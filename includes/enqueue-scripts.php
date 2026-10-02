<?php

/**
 * Script and Style Enqueuing
 * 
 * Handles loading of all theme assets
 */

if (!function_exists('my_theme_enqueue_scripts')):
    /**
     * Enqueue theme scripts and styles
     */
    function my_theme_enqueue_scripts()
    {
        if (defined('WP_ENV') && WP_ENV === 'development') {
            // Load both CSS and JS in development
            wp_enqueue_style('my-theme-style', 'http://localhost:3000/assets/css/main.css', array(), null);
            wp_enqueue_script('my-theme-script', 'http://localhost:3000/@vite/client', array(), null, true);
            wp_enqueue_script('my-theme-vite', 'http://localhost:3000/assets/js/main.js', array('my-theme-script'), null, true);
        } else {
            $dist_dir = get_template_directory() . '/dist/assets/';
            $css_file = glob($dist_dir . 'main-*.css')[0];
            $js_file = glob($dist_dir . 'main-*.js')[0];

            wp_enqueue_style('my-theme-style', get_template_directory_uri() . '/dist/assets/' . basename($css_file), array(), null);
            wp_enqueue_script('my-theme-script', get_template_directory_uri() . '/dist/assets/' . basename($js_file), array(), null, true);
        }

        // Enqueue JustWatch widget script only on single movie posts
        if (is_single()) {
            wp_enqueue_script(
                'justwatch-widget',
                'https://widget.justwatch.com/justwatch_widget.js',
                array(),
                null,
                true
            );
        }
    }
endif;
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

if (!function_exists('modify_script_attributes')):
    /**
     * Modify script attributes for specific scripts
     */
    function modify_script_attributes($tag, $handle, $src)
    {
        // Add module attribute for Vite scripts
        if ($handle === 'my-theme-script' || $handle === 'my-theme-vite') {
            return '<script type="module" src="' . esc_url($src) . '"></script>';
        }

        // Add async attribute for JustWatch widget
        if ($handle === 'justwatch-widget') {
            return '<script async src="' . esc_url($src) . '"></script>';
        }

        return $tag;
    }
endif;
add_filter('script_loader_tag', 'modify_script_attributes', 10, 3);

if (!function_exists('disable_recaptcha_except_contact')):
    /**
     * Disable reCAPTCHA and Contact Form 7 scripts on non-contact pages
     * This improves page load performance by preventing unnecessary script loading
     */
    function disable_recaptcha_except_contact()
    {
        if (!is_page('contact')) {
            wp_dequeue_script('google-recaptcha');
            add_filter('wpcf7_load_js', '__return_false');
            add_filter('wpcf7_load_css', '__return_false');
            remove_action('wp_enqueue_scripts', 'wpcf7_recaptcha_enqueue_scripts', 20);
        }
    }
endif;
add_action('wp_enqueue_scripts', 'disable_recaptcha_except_contact');

// Fix "wp is not defined":
// LiteSpeed combină wp-i18n.js în bundle-ul combinat, dar inline scripts-urile WordPress
// (wp-i18n-js-after, contact-form-7-js-translations) sunt data: URIs care rulează
// ÎNAINTE de bundle → wp e undefined. Soluția: eliminăm complet aceste scripturi
// pe paginile non-contact unde CF7 și wp-i18n nu sunt necesare.
add_action('wp_enqueue_scripts', function () {
    // Rank Math analytics încarcă wp-element/wp-components inutil pe frontend.
    wp_dequeue_script('rank-math-analytics-stats');
    wp_deregister_script('rank-math-analytics-stats');

    if (!is_page('contact')) {
        // Deregister elimină scriptul ȘI inline scripts-urile atașate (translations, before/after).
        // wp_dequeue singur nu elimină inline scripts — de aceea folosim deregister.
        wp_dequeue_script('contact-form-7');
        wp_deregister_script('contact-form-7');
        wp_dequeue_script('wp-i18n');
        wp_deregister_script('wp-i18n');
    }
}, 999);
