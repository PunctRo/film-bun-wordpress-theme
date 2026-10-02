<?php

/**
 * Content Processing Functions
 * 
 * Functions for processing and cleaning post content
 */

if (!function_exists('get_movie_excerpt')):
    /**
     * Get excerpt from cleaned post content
     * If excerpt exists, returns that, otherwise generates from cleaned content
     */
    function get_movie_excerpt($post_id, $text)
    {
        if (has_excerpt($post_id)) {
            return get_the_excerpt($post_id);
        }

        return wp_trim_words(wp_strip_all_tags($text), 20);
    }
endif;

if (!function_exists('extract_post_content')):
    /**
     * Extract and clean post content for display
     * Removes metadata and formats the actual review text
     */
    function extract_post_content($post_id)
    {
        // Check if this post is in the 'noutati' category
        // If yes, return content without movie review formatting
        if (has_category('noutati', $post_id)) {
            // Get the raw content
            $content = get_the_content();
            // Remove shortcodes
            $content = strip_shortcodes($content);
            // Apply WordPress content filters to process blocks, embeds, etc.
            // This will handle all WordPress formatting properly
            $content = apply_filters('the_content', $content);
            
            // Remove "Filme Bune similare:" section from noutati posts
            // This section is embedded in the post content but not relevant for noutati
            $content = preg_replace('/<div[^>]*>\s*<h4[^>]*>Filme Bune similare:.*?<\/div>/is', '', $content);
            
            return $content;
        }

        // Get the full content
        $content = get_the_content();
        $original_content = $content;

        // First, check if we're dealing with a modern format post (with rating-star div)
        $is_modern_format = strpos($content, 'rating-star') !== false;

        // Remove shortcodes first
        $content = preg_replace('/\[.*?\]/', ' ', $content);

        // Normalize spaces that might have been created by shortcode removal
        $content = preg_replace('/\s+/', ' ', $content);

        // For modern format posts (with structured content)
        if ($is_modern_format) {
            // Extract just the review content after metadata section
            if (preg_match('/<ul[^>]*>.*?<\/ul>\s*(.*?)(?:<div class="more">|$)/s', $original_content, $matches)) {
                $main_content = $matches[1];

                // Remove any leftover metadata items that might be at the beginning
                $main_content = preg_replace('/<li>\s*<strong>Nota IMDB\*?:<\/strong>.*?<\/li>/', '', $main_content);
                $main_content = preg_replace('/<li>\s*<strong>Regia:<\/strong>.*?<\/li>/', '', $main_content);
                $main_content = preg_replace('/<li>\s*<strong>Durata:<\/strong>.*?<\/li>/', '', $main_content);

                // Also try without list items
                $main_content = preg_replace('/<strong>Nota IMDB\*?:<\/strong>.*?<br\s*\/?>/', '', $main_content);
                $main_content = preg_replace('/<strong>Regia:<\/strong>.*?<br\s*\/?>/', '', $main_content);
                $main_content = preg_replace('/<strong>Durata:<\/strong>.*?<br\s*\/?>/', '', $main_content);

                // Clean up any remaining list structure
                $main_content = preg_replace('/<ul[^>]*>.*?<\/ul>/', '', $main_content);

                // Preserve strong tags and paragraphs
                $main_content = strip_tags($main_content, '<p><strong>');

                // Make sure content is wrapped in paragraph tags
                if (!preg_match('/^<p>.*<\/p>$/s', $main_content)) {
                    $main_content = '<p>' . $main_content . '</p>';
                }

                return $main_content;
            }

            // Alternative pattern for modern format with div structure
            if (preg_match('/<div[^>]*>\s*<ul[^>]*>.*?<\/ul>\s*(.*?)(?:<\/div>|<div class="more">|$)/s', $original_content, $matches)) {
                $main_content = $matches[1];

                // Remove any leftover metadata items that might be at the beginning
                $main_content = preg_replace('/<li>\s*<strong>Nota IMDB\*?:<\/strong>.*?<\/li>/', '', $main_content);
                $main_content = preg_replace('/<li>\s*<strong>Regia:<\/strong>.*?<\/li>/', '', $main_content);
                $main_content = preg_replace('/<li>\s*<strong>Durata:<\/strong>.*?<\/li>/', '', $main_content);

                // Also try without list items
                $main_content = preg_replace('/<strong>Nota IMDB\*?:<\/strong>.*?<br\s*\/?>/', '', $main_content);
                $main_content = preg_replace('/<strong>Regia:<\/strong>.*?<br\s*\/?>/', '', $main_content);
                $main_content = preg_replace('/<strong>Durata:<\/strong>.*?<br\s*\/?>/', '', $main_content);

                // Clean up any remaining list structure
                $main_content = preg_replace('/<ul[^>]*>.*?<\/ul>/', '', $main_content);

                // Preserve strong tags and paragraphs
                $main_content = strip_tags($main_content, '<p><strong>');

                // Make sure content is wrapped in paragraph tags
                if (!preg_match('/^<p>.*<\/p>$/s', $main_content)) {
                    $main_content = '<p>' . $main_content . '</p>';
                }

                return $main_content;
            }
        }

        // For legacy posts or if modern format extraction failed

        // If content is already clean paragraph format (enriched via API, no legacy metadata),
        // return it directly — legacy patterns would truncate to first paragraph only.
        if (
            strpos($original_content, 'Nota IMDB') === false &&
            strpos($original_content, '<strong>Regia') === false &&
            preg_match('/^\s*<p>/s', $original_content)
        ) {
            return preg_replace('/<div class="widget pt-2">.*?<\/div>/s', '', $original_content);
        }

        // Check if this is a legacy post with typical metadata pattern and extract just the review text
        if (preg_match('/<p>(?:.*?)?(?:\[.*?\])?<strong>Nota IMDB.*?<\/strong>.*?<strong>Regia<\/strong>.*?<strong>Durata<\/strong>.*?(\d+)\s*min<br\s*\/?>\s*(.*?)(?:<\/p>|<!--more-->)/s', $original_content, $legacy_matches)) {
            // Extract just the actual review text after all metadata (using the text after duration)
            $main_content = $legacy_matches[2];

            // Clean up the content
            $main_content = trim($main_content);

            // Make sure content is wrapped in paragraph tags
            return '<p>' . $main_content . '</p>';
        }

        // Alternative pattern for legacy posts with different structure
        if (preg_match('/<p>(?:.*?<img.*?)?(?:\[.*?\])?(?:<strong>Nota IMDB.*?<\/strong>.*?)?(?:<strong>Regia<\/strong>.*?)?(?:<strong>Durata<\/strong>.*?)?(.*?)(?:<\/p>|<!--more-->)/s', $original_content, $legacy_matches)) {
            // Extract just the actual review text after all metadata
            $main_content = $legacy_matches[1];

            // Further clean the content by removing any remaining metadata
            $main_content = preg_replace('/<strong>Nota\s*IMDB\s*\*?<\/strong>\s*:?\s*[0-9.\/]+\s*/', '', $main_content);
            $main_content = preg_replace('/<strong>Regia<\/strong>\s*:?\s*[^<>\.!?,]+/', '', $main_content);
            $main_content = preg_replace('/<strong>Durata<\/strong>\s*:?\s*[0-9]+\s*min\s*/', '', $main_content);

            // Clean up the content
            $main_content = trim($main_content);

            // Make sure content is wrapped in paragraph tags
            return '<p>' . $main_content . '</p>';
        }

        // Generic fallback extraction if specific patterns don't match

        // Keep paragraph, strong tags for now
        $content = strip_tags($content, '<p><strong>');

        // Convert line breaks and normalize spaces
        $content = preg_replace('/<br\s*\/?>\s*/', "\n", $content);
        $content = preg_replace('/\s+/', ' ', $content);

        // Remove metadata sections more aggressively
        // First remove entire metadata blocks (pattern as seen in the provided example)
        if (preg_match('/<p>(\[.*?\])?<strong>Nota IMDB \*<\/strong>: [0-9.\/]+<br\s*\/?>\s*<strong>Regia<\/strong>.*?<strong>Durata<\/strong>.*?(.*?)<\/p>/s', $content, $cleaned_matches)) {
            // Replace with just the review content part
            $content = '<p>' . trim($cleaned_matches[2]) . '</p>';
        } else {
            // Individual metadata removal if block pattern doesn't match
            $content = preg_replace('/<strong>Nota\s*IMDB\s*\*?<\/strong>\s*:?\s*[0-9.\/]+\s*/', '', $content);
            $content = preg_replace('/<strong>Regia<\/strong>\s*:?\s*[^<>\.!?,]+/', '', $content);
            $content = preg_replace('/<strong>Durata<\/strong>\s*:?\s*[0-9]+\s*min\s*/', '', $content);

            // Also try without strong tags
            $content = preg_replace('/Nota\s*IMDB\s*\*?\s*:?\s*[0-9.\/]+\s*/', '', $content);
            $content = preg_replace('/Regia\s*:?\s*[^<>\.!?,]+/', '', $content);
            $content = preg_replace('/Durata\s*:?\s*[0-9]+\s*min\s*/', '', $content);
        }

        // Remove image tags completely - including incomplete ones
        $content = preg_replace('/<img[^>]*>/', '', $content);
        $content = preg_replace('/class="[^"]*"[^>]*\/>/', '', $content); // Remove incomplete image tags

        // Remove any leftover HTML attributes (common issue with broken image tags)
        $content = preg_replace('/(?:class|style|title|src|alt|width|height|align|frameborder)="[^"]*"/', '', $content);
        $content = preg_replace('/\s*(?:\/)?&gt;/', '', $content); // Remove broken closing tags

        // Clean any paragraphs with just HTML attributes
        $content = preg_replace('/<p>\s*(?:class|style|title|src|alt|width|height).*?<\/p>/', '', $content);

        // Remove empty paragraphs that may be left after image removal
        $content = preg_replace('/<p>\s*<\/p>/', '', $content);

        // Try to find content ending with "Vizionare plăcută!" if it exists
        if (preg_match('/(.*?Vizionare\s+plăcută\s*!)/s', $content, $matches)) {
            $content = $matches[1];
        }

        // Remove any trailer sections or post-review content
        $content = preg_replace('/Trailer.*$/s', '', $content);
        $content = preg_replace('/Filmul.*?este disponibil.*$/s', '', $content);
        $content = preg_replace('/Powered by.*$/s', '', $content);
        $content = preg_replace('/<!--more-->.*$/s', '', $content);

        // Final cleanup for specific cases
        // Special handling for the pattern mentioned by the user
        $content = preg_replace('/<p><strong>Nota IMDB \*<\/strong>:\s*[0-9.\/]+\s+(.*?)<\/p>/s', '<p>$1</p>', $content);

        // Extract content after Durata if present - key pattern for most posts
        if (preg_match('/<strong>Durata<\/strong>\s*:?\s*\d+\s*min<br\s*\/?>(.+?)(?:<\/p>|$)/s', $content, $extracted)) {
            $content = '<p>' . trim($extracted[1]) . '</p>';
        }

        // More aggressive removal of leftover metadata at start of paragraph
        $content = preg_replace('/<p>\s*<strong>Nota IMDB\*?:<\/strong>.*?<strong>(?:Regia:<\/strong>.*?)?<strong>Durata:<\/strong>.*?min\s*(.*?)<\/p>/s', '<p>$1</p>', $content);
        $content = preg_replace('/<p>\s*<strong>Nota IMDB\*?<\/strong>.*?<strong>(?:Regia<\/strong>.*?)?<strong>Durata<\/strong>.*?min\s*(.*?)<\/p>/s', '<p>$1</p>', $content);

        // Clean up the text
        $content = trim($content);

        // Fix any case where text might have been concatenated incorrectly
        $content = preg_replace('/([a-zăîâșț])([A-ZĂÎÂȘȚ])/', '$1 $2', $content);

        // Fix character encoding issues with Romanian diacritical marks
        $content = preg_replace('/\s+([ăîâșțĂÎÂȘȚ])/', '$1', $content);
        $content = preg_replace('/([ăîâșțĂÎÂȘȚ])\s+/', '$1', $content);

        // Wrap in paragraph if not already wrapped
        if (!preg_match('/^<p>.*<\/p>$/s', $content)) {
            $content = '<p>' . $content . '</p>';
        }

        return $content;
    }
endif;

if (!function_exists('get_movie_related_posts')):

    function get_movie_related_posts()
    {
        global $post;
        $post_id = $post->ID;

        $meta = get_post_meta($post_id, 'film_related_ids', true);

        if (empty($meta)) {
            return array();
        }

        $ids = array_filter(array_map('absint', explode(',', $meta)));
        if (empty($ids)) {
            return array();
        }

        $posts = get_posts(array(
            'post__in'            => $ids,
            'orderby'             => 'post__in',
            'posts_per_page'      => count($ids),
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        ));

        $svg_fallback = '<div class="absolute inset-0 flex items-center justify-center bg-[#002a3a]"><svg class="w-16 h-16 text-cyan-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 8V16L16 12L10 8Z" fill="currentColor"/><path d="M3 5H21C21.5523 5 22 5.44772 22 6V18C22 18.5523 21.5523 19 21 19H3C2.44772 19 2 18.5523 2 18V6C2 5.44772 2.44772 5 3 5Z" stroke="currentColor" stroke-width="1.5"/><path d="M6 3V7M18 3V7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M2 9H22" stroke="currentColor" stroke-width="1.5"/></svg></div>';

        $related_posts = array();
        foreach ($posts as $p) {
            $poster_url = extract_movie_poster($p->ID);
            $related_posts[] = array(
                'permalink'  => get_permalink($p->ID),
                'title'      => $p->post_title,
                'image_html' => $poster_url
                    ? sprintf('<img src="%s" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="%s" title="%s" />', esc_url($poster_url), esc_attr($p->post_title), esc_attr($p->post_title))
                    : $svg_fallback,
            );
        }

        return $related_posts;
    }
endif;
