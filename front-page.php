<?php get_template_part('template-parts/header'); ?>

<main id="main-content" role="main" itemscope itemtype="https://schema.org/CollectionPage">
  <?php if (!is_paged()) : ?>
    <section class="hero-marquee" aria-label="Hero section" itemprop="mainContentOfPage">

      <!-- Top marquee row: 4 identical sets for seamless infinite scroll -->
      <div class="marquee-row marquee-row--top">
        <div class="marquee-set">
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Dramă</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Thriller</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Acțiune</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Documentar</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Comedie</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Fantastic</div><div class="poster__year">2025</div></div></article>
        </div>
        <div class="marquee-set" aria-hidden="true">
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Dramă</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Thriller</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Acțiune</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Documentar</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Comedie</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Fantastic</div><div class="poster__year">2025</div></div></article>
        </div>
        <div class="marquee-set" aria-hidden="true">
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Dramă</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Thriller</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Acțiune</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Documentar</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Comedie</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Fantastic</div><div class="poster__year">2025</div></div></article>
        </div>
        <div class="marquee-set" aria-hidden="true">
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Dramă</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Thriller</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Acțiune</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Documentar</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Comedie</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Fantastic</div><div class="poster__year">2025</div></div></article>
        </div>
      </div>

      <!-- Bottom marquee row: different genres, slower speed for parallax -->
      <div class="marquee-row marquee-row--bottom">
        <div class="marquee-set">
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Mister</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">SF</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Romantic</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Animație</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Aventură</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Crimă</div><div class="poster__year">2026</div></div></article>
        </div>
        <div class="marquee-set" aria-hidden="true">
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Mister</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">SF</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Romantic</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Animație</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Aventură</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Crimă</div><div class="poster__year">2026</div></div></article>
        </div>
        <div class="marquee-set" aria-hidden="true">
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Mister</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">SF</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Romantic</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Animație</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Aventură</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Crimă</div><div class="poster__year">2026</div></div></article>
        </div>
        <div class="marquee-set" aria-hidden="true">
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Mister</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">SF</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Romantic</div><div class="poster__year">2026</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Animație</div><div class="poster__year">2025</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Aventură</div><div class="poster__year">2024</div></div></article>
          <article class="poster"><div class="poster__image"></div><div class="poster__label"><div class="poster__genre">Crimă</div><div class="poster__year">2026</div></div></article>
        </div>
      </div>

      <!-- Fades to keep marquee subtle behind copy -->
      <div class="hero__center-fade"></div>
      <div class="hero__side-fade"></div>
      <!-- Bottom fade to blend into the next section -->
      <div class="hero__bottom-fade"></div>

      <!-- Hero copy & CTA -->
      <div class="hero__content">
        <h1 class="hero__title" itemprop="headline">
          <span class="hero__title-accent">Filme Bune</span> Recomandate –<br />
          Selecție din Toate Genurile
        </h1>
        <p class="hero__subtitle" itemprop="description">
          Găsește aici, rapid, recomandarea perfectă –
          <span class="hero__subtitle-accent">filme bune</span>,
          pe gustul tău, și unde le poți vedea.
        </p>
      </div>
    </section>
  <?php endif; ?>

  <?php if (is_paged()) : ?>
    <section class="bg-[#001f2d] text-[#f2f2f2] py-8" itemprop="mainContentOfPage">
      <div class="max-w-6xl mx-auto px-4">
        <div class="prose prose-invert mx-auto">
          <h1 class="text-4xl font-bold text-center mb-4" itemprop="headline">
            Cele Mai Bune Filme Noi - Pagina <?php echo get_query_var('paged'); ?>
          </h1>
          <p class="text-center text-lg mb-2" itemprop="description">
            Filme bune – filme noi – recomandări de film – totul aici, pe Film Bun, ghidul tău complet pentru experiențe de neuitat.
          </p>
          <p class="text-center text-sm text-gray-400" aria-label="Informații paginare">
            <?php global $wp_query; ?>
            <span>Pagina <?php echo get_query_var('paged'); ?> din <?php echo $wp_query->max_num_pages; ?></span>
            <meta itemprop="pageStart" content="<?php echo get_query_var('paged'); ?>">
            <meta itemprop="pageEnd" content="<?php echo $wp_query->max_num_pages; ?>">
          </p>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <section id="movies-list" class="relative py-8 md:py-12 bg-[#001f2d] text-[#f2f2f2] scroll-mt-24" itemprop="mainContentOfPage">
    <div class="max-w-6xl mx-auto px-4">
      <?php if (!is_paged()) : ?>
        <header class="text-center mb-8 md:mb-10">
          <h2 class="text-3xl md:text-4xl font-bold mb-4" itemprop="headline">
            Cele Mai Bune <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Filme Noi</span>
          </h2>
          <p class="text-gray-300 text-base md:text-lg max-w-3xl mx-auto leading-relaxed">
            Filme noi în 2026, alese unul câte unul de echipa Film-Bun. Nu listăm tot ce apare &mdash; punem aici doar
            filmele bune, cele care merită o seară liberă. Fiecare are o notă, un rezumat scurt fără spoilere și locul
            unde îl poți vedea.
          </p>
        </header>
      <?php endif; ?>
      <?php if (have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-parts/content'); ?>
          <?php endwhile; ?>
        </div>
        <nav class="mt-8 flex items-center justify-center space-x-2" aria-label="Navigare pagini" role="navigation">
          <?php
          // Add context for pagination
          add_filter('the_posts_pagination_args', function ($args) {
            $args['aria-label'] = 'Navigare pagini filme';
            return $args;
          });
          get_template_part('template-parts/pagination');
          ?>
        </nav>
      <?php else : ?>
        <p class="text-center"><?php _e('No posts found.', 'textdomain'); ?></p>
      <?php endif; // end of have_posts
      ?>
    </div>
  </section>

  <?php if (!is_paged()) : ?>
    <section id="streaming-platforms" class="relative pt-20 pb-8 md:pt-24 md:pb-12 bg-[#001f2d] text-[#f2f2f2] scroll-mt-24 z-10" itemprop="hasPart">
      <!-- Ambient Background Glow -->
      <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden text-center opacity-20">
        <div class="absolute top-[20%] left-[10%] w-64 h-64 bg-cyan-500 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[20%] right-[10%] w-64 h-64 bg-purple-500 rounded-full blur-[100px]"></div>
      </div>

      <div class="relative max-w-7xl mx-auto px-4">
        <!-- Section Header -->
        <header class="text-center mb-8 md:mb-10">
          <h2 class="text-3xl md:text-4xl font-bold mb-4" itemprop="name">
            Platforme de streaming recomandate pentru <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">filme bune</span>
          </h2>
          <p class="text-gray-400 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed">
            Platformele de streaming de top pentru filme de calitate, cu <strong class="text-gray-200">subtitrare</strong> și experiență premium.
          </p>
        </header>

        <!-- Use a tighter grid for mobile (2 columns) and standard for desktop -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 md:gap-6 lg:gap-8" itemprop="about" itemscope itemtype="https://schema.org/ItemList">

          <!-- Netflix -->
          <a href="/tag/netflix" class="group block relative" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="bg-[#002a3a]/40 backdrop-blur-md border border-white/5 rounded-2xl p-6 h-full transition-all duration-300 group-hover:bg-[#002a3a]/60 group-hover:border-red-500/30 group-hover:-translate-y-2 group-hover:shadow-[0_0_20px_rgba(229,9,20,0.15)] flex flex-col items-center justify-center text-center">
              <div class="relative w-24 h-16 md:w-32 md:h-20 mb-3 flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Filme-Online-Pe-Netflix.webp"
                  alt="Filme bune pe Netflix"
                  class="object-contain w-full h-full drop-shadow-lg"
                  width="160" height="160" loading="lazy" itemprop="image" />
              </div>
              <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors" itemprop="name">Netflix</span>
            </div>
            <meta itemprop="position" content="1">
          </a>

          <!-- Max -->
          <a href="/tag/hbo-max" class="group block relative" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="bg-[#002a3a]/40 backdrop-blur-md border border-white/5 rounded-2xl p-6 h-full transition-all duration-300 group-hover:bg-[#002a3a]/60 group-hover:border-blue-500/30 group-hover:-translate-y-2 group-hover:shadow-[0_0_20px_rgba(0,100,255,0.15)] flex flex-col items-center justify-center text-center">
              <div class="relative w-24 h-16 md:w-32 md:h-20 mb-3 flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Filme-Online-Pe-Max.webp"
                  alt="Filme bune pe Max (HBO)"
                  class="object-contain w-full h-full drop-shadow-lg"
                  width="160" height="160" loading="lazy" itemprop="image" />
              </div>
              <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors" itemprop="name">HBO Max</span>
            </div>
            <meta itemprop="position" content="2">
          </a>

          <!-- SkyShowtime -->
          <a href="/tag/skyshowtime" class="group block relative" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="bg-[#002a3a]/40 backdrop-blur-md border border-white/5 rounded-2xl p-6 h-full transition-all duration-300 group-hover:bg-[#002a3a]/60 group-hover:border-yellow-500/30 group-hover:-translate-y-2 group-hover:shadow-[0_0_20px_rgba(255,215,0,0.15)] flex flex-col items-center justify-center text-center">
              <div class="relative w-24 h-16 md:w-32 md:h-20 mb-3 flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Filme-Online-Pe-SkyShowtime.webp"
                  alt="Filme bune pe SkyShowtime"
                  class="object-contain w-full h-full drop-shadow-lg"
                  width="160" height="160" loading="lazy" itemprop="image" />
              </div>
              <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors" itemprop="name">SkyShowTime</span>
            </div>
            <meta itemprop="position" content="3">
          </a>

          <!-- Amazon Prime -->
          <a href="/tag/amazon-prime-video" class="group block relative" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="bg-[#002a3a]/40 backdrop-blur-md border border-white/5 rounded-2xl p-6 h-full transition-all duration-300 group-hover:bg-[#002a3a]/60 group-hover:border-cyan-400/30 group-hover:-translate-y-2 group-hover:shadow-[0_0_20px_rgba(34,211,238,0.15)] flex flex-col items-center justify-center text-center">
              <div class="relative w-24 h-16 md:w-32 md:h-20 mb-3 flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Filme-Online-Pe-Amazonprimevideo.webp"
                  alt="Filme bune pe Amazon Prime"
                  class="object-contain w-full h-full drop-shadow-lg"
                  width="160" height="160" loading="lazy" itemprop="image" />
              </div>
              <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors" itemprop="name">Amazon Prime</span>
            </div>
            <meta itemprop="position" content="4">
          </a>

          <!-- Disney+ -->
          <a href="/tag/disney-plus" class="group block relative col-span-2 lg:col-span-1 lg:border-none lg:pt-0" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <!-- Center the 5th item on mobile by making it span 2 columns but centered content?
                 Actually col-span-2 makes it wide. Let's keep it centered. -->
            <div class="bg-[#002a3a]/40 backdrop-blur-md border border-white/5 rounded-2xl p-6 h-full transition-all duration-300 group-hover:bg-[#002a3a]/60 group-hover:border-blue-400/30 group-hover:-translate-y-2 group-hover:shadow-[0_0_20px_rgba(60,130,246,0.15)] flex flex-col items-center justify-center text-center w-full max-w-[50%] lg:max-w-full mx-auto">
              <div class="relative w-24 h-16 md:w-32 md:h-20 mb-3 flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Filme-Online-Pe-DisneyPlus.webp"
                  alt="Filme bune pe Disney+"
                  class="object-contain w-full h-full drop-shadow-lg"
                  width="160" height="160" loading="lazy" itemprop="image" />
              </div>
              <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors" itemprop="name">Disney+</span>
            </div>
            <meta itemprop="position" content="5">
          </a>

        </div>
      </div>
    </section>

    <!-- Top 10 Filme Section -->
    <section class="relative py-8 md:py-12 bg-[#001f2d] text-[#f2f2f2]" aria-label="Top 10 Filme" itemprop="hasPart" itemscope itemtype="https://schema.org/ItemList">
      <!-- Ambient glow -->
      <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-1/2 left-[5%] w-72 h-72 bg-amber-500/5 rounded-full blur-[100px]"></div>
        <div class="absolute top-1/2 right-[5%] w-72 h-72 bg-cyan-500/5 rounded-full blur-[100px]"></div>
      </div>

      <div class="relative max-w-7xl mx-auto px-4">
        <!-- Section Header -->
        <header class="text-center mb-8 md:mb-10">
          <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-sm font-semibold mb-4">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            Cele mai urmărite acum
          </div>
          <h2 class="text-3xl md:text-4xl font-bold mb-4" itemprop="name">
            Top 10 Filme – <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-orange-400">Selecțiile Lunii</span>
          </h2>
          <p class="text-gray-400 text-lg max-w-2xl mx-auto" itemprop="description">
            Cele mai bune filme din fiecare categorie, alese pe rând de echipa Film-Bun.
          </p>
        </header>

        <!-- Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">

          <!-- Netflix -->
          <a href="/top-10-filme-pe-netflix"
            class="group relative overflow-hidden rounded-2xl bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-red-500/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(229,9,20,0.12)] hover:-translate-y-1 flex flex-col"
            itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute top-3 left-3 z-10 flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-500/15 border border-red-500/25 text-red-400 text-xs font-bold">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              Top 10
            </div>
            <!-- Gradient bar -->
            <div class="h-1 w-full bg-gradient-to-r from-red-600 to-red-400 group-hover:from-red-500 group-hover:to-red-300 transition-all duration-300"></div>
            <div class="p-5 flex flex-col flex-grow">
              <div class="mt-5 mb-3 flex items-center gap-2">
                <span class="text-2xl md:text-3xl font-black text-red-500/30 group-hover:text-red-500/50 transition-colors leading-none select-none">N</span>
                <span class="text-base md:text-lg font-bold text-white group-hover:text-red-200 transition-colors" itemprop="name">Netflix</span>
              </div>
              <p class="text-xs text-gray-400 flex-grow">Cele mai bune filme disponibile acum pe Netflix, alese cu atenție.</p>
              <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-red-400 group-hover:text-red-300 transition-colors">
                <span>Vezi Top 10</span>
                <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </div>
            </div>
            <meta itemprop="position" content="1">
          </a>

          <!-- HBO Max -->
          <a href="/top-10-filme-pe-hbo-max"
            class="group relative overflow-hidden rounded-2xl bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-blue-500/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(59,130,246,0.12)] hover:-translate-y-1 flex flex-col"
            itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute top-3 left-3 z-10 flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-500/15 border border-blue-500/25 text-blue-400 text-xs font-bold">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              Top 10
            </div>
            <div class="h-1 w-full bg-gradient-to-r from-blue-600 to-blue-400 group-hover:from-blue-500 group-hover:to-blue-300 transition-all duration-300"></div>
            <div class="p-5 flex flex-col flex-grow">
              <div class="mt-5 mb-3 flex items-center gap-2">
                <span class="text-2xl md:text-3xl font-black text-blue-500/30 group-hover:text-blue-500/50 transition-colors leading-none select-none">M</span>
                <span class="text-base md:text-lg font-bold text-white group-hover:text-blue-200 transition-colors" itemprop="name">HBO Max</span>
              </div>
              <p class="text-xs text-gray-400 flex-grow">Producții premium și exclusivități HBO Max, selecționate pentru tine.</p>
              <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-blue-400 group-hover:text-blue-300 transition-colors">
                <span>Vezi Top 10</span>
                <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </div>
            </div>
            <meta itemprop="position" content="2">
          </a>

          <!-- SF -->
          <a href="/top-10-filme-sf"
            class="group relative overflow-hidden rounded-2xl bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-cyan-500/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(6,182,212,0.12)] hover:-translate-y-1 flex flex-col"
            itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute top-3 left-3 z-10 flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-cyan-500/15 border border-cyan-500/25 text-cyan-400 text-xs font-bold">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              Top 10
            </div>
            <div class="h-1 w-full bg-gradient-to-r from-cyan-600 to-cyan-400 group-hover:from-cyan-500 group-hover:to-cyan-300 transition-all duration-300"></div>
            <div class="p-5 flex flex-col flex-grow">
              <div class="mt-5 mb-3 flex items-center gap-2">
                <span class="text-2xl md:text-3xl font-black text-cyan-500/30 group-hover:text-cyan-500/50 transition-colors leading-none select-none">SF</span>
              </div>
              <p class="text-xs text-gray-400 flex-grow">Cele mai bune filme SF — de la distopii la aventuri galactice.</p>
              <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-cyan-400 group-hover:text-cyan-300 transition-colors">
                <span>Vezi Top 10</span>
                <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </div>
            </div>
            <meta itemprop="position" content="3">
            <meta itemprop="name" content="Top 10 Filme SF">
          </a>

          <!-- Comedie -->
          <a href="/top-10-filme-comedie"
            class="group relative overflow-hidden rounded-2xl bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-yellow-500/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(234,179,8,0.12)] hover:-translate-y-1 flex flex-col"
            itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute top-3 left-3 z-10 flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-yellow-500/15 border border-yellow-500/25 text-yellow-400 text-xs font-bold">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              Top 10
            </div>
            <div class="h-1 w-full bg-gradient-to-r from-yellow-600 to-yellow-400 group-hover:from-yellow-500 group-hover:to-yellow-300 transition-all duration-300"></div>
            <div class="p-5 flex flex-col flex-grow">
              <div class="mt-5 mb-3">
                <span class="text-base md:text-lg font-bold text-white group-hover:text-yellow-200 transition-colors" itemprop="name">Comedie</span>
              </div>
              <p class="text-xs text-gray-400 flex-grow">Filmele de comedie care chiar fac să râzi — râs garantat.</p>
              <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-yellow-400 group-hover:text-yellow-300 transition-colors">
                <span>Vezi Top 10</span>
                <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </div>
            </div>
            <meta itemprop="position" content="4">
          </a>

          <!-- Horror -->
          <a href="/top-10-filme-horror"
            class="group relative overflow-hidden rounded-2xl bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-gray-400/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(107,114,128,0.12)] hover:-translate-y-1 flex flex-col"
            itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute top-3 left-3 z-10 flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-gray-500/15 border border-gray-500/25 text-gray-300 text-xs font-bold">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              Top 10
            </div>
            <div class="h-1 w-full bg-gradient-to-r from-gray-600 to-gray-400 group-hover:from-gray-500 group-hover:to-gray-300 transition-all duration-300"></div>
            <div class="p-5 flex flex-col flex-grow">
              <div class="mt-5 mb-3">
                <span class="text-base md:text-lg font-bold text-white group-hover:text-gray-200 transition-colors" itemprop="name">Horror</span>
              </div>
              <p class="text-xs text-gray-400 flex-grow">Cele mai înfricoșătoare filme horror — pentru o seară cu adrenalină.</p>
              <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-gray-400 group-hover:text-gray-300 transition-colors">
                <span>Vezi Top 10</span>
                <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </div>
            </div>
            <meta itemprop="position" content="5">
          </a>

          <!-- Dragoste -->
          <a href="/top-10-filme-de-dragoste"
            class="group relative overflow-hidden rounded-2xl bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-pink-500/40 transition-all duration-300 hover:shadow-[0_0_30px_rgba(236,72,153,0.12)] hover:-translate-y-1 flex flex-col"
            itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute top-3 left-3 z-10 flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-pink-500/15 border border-pink-500/25 text-pink-400 text-xs font-bold">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              Top 10
            </div>
            <div class="h-1 w-full bg-gradient-to-r from-pink-600 to-pink-400 group-hover:from-pink-500 group-hover:to-pink-300 transition-all duration-300"></div>
            <div class="p-5 flex flex-col flex-grow">
              <div class="mt-5 mb-3">
                <span class="text-base md:text-lg font-bold text-white group-hover:text-pink-200 transition-colors" itemprop="name">Dragoste</span>
              </div>
              <p class="text-xs text-gray-400 flex-grow">Romanțele care îți taie respirația — povești de dragoste de neuitat.</p>
              <div class="mt-4 flex items-center gap-1 text-xs font-semibold text-pink-400 group-hover:text-pink-300 transition-colors">
                <span>Vezi Top 10</span>
                <svg class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </div>
            </div>
            <meta itemprop="position" content="6">
          </a>

        </div>
      </div>
    </section>

    <section class="relative py-8 md:py-12 bg-[#001f2d] text-[#f2f2f2]" itemprop="hasPart">
      <div class="max-w-7xl mx-auto px-4">
        <header class="text-center mb-8 md:mb-10">
          <h2 class="text-3xl md:text-4xl font-bold mb-4" itemprop="name">
            Descoperă filmele <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">după gen</span>
          </h2>
          <p class="text-gray-400 text-lg max-w-2xl mx-auto">
            De la drame captivante la comedii, găsește rapid genul care se potrivește stării tale.
          </p>
        </header>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6" itemprop="about" itemscope itemtype="https://schema.org/ItemList">

          <!-- Actiune -->
          <a href="/actiune" class="group relative overflow-hidden rounded-2xl aspect-[4/3] bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-red-500/30 transition-all duration-300 hover:shadow-[0_0_30px_rgba(239,68,68,0.15)] flex flex-col items-center justify-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 opacity-60 group-hover:opacity-80 transition-opacity"></div>

            <div class="relative z-10 flex flex-col items-center transform transition-transform duration-300 group-hover:-translate-y-1">
              <div class="w-16 h-16 md:w-20 md:h-20 mb-3 drop-shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/actiune.webp"
                  alt="Filme Acțiune"
                  class="w-full h-full object-contain filter brightness-110"
                  width="80" height="80" loading="lazy" itemprop="image">
              </div>
              <h3 class="text-lg md:text-xl font-bold text-white group-hover:text-red-300 transition-colors" itemprop="name">Acțiune</h3>
              <p class="text-xs text-gray-300 mt-1 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Adrenalină maximă</p>
            </div>
            <meta itemprop="position" content="1">
          </a>

          <!-- SF -->
          <a href="/sf" class="group relative overflow-hidden rounded-2xl aspect-[4/3] bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-cyan-500/30 transition-all duration-300 hover:shadow-[0_0_30px_rgba(6,182,212,0.15)] flex flex-col items-center justify-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 opacity-60 group-hover:opacity-80 transition-opacity"></div>

            <div class="relative z-10 flex flex-col items-center transform transition-transform duration-300 group-hover:-translate-y-1">
              <div class="w-16 h-16 md:w-20 md:h-20 mb-3 drop-shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/sf.webp"
                  alt="Filme SF"
                  class="w-full h-full object-contain filter brightness-110"
                  width="80" height="80" loading="lazy" itemprop="image">
              </div>
              <h3 class="text-lg md:text-xl font-bold text-white group-hover:text-cyan-300 transition-colors" itemprop="name">SF</h3>
              <p class="text-xs text-gray-300 mt-1 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Viitorul azi</p>
            </div>
            <meta itemprop="position" content="2">
          </a>

          <!-- Romanesti -->
          <a href="/romanesti" class="group relative overflow-hidden rounded-2xl aspect-[4/3] bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-blue-500/30 transition-all duration-300 hover:shadow-[0_0_30px_rgba(59,130,246,0.15)] flex flex-col items-center justify-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 opacity-60 group-hover:opacity-80 transition-opacity"></div>

            <div class="relative z-10 flex flex-col items-center transform transition-transform duration-300 group-hover:-translate-y-1">
              <div class="w-16 h-16 md:w-20 md:h-20 mb-3 drop-shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/romanesti.webp"
                  alt="Filme Românești"
                  class="w-full h-full object-contain filter brightness-110"
                  width="80" height="80" loading="lazy" itemprop="image">
              </div>
              <h3 class="text-lg md:text-xl font-bold text-white group-hover:text-blue-300 transition-colors" itemprop="name">Românești</h3>
              <p class="text-xs text-gray-300 mt-1 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Producții locale</p>
            </div>
            <meta itemprop="position" content="3">
          </a>

          <!-- Thriller -->
          <a href="/thriller" class="group relative overflow-hidden rounded-2xl aspect-[4/3] bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-violet-500/30 transition-all duration-300 hover:shadow-[0_0_30px_rgba(139,92,246,0.15)] flex flex-col items-center justify-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 opacity-60 group-hover:opacity-80 transition-opacity"></div>

            <div class="relative z-10 flex flex-col items-center transform transition-transform duration-300 group-hover:-translate-y-1">
              <div class="w-16 h-16 md:w-20 md:h-20 mb-3 drop-shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/thriller.webp"
                  alt="Filme Thriller"
                  class="w-full h-full object-contain filter brightness-110"
                  width="80" height="80" loading="lazy" itemprop="image">
              </div>
              <h3 class="text-lg md:text-xl font-bold text-white group-hover:text-violet-300 transition-colors" itemprop="name">Thriller</h3>
              <p class="text-xs text-gray-300 mt-1 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Mister intens</p>
            </div>
            <meta itemprop="position" content="4">
          </a>

          <!-- Horror -->
          <a href="/horror" class="group relative overflow-hidden rounded-2xl aspect-[4/3] bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-gray-500/30 transition-all duration-300 hover:shadow-[0_0_30px_rgba(107,114,128,0.15)] flex flex-col items-center justify-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 opacity-60 group-hover:opacity-80 transition-opacity"></div>

            <div class="relative z-10 flex flex-col items-center transform transition-transform duration-300 group-hover:-translate-y-1">
              <div class="w-16 h-16 md:w-20 md:h-20 mb-3 drop-shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/horror.webp"
                  alt="Filme Horror"
                  class="w-full h-full object-contain filter brightness-110"
                  width="80" height="80" loading="lazy" itemprop="image">
              </div>
              <h3 class="text-lg md:text-xl font-bold text-white group-hover:text-gray-300 transition-colors" itemprop="name">Horror</h3>
              <p class="text-xs text-gray-300 mt-1 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Frică și suspans</p>
            </div>
            <meta itemprop="position" content="5">
          </a>

          <!-- Drama -->
          <a href="/drama" class="group relative overflow-hidden rounded-2xl aspect-[4/3] bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-purple-500/30 transition-all duration-300 hover:shadow-[0_0_30px_rgba(168,85,247,0.15)] flex flex-col items-center justify-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 opacity-60 group-hover:opacity-80 transition-opacity"></div>

            <div class="relative z-10 flex flex-col items-center transform transition-transform duration-300 group-hover:-translate-y-1">
              <div class="w-16 h-16 md:w-20 md:h-20 mb-3 drop-shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/drama.webp"
                  alt="Filme Dramă"
                  class="w-full h-full object-contain filter brightness-110"
                  width="80" height="80" loading="lazy" itemprop="image">
              </div>
              <h3 class="text-lg md:text-xl font-bold text-white group-hover:text-purple-300 transition-colors" itemprop="name">Dramă</h3>
              <p class="text-xs text-gray-300 mt-1 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Emoție pură</p>
            </div>
            <meta itemprop="position" content="6">
          </a>

          <!-- Comedie -->
          <a href="/comedie" class="group relative overflow-hidden rounded-2xl aspect-[4/3] bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-yellow-500/30 transition-all duration-300 hover:shadow-[0_0_30px_rgba(234,179,8,0.15)] flex flex-col items-center justify-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 opacity-60 group-hover:opacity-80 transition-opacity"></div>

            <div class="relative z-10 flex flex-col items-center transform transition-transform duration-300 group-hover:-translate-y-1">
              <div class="w-16 h-16 md:w-20 md:h-20 mb-3 drop-shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/comedie.webp"
                  alt="Filme Comedie"
                  class="w-full h-full object-contain filter brightness-110"
                  width="80" height="80" loading="lazy" itemprop="image">
              </div>
              <h3 class="text-lg md:text-xl font-bold text-white group-hover:text-yellow-300 transition-colors" itemprop="name">Comedie</h3>
              <p class="text-xs text-gray-300 mt-1 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Râsete garantate</p>
            </div>
            <meta itemprop="position" content="7">
          </a>

          <!-- Dragoste -->
          <a href="/dragoste" class="group relative overflow-hidden rounded-2xl aspect-[4/3] bg-[#002a3a]/40 backdrop-blur-md border border-white/5 hover:border-pink-500/30 transition-all duration-300 hover:shadow-[0_0_30px_rgba(236,72,153,0.15)] flex flex-col items-center justify-center" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60 opacity-60 group-hover:opacity-80 transition-opacity"></div>

            <div class="relative z-10 flex flex-col items-center transform transition-transform duration-300 group-hover:-translate-y-1">
              <div class="w-16 h-16 md:w-20 md:h-20 mb-3 drop-shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dragoste.webp"
                  alt="Filme de Dragoste"
                  class="w-full h-full object-contain filter brightness-110"
                  width="80" height="80" loading="lazy" itemprop="image">
              </div>
              <h3 class="text-lg md:text-xl font-bold text-white group-hover:text-pink-300 transition-colors" itemprop="name">Dragoste</h3>
              <p class="text-xs text-gray-300 mt-1 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">Romantism</p>
            </div>
            <meta itemprop="position" content="8">
          </a>

        </div>
      </div>
    </section>
    <section id="liste-recomandari" class="relative py-8 md:py-12 bg-[#001f2d] text-[#f2f2f2]" itemprop="hasPart">
      <div class="max-w-7xl mx-auto px-4">
        <header class="text-center mb-8 md:mb-10">
          <h2 class="text-3xl md:text-4xl font-bold mb-4" itemprop="name">
            Recomandări Filme Bune – <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">Liste Tematice</span>
          </h2>
          <p class="text-gray-400 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed" itemprop="description">
            Descoperă cele mai bune filme noi și recomandări tematice, organizate pe categorii, pentru toate gusturile cinefile.
          </p>
        </header>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6" itemprop="about" itemscope itemtype="https://schema.org/ItemList">
          <div class="bg-[#002a3a] rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:bg-[#003a52] border border-transparent hover:border-cyan-400/30 transform hover:-translate-y-1 flex flex-col h-full overflow-hidden" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <!-- Header with Background Image and Title -->
            <div class="relative h-24 rounded-t-xl overflow-hidden">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/adolescenti.webp" alt="Filme cu Adolescenți" class="w-full h-full object-cover" loading="lazy" />
              <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/60"></div>
              <div class="absolute inset-0 flex items-center justify-center px-4">
                <h3 class="text-xl font-bold text-white text-center drop-shadow-lg" itemprop="name">Filme cu Adolescenți</h3>
              </div>
            </div>
            <!-- Card Content -->
            <div class="p-6 flex flex-col flex-grow">
              <p class="text-sm text-gray-300 mb-4 flex-grow" itemprop="description">
                Filme despre liceu, maturizare și prima iubire – drame și comedii care surprind perfect vârsta rebelă.
              </p>
              <a href="/tag/adolescenti" class="text-cyan-400 hover:text-cyan-300 text-sm font-semibold flex items-center group transition-colors" itemprop="url">
                <span>Vezi filme care te trimit înapoi în anii adolescenței</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </a>
            </div>
          </div>
          <div class="bg-[#002a3a] rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:bg-[#003a52] border border-transparent hover:border-cyan-400/30 transform hover:-translate-y-1 flex flex-col h-full overflow-hidden" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <!-- Header with Background Image and Title -->
            <div class="relative h-24 rounded-t-xl overflow-hidden">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/supravietuire.webp" alt="Filme despre Supraviețuire" class="w-full h-full object-cover" loading="lazy" />
              <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/60"></div>
              <div class="absolute inset-0 flex items-center justify-center px-4">
                <h3 class="text-xl font-bold text-white text-center drop-shadow-lg" itemprop="name">Filme despre Supraviețuire</h3>
              </div>
            </div>
            <!-- Card Content -->
            <div class="p-6 flex flex-col flex-grow">
              <p class="text-sm text-gray-300 mb-4 flex-grow" itemprop="description">
                Aventuri extreme, decizii imposibile și oameni care luptă pentru viață – emoții la intensitate maximă.
              </p>
              <a href="/tag/supravietuire" class="text-cyan-400 hover:text-cyan-300 text-sm font-semibold flex items-center group transition-colors" itemprop="url">
                <span>Intră în cele mai intense povești de supraviețuire</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </a>
            </div>
          </div>
          <div class="bg-[#002a3a] rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:bg-[#003a52] border border-transparent hover:border-cyan-400/30 transform hover:-translate-y-1 flex flex-col h-full overflow-hidden" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <!-- Header with Background Image and Title -->
            <div class="relative h-24 rounded-t-xl overflow-hidden">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mister.webp" alt="Filme cu Mister" class="w-full h-full object-cover" loading="lazy" />
              <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/60"></div>
              <div class="absolute inset-0 flex items-center justify-center px-4">
                <h3 class="text-xl font-bold text-white text-center drop-shadow-lg" itemprop="name">Filme cu Mister</h3>
              </div>
            </div>
            <!-- Card Content -->
            <div class="p-6 flex flex-col flex-grow">
              <p class="text-sm text-gray-300 mb-4 flex-grow" itemprop="description">
                Crime nerezolvate, indicii ascunse și finaluri care te lasă cu gura căscată – gata de o noapte cu suspans?
              </p>
              <a href="/tag/mister" class="text-cyan-400 hover:text-cyan-300 text-sm font-semibold flex items-center group transition-colors" itemprop="url">
                <span>Descoperă filme care te țin în priză până la ultima secundă</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </a>
            </div>
          </div>
          <div class="bg-[#002a3a] rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:bg-[#003a52] border border-transparent hover:border-cyan-400/30 transform hover:-translate-y-1 flex flex-col h-full overflow-hidden" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <!-- Header with Background Image and Title -->
            <div class="relative h-24 rounded-t-xl overflow-hidden">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/jafuri.webp" alt="Filme cu Jafuri" class="w-full h-full object-cover" loading="lazy" />
              <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/60"></div>
              <div class="absolute inset-0 flex items-center justify-center px-4">
                <h3 class="text-xl font-bold text-white text-center drop-shadow-lg" itemprop="name">Filme cu Jafuri</h3>
              </div>
            </div>
            <!-- Card Content -->
            <div class="p-6 flex flex-col flex-grow">
              <p class="text-sm text-gray-300 mb-4 flex-grow" itemprop="description">
                Planuri nebune, echipe de profesioniști și răsturnări de situație – un deliciu pentru fanii acțiunii.
              </p>
              <a href="/tag/jaf" class="text-cyan-400 hover:text-cyan-300 text-sm font-semibold flex items-center group transition-colors" itemprop="url">
                <span>Vezi cele mai tari filme cu jafuri și planuri imposibile</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <?php if (!is_paged()) : ?>
    <section class="relative py-10 md:py-14 bg-[#001f2d] text-[#f2f2f2]" aria-label="Despre recomandările Film-Bun">
      <div class="max-w-4xl mx-auto px-4">
        <header class="text-center mb-8">
          <h2 class="text-3xl md:text-4xl font-bold mb-4">
            Cum Alegem <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Filmele Bune</span>
          </h2>
        </header>

        <div class="text-gray-300 text-base md:text-lg leading-relaxed space-y-4">
          <p>
            Sunt mii de filme noi în fiecare an și aproape nimeni nu are timp să le încerce pe toate. De asta echipa
            Film-Bun se uită întâi la ele și scrie despre cele care chiar merită &mdash; indiferent dacă au ieșit
            săptămâna asta sau acum zece ani.
          </p>
          <p>
            Fiecare film primește o notă a echipei, alături de nota IMDb, ca să vezi dintr-o privire la ce să te aștepți.
            Scriem scurt, în română, fără spoilere și fără limbaj de critic de festival. Dacă un film e greu de privit
            sau lent, o spunem &mdash; recomandarea nu ajută dacă nu e sinceră.
          </p>
          <p>
            Filmele sunt strânse pe genuri și pe teme, așa că poți porni de la ce ai chef în seara asta: un
            <a href="/tag/mister" class="text-cyan-400 hover:text-cyan-300">film de mister</a> care te ține în priză,
            o <a href="/tag/mafie" class="text-cyan-400 hover:text-cyan-300">poveste cu mafie</a>,
            un <a href="/tag/jaf" class="text-cyan-400 hover:text-cyan-300">jaf pus la punct</a> sau
            ceva <a href="/romanesti" class="text-cyan-400 hover:text-cyan-300">românesc</a>.
          </p>
        </div>

        <div class="mt-10">
          <h2 class="text-2xl md:text-3xl font-bold mb-6 text-center">Întrebări Frecvente</h2>
          <div class="space-y-4">
            <?php
            $fb_faq = [
              [
                'q' => 'Ce filme bune merită văzute în 2026?',
                'a' => 'Lista de pe prima pagină e chiar răspunsul nostru: filmele noi din 2026 pe care echipa Film-Bun le-a văzut și le recomandă, cele mai recente primele. Fiecare are notă, durată și un rezumat scurt fără spoilere.',
              ],
              [
                'q' => 'Cum alege echipa Film-Bun filmele recomandate?',
                'a' => 'Le vedem înainte să scriem despre ele. Nu publicăm tot ce apare — doar filmele care merită timpul tău. Fiecare primește o notă a echipei, pusă lângă nota IMDb, ca să ai două repere, nu unul.',
              ],
              [
                'q' => 'Unde pot vedea filmele de pe Film-Bun?',
                'a' => 'Pe pagina fiecărui film găsești unde e disponibil în România, pe platformele de streaming la care ești deja abonat. Film-Bun nu găzduiește filme — îți spune care merită și unde le găsești legal.',
              ],
              [
                'q' => 'Cât de des apar recomandări noi?',
                'a' => 'Adăugăm filme noi în fiecare săptămână, pe măsură ce apar premierele și le vedem. Prima pagină e mereu ordonată cu cele mai recente recomandări în frunte.',
              ],
            ];
            foreach ($fb_faq as $i => $item) : ?>
              <details class="bg-[#002a3a] rounded-xl border border-transparent hover:border-cyan-400/30 transition-colors"<?php echo $i === 0 ? ' open' : ''; ?>>
                <summary class="cursor-pointer px-5 py-4 font-semibold text-base md:text-lg"><?php echo esc_html($item['q']); ?></summary>
                <div class="px-5 pb-4 text-gray-300 leading-relaxed"><?php echo esc_html($item['a']); ?></div>
              </details>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

    <?php
    $fb_faq_ld = [
      '@context'   => 'https://schema.org',
      '@type'      => 'FAQPage',
      'mainEntity' => array_map(function ($item) {
        return [
          '@type'          => 'Question',
          'name'           => $item['q'],
          'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
        ];
      }, $fb_faq),
    ];
    echo '<script type="application/ld+json">' . wp_json_encode($fb_faq_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    ?>
  <?php endif; ?>

  <?php
  // ItemList JSON-LD for the movie grid, built from the main query without disturbing the loop.
  global $wp_query;
  $fb_items = [];
  $fb_ppp   = (int) get_query_var('posts_per_page');
  if ($fb_ppp < 1) { $fb_ppp = (int) get_option('posts_per_page', 10); }
  $fb_pos   = 1 + (max(1, (int) get_query_var('paged')) - 1) * $fb_ppp;
  foreach ($wp_query->posts as $fb_post) {
    $fb_items[] = [
      '@type'    => 'ListItem',
      'position' => $fb_pos++,
      'url'      => get_permalink($fb_post->ID),
      'name'     => get_the_title($fb_post->ID),
    ];
  }
  if ($fb_items) {
    echo '<script type="application/ld+json">' . wp_json_encode([
      '@context'        => 'https://schema.org',
      '@type'           => 'ItemList',
      'name'            => 'Cele mai bune filme noi recomandate de Film-Bun',
      'itemListOrder'   => 'https://schema.org/ItemListOrderDescending',
      'numberOfItems'   => count($fb_items),
      'itemListElement' => $fb_items,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
  }
  ?>
</main>

<?php get_template_part('template-parts/footer'); ?>
