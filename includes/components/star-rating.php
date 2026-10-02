<?php

/**
 * Star Rating Components
 *
 * Renders star rating displays using Tailwind CSS classes
 */

if (!function_exists('render_simple_rating')):
    /**
     * Render simplified star rating display with single color-coded star
     *
     * @param float $rating The rating value (0-10)
     * @param string $size CSS class for star size (default: 'w-5 h-5')
     * @param bool $show_value Whether to show the numeric rating value
     * @return string HTML markup for the star rating
     */
    function render_simple_rating($rating, $size = 'w-5 h-5', $show_value = true)
    {
        if (!$rating) {
            return '';
        }

        // Convert comma to period for numeric operations
        $rating = str_replace(',', '.', $rating);

        ob_start();
?>
        <div class="flex items-center gap-1 sm:gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="<?php echo esc_attr($size); ?> text-yellow-400">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <?php if ($show_value) : ?>
                <span class="font-semibold whitespace-nowrap"><?php echo esc_html($rating); ?></span>
            <?php endif; ?>
        </div>
<?php
        return ob_get_clean();
    }
endif;
