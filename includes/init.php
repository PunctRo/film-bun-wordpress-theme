<?php

/**
 * Theme Initialization
 * 
 * Loads all theme modules and functionality
 */

// Define the theme's root path
if (!defined('THEME_ROOT')) {
    define('THEME_ROOT', get_template_directory());
}

// Define the includes path
if (!defined('THEME_INCLUDES')) {
    define('THEME_INCLUDES', THEME_ROOT . '/includes');
}

// Load required files
require_once THEME_INCLUDES . '/class-movie-metadata.php';
require_once THEME_INCLUDES . '/class-movie-taxonomies.php';
require_once THEME_INCLUDES . '/components/star-rating.php';
require_once THEME_INCLUDES . '/content-processing.php';
require_once THEME_INCLUDES . '/enqueue-scripts.php';
require_once THEME_INCLUDES . '/setup.php';
require_once THEME_INCLUDES . '/helper-functions.php';
require_once THEME_INCLUDES . '/class-custom-nav-walker.php';
require_once THEME_INCLUDES . '/class-category-header.php';
require_once THEME_INCLUDES . '/class-tag-header.php';
require_once THEME_INCLUDES . '/class-year-header.php';
require_once THEME_INCLUDES . '/class-actor-header.php';
require_once THEME_INCLUDES . '/class-director-header.php';
require_once THEME_INCLUDES . '/search-functions.php';
require_once THEME_INCLUDES . '/comments-functions.php';
require_once THEME_INCLUDES . '/search-logging.php';
require_once THEME_INCLUDES . '/class-film-related-metabox.php';
require_once THEME_INCLUDES . '/class-news-post-type.php';
require_once THEME_INCLUDES . '/news-functions.php';
require_once THEME_INCLUDES . '/class-news-related-metabox.php';
require_once THEME_INCLUDES . '/class-news-settings.php';

// Initialize classes
add_action('init', array('Movie_Taxonomies', 'register'));
new Category_Header();
new Tag_Header();
new Year_Header();
new Actor_Header();
new Director_Header();
new News_Post_Type();
new News_Settings();

add_action('init', function () {
    // Map your meta keys to their schema.
    // Change 'post' to a specific post type if needed (e.g. 'post', 'page', 'movie').
    $post_type = 'post';

    $fields = [
        'filmRating'   => ['type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field'],
        'imdbId'       => ['type' => 'string',  'single' => true, 'sanitize_callback' => 'sanitize_text_field'],
        'imdbRating'   => ['type' => 'number',  'single' => true, 'sanitize_callback' => function ($v) {
            return is_numeric($v) ? (float) $v : null;
        }],
        'duration'     => ['type' => 'integer', 'single' => true, 'sanitize_callback' => function ($v) {
            return is_numeric($v) ? (int) $v : null;
        }],
        'justwatchURL' => ['type' => 'string',  'single' => true, 'sanitize_callback' => 'esc_url_raw'],
        'trailer'      => ['type' => 'string',  'single' => true, 'sanitize_callback' => 'esc_url_raw'],
        'movie_poster'  => ['type' => 'string',  'single' => true, 'sanitize_callback' => 'esc_url_raw'],
        'info_block'       => ['type' => 'string', 'single' => true, 'sanitize_callback' => 'wp_kses_post'],
        'film_related_ids' => ['type' => 'string', 'single' => true, 'sanitize_callback' => 'sanitize_text_field'],
        'streaming_url'    => ['type' => 'string',  'single' => true, 'sanitize_callback' => 'esc_url_raw'],
        // add more keys here...
    ];

    foreach ($fields as $key => $args) {
        register_post_meta(
            $post_type,           // '' to apply to ALL post types, or a specific type like 'post'
            $key,
            array_merge(
                [
                    'show_in_rest'  => true,            // <-- critical for MCP/REST
                    'auth_callback' => null,            // default read perms; edits require capability
                ],
                $args
            )
        );
    }
});
