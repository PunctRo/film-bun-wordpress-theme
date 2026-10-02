<?php
// includes/news-functions.php

/** Topic slug → badge color (single source of truth for the badge). */
function news_topic_badge_color($slug)
{
    $map = [
        'trailer'   => '#7c3aed',
        'streaming' => '#0e7490',
        'premiera'  => '#b91c1c',
        'editorial' => '#a16207',
    ];
    return isset($map[$slug]) ? $map[$slug] : '#003a61';
}

/** Comma-separated string → array of positive, deduped ints (order preserved). */
function news_parse_related_ids($raw)
{
    $raw = str_replace(['[', ']'], '', (string) $raw);
    $ids = [];
    foreach (explode(',', $raw) as $part) {
        $n = (int) trim($part);
        if ($n > 0 && !in_array($n, $ids, true)) {
            $ids[] = $n;
        }
    }
    return $ids;
}

// The functions below need WordPress; skip when running the standalone unit test.
if (defined('NEWS_FUNCTIONS_TEST')) {
    return;
}

/** First news_topic term for a post, or null. */
function news_get_topic($post_id)
{
    $terms = get_the_terms($post_id, News_Post_Type::TAXONOMY);
    return (!empty($terms) && !is_wp_error($terms)) ? $terms[0] : null;
}

/** Related movie post IDs for a news post. */
function news_get_related_film_ids($post_id)
{
    return news_parse_related_ids(get_post_meta($post_id, 'related_films', true));
}

/** Archive header copy + hero, editable via Customizer (Task 6); verbatim defaults. */
function news_archive_h1()
{
    return get_theme_mod('stiri_h1', 'Știri despre filme');
}
function news_archive_intro()
{
    return get_theme_mod('stiri_intro', 'Premiere, trailere noi, ce apare pe Netflix și HBO Max, și recomandările echipei Film-Bun — toate într-un singur loc.');
}
function news_archive_hero_image()
{
    return get_theme_mod('stiri_hero_image', '');
}

/** SEO <title> for the /stiri archive (also feeds og:title), editable via Customizer. */
function news_archive_meta_title()
{
    return get_theme_mod('stiri_meta_title', 'Știri despre Filme: Premiere, Trailere, Noutăți | Film-Bun');
}

/** SEO meta description for the /stiri archive (also feeds og:description), editable via Customizer. */
function news_archive_meta_description()
{
    return get_theme_mod('stiri_meta_description', 'Știri despre filme: premiere, trailere noi, ce apare pe Netflix și HBO Max și recomandările echipei Film-Bun. Toate noutățile din lumea filmului.');
}
