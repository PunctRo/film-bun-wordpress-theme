<?php

/**
 * Custom Walker class for navigation menus that applies consistent styling
 * for WordPress menu items to match custom menu items
 */
class Custom_Nav_Walker extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $output .= '<a href="' . esc_url($item->url) . '" class="block px-4 py-2 text-sm text-white/75 hover:text-white hover:bg-white/5 transition-colors duration-150 cursor-pointer" role="menuitem">';
        $output .= esc_html($item->title);
        $output .= '</a>';
    }
}
