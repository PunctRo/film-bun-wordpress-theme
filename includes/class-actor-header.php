<?php

/**
 * Actor Header functionality
 */
class Actor_Header
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('actor_add_form_fields', array($this, 'add_actor_fields'), 10, 2);
        add_action('actor_edit_form_fields', array($this, 'edit_actor_fields'), 10, 2);
        add_action('created_actor', array($this, 'save_actor_fields'), 10, 2);
        add_action('edited_actor', array($this, 'save_actor_fields'), 10, 2);

        // Register term meta for REST API access
        add_action('init', array($this, 'register_meta'));

        // Add custom styles to admin head for the repeater field
        add_action('admin_head-term.php', array($this, 'add_admin_styles'));
        add_action('admin_head-edit-tags.php', array($this, 'add_admin_styles'));

        // Enqueue media uploader
        add_action('admin_enqueue_scripts', array($this, 'enqueue_media_scripts'));

        // Add scripts to admin footer
        add_action('admin_footer-term.php', array($this, 'add_admin_scripts'));
        add_action('admin_footer-edit-tags.php', array($this, 'add_admin_scripts'));

        // %filmcount% variable for RankMath meta title/description on term pages
        add_action('rank_math/vars/register_extra_replacements', array($this, 'register_rankmath_vars'));
    }

    /**
     * Format a film count for Romanian prose: "7" but "20 de" (filme).
     */
    public static function format_film_count($count)
    {
        $count = (int) $count;
        return $count < 20 ? (string) $count : $count . ' de';
    }

    /**
     * Register %filmcount% RankMath variable — resolves to the queried
     * term's live post count, so meta descriptions never go stale.
     */
    public function register_rankmath_vars()
    {
        if (!function_exists('rank_math_register_var_replacement')) {
            return;
        }

        rank_math_register_var_replacement(
            'filmcount',
            array(
                'name'        => esc_html__('Film count', 'textdomain'),
                'description' => esc_html__('Number of films assigned to the current term (with "de" appended when 20+)', 'textdomain'),
                'variable'    => 'filmcount',
                'example'     => '7',
            ),
            array($this, 'get_filmcount_var')
        );
    }

    /**
     * Callback for %filmcount%.
     */
    public function get_filmcount_var()
    {
        $term = get_queried_object();
        if ($term instanceof WP_Term) {
            return self::format_film_count($term->count);
        }
        return '';
    }

    /**
     * Enqueue wp.media for actor image upload
     */
    public function enqueue_media_scripts($hook)
    {
        if (in_array($hook, array('term.php', 'edit-tags.php'))) {
            wp_enqueue_media();
        }
    }

    /**
     * Register term meta for REST API exposure
     */
    public function register_meta()
    {
        register_term_meta('actor', 'actor_header_title', array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
            'auth_callback' => function () {
                return current_user_can('manage_categories');
            },
        ));

        register_term_meta('actor', 'actor_header_description', array(
            'show_in_rest' => true,
            'single'       => true,
            'type'         => 'string',
            'auth_callback' => function () {
                return current_user_can('manage_categories');
            },
        ));

        register_term_meta('actor', 'actor_related_links', array(
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

        register_term_meta('actor', 'actor_image_id', array(
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'integer',
            'auth_callback' => function () {
                return current_user_can('manage_categories');
            },
        ));
    }

    /**
     * Add custom fields to actor creation form
     */
    public function add_actor_fields()
    {
        wp_nonce_field('actor_header_nonce', 'actor_header_nonce');
?>
        <div class="form-field">
            <label for="actor_image_id"><?php _e('Actor Photo', 'textdomain'); ?></label>
            <div id="actor-image-preview"></div>
            <input type="hidden" name="actor_image_id" id="actor_image_id" value="" />
            <button type="button" class="button" id="actor-image-upload"><?php _e('Select Image', 'textdomain'); ?></button>
            <button type="button" class="button" id="actor-image-remove" style="display:none;"><?php _e('Remove Image', 'textdomain'); ?></button>
            <p class="description"><?php _e('Photo of the actor displayed on their page and movie pages.', 'textdomain'); ?></p>
        </div>

        <div class="form-field">
            <label for="actor_header_title"><?php _e('Header Title', 'textdomain'); ?></label>
            <input type="text" name="actor_header_title" id="actor_header_title" value="" />
            <p class="description"><?php _e('Custom header title. Leave empty to use default "Filmografia lui {Actor}".', 'textdomain'); ?></p>
        </div>

        <div class="form-field">
            <label for="actor_header_description"><?php _e('Header Description', 'textdomain'); ?></label>
            <?php
            wp_editor('', 'actor_header_description', array(
                'textarea_name' => 'actor_header_description',
                'textarea_rows' => 5,
                'media_buttons' => true,
                'teeny' => true,
            ));
            ?>
            <p class="description"><?php _e('Add a custom description that will appear in the actor header.', 'textdomain'); ?></p>
        </div>

        <div class="form-field">
            <label><?php _e('Related Links', 'textdomain'); ?></label>
            <div id="related-links-container">
                <div class="related-link-item" data-index="0">
                    <input type="text" name="actor_related_links[0][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                    <input type="text" name="actor_related_links[0][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                    <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                </div>
            </div>
            <button type="button" class="add-link button"><?php _e('Add Link', 'textdomain'); ?></button>
            <p class="description"><?php _e('Add related links that will appear in the actor header.', 'textdomain'); ?></p>
        </div>
    <?php
    }

    /**
     * Add custom fields to actor edit form
     */
    public function edit_actor_fields($term, $taxonomy)
    {
        wp_nonce_field('actor_header_nonce', 'actor_header_nonce');

        $title = get_term_meta($term->term_id, 'actor_header_title', true);
        $description = get_term_meta($term->term_id, 'actor_header_description', true);
        $related_links = get_term_meta($term->term_id, 'actor_related_links', true);
        $image_id = (int) get_term_meta($term->term_id, 'actor_image_id', true);

        if (!is_array($related_links)) {
            $related_links = array();
        }
    ?>
        <tr class="form-field">
            <th scope="row">
                <label for="actor_image_id"><?php _e('Actor Photo', 'textdomain'); ?></label>
            </th>
            <td>
                <div id="actor-image-preview">
                    <?php if ($image_id) : ?>
                        <?php echo wp_get_attachment_image($image_id, array(150, 200), false, array('style' => 'display:block;margin-bottom:8px;')); ?>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="actor_image_id" id="actor_image_id" value="<?php echo esc_attr($image_id ?: ''); ?>" />
                <button type="button" class="button" id="actor-image-upload"><?php _e('Select Image', 'textdomain'); ?></button>
                <button type="button" class="button" id="actor-image-remove" <?php echo $image_id ? '' : 'style="display:none;"'; ?>><?php _e('Remove Image', 'textdomain'); ?></button>
                <p class="description"><?php _e('Photo of the actor displayed on their page and movie pages.', 'textdomain'); ?></p>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="actor_header_title"><?php _e('Header Title', 'textdomain'); ?></label>
            </th>
            <td>
                <input type="text" name="actor_header_title" id="actor_header_title" value="<?php echo esc_attr($title); ?>" />
                <p class="description"><?php _e('Custom header title. Leave empty to use default "Filmografia lui {Actor}".', 'textdomain'); ?></p>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="actor_header_description"><?php _e('Header Description', 'textdomain'); ?></label>
            </th>
            <td>
                <?php
                wp_editor($description, 'actor_header_description', array(
                    'textarea_name' => 'actor_header_description',
                    'textarea_rows' => 5,
                    'media_buttons' => true,
                    'teeny' => true,
                ));
                ?>
                <p class="description"><?php _e('Add a custom description that will appear in the actor header.', 'textdomain'); ?></p>
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
                            <input type="text" name="actor_related_links[0][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                            <input type="text" name="actor_related_links[0][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                            <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                        </div>
                    <?php else : ?>
                        <?php foreach ($related_links as $index => $link) : ?>
                            <div class="related-link-item" data-index="<?php echo esc_attr($index); ?>">
                                <input type="text" name="actor_related_links[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($link['title']); ?>" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />
                                <input type="text" name="actor_related_links[<?php echo esc_attr($index); ?>][url]" value="<?php echo esc_attr($link['url']); ?>" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />
                                <button type="button" class="remove-link button"><?php _e('Remove', 'textdomain'); ?></button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="button" class="add-link button"><?php _e('Add Link', 'textdomain'); ?></button>
                <p class="description"><?php _e('Add related links that will appear in the actor header.', 'textdomain'); ?></p>
            </td>
        </tr>
    <?php
    }

    /**
     * Save custom fields
     */
    public function save_actor_fields($term_id)
    {
        if (
            !isset($_POST['actor_header_nonce']) ||
            !wp_verify_nonce($_POST['actor_header_nonce'], 'actor_header_nonce')
        ) {
            return;
        }

        if (current_user_can('manage_categories')) {
            // Save actor image ID
            if (isset($_POST['actor_image_id'])) {
                $image_id = absint($_POST['actor_image_id']);
                if ($image_id) {
                    update_term_meta($term_id, 'actor_image_id', $image_id);
                } else {
                    delete_term_meta($term_id, 'actor_image_id');
                }
            }

            // Save header title
            if (isset($_POST['actor_header_title'])) {
                $title = sanitize_text_field($_POST['actor_header_title']);
                update_term_meta($term_id, 'actor_header_title', $title);
            }

            // Save header description
            if (isset($_POST['actor_header_description'])) {
                $description = wp_kses_post($_POST['actor_header_description']);
                update_term_meta($term_id, 'actor_header_description', $description);
            }

            // Save related links
            if (isset($_POST['actor_related_links'])) {
                $links = array_values(array_filter($_POST['actor_related_links'], function ($link) {
                    return !empty($link['title']) && !empty($link['url']);
                }));

                $sanitized_links = array_map(function ($link) {
                    return array(
                        'title' => sanitize_text_field($link['title']),
                        'url' => esc_url_raw($link['url'])
                    );
                }, $links);

                update_term_meta($term_id, 'actor_related_links', $sanitized_links);
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
                // Actor image uploader
                var mediaFrame;
                $('#actor-image-upload').on('click', function(e) {
                    e.preventDefault();
                    if (mediaFrame) { mediaFrame.open(); return; }
                    mediaFrame = wp.media({ title: '<?php _e('Select Actor Photo', 'textdomain'); ?>', button: { text: '<?php _e('Use this image', 'textdomain'); ?>' }, multiple: false });
                    mediaFrame.on('select', function() {
                        var attachment = mediaFrame.state().get('selection').first().toJSON();
                        $('#actor_image_id').val(attachment.id);
                        $('#actor-image-preview').html('<img src="' + (attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" style="display:block;margin-bottom:8px;max-width:150px;">');
                        $('#actor-image-remove').show();
                    });
                    mediaFrame.open();
                });
                $('#actor-image-remove').on('click', function(e) {
                    e.preventDefault();
                    $('#actor_image_id').val('');
                    $('#actor-image-preview').html('');
                    $(this).hide();
                });

                $('.add-link').on('click', function() {
                    var container = $('#related-links-container');
                    var index = container.children().length;

                    var newItem = $('<div class="related-link-item" data-index="' + index + '">' +
                        '<input type="text" name="actor_related_links[' + index + '][title]" placeholder="<?php _e('Link Title', 'textdomain'); ?>" />' +
                        '<input type="text" name="actor_related_links[' + index + '][url]" placeholder="<?php _e('Link URL', 'textdomain'); ?>" />' +
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
     * @param int $term_id Actor term ID
     * @return array Header content array
     */
    /**
     * Get default actor description
     *
     * @param string $actor_name The name of the actor
     * @return string Formatted description
     */
    /**
     * Get default actor title
     *
     * @param string $actor_name The name of the actor
     * @return string Formatted title
     */
    private static function get_actor_title($actor_name)
    {
        return sprintf('Filmografia lui %s', $actor_name);
    }

    private static function get_actor_description($actor_name)
    {
        return sprintf(
            'Descoperiți filmografia actorului/actriței %s. ' .
                'Această colecție prezintă performanțele memorabile și diversitatea rolurilor interpretate de %s, ' .
                'oferind o perspectivă asupra versatilității și talentului său actoricesc.',
            $actor_name,
            $actor_name
        );
    }

    /**
     * Get header content including description and related links
     *
     * @param int $term_id Actor term ID
     * @return array Header content array
     */
    public static function get_header_content($term_id)
    {
        $title = get_term_meta($term_id, 'actor_header_title', true);
        $description = get_term_meta($term_id, 'actor_header_description', true);
        $related_links = get_term_meta($term_id, 'actor_related_links', true);
        $term = get_term($term_id, 'actor');

        if (empty($title)) {
            $title = self::get_actor_title($term->name);
        }

        if (empty($description) && empty($term->description)) {
            $description = self::get_actor_description($term->name);
        }

        // %filmcount% resolves to the term's live post count at render time
        if ($description && strpos($description, '%filmcount%') !== false) {
            $description = str_replace('%filmcount%', self::format_film_count($term->count), $description);
        }

        return array(
            'title' => $title,
            'description' => $description,
            'related_links' => is_array($related_links) ? $related_links : array()
        );
    }
}
