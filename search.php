<?php
get_template_part('template-parts/header');

// Get search query and results count
$search_query = get_search_query();
$total_results = $wp_query->found_posts;

// Fallback search: if no results and query has multiple words, try first meaningful word
$fallback_query = null;
$fallback_posts = null;

if ($total_results === 0 && !empty($search_query)) {
    $words = array_values(array_filter(explode(' ', $search_query), function($w) {
        return strlen($w) >= 3;
    }));

    if (count($words) >= 2) {
        $fallback_query = $words[0];
        $fallback_posts = new WP_Query([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            's'              => $fallback_query,
            'posts_per_page' => 6,
        ]);
        if (!$fallback_posts->have_posts()) {
            $fallback_query = null;
            $fallback_posts = null;
        }
    }
}

// News results: separate query, shown first, only on page 1 (so they don't repeat across movie pagination)
$paged = max(1, (int) get_query_var('paged'));
$news_query = null;
if ($paged === 1 && $search_query !== '') {
    $nq = new WP_Query([
        'post_type'      => 'stiri',
        'post_status'    => 'publish',
        's'              => $search_query,
        'posts_per_page' => 6,
    ]);
    if ($nq->have_posts()) {
        $news_query = $nq;
    }
}
$display_total = $total_results + ($news_query ? (int) $news_query->found_posts : 0);
?>

<main>
    <section class="bg-[#001f2d] text-[#f2f2f2] py-8">
        <div class="max-w-6xl mx-auto px-4">
            <div class="prose prose-invert mx-auto">
                <h1 class="text-3xl font-bold text-center mb-4">
                    <?php
                    if ($display_total > 0) {
                        printf(
                            esc_html(_n(
                                '%d rezultat pentru "%s"',
                                '%d rezultate pentru "%s"',
                                $display_total,
                                'textdomain'
                            )),
                            $display_total,
                            esc_html($search_query)
                        );
                    } else {
                        printf(
                            esc_html__('Nu am găsit rezultate pentru "%s"', 'textdomain'),
                            esc_html($search_query)
                        );
                    }
                    ?>
                </h1>

                <div class="max-w-2xl mx-auto mb-8">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="relative">
                            <input type="search"
                                class="w-full px-6 py-3 text-white bg-[#002a3a] rounded-lg focus:ring-2 focus:ring-cyan-400 focus:outline-none placeholder-gray-400"
                                placeholder="<?php echo esc_attr_x('Caută filme...', 'placeholder', 'textdomain'); ?>"
                                value="<?php echo esc_attr($search_query); ?>"
                                name="s" />
                            <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 p-2 hover:bg-[#003a52] rounded-full transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-10 bg-[#001f2d] text-[#f2f2f2]">
        <div class="max-w-6xl mx-auto px-4">
            <?php if ($news_query) : ?>
                <div class="flex items-center gap-2.5 mb-4">
                    <span class="block w-6 h-px bg-white/40"></span>
                    <span class="text-white/55 text-[11px] uppercase tracking-[0.18em] font-semibold">Știri</span>
                    <span class="text-white/35 text-[11px]">(<?php echo (int) $news_query->found_posts; ?>)</span>
                </div>
                <div class="news-feed flex flex-col gap-4 sm:gap-5 mb-10">
                    <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                        <?php get_template_part('template-parts/news-card'); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>

            <?php if (have_posts()) : ?>
                <?php if ($news_query) : ?>
                    <div class="flex items-center gap-2.5 mb-4">
                        <span class="block w-6 h-px bg-white/40"></span>
                        <span class="text-white/55 text-[11px] uppercase tracking-[0.18em] font-semibold">Filme</span>
                        <span class="text-white/35 text-[11px]">(<?php echo (int) $total_results; ?>)</span>
                    </div>
                <?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/content'); ?>
                    <?php endwhile; ?>
                </div>
                <nav class="mt-8 flex items-center justify-center space-x-2" aria-label="Pagination">
                    <?php get_template_part('template-parts/pagination'); ?>
                </nav>

            <?php elseif ($fallback_posts) : ?>
                <?php
                // Fallback results
                printf(
                    '<p class="text-gray-400 mb-6">Nu am găsit rezultate pentru <strong class="text-white">%s</strong>. Iată rezultate pentru <a href="%s" class="text-cyan-400 hover:underline"><strong>%s</strong></a>:</p>',
                    esc_html($search_query),
                    esc_url(home_url('/?s=' . urlencode($fallback_query))),
                    esc_html($fallback_query)
                );
                ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php while ($fallback_posts->have_posts()) : $fallback_posts->the_post(); ?>
                        <?php get_template_part('template-parts/content'); ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>

            <?php elseif (!$news_query) : ?>
                <div class="text-center py-12">
                    <p class="text-lg mb-8 text-gray-400">
                        <?php _e('Nu am găsit filme pentru căutarea ta. Explorează colecția noastră după gen:', 'textdomain'); ?>
                    </p>

                    <?php
                    $categories = get_categories([
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                        'number'     => 8,
                        'hide_empty' => true,
                        'exclude'    => get_cat_ID('Noutati'),
                    ]);
                    if ($categories) : ?>
                        <div class="flex flex-wrap justify-center gap-3 mb-12">
                            <?php foreach ($categories as $cat) : ?>
                                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                                   class="px-5 py-2 bg-[#002a3a] hover:bg-cyan-600 border border-cyan-800 hover:border-cyan-600 rounded-full text-sm font-medium transition-colors">
                                    <?php echo esc_html($cat->name); ?>
                                    <span class="text-gray-400 ml-1">(<?php echo $cat->count; ?>)</span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    $popular_posts = new WP_Query([
                        'posts_per_page' => 4,
                        'meta_key'       => 'imdbRating',
                        'orderby'        => 'meta_value_num',
                        'order'          => 'DESC',
                    ]);
                    if ($popular_posts->have_posts()) : ?>
                        <h2 class="text-2xl font-bold mb-6"><?php _e('Filme recomandate', 'textdomain'); ?></h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                            <?php while ($popular_posts->have_posts()) : $popular_posts->the_post(); ?>
                                <?php get_template_part('template-parts/content'); ?>
                            <?php endwhile; ?>
                        </div>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>
