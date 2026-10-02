<?php get_template_part('template-parts/header'); ?>

<main>
    <?php $actor = get_queried_object(); ?>
    <section class="bg-[#001f2d] text-[#f2f2f2] py-8">
        <div class="max-w-6xl mx-auto px-4">
            <?php
            $actor_image_id = (int) get_term_meta($actor->term_id, 'actor_image_id', true);
            $header_content = Actor_Header::get_header_content($actor->term_id);
            if ($actor_image_id) : ?>
                <div class="max-w-4xl mx-auto flex flex-col sm:flex-row gap-6 sm:gap-8 items-center sm:items-start">
                    <div class="flex-shrink-0">
                        <?php echo wp_get_attachment_image($actor_image_id, 'medium', false, [
                            'class' => 'actor-photo rounded-xl shadow-2xl w-[140px] sm:w-[170px] object-cover ring-2 ring-white/10',
                            'alt'   => esc_attr($actor->name),
                        ]); ?>
                        <p class="text-xs text-gray-500 text-center mt-1">Foto: <a href="https://www.themoviedb.org" target="_blank" rel="noopener noreferrer" class="hover:text-gray-400 transition-colors">TMDB</a></p>
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <h1 class="text-3xl font-bold mb-3"><?php echo esc_html($header_content['title']); ?></h1>
                        <?php if (!empty($header_content['description'])) : ?>
                            <div class="text-gray-300 leading-relaxed mb-4">
                                <?php echo wp_kses_post($header_content['description']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($header_content['related_links'])) : ?>
                            <ul class="flex flex-wrap justify-center sm:justify-start gap-3 mt-2">
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
                    <?php if (!empty($header_content['description'])) : ?>
                        <div class="text-center text-gray-300 leading-relaxed mb-4">
                            <?php echo wp_kses_post($header_content['description']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($header_content['related_links'])) : ?>
                        <ul class="flex justify-center gap-4 mt-2">
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
            <?php endif; ?>

            <p class="text-center text-sm text-gray-300">
                <?php
                $post_count = $actor->count;
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
                    <p class="text-lg"><?php _e('Nu am găsit filme cu acest actor.', 'textdomain'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>