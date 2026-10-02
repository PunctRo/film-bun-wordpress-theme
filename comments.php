<?php
/**
 * Comments Template
 *
 * Dark-themed comment list and form.
 * Called via comments_template() in single-content.php.
 */

if (!defined('ABSPATH')) {
    exit;
}

if (post_password_required()) {
    echo '<p class="fbun-comments-locked">Articolul este protejat cu parolă. Introduceți parola pentru a vedea comentariile.</p>';
    return;
}

$post_id      = get_the_ID();
$comment_count = (int) get_comments_number();
$avg_rating   = (float) get_post_meta($post_id, 'user_avg_rating', true);
$rating_count = (int)   get_post_meta($post_id, 'user_rating_count', true);
?>

<div class="fbun-comments-wrap" id="comentarii">

    <?php /* ---- Aggregate reader rating ---- */ ?>
    <?php if ($avg_rating > 0 && $rating_count > 0) : ?>
    <div class="fbun-reader-rating">
        <div class="fbun-reader-rating-stars" aria-hidden="true">
            <?php for ($i = 1; $i <= 10; $i++) : ?>
                <span class="fbun-rr-star <?php echo $i <= round($avg_rating) ? 'filled' : ''; ?>">&#9733;</span>
            <?php endfor; ?>
        </div>
        <div class="fbun-reader-rating-info">
            <span class="fbun-reader-rating-avg"><?php echo esc_html(number_format($avg_rating, 1, ',', '')); ?></span>
            <span class="fbun-reader-rating-label">/ 10 &mdash;
                <strong><?php echo esc_html($rating_count); ?></strong>
                <?php echo esc_html($rating_count === 1 ? 'cititor a votat' : 'cititori au votat'); ?>
            </span>
        </div>
    </div>
    <?php endif; ?>

    <?php /* ---- Comment list ---- */ ?>
    <?php if (have_comments()) : ?>
    <section class="fbun-comments-section">
        <div class="fbun-comments-heading">
            <h2 class="fbun-comments-title">
                Comentarii
                <span class="fbun-comments-count">(<?php echo esc_html($comment_count); ?>)</span>
            </h2>
            <div class="fbun-heading-line"></div>
        </div>

        <ol class="fbun-commentlist">
            <?php
            wp_list_comments([
                'callback'    => 'fbun_render_comment',
                'style'       => 'ol',
                'type'        => 'comment',
                'avatar_size' => 48,
                'max_depth'   => 2,
            ]);
            ?>
        </ol>

        <?php
        the_comments_pagination([
            'prev_text' => '&larr; Mai vechi',
            'next_text' => 'Mai noi &rarr;',
            'class'     => 'fbun-comments-pagination',
        ]);
        ?>
    </section>
    <?php endif; ?>

    <?php /* ---- Comment form ---- */ ?>
    <?php if (comments_open()) : ?>
    <section class="fbun-comment-form-section">
        <div class="fbun-comments-heading">
            <h2 class="fbun-comments-title">
                <?php echo have_comments() ? 'Lasă un comentariu' : 'Fii primul care comentează'; ?>
            </h2>
            <div class="fbun-heading-line"></div>
        </div>

        <?php
        comment_form([
            'id_form'              => 'fbun-commentform',
            'class_form'           => 'fbun-form',
            'title_reply'          => '',
            'title_reply_before'   => '',
            'title_reply_after'    => '',
            'must_log_in'          => '',
            'logged_in_as'         => '',
            'comment_notes_before' => '',
            'comment_notes_after'  => '',
            'label_submit'         => 'Trimite comentariul',
            'class_submit'         => 'fbun-submit-btn',
            'id_submit'            => 'fbun-submit',
            'comment_field'        => '<p class="comment-form-comment fbun-field-group">
                <label for="comment" class="fbun-label">Comentariul tău <span class="required" aria-hidden="true">*</span></label>
                <textarea id="comment" name="comment" class="fbun-textarea" rows="6" required aria-required="true" placeholder="Scrie ce ai gândit despre film…"></textarea>
            </p>',
            'fields'               => [
                'author' => '<p class="comment-form-author fbun-field-group">
                    <label for="author" class="fbun-label">Numele tău <span class="required" aria-hidden="true">*</span></label>
                    <input id="author" name="author" type="text" class="fbun-input" required aria-required="true"
                        value="' . esc_attr(wp_get_current_commenter()['comment_author']) . '"
                        placeholder="Ion Popescu" autocomplete="name">
                </p>',
                'email'  => '<p class="comment-form-email fbun-field-group">
                    <label for="email" class="fbun-label">Email <span class="required" aria-hidden="true">*</span></label>
                    <input id="email" name="email" type="email" class="fbun-input" required aria-required="true"
                        value="' . esc_attr(wp_get_current_commenter()['comment_author_email']) . '"
                        placeholder="email@exemplu.ro" autocomplete="email">
                    <span class="fbun-field-note">Nu va fi publicat.</span>
                </p>',
            ],
        ]);
        ?>
    </section>
    <?php else : ?>
    <p class="fbun-comments-closed">Comentariile sunt dezactivate pentru acest articol.</p>
    <?php endif; ?>

</div><?php // .fbun-comments-wrap ?>
