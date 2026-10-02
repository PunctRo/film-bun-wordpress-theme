<?php get_template_part('template-parts/header'); ?>

<main class="bg-[#001f2d] text-[#f2f2f2] min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4">
        <?php while (have_posts()) : the_post(); ?>
            <article class="bg-[#002a3a] rounded-xl shadow-lg p-8 border border-cyan-400/30">
                <!-- Page Title -->
                <h1 class="text-3xl md:text-4xl font-bold mb-8 text-white leading-tight"><?php the_title(); ?></h1>

                <!-- Content Container -->
                <div class="static-page">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_template_part('template-parts/footer'); ?>