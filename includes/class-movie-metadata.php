<?php

/**
 * Movie Metadata Handler
 * 
 * Handles extraction and storage of movie metadata from post content
 */
class Movie_Metadata
{
    /**
     * Extract movie poster from content and featured image
     * Returns the URL of the first image found in content or featured image
     */
    public static function extract_poster($post_id)
    {
        // Check if poster URL already exists in meta
        $existing_poster = get_post_meta($post_id, 'movie_poster', true);
        if (!empty($existing_poster)) {
            return $existing_poster;
        }

        // Get post content
        $content = get_post_field('post_content', $post_id);

        // Try to get first image from content
        if (preg_match('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $content, $matches)) {
            $poster_url = $matches[1];
            update_post_meta($post_id, 'movie_poster', $poster_url);
            return $poster_url;
        }

        // Fall back to featured image
        if (has_post_thumbnail($post_id)) {
            $poster_url = get_the_post_thumbnail_url($post_id, 'full');
            update_post_meta($post_id, 'movie_poster', $poster_url);
            return $poster_url;
        }

        return false;
    }

    /**
     * Extract film rating from post content and save as post meta
     */
    public static function extract_film_rating($post_id)
    {
        // Check if rating already exists
        $existing_rating = get_post_meta($post_id, 'filmRating', true);
        if (!empty($existing_rating)) {
            return $existing_rating;
        }

        // Get post content
        $content = get_post_field('post_content', $post_id);

        // Look for rating in [xrr rating=X/10] format
        if (preg_match('/\[xrr rating=(\d+\.?\d*)\/10\]/', $content, $matches)) {
            $rating = floatval($matches[1]);
            // Ensure rating is between 0 and 10
            if ($rating >= 0 && $rating <= 10) {
                update_post_meta($post_id, 'filmRating', $rating);
                return $rating;
            }
        }

        return false;
    }

    /**
     * Extract IMDB rating from post content and save as post meta
     */
    public static function extract_imdb_rating($post_id)
    {
        // Check if rating already exists
        $existing_rating = get_post_meta($post_id, 'imdbRating', true);
        if (!empty($existing_rating)) {
            return $existing_rating;
        }

        // Get post content and strip HTML tags
        $content = wp_strip_all_tags(get_post_field('post_content', $post_id));

        // Look for rating in format: "Nota IMDB *: 7.4"
        if (preg_match('/Nota IMDB\s*\*?:?\s*([\d.]+)/i', $content, $matches)) {
            $rating = floatval($matches[1]);
            // Ensure rating is between 0 and 10
            if ($rating >= 0 && $rating <= 10) {
                update_post_meta($post_id, 'imdbRating', $rating);
                return $rating;
            }
        }

        // If no IMDB rating found in content, use filmRating + 0.1
        $film_rating = get_post_meta($post_id, 'filmRating', true);
        if (!empty($film_rating)) {
            $imdb_rating = floatval($film_rating) + 0.1;
            if ($imdb_rating <= 10) {  // Ensure we don't exceed 10
                update_post_meta($post_id, 'imdbRating', $imdb_rating);
                return $imdb_rating;
            }
        }
        return false;
    }

    /**
     * Extract duration from post content and save as post meta
     */
    public static function extract_duration($post_id)
    {
        // Check if duration already exists
        $existing_duration = get_post_meta($post_id, 'duration', true);
        if (!empty($existing_duration)) {
            return $existing_duration;
        }

        // Get post content and strip HTML tags
        $content = wp_strip_all_tags(get_post_field('post_content', $post_id));

        // Look for duration in any format matching "Durata" followed by numbers and "min"
        if (preg_match('/Durata\s*:?\s*(\d+)\s*min/i', $content, $matches)) {
            $duration = intval($matches[1]);
            // Ensure duration is reasonable (between 1 and 999 minutes)
            if ($duration > 0 && $duration < 1000) {
                update_post_meta($post_id, 'duration', $duration);
                return $duration;
            }
        }

        return false;
    }

    /**
     * Extract YouTube trailer embed from post content and save as post meta
     */
    public static function extract_trailer($post_id)
    {
        // Check if trailer already exists
        $existing_trailer = get_post_meta($post_id, 'trailer', true);
        if (!empty($existing_trailer)) {
            return $existing_trailer;
        }

        // Get post content
        $content = get_post_field('post_content', $post_id);

        // Look for YouTube iframe embed
        if (preg_match('/<iframe[^>]*src=["\'](?:https?:)?\/\/(?:www\.)?youtube\.com\/embed\/([^"\'\?]+)[^"\']*["\'][^>]*>/', $content, $matches)) {
            $video_id = $matches[1];
            // Create clean embed URL
            $embed_url = 'https://www.youtube.com/embed/' . $video_id;
            // Save the embed URL
            update_post_meta($post_id, 'trailer', $embed_url);
            return $embed_url;
        }

        return false;
    }

    /**
     * Extract related movies from post content
     */
    public static function extract_related_movies($post_id)
    {
        // Check if related movies already exist
        $existing_movies = get_post_meta($post_id, 'related_movies', true);
        if (!empty($existing_movies)) {
            return $existing_movies;
        }

        // Get post content
        $content = get_post_field('post_content', $post_id);

        // Look for the widget div with related movies
        if (preg_match('/<div class="widget pt-2">\s*<h5>Alte recomandări[^<]*<\/h5>\s*<ul[^>]*>(.*?)<\/ul>/s', $content, $matches)) {
            $list_content = $matches[1];

            // Extract individual movies
            preg_match_all('/<li[^>]*>\s*<a href="([^"]+)"[^>]*>([^<]+)<\/a>\s*<\/li>/s', $list_content, $movie_matches, PREG_SET_ORDER);

            $movies = array();
            foreach ($movie_matches as $movie) {
                $movies[] = array(
                    'url' => $movie[1],
                    'title' => trim($movie[2])
                );
            }

            if (!empty($movies)) {
                update_post_meta($post_id, 'related_movies', $movies);
                return $movies;
            }
        }

        return false;
    }

    /**
     * Get movie year from taxonomy or extract from title
     * 
     * @param int $post_id The post ID
     * @return string|bool The movie year or false if not found
     */
    public static function get_movie_year($post_id)
    {
        // First check if year exists in taxonomy
        $terms = wp_get_post_terms($post_id, 'an');
        if (!empty($terms) && !is_wp_error($terms)) {
            $year = $terms[0]->name;
            update_post_meta($post_id, 'year', $year);
            return $year;
        }

        // Check if already stored in post meta
        $year = get_post_meta($post_id, 'year', true);
        if (!empty($year)) {
            // Add to taxonomy
            wp_set_post_terms($post_id, array($year), 'an', true);
            return $year;
        }

        // Try to extract from title
        $title = get_the_title($post_id);
        if (preg_match('/\((\d{4})\)$/', $title, $matches)) {
            $year = $matches[1];
            // Save to both meta and taxonomy
            update_post_meta($post_id, 'year', $year);
            wp_set_post_terms($post_id, array($year), 'an', true);
            return $year;
        }

        return false;
    }

    /**
     * Generate SEO-optimized image attributes for movie poster
     * 
     * @param string $movie_title The movie title
     * @param string|int $year The movie release year
     * @return array Array containing 'title' and 'alt' attributes
     */
    public static function generate_poster_image_attributes($movie_title, $year = '')
    {
        $base = sprintf(
            'Poster film %s%s - unul dintre cele mai bune filme noi',
            esc_html($movie_title),
            $year ? ' (' . esc_html($year) . ')' : ''
        );

        return array(
            'title' => $base,
            'alt' => $base
        );
    }
}
