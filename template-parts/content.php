<?php
// Get post data
$post = get_post();
$content = $post->post_content;
$post_title = get_the_title();

// Get year if available
$year_terms = get_the_terms($post->ID, 'an');
$year = !empty($year_terms) ? $year_terms[0]->name : '';

// Generate SEO-optimized image attributes
$image_attributes = generate_movie_poster_attributes($post_title, $year);

// Get categories once to use in both mobile and desktop versions
$categories = get_the_category();

// Get tags once to use for both platforms and tag list
$post_tags = get_the_tags();
?>
<a href="<?php the_permalink(); ?>" class="rounded-xl block">
    <article class="bg-[#002a3a] rounded-xl shadow-lg flex flex-row hover:shadow-xl transition-all duration-300 hover:bg-[#003a52] overflow-hidden border border-transparent hover:border-cyan-400/30 min-h-[180px] sm:min-h-[280px]">
        <div class="relative w-28 sm:w-36 md:w-40 lg:w-44 p-2 sm:p-4 flex-shrink-0 group">
            <!-- Mobile and Desktop Version - Unified -->
            <div class="relative overflow-hidden rounded-lg transition-transform duration-300 group-hover:scale-105 h-full">
                <?php
                // Get poster URL using Movie_Metadata class
                $poster_url = Movie_Metadata::extract_poster(get_the_ID());
                
                if ($poster_url) {
                    printf(
                        '<img src="%s" class="object-cover w-full h-full rounded" alt="%s" title="%s" width="150" height="223" loading="lazy"/>',
                        esc_url($poster_url),
                        esc_attr($image_attributes['alt']),
                        esc_attr($image_attributes['title'])
                    );
                }
                ?>
                <?php if ($categories) : ?>
                    <!-- Category Badge -->
                    <div class="absolute top-2 sm:top-4 left-0 transform bg-[#003a61] text-white text-[10px] sm:text-xs px-2 sm:px-3 py-0.5 sm:py-1 font-semibold rounded-r-full shadow-md flex items-center transition-all duration-300 group-hover:bg-[#004a7a]">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/clapperboard.png" alt="Categorie film" title="Categorie film" class="w-3 sm:w-4 h-3 sm:h-4 mr-0.5 sm:mr-1 -mt-px" loading="lazy">
                        <?php echo esc_html($categories[0]->name); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="p-2 sm:p-4 flex flex-col justify-between flex-1 min-w-0">
            <div class="flex flex-wrap items-center text-[10px] sm:text-xs mb-1.5 sm:mb-2 gap-1 sm:gap-2 min-w-0">
                <?php
                extract_film_rating(get_the_ID()); // Extract and save rating if not already done
                extract_imdb_rating(get_the_ID()); // Extract and save IMDB rating if not already done
                $rating = get_post_meta(get_the_ID(), 'filmRating', true);
                $imdb_rating = get_post_meta(get_the_ID(), 'imdbRating', true);
                if ($rating) : ?>
                    <div class="flex items-center gap-1.5 sm:gap-3 min-w-0 text-[10px] sm:text-xs">
                        <div class="flex items-center min-w-0">
                            <?php echo render_simple_rating($rating, 'w-3 sm:w-4 h-3 sm:h-4'); ?>
                        </div>
                        <?php if ($imdb_rating) : ?>
                            <div class="flex items-center gap-1 text-gray-400">
                                <span class="whitespace-nowrap">IMDb:</span>
                                <span class="font-semibold whitespace-nowrap"><?php echo esc_html($imdb_rating); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php
                extract_duration(get_the_ID()); // Extract and save duration if not already done
                $duration = get_post_meta(get_the_ID(), 'duration', true);
                if ($duration) : ?>
                    <div class="flex items-center gap-0.5 sm:gap-1 flex-shrink-0 text-[10px] sm:text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 sm:w-4 h-3 sm:h-4 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold whitespace-nowrap"><?php echo esc_html($duration); ?> min</span>
                    </div>
                <?php endif; ?>
                <?php
                $available_platforms = [
                    'netflix' => [
                        'image' => 'Filme-Online-Pe-Netflix.webp',
                        'alt' => 'Disponibil pe Netflix',
                        'title' => 'Disponibil pe Netflix',
                    ],
                    'hbo-max' => [
                        'image' => 'Filme-Online-Pe-Max.webp',
                        'alt' => 'Disponibil pe Max',
                        'title' => 'Disponibil pe Max',
                    ],
                    'amazon-prime-video' => [
                        'image' => 'Filme-Online-Pe-Amazonprimevideo.webp',
                        'alt' => 'Disponibil pe Amazon Prime Video',
                        'title' => 'Disponibil pe Amazon Prime Video',
                    ],
                    'amazonprimevideo' => [
                        'image' => 'Filme-Online-Pe-Amazonprimevideo.webp',
                        'alt' => 'Disponibil pe Amazon Prime Video',
                        'title' => 'Disponibil pe Amazon Prime Video',
                    ],
                    'disney-plus' => [
                        'image' => 'Filme-Online-Pe-DisneyPlus.webp',
                        'alt' => 'Disponibil pe Disney+',
                        'title' => 'Disponibil pe Disney+',
                    ],
                    'disneyplus' => [
                        'image' => 'Filme-Online-Pe-DisneyPlus.webp',
                        'alt' => 'Disponibil pe Disney+',
                        'title' => 'Disponibil pe Disney+',
                    ],
                    'skyshowtime' => [
                        'image' => 'Filme-Online-Pe-SkyShowtime.webp',
                        'alt' => 'Disponibil pe SkyShowtime',
                        'title' => 'Disponibil pe SkyShowtime',
                    ],
                ];

                $platforms = [];
                if ($post_tags) {
                    foreach ($post_tags as $tag) {
                        if (array_key_exists($tag->slug, $available_platforms)) {
                            $platforms[] = $tag->slug;
                        }
                    }
                }

                if (!empty($platforms)) : ?>
                    <div class="flex items-center gap-1 sm:gap-1.5">
                        <?php foreach (array_unique($platforms) as $platform_key) :
                            $platform_data = $available_platforms[$platform_key];
                        ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $platform_data['image']; ?>" alt="<?php echo esc_attr($platform_data['alt']); ?>" title="<?php echo esc_attr($platform_data['title']); ?>" class="h-3.5 sm:h-5 w-auto" loading="lazy">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php
                // Show book icon for ecranizare-tagged movies
                $is_ecranizare = false;
                if ($post_tags) {
                    foreach ($post_tags as $tag) {
                        if ($tag->slug === 'ecranizare') {
                            $is_ecranizare = true;
                            break;
                        }
                    }
                }
                if ($is_ecranizare) : ?>
                    <div class="flex items-center flex-shrink-0" title="Ecranizare – bazat pe o carte">
                        <svg class="w-3.5 sm:w-5 h-3.5 sm:h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                <?php endif; ?>
            </div>
            <h3 class="text-sm sm:text-lg font-bold mb-1 sm:mb-2 line-clamp-2 leading-tight">
                <?php
                if (is_search()) {
                    echo highlight_search_terms(get_the_title());
                } else {
                    the_title();
                }
                ?>
            </h3>
            <div class="text-[11px] sm:text-sm leading-relaxed mb-1.5 sm:mb-3 line-clamp-2 sm:line-clamp-3">
                <?php
                // Remove shortcodes and metadata
                $text = strip_tags($content);
                // Remove shortcode pattern
                $text = preg_replace('/\[.*?\]/', '', $text);
                // Remove metadata pattern (Nota IMDB... Regia... Durata...)
                $text = preg_replace('/Nota IMDB\s*\*?\s*:\s*[\d.]+\s*Regia\s*:\s*[^:]+\s*Durata\s*:\s*\d+\s*min/i', '', $text);
                // Clean up extra whitespace
                $text = trim(preg_replace('/\s+/', ' ', $text));
                // Split into words and get first 40
                $words = explode(' ', $text);
                $excerpt = implode(' ', array_slice($words, 0, 36));
                // Add ellipsis if there are more words
                if (count($words) > 40) {
                    $excerpt .= '...';
                }

                if (is_search()) {
                    echo highlight_search_terms($excerpt);
                } else {
                    echo esc_html($excerpt);
                }
                ?>
            </div>
            <div class="text-[10px] sm:text-sm space-y-1 hidden sm:block">
                <?php
                // Filter out 'online' and streaming platform tags (already shown as icons)
                $excluded_tag_slugs = array('online', 'netflix', 'hbo-max', 'amazonprimevideo', 'amazon-prime-video', 'disneyplus', 'disney-plus', 'skyshowtime', 'ecranizare');
                $display_tags = $post_tags ? array_filter($post_tags, function($tag) use ($excluded_tag_slugs) {
                    return !in_array($tag->slug, $excluded_tag_slugs);
                }) : [];
                if (!empty($display_tags)) : ?>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block mr-1 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607l-9.581-9.581A2.25 2.25 0 0010.159 3.659 2.25 2.25 0 009.568 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                        </svg>
                        <strong>Etichete:</strong>
                        <?php echo join(', ', wp_list_pluck(array_slice($display_tags, 0, 5), 'name')); ?>
                    </p>
                <?php endif; ?>
            </div>
            <div class="flex justify-center sm:justify-end mt-2">
                <span class="inline-block w-full sm:w-fit bg-gradient-to-r from-cyan-400 to-blue-500 text-white font-semibold rounded-full px-3 sm:px-4 py-1 sm:py-1.5 text-xs sm:text-sm text-center hover:shadow-lg transition-all duration-300 hover:scale-105 active:scale-95">
                    Detalii Film
                </span>
            </div>
        </div>
    </article>
</a>