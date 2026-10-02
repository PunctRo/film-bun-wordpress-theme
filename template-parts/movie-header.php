<?php
$post = get_post();
$content = $post->post_content;

// Extract and store movie poster URL globally
global $movie_poster_url;
$movie_poster_url = extract_movie_poster(get_the_ID());

// Get ratings and duration
extract_film_rating(get_the_ID());
extract_imdb_rating(get_the_ID());
extract_duration(get_the_ID());
$rating = get_post_meta(get_the_ID(), 'filmRating', true);
$imdb_rating = get_post_meta(get_the_ID(), 'imdbRating', true);
$duration = get_post_meta(get_the_ID(), 'duration', true);

// Get director (regizor) and year (an)
$regizori = get_the_terms(get_the_ID(), 'regizor');
$ani = get_the_terms(get_the_ID(), 'an');

// Get categories and tags
$categories = get_the_category();
$tags = get_the_tags();

// Check if this is a noutati post (article)
$is_noutati = has_category('noutati', get_the_ID());
?>

<section class="relative py-12 px-4 overflow-hidden min-h-[300px] md:min-h-[400px]" role="banner" itemprop="mainEntityOfPage">
    <?php
    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail_url = has_post_thumbnail() ? wp_get_attachment_image_src($thumbnail_id, 'large')[0] : '';
    $thumbnail_meta = wp_get_attachment_metadata($thumbnail_id);
    $excerpt = !empty($args['excerpt']) ? strip_tags($args['excerpt']) : '';
    ?>

    <?php if ($thumbnail_url) : ?>
        <div class="absolute inset-0 bg-[#001f2d]" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-40" style="background-image: url('<?php echo esc_url($thumbnail_url); ?>')"></div>
            <div class="absolute inset-0 bg-gradient-to-t from 90% from-[#001f2d] to-transparent"></div>
            <meta itemprop="contentUrl" content="<?php echo esc_url($thumbnail_url); ?>">
            <?php if ($thumbnail_meta) : ?>
                <meta itemprop="width" content="<?php echo esc_attr($thumbnail_meta['width'] ?? ''); ?>">
                <meta itemprop="height" content="<?php echo esc_attr($thumbnail_meta['height'] ?? ''); ?>">
            <?php endif; ?>
        </div>
    <?php else : ?>
        <div class="absolute inset-0 bg-gradient-to-br from-[#001f2d] via-[#003345] to-[#001f2d]"></div>
    <?php endif; ?>

    <?php if (!empty($excerpt)) : ?>
        <div class="relative z-10 max-w-4xl mx-auto mb-8">
            <div class="text-[#f2f2f2] text-lg md:text-xl leading-relaxed">
                <?php echo esc_html($excerpt); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="relative z-10 max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row gap-10 items-start">
            <!-- Poster Column -->
            <div class="w-full md:w-auto flex-shrink-0 md:sticky md:top-24">
                <div class="relative w-[150px] lg:w-[180px] mx-auto md:mx-0 aspect-[150/223] rounded-xl overflow-hidden shadow-xl group border-2 border-cyan-400/20 hover:border-cyan-400/30 transition-colors duration-300" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                    <?php
                    if ($movie_poster_url) {
                        $poster_alt = sprintf('Poster pentru filmul %s', get_the_title());
                        echo sprintf(
                            '<img src="%s" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" alt="%s" itemprop="contentUrl" width="180" height="267" loading="lazy" />',
                            esc_url($movie_poster_url),
                            esc_attr($poster_alt)
                        );
                        echo '<meta itemprop="width" content="180">';
                        echo '<meta itemprop="height" content="267">';
                        echo sprintf('<meta itemprop="caption" content="%s">', esc_attr($poster_alt));
                    }
                    ?>
                </div>
            </div>

            <!-- Details Column -->
            <div class="flex-1 md:pl-8">
                <div class="flex flex-col justify-center">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 text-white leading-tight" itemprop="name"><?php the_title(); ?></h1>

                    <!-- Ratings -->
                    <div class="flex flex-wrap items-center gap-4 mb-4"<?php if ($rating && !$is_noutati) : ?> itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating"<?php endif; ?>>
                        <?php if ($rating) : ?>
                            <div class="flex items-center gap-2 bg-[#002a3a] px-4 py-2 rounded-full shadow-md border border-cyan-400/20 hover:border-cyan-400/30 transition-colors duration-300">
                                <?php echo render_simple_rating($rating); ?>
                                <meta itemprop="ratingValue" content="<?php echo esc_attr($rating); ?>">
                                <meta itemprop="bestRating" content="10">
                                <meta itemprop="ratingCount" content="1">
                            </div>
                        <?php endif; ?>

                        <?php if ($imdb_rating) : ?>
                            <div class="flex items-center gap-2 bg-[#002a3a] px-4 py-2 rounded-full shadow-md border border-cyan-400/20 hover:border-cyan-400/30 transition-colors duration-300" itemscope itemtype="https://schema.org/AggregateRating">
                                <span class="font-bold text-yellow-400">IMDb</span>
                                <span class="font-semibold" itemprop="ratingValue"><?php echo esc_html($imdb_rating); ?></span>
                                <meta itemprop="bestRating" content="10">
                                <meta itemprop="worstRating" content="1">
                                <meta itemprop="ratingCount" content="1000">
                                <div itemprop="itemReviewed" itemscope itemtype="https://schema.org/Movie">
                                    <meta itemprop="name" content="<?php echo esc_attr(get_the_title()); ?>">
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($duration) : ?>
                            <div class="flex items-center gap-2 bg-[#002a3a] px-4 py-2 rounded-full shadow-md border border-cyan-400/20 hover:border-cyan-400/30 transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-300" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-semibold"><span itemprop="duration" content="PT<?php echo esc_attr($duration); ?>M"><?php echo esc_html($duration); ?> min</span></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Movie Details Box -->
                <div class="space-y-2.5 text-sm bg-[#002a3a]/50 rounded-2xl p-4 border border-cyan-400/20">
                    <?php if ($regizori && !is_wp_error($regizori)) : ?>
                        <div class="flex items-start gap-2" itemprop="director" itemscope itemtype="https://schema.org/Person">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mt-0.5 text-gray-300" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <div>
                                <span class="font-semibold text-cyan-400/90">Regizor:</span>
                                <span class="text-[#f2f2f2]/90" itemprop="name"><?php
                                    $regizor_links = array();
                                    foreach ($regizori as $regizor) {
                                        $regizor_links[] = '<a href="' . esc_url(get_term_link($regizor)) . '" class="hover:text-cyan-400 transition-colors">' . esc_html($regizor->name) . '</a>';
                                    }
                                    echo join(', ', $regizor_links);
                                ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($ani && !is_wp_error($ani)) : ?>
                        <div class="flex items-start gap-2" itemprop="datePublished">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mt-0.5 text-gray-300" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <div>
                                <span class="font-semibold text-cyan-400/90">An:</span>
                                <span class="text-[#f2f2f2]/90">
                                    <?php
                                    $an_links = array();
                                    foreach ($ani as $an) {
                                        $an_links[] = sprintf(
                                            '<a href="%s" class="hover:text-cyan-400 transition-colors" title="Vezi toate filmele din %s" content="%s">%s</a>',
                                            esc_url(get_term_link($an->term_id)),
                                            esc_attr($an->name),
                                            esc_attr($an->name . '-01-01'),
                                            esc_html($an->name)
                                        );
                                    }
                                    echo join(', ', $an_links);
                                    ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($categories) : ?>
                        <div class="flex items-start gap-2" itemprop="genre">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mt-0.5 text-gray-300" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0118 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0118 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 016 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0 .621.504 1.125 1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M7.125 12h9.75m-9.75 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h17.25m-17.25 0c-.621 0-1.125.504-1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5" />
                            </svg>
                            <div>
                                <span class="font-semibold text-cyan-400/90">Genuri:</span>
                                <span class="text-[#f2f2f2]/90">
                                    <?php
                                    $category_links = array();
                                    foreach ($categories as $category) {
                                        $category_links[] = sprintf(
                                            '<a href="%s" class="hover:text-cyan-400 transition-colors" title="Vezi toate filmele din categoria %s" lang="ro" itemprop="genre">%s</a>',
                                            esc_url(get_category_link($category->term_id)),
                                            esc_attr($category->name),
                                            esc_html($category->name)
                                        );
                                    }
                                    echo join(', ', $category_links);
                                    ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($tags) : ?>
                        <div class="flex items-start gap-2" itemprop="keywords">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mt-0.5 text-gray-300" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607l-9.581-9.581A2.25 2.25 0 0010.159 3.659 2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                            <div>
                                <span class="font-semibold text-cyan-400/90">Etichete:</span>
                                <span class="text-[#f2f2f2]/90">
                                    <?php
                                    $tag_links = array();
                                    foreach ($tags as $tag) {
                                        $tag_links[] = sprintf(
                                            '<a href="%s" class="hover:text-cyan-400 transition-colors" lang="ro" itemprop="keywords">%s</a>',
                                            esc_url(get_tag_link($tag->term_id)),
                                            esc_html($tag->name)
                                        );
                                    }
                                    echo join(', ', $tag_links);
                                    ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>