<?php

/**
 * Theme Setup
 * 
 * Basic theme setup and support declarations
 */

if (!function_exists('my_theme_setup')):
    /**
     * Sets up theme defaults and registers support for various WordPress features
     */
    function my_theme_setup()
    {
        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages
        add_theme_support('post-thumbnails');

        // Register nav menus
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'textdomain'),
        ));

        // Switch default core markup to output valid HTML5
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
    }
endif;
add_action('after_setup_theme', 'my_theme_setup');

/**
 * Remove feed links from wp_head
 */
function remove_feed_links()
{
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
}
add_action('init', 'remove_feed_links');

/**
 * Clear related movies meta data when post is saved
 * This ensures they are re-extracted from the updated content
 */
function clear_related_movies_on_save($post_id)
{
    // If this is just a revision, don't process
    if (wp_is_post_revision($post_id)) {
        return;
    }

    // Delete the related movies meta so it will be re-extracted
    delete_post_meta($post_id, 'related_movies');
}
add_action('save_post', 'clear_related_movies_on_save');
