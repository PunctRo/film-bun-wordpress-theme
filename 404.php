<?php

/**
 * 404 Template
 *
 * Template pentru pagina de eroare 404 (Pagină Negăsită)
 */

// Set proper HTTP headers
status_header(404);
nocache_headers();

// Force correct page title
add_filter('pre_get_document_title', function () {
    return 'Pagină Negăsită | ' . get_bloginfo('name');
});

// SEO meta description
add_action('wp_head', function () {
    echo '<meta name="robots" content="noindex,follow">';
    echo '<meta name="description" content="Pagina pe care o cauți nu a fost găsită. Explorează filmele noastre sau folosește căutarea pentru a găsi ce dorești.">';
});

// Add Schema.org markup
add_action('wp_head', function () {
    $schema = array(
        "@context" => "https://schema.org",
        "@type" => "WebPage",
        "name" => "Pagină Negăsită",
        "description" => "Pagina pe care o cauți nu a fost găsită. Explorează filmele noastre sau folosește căutarea pentru a găsi ce dorești."
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
});

get_template_part('template-parts/header'); ?>

<main>
    <section class="bg-[#001f2d] text-[#f2f2f2] py-8">
        <div class="max-w-6xl mx-auto px-4">
            <div class="prose prose-invert mx-auto text-center">
                <h1 class="text-3xl font-bold mb-4">Pagină Negăsită</h1>
                <p class="text-xl">Ne pare rău, pagina pe care o cauți nu mai există sau a fost mutată la o altă adresă.</p>
            </div>
        </div>
    </section>

    <section class="pb-10 bg-[#001f2d] text-[#f2f2f2]">
        <div class="max-w-6xl mx-auto px-4">
            <!-- 404 Illustration -->
            <div class="flex justify-center mb-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-48 w-48 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <!-- Search Section -->
            <div class="max-w-2xl mx-auto text-center mb-6">
                <h2 class="text-xl mb-6 text-cyan-300">Caută filme</h2>
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="relative">
                        <input type="search"
                            class="w-full px-6 py-3 text-white bg-[#002a3a] rounded-lg focus:ring-2 focus:ring-cyan-400 focus:outline-none placeholder-gray-400"
                            placeholder="<?php echo esc_attr_x('Caută filme...', 'placeholder', 'textdomain'); ?>"
                            value="<?php echo get_search_query(); ?>"
                            name="s" />
                        <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 p-2 hover:bg-[#003a52] rounded-full transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Navigation Links -->
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-xl mb-6 text-cyan-300">Explorează filme</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center justify-center p-4 bg-[#002a3a] rounded-lg hover:bg-[#003a52] transition-colors duration-200 group">
                        <span class="text-cyan-400 group-hover:text-cyan-300">Pagina Principală</span>
                    </a>
                    <a href="/filme-romanesti-online" class="flex items-center justify-center p-4 bg-[#002a3a] rounded-lg hover:bg-[#003a52] transition-colors duration-200 group">
                        <span class="text-cyan-400 group-hover:text-cyan-300">Filme Românești</span>
                    </a>
                    <a href="/tag/online" class="flex items-center justify-center p-4 bg-[#002a3a] rounded-lg hover:bg-[#003a52] transition-colors duration-200 group">
                        <span class="text-cyan-400 group-hover:text-cyan-300">Toate Filmele</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Analytics Tracking -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Track 404 error
        if (typeof gtag !== 'undefined') {
            gtag('event', 'page_view', {
                'event_category': '404_error',
                'event_label': window.location.pathname,
                'referrer': document.referrer
            });
        }
    });
</script>

<?php get_template_part('template-parts/footer'); ?>