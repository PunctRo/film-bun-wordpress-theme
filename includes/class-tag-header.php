<?php

/**
 * Tag Header functionality
 */
class Tag_Header
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('post_tag_add_form_fields', array($this, 'add_tag_fields'), 10, 2);
        add_action('post_tag_edit_form_fields', array($this, 'edit_tag_fields'), 10, 2);
        add_action('created_post_tag', array($this, 'save_tag_fields'), 10, 2);
        add_action('edited_post_tag', array($this, 'save_tag_fields'), 10, 2);

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
        register_term_meta('post_tag', 'tag_header_title', array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
            'auth_callback' => function () {
                return current_user_can('manage_categories');
            },
        ));

        register_term_meta('post_tag', 'tag_header_description', array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
            'auth_callback' => function () {
                return current_user_can('manage_categories');
            },
        ));

        register_term_meta('post_tag', 'tag_related_links', array(
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
     * Add custom fields to tag creation form
     */
    public function add_tag_fields()
    {
        wp_nonce_field('tag_header_nonce', 'tag_header_nonce');
?>
        <div class="form-field">
            <label for="tag_header_title"><?php _e('Header Title', 'textdomain'); ?></label>
            <input type="text" name="tag_header_title" id="tag_header_title" value="" />
            <p class="description"><?php _e('Custom header title. Leave empty to use default "Filme Cu {Tag}".', 'textdomain'); ?></p>
        </div>

        <div class="form-field">
            <label for="tag_header_description"><?php _e('Header Description', 'textdomain'); ?></label>
            <?php
            wp_editor('', 'tag_header_description', array(
                'textarea_name' => 'tag_header_description',
                'textarea_rows' => 5,
                'media_buttons' => true,
                'teeny' => true,
            ));
            ?>
            <p class="description"><?php _e('Add a custom description that will appear in the tag header.', 'textdomain'); ?></p>
        </div>

        <div class="form-field">
            <label><?php _e('Related Links', 'textdomain'); ?></label>
            <div id="tag-related-links-container">
                <div class="related-link-item">
                    <input type="text" name="tag_related_links[0][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                    <input type="text" name="tag_related_links[0][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                    <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                </div>
            </div>
            <button type="button" class="add-link button"><?php _e('Add Link', 'textdomain'); ?></button>
            <p class="description"><?php _e('Add related links that will appear in the tag header.', 'textdomain'); ?></p>
        </div>
    <?php
    }

    /**
     * Add custom fields to tag edit form
     */
    public function edit_tag_fields($term, $taxonomy)
    {
        wp_nonce_field('tag_header_nonce', 'tag_header_nonce');

        $title = get_term_meta($term->term_id, 'tag_header_title', true);
        $description = get_term_meta($term->term_id, 'tag_header_description', true);
        $related_links = get_term_meta($term->term_id, 'tag_related_links', true);

        if (!is_array($related_links)) {
            $related_links = array();
        }
    ?>
        <tr class="form-field">
            <th scope="row">
                <label for="tag_header_title"><?php _e('Header Title', 'textdomain'); ?></label>
            </th>
            <td>
                <input type="text" name="tag_header_title" id="tag_header_title" value="<?php echo esc_attr($title); ?>" />
                <p class="description"><?php _e('Custom header title. Leave empty to use default "Filme Cu {Tag}".', 'textdomain'); ?></p>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="tag_header_description"><?php _e('Header Description', 'textdomain'); ?></label>
            </th>
            <td>
                <?php
                wp_editor($description, 'tag_header_description', array(
                    'textarea_name' => 'tag_header_description',
                    'textarea_rows' => 5,
                    'media_buttons' => true,
                    'teeny' => true,
                ));
                ?>
                <p class="description"><?php _e('Add a custom description that will appear in the tag header.', 'textdomain'); ?></p>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label><?php _e('Related Links', 'textdomain'); ?></label>
            </th>
            <td>
                <div id="tag-related-links-container">
                    <?php
                    if (!empty($related_links)) {
                        foreach ($related_links as $index => $link) : ?>
                            <div class="related-link-item">
                                <input type="text"
                                    name="tag_related_links[<?php echo esc_attr($index); ?>][title]"
                                    value="<?php echo esc_attr($link['title']); ?>"
                                    placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                                <input type="text"
                                    name="tag_related_links[<?php echo esc_attr($index); ?>][url]"
                                    value="<?php echo esc_attr($link['url']); ?>"
                                    placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                                <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                            </div>
                        <?php endforeach;
                    } else { ?>
                        <div class="related-link-item">
                            <input type="text" name="tag_related_links[0][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                            <input type="text" name="tag_related_links[0][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                            <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                        </div>
                    <?php } ?>
                </div>
                <button type="button" class="add-link button"><?php _e('Add Link', 'textdomain'); ?></button>
                <p class="description"><?php _e('Add related links that will appear in the tag header.', 'textdomain'); ?></p>
            </td>
        </tr>
    <?php
    }

    /**
     * Save custom fields
     */
    public function save_tag_fields($term_id)
    {
        if (
            !isset($_POST['tag_header_nonce']) ||
            !wp_verify_nonce($_POST['tag_header_nonce'], 'tag_header_nonce')
        ) {
            return;
        }

        if (current_user_can('manage_categories')) {
            // Save header title
            if (isset($_POST['tag_header_title'])) {
                $title = sanitize_text_field($_POST['tag_header_title']);
                update_term_meta($term_id, 'tag_header_title', $title);
            }

            // Save header description
            if (isset($_POST['tag_header_description'])) {
                $description = wp_kses_post($_POST['tag_header_description']);
                update_term_meta($term_id, 'tag_header_description', $description);
            }

            // Save related links
            if (isset($_POST['tag_related_links']) && is_array($_POST['tag_related_links'])) {
                $valid_links = array_filter(array_map(function ($link) {
                    if (!is_array($link) || empty($link['title']) || empty($link['url'])) {
                        return null;
                    }
                    return array(
                        'title' => sanitize_text_field($link['title']),
                        'url' => esc_url_raw($link['url'])
                    );
                }, $_POST['tag_related_links']));

                if (!empty($valid_links)) {
                    update_term_meta($term_id, 'tag_related_links', array_values($valid_links));
                } else {
                    delete_term_meta($term_id, 'tag_related_links');
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
                var $container = $('#tag-related-links-container'),
                    tmpl = '<div class="related-link-item"><input type="text" name="tag_related_links[{index}][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>"/><input type="text" name="tag_related_links[{index}][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>"/><button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button></div>';

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
     * Get default tag title
     *
     * @param string $tag_name The name of the tag
     * @return string Formatted title
     */
    private static function get_tag_title($tag_name)
    {
        return sprintf('Filme Cu %s', ucfirst($tag_name));
    }

    /**
     * Get default tag description
     *
     * @param string $tag_name The name of the tag
     * @return string Formatted description
     */
    private static function get_tag_description($tag_name)
    {
        return sprintf(
            'Explorați selectia noastră de filme care se încadrează sub tema %s. ' .
                'Această listă include filme care abordează subiectul %s în moduri diverse, ' .
                'oferind o gamă largă de perspective și stiluri narative. ' .
                'Fiecare film a fost selectat pentru calitatea și relevanța sa în contextul "%s", ' .
                'asigurându-vă o experiență de vizionare captivantă.',
            $tag_name,
            $tag_name,
            $tag_name
        );
    }

    /**
     * Get header content including description and related links
     *
     * @param int $term_id Tag term ID
     * @return array Header content array
     */
    public static function get_header_content($term_id)
    {
        $title = get_term_meta($term_id, 'tag_header_title', true);
        $description = get_term_meta($term_id, 'tag_header_description', true);
        $related_links = get_term_meta($term_id, 'tag_related_links', true);
        $term = get_term($term_id, 'post_tag');

        if (empty($title)) {
            $title = self::get_tag_title($term->name);
        }

        if (empty($description) && empty($term->description)) {
            $description = self::get_tag_description($term->name);
        }

        return array(
            'title' => $title,
            'description' => $description,
            'related_links' => is_array($related_links) ? $related_links : array()
        );
    }
}
