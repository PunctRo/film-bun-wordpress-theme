<?php

/**
 * Affiliate link management and display functions
 */

/**
 * Affiliate redirect system
 * Handles /recomanda/{slug} URLs and redirects to affiliate destinations
 */
function handle_affiliate_redirects()
{
    $affiliates = [
        'nordvpn'    => 'https://nordvpn.sjv.io/4eO7X1',
        'libris'     => 'https://event.2performant.com/events/click?ad_type=quicklink&aff_code=5c6450bfb&unique=9a6f02fef&redirect_to=https%253A//www.libris.ro',
        'emag'       => 'https://l.profitshare.ro/l/15420507',
        'carturesti' => 'https://event.2performant.com/events/click?ad_type=quicklink&aff_code=5c6450bfb&unique=07b5f0fed&redirect_to=https%253A//carturesti.ro',
        'popcorn'    => 'https://l.profitshare.ro/l/16151202',
    ];

    $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    if ($path !== 'recomanda' && strpos($path, 'recomanda/') !== 0) {
        return;
    }

    // Nothing under /recomanda/ belongs in a search index: not the redirects,
    // not the 404s served for retired or malformed slugs. robots.txt blocks
    // only the known slugs, so anything else here must say noindex itself.
    header('X-Robots-Tag: noindex, nofollow', true);

    if (preg_match('#^recomanda/([a-z0-9-]+)$#', $path, $m) && isset($affiliates[$m[1]])) {
        // 302, not 301: browsers cache 301s indefinitely, so a slug whose
        // destination changes would keep sending returning visitors to the
        // old target. Must also stay out of the page cache — a cached
        // redirect would bypass the click counter below.
        do_action('litespeed_control_set_nocache', 'affiliate redirect: click counting');
        nocache_headers();
        fbun_log_affiliate_click($m[1]);
        wp_redirect($affiliates[$m[1]], 302);
        exit;
    }
}
add_action('template_redirect', 'handle_affiliate_redirects');

/**
 * Affiliate click logging — daily aggregate per slug, GDPR-safe (no IP/UA stored).
 * Lets us compare real clicks against the affiliate network's reported clicks
 * (adblockers eat the l.profitshare.ro redirect, so network numbers undercount).
 */

function fbun_create_affiliate_click_table()
{
    global $wpdb;
    $table_name      = $wpdb->prefix . 'film_affiliate_click_log';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
        id     BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        slug   VARCHAR(64)     NOT NULL,
        day    DATE            NOT NULL,
        clicks INT UNSIGNED    NOT NULL DEFAULT 1,
        PRIMARY KEY (id),
        UNIQUE KEY unique_slug_day (slug, day),
        KEY day_idx (day)
    ) {$charset_collate};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
add_action('after_switch_theme', 'fbun_create_affiliate_click_table');

function fbun_maybe_create_affiliate_click_table()
{
    if (get_option('fbun_affiliate_click_db_version') !== '1.0') {
        fbun_create_affiliate_click_table();
        update_option('fbun_affiliate_click_db_version', '1.0');
    }
}
add_action('init', 'fbun_maybe_create_affiliate_click_table');

function fbun_log_affiliate_click($slug)
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
        return; // HEAD/OPTIONS: link checkers, uptime monitors
    }
    // Speculative prefetches are browser guesses, not clicks. Chrome sends
    // Sec-Purpose, Safari Purpose, Firefox X-Moz.
    $purpose = ($_SERVER['HTTP_SEC_PURPOSE'] ?? '') . ($_SERVER['HTTP_PURPOSE'] ?? '') . ($_SERVER['HTTP_X_MOZ'] ?? '');
    if (stripos($purpose, 'prefetch') !== false || stripos($purpose, 'prerender') !== false) {
        return;
    }
    if (function_exists('fbun_search_is_bot') && fbun_search_is_bot($_SERVER['HTTP_USER_AGENT'] ?? '')) {
        return;
    }
    if (current_user_can('edit_posts')) {
        return; // don't count staff testing
    }

    global $wpdb;
    $table = $wpdb->prefix . 'film_affiliate_click_log';
    $wpdb->query(
        $wpdb->prepare(
            "INSERT INTO {$table} (slug, day, clicks) VALUES (%s, %s, 1)
             ON DUPLICATE KEY UPDATE clicks = clicks + 1",
            mb_substr((string) $slug, 0, 64),
            current_time('Y-m-d')
        )
    );
}

add_action('rest_api_init', function () {
    register_rest_route('film-bun/v1', '/affiliate-stats', [
        'methods'             => 'GET',
        'callback'            => 'fbun_affiliate_stats_endpoint',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        },
    ]);
});

function fbun_affiliate_stats_endpoint($request)
{
    // Same caveat as search-stats: LiteSpeed's cache key ignores Authorization,
    // so a cached 200 would leak auth-gated data. Mark no-cache.
    do_action('litespeed_control_set_nocache', 'film-bun affiliate-stats: auth-gated live data');
    nocache_headers();

    global $wpdb;
    $table = $wpdb->prefix . 'film_affiliate_click_log';
    $to    = preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $request['to'])   ? $request['to']   : current_time('Y-m-d');
    $from  = preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $request['from']) ? $request['from'] : '2000-01-01';

    $rows = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT slug, day, clicks FROM {$table}
             WHERE day BETWEEN %s AND %s
             ORDER BY day DESC, clicks DESC",
            $from,
            $to
        ),
        ARRAY_A
    );

    $totals = [];
    foreach ($rows ?: [] as $r) {
        $totals[$r['slug']] = ($totals[$r['slug']] ?? 0) + (int) $r['clicks'];
    }

    return rest_ensure_response([
        'from'   => $from,
        'to'     => $to,
        'totals' => $totals,
        'rows'   => $rows ?: [],
    ]);
}

/**
 * Get affiliate link URL by slug
 *
 * Every anchor pointing here carries the `no-prefetch` class, which core's
 * speculation rules exclude by selector. Conservative eagerness prefetches on
 * pointerdown/touchstart, so mobile users touching a banner to scroll fire
 * phantom requests that inflate the click counter (123 counted vs 7 real on
 * launch day). Excluding by class instead of by href path keeps the string
 * "/recomanda/*" out of the speculation-rules JSON — Googlebot harvested it
 * from there as a literal URL and indexed it.
 */
function get_affiliate_link($slug)
{
    $base_url = home_url('/recomanda/' . $slug);
    return $base_url;
}

/**
 * Render NordVPN banner for single movie pages (after description)
 */
function render_nordvpn_movie_banner()
{
    $link = get_affiliate_link('nordvpn');
    ?>
    <div class="max-w-4xl mx-auto mt-4">
        <a href="<?php echo esc_url($link); ?>"
           target="_blank"
           rel="sponsored noopener"
           class="no-prefetch group block bg-gradient-to-r from-[#1a1a2e] via-[#16213e] to-[#0f3460] rounded-xl px-6 py-2 border border-blue-500/20 hover:border-blue-400/40 transition-all duration-300 hover:shadow-[0_0_25px_rgba(59,130,246,0.15)] no-underline">
            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-5">
                <div class="flex-shrink-0 w-11 h-11 rounded-full bg-blue-500/20 flex items-center justify-center group-hover:bg-blue-500/30 transition-colors">
                    <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-white font-semibold text-sm sm:text-base mb-1">Streaming securizat cu NordVPN</p>
                    <p class="text-gray-400 text-xs sm:text-sm m-0">Protejează-ți confidențialitatea online când vizionezi filme – rapid, sigur, fără griji.</p>
                </div>
                <div class="flex-shrink-0 mt-1 sm:mt-0">
                    <span class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-blue-500/20 group-hover:bg-blue-500/30 text-blue-300 group-hover:text-blue-200 text-xs sm:text-sm font-semibold rounded-full transition-all duration-300">
                        Încearcă NordVPN
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </div>
            </div>
        </a>
    </div>
    <?php
}

/**
 * Render NordVPN inline callout for streaming section
 */
function render_nordvpn_streaming_callout()
{
    $link = get_affiliate_link('nordvpn');
    ?>
    <div class="mt-4 pt-4 border-t border-cyan-400/10">
        <a href="<?php echo esc_url($link); ?>"
           target="_blank"
           rel="sponsored noopener"
           class="no-prefetch group flex items-center gap-3 p-3 rounded-lg bg-blue-500/5 hover:bg-blue-500/10 border border-blue-500/10 hover:border-blue-400/25 transition-all duration-300 no-underline">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-500/15 flex items-center justify-center group-hover:bg-blue-500/25 transition-colors">
                <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-gray-200 text-xs sm:text-sm font-medium m-0">🔒 Streaming în siguranță cu <strong class="text-blue-300">NordVPN</strong></p>
            </div>
            <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-400 transform group-hover:translate-x-0.5 transition-all flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </a>
    </div>
    <?php
}

/**
 * Render Libris.ro book callout for movies tagged as 'ecranizare'
 * Shown on single movie pages when the movie is based on a literary source.
 */
function render_libris_book_callout()
{
    if (!has_tag('ecranizare')) {
        return;
    }

    $link = get_affiliate_link('libris');
    ?>
    <div class="max-w-4xl mx-auto mt-4">
        <a href="<?php echo esc_url($link); ?>"
           target="_blank"
           rel="sponsored noopener"
           class="no-prefetch group block bg-gradient-to-r from-[#2a1a0e] via-[#3a2415] to-[#1e1510] rounded-xl px-6 py-2 border border-amber-500/20 hover:border-amber-400/40 transition-all duration-300 hover:shadow-[0_0_25px_rgba(245,158,11,0.15)] no-underline">
            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-5">
                <div class="flex-shrink-0 w-11 h-11 rounded-full bg-amber-500/20 flex items-center justify-center group-hover:bg-amber-500/30 transition-colors">
                    <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-white font-semibold text-sm sm:text-base mb-1">📖 Acest film este o ecranizare</p>
                    <p class="text-gray-400 text-xs sm:text-sm m-0">Descoperă cartea care a inspirat filmul – comandă de pe Libris.ro</p>
                </div>
                <div class="flex-shrink-0 mt-1 sm:mt-0">
                    <span class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-amber-500/20 group-hover:bg-amber-500/30 text-amber-300 group-hover:text-amber-200 text-xs sm:text-sm font-semibold rounded-full transition-all duration-300">
                        Caută cartea
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </div>
            </div>
        </a>
    </div>
    <?php
}

/**
 * Render eMAG "movie night" banner for single movie pages (after related movies)
 */
function render_emag_movie_night_banner()
{
    $link = get_affiliate_link('emag');
    ?>
    <div class="max-w-4xl mx-auto mt-6 mb-2">
        <a href="<?php echo esc_url($link); ?>"
           target="_blank"
           rel="sponsored noopener"
           class="no-prefetch group block bg-gradient-to-r from-[#0a1e1a] via-[#0f2922] to-[#0a1a15] rounded-xl px-6 py-2 border border-emerald-500/20 hover:border-emerald-400/40 transition-all duration-300 hover:shadow-[0_0_25px_rgba(16,185,129,0.15)] no-underline">
            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-5">
                <div class="flex-shrink-0 w-11 h-11 rounded-full bg-emerald-500/20 flex items-center justify-center group-hover:bg-emerald-500/30 transition-colors">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-white font-semibold text-sm sm:text-base mb-1">📺 Televizoare 4K pe eMAG</p>
                    <p class="text-gray-400 text-xs sm:text-sm m-0">Caută televizoare 4K, OLED și QLED pentru o experiență cinematografică acasă.</p>
                </div>
                <div class="flex-shrink-0 mt-1 sm:mt-0">
                    <span class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-emerald-500/20 group-hover:bg-emerald-500/30 text-emerald-300 group-hover:text-emerald-200 text-xs sm:text-sm font-semibold rounded-full transition-all duration-300">
                        Vezi pe eMAG
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </div>
            </div>
        </a>
    </div>
    <?php
}

/**
 * Render eMAG popcorn machine banner for single movie pages (after description)
 */
function render_popcorn_movie_banner()
{
    $link = get_affiliate_link('popcorn');
    ?>
    <div class="max-w-4xl mx-auto mt-4">
        <a href="<?php echo esc_url($link); ?>"
           target="_blank"
           rel="sponsored nofollow noopener"
           class="no-prefetch group block bg-gradient-to-r from-[#2e120e] via-[#3a1a12] to-[#25100c] rounded-xl px-6 py-2 border border-red-500/20 hover:border-red-400/40 transition-all duration-300 hover:shadow-[0_0_25px_rgba(239,68,68,0.15)] no-underline">
            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-5">
                <div class="flex-shrink-0 w-11 h-11 rounded-full bg-red-500/20 flex items-center justify-center group-hover:bg-red-500/30 transition-colors">
                    <span class="text-xl leading-none">🍿</span>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-white font-semibold text-sm sm:text-base mb-1">Un film bun merge cu popcorn</p>
                    <p class="text-gray-400 text-xs sm:text-sm m-0">Aparat cu aer cald – popcorn ca la cinema, fără ulei, gata în 3 minute. ~99 lei pe eMAG.</p>
                </div>
                <div class="flex-shrink-0 mt-1 sm:mt-0">
                    <span class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-red-500/20 group-hover:bg-red-500/30 text-red-300 group-hover:text-red-200 text-xs sm:text-sm font-semibold rounded-full transition-all duration-300">
                        Vezi pe eMAG
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </div>
            </div>
        </a>
    </div>
    <?php
}

/**
 * Render Cărturești Mărțișor seasonal banner
 * Only visible between Feb 15 and Mar 8 each year.
 */
function render_carturesti_martisor_banner()
{
    // Date guard: only show during Mărțișor season (Feb 15 – Mar 8)
    $now   = current_time('timestamp');
    $year  = date('Y', $now);
    $start = strtotime("$year-02-15");
    $end   = strtotime("$year-03-08 23:59:59");

    if ($now < $start || $now > $end) {
        return;
    }

    $link = get_affiliate_link('carturesti');
    ?>
    <div class="max-w-4xl mx-auto mt-4">
        <a href="<?php echo esc_url($link); ?>"
           target="_blank"
           rel="sponsored noopener"
           class="no-prefetch group block bg-gradient-to-r from-[#2e1525] via-[#3a1a2e] to-[#251020] rounded-xl px-6 py-4 border border-rose-500/20 hover:border-rose-400/40 transition-all duration-300 hover:shadow-[0_0_25px_rgba(244,63,94,0.15)] no-underline">
            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-5">
                <div class="flex-shrink-0 w-11 h-11 rounded-full bg-rose-500/20 flex items-center justify-center group-hover:bg-rose-500/30 transition-colors">
                    <span class="text-xl leading-none">🌸</span>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <p class="text-white font-semibold text-sm sm:text-base mb-1">🌸 Mărțișor la Cărturești</p>
                    <p class="text-gray-400 text-xs sm:text-sm m-0">Găsește cadoul perfect de Mărțișor – cărți, bijuterii și surprize de primăvară, pe Cărturești.</p>
                </div>
                <div class="flex-shrink-0 mt-1 sm:mt-0">
                    <span class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-rose-500/20 group-hover:bg-rose-500/30 text-rose-300 group-hover:text-rose-200 text-xs sm:text-sm font-semibold rounded-full transition-all duration-300">
                        Descoperă cadouri
                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </div>
            </div>
        </a>
    </div>
    <?php
}
