<?php
// includes/class-news-post-type.php

/**
 * Registers the news section: 'stiri' CPT, 'news_topic' taxonomy,
 * related_films meta, and seeds the curated topic terms.
 */
class News_Post_Type
{
    const POST_TYPE = 'stiri';
    const TAXONOMY  = 'news_topic';

    /** slug => display name, seeded once */
    const TOPICS = [
        'trailer'   => 'Trailer',
        'streaming' => 'Streaming',
        'premiera'  => 'Premieră',
        'editorial' => 'Editorial',
    ];

    public function __construct()
    {
        add_action('init', [$this, 'register_post_type']);
        add_action('init', [$this, 'register_taxonomy']);
        add_action('init', [$this, 'register_meta']);
        add_action('init', [$this, 'seed_topics'], 20);
        add_action('after_switch_theme', [$this, 'flush']);
    }

    public function register_post_type()
    {
        register_post_type(self::POST_TYPE, [
            'labels' => [
                'name'          => 'Știri',
                'singular_name' => 'Știre',
                'add_new_item'  => 'Adaugă știre',
                'edit_item'     => 'Editează știrea',
                'menu_name'     => 'Știri',
            ],
            'public'       => true,
            'has_archive'  => 'stiri',
            'rewrite'      => ['slug' => 'stiri', 'with_front' => false],
            'menu_icon'    => 'dashicons-megaphone',
            'show_in_rest' => true,
            'rest_base'    => 'stiri',
            'supports'     => ['title', 'editor', 'excerpt', 'thumbnail', 'author', 'custom-fields'],
        ]);
    }

    public function register_taxonomy()
    {
        register_taxonomy(self::TAXONOMY, self::POST_TYPE, [
            'labels' => [
                'name'          => 'Subiecte',
                'singular_name' => 'Subiect',
                'menu_name'     => 'Subiecte',
            ],
            'hierarchical'      => false,
            'public'            => false,
            'publicly_queryable' => false, // no front-end topic archives yet
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rest_base'         => 'news_topic',
        ]);
    }

    public function register_meta()
    {
        register_post_meta(self::POST_TYPE, 'related_films', [
            'type'              => 'string',
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => function ($value) {
                return implode(',', news_parse_related_ids($value));
            },
            'auth_callback'     => function () { return current_user_can('edit_posts'); },
        ]);
    }

    public function seed_topics()
    {
        foreach (self::TOPICS as $slug => $name) {
            if (!term_exists($slug, self::TAXONOMY)) {
                wp_insert_term($name, self::TAXONOMY, ['slug' => $slug]);
            }
        }
    }

    public function flush()
    {
        $this->register_post_type();
        flush_rewrite_rules();
    }
}
