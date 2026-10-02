<?php

/**
 * Comments & Ratings Functions
 *
 * - Per-comment star rating (1–5) stored in comment_meta
 * - Aggregate reader rating cached in post_meta
 * - Comment upvote/downvote with server-side IP hash dedup
 * - Honeypot spam protection
 * - GDPR-safe: IP stored only as sha256 hash with secret salt
 */

if (!defined('ABSPATH')) {
    exit;
}

// ---------------------------------------------------------------------------
// Salt helper — uses VOTE_SALT constant (wp-config.php) or auto-generated option
// ---------------------------------------------------------------------------

function fbun_get_vote_salt()
{
    if (defined('VOTE_SALT') && VOTE_SALT !== '') {
        return VOTE_SALT;
    }
    $salt = get_option('fbun_vote_salt');
    if (!$salt) {
        $salt = wp_generate_password(64, true, true);
        add_option('fbun_vote_salt', $salt);
    }
    return $salt;
}

// ---------------------------------------------------------------------------
// Database table creation
// ---------------------------------------------------------------------------

function fbun_create_votes_table()
{
    global $wpdb;
    $table_name      = $wpdb->prefix . 'film_comment_votes';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
        id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        comment_id BIGINT UNSIGNED NOT NULL,
        ip_hash    CHAR(64)        NOT NULL,
        vote       TINYINT(1)      NOT NULL,
        created_at DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY unique_vote (comment_id, ip_hash)
    ) {$charset_collate};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_switch_theme', 'fbun_create_votes_table');

function fbun_maybe_create_votes_table()
{
    if (get_option('fbun_votes_db_version') !== '1.0') {
        fbun_create_votes_table();
        update_option('fbun_votes_db_version', '1.0');
    }
}
add_action('init', 'fbun_maybe_create_votes_table');

function fbun_create_ratings_table()
{
    global $wpdb;
    $table_name      = $wpdb->prefix . 'film_post_ratings';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
        id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        post_id    BIGINT UNSIGNED NOT NULL,
        ip_hash    CHAR(64)        NOT NULL,
        created_at DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY unique_rating (post_id, ip_hash)
    ) {$charset_collate};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_switch_theme', 'fbun_create_ratings_table');

function fbun_maybe_create_ratings_table()
{
    if (get_option('fbun_ratings_db_version') !== '1.0') {
        fbun_create_ratings_table();
        update_option('fbun_ratings_db_version', '1.0');
    }
}
add_action('init', 'fbun_maybe_create_ratings_table');

// ---------------------------------------------------------------------------
// Helper: check if current IP has already rated a post
// ---------------------------------------------------------------------------

function fbun_ip_has_rated($post_id)
{
    if (!$post_id) {
        return false;
    }
    global $wpdb;
    $table   = $wpdb->prefix . 'film_post_ratings';
    $raw_ip  = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
    $ip_hash = hash('sha256', $raw_ip . fbun_get_vote_salt());

    return (bool) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE post_id = %d AND ip_hash = %s",
            $post_id,
            $ip_hash
        )
    );
}

// ---------------------------------------------------------------------------
// Script enqueue — only on single posts
// ---------------------------------------------------------------------------

function fbun_enqueue_comment_scripts()
{
    if (!is_single() || !comments_open()) {
        return;
    }

    // Include the core comment-reply script so reply form moves and IDs are nested
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script(
        'fbun-comments',
        get_template_directory_uri() . '/assets/js/comments.js',
        [],
        '1.1',
        true
    );
    wp_localize_script('fbun-comments', 'FilmBunVote', [
        'nonce'   => wp_create_nonce('film_bun_vote'),
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'i18n'    => [
            'loading'      => 'Se procesează…',
            'alreadyVoted' => 'Ai votat deja',
            'error'        => 'Eroare. Încearcă din nou.',
        ],
    ]);
}
add_action('wp_enqueue_scripts', 'fbun_enqueue_comment_scripts');

// ---------------------------------------------------------------------------
// Star rating field in comment form
// ---------------------------------------------------------------------------

function fbun_add_rating_field($fields)
{
    // Remove website field — irrelevant, attracts spam
    unset($fields['url']);

    // Hide star field if this IP has already rated this post
    if (fbun_ip_has_rated((int) get_the_ID())) {
        return $fields;
    }

    $stars_html = '';
    for ($i = 10; $i >= 1; $i--) {
        $stars_html .= '<input type="radio" name="film_rating" id="fstar' . $i . '" value="' . $i . '">';
        $stars_html .= '<label for="fstar' . $i . '" title="' . $i . '/10">&#9733;</label>';
    }

    $star_field = '<fieldset class="comment-form-rating fbun-star-field">
        <legend class="fbun-star-legend">Nota ta <span class="fbun-star-optional">(opțional)</span></legend>
        <div class="fbun-stars fbun-stars-10" role="radiogroup" aria-label="Selectează nota filmului">
            ' . $stars_html . '
        </div>
    </fieldset>';

    $new_fields = [];
    foreach ($fields as $key => $field) {
        $new_fields[$key] = $field;
        if ($key === 'email') {
            $new_fields['film_rating'] = $star_field;
        }
    }

    return $new_fields;
}
add_filter('comment_form_fields', 'fbun_add_rating_field');

// ---------------------------------------------------------------------------
// Save star rating on comment submit
// ---------------------------------------------------------------------------

function fbun_save_comment_rating($comment_id, $comment_approved)
{
    if (!isset($_POST['film_rating'])) {
        return;
    }
    $rating = intval($_POST['film_rating']);
    if ($rating < 1 || $rating > 10) {
        return;
    }

    // Server-side IP guard — mirrors upvote/downvote dedup logic
    $comment = get_comment($comment_id);
    $post_id = $comment ? (int) $comment->comment_post_ID : 0;
    if (!$post_id || fbun_ip_has_rated($post_id)) {
        return; // already rated from this IP — silently skip
    }

    add_comment_meta($comment_id, 'film_rating', $rating, true);

    // Record IP hash so this IP cannot rate again
    global $wpdb;
    $raw_ip  = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
    $ip_hash = hash('sha256', $raw_ip . fbun_get_vote_salt());
    $wpdb->insert(
        $wpdb->prefix . 'film_post_ratings',
        [
            'post_id'    => $post_id,
            'ip_hash'    => $ip_hash,
            'created_at' => current_time('mysql', true),
        ],
        ['%d', '%s', '%s']
    );
}
add_action('comment_post', 'fbun_save_comment_rating', 10, 2);

// ---------------------------------------------------------------------------
// Recalculate aggregate rating on comment status change
// ---------------------------------------------------------------------------

function fbun_recalculate_film_rating($comment_or_id, $args = null)
{
    if ($comment_or_id instanceof WP_Comment) {
        $post_id = (int) $comment_or_id->comment_post_ID;
    } else {
        $comment_id = (int) $comment_or_id;
        $comment    = get_comment($comment_id);
        if (!$comment) {
            return;
        }
        $post_id = (int) $comment->comment_post_ID;
    }

    if (!$post_id) {
        return;
    }

    $comments = get_comments([
        'post_id'    => $post_id,
        'status'     => 'approve',
        'meta_query' => [
            [
                'key'     => 'film_rating',
                'compare' => 'EXISTS',
            ],
        ],
    ]);

    if (empty($comments)) {
        delete_post_meta($post_id, 'user_avg_rating');
        delete_post_meta($post_id, 'user_rating_count');
        return;
    }

    $sum   = 0;
    $count = 0;
    foreach ($comments as $c) {
        $val = (int) get_comment_meta($c->comment_ID, 'film_rating', true);
        if ($val >= 1 && $val <= 10) {
            $sum += $val;
            $count++;
        }
    }

    if ($count > 0) {
        update_post_meta($post_id, 'user_avg_rating', round($sum / $count, 1));
        update_post_meta($post_id, 'user_rating_count', $count);
    } else {
        delete_post_meta($post_id, 'user_avg_rating');
        delete_post_meta($post_id, 'user_rating_count');
    }
}

add_action('comment_approved_to_approved', 'fbun_recalculate_film_rating', 10, 2);
add_action('wp_set_comment_status',        'fbun_recalculate_film_rating', 10, 2);
add_action('deleted_comment',              'fbun_recalculate_film_rating', 10, 2);
add_action('trashed_comment',              'fbun_recalculate_film_rating', 10, 2);
add_action('spammed_comment',              'fbun_recalculate_film_rating', 10, 2);

// ---------------------------------------------------------------------------
// Honeypot spam protection
// ---------------------------------------------------------------------------

function fbun_add_honeypot_field()
{
    // Hidden via CSS — bots fill it, humans don't
    echo '<p class="fbun-hp-field" aria-hidden="true">
        <label for="fbun_hp">Nu completa acest câmp</label>
        <input type="text" name="fbun_hp" id="fbun_hp" tabindex="-1" autocomplete="off" value="">
    </p>';
}
add_action('comment_form', 'fbun_add_honeypot_field');

function fbun_check_honeypot()
{
    if (!empty($_POST['fbun_hp'])) {
        wp_die(
            'Comentariul tău a fost blocat.',
            'Blocat',
            ['response' => 403, 'back_link' => true]
        );
    }
}
add_action('pre_comment_on_post', 'fbun_check_honeypot');

// ---------------------------------------------------------------------------
// AJAX vote handler
// ---------------------------------------------------------------------------

function fbun_handle_vote()
{
    // 1. CSRF check — dies with 403 if nonce is invalid
    check_ajax_referer('film_bun_vote', 'nonce');

    // 2. Validate comment_id
    $comment_id = absint($_POST['comment_id'] ?? 0);
    if (!$comment_id) {
        wp_send_json_error(['message' => 'ID invalid', 'code' => 'invalid_id'], 400);
    }

    // 3. Validate vote type — strict whitelist
    $vote_type = sanitize_key($_POST['vote'] ?? '');
    if (!in_array($vote_type, ['up', 'down'], true)) {
        wp_send_json_error(['message' => 'Tip de vot invalid', 'code' => 'invalid_type'], 400);
    }
    $vote_int = $vote_type === 'up' ? 1 : -1;

    // 4. Hash IP — never store raw IP
    $raw_ip  = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
    $ip_hash = hash('sha256', $raw_ip . fbun_get_vote_salt());

    // 5. Rate limit — max 20 votes per IP per hour
    $rate_key = 'fbun_rate_' . substr($ip_hash, 0, 24);
    $rate     = (int) get_transient($rate_key);
    if ($rate >= 20) {
        wp_send_json_error(
            ['message' => 'Prea multe cereri. Încearcă mai târziu.', 'code' => 'rate_limit'],
            429
        );
    }

    // 6. Verify comment exists and is approved
    $comment = get_comment($comment_id);
    if (!$comment || $comment->comment_approved !== '1') {
        wp_send_json_error(['message' => 'Comentariu negăsit', 'code' => 'not_found'], 404);
    }

    // 6b. Prevent voting on own comment — compare hashed commenter IP with voter IP
    $commenter_ip_hash = hash('sha256', $comment->comment_author_IP . fbun_get_vote_salt());
    if ($commenter_ip_hash === $ip_hash) {
        wp_send_json_error(
            ['message' => 'Nu îți poți vota propriul comentariu', 'code' => 'own_comment'],
            403
        );
    }

    global $wpdb;
    $table = $wpdb->prefix . 'film_comment_votes';

    // 7. Check existing vote
    $existing = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT vote FROM {$table} WHERE comment_id = %d AND ip_hash = %s",
            $comment_id,
            $ip_hash
        )
    );

    if ($existing !== null && (int) $existing === $vote_int) {
        // Same vote direction — already voted
        wp_send_json_error(['message' => 'Ai votat deja', 'code' => 'already_voted'], 409);
    }

    // 8. Insert or update vote (atomic — DB UNIQUE KEY prevents race conditions)
    $result = $wpdb->query(
        $wpdb->prepare(
            "INSERT INTO {$table} (comment_id, ip_hash, vote)
             VALUES (%d, %s, %d)
             ON DUPLICATE KEY UPDATE vote = VALUES(vote)",
            $comment_id,
            $ip_hash,
            $vote_int
        )
    );

    if ($result === false) {
        wp_send_json_error(['message' => 'Eroare server', 'code' => 'db_error'], 500);
    }

    // 9. Increment rate limit counter
    set_transient($rate_key, $rate + 1, HOUR_IN_SECONDS);

    // 10. Recalculate counts from votes table (source of truth)
    $counts = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT
                SUM(CASE WHEN vote = 1  THEN 1 ELSE 0 END) AS up,
                SUM(CASE WHEN vote = -1 THEN 1 ELSE 0 END) AS down
             FROM {$table}
             WHERE comment_id = %d",
            $comment_id
        )
    );
    $new_up   = (int) ($counts->up   ?? 0);
    $new_down = (int) ($counts->down ?? 0);

    // 11. Cache counts in comment_meta for display without hitting votes table on every render
    update_comment_meta($comment_id, 'vote_up',   $new_up);
    update_comment_meta($comment_id, 'vote_down', $new_down);

    wp_send_json_success([
        'up'        => $new_up,
        'down'      => $new_down,
        'voted'     => $vote_type,
        'was_switch' => $existing !== null,
        'message'   => 'Vot înregistrat',
    ]);
}
add_action('wp_ajax_vote_comment',        'fbun_handle_vote');
add_action('wp_ajax_nopriv_vote_comment', 'fbun_handle_vote');

// ---------------------------------------------------------------------------
// Batch recalculate all post ratings (run after cache clear or 5→10 migration)
// ---------------------------------------------------------------------------

function fbun_recalculate_all_ratings()
{
    global $wpdb;

    // Get all post IDs that have at least one approved comment with a film_rating
    $post_ids = $wpdb->get_col(
        "SELECT DISTINCT c.comment_post_ID
         FROM {$wpdb->comments} c
         INNER JOIN {$wpdb->commentmeta} cm ON cm.comment_id = c.comment_ID
         WHERE c.comment_approved = '1'
           AND cm.meta_key = 'film_rating'"
    );

    if (empty($post_ids)) {
        return 0;
    }

    $updated = 0;
    foreach ($post_ids as $post_id) {
        $comments = get_comments([
            'post_id'    => (int) $post_id,
            'status'     => 'approve',
            'meta_query' => [['key' => 'film_rating', 'compare' => 'EXISTS']],
        ]);

        $sum = 0; $count = 0;
        foreach ($comments as $c) {
            $val = (int) get_comment_meta($c->comment_ID, 'film_rating', true);
            if ($val >= 1 && $val <= 10) {
                $sum += $val;
                $count++;
            }
        }

        if ($count > 0) {
            update_post_meta((int) $post_id, 'user_avg_rating', round($sum / $count, 1));
            update_post_meta((int) $post_id, 'user_rating_count', $count);
            $updated++;
        }
    }

    return $updated;
}

// WP-CLI: wp eval "echo fbun_recalculate_all_ratings();"
// Admin URL trigger (admin only, one-time): ?fbun_recalc_ratings=1
add_action('admin_init', function () {
    if (!isset($_GET['fbun_recalc_ratings']) || !current_user_can('manage_options')) {
        return;
    }
    $n = fbun_recalculate_all_ratings();
    wp_die("Recalculated ratings for {$n} posts.", 'Done', ['response' => 200]);
});

// ---------------------------------------------------------------------------
// Data retention — purge votes older than 12 months (GDPR)
// ---------------------------------------------------------------------------

function fbun_purge_old_votes()
{
    global $wpdb;
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->prefix}film_comment_votes WHERE created_at < %s",
            gmdate('Y-m-d H:i:s', strtotime('-12 months'))
        )
    );
}
add_action('fbun_purge_old_votes', 'fbun_purge_old_votes');

// Register 'monthly' cron interval (WP only has hourly, twicedaily, daily, weekly built-in)
add_filter('cron_schedules', function ($schedules) {
    if (!isset($schedules['monthly'])) {
        $schedules['monthly'] = [
            'interval' => 30 * DAY_IN_SECONDS,
            'display'  => 'Once Monthly',
        ];
    }
    return $schedules;
});

function fbun_schedule_vote_purge()
{
    if (!wp_next_scheduled('fbun_purge_old_votes')) {
        wp_schedule_event(time(), 'monthly', 'fbun_purge_old_votes');
    }
}
add_action('wp', 'fbun_schedule_vote_purge');

// ---------------------------------------------------------------------------
// Helper: render star icons for display (not the form selector)
// ---------------------------------------------------------------------------

function fbun_render_star_badge($rating, $max = 10)
{
    $rating = (int) $rating;
    if ($rating < 1 || $rating > $max) {
        return '';
    }
    $stars = '';
    for ($i = 1; $i <= $max; $i++) {
        $filled = $i <= $rating ? 'fbun-star-filled' : 'fbun-star-empty';
        $stars .= '<span class="fbun-star ' . esc_attr($filled) . '" aria-hidden="true">&#9733;</span>';
    }
    return '<span class="fbun-star-badge" aria-label="' . esc_attr($rating . ' din ' . $max . ' stele') . '">'
        . $stars
        . '</span>';
}

// ---------------------------------------------------------------------------
// Custom comment render callback
// ---------------------------------------------------------------------------

function fbun_render_comment($comment, $args, $depth)
{
    $star_rating = (int) get_comment_meta($comment->comment_ID, 'film_rating', true);
    $vote_up     = (int) get_comment_meta($comment->comment_ID, 'vote_up',     true);
    $vote_down   = (int) get_comment_meta($comment->comment_ID, 'vote_down',   true);

    // Letter avatar fallback
    $author_name  = get_comment_author($comment);
    $first_letter = mb_strtoupper(mb_substr($author_name, 0, 1), 'UTF-8');
    $avatar_colors = ['#0e7490', '#0891b2', '#0284c7', '#6d28d9', '#7c3aed', '#be185d'];
    $color_index   = abs(crc32($author_name)) % count($avatar_colors);
    $avatar_color  = $avatar_colors[$color_index];

    $gravatar = get_avatar($comment, 48, '', '', ['class' => 'fbun-avatar-img']);
    ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class('fbun-comment-item', $comment); ?>>
        <article class="fbun-comment-card">
            <header class="fbun-comment-header">
                <div class="fbun-avatar" style="background-color: <?php echo esc_attr($avatar_color); ?>;" aria-hidden="true">
                    <?php if ($gravatar && strpos($gravatar, 'gravatar.com/avatar') !== false && strpos($gravatar, 'd=mm') === false) : ?>
                        <?php echo $gravatar; ?>
                    <?php else : ?>
                        <span class="fbun-avatar-letter"><?php echo esc_html($first_letter); ?></span>
                    <?php endif; ?>
                </div>
                <div class="fbun-comment-meta">
                    <span class="fbun-comment-author"><?php echo esc_html($author_name); ?></span>
                    <time class="fbun-comment-date" datetime="<?php echo esc_attr(get_comment_date('c', $comment)); ?>">
                        <?php echo esc_html(get_comment_date('j F Y', $comment)); ?>
                    </time>
                </div>
                <?php if ($star_rating >= 1 && $star_rating <= 10) : ?>
                    <div class="fbun-comment-rating" aria-label="<?php echo esc_attr($star_rating . ' din 10 stele'); ?>">
                        <?php echo fbun_render_star_badge($star_rating); ?>
                        <span class="fbun-comment-rating-num"><?php echo esc_html($star_rating); ?>/10</span>
                    </div>
                <?php endif; ?>
            </header>

            <?php if ('0' === $comment->comment_approved) : ?>
                <p class="fbun-comment-pending">Comentariul tău este în așteptare și va apărea după moderare.</p>
            <?php endif; ?>

            <div class="fbun-comment-body">
                <?php comment_text($comment); ?>
            </div>

            <footer class="fbun-comment-footer">
                <div class="fbun-vote-bar" role="group" aria-label="Votează comentariul">
                    <button
                        class="fbun-vote-btn fbun-vote-up"
                        data-comment-id="<?php echo esc_attr($comment->comment_ID); ?>"
                        data-vote="up"
                        aria-label="Util (<?php echo esc_attr($vote_up); ?> voturi)"
                        type="button">
                        <svg class="fbun-vote-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M1 8.25a1.25 1.25 0 112.5 0v7.5a1.25 1.25 0 01-2.5 0v-7.5zM11 3V1.7c0-.268.14-.526.395-.607A2 2 0 0114 3c0 .995-.182 1.948-.514 2.826-.204.536.166 1.174.744 1.174h2.52c1.243 0 2.261 1.01 2.146 2.247a23.864 23.864 0 01-1.341 5.974C17.153 16.323 16.058 17 14.9 17h-3.192a3 3 0 01-1.341-.317l-2.734-1.366A3 3 0 006.292 15H5V8h.963c.685 0 1.258-.483 1.612-1.068a4.011 4.011 0 012.166-1.73c.432-.143.853-.386 1.011-.78A6.467 6.467 0 0111 3z"/>
                        </svg>
                        <span class="fbun-vote-count"><?php echo esc_html($vote_up); ?></span>
                    </button>
                    <button
                        class="fbun-vote-btn fbun-vote-down"
                        data-comment-id="<?php echo esc_attr($comment->comment_ID); ?>"
                        data-vote="down"
                        aria-label="Neutil (<?php echo esc_attr($vote_down); ?> voturi)"
                        type="button">
                        <svg class="fbun-vote-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M18.905 12.75a1.25 1.25 0 01-2.5 0v-7.5a1.25 1.25 0 012.5 0v7.5zM8.905 17v1.3c0 .268-.14.526-.395.607A2 2 0 015.905 17c0-.995.182-1.948.514-2.826.204-.536-.166-1.174-.744-1.174h-2.52c-1.243 0-2.261-1.01-2.146-2.247.193-2.08.652-4.082 1.341-5.974C2.752 3.678 3.847 3 5.005 3h3.192a3 3 0 011.341.317l2.734 1.366A3 3 0 0013.613 5h1.292v7h-.963c-.685 0-1.258.483-1.612 1.068a4.01 4.01 0 01-2.166 1.73c-.432.143-.853.386-1.011.78A6.467 6.467 0 008.905 17z"/>
                        </svg>
                        <span class="fbun-vote-count"><?php echo esc_html($vote_down); ?></span>
                    </button>
                </div>

                <?php
                comment_reply_link(array_merge($args, [
                    'add_below' => 'comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'] ?? 2,
                    'before'    => '<span class="fbun-reply-link">',
                    'after'     => '</span>',
                ]));
                ?>
            </footer>
        </article>
    <?php
    // Note: closing </li> is added by wp_list_comments() walker
}
