<?php
/*
Template Name: Filme Actiune 2025
*/

/**
 * @var WP_Query $wp_query WordPress main query object
 */

get_template_part('template-parts/header');

// Get current page for pagination
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

?>
<main id="main-content" role="main" itemscope itemtype="https://schema.org/CollectionPage" class="bg-[#001f2d] text-[#f2f2f2] min-h-screen py-12">
    <?php
    echo '<div class="max-w-4xl mx-auto px-4">';
    echo '<article class="bg-[#002a3a] rounded-xl shadow-lg overflow-hidden border border-cyan-400/30">';
    if ($paged < 2) {
        ?>

        <!-- Hero Section -->
        <div class="relative overflow-hidden p-8 pb-5 border-b border-cyan-400/20">
            <div class="absolute top-0 right-0 w-72 h-72 bg-cyan-400/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative">
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="px-3 py-1 text-xs font-bold tracking-widest uppercase bg-cyan-400/10 border border-cyan-400/40 text-cyan-400 rounded-full">2025</span>
                    <span class="px-3 py-1 text-xs font-semibold tracking-wide uppercase bg-[#003a52] border border-cyan-400/20 text-gray-300 rounded-full">Acțiune</span>
                </div>

                <h1 class="text-3xl sm:text-4xl font-black mb-3 leading-tight">
                    <span class="bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">Filme acțiune 2025</span>
                    <span class="text-[#f2f2f2]"> – cele mai bune de văzut</span>
                </h1>

                <p class="text-gray-300 text-base leading-relaxed mb-4 max-w-2xl">
                    Cauți <strong class="text-[#f2f2f2]">filme acțiune 2025</strong> de văzut? Selecție cu cele mai bune filme de acțiune noi – de la thrillere cu Jason Statham, la blockbustere pe Netflix, Amazon și HBO Max.
                </p>

                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">⚡ Thriller</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">🎬 Blockbuster</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">🚀 Sci-Fi</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">🕵️ Spionaj</span>
                </div>
            </div>
        </div>

        <!-- Body content -->
        <div class="px-8 pt-5 pb-8">

            <!-- Important callout -->
            <div class="border-l-4 border-amber-400 bg-amber-400/10 px-4 py-3 rounded-r-lg text-sm text-gray-300">
                <strong class="text-amber-400">Important:</strong> Lista completă cu filme se află mai jos, după acest text. Intră în pagina fiecărui film și, după trailer, vei găsi link-ul direct de vizionare.
            </div>

            <!-- Top ranked films -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Top filme acțiune 2025</h2>
                <p class="text-gray-400 text-sm mb-4">Cele mai apreciate <strong class="text-[#f2f2f2]">filme de acțiune din 2025</strong>, disponibile online sau recent lansate în cinematografe:</p>

                <div class="space-y-3">
                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">1</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">Balerina (2025)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">Spin-off al seriei John Wick, cu Ana de Armas în rol principal. O asasină caută răzbunare într-un film cu coregrafie de luptă spectaculoasă.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">2</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">Cleaner (2025)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">Jason Statham joacă un fost operator de forțe speciale prins între loialitate și supraviețuire. Thriller de acțiune intens, cu ritm susținut.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">3</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">Warfare (2025)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">Dramă de război bazată pe o misiune reală a Navy SEALs în Irak. Regie Alex Garland – autentică, brutală și fără concesii.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">4</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">The Amateur / Amatorul (2025)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">Rami Malek joacă un analist CIA care devine agent de teren pentru a-și răzbuna soția. Thriller de spionaj cu umor negru și ritm alert.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">5</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">Mission: Impossible – The Final Reckoning (2025)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">Tom Cruise în ultimul capitol al seriei. Cascade reale, acțiune non-stop și un final promis ca cel mai spectaculos din franciză.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">6</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">Thunderbolts* (2025)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">Marvel reunește anti-eroii: Florence Pugh, Sebastian Stan și o echipă de personaje imperfecte trimise într-o misiune imposibilă.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Platforms section -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Filme acțiune 2025 pe Netflix și alte platforme</h2>
                <p class="text-gray-300 text-sm leading-relaxed mb-4">Vrei <strong class="text-[#f2f2f2]">filme acțiune 2025 online</strong>? Platformele de streaming au acoperire bună în 2025. Verifică pagina fiecărui film pe Film Bun – linkul de streaming apare după trailer.</p>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">Netflix</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">Amazon Prime Video</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">HBO Max</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">SkyShowtime</span>
                </div>
            </div>

            <!-- Jason Statham section -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Filme acțiune 2025 cu Jason Statham</h2>
                <div class="border-l-4 border-cyan-400 pl-5 py-1">
                    <p class="text-gray-300 text-sm leading-relaxed">Jason Statham este cel mai căutat actor de acțiune al anului. Marele său film din 2025 este <strong class="text-[#f2f2f2]">Cleaner</strong> – un thriller în care joacă un profesionist tăcut și periculos, prins într-o misiune ce scapă de sub control. Statham continuă să domine genul cu roluri care îmbină acțiunea fizică cu tensiunea psihologică. Îl găsești direct în lista de mai jos sau pe pagina <a href="/actiune" class="text-cyan-400 hover:text-cyan-300 underline underline-offset-2 transition-colors">filme acțiune</a>.</p>
                </div>
            </div>

            <!-- FAQ section -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Întrebări frecvente</h2>
                <div class="space-y-3">
                    <div class="border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40">
                        <p class="text-[#f2f2f2] font-semibold text-sm mb-2">Care sunt cele mai bune filme de acțiune din 2025?</p>
                        <p class="text-gray-400 text-sm leading-relaxed">Cele mai apreciate <strong class="text-gray-300">filme acțiune 2025</strong> sunt: <em>Balerina</em> (spin-off John Wick), <em>Mission: Impossible – The Final Reckoning</em>, <em>Warfare</em>, <em>Cleaner</em> cu Jason Statham și <em>Thunderbolts*</em> de la Marvel. Le găsești pe toate în lista de mai jos.</p>
                    </div>

                    <div class="border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40">
                        <p class="text-[#f2f2f2] font-semibold text-sm mb-2">Unde pot vedea filme de acțiune din 2025 online?</p>
                        <p class="text-gray-400 text-sm leading-relaxed">Filmele de acțiune 2025 sunt disponibile pe Netflix, Amazon Prime Video, HBO Max și SkyShowtime – în funcție de distribuitor. Pe Film Bun găsești linkul de vizionare direct în pagina fiecărui film, după trailer.</p>
                    </div>

                    <div class="border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40">
                        <p class="text-[#f2f2f2] font-semibold text-sm mb-2">Ce filme cu Jason Statham apar în 2025?</p>
                        <p class="text-gray-400 text-sm leading-relaxed">Principalul film cu <strong class="text-gray-300">Jason Statham în 2025</strong> este <em>Cleaner</em>, thriller de acțiune în care joacă un fost operator de forțe speciale. Este unul din cele mai așteptate <strong class="text-gray-300">filme acțiune 2025</strong> ale anului.</p>
                    </div>
                </div>
            </div>

            <!-- Explorează mai mult - link buttons -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Explorează mai mult</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="/actiune" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">🎬 Filme Acțiune</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                    <a href="/an/2025" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">📅 Filme 2025</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                    <a href="/thriller" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">🕵️ Filme Thriller</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                    <a href="/comedie" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">😄 Filme Comedie</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                </div>
            </div>

        </div>

        <?php
    } else {
        echo '<div class="p-6 border-b border-cyan-400/20">';
        echo '<h1 class="text-2xl sm:text-3xl font-black leading-tight">';
        echo '<span class="bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">Filme acțiune 2025</span>';
        echo ' <span class="text-[#f2f2f2]">– Pagina ' . intval($paged) . '</span>';
        echo '</h1>';
        echo '<p class="text-gray-400 text-sm mt-2">Continuare listă • <a href="/actiune-2025" class="text-cyan-400 hover:underline">← Înapoi la pagina 1</a></p>';
        echo '</div>';
    }
    echo '</article>';
    echo '</div>';

    // Query posts
    $args = array(
        'category_name' => 'actiune',
        'paged'        => $paged,
        'post_type'    => 'post',
        'tax_query'    => array(
            array(
                'taxonomy' => 'an',
                'field'    => 'slug',
                'terms'    => '2025'
            )
        )
    );

    $custom_query = new WP_Query($args);

    // Set temporary query
    $temp_query = $wp_query;
    $wp_query   = $custom_query;
    ?>

    <section id="movies-list" class="mt-8">
        <div class="max-w-6xl mx-auto px-4">
            <?php if ($custom_query->have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" itemprop="about" itemscope itemtype="https://schema.org/ItemList">
                    <?php while ($custom_query->have_posts()) :
                        $custom_query->the_post();
                        get_template_part('template-parts/content');
                    endwhile; ?>
                </div>
                <nav class="mt-8 flex items-center justify-center space-x-2" aria-label="Navigare pagini" role="navigation">
                    <?php get_template_part('template-parts/pagination'); ?>
                </nav>
            <?php else : ?>
                <p class="text-center py-8">Nu au fost găsite filme care să corespundă criteriilor.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
// Restore original query
$wp_query = $temp_query;
wp_reset_postdata();

get_template_part('template-parts/footer');
