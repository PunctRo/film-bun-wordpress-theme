<?php

/**
 * Search functionality enhancements
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define constants if not already defined
if (!defined('HOUR_IN_SECONDS')) {
    define('HOUR_IN_SECONDS', 3600);
}

/**
 * Highlight search terms in text
 */
function highlight_search_terms($text)
{
    $search_terms = get_search_query();
    if (empty($search_terms)) {
        return $text;
    }

    // Split search terms and escape regex special characters
    $terms = array_map(function ($term) {
        return preg_quote($term, '/');
    }, explode(' ', $search_terms));

    // Build regex pattern for all terms
    $pattern = '/(' . implode('|', $terms) . ')/iu';

    return preg_replace($pattern, '<mark class="bg-cyan-500/20 text-cyan-300 font-bold">$1</mark>', $text);
}

/**
 * Modify titles and excerpts to highlight search terms
 */
function add_search_term_highlighting($text)
{
    if (is_search() && !empty($text)) {
        return highlight_search_terms($text);
    }
    return $text;
}
add_filter('the_title', 'add_search_term_highlighting', 100);
add_filter('get_the_excerpt', 'add_search_term_highlighting', 100);

/**
 * Optimize search queries
 */
function optimize_search_query($query)
{
    if (!is_admin() && $query->is_search() && $query->is_main_query()) {
        // Collapse runs of whitespace — "The  gorge" must match "The Gorge"
        $s = preg_replace('/\s+/u', ' ', trim((string) $query->get('s')));
        $query->set('s', $s);

        // Redirect empty search to homepage
        if ('' === $s) {
            wp_redirect(home_url('/'));
            exit;
        }

        // Optimize query performance
        $query->set('cache_results', true);
        $query->set('update_post_meta_cache', true);
        $query->set('update_post_term_cache', true);

        // Only search in posts
        $query->set('post_type', 'post');

        // Order by relevance and date
        $query->set('orderby', 'relevance');
    }
    return $query;
}
add_action('pre_get_posts', 'optimize_search_query');


/**
 * Modify search to include custom fields
 *
 * Taxonomy matching runs as a correlated EXISTS, NOT as LEFT JOINs on
 * term_relationships/terms: the joins multiply rows (forcing DISTINCT +
 * GROUP BY) and push MariaDB into a full-scan BNL join on wp_terms —
 * multi-minute searches that pile up on the DB.
 */
function search_include_custom_fields($search, $wp_query)
{
    global $wpdb;

    if (!is_admin() && $wp_query->is_search() && $wp_query->is_main_query() && $wp_query->get('s')) {
        $search_term = $wp_query->get('s');

        // Match word-by-word (every word must match some field), not the whole
        // phrase as one literal LIKE — "Fjord 2026" must find the post titled
        // "Fjord (2026)"; a single phrase LIKE can't cross the punctuation.
        $words = preg_split('/\s+/u', trim((string) $search_term), -1, PREG_SPLIT_NO_EMPTY);
        $words = array_slice($words, 0, 8); // bound query size
        if (empty($words)) {
            return $search;
        }

        // Older posts have the trailer iframe and the "related movies" widget
        // embedded directly in post_content (now generated from meta/template
        // instead) followed by an optional "<!--more-->". Cut the content
        // there so LIKE only ever sees the actual review text — matching on
        // the words "Trailer"/"Actori" instead used to reject the whole post
        // just because the editor's own prose happened to contain them (e.g.
        // "Familia Rose" mentions "trailer" in its review), see wp_posts_client.py
        // _strip_legacy_sections() for the equivalent PHP-side logic.
        $reviewable_content = "SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX({$wpdb->posts}.post_content, '<!--more-->', 1), '<iframe', 1), '<div class=\"widget', 1)";

        $word_clauses      = [];
        $title_word_likes  = [];
        foreach ($words as $word) {
            $like_term = '%' . $wpdb->esc_like($word) . '%';

            // Prioritize title matches
            $title_search = $wpdb->prepare(
                "({$wpdb->posts}.post_title LIKE %s)",
                $like_term
            );
            $title_word_likes[] = $title_search;

            $content_search = $wpdb->prepare(
                "OR ({$reviewable_content} LIKE %s)",
                $like_term
            );

            // Search in relevant meta fields
            $custom_fields_search = $wpdb->prepare(
                "OR EXISTS (
                    SELECT * FROM {$wpdb->postmeta}
                    WHERE post_id = {$wpdb->posts}.ID
                    AND meta_key IN ('filmRating', 'duration', 'imdbRating')
                    AND meta_value LIKE %s
                )",
                $like_term
            );

            // Search in taxonomy terms (tags, categories, actors, etc.)
            $taxonomy_search = $wpdb->prepare(
                "OR EXISTS (
                    SELECT 1 FROM {$wpdb->term_relationships} tr_w
                    INNER JOIN {$wpdb->term_taxonomy} tt_w ON (tt_w.term_taxonomy_id = tr_w.term_taxonomy_id)
                    INNER JOIN {$wpdb->terms} t_w ON (t_w.term_id = tt_w.term_id)
                    WHERE tr_w.object_id = {$wpdb->posts}.ID
                    AND t_w.name LIKE %s
                )",
                $like_term
            );

            $word_clauses[] = "({$title_search} {$content_search} {$custom_fields_search} {$taxonomy_search})";
        }

        // Combine: every word must match at least one field
        $search = ' AND (' . implode(' AND ', $word_clauses) . ')';

        // Add relevance ordering: exact phrase in title first, then titles
        // matching all words, then phrase in excerpt/content
        add_filter('posts_orderby', function () use ($wpdb, $search_term, $title_word_likes) {
            $phrase_like     = '%' . $wpdb->esc_like($search_term) . '%';
            $phrase_title    = $wpdb->prepare("{$wpdb->posts}.post_title LIKE %s", $phrase_like);
            $phrase_excerpt  = $wpdb->prepare("{$wpdb->posts}.post_excerpt LIKE %s", $phrase_like);
            $phrase_content  = $wpdb->prepare("{$wpdb->posts}.post_content LIKE %s", $phrase_like);
            $title_all_words = implode(' AND ', $title_word_likes);
            return "CASE
                    WHEN {$phrase_title} THEN 1
                    WHEN {$title_all_words} THEN 2
                    WHEN {$phrase_excerpt} THEN 3
                    WHEN {$phrase_content} THEN 4
                    ELSE 5
                END, {$wpdb->posts}.post_date DESC";
        });
    }

    return $search;
}
add_filter('posts_search', 'search_include_custom_fields', 10, 2);
