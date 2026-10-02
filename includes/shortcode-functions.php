<?php

/**
 * Shortcode Functions
 *
 * @package Film_Bun
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get posts organized by year for a specific category and tag
 *
 * @param string $category Category name.
 * @param string $tag Tag slug.
 * @return array Posts organized by year.
 */
function get_posts_by_category_and_tag($category, $tag)
{
    $args = array(
        'category_name' => $category,
        'tag' => $tag,
        'post_status' => 'publish',
        'numberposts' => -1
    );
    $posts = get_posts($args);

    // Create an array to store the posts by year
    $posts_by_year = array();
    foreach ($posts as $post) {
        if (in_array($post->ID, [1929, 110])) {
            continue;
        }
        // Try to get the value of the 'an' taxonomy for the post
        $year = wp_get_object_terms($post->ID, 'an');
        if (!empty($year)) {
            // If the 'an' taxonomy is not empty, use its value as the year
            $year = $year[0]->name;
        } else {
            // If the 'an' taxonomy is empty, extract the year from the post title
            preg_match('/\b(19\d{2}|20\d{2})\b/', $post->post_title, $matches);
            if (isset($matches[1])) {
                $year = $matches[1];
            }
        }
        // If a year was found, add the post to the array for the year
        if (isset($year)) {
            // If this is the first post for this year, create an array for the year
            if (!isset($posts_by_year[$year])) {
                $posts_by_year[$year] = array();
            }
            // Add the post to the array for the year
            $posts_by_year[$year][] = $post;
        }
    }

    // Sort the years in ascending order
    krsort($posts_by_year);

    foreach ($posts_by_year as $year => &$posts) {
        usort($posts, function ($a, $b) {
            // Extract rating and ensure it's interpreted as float
            $ratingA = floatval(get_post_meta($a->ID, 'filmRating', true));
            $ratingB = floatval(get_post_meta($b->ID, 'filmRating', true));

            // Check if ratings are equal
            if ($ratingA == $ratingB) {
                return 0;
            }

            // Return 1 or -1 to determine descending order
            return ($ratingA < $ratingB) ? 1 : -1;
        });
    }

    return $posts_by_year;
}

/**
 * Shortcode handler for displaying posts by category and tag
 *
 * @param array $atts Shortcode attributes.
 * @return string Generated HTML content.
 */
function get_posts_by_category_and_tag_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'category' => '',
        'tag' => ''
    ), $atts, 'get_posts_by_category_and_tag');

    $category = $atts['category'];
    $tag = $atts['tag'];

    // Call the function to get posts organized by year
    $posts_by_year = get_posts_by_category_and_tag($category, $tag);

    $output = '';

    foreach ($posts_by_year as $year => $posts) {
        $output .= '<h2>Top Filme de Dragoste din ' . esc_html($year) . ' pe Netflix</h2>';
        $output .= '<ul style="margin: 0;">';

        $place = 1;
        foreach ($posts as $post) {
            $title = get_the_title($post->ID);
            $rating = get_post_meta($post->ID, 'filmRating', true);
            $permalink = get_the_permalink($post->ID);
            $preview = wp_trim_words($post->post_content, 55);

            // Clean up the preview text by removing rating and duration info
            $pattern2 = '/\[xrr rating=[0-9]+(\.[0-9]+)?\/10\].*?Durata\s*:\s*[0-9]{1,3}\s*min/';
            $preview2 = preg_replace($pattern2, '', $preview);

            $pattern3 = '/\[film_bun_rating rating="[^"]+"\] Nota IMDB \*:.*?Durata : \d+ min/';
            $cleanedString = preg_replace($pattern3, '', $preview2);
            $cleanedString2 = preg_replace('/^.*\d+\s+min\s+/', '', $cleanedString);

            // Get the first embedded image
            $content = apply_filters('the_content', $post->post_content);
            preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $image_matches);

            $image = '';
            if (isset($image_matches[1])) {
                $image_index = (strpos($image_matches[1][0], 'rating') === false) ? 0 : (isset($image_matches[1][1]) ? 1 : 0);
                $image = sprintf(
                    '<img src="%s" class="attachment-full size-full wp-post-image" alt="%s" title="%s" width="150" height="222" style="max-width: 150px;" />',
                    esc_url($image_matches[1][$image_index]),
                    esc_attr($title . ' - Film De Dragoste'),
                    esc_attr($title . ' - Film De Dragoste')
                );
            }

            $output .= '<li class="list-item">';
            $output .= sprintf('<a href="%s" title="%s">%s</a>', esc_url($permalink), esc_attr($title), $image);
            $output .= '<div class="preview-text">';
            $output .= sprintf(
                '<a href="%s" title="%s"><h3>%d. %s</h3></a>',
                esc_url($permalink),
                esc_attr($title),
                $place,
                esc_html($title)
            );
            $output .= '<p><b>Nota: </b>' . esc_html($rating) . '</p>';
            $output .= '<p>' . wp_kses_post($cleanedString2) . '</p>';
            $output .= '</div></li>';
            $place++;
        }
        $output .= '</ul>';
    }

    return $output;
}

/**
 * Get the first embedded image from content
 *
 * @param string $content Post content.
 * @return string Image HTML or empty string.
 */
function get_first_embedded_image($content)
{
    preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
    if (isset($matches[1][0])) {
        return sprintf(
            '<img src="%s" class="embedded-image">',
            esc_url($matches[1][0])
        );
    }
    return '';
}

/**
 * Shortcode handler for displaying top rated films by year
 *
 * @param array $atts Shortcode attributes.
 * @return string Generated HTML content.
 */
function top_rated_films_by_year_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'year' => '2022',
    ), $atts);

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 10,
        'meta_key' => 'filmRating',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'an',
                'field' => 'name',
                'terms' => $atts['year'],
            ),
        ),
    );

    $the_query = new WP_Query($args);
    $output = '';

    if ($the_query->have_posts()) {
        $output .= '<ul class="top-rated-films">';
        $position = 0;

        while ($the_query->have_posts()) {
            $position++;
            $the_query->the_post();

            $title = get_the_title();
            $rating = get_post_meta(get_the_ID(), 'filmRating', true);
            $permalink = get_the_permalink();
            $content = get_the_content();
            $preview = wp_trim_words($content, 55);

            // Clean up preview text
            $pattern2 = '/\[xrr rating=[0-9]+(\.[0-9]+)?\/10\].*?Durata\s*:\s*[0-9]{1,3}\s*min/';
            $preview2 = preg_replace($pattern2, '', $preview);

            $pattern3 = '/\[film_bun_rating rating="[^"]+"\] Nota IMDB \*:.*?Durata : \d+ min/';
            $cleanedString = preg_replace($pattern3, '', $preview2);
            $cleanedString2 = preg_replace('/^.*\d+\s+min\s+/', '', $cleanedString);

            // Get the first embedded image
            $content = apply_filters('the_content', $content);
            preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $image_matches);

            $image = '';
            if (isset($image_matches[1])) {
                $image_index = (strpos($image_matches[1][0], 'rating') === false) ? 0 : (isset($image_matches[1][1]) ? 1 : 0);
                $image = sprintf(
                    '<img src="%s" class="attachment-full size-full wp-post-image" alt="%s" title="%s" style="max-width: 150px;" width="150" height="222"/>',
                    esc_url($image_matches[1][$image_index]),
                    esc_attr($title),
                    esc_attr($title)
                );
            }

            $output .= '<li class="list-item">';
            $output .= sprintf('<a href="%s" title="%s">%s</a>', esc_url($permalink), esc_attr($title), $image);
            $output .= '<div class="preview-text">';
            $output .= sprintf(
                '<a href="%s" title="%s"><h2>%d. %s</h2></a>',
                esc_url($permalink),
                esc_attr($title),
                $position,
                esc_html($title)
            );
            $output .= '<p><b>Nota: </b>' . esc_html($rating) . '</p>';
            $output .= '<p>' . wp_kses_post($cleanedString2) . '</p>';
            $output .= '</div></li>';
        }

        $output .= '</ul>';
        wp_reset_postdata();
    } else {
        $output = '<p>No top-rated films found for the year ' . esc_html($atts['year']) . '.</p>';
    }

    return $output;
}

/**
 * Shortcode: [top_filme]
 *
 * Generates a dynamic top-N films list ordered by filmRating meta.
 * Includes Schema.org ItemList markup, excerpt, genre badges, CTA, and update date.
 *
 * Attributes:
 *   gen       — Category slug (e.g. "dragoste", "horror", "actiune")
 *   platforma — Tag slug for streaming platform (e.g. "netflix", "max")
 *   an        — Year filter, e.g. "2024" (filters by post publication year)
 *   count     — Number of films to display (default: 10, max: 50)
 *   titlu     — List title for Schema.org (e.g. "Top 10 Filme de Dragoste")
 *
 * Examples:
 *   [top_filme gen="dragoste" count="10" titlu="Top 10 Filme de Dragoste"]
 *   [top_filme gen="sf" platforma="netflix" count="5" titlu="Top 5 Filme SF pe Netflix"]
 *   [top_filme platforma="netflix" count="10" titlu="Top 10 Filme pe Netflix"]
 */
add_shortcode('top_filme', function ($atts) {
    $a = shortcode_atts([
        'gen'       => '',
        'platforma' => '',
        'an'        => '',
        'count'     => 10,
        'titlu'     => '',
    ], $atts, 'top_filme');

    $count = max(1, min(50, intval($a['count'])));
    $gen   = sanitize_text_field($a['gen']);
    $plat  = sanitize_text_field($a['platforma']);
    $an    = sanitize_text_field($a['an']);
    $titlu = sanitize_text_field($a['titlu']) ?: get_the_title();

    $query_args = [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $count,
        'meta_key'       => 'filmRating',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    ];

    $tax_query = [];
    if ($gen) {
        $tax_query[] = [
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $gen,
        ];
    }
    if ($plat) {
        $tax_query[] = [
            'taxonomy' => 'post_tag',
            'field'    => 'slug',
            'terms'    => $plat,
        ];
    }
    if (count($tax_query) > 1) {
        $tax_query['relation'] = 'AND';
    }
    if ($tax_query) {
        $query_args['tax_query'] = $tax_query;
    }

    if ($an && is_numeric($an)) {
        $query_args['date_query'] = [['year' => intval($an)]];
    }

    $posts = get_posts($query_args);

    if (empty($posts)) {
        return '<p class="top-filme-empty">Nu am găsit filme pentru această selecție.</p>';
    }

    // ── Schema.org JSON-LD ────────────────────────────────────────────────────
    $schema_items = [];
    foreach ($posts as $i => $post) {
        $rating = get_post_meta($post->ID, 'filmRating', true);
        $item   = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'item'     => [
                '@type' => 'Movie',
                'name'  => get_the_title($post->ID),
                'url'   => get_permalink($post->ID),
            ],
        ];
        if ($rating) {
            $item['item']['aggregateRating'] = [
                '@type'       => 'AggregateRating',
                'ratingValue' => (float) $rating,
                'bestRating'  => 10,
                'worstRating' => 1,
                'ratingCount' => 1,
            ];
        }
        $schema_items[] = $item;
    }
    $schema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'ItemList',
        'name'            => $titlu,
        'itemListElement' => $schema_items,
    ];
    $html = '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';

    // ── Inline styles (self-contained, no build dependency) ──────────────────
    $html .= '
<style>
.top-filme-list,.static-page .top-filme-list{list-style:none;padding:0!important;margin:0!important}
.top-filme-item{display:flex;align-items:flex-start;gap:14px;padding:14px 0;border-bottom:1px solid rgba(255,255,255,.08)}
.top-filme-item:last-child{border-bottom:none}
.top-filme-rank{font-size:1.4rem;font-weight:800;color:rgba(255,255,255,.2);min-width:30px;text-align:right;flex-shrink:0;padding-top:2px}
.top-filme-thumb{flex-shrink:0;display:block;line-height:0;border:none!important;padding:0!important}
.top-filme-thumb img{width:70px!important;height:105px!important;object-fit:cover;border-radius:4px;display:block}
.top-filme-info{display:flex;flex-direction:column;gap:4px;min-width:0;flex:1}
.top-filme-header{display:flex;flex-wrap:wrap;align-items:baseline;gap:6px}
.top-filme-title{font-size:.95rem;font-weight:600;color:#f2f2f2!important;text-decoration:none!important;border:none!important;padding:0!important}
.top-filme-title:hover{color:#22d3ee!important}
.top-filme-year{font-size:.78rem;color:rgba(255,255,255,.4)}
.top-filme-rating{font-size:.85rem;color:#fbbf24;font-weight:600;margin-left:auto}
.top-filme-genres{display:flex;flex-wrap:wrap;gap:4px}
.top-filme-genre{font-size:.7rem;font-weight:600;padding:2px 7px;border-radius:20px;background:rgba(34,211,238,.15);color:#22d3ee;text-transform:uppercase;letter-spacing:.04em}
.top-filme-excerpt{font-size:.82rem;color:rgba(255,255,255,.55);margin:0;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.top-filme-cta{font-size:.8rem;font-weight:600;color:#22d3ee!important;text-decoration:none!important;border:none!important;padding:0!important;align-self:flex-start}
.top-filme-cta:hover{text-decoration:underline!important}
.top-filme-updated{font-size:.75rem;color:rgba(255,255,255,.3);margin-top:12px;text-align:right}
.top-filme-platforms{display:flex;align-items:center;gap:4px;margin-left:auto}
.top-filme-platform-icon{height:16px;width:auto;object-fit:contain;border-radius:3px}
@media(max-width:480px){
.top-filme-item{gap:10px;padding:12px 0}
.top-filme-rank{font-size:1.1rem;min-width:22px}
.top-filme-thumb img{width:55px!important;height:83px!important}
.top-filme-title{font-size:.88rem}
.top-filme-excerpt{font-size:.78rem}
.top-filme-cta{font-size:.76rem}
}
</style>';

    // ── Platform icon map ────────────────────────────────────────────────────
    $platform_icons = [
        'netflix'           => ['img' => 'Filme-Online-Pe-Netflix.webp',          'alt' => 'Netflix'],
        'hbo-max'           => ['img' => 'Filme-Online-Pe-Max.webp',               'alt' => 'Max'],
        'amazonprimevideo'  => ['img' => 'Filme-Online-Pe-Amazonprimevideo.webp',  'alt' => 'Amazon Prime Video'],
        'amazon-prime-video'=> ['img' => 'Filme-Online-Pe-Amazonprimevideo.webp',  'alt' => 'Amazon Prime Video'],
        'disneyplus'        => ['img' => 'Filme-Online-Pe-DisneyPlus.webp',        'alt' => 'Disney+'],
        'disney-plus'       => ['img' => 'Filme-Online-Pe-DisneyPlus.webp',        'alt' => 'Disney+'],
        'skyshowtime'       => ['img' => 'Filme-Online-Pe-SkyShowtime.webp',       'alt' => 'SkyShowtime'],
    ];
    $img_base = get_template_directory_uri() . '/assets/images/';

    // ── Film list ─────────────────────────────────────────────────────────────
    $html .= '<ol class="top-filme-list">';
    foreach ($posts as $i => $post) {
        $rating  = get_post_meta($post->ID, 'filmRating', true);
        $url     = get_permalink($post->ID);
        $title   = get_the_title($post->ID);
        $raw     = get_post_field('post_content', $post->ID);
        $raw     = preg_replace('/\[xrr rating=[0-9]+(\.[0-9]+)?\/10\].*?Durata\s*:\s*[0-9]{1,3}\s*min/s', '', $raw);
        $raw     = preg_replace('/\[film_bun_rating rating="[^"]+"\]\s*Nota IMDB\s*\*?\s*:.*?Durata\s*:\s*\d+\s*min/s', '', $raw);
        $raw     = preg_replace('/^.*?\d+\s+min\s*/s', '', $raw);
        $excerpt = wp_strip_all_tags(strip_shortcodes($raw));
        $excerpt = wp_trim_words($excerpt, 20);
        if (strlen($excerpt) > 120) {
            $excerpt = mb_substr($excerpt, 0, 117) . '...';
        }

        // Poster from movie_poster meta (fallback: WP thumbnail)
        $poster_url = extract_movie_poster($post->ID);
        $thumb_html = '';
        if ($poster_url) {
            $thumb_html = '<a href="' . esc_url($url) . '" class="top-filme-thumb" tabindex="-1" aria-hidden="true">'
                . '<img src="' . esc_url($poster_url) . '" alt="' . esc_attr($title) . '" width="70" height="105" loading="lazy">'
                . '</a>';
        }

        // Genre badges (max 2, exclude Uncategorized, main genre always first)
        $genres     = get_the_terms($post->ID, 'category') ?: [];
        $genre_html = '';
        $shown      = 0;

        // Show the main genre (from shortcode 'gen' attribute) first
        if ($gen) {
            foreach ($genres as $genre) {
                if ($genre->slug === $gen) {
                    $genre_html .= '<span class="top-filme-genre">' . esc_html($genre->name) . '</span>';
                    $shown++;
                    break;
                }
            }
        }

        foreach ($genres as $genre) {
            if ($shown >= 2) break;
            if (strtolower($genre->name) === 'uncategorized') continue;
            if ($gen && $genre->slug === $gen) continue; // already shown above
            $genre_html .= '<span class="top-filme-genre">' . esc_html($genre->name) . '</span>';
            $shown++;
        }

        $html .= '<li class="top-filme-item">';
        $html .= '<span class="top-filme-rank" aria-label="Locul ' . ($i + 1) . '">' . ($i + 1) . '</span>';
        $html .= $thumb_html;

        $html .= '<div class="top-filme-info">';

        $html .= '<div class="top-filme-header">';
        $html .= '<a href="' . esc_url($url) . '" class="top-filme-title">' . esc_html($title) . '</a>';
        if ($rating) {
            $html .= '<span class="top-filme-rating">&#11088; ' . esc_html(number_format((float) $rating, 1)) . '</span>';
        }
        $html .= '</div>';

        // Platform icons
        $post_tags    = get_the_terms($post->ID, 'post_tag') ?: [];
        $plat_html    = '';
        $shown_plats  = [];
        foreach ($post_tags as $tag) {
            $slug = $tag->slug;
            if (isset($platform_icons[$slug]) && !in_array($platform_icons[$slug]['img'], $shown_plats)) {
                $p = $platform_icons[$slug];
                $plat_html .= '<img src="' . esc_url($img_base . $p['img']) . '" alt="' . esc_attr($p['alt']) . '" title="' . esc_attr($p['alt']) . '" class="top-filme-platform-icon" width="40" height="20" loading="lazy">';
                $shown_plats[] = $platform_icons[$slug]['img'];
            }
        }

        if ($genre_html || $plat_html) {
            $html .= '<div class="top-filme-genres">' . $genre_html;
            if ($plat_html) {
                $html .= '<span class="top-filme-platforms">' . $plat_html . '</span>';
            }
            $html .= '</div>';
        }
        if ($excerpt) {
            $html .= '<p class="top-filme-excerpt">' . esc_html($excerpt) . '</p>';
        }

        $html .= '<a href="' . esc_url($url) . '" class="top-filme-cta" aria-label="Citește recenzia ' . esc_attr($title) . '">&#8594; Citește recenzia</a>';
        $html .= '</div>'; // .top-filme-info
        $html .= '</li>';
    }
    $html .= '</ol>';

    $html .= '<p class="top-filme-updated">Actualizat: ' . date_i18n('F Y') . '</p>';

    return $html;
});

// Register shortcodes
add_shortcode('get_posts_by_category_and_tag', 'get_posts_by_category_and_tag_shortcode');
add_shortcode('top_rated_films_by_year', 'top_rated_films_by_year_shortcode');
