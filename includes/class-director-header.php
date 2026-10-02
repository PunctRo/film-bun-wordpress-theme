<?php

/**
 * Director Header functionality
 */
class Director_Header
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('regizor_add_form_fields', array($this, 'add_director_fields'), 10, 2);
        add_action('regizor_edit_form_fields', array($this, 'edit_director_fields'), 10, 2);
        add_action('created_regizor', array($this, 'save_director_fields'), 10, 2);
        add_action('edited_regizor', array($this, 'save_director_fields'), 10, 2);

        // Add custom styles to admin head for the repeater field
        add_action('admin_head-term.php', array($this, 'add_admin_styles'));
        add_action('admin_head-edit-tags.php', array($this, 'add_admin_styles'));

        // Add scripts to admin footer
        add_action('admin_footer-term.php', array($this, 'add_admin_scripts'));
        add_action('admin_footer-edit-tags.php', array($this, 'add_admin_scripts'));
    }

    /**
     * Add custom fields to director creation form
     */
    public function add_director_fields()
    {
        wp_nonce_field('director_header_nonce', 'director_header_nonce');
?>
        <div class="form-field">
            <label for="director_header_description"><?php _e('Header Description', 'textdomain'); ?></label>
            <?php
            wp_editor('', 'director_header_description', array(
                'textarea_name' => 'director_header_description',
                'textarea_rows' => 5,
                'media_buttons' => true,
                'teeny' => true,
            ));
            ?>
            <p class="description"><?php _e('Add a custom description that will appear in the director header.', 'textdomain'); ?></p>
        </div>

        <div class="form-field">
            <label><?php _e('Related Links', 'textdomain'); ?></label>
            <div id="related-links-container">
                <div class="related-link-item" data-index="0">
                    <input type="text" name="director_related_links[0][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                    <input type="text" name="director_related_links[0][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                    <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                </div>
            </div>
            <button type="button" class="add-link button"><?php _e('Add Link', 'textdomain'); ?></button>
            <p class="description"><?php _e('Add related links that will appear in the director header.', 'textdomain'); ?></p>
        </div>
    <?php
    }

    /**
     * Add custom fields to director edit form
     */
    public function edit_director_fields($term, $taxonomy)
    {
        wp_nonce_field('director_header_nonce', 'director_header_nonce');

        $description = get_term_meta($term->term_id, 'director_header_description', true);
        $related_links = get_term_meta($term->term_id, 'director_related_links', true);

        if (!is_array($related_links)) {
            $related_links = array();
        }
    ?>
        <tr class="form-field">
            <th scope="row">
                <label for="director_header_description"><?php _e('Header Description', 'textdomain'); ?></label>
            </th>
            <td>
                <?php
                wp_editor($description, 'director_header_description', array(
                    'textarea_name' => 'director_header_description',
                    'textarea_rows' => 5,
                    'media_buttons' => true,
                    'teeny' => true,
                ));
                ?>
                <p class="description"><?php _e('Add a custom description that will appear in the director header.', 'textdomain'); ?></p>
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
                            <input type="text" name="director_related_links[0][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                            <input type="text" name="director_related_links[0][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                            <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                        </div>
                    <?php else : ?>
                        <?php foreach ($related_links as $index => $link) : ?>
                            <div class="related-link-item" data-index="<?php echo esc_attr($index); ?>">
                                <input type="text" name="director_related_links[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($link['title']); ?>" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                                <input type="text" name="director_related_links[<?php echo esc_attr($index); ?>][url]" value="<?php echo esc_attr($link['url']); ?>" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                                <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="button" class="add-link button"><?php _e('Add Link', 'textdomain'); ?></button>
                <p class="description"><?php _e('Add related links that will appear in the director header.', 'textdomain'); ?></p>
            </td>
        </tr>
    <?php
    }

    /**
     * Save custom fields
     */
    public function save_director_fields($term_id)
    {
        if (
            !isset($_POST['director_header_nonce']) ||
            !wp_verify_nonce($_POST['director_header_nonce'], 'director_header_nonce')
        ) {
            return;
        }

        if (current_user_can('manage_categories')) {
            // Save header description
            if (isset($_POST['director_header_description'])) {
                $description = wp_kses_post($_POST['director_header_description']);
                update_term_meta($term_id, 'director_header_description', $description);
            }

            // Save related links
            if (isset($_POST['director_related_links'])) {
                $links = array_values(array_filter($_POST['director_related_links'], function ($link) {
                    return !empty($link['title']) && !empty($link['url']);
                }));

                $sanitized_links = array_map(function ($link) {
                    return array(
                        'title' => sanitize_text_field($link['title']),
                        'url' => esc_url_raw($link['url'])
                    );
                }, $links);

                update_term_meta($term_id, 'director_related_links', $sanitized_links);
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
                        '<input type="text" name="director_related_links[' + index + '][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />' +
                        '<input type="text" name="director_related_links[' + index + '][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />' +
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
     * @param int $term_id Director term ID
     * @return array Header content array
     */
    /**
     * Get default director description
     *
     * @param string $director_name The name of the director
     * @return string Formatted description
     */
    private static function get_director_description($director_name, $count = 0)
    {
        if ((int) $count === 1) {
            return sprintf(
                'Pe Film-Bun găsești filmul regizat de %s, văzut și recenzat de echipa noastră — ' .
                    'cu nota Film-Bun, nota IMDb și o scurtă prezentare fără spoilere.',
                $director_name
            );
        }

        return sprintf(
            'Pe Film-Bun găsești filmele regizate de %s, văzute și recenzate de echipa noastră — ' .
                'la fiecare cu nota Film-Bun, nota IMDb și o scurtă prezentare fără spoilere.',
            $director_name
        );
    }

    /**
     * Get header content including description and related links
     *
     * @param int $term_id Director term ID
     * @return array Header content array
     */
    public static function get_header_content($term_id)
    {
        $description = get_term_meta($term_id, 'director_header_description', true);
        $related_links = get_term_meta($term_id, 'director_related_links', true);
        $term = get_term($term_id, 'regizor');

        if (empty($description) && empty($term->description)) {
            $description = self::get_director_description($term->name, $term->count);
        }

        return array(
            'description' => $description,
            'related_links' => is_array($related_links) ? $related_links : array()
        );
    }
}
