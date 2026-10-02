<?php

/**
 * Movie Taxonomies Handler
 * 
 * Handles registration and management of movie-related taxonomies
 */
class Movie_Taxonomies
{
    /**
     * Register all movie-related taxonomies
     */
    public static function register()
    {
        self::register_year_taxonomy();
        self::register_director_taxonomy();
        self::register_actor_taxonomy();
    }

    /**
     * Register Year (An) taxonomy
     */
    private static function register_year_taxonomy()
    {
        $labels = array(
            'name' => _x('An', 'taxonomy general name'),
            'singular_name' => _x('An', 'taxonomy singular name'),
            'search_items' => __('Search Years'),
            'popular_items' => __('Popular Years'),
            'all_items' => __('All Years'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edit Year'),
            'update_item' => __('Update Year'),
            'add_new_item' => __('Add New Year'),
            'new_item_name' => __('New Year Name'),
            'separate_items_with_commas' => __('Separate Years with commas'),
            'add_or_remove_items' => __('Add or remove Years'),
            'choose_from_most_used' => __('Choose from the most used Years'),
            'menu_name' => __('Years'),
        );

        register_taxonomy('an', 'post', array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'an'),
            'show_in_rest' => true,
        ));
    }

    /**
     * Register Director (Regizor) taxonomy
     */
    private static function register_director_taxonomy()
    {
        $labels = array(
            'name' => _x('Regizor', 'taxonomy general name'),
            'singular_name' => _x('Regizor', 'taxonomy singular name'),
            'search_items' => __('Search Director'),
            'popular_items' => __('Popular Directors'),
            'all_items' => __('All Directors'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edit Director'),
            'update_item' => __('Update Director'),
            'add_new_item' => __('Add New Director'),
            'new_item_name' => __('New Director Name'),
            'separate_items_with_commas' => __('Separate Directors with commas'),
            'add_or_remove_items' => __('Add or remove Directors'),
            'choose_from_most_used' => __('Choose from the most used Directors'),
            'menu_name' => __('Directors'),
        );

        register_taxonomy('regizor', 'post', array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'regizor'),
            'show_in_rest' => true,
        ));
    }

    /**
     * Register Actor taxonomy
     */
    private static function register_actor_taxonomy()
    {
        $labels = array(
            'name' => _x('Actor', 'taxonomy general name'),
            'singular_name' => _x('Actor', 'taxonomy singular name'),
            'search_items' => __('Search Actori'),
            'popular_items' => __('Popular Actori'),
            'all_items' => __('All Actori'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edit Actor'),
            'update_item' => __('Update Actor'),
            'add_new_item' => __('Add New Actor'),
            'new_item_name' => __('New Actor Name'),
            'separate_items_with_commas' => __('Separate Actori with commas'),
            'add_or_remove_items' => __('Add or remove Actori'),
            'choose_from_most_used' => __('Choose from the most used Actori'),
            'menu_name' => __('Actori'),
        );

        register_taxonomy('actor', 'post', array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'actor'),
            'show_in_rest' => true,
        ));
    }
    /**
     * Get recent years from the year taxonomy
     *
     * @param int $count Number of years to return
     * @return array|WP_Error Array of term objects or WP_Error
     */
    public static function get_recent_years($count = 5)
    {
        return get_terms([
            'taxonomy' => 'an',
            'orderby' => 'name',
            'order' => 'DESC',
            'number' => $count,
            'hide_empty' => true
        ]);
    }
}
