<footer class="relative bg-[#001520] text-gray-400 border-t border-white/5 pt-16 pb-8 text-sm" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
  <!-- Decorative Glow -->
  <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-1 bg-gradient-to-r from-transparent via-cyan-500/20 to-transparent"></div>

  <div class="max-w-6xl mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8 mb-12">

      <!-- Column 1: Brand & About -->
      <div class="space-y-4">
        <h4 class="text-xl font-bold text-white mb-2 flex items-center gap-2">
          <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo-film-bun.webp')); ?>" alt="Film Bun" class="h-8 w-8" width="32" height="32" loading="lazy"> Film Bun
        </h4>
        <p class="leading-relaxed">
          Ghidul tău complet pentru <strong>filme bune</strong>, recenzii oneste și recomandări de calitate. Descoperă ce merită văzut în fiecare seară.
        </p>
        <div class="flex gap-4 pt-2">
          <!-- Social Icons -->
          <a href="<?php echo esc_url(get_theme_mod('facebook_url', 'https://www.facebook.com/FilmBun')); ?>" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center hover:bg-cyan-500/20 hover:text-cyan-400 transition-all" aria-label="Facebook">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
              <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
            </svg>
          </a>
          <a href="<?php echo esc_url(get_theme_mod('instagram_url', 'https://www.instagram.com/film_bun')); ?>" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center hover:bg-cyan-500/20 hover:text-cyan-400 transition-all" aria-label="Instagram">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
              <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path>
              <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
            </svg>
          </a>
          <a href="https://whatsapp.com/channel/0029Vb7SCp0AzNc010i6kf2U" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 h-8 px-3 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 hover:bg-emerald-500/20 hover:border-emerald-500/30 transition-all duration-300" aria-label="Urmărește canalul nostru WhatsApp">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            <span class="text-xs font-semibold">Canal</span>
          </a>
        </div>
      </div>

      <!-- Column 2: Explore Genres (SEO) -->
      <div>
        <h4 class="text-white font-semibold mb-6">Explorează Genuri</h4>
        <ul class="space-y-3">
          <li><a href="/actiune" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-cyan-500/50"></span> Filme de Acțiune</a></li>
          <li><a href="/comedie" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-cyan-500/50"></span> Comedii</a></li>
          <li><a href="/drama" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-cyan-500/50"></span> Drame</a></li>
          <li><a href="/horror" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-cyan-500/50"></span> Filme Horror</a></li>
          <li><a href="/sf" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-cyan-500/50"></span> Science Fiction</a></li>
          <li><a href="/dragoste" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-cyan-500/50"></span> Filme De Dragoste</a></li>
        </ul>
      </div>

      <!-- Column 3: Popular Actors -->
      <div>
        <h4 class="text-white font-semibold mb-6">Actori Populari</h4>
        <ul class="space-y-3">
          <li><a href="/actor/tom-hardy" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-purple-500/50"></span> Tom Hardy</a></li>
          <li><a href="/actor/robert-de-niro" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-purple-500/50"></span> Robert De Niro</a></li>
          <li><a href="/actor/tom-cruise" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-purple-500/50"></span> Tom Cruise</a></li>
          <li><a href="/actor/denzel-washington" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-purple-500/50"></span> Denzel Washington</a></li>
          <li><a href="/actor/leonardo-dicaprio" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-purple-500/50"></span> Leonardo DiCaprio</a></li>
          <li><a href="/actor/liam-neeson" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-purple-500/50"></span> Liam Neeson</a></li>
        </ul>
      </div>

      <!-- Column 3: Quick Links -->
      <div>
        <h4 class="text-white font-semibold mb-6">Informații Utile</h4>
        <ul class="space-y-3">
          <li><a href="/despre-film-bun" class="hover:text-cyan-400 transition-colors">Despre Noi</a></li>
          <li><a href="/contact" class="hover:text-cyan-400 transition-colors">Contact</a></li>
          <li><a href="/termeni-si-conditii" class="hover:text-cyan-400 transition-colors">Termeni și Condiții</a></li>
          <li><a href="/cookie-policy" class="hover:text-cyan-400 transition-colors">Politica Cookie</a></li>
        </ul>
      </div>

    </div>

    <?php /* Affiliate disclosure removed 2026-08-31: the popcorn test closed 2026-07-19 and
       no affiliate link has rendered since. render_popcorn_movie_banner() / get_affiliate_link()
       in includes/affiliate-functions.php are defined but called from nowhere. If affiliate
       links are reactivated, restore this block in the same commit. */ ?>
    <!-- Bottom Bar -->
    <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
      <p>&copy; <?php echo date('Y'); ?> <strong>Film Bun</strong>. Toate drepturile rezervate.</p>
      <p class="flex items-center gap-1">Creat cu <span class="text-red-500">❤️</span> de <a href="https://devbybb.com/" target="_blank" rel="noopener" class="font-medium text-cyan-400 hover:text-cyan-300 transition-colors">DevByBB</a> pentru iubitorii de filme.</p>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>
