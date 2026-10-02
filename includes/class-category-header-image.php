<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Category Header Image functionality
 * Handles generation and caching of category header collages
 */
class Category_Header_Image
{
    private $category_id;
    private $cache_key_prefix = 'category_header_';

    /**
     * Initialize hooks
     */
    public static function init()
    {
        // Only invalidate on specific post status transitions
        add_action('transition_post_status', array(__CLASS__, 'handle_post_status_change'), 10, 3);
        add_action('deleted_post', array(__CLASS__, 'invalidate_category_cache'), 10, 2);
        
        // Add admin action to manually regenerate category images
        add_action('wp_ajax_regenerate_category_image', array(__CLASS__, 'ajax_regenerate_category_image'));
    }

    /**
     * Constructor
     *
     * @param int $category_id Category ID
     */
    public function __construct($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Get or generate collage for category
     *
     * @return array|false Array with image URL and ID or false on failure
     */
    public function get_or_generate_collage()
    {
        if (!function_exists('wp_get_upload_dir')) {
            return false;
        }

        $version = get_term_meta($this->category_id, 'category_image_version', true) ?: 1;
        $attachment_id = get_term_meta($this->category_id, 'category_image_id', true);
        $stored_version = get_term_meta($this->category_id, 'category_image_stored_version', true) ?: 0;

        // Check if we need to regenerate because version changed
        $needs_regeneration = ($version != $stored_version);

        // Always return existing image if no regeneration is needed
        if ($attachment_id && !$needs_regeneration) {
            // Validate that the attachment still exists
            $image_url = wp_get_attachment_image_url($attachment_id, 'full');
            if ($image_url) {
                $image_url = add_query_arg('v', $version, $image_url);
                return array(
                    'id' => $attachment_id,
                    'url' => $image_url
                );
            } else {
                // Image was deleted, mark for regeneration
                $needs_regeneration = true;
            }
        }

        // Only regenerate if truly necessary
        if (!$needs_regeneration) {
            return false;
        }

        // Regenerate the collage
        $result = $this->generate_collage();
        if ($result && isset($result['id'])) {
            update_term_meta($this->category_id, 'category_image_id', $result['id']);
            update_term_meta($this->category_id, 'category_image_stored_version', $version);
        }

        return $result;
    }

    /**
     * Generate collage from top posts
     *
     * @return array|false Array with image URL and ID or false on failure
     */
    private function generate_collage()
    {
        if (!function_exists('get_posts') || !function_exists('wp_get_upload_dir')) {
            return false;
        }

        $images = $this->get_top_posts_images();
        if (empty($images)) {
            return false;
        }

        $collage = $this->create_collage_image($images);
        if (!$collage || !file_exists($collage)) {
            return false;
        }

        $attachment_id = $this->save_to_media_library($collage);
        if (!$attachment_id) {
            @unlink($collage);
            return false;
        }

        $image_url = wp_get_attachment_image_url($attachment_id, 'full');
        if (!$image_url) {
            return false;
        }

        return array(
            'id' => $attachment_id,
            'url' => $image_url
        );
    }

    /**
     * Get movie poster images from top 3 posts in category
     *
     * @return array Array of image file paths
     */
    private function get_top_posts_images()
    {
        $images = array();
        $posts = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'category' => $this->category_id,
            'orderby' => 'date',
            'order' => 'DESC'
        ));

        foreach ($posts as $post) {
            if (has_post_thumbnail($post->ID)) {
                $thumbnail_id = get_post_thumbnail_id($post->ID);
                $image_path = get_attached_file($thumbnail_id);
                if ($image_path && file_exists($image_path)) {
                    $images[] = $image_path;
                }
                continue;
            }

            preg_match('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $post->post_content, $matches);
            if (!empty($matches[1])) {
                $image_path = $this->get_image_path_from_url($matches[1]);
                if ($image_path && file_exists($image_path)) {
                    $images[] = $image_path;
                }
            }
        }

        return $images;
    }

    /**
     * Convert image URL to file path
     *
     * @param string $url Image URL
     * @return string|false File path or false on failure
     */
    private function get_image_path_from_url($url)
    {
        $upload_dir = wp_upload_dir();
        return str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $url);
    }

    /**
     * Create collage image from source images
     *
     * @param array $images Array of image file paths
     * @return string|false Temporary file path of created collage or false on failure
     */
    private function create_collage_image($images)
    {
        if (!function_exists('imagecreatetruecolor')) {
            return false;
        }

        $poster_scale = 2;
        $spacing = 40;
        $poster_width = 150 * $poster_scale;
        $poster_height = 223 * $poster_scale;
        $width = ($poster_width * 3) + ($spacing * 2);
        $height = $poster_height;

        $collage = imagecreatetruecolor($width, $height);
        if (!$collage) {
            return false;
        }

        imagefill($collage, 0, 0, imagecolorallocate($collage, 0, 0, 0));

        $layouts = array(
            array('x' => 0, 'y' => 0, 'w' => $poster_width, 'h' => $poster_height),
            array('x' => $poster_width + $spacing, 'y' => 0, 'w' => $poster_width, 'h' => $poster_height),
            array('x' => ($poster_width + $spacing) * 2, 'y' => 0, 'w' => $poster_width, 'h' => $poster_height)
        );

        foreach ($images as $index => $image_path) {
            if ($index >= 3) break;

            $image_size = getimagesize($image_path);
            if (!$image_size) continue;

            $image = null;
            switch ($image_size['mime']) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($image_path);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($image_path);
                    break;
                case 'image/webp':
                    $image = imagecreatefromwebp($image_path);
                    break;
            }
            if (!$image) continue;

            $layout = $layouts[$index];
            $src_ratio = $image_size[0] / $image_size[1];
            $dst_ratio = $layout['w'] / $layout['h'];

            if ($src_ratio > $dst_ratio) {
                $src_h = $image_size[1];
                $src_w = $src_h * $dst_ratio;
                $src_x = ($image_size[0] - $src_w) / 2;
                $src_y = 0;
            } else {
                $src_w = $image_size[0];
                $src_h = $src_w / $dst_ratio;
                $src_x = 0;
                $src_y = ($image_size[1] - $src_h) / 2;
            }

            imagecopyresampled(
                $collage,
                $image,
                $layout['x'],
                $layout['y'],
                $src_x,
                $src_y,
                $layout['w'],
                $layout['h'],
                $src_w,
                $src_h
            );

            imagedestroy($image);
        }

        $upload_dir = wp_upload_dir();
        if (empty($upload_dir['path']) || !is_writable($upload_dir['path'])) {
            imagedestroy($collage);
            return false;
        }

        $tmp_file = tempnam($upload_dir['path'], 'cat_collage_');
        if (!$tmp_file) {
            imagedestroy($collage);
            return false;
        }

        $success = imagejpeg($collage, $tmp_file, 90);
        imagedestroy($collage);

        return $success ? $tmp_file : false;
    }

    /**
     * Save generated collage to media library
     *
     * @param string $file_path Path to temporary image file
     * @return int|false Attachment ID or false on failure
     */
    private function save_to_media_library($file_path)
    {
        if (!function_exists('wp_upload_bits') || !function_exists('wp_insert_attachment')) {
            return false;
        }

        $category = get_term($this->category_id, 'category');
        if (!$category || is_wp_error($category)) {
            return false;
        }

        // Create SEO-friendly filename
        $category_slug = sanitize_title($category->name);
        $year_month = date('Y/m');
        $filename = sprintf('filme-%s-categoria-header.jpg', $category_slug);
        $relative_path = $year_month . '/' . $filename;

        $existing_id = get_term_meta($this->category_id, 'category_image_id', true);
        if ($existing_id) {
            $existing_file = get_attached_file($existing_id);
            if ($existing_file && file_exists($existing_file)) {
                // Update existing file content instead of creating new attachment
                if (file_put_contents($existing_file, file_get_contents($file_path)) !== false) {
                    @unlink($file_path);
                    
                    // Update attachment metadata to refresh thumbnails
                    if (function_exists('wp_generate_attachment_metadata')) {
                        $attachment_data = wp_generate_attachment_metadata($existing_id, $existing_file);
                        wp_update_attachment_metadata($existing_id, $attachment_data);
                    }
                    
                    return $existing_id;
                }
            }
        }

        $upload_dir = wp_upload_dir();
        $target_path = $upload_dir['basedir'] . '/' . $relative_path;
        $target_url = $upload_dir['baseurl'] . '/' . $relative_path;

        wp_mkdir_p(dirname($target_path));
        if (!copy($file_path, $target_path)) {
            return false;
        }

        @unlink($file_path);

        $attachment = array(
            'guid' => $target_url,
            'post_mime_type' => 'image/jpeg',
            'post_title' => sprintf(__('Filme %s - Categoria Header', 'textdomain'), ucfirst($category->name)),
            'post_content' => sprintf(__('Header collage pentru categoria %s cu ultimele filme adaugate.', 'textdomain'), $category->name),
            'post_status' => 'inherit',
            'post_excerpt' => sprintf(__('Colaj cu filme din categoria %s', 'textdomain'), $category->name)
        );

        $attachment_id = wp_insert_attachment($attachment, $relative_path);
        if (!$attachment_id || is_wp_error($attachment_id)) {
            return false;
        }

        if (function_exists('wp_generate_attachment_metadata')) {
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $target_path);
            wp_update_attachment_metadata($attachment_id, $attachment_data);
        }

        // Set alt text for better SEO
        update_post_meta($attachment_id, '_wp_attachment_image_alt',
            sprintf(__('Filme din categoria %s - colaj cu ultimele adaugari', 'textdomain'), $category->name)
        );

        return $attachment_id;
    }

    /**
     * Handle post status changes to invalidate cache only when necessary
     *
     * @param string $new_status New post status
     * @param string $old_status Previous post status
     * @param object $post Post object
     */
    public static function handle_post_status_change($new_status, $old_status, $post)
    {
        // Only handle posts, not other post types
        if ($post->post_type !== 'post') {
            return;
        }

        // Skip autosaves and revisions
        if (wp_is_post_autosave($post->ID) || wp_is_post_revision($post->ID)) {
            return;
        }

        // Only invalidate cache when:
        // 1. A post is newly published (draft/pending -> publish)
        // 2. A published post is deleted
        // 3. A post is unpublished (publish -> draft/trash)
        $should_invalidate = false;

        if ($new_status === 'publish' && $old_status !== 'publish') {
            // New post published
            $should_invalidate = true;
        } elseif ($old_status === 'publish' && $new_status !== 'publish') {
            // Post unpublished
            $should_invalidate = true;
        }

        if ($should_invalidate) {
            self::invalidate_post_categories($post->ID);
        }
    }

    /**
     * Invalidate cache when posts in any category are updated
     *
     * @param int $post_id Post ID
     * @param null|object $post Post object
     */
    public static function invalidate_category_cache($post_id, $post = null)
    {
        // Skip autosaves, revisions, and non-post types
        if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
            return;
        }

        // Get the post object if not provided
        if (!$post) {
            $post = get_post($post_id);
        }

        // Only invalidate for published posts
        if (!$post || $post->post_type !== 'post') {
            return;
        }

        self::invalidate_post_categories($post_id);
    }

    /**
     * Invalidate categories for a specific post
     *
     * @param int $post_id Post ID
     */
    private static function invalidate_post_categories($post_id)
    {
        $categories = get_the_category($post_id);
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $version = get_term_meta($category->term_id, 'category_image_version', true) ?: 1;
                update_term_meta($category->term_id, 'category_image_version', $version + 1);
                
            }
        }
    }

    /**
     * AJAX handler to manually regenerate category image
     */
    public static function ajax_regenerate_category_image()
    {
        check_ajax_referer('regenerate_category_image', 'nonce');
        
        if (!current_user_can('manage_categories')) {
            wp_die(__('You do not have permission to perform this action.'));
        }

        $category_id = intval($_POST['category_id']);
        if (!$category_id) {
            wp_die(__('Invalid category ID.'));
        }

        // Force regeneration by clearing stored version
        delete_term_meta($category_id, 'category_image_stored_version');
        
        $header_image = new self($category_id);
        $result = $header_image->get_or_generate_collage();
        
        if ($result) {
            wp_send_json_success(array(
                'message' => __('Category image regenerated successfully.'),
                'image_url' => $result['url']
            ));
        } else {
            wp_send_json_error(__('Failed to regenerate category image.'));
        }
    }

    /**
     * Clean up old category images that are no longer used
     *
     * @param int $category_id Category ID
     */
    public function cleanup_old_images($category_id = null)
    {
        if ($category_id) {
            $categories = array(get_term($category_id, 'category'));
        } else {
            $categories = get_terms(array(
                'taxonomy' => 'category',
                'hide_empty' => false
            ));
        }

        foreach ($categories as $category) {
            if (is_wp_error($category)) {
                continue;
            }

            $current_id = get_term_meta($category->term_id, 'category_image_id', true);
            
            // Find all attachments that might be old category images
            $old_attachments = get_posts(array(
                'post_type' => 'attachment',
                'post_status' => 'inherit',
                'meta_query' => array(
                    array(
                        'key' => '_wp_attachment_image_alt',
                        'value' => $category->name,
                        'compare' => 'LIKE'
                    )
                ),
                'exclude' => $current_id ? array($current_id) : array()
            ));

            foreach ($old_attachments as $attachment) {
                // Only delete if it looks like a category header image
                if (strpos($attachment->post_title, 'Category Header') !== false ||
                    strpos($attachment->post_title, 'Categoria Header') !== false) {
                    wp_delete_attachment($attachment->ID, true);
                }
            }
        }
    }
}
