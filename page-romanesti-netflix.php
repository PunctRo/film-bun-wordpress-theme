<?php
/*
Template Name: Românești Online Netflix
*/

/**
 * @var WP_Query $wp_query WordPress main query object
 */

get_template_part('template-parts/header');

// Get current page for pagination
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// Get static page content
$page_static_content = '';
if (have_posts()) {
    the_post();
    $page_static_content = get_the_content();
}

?>
<main id="main-content" role="main" itemscope itemtype="https://schema.org/CollectionPage" class="bg-[#001f2d] text-[#f2f2f2] min-h-screen py-12">
    <?php
    // Display static content
    if (!empty($page_static_content)) {
        echo '<div class="max-w-4xl mx-auto px-4">';
        echo '<article class="bg-[#002a3a] rounded-xl shadow-lg p-8 border border-cyan-400/30">';
        if ($paged < 2) {
            echo '<div class="static-page prose prose-invert">';
            echo apply_filters('the_content', $page_static_content);
            echo '</div>';
        } else {
            echo '<div class="border-b border-cyan-400/20 pb-5 mb-2">';
            echo '<h1 class="text-2xl sm:text-3xl font-black leading-tight">';
            echo '<span class="bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">Filme Românești Netflix</span>';
            echo ' <span class="text-[#f2f2f2]">– Pagina ' . intval($paged) . '</span>';
            echo '</h1>';
            echo '<p class="text-gray-400 text-sm mt-2">Continuare listă • <a href="/filme-romanesti-netflix" class="text-cyan-400 hover:underline">← Înapoi la pagina 1</a></p>';
            echo '</div>';
        }
        echo '</article>';
        echo '</div>';
    }

    // Query posts
    $args = array(
        'category_name' => 'romanesti',
        'tag'          => 'netflix',
        'paged'        => $paged,
        'post_type'    => 'post'
    );

    $custom_query = new WP_Query($args);

    // Set temporary query
    $temp_query = $wp_query;
    $wp_query   = $custom_query;
    ?>

    <section id="movies-list" class="mt-8">
        <div class="max-w-6xl mx-auto px-4">
            <?php if ($custom_query->have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" itemprop="about" itemscope itemtype="https://schema.org/ItemList">
                    <?php while ($custom_query->have_posts()) :
                        $custom_query->the_post();
                        get_template_part('template-parts/content');
                    endwhile; ?>
                </div>
                <nav class="mt-8 flex items-center justify-center space-x-2" aria-label="Navigare pagini" role="navigation">
                    <?php get_template_part('template-parts/pagination'); ?>
                </nav>
            <?php else : ?>
                <p class="text-center py-8">Nu au fost găsite filme care să corespundă criteriilor.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
// Restore original query
$wp_query = $temp_query;
wp_reset_postdata();

get_template_part('template-parts/footer');
