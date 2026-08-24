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
        'primary' => __('Primary Menu', 'lawyer-theme'),
        'footer'  => __('Footer Menu', 'lawyer-theme'),
    ]);
}

add_action('after_setup_theme', 'lawyer_theme_setup');

function lawyer_theme_assets()
{
    wp_enqueue_style(
        'lawyer-theme-style',
        get_template_directory_uri() . '/assets/css/app.css',
        [],
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
    $menu_id    = !empty($args->menu_id) ? $args->menu_id : 'menu-fallback';
    $menu_class = !empty($args->menu_class) ? $args->menu_class : 'menu';
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
