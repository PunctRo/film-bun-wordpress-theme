<?php

/**
 * Functions for handling advertising integration
 */

/**
 * Add Google AdSense code to header
 */
function add_google_adsense()
{
    echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9168385774327597"
     crossorigin="anonymous"></script>';
}
add_action('wp_head', 'add_google_adsense', 10);
