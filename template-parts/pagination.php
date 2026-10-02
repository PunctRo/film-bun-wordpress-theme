<?php

/**
 * Enhanced pagination with better mobile support using Tailwind CSS
 * This custom implementation ensures proper horizontal display on all devices
 */

global $wp_query;

// Don't display pagination if there's only 1 page
if ($wp_query->max_num_pages <= 1) {
    return;
}

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$max_pages = $wp_query->max_num_pages;
?>

<nav class="pagination-wrapper my-8 px-2" aria-label="<?php echo esc_attr__('Posts Navigation', 'textdomain'); ?>">
    <!-- Scrollable container with hidden scrollbar -->
    <div class="overflow-x-auto py-2 -mx-2 px-2 scrollbar-hide">
        <!-- Pagination list -->
        <ul class="flex items-center justify-center gap-1 sm:gap-1 w-max mx-auto">
            <?php if ($paged > 1) : ?>
                <!-- Previous page button -->
                <li>
                    <a href="<?php echo esc_url(get_pagenum_link($paged - 1)); ?>" class="inline-flex items-center justify-center min-w-[42px] min-h-[42px] sm:min-w-[36px] sm:min-h-[36px] px-2 py-2 sm:px-1.5 sm:py-1 bg-[#002a3a]/80 hover:bg-[#003a52] text-white border border-cyan-400/30 hover:border-cyan-400/50 rounded-lg sm:rounded-md text-sm font-medium transition-all duration-200 active:scale-95">
                        <span class="hidden sm:inline">&laquo; <?php _e('Previous', 'textdomain'); ?></span>
                        <span class="sm:hidden">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php
            // Limited pages to show before and after current page
            $show_items = 1; // Show fewer items on mobile for larger touch targets

            // Always show first page button
            if ($paged > 1) : ?>
                <li>
                    <a href="<?php echo esc_url(get_pagenum_link(1)); ?>" class="inline-flex items-center justify-center min-w-[42px] min-h-[42px] sm:min-w-[36px] sm:min-h-[36px] px-2 py-2 sm:px-1.5 sm:py-1 bg-[#002a3a] hover:bg-[#003a52] text-white border border-cyan-400/30 hover:border-cyan-400/50 rounded-lg sm:rounded-md text-sm font-medium transition-all duration-200 active:scale-95">
                        1
                    </a>
                </li>
            <?php endif; ?>

            <?php
            // Show dots if not showing all items
            if ($paged - $show_items > 2) : ?>
                <li class="flex items-center justify-center text-white font-bold min-w-[24px]">
                    <span>&hellip;</span>
                </li>
            <?php endif; ?>

            <?php
            // Show pages around current page
            $start_page = max(1, $paged - $show_items);
            // Skip page 1 if it's already been shown
            if ($paged > 1 && $start_page == 1) {
                $start_page = 2;
            }
            for ($i = $start_page; $i <= min($max_pages, $paged + $show_items); $i++) {
                if ($i == $paged) {
                    // Current page with special styling
                    echo '<li><span class="inline-flex items-center justify-center min-w-[42px] min-h-[42px] sm:min-w-[36px] sm:min-h-[36px] px-2 py-2 sm:px-1.5 sm:py-1 bg-gradient-to-r from-cyan-400/20 to-blue-500/20 text-white border border-cyan-400/60 rounded-lg sm:rounded-md text-sm font-bold shadow-md shadow-cyan-400/10 cursor-default">' . $i . '</span></li>';
                } else {
                    echo '<li><a href="' . esc_url(get_pagenum_link($i)) . '" class="inline-flex items-center justify-center min-w-[42px] min-h-[42px] sm:min-w-[36px] sm:min-h-[36px] px-2 py-2 sm:px-1.5 sm:py-1 bg-[#002a3a] hover:bg-[#003a52] text-white border border-cyan-400/30 hover:border-cyan-400/50 rounded-lg sm:rounded-md text-sm font-medium transition-all duration-200 active:scale-95">' . $i . '</a></li>';
                }
            }
            ?>

            <?php
            // Show dots if not showing all items
            if ($paged + $show_items < $max_pages - 1) : ?>
                <li class="flex items-center justify-center text-white font-bold min-w-[24px]">
                    <span>&hellip;</span>
                </li>
            <?php endif; ?>

            <?php
            // Always show last page button
            if ($paged < $max_pages && $paged + $show_items < $max_pages) : ?>
                <li>
                    <a href="<?php echo esc_url(get_pagenum_link($max_pages)); ?>" class="inline-flex items-center justify-center min-w-[42px] min-h-[42px] sm:min-w-[36px] sm:min-h-[36px] px-2 py-2 sm:px-1.5 sm:py-1 bg-[#002a3a] hover:bg-[#003a52] text-white border border-cyan-400/30 hover:border-cyan-400/50 rounded-lg sm:rounded-md text-sm font-medium transition-all duration-200 active:scale-95">
                        <?php echo $max_pages; ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($paged < $max_pages) : ?>
                <!-- Next page button -->
                <li>
                    <a href="<?php echo esc_url(get_pagenum_link($paged + 1)); ?>" class="inline-flex items-center justify-center min-w-[42px] min-h-[42px] sm:min-w-[36px] sm:min-h-[36px] px-2 py-2 sm:px-1.5 sm:py-1 bg-[#002a3a]/80 hover:bg-[#003a52] text-white border border-cyan-400/30 hover:border-cyan-400/50 rounded-lg sm:rounded-md text-sm font-medium transition-all duration-200 active:scale-95">
                        <span class="hidden sm:inline"><?php _e('Next', 'textdomain'); ?> &raquo;</span>
                        <span class="sm:hidden">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<?php
// Add the scrollbar hiding utility if not already defined in your Tailwind config
// This is the only CSS we need to keep, as it's not available in standard Tailwind
?>
<style>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>