<?php

/**
 * Category Header functionality
 */
class Category_Header
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Initialize Category_Header_Image hooks
        Category_Header_Image::init();

        // Register admin hooks
        add_action('category_add_form_fields', array($this, 'add_category_fields'), 10, 2);
        add_action('category_edit_form_fields', array($this, 'edit_category_fields'), 10, 2);
        add_action('created_category', array($this, 'save_category_fields'), 10, 2);
        add_action('edited_category', array($this, 'save_category_fields'), 10, 2);

        // Register term meta for REST API access
        add_action('init', array($this, 'register_meta'));

        // Add custom styles to admin head for the repeater field
        add_action('admin_head-term.php', array($this, 'add_admin_styles'));
        add_action('admin_head-edit-tags.php', array($this, 'add_admin_styles'));

        // Add scripts to admin footer
        add_action('admin_footer-term.php', array($this, 'add_admin_scripts'));
        add_action('admin_footer-edit-tags.php', array($this, 'add_admin_scripts'));
    }

    /**
     * Register term meta for REST API exposure
     */
    public function register_meta()
    {
        register_term_meta('category', 'category_header_title', array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
            'auth_callback' => function () {
                return current_user_can('manage_categories');
            },
        ));

        register_term_meta('category', 'category_header_description', array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
            'auth_callback' => function () {
                return current_user_can('manage_categories');
            },
        ));

        register_term_meta('category', 'category_related_links', array(
            'show_in_rest' => array(
                'schema' => array(
                    'type'  => 'array',
                    'items' => array(
                        'type'       => 'object',
                        'properties' => array(
                            'title' => array('type' => 'string'),
                            'url'   => array('type' => 'string', 'format' => 'uri'),
                        ),
                    ),
                ),
            ),
            'single'       => true,
            'type'         => 'array',
            'auth_callback' => function () {
                return current_user_can('manage_categories');
            },
        ));
    }

    /**
     * Add custom fields to category creation form
     */
    public function add_category_fields()
    {
        wp_nonce_field('category_header_nonce', 'category_header_nonce');
?>
        <div class="form-field">
            <label for="category_header_title"><?php _e('Header Title', 'textdomain'); ?></label>
            <input type="text" name="category_header_title" id="category_header_title" value="" />
            <p class="description"><?php _e('Custom header title. Leave empty to use default "Filme Din Categoria {Category}".', 'textdomain'); ?></p>
        </div>

        <div class="form-field">
            <label for="category_header_description"><?php _e('Header Description', 'textdomain'); ?></label>
            <?php
            wp_editor('', 'category_header_description', array(
                'textarea_name' => 'category_header_description',
                'textarea_rows' => 5,
                'media_buttons' => true,
                'teeny' => true,
            ));
            ?>
            <p class="description"><?php _e('Add a custom description that will appear in the category header.', 'textdomain'); ?></p>
        </div>

        <div class="form-field">
            <label><?php _e('Related Links', 'textdomain'); ?></label>
            <div id="category-related-links-container">
                <div class="related-link-item" data-index="0">
                    <input type="text" name="category_related_links[0][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                    <input type="text" name="category_related_links[0][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                    <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                </div>
            </div>
            <button type="button" class="add-link button"><?php _e('Add Link', 'textdomain'); ?></button>
            <p class="description"><?php _e('Add related links that will appear in the category header.', 'textdomain'); ?></p>
        </div>
    <?php
    }

    /**
     * Add custom fields to category edit form
     */
    public function edit_category_fields($term, $taxonomy)
    {
        wp_nonce_field('category_header_nonce', 'category_header_nonce');

        $title = get_term_meta($term->term_id, 'category_header_title', true);
        $description = get_term_meta($term->term_id, 'category_header_description', true);
        $related_links = get_term_meta($term->term_id, 'category_related_links', true);

        if (!is_array($related_links)) {
            $related_links = array();
        }
    ?>
        <tr class="form-field">
            <th scope="row">
                <label for="category_header_title"><?php _e('Header Title', 'textdomain'); ?></label>
            </th>
            <td>
                <input type="text" name="category_header_title" id="category_header_title" value="<?php echo esc_attr($title); ?>" />
                <p class="description"><?php _e('Custom header title. Leave empty to use default "Filme Din Categoria {Category}".', 'textdomain'); ?></p>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="category_header_description"><?php _e('Header Description', 'textdomain'); ?></label>
            </th>
            <td>
                <?php
                wp_editor($description, 'category_header_description', array(
                    'textarea_name' => 'category_header_description',
                    'textarea_rows' => 5,
                    'media_buttons' => true,
                    'teeny' => true,
                ));
                ?>
                <p class="description"><?php _e('Add a custom description that will appear in the category header.', 'textdomain'); ?></p>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label><?php _e('Related Links', 'textdomain'); ?></label>
            </th>
            <td>
                <div id="category-related-links-container">
                    <?php if (empty($related_links)) : ?>
                        <div class="related-link-item" data-index="0">
                            <input type="text" name="category_related_links[0][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                            <input type="text" name="category_related_links[0][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                            <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                        </div>
                    <?php else : ?>
                        <?php foreach ($related_links as $index => $link) : ?>
                            <div class="related-link-item" data-index="<?php echo esc_attr($index); ?>">
                                <input type="text"
                                    name="category_related_links[<?php echo esc_attr($index); ?>][title]"
                                    value="<?php echo esc_attr($link['title']); ?>"
                                    placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                                <input type="text"
                                    name="category_related_links[<?php echo esc_attr($index); ?>][url]"
                                    value="<?php echo esc_attr($link['url']); ?>"
                                    placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                                <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="button" class="add-link button"><?php _e('Add Link', 'textdomain'); ?></button>
                <p class="description"><?php _e('Add related links that will appear in the category header.', 'textdomain'); ?></p>
            </td>
        </tr>
    <?php
    }

    /**
     * Save custom fields
     */
    public function save_category_fields($term_id)
    {
        if (
            !isset($_POST['category_header_nonce']) ||
            !wp_verify_nonce($_POST['category_header_nonce'], 'category_header_nonce')
        ) {
            return;
        }

        if (current_user_can('manage_categories')) {
            // Save header title
            if (isset($_POST['category_header_title'])) {
                $title = sanitize_text_field($_POST['category_header_title']);
                update_term_meta($term_id, 'category_header_title', $title);
            }

            // Save header description
            if (isset($_POST['category_header_description'])) {
                $description = wp_kses_post($_POST['category_header_description']);
                update_term_meta($term_id, 'category_header_description', $description);
            }

            // Save related links
            if (isset($_POST['category_related_links']) && is_array($_POST['category_related_links'])) {
                $valid_links = array_filter(array_map(function ($link) {
                    if (!is_array($link) || empty($link['title']) || empty($link['url'])) {
                        return null;
                    }
                    return array(
                        'title' => sanitize_text_field($link['title']),
                        'url' => esc_url_raw($link['url'])
                    );
                }, $_POST['category_related_links']));

                if (!empty($valid_links)) {
                    update_term_meta($term_id, 'category_related_links', array_values($valid_links));
                } else {
                    delete_term_meta($term_id, 'category_related_links');
                }
            }
        }
    }

    /**
     * Add custom styles for admin
     */
    public function add_admin_styles()
    {
    ?>
        <style>
            .related-link-item {
                margin-bottom: 10px;
                display: flex;
                gap: 10px;
            }

            .related-link-item input {
                flex: 1;
            }

            .add-link {
                margin-top: 10px !important;
            }
        </style>
    <?php
    }

    /**
     * Add custom scripts for admin
     */
    public function add_admin_scripts()
    {
    ?>
        <script>
            jQuery(function($) {
                var $container = $('#category-related-links-container'),
                    tmpl = '<div class="related-link-item"><input type="text" name="category_related_links[{index}][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>"/><input type="text" name="category_related_links[{index}][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>"/><button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button></div>';

                function reindexLinks() {
                    $container.find('.related-link-item input').each(function(i) {
                        var $input = $(this),
                            name = $input.attr('name');
                        name && $input.attr('name', name.replace(/\[\d+\]/, '[' + Math.floor(i / 2) + ']'));
                    });
                }

                $('.add-link').on('click', function() {
                    $container.append(tmpl.replace(/\{index\}/g, $container.children().length));
                    reindexLinks();
                });

                $(document).on('click', '.remove-link', function() {
                    $(this).closest('.related-link-item').remove();
                    reindexLinks();
                });
            });
        </script>
<?php
    }

    /**
     * Get default category title
     *
     * @param string $category_name The name of the category
     * @return string Formatted title
     */
    private static function get_category_title($category_name)
    {
        return sprintf('Filme Din Categoria %s', ucfirst($category_name));
    }

    /**
     * Get header content including title, description, related links, and header image
     *
     * @param int $term_id Category term ID
     * @return array Header content array
     */
    public static function get_header_content($term_id)
    {
        $title = get_term_meta($term_id, 'category_header_title', true);
        $description = get_term_meta($term_id, 'category_header_description', true);
        $related_links = get_term_meta($term_id, 'category_related_links', true);

        // Get category term
        $term = get_term($term_id, 'category');

        // Get or generate category header image
        $header_image = self::get_header_image($term_id);

        // Use default title if custom title is not set
        if (empty($title)) {
            $title = self::get_category_title($term->name);
        }

        return array(
            'title' => $title,
            'description' => $description,
            'related_links' => is_array($related_links) ? $related_links : array(),
            'header_image' => $header_image
        );
    }

    /**
     * Get or generate category header image
     *
     * @param int $term_id Category term ID
     * @return array|false Array with image data or false on failure
     */
    private static function get_header_image($term_id)
    {
        require_once dirname(__FILE__) . '/class-category-header-image.php';

        $header_image = new Category_Header_Image($term_id);
        $result = $header_image->get_or_generate_collage();

        if ($result && isset($result['id']) && isset($result['url'])) {
            // Keep the version query parameter for proper cache busting
            return array(
                'id' => $result['id'],
                'url' => $result['url']
            );
        }

        return false;
    }
}
