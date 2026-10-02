<?php

/**
 * Metabox pentru filmele asociate unei știri (related_films)
 * Valoare: ID-uri de posturi separate prin virgulă, ex: "1886,12387"
 */

add_action('add_meta_boxes', function () {
    add_meta_box(
        'news_related_films',
        'Filme asociate (ID-uri)',
        'news_related_metabox_render',
        News_Post_Type::POST_TYPE,
        'side',
        'default'
    );
});

function news_related_metabox_render($post)
{
    wp_nonce_field('news_related_save', 'news_related_nonce');
    $value = get_post_meta($post->ID, 'related_films', true);
    echo '<label for="news_related_films" style="display:block;margin-bottom:4px;font-size:12px;color:#666;">ID-uri filme separate prin virgulă:</label>';
    echo '<input type="text" id="news_related_films" name="news_related_films" value="' . esc_attr($value) . '" style="width:100%;font-family:monospace;" placeholder="1886,12387">';
}

add_action('save_post_' . News_Post_Type::POST_TYPE, function ($post_id) {
    if (!isset($_POST['news_related_nonce']) || !wp_verify_nonce($_POST['news_related_nonce'], 'news_related_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['news_related_films'])) {
        $raw = sanitize_text_field($_POST['news_related_films']);
        $ids = array_filter(array_map('absint', explode(',', $raw)));
        update_post_meta($post_id, 'related_films', implode(',', $ids));
    }
});
