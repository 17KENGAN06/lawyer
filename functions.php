<?php

function lawyer_theme_setup()
{
    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    register_nav_menus([
        'primary' => __('Main Menu', 'lawyer-theme'),
        'footer'  => __('Footer Menu', 'lawyer-theme'),
    ]);
}

add_action('after_setup_theme', 'lawyer_theme_setup');

function lawyer_theme_get_option($field_name, $default = '')
{
    if (!function_exists('get_field')) {
        return $default;
    }

    $value = get_field($field_name, 'option');

    return ($value !== null && $value !== false && $value !== '') ? $value : $default;
}

function lawyer_theme_normalize_link($value, $default = [])
{
    $default = wp_parse_args($default, [
        'url'    => '',
        'title'  => '',
        'target' => '_self',
    ]);

    if (is_string($value)) {
        $value = ['url' => $value];
    }

    if (!is_array($value)) {
        return $default;
    }

    return [
        'url'    => !empty($value['url']) ? $value['url'] : $default['url'],
        'title'  => isset($value['title']) && $value['title'] !== '' ? $value['title'] : $default['title'],
        'target' => !empty($value['target']) ? $value['target'] : $default['target'],
    ];
}

/**
 * Return the form shortcode configured on the Contact page.
 *
 * The popup reuses the existing form rather than introducing a second form
 * handler. As a fallback, the first published Contact Form 7 form is used.
 *
 * @return string
 */
function lawyer_theme_get_contact_form_shortcode()
{
    static $shortcode = null;

    if ($shortcode !== null) {
        return $shortcode;
    }

    $shortcode    = '';
    $contact_page = get_posts([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'page-contact.php',
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    if ($contact_page && function_exists('get_field')) {
        $shortcode = trim((string) get_field('contact_form_shortcode', $contact_page[0]));
    }

    if (!$shortcode && post_type_exists('wpcf7_contact_form')) {
        $forms = get_posts([
            'post_type'      => 'wpcf7_contact_form',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'no_found_rows'  => true,
        ]);

        if ($forms) {
            $shortcode = sprintf('[contact-form-7 id="%d"]', (int) $forms[0]);
        }
    }

    return (string) apply_filters('lawyer_theme_contact_form_shortcode', $shortcode);
}

function lawyer_theme_reading_time($post_id = 0)
{
    $post_id = $post_id ?: get_the_ID();
    $content = wp_strip_all_tags((string) get_post_field('post_content', $post_id));

    preg_match_all('/[\p{L}\p{N}]+/u', $content, $words);

    return max(1, (int) ceil(count($words[0]) / 200));
}

function lawyer_theme_acf_options_pages()
{
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    $parent = acf_add_options_page([
        'page_title' => __('Theme Settings', 'lawyer-theme'),
        'menu_title' => __('Theme Settings', 'lawyer-theme'),
        'menu_slug'  => 'lawyer-theme-settings',
        'capability' => 'manage_options',
        'redirect'   => true,
        'icon_url'   => 'dashicons-admin-customizer',
    ]);

    acf_add_options_sub_page([
        'page_title'  => __('Header Settings', 'lawyer-theme'),
        'menu_title'  => __('Header', 'lawyer-theme'),
        'menu_slug'   => 'lawyer-header-settings',
        'parent_slug' => $parent['menu_slug'],
    ]);

    acf_add_options_sub_page([
        'page_title'  => __('Footer Settings', 'lawyer-theme'),
        'menu_title'  => __('Footer', 'lawyer-theme'),
        'menu_slug'   => 'lawyer-footer-settings',
        'parent_slug' => $parent['menu_slug'],
    ]);
}

add_action('acf/init', 'lawyer_theme_acf_options_pages');

function lawyer_theme_assets()
{
    wp_enqueue_style(
        'lawyer-theme-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'lawyer-theme-style',
        get_template_directory_uri() . '/assets/css/app.css',
        ['lawyer-theme-fonts'],
        filemtime(get_template_directory() . '/assets/css/app.css')
    );

    wp_enqueue_script(
        'lawyer-theme-header',
        get_template_directory_uri() . '/assets/js/header.js',
        [],
        filemtime(get_template_directory() . '/assets/js/header.js'),
        true
    );

    if (!is_page_template('page-contact.php')) {
        wp_enqueue_script(
            'lawyer-theme-consultation-popup',
            get_template_directory_uri() . '/assets/js/consultation-popup.js',
            [],
            filemtime(get_template_directory() . '/assets/js/consultation-popup.js'),
            true
        );
    }
}

add_action('wp_enqueue_scripts', 'lawyer_theme_assets');

function lawyer_theme_menu_fallback($args = [])
{
    if (is_array($args)) {
        $menu_id    = !empty($args['menu_id']) ? $args['menu_id'] : 'menu-fallback';
        $menu_class = !empty($args['menu_class']) ? $args['menu_class'] : 'site-nav';
    } else {
        $menu_id    = !empty($args->menu_id) ? $args->menu_id : 'menu-fallback';
        $menu_class = !empty($args->menu_class) ? $args->menu_class : 'site-nav';
    }

    $links      = [
        __('Home', 'lawyer-theme')           => home_url('/'),
        __('About', 'lawyer-theme')          => home_url('/#about'),
        __('Practice Areas', 'lawyer-theme') => home_url('/#practice-areas'),
        __('Blog', 'lawyer-theme')           => home_url('/#latest-articles'),
        __('Contact', 'lawyer-theme')        => home_url('/#contact'),
    ];

    echo '<ul id="' . esc_attr($menu_id) . '" class="' . esc_attr($menu_class) . '">';

    foreach ($links as $label => $url) {
        echo '<li><a href="' . esc_url($url) . '">' . esc_html($label) . '</a></li>';
    }

    echo '</ul>';
}
