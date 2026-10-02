<?php get_template_part('template-parts/header'); ?>

<main>
    <?php $tag = get_queried_object(); ?>
    <section class="bg-[#001f2d] text-[#f2f2f2] py-8">
        <div class="max-w-6xl mx-auto px-4">
            <?php
            $header_content = Tag_Header::get_header_content($tag->term_id);
            if (!empty($header_content['description'])) : ?>
                <div class="prose prose-invert mx-auto">
                    <h1 class="text-3xl font-bold text-center mb-4"><?php echo esc_html($header_content['title']); ?></h1>
                    <div class="mb-5 text-center">
                        <?php echo wp_kses_post($header_content['description']); ?>

                        <?php if (!empty($header_content['related_links'])) : ?>
                            <ul class="flex justify-center gap-4 mt-4">
                                <?php foreach ($header_content['related_links'] as $link) : ?>
                                    <li>
                                        <a href="<?php echo esc_url($link['url']); ?>"
                                            class="text-blue-300 hover:text-blue-200 transition-colors">
                                            <?php echo esc_html($link['title']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="prose prose-invert mx-auto">
                    <h1 class="text-3xl font-bold text-center mb-4"><?php echo esc_html($header_content['title']); ?></h1>
                    <?php if (tag_description()) : ?>
                        <div class="text-center text-lg mb-6">
                            <?php echo tag_description(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <p class="text-center text-sm text-gray-300">
                <?php
                $post_count = $tag->count;
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $posts_per_page = get_option('posts_per_page');
                $start = ($paged - 1) * $posts_per_page + 1;
                $end = min($paged * $posts_per_page, $post_count);

                if ($post_count > 0) {
                    if ($start === $end) {
                        printf(
                            __('Filmul %s din %s', 'textdomain'),
                            number_format_i18n($start),
                            number_format_i18n($post_count)
                        );
                    } else {
                        printf(
                            __('Filmele %s - %s din %s', 'textdomain'),
                            number_format_i18n($start),
                            number_format_i18n($end),
                            number_format_i18n($post_count)
                        );
                    }
                }
                ?>
            </p>
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
                    <p class="text-lg"><?php _e('Nu am găsit filme cu acest tag.', 'textdomain'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>