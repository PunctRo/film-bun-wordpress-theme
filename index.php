<?php 
get_template_part('template-parts/header'); ?>

<main>
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