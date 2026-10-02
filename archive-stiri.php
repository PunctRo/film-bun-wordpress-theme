<?php
// archive-stiri.php — /stiri listing: Antet B hero + single-column feed.
get_template_part('template-parts/header');
$hero  = news_archive_hero_image();
$intro = news_archive_intro();
?>
<main class="bg-[#001f2d] text-[#f2f2f2] min-h-screen">
    <section class="stiri-hero relative overflow-hidden" itemscope itemtype="https://schema.org/CollectionPage">
        <?php if ($hero) : ?>
            <img src="<?php echo esc_url($hero); ?>" alt="Știri despre filme"
                 class="absolute inset-0 w-full h-full object-cover" loading="eager" />
        <?php endif; ?>
        <div class="absolute inset-0" style="background: linear-gradient(to right, #001f2d 30%, rgba(0,31,45,.5) 75%, rgba(0,31,45,.25) 100%)"></div>
        <div class="absolute inset-0" style="background: linear-gradient(to top, #001f2d 0%, rgba(0,31,45,.6) 35%, transparent 65%)"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 min-h-[220px] sm:min-h-[300px] flex flex-col justify-end md:justify-center py-8">
            <div class="max-w-2xl">
                <div class="flex items-center gap-2.5 mb-3">
                    <span class="block w-6 h-px bg-white/50"></span>
                    <span class="text-white/60 text-[11px] uppercase tracking-[0.18em] font-semibold">Film-Bun · Actualitate</span>
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-3" style="text-shadow:0 2px 18px rgba(0,0,0,.6)" itemprop="name"><?php echo esc_html(news_archive_h1()); ?></h1>
                <?php if ($intro) : ?>
                    <p class="text-gray-200/90 text-sm sm:text-base leading-relaxed" itemprop="description"><?php echo wp_kses_post($intro); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-10">
        <?php if (have_posts()) : ?>
            <h2 class="sr-only">Lista de știri</h2>
            <div class="news-feed flex flex-col gap-4 sm:gap-5">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/news-card'); ?>
                <?php endwhile; ?>
            </div>
            <nav class="mt-8 flex items-center justify-center space-x-2" aria-label="Pagination">
                <?php get_template_part('template-parts/pagination'); ?>
            </nav>
        <?php else : ?>
            <p class="text-center py-12 text-lg">Momentan nu sunt știri.</p>
        <?php endif; ?>
    </section>
</main>
<?php get_template_part('template-parts/footer'); ?>
