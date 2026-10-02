<?php

/**
 * Helper Functions
 * 
 * Global helper functions that bridge to class methods
 */

if (!function_exists('extract_film_rating')):
    function extract_film_rating($post_id)
    {
        return Movie_Metadata::extract_film_rating($post_id);
    }
endif;

if (!function_exists('extract_imdb_rating')):
    function extract_imdb_rating($post_id)
    {
        return Movie_Metadata::extract_imdb_rating($post_id);
    }
endif;

if (!function_exists('extract_duration')):
    function extract_duration($post_id)
    {
        return Movie_Metadata::extract_duration($post_id);
    }
endif;

if (!function_exists('extract_movie_poster')):
    function extract_movie_poster($post_id)
    {
        return Movie_Metadata::extract_poster($post_id);
    }
endif;

if (!function_exists('extract_trailer')):
    function extract_trailer($post_id)
    {
        return Movie_Metadata::extract_trailer($post_id);
    }
endif;

if (!function_exists('extract_related_movies')):
    function extract_related_movies($post_id)
    {
        return Movie_Metadata::extract_related_movies($post_id);
    }
endif;

if (!function_exists('get_recent_years')):
    function get_recent_years($count = 5)
    {
        return Movie_Taxonomies::get_recent_years($count);
    }
endif;

if (!function_exists('generate_movie_poster_attributes')):
    /**
     * Generate SEO-optimized image attributes for movie poster
     * 
     * @param string $movie_title The movie title
     * @param string|int $year Optional. The movie release year
     * @return array Array containing 'title' and 'alt' attributes
     */
    function generate_movie_poster_attributes($movie_title, $year = '')
    {
        return Movie_Metadata::generate_poster_image_attributes($movie_title, $year);
    }
endif;

if (!function_exists('get_movie_year')):
    /**
     * Get movie year from taxonomy or extract from title
     * 
     * @param int $post_id The post ID
     * @return string|bool The movie year or false if not found
     */
    function get_movie_year($post_id)
    {
        return Movie_Metadata::get_movie_year($post_id);
    }
endif;

/**
 * Get genre sprite class based on category slug
 * 
 * @param string $category_slug The slug of the category
 * @param string $size Optional size variant (default or sm)
 * @return string CSS class for the sprite
 */
function get_genre_sprite_class($category_slug, $size = '')
{
    $size_class = ($size === 'sm') ? 'genre-sprite-sm' : '';

    // Map category slugs to sprite classes
    $sprite_map = array(
        'drama' => 'genre-drama',
        'comedie' => 'genre-comedy',
        'horror' => 'genre-horror',
        'sf' => 'genre-sf',
        'dragoste' => 'genre-dragoste',
        'documentar' => 'genre-documentar',
        'filme-romanesti' => 'genre-romanian',
        'actiune' => 'genre-action',
        'thriller' => 'genre-thriller',
        // Add more mappings as needed
    );

    // Get the sprite class for this category, or default to drama if not found
    $sprite_class = isset($sprite_map[$category_slug]) ? $sprite_map[$category_slug] : 'genre-drama';

    return "genre-sprite $sprite_class $size_class";
}

if (!function_exists('format_text_with_wpautop')):
    /**
     * Formatează un text lung în paragrafe folosind wpautop, după gruparea propozițiilor.
     *
     * Această funcție împarte textul în propoziții, le grupează
     * (ex: câte 3 propoziții per paragraf), adaugă pauze de linie duple
     * între grupuri și apoi aplică funcția WordPress wpautop.
     *
     * @param string $text Textul original care trebuie formatat.
     * @param int $sentences_per_paragraph Numărul aproximativ de propoziții per paragraf. (Default: 3)
     * @return string Textul formatat cu tag-uri <p> și <br> de către wpautop.
     */
    function format_text_with_wpautop($text, $sentences_per_paragraph = 3)
    {
        // Verifică dacă textul de intrare nu este gol.
        if (empty($text)) {
            return '';
        }

        // Elimină spațiile albe de la începutul și sfârșitul textului.
        $text = trim($text);

        // Împarte textul în propoziții.
        // Folosim o expresie regulată care împarte după '.', '!', '?' urmate de spațiu sau sfârșit de linie.
        // PREG_SPLIT_DELIM_CAPTURE păstrează delimitatorii (punctuația) în array-ul rezultat.
        // PREG_SPLIT_NO_EMPTY elimină elementele goale.
        $sentences = preg_split('/([.!?])\s*/', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        // Verifică dacă împărțirea a funcționat.
        if (!is_array($sentences) || count($sentences) <= 1) {
            // Dacă împărțirea nu a reușit sau textul e prea scurt, aplicăm direct wpautop.
            // Poate textul nu are punctuația așteptată.
            return wpautop($text);
        }

        $grouped_text = '';
        $sentence_count = 0;
        $current_group = '';

        // Reconstruiește propozițiile și grupează-le.
        // Iterăm din 2 în 2 pentru că $sentences conține alternativ textul și delimitatorul.
        for ($i = 0; $i < count($sentences); $i += 2) {
            // Adaugă textul propoziției.
            $current_sentence = trim($sentences[$i]);
            // Adaugă delimitatorul (dacă există).
            if (isset($sentences[$i + 1])) {
                $current_sentence .= $sentences[$i + 1];
            }

            // Adaugă propoziția la grupul curent.
            $current_group .= $current_sentence . ' '; // Adaugă spațiu între propoziții
            $sentence_count++;

            // Dacă am atins numărul dorit de propoziții per paragraf SAU suntem la ultima propoziție
            if ($sentence_count >= $sentences_per_paragraph || $i >= count($sentences) - 2) {
                // Adaugă grupul curent la textul final, urmat de o pauză de linie dublă.
                $grouped_text .= trim($current_group) . "\n\n";
                // Resetează pentru următorul grup.
                $current_group = '';
                $sentence_count = 0;
            }
        }

        // Aplică wpautop pe textul reconstruit cu pauze de linie.
        $formatted_text = wpautop(trim($grouped_text));

        // Adaugă clasa pentru indentare la fiecare paragraf
        $formatted_text = str_replace('<p>', '<p class="indented-paragraph">', $formatted_text);

        // Returnează textul formatat.
        return $formatted_text;
    }
endif;
