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
