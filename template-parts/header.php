<?php
$menu_generator = new Menu_Generator();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const menuToggle = document.getElementById('menu-toggle');
      const mobileMenu = document.getElementById('mobile-menu');
      const mobileButtons = document.querySelectorAll('.mobile-menu-button');
      const searchToggle = document.getElementById('search-toggle');
      const mobileSearchBar = document.getElementById('mobile-search-bar');
      const mobileSearchInput = document.getElementById('mobile-search-input');
      const desktopSearchToggle = document.getElementById('desktop-search-toggle');
      const desktopSearchBar = document.getElementById('desktop-search-bar');
      const desktopSearchInput = document.getElementById('desktop-search-input');

      menuToggle.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
        // Close search bar if open
        mobileSearchBar.classList.add('hidden');
      });

      searchToggle.addEventListener('click', function() {
        const isHidden = mobileSearchBar.classList.toggle('hidden');
        if (!isHidden) {
          mobileSearchInput.focus();
          // Close burger menu if open
          mobileMenu.classList.add('hidden');
        }
      });

      desktopSearchToggle.addEventListener('click', function() {
        const isHidden = desktopSearchBar.classList.toggle('hidden');
        if (!isHidden) {
          desktopSearchInput.focus();
        }
      });

      // Close search bars on outside click
      document.addEventListener('click', function(e) {
        if (!mobileSearchBar.contains(e.target) && !searchToggle.contains(e.target)) {
          mobileSearchBar.classList.add('hidden');
        }
        if (!desktopSearchBar.contains(e.target) && !desktopSearchToggle.contains(e.target)) {
          desktopSearchBar.classList.add('hidden');
        }
      });

      mobileButtons.forEach(button => {
        button.addEventListener('click', function() {
          const dropdown = this.nextElementSibling;
          dropdown.classList.toggle('hidden');
          const icon = this.querySelector('svg');
          icon.style.transform = dropdown.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        });
      });
    });
  </script>
</head>

<body <?php body_class('min-h-screen font-sans bg-gradient-bottom-left text-[#f2f2f2]'); ?>>
  <?php wp_body_open(); ?>
  <header class="bg-prussian-blue-3 sticky top-0 z-50 shadow-md">
    <nav class="mx-auto max-w-6xl px-4 flex items-center"
      itemscope
      itemtype="https://schema.org/SiteNavigationElement"
      role="navigation"
      aria-label="Main navigation"
      itemprop="mainEntityOfPage">
      <div class="flex items-center" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:opacity-90" itemprop="url">
          <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo-film-bun.webp')); ?>"
            alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
            class="h-20 w-20"
            itemprop="logo"
            width="240"
            height="240">
        </a>
        <meta itemprop="name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
      </div>

      <!-- Desktop nav items — left-aligned, fills space after logo -->
      <div class="hidden md:flex items-center flex-1 ml-4">
        <?php
        // Desktop Menu
        echo $menu_generator->generate_desktop_menu();
        ?>
      </div>

      <!-- Desktop: Despre noi, Contact, search, social — right side -->
      <div class="hidden md:flex items-center gap-4 ml-4">
        <span class="h-4 w-px bg-white/15 shrink-0" aria-hidden="true"></span>
        <a href="<?php echo esc_url(home_url('/despre-film-bun/')); ?>"
          class="font-medium text-white hover:text-cyan-300 transition-colors duration-150 whitespace-nowrap"
          lang="ro">Despre noi</a>
        <a href="<?php echo esc_url(get_page_link(get_page_by_path('contact'))); ?>"
          class="font-medium text-white hover:text-cyan-300 transition-colors duration-150 whitespace-nowrap"
          lang="ro">Contact</a>
        <button id="desktop-search-toggle"
          class="flex items-center gap-2 px-4 py-2 rounded-full bg-cyan-500/15 hover:bg-cyan-500/25 border border-cyan-500/30 hover:border-cyan-400/50 text-cyan-300 hover:text-cyan-200 transition-all text-sm font-medium focus:outline-none"
          aria-label="Caută filme">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
          <span>Caută un film...</span>
        </button>

      </div>

      <div class="flex items-center gap-3 md:hidden ml-auto">
        <button id="search-toggle" class="text-[#f2f2f2] focus:outline-none p-1" aria-label="Caută filme">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
        </button>
        <button id="menu-toggle" class="text-[#f2f2f2] focus:outline-none" aria-label="Toggle Menu">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
      </div>
    </nav>

    <!-- Mobile search panel -->
    <div id="mobile-search-bar" class="hidden md:hidden bg-[#002233] border-t border-white/10 px-4 py-3">
      <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="relative">
          <input id="mobile-search-input"
            type="search"
            name="s"
            class="w-full px-5 py-2.5 pr-12 text-white bg-[#001f2d] rounded-lg focus:ring-2 focus:ring-cyan-400 focus:outline-none placeholder-gray-400 text-sm"
            placeholder="Caută filme, actori, regizori..."
            value="<?php echo esc_attr(get_search_query()); ?>"
            autocomplete="off" />
          <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-cyan-400 transition-colors" aria-label="Caută">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
          </button>
        </div>
      </form>
    </div>

    <!-- Desktop search panel -->
    <div id="desktop-search-bar" class="hidden bg-[#002233] border-t border-white/10 py-3">
      <div class="max-w-2xl mx-auto px-4">
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
          <div class="relative">
            <input id="desktop-search-input"
              type="search"
              name="s"
              class="w-full px-5 py-2.5 pr-12 text-white bg-[#001f2d] rounded-lg focus:ring-2 focus:ring-cyan-400 focus:outline-none placeholder-gray-400 text-sm"
              placeholder="Caută filme, actori, regizori..."
              value="<?php echo esc_attr(get_search_query()); ?>"
              autocomplete="off" />
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-cyan-400 transition-colors" aria-label="Caută">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
              </svg>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden">
      <div class="flex flex-col space-y-2 px-4 pb-3">
        <?php echo $menu_generator->generate_mobile_menu(); ?>

        <div class="flex items-center space-x-4 py-2" itemscope itemtype="https://schema.org/Organization">
          <meta itemprop="name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
          <a href="<?php echo esc_url(get_theme_mod('facebook_url', 'https://www.facebook.com/FilmBun')); ?>"
            target="_blank"
            rel="noopener noreferrer"
            class="text-[#f2f2f2] hover:text-cyan-400 transition-colors"
            itemprop="sameAs"
            aria-label="Urmărește-ne pe Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
            </svg>
          </a>
          <a href="<?php echo esc_url(get_theme_mod('instagram_url', 'https://www.instagram.com/film_bun')); ?>"
            target="_blank"
            rel="noopener noreferrer"
            class="text-[#f2f2f2] hover:text-cyan-400 transition-colors"
            itemprop="sameAs"
            aria-label="Urmărește-ne pe Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
            </svg>
          </a>
          <a href="https://whatsapp.com/channel/0029Vb7SCp0AzNc010i6kf2U"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 hover:bg-emerald-500/20 hover:border-emerald-500/30 transition-all duration-300"
            itemprop="sameAs"
            aria-label="Urmărește canalul nostru WhatsApp">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
            <span class="text-xs font-semibold">Canal</span>
          </a>
        </div>

        <div class="pb-3">
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
  </header>