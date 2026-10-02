<?php
// Get post ID and title early while we have the correct post context
$post_id = get_the_ID();
$post_title = get_the_title();

// Access globally stored movie poster URL
global $movie_poster_url;

// Get IMDb ID if available
$justwatch_URL = get_post_meta($post_id, 'justwatchURL', true);

// First extract metadata from raw content
$related_movies = extract_related_movies($post_id);

// Then process content for display
$text = extract_post_content($post_id);

// Extract trailer before we modify the content
$trailer_url = extract_trailer($post_id);

// If no trailer in meta, try to extract from content
if (!$trailer_url && preg_match('/<iframe[^>]*src="([^"]*youtube[^"]*)"/', get_the_content(), $matches)) {
    $trailer_url = $matches[1];
    update_post_meta($post_id, 'trailer', $trailer_url);
}
?>

<section class="py-4" itemprop="description">
    <div class="max-w-4xl mx-auto">
        <?php if (!has_category('noutati', $post_id)) : ?>
        <div class="flex items-center gap-2 mb-6 px-4">
            <h2 class="text-2xl font-bold text-cyan-400" lang="ro">Despre Film</h2>
            <div class="flex-1 h-px bg-cyan-400/20"></div>
        </div>
        <?php endif; ?>
        <div class="bg-[#002a3a] rounded-xl shadow-lg p-8 border border-cyan-400/10 hover:border-cyan-400/30 transition-all duration-300">
            <article class="prose prose-invert prose-lg max-w-none prose-headings:text-cyan-400 prose-a:text-cyan-400 prose-strong:text-cyan-400" lang="ro">
                <?php
                // For noutati posts, content is already formatted by extract_post_content
                // For movie reviews, apply additional formatting
                if (has_category('noutati', $post_id)) {
                    echo wp_kses_post($text);
                } else {
                    echo wp_kses_post(format_text_with_wpautop($text));
                }
                ?>
            </article>
        </div>
    </div>
</section>

<?php
$info_block = get_post_meta($post_id, 'info_block', true);
if ($info_block) : ?>
<div class="max-w-4xl mx-auto px-4 mb-4">
    <?php echo wp_kses_post($info_block); ?>
</div>
<?php endif; ?>

<?php
$trailer_url = get_post_meta(get_the_ID(), 'trailer', true);
if ($trailer_url) : ?>
    <section class="py-4" itemprop="trailer" itemscope itemtype="https://schema.org/VideoObject">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-2 mb-6 px-4">
                <h2 class="text-2xl font-bold text-cyan-400" lang="ro">Trailer</h2>
                <div class="flex-1 h-px bg-cyan-400/20"></div>
            </div>
            <div class="bg-[#002a3a] rounded-xl shadow-lg p-8 border border-cyan-400/10 hover:border-cyan-400/30 transition-all duration-300">
                <div class="aspect-video">
                    <meta itemprop="name" content="<?php echo esc_attr(sprintf('Trailer oficial pentru filmul %s', get_the_title())); ?>">
                    <meta itemprop="description" content="<?php echo esc_attr(sprintf('Vezi trailerul oficial pentru filmul %s', get_the_title())); ?>">
                    <?php
                    $thumbnail_url = $movie_poster_url;
                    if (!$thumbnail_url && preg_match('/embed\/([a-zA-Z0-9_-]+)/', $trailer_url, $yt_match)) {
                        $thumbnail_url = 'https://img.youtube.com/vi/' . $yt_match[1] . '/maxresdefault.jpg';
                    }
                    ?>
                    <meta itemprop="thumbnailUrl" content="<?php echo esc_url($thumbnail_url); ?>">
                    <meta itemprop="uploadDate" content="<?php echo esc_attr(get_the_date('c')); ?>">
                    <meta itemprop="contentUrl" content="<?php echo esc_url(str_replace('embed/', 'watch?v=', $trailer_url)); ?>">
                    <meta itemprop="duration" content="PT3M">
                    <iframe src="<?php echo esc_url($trailer_url); ?>"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                        class="w-full h-full rounded"
                        itemprop="embedUrl"
                        title="<?php echo esc_attr(sprintf('Trailer oficial pentru filmul %s', get_the_title())); ?>"></iframe>
                </div>
            </div>
        </div>
    </section>
<?php endif;

?>
<?php
// Check if movie has any streaming platform tags
$streaming_platforms = array('netflix', 'hbo-max', 'skyshowtime', 'amazon-prime-video', 'disney-plus');
$has_streaming = false;

foreach ($streaming_platforms as $platform) {
    if (has_tag($platform)) {
        $has_streaming = true;
        break;
    }
}

if ($has_streaming) :
    // Get custom streaming URL if it exists
    $streaming_url = get_post_meta($post_id, 'streaming_url', true);
    $movie_year = get_movie_year($post_id);
?>
    <section class="py-4 streaming-section">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-2 mb-6 px-4">
                <h2 class="text-2xl font-bold text-cyan-400"><?php echo esc_html($post_title); ?> este disponibil online subtitrat</h2>
                <div class="flex-1 h-px bg-cyan-400/20"></div>
            </div>
            <div class="bg-[#002a3a] rounded-xl shadow-lg p-6 border border-cyan-400/10 hover:border-cyan-400/30 transition-all duration-300">
                <?php if ($streaming_url) : ?>
                    <a href="<?php echo esc_url($streaming_url); ?>"
                        class="inline-flex items-center justify-center w-full px-6 py-4 text-lg font-semibold text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg transition-colors duration-300"
                        target="_blank"
                        rel="noopener"
                        title="<?php echo esc_attr(sprintf('Vezi %s online', $post_title)); ?>">
                        <?php echo esc_html(sprintf('Vezi %s online', $post_title)); ?>
                    </a>
                <?php else : ?>
                    <div class="relative group">
                        <div
                            data-jw-widget=""
                            class="transition-opacity duration-300"
                            data-api-key="kfltyCjlMBdrn9EgF5o4VwE8k4b4580Q"
                            data-object-type="movie"
                            <?php if ($justwatch_URL) : ?>
                            data-url-path="<?php echo esc_attr($justwatch_URL); ?>"
                            <?php else : ?>
                            data-title="<?php echo esc_attr(get_the_title()); ?>"
                            data-year="<?php echo esc_attr(get_movie_year(get_the_ID())); ?>"
                            <?php endif; ?>
                            data-theme="dark">
                        </div>
                        <div class="mt-2">
                            <a class="inline-flex items-center gap-1.5 text-[11px] font-sans text-gray-300 hover:text-gray-100 transition-colors no-underline"
                                target="_blank"
                                href="https://www.justwatch.com/ro"
                                rel="noopener">
                                Powered by
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/JW_logo_black_10px.svg"
                                    alt="JustWatch"
                                    class="h-[10px] w-auto brightness-[10] opacity-80"
                                    style="filter: invert(1);">
                            </a>
                        </div>
                    </div>
            </div>
        <?php endif; // End if streaming_url
        ?>
        </div>
        </div>
    </section>
<?php endif; // End if has_streaming 
?>

<?php
// Get actors for the current post
$actors = get_the_terms(get_the_ID(), 'actor');

if ($actors && !is_wp_error($actors)) : ?>
    <section class="py-4" itemprop="actor" itemscope itemtype="https://schema.org/Person">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-2 mb-6 px-4">
                <h2 class="text-2xl font-bold text-cyan-400" lang="ro">Actori</h2>
                <div class="flex-1 h-px bg-cyan-400/20"></div>
            </div>
            <div class="bg-[#002a3a] rounded-xl shadow-lg p-6 border border-cyan-400/10 hover:border-cyan-400/30 transition-all duration-300">
                <ul class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 list-none p-0 m-0">
                    <?php $has_tmdb_image = false; foreach ($actors as $actor) :
                        $actor_image_id = (int) get_term_meta($actor->term_id, 'actor_image_id', true);
                        $actor_image    = get_term_meta($actor->term_id, 'actor_image', true);
                        if ($actor_image_id) $has_tmdb_image = true;
                    ?>
                        <li>
                            <a href="<?php echo esc_url(get_term_link($actor)); ?>" class="group" itemprop="actor" itemscope itemtype="https://schema.org/Person">
                                <div class="aspect-[3/4] max-w-[130px] mx-auto overflow-hidden rounded-lg mb-2">
                                    <?php if ($actor_image_id) : ?>
                                        <?php echo wp_get_attachment_image($actor_image_id, array(130, 173), false, [
                                            'alt'             => esc_attr($actor->name),
                                            'aria-labelledby' => 'actor-name-' . esc_attr($actor->term_id),
                                            'class'           => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300',
                                            'itemprop'        => 'image',
                                            'loading'         => 'lazy',
                                        ]); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url($actor_image ?: get_template_directory_uri() . '/assets/images/actor-placeholder.svg'); ?>"
                                            alt="<?php echo esc_attr($actor->name); ?>"
                                            aria-labelledby="actor-name-<?php echo esc_attr($actor->term_id); ?>"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                            itemprop="image"
                                            width="130"
                                            height="173"
                                            loading="lazy">
                                    <?php endif; ?>
                                </div>
                                <h3 class="text-center text-sm font-medium text-gray-200 group-hover:text-cyan-400 transition-colors" itemprop="name" id="actor-name-<?php echo esc_attr($actor->term_id); ?>">
                                    <?php echo esc_html($actor->name); ?>
                                </h3>
                                <link itemprop="sameAs" href="<?php echo esc_url(get_term_link($actor)); ?>">
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if ($has_tmdb_image) : ?>
                <p class="text-xs text-gray-500 text-right mt-3">Foto actori: <a href="https://www.themoviedb.org" target="_blank" rel="noopener noreferrer" class="hover:text-gray-400 transition-colors">TMDB</a></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php
$related_posts = get_movie_related_posts();
if (!has_category('noutati', $post_id) && !empty($related_posts)) : ?>
<section class="py-4" itemprop="isRelatedTo" itemscope itemtype="https://schema.org/ItemList">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center gap-2 mb-6 px-4">
            <h2 class="text-2xl font-bold text-cyan-400" lang="ro" itemprop="name">Filme Bune similare</h2>
            <div class="flex-1 h-px bg-cyan-400/20"></div>
        </div>
        <div class="bg-[#002a3a] rounded-xl shadow-lg p-6 border border-cyan-400/10 hover:border-cyan-400/30 transition-all duration-300">
            <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 list-none p-0 m-0">
                <?php
                foreach ($related_posts as $post) {
                ?>
                    <li>
                        <a href="<?php echo esc_url($post['permalink']); ?>" class="group" itemprop="itemListElement" itemscope itemtype="https://schema.org/Movie">
                            <div class="relative w-[150px] mx-auto aspect-[150/223] rounded-lg overflow-hidden shadow-xl group border-2 border-cyan-400/20 hover:border-cyan-400/30 transition-colors duration-300 mb-2" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                <?php
                                // Extract image src from image_html using regex
                                preg_match('/src=["\']([^"\']+)["\']/', $post['image_html'], $matches);
                                $img_src = isset($matches[1]) ? $matches[1] : '';

                                if ($img_src) {
                                    echo sprintf(
                                        '<img src="%s" alt="Poster pentru filmul %s" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" itemprop="contentUrl" loading="lazy" width="150" height="223">',
                                        esc_url($img_src),
                                        esc_attr($post['title'])
                                    );
                                } else {
                                    echo $post['image_html'];
                                }
                                ?>
                            </div>
                            <h3 class="text-center text-sm font-medium text-gray-200 group-hover:text-cyan-400 transition-colors" itemprop="name">
                                <?php echo esc_html($post['title']); ?>
                            </h3>
                            <link itemprop="url" href="<?php echo esc_url($post['permalink']); ?>">
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
// Using the related_movies already extracted at the beginning of the file
if ($related_movies) : ?>
    <section class="py-4" itemprop="isRelatedTo" itemscope itemtype="https://schema.org/ItemList">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-2 mb-6 px-4">
                <h2 class="text-2xl font-bold text-cyan-400" lang="ro" itemprop="name">Alte recomandări de filme asemănătoare cu <?php echo esc_html($post_title); ?></h2>
                <div class="flex-1 h-px bg-cyan-400/20"></div>
            </div>
            <div class="bg-[#002a3a] rounded-xl shadow-lg p-6 border border-cyan-400/10 hover:border-cyan-400/30 transition-all duration-300">
                <ul class="grid sm:grid-cols-2 gap-3 list-none p-0 m-0">
                    <?php $movie_index = 0; foreach ($related_movies as $movie) : $movie_index++; ?>
                        <li>
                            <a href="<?php echo esc_url($movie['url']); ?>"
                                class="flex items-center gap-3 p-3 rounded-lg bg-cyan-400/5 hover:bg-cyan-400/10 border border-cyan-400/10 hover:border-cyan-400/20 transition-all duration-300 group"
                                target="_blank"
                                rel="noopener"
                                itemprop="itemListElement"
                                itemscope
                                itemtype="https://schema.org/Movie">
                                <span class="flex-shrink-0 w-7 h-7 rounded-full bg-cyan-400/10 group-hover:bg-cyan-400/20 flex items-center justify-center text-xs font-bold text-cyan-400 transition-colors"><?php echo $movie_index; ?></span>
                                <span class="flex-1 text-gray-200 group-hover:text-cyan-400 transition-colors line-clamp-1" lang="ro" itemprop="name">
                                    <?php echo esc_html($movie['title']); ?>
                                </span>
                                <span class="flex-shrink-0 inline-flex items-center gap-1 text-[10px] font-semibold text-yellow-500/70 group-hover:text-yellow-500 transition-colors">
                                    IMDb
                                    <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.22 14.78a.75.75 0 001.06 0l7.22-7.22v5.69a.75.75 0 001.5 0v-7.5a.75.75 0 00-.75-.75h-7.5a.75.75 0 000 1.5h5.69l-7.22 7.22a.75.75 0 000 1.06z" clip-rule="evenodd"/></svg>
                                </span>
                                <meta itemprop="url" content="<?php echo esc_url($movie['url']); ?>">
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (!has_category('noutati', $post_id)) : ?>
<div class="max-w-4xl mx-auto mt-4 px-0">
    <a href="https://whatsapp.com/channel/0029Vb7SCp0AzNc010i6kf2U"
       target="_blank"
       rel="noopener noreferrer"
       class="group flex flex-col sm:flex-row items-center gap-3 sm:gap-5 bg-[#0d2218] rounded-xl px-6 py-4 border border-emerald-500/20 hover:border-emerald-400/40 transition-all duration-300 hover:shadow-[0_0_25px_rgba(37,211,102,0.12)] no-underline">
        <div class="flex-shrink-0 w-11 h-11 rounded-full bg-emerald-500/15 flex items-center justify-center group-hover:bg-emerald-500/25 transition-colors">
            <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </div>
        <div class="flex-1 text-center sm:text-left">
            <p class="text-white font-semibold text-sm sm:text-base mb-1">Ți-a plăcut această recomandare?</p>
            <p class="text-gray-400 text-xs sm:text-sm m-0">Urmărește canalul nostru WhatsApp — filme bune, direct pe telefon.</p>
        </div>
        <div class="flex-shrink-0 mt-1 sm:mt-0">
            <span class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-emerald-500/15 group-hover:bg-emerald-500/25 text-emerald-300 group-hover:text-emerald-200 text-xs sm:text-sm font-semibold rounded-full transition-all duration-300">
                Urmărește
                <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </span>
        </div>
    </a>
</div>
<?php endif; ?>

<?php if (!has_category('noutati', $post_id)) : ?>
<section class="py-4 max-w-4xl mx-auto">
    <?php
    // Restore main query's post context — related posts section runs a secondary WP_Query
    // which can shift the global $post. comments_template() needs the correct post.
    wp_reset_postdata();
    comments_template();
    ?>
</section>
<?php endif; ?>