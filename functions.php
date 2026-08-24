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
}

add_action('wp_enqueue_scripts', 'lawyer_theme_assets');