<?php
/*
Template Name: Filme Horror 2025
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
                    <span class="px-3 py-1 text-xs font-semibold tracking-wide uppercase bg-[#003a52] border border-cyan-400/20 text-gray-300 rounded-full">Horror</span>
                </div>

                <h1 class="text-3xl sm:text-4xl font-black mb-3 leading-tight">
                    <span class="bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">Filme horror 2025</span>
                    <span class="text-[#f2f2f2]"> – cele mai bune de văzut</span>
                </h1>

                <p class="text-gray-300 text-base leading-relaxed mb-4 max-w-2xl">
                    Cauți <strong class="text-[#f2f2f2]">filme horror 2025</strong> de văzut? Selecție cu cele mai bune filme horror noi – de la thrillere supranaturale și slashere intense, la horror psihologic și producții lansate pe Netflix, HBO Max și în cinema.
                </p>

                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">👻 Supranatural</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">🔪 Slasher</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">🧠 Psihologic</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs bg-[#003a52] border border-cyan-400/20 rounded-full text-gray-300">🎥 Found Footage</span>
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
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Top filme horror 2025</h2>
                <p class="text-gray-400 text-sm mb-4">Cele mai apreciate <strong class="text-[#f2f2f2]">filme de horror din 2025</strong>, disponibile online sau recent lansate în cinematografe:</p>

                <div class="space-y-3">
                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">1</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base"><a href="/horror/sinners-2025/" class="hover:text-cyan-400 transition-colors">Sinners (2025)</a></strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">Ryan Coogler semnează unul dintre cele mai originale filme horror ale anului. Michael B. Jordan joacă dublu – doi frați gemeni care deschid un club de blues în Mississippi anilor '30, unde amenințarea nu vine de unde te aștepți. Horror cu rădăcini în folclor și ritm de thriller modern.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">2</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base"><a href="/horror/telefonul-negru-2-2025/" class="hover:text-cyan-400 transition-colors">Telefonul Negru 2 (2025)</a></strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">Black Phone 2 transformă franciza într-un horror supranatural pur. Răufăcătorul atacă în vise – o schimbare îndrăzneață față de primul film. Gwen devine centrul poveștii, iar tensiunea psihologică crește constant până la final.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">3</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base"><a href="/horror/final-destination-bloodlines-2025/" class="hover:text-cyan-400 transition-colors">Final Destination Bloodlines (2025)</a></strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">O revenire sângeroasă și surprinzător de proaspătă pentru o franciză pe care o credeam epuizată. Destinație Finală: Succesorii reia rețeta clasică a premoniției și a morții inevitabile – cu secvențe inventive și un ritm susținut de la primul cadru.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">4</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">The Monkey (2025)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">Adaptare după Stephen King, regizată de Osgood Perkins (<em>Longlegs</em>). O maimuță mecanică aduce moartea tuturor celor din jur. Perkins transformă premisa absurdă într-un film tensionat, cu umor negru și scene de groază autentice.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">5</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base">Wolf Man (2025)</strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">Leigh Whannell revine după succesul lui <em>The Invisible Man</em> cu o reimaginare a clasicului om-lup. Christopher Abbott joacă un tată care se transformă treptat – mai mult film de groază psihologică decât monster movie clasic.</p>
                        </div>
                    </div>

                    <div class="relative border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40 hover:border-cyan-400/40 hover:bg-[#003a52] transition-all duration-300 group">
                        <span class="absolute top-3 right-4 text-5xl font-black text-cyan-400/10 leading-none select-none group-hover:text-cyan-400/20 transition-colors">6</span>
                        <div class="pr-10">
                            <strong class="text-[#f2f2f2] text-base"><a href="/horror/companion-2025/" class="hover:text-cyan-400 transition-colors">Companion (2025)</a></strong>
                            <p class="text-gray-400 text-sm mt-1 leading-relaxed">Thriller horror cu elemente SF. Sophie Thatcher și Jack Quaid într-o relație ce ascunde un secret întunecat. Combină paranoia cu horror-ul de gen, cu un twist bine construit și o interpretare memorabilă din partea lui Thatcher.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Platforms section -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Filme horror 2025 online – Netflix, HBO Max și altele</h2>
                <p class="text-gray-300 text-sm leading-relaxed mb-4">Vrei <strong class="text-[#f2f2f2]">filme horror 2025 online</strong>? Platformele de streaming au acoperire bună în 2025. Verifică pagina fiecărui film pe Film Bun – linkul de streaming apare după trailer.</p>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">Netflix</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">HBO Max</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">Amazon Prime Video</span>
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-[#003a52] border border-cyan-400/30 text-[#f2f2f2] rounded-lg">SkyShowtime</span>
                </div>
            </div>

            <!-- Cinema section -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Filme horror 2025 lansate în cinema</h2>
                <div class="border-l-4 border-cyan-400 pl-5 py-1">
                    <p class="text-gray-300 text-sm leading-relaxed">Câteva dintre cele mai așteptate <strong class="text-[#f2f2f2]">filme horror 2025 în cinema</strong> au avut lansări internaționale remarcabile. <em>Sinners</em> a fost una dintre surprizele anului la box office, cu o deschidere puternică în România. <em>The Monkey</em> și <em>Wolf Man</em> au deschis sezonul horror de primăvară. Le găsești pe toate în lista de mai jos – cu disponibilitate actualizată pentru streaming sau cinema.</p>
                </div>
            </div>

            <!-- FAQ section -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Întrebări frecvente</h2>
                <div class="space-y-3">
                    <div class="border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40">
                        <p class="text-[#f2f2f2] font-semibold text-sm mb-2">Care sunt cele mai bune filme horror din 2025?</p>
                        <p class="text-gray-400 text-sm leading-relaxed">Cele mai apreciate <strong class="text-gray-300">filme horror 2025</strong> sunt: <em>Sinners</em> (Ryan Coogler), <em>The Monkey</em> (adaptare Stephen King), <em>Wolf Man</em> (Leigh Whannell), <em>Presence</em> (Soderbergh) și <em>Companion</em>. Le găsești pe toate în lista de mai jos.</p>
                    </div>

                    <div class="border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40">
                        <p class="text-[#f2f2f2] font-semibold text-sm mb-2">Unde pot vedea filme horror 2025 online?</p>
                        <p class="text-gray-400 text-sm leading-relaxed"><strong class="text-gray-300">Filmele horror 2025 online</strong> sunt disponibile pe Netflix, HBO Max, Amazon Prime Video și SkyShowtime – în funcție de distribuitor. Pe Film Bun găsești linkul de vizionare direct în pagina fiecărui film, după trailer.</p>
                    </div>

                    <div class="border border-cyan-400/20 rounded-lg p-4 bg-[#001f2d]/40">
                        <p class="text-[#f2f2f2] font-semibold text-sm mb-2">Ce filme horror noi au apărut în 2025?</p>
                        <p class="text-gray-400 text-sm leading-relaxed">Printre cele mai notabile <strong class="text-gray-300">filme horror noi 2025</strong> se numără <em>Sinners</em>, <em>The Monkey</em>, <em>Wolf Man</em>, <em>Presence</em>, <em>Companion</em> și <em>Death of a Unicorn</em>. Genul a fost bine reprezentat în 2025, cu producții atât pentru fanii horror-ului clasic, cât și pentru cei care preferă abordări mai experimentale.</p>
                    </div>
                </div>
            </div>

            <!-- Explorează mai mult - link buttons -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-cyan-400 mb-3">Explorează mai mult</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="/horror/" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">🎃 Filme Horror</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                    <a href="/an/2025/" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">📅 Filme 2025</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                    <a href="/thriller/" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">🔪 Filme Thriller</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                    <a href="/filme-actiune-2025/" class="group flex items-center justify-between px-4 py-3 rounded-lg bg-[#003a52] border border-cyan-400/30 hover:border-cyan-400 hover:bg-[#004a62] transition-all duration-200">
                        <span class="text-sm text-gray-300 group-hover:text-[#f2f2f2] transition-colors">💥 Filme Acțiune 2025</span>
                        <span class="text-cyan-400 group-hover:translate-x-1 transition-transform inline-block">→</span>
                    </a>
                </div>
            </div>

        </div>

        <?php
    } else {
        echo '<div class="p-6 border-b border-cyan-400/20">';
        echo '<h1 class="text-2xl sm:text-3xl font-black leading-tight">';
        echo '<span class="bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">Filme horror 2025</span>';
        echo ' <span class="text-[#f2f2f2]">– Pagina ' . intval($paged) . '</span>';
        echo '</h1>';
        echo '<p class="text-gray-400 text-sm mt-2">Continuare listă • <a href="/horror-2025" class="text-cyan-400 hover:underline">← Înapoi la pagina 1</a></p>';
        echo '</div>';
    }
    echo '</article>';
    echo '</div>';

    // Query posts
    $args = array(
        'category_name' => 'horror',
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
