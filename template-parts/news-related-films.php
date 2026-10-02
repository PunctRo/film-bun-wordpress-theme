<?php
// template-parts/news-related-films.php — "Filmul din articol" (in-article only).
$ids = news_get_related_film_ids(get_the_ID());
if (empty($ids)) {
    return;
}
?>
<section class="news-related mt-10 bg-[#012634] border border-white/10 rounded-2xl p-5 sm:p-6">
    <p class="text-xs uppercase tracking-[0.14em] text-gray-400 font-bold mb-4">Filmul din articol</p>
    <div class="flex flex-col gap-4">
        <?php foreach ($ids as $film_id) :
            $film = get_post($film_id);
            if (!$film || $film->post_status !== 'publish') { continue; }
            $poster = Movie_Metadata::extract_poster($film_id);
            $rating = get_post_meta($film_id, 'filmRating', true);
            $imdb   = get_post_meta($film_id, 'imdbRating', true);
            $year_terms = get_the_terms($film_id, 'an');
            $year = (!empty($year_terms) && !is_wp_error($year_terms)) ? $year_terms[0]->name : '';
        ?>
            <div class="flex gap-4 items-stretch">
                <div class="shrink-0 w-[84px] h-[124px] rounded-lg overflow-hidden bg-[#01313f]">
                    <?php if ($poster) : ?>
                        <img src="<?php echo esc_url($poster); ?>" alt="<?php echo esc_attr(get_the_title($film_id)); ?>" class="w-full h-full object-cover" loading="lazy" width="84" height="124" />
                    <?php endif; ?>
                </div>
                <div class="flex flex-col gap-1.5 min-w-0 flex-1">
                    <h3 class="text-base sm:text-lg font-extrabold text-white">
                        <?php echo esc_html(get_the_title($film_id)); ?>
                        <?php if ($year) : ?><span class="text-gray-400 font-semibold">(<?php echo esc_html($year); ?>)</span><?php endif; ?>
                    </h3>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <?php if ($rating) : ?><span class="text-cyan-400 font-bold">★ <?php echo esc_html($rating); ?> Film-Bun</span><?php endif; ?>
                        <?php if ($imdb) : ?><span>IMDb <?php echo esc_html($imdb); ?></span><?php endif; ?>
                    </div>
                    <a href="<?php echo esc_url(get_permalink($film_id)); ?>" class="news-related__cta mt-auto self-start inline-block bg-gradient-to-r from-cyan-400 to-blue-500 text-white font-bold text-sm rounded-full px-4 py-1.5 transition-all duration-300 hover:scale-105">Detalii film →</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
