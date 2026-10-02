<?php

/**
 * Year Header functionality
 */
class Year_Header
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('an_add_form_fields', array($this, 'add_year_fields'), 10, 2);
        add_action('an_edit_form_fields', array($this, 'edit_year_fields'), 10, 2);
        add_action('created_an', array($this, 'save_year_fields'), 10, 2);
        add_action('edited_an', array($this, 'save_year_fields'), 10, 2);

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
        register_term_meta('an', 'year_header_title', array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
            'auth_callback' => function () {
                return current_user_can('manage_categories');
            },
        ));

        register_term_meta('an', 'year_header_description', array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
            'auth_callback' => function () {
                return current_user_can('manage_categories');
            },
        ));

        register_term_meta('an', 'year_related_links', array(
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
     * Add custom fields to year creation form
     */
    public function add_year_fields()
    {
        wp_nonce_field('year_header_nonce', 'year_header_nonce');
?>
        <div class="form-field">
            <label for="year_header_title"><?php _e('Header Title', 'textdomain'); ?></label>
            <input type="text" name="year_header_title" id="year_header_title" value="" />
            <p class="description"><?php _e('Custom header title. Leave empty to use default "Filme Din {Year}".', 'textdomain'); ?></p>
        </div>

        <div class="form-field">
            <label for="year_header_description"><?php _e('Header Description', 'textdomain'); ?></label>
            <?php
            wp_editor('', 'year_header_description', array(
                'textarea_name' => 'year_header_description',
                'textarea_rows' => 5,
                'media_buttons' => true,
                'teeny' => true,
            ));
            ?>
            <p class="description"><?php _e('Add a custom description that will appear in the year header.', 'textdomain'); ?></p>
        </div>

        <div class="form-field">
            <label><?php _e('Related Links', 'textdomain'); ?></label>
            <div id="related-links-container">
                <div class="related-link-item" data-index="0">
                    <input type="text" name="year_related_links[0][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                    <input type="text" name="year_related_links[0][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                    <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                </div>
            </div>
            <button type="button" class="add-link button"><?php _e('Add Link', 'textdomain'); ?></button>
            <p class="description"><?php _e('Add related links that will appear in the year header.', 'textdomain'); ?></p>
        </div>
    <?php
    }

    /**
     * Add custom fields to year edit form
     */
    public function edit_year_fields($term, $taxonomy)
    {
        wp_nonce_field('year_header_nonce', 'year_header_nonce');

        $title = get_term_meta($term->term_id, 'year_header_title', true);
        $description = get_term_meta($term->term_id, 'year_header_description', true);
        $related_links = get_term_meta($term->term_id, 'year_related_links', true);

        if (!is_array($related_links)) {
            $related_links = array();
        }
    ?>
        <tr class="form-field">
            <th scope="row">
                <label for="year_header_title"><?php _e('Header Title', 'textdomain'); ?></label>
            </th>
            <td>
                <input type="text" name="year_header_title" id="year_header_title" value="<?php echo esc_attr($title); ?>" />
                <p class="description"><?php _e('Custom header title. Leave empty to use default "Filme Din {Year}".', 'textdomain'); ?></p>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="year_header_description"><?php _e('Header Description', 'textdomain'); ?></label>
            </th>
            <td>
                <?php
                wp_editor($description, 'year_header_description', array(
                    'textarea_name' => 'year_header_description',
                    'textarea_rows' => 5,
                    'media_buttons' => true,
                    'teeny' => true,
                ));
                ?>
                <p class="description"><?php _e('Add a custom description that will appear in the year header.', 'textdomain'); ?></p>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label><?php _e('Related Links', 'textdomain'); ?></label>
            </th>
            <td>
                <div id="related-links-container">
                    <?php if (empty($related_links)) : ?>
                        <div class="related-link-item" data-index="0">
                            <input type="text" name="year_related_links[0][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                            <input type="text" name="year_related_links[0][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                            <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                        </div>
                    <?php else : ?>
                        <?php foreach ($related_links as $index => $link) : ?>
                            <div class="related-link-item" data-index="<?php echo esc_attr($index); ?>">
                                <input type="text" name="year_related_links[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($link['title']); ?>" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                                <input type="text" name="year_related_links[<?php echo esc_attr($index); ?>][url]" value="<?php echo esc_attr($link['url']); ?>" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                                <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="button" class="add-link button"><?php _e('Add Link', 'textdomain'); ?></button>
                <p class="description"><?php _e('Add related links that will appear in the year header.', 'textdomain'); ?></p>
            </td>
        </tr>
    <?php
    }

    /**
     * Save custom fields
     */
    public function save_year_fields($term_id)
    {
        if (
            !isset($_POST['year_header_nonce']) ||
            !wp_verify_nonce($_POST['year_header_nonce'], 'year_header_nonce')
        ) {
            return;
        }

        if (current_user_can('manage_categories')) {
            // Save header description
            // Save header title
            if (isset($_POST['year_header_title'])) {
                $title = sanitize_text_field($_POST['year_header_title']);
                update_term_meta($term_id, 'year_header_title', $title);
            }

            // Save header description
            if (isset($_POST['year_header_description'])) {
                $description = wp_kses_post($_POST['year_header_description']);
                update_term_meta($term_id, 'year_header_description', $description);
            }

            // Save related links
            if (isset($_POST['year_related_links'])) {
                $links = array_values(array_filter($_POST['year_related_links'], function ($link) {
                    return !empty($link['title']) && !empty($link['url']);
                }));

                $sanitized_links = array_map(function ($link) {
                    return array(
                        'title' => sanitize_text_field($link['title']),
                        'url' => esc_url_raw($link['url'])
                    );
                }, $links);

                update_term_meta($term_id, 'year_related_links', $sanitized_links);
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
            jQuery(document).ready(function($) {
                $('.add-link').on('click', function() {
                    var container = $('#related-links-container');
                    var index = container.children().length;

                    var newItem = $('<div class="related-link-item" data-index="' + index + '">' +
                        '<input type="text" name="year_related_links[' + index + '][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />' +
                        '<input type="text" name="year_related_links[' + index + '][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />' +
                        '<button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>' +
                        '</div>');

                    container.append(newItem);
                });

                $(document).on('click', '.remove-link', function() {
                    $(this).closest('.related-link-item').remove();
                });
            });
        </script>
<?php
    }

    /**
     * Get header content including description and related links
     *
     * @param int $term_id Year term ID
     * @return array Header content array
     */
    /**
     * Get default year description
     *
     * @param string $year The year
     * @return string Formatted description
     */
    /**
     * Get default year title
     *
     * @param string $year The year
     * @return string Formatted title
     */
    private static function get_year_title($year)
    {
        return sprintf('Filme Din %s', $year);
    }

    /**
     * Get default year description
     *
     * @param string $year The year
     * @return string Formatted description
     */
    private static function get_year_description($year)
    {
        return sprintf(
            'Descoperiți cele mai interesante filme din anul %s. ' .
                'Această colecție cuprinde producții cinematografice reprezentative pentru anul %s, ' .
                'oferind o perspectivă asupra tendințelor și stilurilor cinematografice ale acestui an.',
            $year,
            $year
        );
    }

    /**
     * Get header content including description and related links
     *
     * @param int $term_id Year term ID
     * @return array Header content array
     */
    public static function get_header_content($term_id)
    {
        $title = get_term_meta($term_id, 'year_header_title', true);
        $description = get_term_meta($term_id, 'year_header_description', true);
        $related_links = get_term_meta($term_id, 'year_related_links', true);
        $term = get_term($term_id, 'an');

        if (empty($title)) {
            $title = self::get_year_title($term->name);
        }

        if (empty($description) && empty($term->description)) {
            $description = self::get_year_description($term->name);
        }

        return array(
            'title' => $title,
            'description' => $description,
            'related_links' => is_array($related_links) ? $related_links : array()
        );
    }
}
