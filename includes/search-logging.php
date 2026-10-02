<?php
/**
 * Search query logging — daily aggregate, GDPR-safe.
 *
 * Records what visitors search for in wp_film_search_log, one row per
 * (normalized query, day) with a hit counter. Stores no IP / user ID — the
 * only IP touch is a salted hash held ~10 min in a transient for dedup.
 */

if (!defined('ABSPATH')) {
    exit;
}

// ---------------------------------------------------------------------------
// Table (mirrors the dbDelta pattern in comments-functions.php)
// ---------------------------------------------------------------------------

function fbun_create_search_log_table()
{
    global $wpdb;
    $table_name      = $wpdb->prefix . 'film_search_log';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
        id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        query_norm    VARCHAR(191)    NOT NULL,
        query_raw     VARCHAR(255)    NOT NULL,
        day           DATE            NOT NULL,
        hits          INT UNSIGNED    NOT NULL DEFAULT 1,
        zero_results  TINYINT(1)      NOT NULL DEFAULT 0,
        results_count INT UNSIGNED    NOT NULL DEFAULT 0,
        PRIMARY KEY (id),
        UNIQUE KEY unique_query_day (query_norm, day),
        KEY day_idx (day)
    ) {$charset_collate};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_switch_theme', 'fbun_create_search_log_table');

function fbun_maybe_create_search_log_table()
{
    if (get_option('fbun_search_log_db_version') !== '1.0') {
        fbun_create_search_log_table();
        update_option('fbun_search_log_db_version', '1.0');
    }
}
add_action('init', 'fbun_maybe_create_search_log_table');

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------

function fbun_normalize_search_query($raw)
{
    $norm = trim((string) $raw);
    $norm = preg_replace('/\s+/u', ' ', $norm);
    return function_exists('mb_strtolower') ? mb_strtolower($norm, 'UTF-8') : strtolower($norm);
}

function fbun_search_is_bot($ua)
{
    $ua = strtolower((string) $ua);
    if ($ua === '') {
        return true; // missing UA → treat as bot
    }
    foreach (['bot', 'crawl', 'spider', 'slurp', 'bingpreview', 'facebookexternalhit', 'embedly', 'read-aloud', 'mediapartners', 'inspectiontool', 'admantx'] as $needle) {
        if (strpos($ua, $needle) !== false) {
            return true;
        }
    }
    return false;
}

// ---------------------------------------------------------------------------
// Capture: one upsert per qualifying search, on the results page (page 1)
// ---------------------------------------------------------------------------

function fbun_log_search_query()
{
    global $wp_query;
    if (is_admin() || !is_search() || !$wp_query->is_main_query() || is_paged()) {
        return;
    }
    if (current_user_can('edit_posts')) {
        return; // don't log staff testing
    }
    if (fbun_search_is_bot($_SERVER['HTTP_USER_AGENT'] ?? '')) {
        return;
    }

    $raw  = get_search_query();
    $norm = fbun_normalize_search_query($raw);
    if (mb_strlen($norm) < 2) {
        return;
    }

    // Dedup: same visitor+query within 10 min counts once. IP never stored.
    $raw_ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
    $key    = 'fbun_srch_' . hash('sha256', $raw_ip . '|' . $norm . fbun_get_vote_salt());
    if (get_transient($key)) {
        return;
    }
    set_transient($key, 1, 10 * MINUTE_IN_SECONDS);

    global $wpdb;
    // Count movies (main query) + news (stiri). search.php renders both, so a
    // query that matches a news article but no movie is NOT a true "no results".
    $results_count = (int) $wp_query->found_posts;
    $news = new WP_Query([
        'post_type'      => 'stiri',
        'post_status'    => 'publish',
        's'              => $raw,
        'fields'         => 'ids',
        'posts_per_page' => 1,
    ]);
    $results_count += (int) $news->found_posts;
    $zero          = $results_count === 0 ? 1 : 0;
    $table         = $wpdb->prefix . 'film_search_log';
    $day           = current_time('Y-m-d');
    $norm          = mb_substr($norm, 0, 191);
    $raw           = mb_substr((string) $raw, 0, 255);

    $wpdb->query(
        $wpdb->prepare(
            "INSERT INTO {$table} (query_norm, query_raw, day, hits, zero_results, results_count)
             VALUES (%s, %s, %s, 1, %d, %d)
             ON DUPLICATE KEY UPDATE hits = hits + 1,
                 zero_results = VALUES(zero_results), results_count = VALUES(results_count)",
            $norm,
            $raw,
            $day,
            $zero,
            $results_count
        )
    );
}
add_action('template_redirect', 'fbun_log_search_query');

// ---------------------------------------------------------------------------
// REST: read aggregated stats (admin-authenticated, read-only)
// ---------------------------------------------------------------------------

add_action('rest_api_init', function () {
    register_rest_route('film-bun/v1', '/search-stats', [
        'methods'             => 'GET',
        'callback'            => 'fbun_search_stats_endpoint',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        },
    ]);
});

function fbun_search_stats_endpoint($request)
{
    // Never let a page cache store this response. LiteSpeed's cache key ignores
    // the Authorization header, so a cached 200 would be (a) stale and (b) served
    // to unauthenticated callers — bypassing the edit_posts gate. Mark no-cache.
    do_action('litespeed_control_set_nocache', 'film-bun search-stats: auth-gated live data');
    nocache_headers();

    global $wpdb;
    $table = $wpdb->prefix . 'film_search_log';

    $view  = in_array($request['view'], ['top', 'gaps', 'daily'], true) ? $request['view'] : 'top';
    $limit = min(500, max(1, (int) ($request['limit'] ?: 50)));
    $to    = preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $request['to'])   ? $request['to']   : current_time('Y-m-d');
    $from  = preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $request['from']) ? $request['from'] : '2000-01-01';

    $totals = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT COALESCE(SUM(hits),0) AS total_searches, COUNT(DISTINCT query_norm) AS distinct_queries
             FROM {$table} WHERE day BETWEEN %s AND %s",
            $from,
            $to
        ),
        ARRAY_A
    );

    if ($view === 'daily') {
        $rows = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT day, SUM(hits) AS hits, SUM(zero_results) AS zero_queries
                 FROM {$table} WHERE day BETWEEN %s AND %s
                 GROUP BY day ORDER BY day ASC",
                $from,
                $to
            ),
            ARRAY_A
        );
    } else {
        // zero_results/results_count must reflect the LATEST day in the window,
        // not MAX over it — else a movie added mid-period keeps showing as a
        // "gap" because of its pre-publish zero-days. Latest day first via
        // GROUP_CONCAT ORDER BY day DESC, then SUBSTRING_INDEX picks it.
        $latest_zero    = "CAST(SUBSTRING_INDEX(GROUP_CONCAT(zero_results ORDER BY day DESC), ',', 1) AS UNSIGNED)";
        $latest_results = "CAST(SUBSTRING_INDEX(GROUP_CONCAT(results_count ORDER BY day DESC), ',', 1) AS UNSIGNED)";
        $having = $view === 'gaps' ? "HAVING {$latest_zero} = 1" : '';
        $rows = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT query_norm, MAX(query_raw) AS query_raw, SUM(hits) AS hits,
                        {$latest_zero} AS zero_results, {$latest_results} AS results_count
                 FROM {$table} WHERE day BETWEEN %s AND %s
                 GROUP BY query_norm {$having}
                 ORDER BY hits DESC LIMIT %d",
                $from,
                $to,
                $limit
            ),
            ARRAY_A
        );
    }

    return rest_ensure_response([
        'view'             => $view,
        'from'             => $from,
        'to'               => $to,
        'total_searches'   => (int) $totals['total_searches'],
        'distinct_queries' => (int) $totals['distinct_queries'],
        'rows'             => $rows ?: [],
    ]);
}
