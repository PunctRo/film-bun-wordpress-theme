<?php
// template-parts/news-card.php — one news card (refined Option A). No date, no film link.
$post_id   = get_the_ID();
$topic     = news_get_topic($post_id);
$thumb     = get_the_post_thumbnail_url($post_id, 'large');
$excerpt   = get_the_excerpt($post_id);
?>
<a href="<?php the_permalink(); ?>" class="news-card block rounded-xl">
    <article class="news-card__inner flex flex-col sm:flex-row bg-[#002a3a] rounded-xl overflow-hidden shadow-lg border border-transparent transition-all duration-300 hover:bg-[#003a52] hover:border-cyan-400/30">
        <div class="relative sm:w-[40%] sm:max-w-[280px] aspect-[16/9] sm:aspect-auto shrink-0">
            <?php if ($topic) : ?>
                <span class="news-card__badge absolute top-2.5 left-2.5 z-10 text-[11px] font-bold uppercase tracking-wide text-white px-2.5 py-1 rounded-full shadow-md"
                      style="background: <?php echo esc_attr(news_topic_badge_color($topic->slug)); ?>;">
                    <?php echo esc_html($topic->name); ?>
                </span>
            <?php endif; ?>
            <?php if ($thumb) : ?>
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                     class="w-full h-full object-cover" loading="lazy" width="600" height="338" />
            <?php else : ?>
                <div class="w-full h-full bg-gradient-to-br from-[#01313f] to-[#002a3a]"></div>
            <?php endif; ?>
        </div>
        <div class="flex flex-col gap-2.5 p-4 sm:p-5 flex-1 min-w-0">
            <h2 class="news-card__title text-lg font-extrabold leading-tight text-white line-clamp-2"><?php the_title(); ?></h2>
            <?php
            // On search pages the get_the_excerpt filter already wraps matched terms in
            // <mark> (see includes/search-functions.php), so output it unescaped like the
            // title; escaping here would print the markup as literal text. Escape otherwise.
            ?>
            <p class="text-sm leading-relaxed text-gray-300 line-clamp-2"><?php echo is_search() ? $excerpt : esc_html($excerpt); ?></p>
            <span class="mt-auto self-end text-sm font-bold text-cyan-400">Citește articolul →</span>
        </div>
    </article>
</a>
