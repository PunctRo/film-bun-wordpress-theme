<?php
// Include custom classes and functions
require_once get_template_directory() . '/includes/class-custom-nav-walker.php';
require_once get_template_directory() . '/includes/class-menu-generator.php';
require_once get_template_directory() . '/includes/class-movie-metadata.php';
require_once get_template_directory() . '/includes/class-movie-taxonomies.php';
require_once get_template_directory() . '/includes/class-category-header.php';
require_once get_template_directory() . '/includes/class-category-header-image.php';
require_once get_template_directory() . '/includes/class-tag-header.php';
require_once get_template_directory() . '/includes/class-actor-header.php';
require_once get_template_directory() . '/includes/class-director-header.php';
require_once get_template_directory() . '/includes/class-year-header.php';

// Include helper functions
require_once get_template_directory() . '/includes/helper-functions.php';
require_once get_template_directory() . '/includes/advertising-functions.php';
require_once get_template_directory() . '/includes/affiliate-functions.php';
require_once get_template_directory() . '/includes/search-functions.php';
require_once get_template_directory() . '/includes/content-processing.php';
require_once get_template_directory() . '/includes/shortcode-functions.php';
require_once get_template_directory() . '/includes/init.php';
require_once get_template_directory() . '/includes/setup.php';
require_once get_template_directory() . '/includes/enqueue-scripts.php';
require_once get_template_directory() . '/includes/redirects.php';

// Unique meta title and description for paginated custom-template pages (page 2+)
add_filter('rank_math/frontend/title', function ($title) {
    if (!is_page() || !is_paged()) {
        return $title;
    }
    $paged = intval(get_query_var('paged'));
    if ($paged < 2) {
        return $title;
    }
    $separator_pos = strrpos($title, ' | ');
    if ($separator_pos !== false) {
        return substr($title, 0, $separator_pos) . ' - Pagina ' . $paged . substr($title, $separator_pos);
    }
    return $title . ' - Pagina ' . $paged;
});

add_filter( 'rank_math/schema/validated_data', function ( $data ) {
    foreach ( $data as $key => $schema ) {
        if ( is_array( $schema ) && isset( $schema['@type'] ) && $schema['@type'] === 'VideoObject' ) {
            unset( $data[ $key ] );
        }
    }
    return $data;
} );

add_filter('rank_math/frontend/description', function ($description) {
    if (!is_page() || !is_paged()) {
        return $description;
    }
    $paged = intval(get_query_var('paged'));
    if ($paged < 2) {
        return $description;
    }
    return rtrim($description, '.') . '. Pagina ' . $paged . '.';
});

// /stiri archive: RankMath has no archive title/description set for the CPT, so it
// falls back to the generic "Știri Archive - Filme Bune". Override with editable copy.
add_filter('rank_math/frontend/title', function ($title) {
    return is_post_type_archive('stiri') ? news_archive_meta_title() : $title;
});
add_filter('rank_math/frontend/description', function ($description) {
    return is_post_type_archive('stiri') ? news_archive_meta_description() : $description;
});
