<?php

/**
 * Metabox simplu pentru filme similare (film_related_ids)
 * Valoare: ID-uri de posturi separate prin virgulă, ex: "1886,12387,1402,4567"
 */

add_action('add_meta_boxes', function () {
    add_meta_box(
        'film_related_ids',
        'Filme Bune similare (ID-uri)',
        'film_related_metabox_render',
        'post',
        'side',
        'default'
    );
});

function film_related_metabox_render($post)
{
    wp_nonce_field('film_related_save', 'film_related_nonce');
    $value = get_post_meta($post->ID, 'film_related_ids', true);
    echo '<label for="film_related_ids" style="display:block;margin-bottom:4px;font-size:12px;color:#666;">ID-uri separate prin virgulă (max 4):</label>';
    echo '<input type="text" id="film_related_ids" name="film_related_ids" value="' . esc_attr($value) . '" style="width:100%;font-family:monospace;" placeholder="1886,12387,1402,4567">';
}

add_action('save_post', function ($post_id) {
    if (!isset($_POST['film_related_nonce']) || !wp_verify_nonce($_POST['film_related_nonce'], 'film_related_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['film_related_ids'])) {
        // Sanitizează: păstrează doar cifre și virgule
        $raw = sanitize_text_field($_POST['film_related_ids']);
        $ids = array_filter(array_map('absint', explode(',', $raw)));
        update_post_meta($post_id, 'film_related_ids', implode(',', $ids));
    }
});
