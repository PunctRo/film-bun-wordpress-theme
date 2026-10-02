<?php
// single-stiri.php — individual news article (NewsArticle schema).
get_template_part('template-parts/header');
?>
<main class="bg-[#001f2d] text-[#f2f2f2] min-h-screen" itemscope itemtype="https://schema.org/NewsArticle">
    <?php if (have_posts()) : while (have_posts()) : the_post();
        $post_id  = get_the_ID();
        $topic    = news_get_topic($post_id);
        $thumb    = get_the_post_thumbnail_url($post_id, 'full');
        $thumb_id = get_post_thumbnail_id($post_id);
        // Image credit: editable per article via the featured image's WP caption
        // (e.g. "Foto: Netflix"); falls back to TMDB, where most stills come from.
        $thumb_credit = $thumb_id ? wp_get_attachment_caption($thumb_id) : '';
    ?>
        <article class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-10">
            <a href="<?php echo esc_url(get_post_type_archive_link('stiri')); ?>" class="flex w-fit items-center gap-1 text-sm text-cyan-400 hover:text-cyan-300 transition-colors mb-5">
                <span aria-hidden="true">&larr;</span> Înapoi la Știri
            </a>
            <?php if ($topic) : ?>
                <span class="inline-block text-[11px] font-bold uppercase tracking-wide text-white px-2.5 py-1 rounded-full mb-4"
                      style="background: <?php echo esc_attr(news_topic_badge_color($topic->slug)); ?>;">
                    <?php echo esc_html($topic->name); ?>
                </span>
            <?php endif; ?>
            <h1 class="text-2xl sm:text-4xl font-black text-white leading-tight mb-5" itemprop="headline"><?php the_title(); ?></h1>
            <?php if ($thumb) : ?>
                <figure class="mb-6">
                    <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full rounded-2xl" itemprop="image" loading="eager" />
                    <figcaption class="text-xs text-gray-500 text-right mt-1">
                        <?php if ($thumb_credit) : ?>
                            <?php echo wp_kses_post($thumb_credit); ?>
                        <?php else : ?>
                            Foto: <a href="https://www.themoviedb.org" target="_blank" rel="noopener noreferrer" class="hover:text-gray-400 transition-colors">TMDB</a>
                        <?php endif; ?>
                    </figcaption>
                </figure>
            <?php endif; ?>
            <div class="prose-news text-[15px] sm:text-base leading-relaxed text-gray-200 [&_p]:mb-4 [&_a]:text-cyan-400 [&_h2]:text-white [&_h2]:font-bold [&_h2]:text-xl [&_h2]:mt-6 [&_h2]:mb-3" itemprop="articleBody">
                <?php the_content(); ?>
            </div>
            <?php get_template_part('template-parts/news-related-films'); ?>
        </article>
    <?php endwhile; endif; ?>
</main>
<?php get_template_part('template-parts/footer'); ?>
