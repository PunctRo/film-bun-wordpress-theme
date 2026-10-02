<?php
/*
Template Name: Românești Online
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
                    <span class="px-3 py-1 text-xs font-bold tracking-widest uppercase bg-cyan-400/10 border border-cyan-400/40 text-cyan-400 rounded-full">Românești</span>
                    <span class="px-3 py-1 text-xs font-semibold tracking-wide uppercase bg-[#003a52] border border-cyan-400/20 text-gray-300 rounded-full">Online</span>
                </div>

                <h1 class="text-3xl sm:text-4xl font-black mb-3 leading-tight">
                    <span class="bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">Filme online românești</span>
                    <span class="text-[#f2f2f2]"> – unde le poți vedea legal în 2026</span>
                </h1>

                <p class="text-gray-300 text-base leading-relaxed mb-4 max-w-2xl">
                    Cauți <strong class="text-[#f2f2f2]">filme online românești</strong>? Ai ajuns unde trebuie. Găsești aici producții noi și vechi, comedii, drame și documentare – cu linkuri directe către platformele legale de streaming.
                </p>

                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">🎭 Comedie</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">🎬 Dramă</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">📽️ Documentar</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">📡 Streaming legal</span>
                </div>
            </div>
        </div>

        <!-- Body content -->
        <div class="px-8 pt-5 pb-8">

            <!-- Important callout -->
            <div class="border-l-4 border-amber-400 bg-amber-400/10 px-4 py-3 rounded-r-lg text-sm text-gray-300">
                <strong class="text-amber-400">Important:</strong> Lista cu filmele disponibile se află mai jos, după acest text. Intră în articolul fiecărui film și, după trailer, vei găsi link-ul direct de vizionare.
            </div>

            <!-- Top films -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Cele mai bune filme românești online</h2>
                <p class="text-gray-400 text-sm mb-4">Cele mai apreciate <strong class="text-[#f2f2f2]">filme românești disponibile online</strong>, de la drame premiate la comedii populare:</p>

                <div class="space-y-3">
                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">1</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">Anul Nou care n-a fost (2024)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed"><em class="text-gray-500">Regie: Bogdan Mureșanu</em> – Dramă despre ultimele zile ale comunismului. Surprinde fricile și speranțele românilor înainte de Revoluția din 1989.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">2</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">Două lozuri (2016)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed"><em class="text-gray-500">Regie: Paul Negoescu</em> – Comedie despre trei prieteni și un bilet de loterie care le pune prietenia la încercare. Umor tipic românesc, ritm alert.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">3</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">Complet Necunoscuți (2021)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed"><em class="text-gray-500">Regie: Octavian Strunilă</em> – Versiunea românească a filmului „Perfetti Sconosciuti". Comedie amară despre secrete dezvăluite printr-un joc cu telefoanele mobile.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">4</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">6.9 pe Scara Richter (2016)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed"><em class="text-gray-500">Regie: Nae Caranfil</em> – Comedie muzicală rară în cinematografia românească. Plină de energie și replici memorabile.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">5</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">Luca (2020)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed"><em class="text-gray-500">Regie: Horațiu Mălăele</em> – Film emoționant despre un bărbat întors în țară după o lungă absență, confruntat cu amintiri și regrete.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Platforms section -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Unde găsești filme românești online (legal)</h2>
                <p class="text-gray-300 text-sm leading-relaxed mb-4">Vrei <strong class="text-[#f2f2f2]">filme românești online</strong>? Platformele de streaming au acoperire bună. Verifică pagina fiecărui film pe Film Bun – linkul de streaming apare după trailer.</p>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">Netflix</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">HBO Max</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">Amazon Prime Video</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">SkyShowtime</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">Voyo</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">CINEPUB (gratuit)</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">AntenaPLAY</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">YouTube CINEPUB</span>
                </div>
            </div>

            <!-- Old films section -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Filme românești vechi online</h2>
                <div class="border-l-4 border-cyan-400 pl-5 py-1">
                    <p class="text-gray-300 text-sm leading-relaxed">Cauți <strong class="text-[#f2f2f2]">filme românești vechi online</strong>? Cele mai bune surse sunt <strong class="text-[#f2f2f2]">CINEPUB</strong> și canalul lor oficial de YouTube. Acolo găsești lungmetraje de colecție gratuit și legal – inclusiv titluri de dinainte de 1989, de la comedii clasice la filme istorice. Pe <a href="/romanesti" class="text-cyan-400 hover:text-cyan-300 underline underline-offset-2 transition-colors">pagina noastră de filme românești</a> găsești recomandări filtrate după gen și perioadă.</p>
                </div>
            </div>

            <!-- Free films section -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Filme românești online gratuite: ce trebuie să știi</h2>
                <div class="border-l-4 border-cyan-400 pl-5 py-1">
                    <p class="text-gray-300 text-sm leading-relaxed">Pentru <strong class="text-[#f2f2f2]">filme românești online gratis</strong>, alege surse legale. <strong class="text-[#f2f2f2]">CINEPUB</strong> și canalul YouTube CINEPUB oferă gratuit zeci de titluri – inclusiv comedii populare precum <em>Două lozuri</em> sau <em>Complet Necunoscuți</em>. <strong class="text-[#f2f2f2]">AntenaPLAY</strong> are și el o secțiune gratuită cu producții românești. Folosind aceste platforme, susții direct cinematografia autohtonă.</p>
                </div>
            </div>

            <!-- FAQ section -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Întrebări frecvente</h2>
                <div class="space-y-3">
                    <div class="border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40">
                        <p class="text-[#f2f2f2] font-semibold text-sm mb-2">Unde pot vedea filme românești online gratis?</p>
                        <p class="text-gray-400 text-sm leading-relaxed">Cele mai bune opțiuni gratuite sunt <strong class="text-gray-300">CINEPUB</strong> (cinepub.ro) și canalul <strong class="text-gray-300">CINEPUB pe YouTube</strong> – ambele 100% legale, fără abonament. <strong class="text-gray-300">AntenaPLAY</strong> are de asemenea titluri românești gratuite în secțiunea dedicată.</p>
                    </div>

                    <div class="border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40">
                        <p class="text-[#f2f2f2] font-semibold text-sm mb-2">Care sunt cele mai bune comedii românești online?</p>
                        <p class="text-gray-400 text-sm leading-relaxed">Comedii românești de neratat: <em>Două lozuri</em> (2016), <em>Complet Necunoscuți</em> (2021), <em>Nuntă pe bani</em> (2023) și <em>Căsătoria</em> (2024). Le găsești pe platformele de mai sus sau direct în lista noastră de <a href="/comedie" class="text-cyan-400 hover:text-cyan-300 underline underline-offset-2 transition-colors">filme românești de comedie</a>.</p>
                    </div>

                    <div class="border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40">
                        <p class="text-[#f2f2f2] font-semibold text-sm mb-2">Unde găsesc filme românești vechi online?</p>
                        <p class="text-gray-400 text-sm leading-relaxed">Mergi pe <strong class="text-gray-300">CINEPUB</strong> sau pe YouTube (caută „CINEPUB lungmetraj"). Acolo găsești titluri de dinainte de 1989 – comedii clasice, drame și filme istorice românești – integral și gratuit.</p>
                    </div>
                </div>
            </div>

            <!-- Explorează mai mult - link buttons -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Explorează mai mult</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="/filme-romanesti-2024" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">📅 Filme Românești 2024</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                    <a href="/romanesti" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">🎬 Filme Românești</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                    <a href="/filme-romanesti-netflix" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">📺 Filme Românești Netflix</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                    <a href="/comedie" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">😄 Comedii Românești</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                </div>
            </div>

        </div>

        <?php
    } else {
        echo '<div class="p-6 border-b border-cyan-400/20">';
        echo '<h1 class="text-2xl sm:text-3xl font-black leading-tight">';
        echo '<span class="bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">Filme online românești</span>';
        echo ' <span class="text-[#f2f2f2]">– Pagina ' . intval($paged) . '</span>';
        echo '</h1>';
        echo '<p class="text-gray-400 text-sm mt-2">Continuare listă • <a href="/filme-romanesti-online" class="text-cyan-400 hover:underline">← Înapoi la pagina 1</a></p>';
        echo '</div>';
    }
    echo '</article>';
    echo '</div>';

    // Query posts
    $args = array(
        'category_name' => 'romanesti',
        'tag'          => 'online',
        'paged'        => $paged,
        'post_type'    => 'post'
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
