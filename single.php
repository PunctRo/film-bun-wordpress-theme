<?php get_template_part('template-parts/header'); ?>

<?php
// Check if this is a noutati post to determine schema type
$post_id = get_the_ID();
$is_noutati = has_category('noutati', $post_id);
$schema_markup = $is_noutati ? '' : ' itemscope itemtype="https://schema.org/Movie"';
?>

<main class="bg-[#001f2d] text-[#f2f2f2] min-h-screen"<?php echo $schema_markup; ?>>
    <?php if (have_posts()) : while (have_posts()) : the_post();
            // Extract content once to be used by both templates
            $post_id = get_the_ID();
            global $film_content;
            $film_content = extract_post_content($post_id);
            $excerpt = get_movie_excerpt($post_id, $film_content);

            // Include both templates with the content
            get_template_part('template-parts/movie-header', null, ['excerpt' => $excerpt]);
            get_template_part('template-parts/single-content');
    ?>
        <?php endwhile;
    else : ?>
        <div class="max-w-4xl mx-auto px-4 py-8">
            <p class="text-center"><?php _e('No posts found.', 'textdomain'); ?></p>
        </div>
    <?php endif; ?>
</main>

<?php get_template_part('template-parts/footer'); ?>