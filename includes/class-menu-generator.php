<?php
class Menu_Generator
{
    private $menu_data;
    private $wp_menu_walker;

    public function __construct()
    {
        $this->menu_data = require get_template_directory() . '/includes/menu-data.php';
        $this->wp_menu_walker = new Custom_Nav_Walker();
    }

    /**
     * Generate desktop menu HTML
     */
    public function generate_desktop_menu()
    {
        ob_start();
?>
        <div class="flex items-center gap-5 lg:gap-6 flex-1" itemscope itemtype="https://schema.org/SiteNavigationElement">
            <!-- Dropdown nav items -->
            <?php foreach ($this->menu_data as $key => $menu) : ?>
                <?php if (($menu['type'] ?? '') === 'link') : ?>
                    <a href="<?php echo esc_url($menu['url']); ?>"
                       class="font-medium text-white hover:text-cyan-300 transition-colors duration-150 py-1 whitespace-nowrap"
                       itemprop="url" lang="ro"><span itemprop="name"><?php echo esc_html($menu['title']); ?></span></a>
                    <?php continue; ?>
                <?php endif; ?>
                <div class="relative group" <?php echo $key === 'categorii' ? 'itemscope itemtype="https://schema.org/ItemList"' : ''; ?>>
                    <button
                        class="flex items-center gap-1 font-medium text-white hover:text-cyan-300 transition-colors duration-150 py-1 whitespace-nowrap"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <span itemprop="name" lang="ro"><?php echo esc_html($menu['title']); ?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0 transition-transform duration-200 group-hover:rotate-180 text-white/50" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <!-- Dropdown panel -->
                    <div class="absolute left-0 top-full w-56 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 ease-out z-50 transform scale-95 group-hover:scale-100">
                        <div class="rounded-xl shadow-xl bg-[#001f2e] border border-white/10 overflow-hidden" role="menu" aria-orientation="vertical" itemprop="hasMenu" itemscope itemtype="https://schema.org/ItemList">
                            <div class="py-1.5">
                            <?php if (($menu['type'] ?? '') === 'wp-menu') : ?>
                                <meta itemprop="name" content="Listă categorii filme">
                                <?php
                                wp_nav_menu(array(
                                    'menu' => $menu['menu_name'],
                                    'container' => false,
                                    'items_wrap' => '%3$s',
                                    'walker' => $this->wp_menu_walker,
                                    'before' => '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">',
                                    'after' => '</span>',
                                    'link_before' => '<span itemprop="name" lang="ro">',
                                    'link_after' => '</span>'
                                ));
                                ?>
                            <?php else : ?>
                                <meta itemprop="name" content="<?php echo esc_attr($menu['title']); ?>">
                                <?php foreach ($menu['items'] as $item) : ?>
                                    <a href="<?php echo esc_url($item['url']); ?>"
                                        class="block px-4 py-2 text-sm text-white/75 hover:text-white hover:bg-white/5 transition-colors duration-150 cursor-pointer"
                                        role="menuitem"
                                        itemprop="itemListElement"
                                        itemscope
                                        itemtype="https://schema.org/ListItem"
                                        lang="ro">
                                        <span itemprop="name"><?php echo esc_html($item['title']); ?></span>
                                        <meta itemprop="position" content="<?php echo esc_attr($item['position']); ?>">
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    <?php
        return ob_get_clean();
    }

    /**
     * Generate mobile menu HTML
     */
    public function generate_mobile_menu()
    {
        ob_start();
    ?>
        <div class="mobile-menu-content flex flex-col space-y-2">
            <?php foreach ($this->menu_data as $key => $menu) : ?>
                <?php if (($menu['type'] ?? '') === 'link') : ?>
                    <a href="<?php echo esc_url($menu['url']); ?>" class="block py-1 hover:text-gray-300" lang="ro"><?php echo esc_html($menu['title']); ?></a>
                    <?php continue; ?>
                <?php endif; ?>
                <div class="relative" <?php echo $key === 'categorii' ? 'itemscope itemtype="https://schema.org/ItemList"' : ''; ?>>
                    <button class="w-full text-left py-1 hover:text-gray-300 flex items-center justify-between mobile-menu-button"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <span itemprop="name" lang="ro"><?php echo esc_html($menu['title']); ?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="mobile-dropdown hidden pl-4 mt-1 space-y-1 bg-[#002438] rounded" role="menu" itemprop="hasMenu" itemscope itemtype="https://schema.org/ItemList">
                        <?php if (($menu['type'] ?? '') === 'wp-menu') : ?>
                            <meta itemprop="name" content="Listă categorii filme">
                            <?php
                            wp_nav_menu(array(
                                'menu' => $menu['menu_name'],
                                'container' => false,
                                'items_wrap' => '%3$s',
                                'walker' => $this->wp_menu_walker,
                                'before' => '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">',
                                'after' => '</span>',
                                'link_before' => '<span itemprop="name" lang="ro">',
                                'link_after' => '</span>'
                            ));
                            ?>
                        <?php else : ?>
                            <meta itemprop="name" content="<?php echo esc_attr($menu['title']); ?>">
                            <?php foreach ($menu['items'] as $item) : ?>
                                <a href="<?php echo esc_url($item['url']); ?>"
                                    class="block py-1 hover:text-gray-300"
                                    itemprop="itemListElement"
                                    itemscope
                                    itemtype="https://schema.org/ListItem"
                                    role="menuitem"
                                    lang="ro">
                                    <span itemprop="name"><?php echo esc_html($item['title']); ?></span>
                                    <meta itemprop="position" content="<?php echo esc_attr($item['position']); ?>">
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <a href="<?php echo esc_url(home_url('/despre-film-bun/')); ?>"
                class="block py-1 hover:text-gray-300"
                itemprop="itemListElement"
                itemscope
                itemtype="https://schema.org/SiteNavigationElement"
                lang="ro">
                <span itemprop="name">Despre noi</span>
            </a>
            <a href="<?php echo esc_url(get_page_link(get_page_by_path('contact'))); ?>"
                class="block py-1 hover:text-gray-300"
                itemprop="itemListElement"
                itemscope
                itemtype="https://schema.org/SiteNavigationElement"
                lang="ro">
                <span itemprop="name">Contact</span>
            </a>
        </div>
<?php
        return ob_get_clean();
    }
}
