<?php
// includes/class-news-settings.php — Customizer section "Setări Știri".

class News_Settings
{
    public function __construct()
    {
        add_action('customize_register', [$this, 'register']);
    }

    public function register($wp_customize)
    {
        $wp_customize->add_section('stiri_settings', [
            'title'    => 'Setări Știri',
            'priority' => 160,
        ]);

        $wp_customize->add_setting('stiri_h1', [
            'default'           => 'Știri despre filme',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('stiri_h1', [
            'label'   => 'Titlu (H1)',
            'section' => 'stiri_settings',
            'type'    => 'text',
        ]);

        $wp_customize->add_setting('stiri_intro', [
            'default'           => 'Premiere, trailere noi, ce apare pe Netflix și HBO Max, și recomandările echipei Film-Bun — toate într-un singur loc.',
            'sanitize_callback' => 'wp_kses_post',
        ]);
        $wp_customize->add_control('stiri_intro', [
            'label'   => 'Intro (SEO)',
            'section' => 'stiri_settings',
            'type'    => 'textarea',
        ]);

        $wp_customize->add_setting('stiri_meta_title', [
            'default'           => 'Știri despre Filme: Premiere, Trailere, Noutăți | Film-Bun',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('stiri_meta_title', [
            'label'       => 'Meta title (SEO)',
            'description' => 'Titlul <title>/og:title pentru /stiri. Max ~60 caractere.',
            'section'     => 'stiri_settings',
            'type'        => 'text',
        ]);

        $wp_customize->add_setting('stiri_meta_description', [
            'default'           => 'Știri despre filme: premiere, trailere noi, ce apare pe Netflix și HBO Max și recomandările echipei Film-Bun. Toate noutățile din lumea filmului.',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control('stiri_meta_description', [
            'label'       => 'Meta description (SEO)',
            'description' => 'Descrierea meta/og:description pentru /stiri. Max ~155 caractere.',
            'section'     => 'stiri_settings',
            'type'        => 'textarea',
        ]);

        $wp_customize->add_setting('stiri_hero_image', [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'stiri_hero_image', [
            'label'   => 'Imagine hero',
            'section' => 'stiri_settings',
        ]));
    }
}
