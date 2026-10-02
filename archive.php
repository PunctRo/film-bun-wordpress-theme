<?php get_header(); ?>

<main>
    <header class="archive-header">
        <h1 class="archive-title"><?php the_archive_title(); ?></h1>
        <?php if (the_archive_description()) : ?>
            <div class="archive-description"><?php the_archive_description(); ?></div>
        <?php endif; ?>
    </header>
    <?php if (have_posts()) : ?>
        <div class="post-list">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content'); ?>
            <?php endwhile; ?>
        </div>
        <?php get_template_part('template-parts/pagination'); ?>
    <?php else : ?>
        <p><?php _e('No posts found.', 'textdomain'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>