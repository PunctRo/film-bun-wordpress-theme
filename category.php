<?php get_template_part('template-parts/header'); ?>

<main>
    <?php $category = get_queried_object(); ?>
    <section class="bg-[#001f2d] text-[#f2f2f2] py-6 md:py-10">
        <div class="max-w-6xl mx-auto px-4">
            <?php
            $header_content = Category_Header::get_header_content($category->term_id);
            if (!empty($header_content['header_image']) && !empty($header_content['header_image']['url'])) : ?>
                <article class="relative overflow-hidden bg-[#001f2d]" itemscope itemtype="https://schema.org/CollectionPage">
                    <!-- Hero Image -->
                    <div class="absolute inset-0">
                        <img src="<?php echo esc_url($header_content['header_image']['url']); ?>"
                            alt="Colecție filme <?php echo esc_attr(single_cat_title('', false)); ?>"
                            title="Filme <?php echo esc_attr(single_cat_title('', false)); ?>"
                            class="w-full h-full object-cover object-center"
                            loading="eager"
                            itemprop="image" />
                        <!-- Cinematic double gradient: strong on left + bottom, fades out right/top -->
                        <div class="absolute inset-0" style="background: linear-gradient(to right, #001f2d 35%, rgba(0,31,45,0.82) 60%, rgba(0,31,45,0.35) 100%)"></div>
                        <div class="absolute inset-0" style="background: linear-gradient(to top, #001f2d 0%, rgba(0,31,45,0.6) 30%, transparent 60%)"></div>
                    </div>

                    <!-- Content Container -->
                    <div class="relative min-h-[400px] sm:min-h-[460px] md:min-h-[520px] lg:min-h-[560px] flex flex-col justify-end md:justify-center z-10">
                        <div class="w-full md:max-w-[65%] lg:max-w-[58%] px-5 sm:px-7 md:px-10 pb-7 pt-20 sm:pt-10 md:pt-0">

                            <!-- Eyebrow label -->
                            <div class="flex items-center gap-2.5 mb-4">
                                <span class="block w-6 h-px bg-white/50"></span>
                                <span class="text-white/55 text-[11px] uppercase tracking-[0.18em] font-semibold">Colecție Cinema</span>
                            </div>

                            <!-- Title -->
                            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-white mb-4 md:mb-5 leading-tight tracking-tight"
                                style="text-shadow: 0 2px 24px rgba(0,0,0,0.55);"
                                itemprop="name">
                                <?php echo esc_html($header_content['title']); ?>
                            </h1>

                            <?php if (!empty($header_content['description'])) : ?>
                                <!-- Description — no prose to avoid global text-indent -->
                                <div class="max-w-2xl mb-5 md:mb-6 pl-3 border-l border-white/20" itemprop="description">
                                    <div class="text-gray-200/85 text-sm sm:text-[15px] leading-relaxed [&_strong]:text-white [&_strong]:font-semibold [&_em]:italic [&_a]:text-cyan-400 [&_p]:mb-2 [&_p:last-child]:mb-0">
                                        <?php echo wp_kses_post($header_content['description']); ?>
                                    </div>
                                </div>

                                <!-- Related Links as pill buttons -->
                                <?php if (!empty($header_content['related_links'])) : ?>
                                    <nav class="mb-5 md:mb-6" aria-label="Linkuri categorii conexe">
                                        <div class="flex flex-wrap gap-2">
                                            <?php foreach ($header_content['related_links'] as $link) : ?>
                                                <a href="<?php echo esc_url($link['url']); ?>"
                                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-sm font-medium text-white/90 border border-white/20 bg-white/[0.07] backdrop-blur-sm hover:bg-white/[0.16] hover:border-white/35 hover:-translate-y-px transition-all duration-150"
                                                    itemprop="relatedLink">
                                                    <svg class="w-3 h-3 opacity-60 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                    <?php echo esc_html($link['title']); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </nav>
                                <?php endif; ?>
                            <?php elseif (category_description()) : ?>
                                <div class="max-w-2xl mb-5 pl-3 border-l border-white/20 text-gray-200/85 text-sm sm:text-[15px] leading-relaxed" itemprop="description">
                                    <?php echo category_description(); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Film count badge -->
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-white/[0.07] border border-white/10 backdrop-blur-sm text-sm text-gray-300">
                                <svg class="w-4 h-4 opacity-50 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                                </svg>
                                <span itemprop="numberOfItems">
                                    <?php
                                    $post_count = $category->count;
                                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                                    $posts_per_page = get_option('posts_per_page');
                                    $start = ($paged - 1) * $posts_per_page + 1;
                                    $end = min($paged * $posts_per_page, $post_count);

                                    if ($post_count > 0) {
                                        if ($paged > 1) {
                                            printf(
                                                __('%s - %s din %s filme', 'textdomain'),
                                                number_format_i18n($start),
                                                number_format_i18n($end),
                                                number_format_i18n($post_count)
                                            );
                                        } else {
                                            printf(
                                                __('%s filme', 'textdomain'),
                                                number_format_i18n($post_count)
                                            );
                                        }
                                    }
                                    ?>
                                </span>
                            </div>

                        </div>
                    </div>
                </article>
            <?php else: ?>
                <article class="py-10" itemscope itemtype="https://schema.org/CollectionPage">
                    <div class="flex items-center gap-2.5 mb-4">
                        <span class="block w-6 h-px bg-white/40"></span>
                        <span class="text-white/50 text-[11px] uppercase tracking-[0.18em] font-semibold">Colecție Cinema</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-4" itemprop="name">
                        <?php echo esc_html($header_content['title']); ?>
                    </h1>
                    <?php if (category_description()) : ?>
                        <div class="max-w-3xl pl-3 border-l border-white/20 text-gray-200/85 text-sm sm:text-base leading-relaxed" itemprop="description">
                            <?php echo category_description(); ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endif; ?>
        </div>
    </section>

    <section class="pb-10 bg-[#001f2d] text-[#f2f2f2]">
        <div class="max-w-6xl mx-auto px-4">
            <?php if (have_posts()) : ?>
                <h2 class="sr-only">Lista de filme</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/content'); ?>
                    <?php endwhile; ?>
                </div>
                <nav class="mt-8 flex items-center justify-center space-x-2" aria-label="Pagination">
                    <?php get_template_part('template-parts/pagination'); ?>
                </nav>
            <?php else : ?>
                <div class="text-center py-12">
                    <p class="text-lg"><?php _e('Nu am găsit filme în această categorie.', 'textdomain'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>