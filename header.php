<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <header id="site-header"
        class="site-header <?php echo is_front_page() ? '' : 'site-header--solid'; ?>"
        data-site-header>
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">
            <a class="group inline-flex items-center gap-3 text-white"
                href="<?php echo esc_url(home_url('/')); ?>"
                aria-label="<?php esc_attr_e('Lawyer Theme — Home', 'lawyer-theme'); ?>">
                <span class="flex size-11 items-center justify-center border border-accent text-lg font-semibold text-accent transition-colors group-hover:bg-accent group-hover:text-primary"
                    aria-hidden="true">LT</span>
                <span class="leading-none">
                    <span class="block font-serif text-xl tracking-[0.12em]">LAWYER</span>
                    <span class="mt-1 block text-[0.6rem] uppercase tracking-[0.42em] text-accent">Theme</span>
                </span>
            </a>

            <nav class="hidden lg:block" aria-label="<?php esc_attr_e('Primary navigation', 'lawyer-theme'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'site-nav',
                    'fallback_cb'    => 'lawyer_theme_menu_fallback',
                    'depth'          => 1,
                ]);
                ?>
            </nav>

            <a class="hidden border border-accent bg-accent px-5 py-3 text-sm font-semibold text-primary transition-colors hover:bg-transparent hover:text-white lg:inline-flex"
                href="<?php echo esc_url(home_url('/#contact')); ?>">
                <?php esc_html_e('Free Consultation', 'lawyer-theme'); ?>
            </a>

            <button class="inline-flex size-11 items-center justify-center border border-white/20 text-white transition-colors hover:border-accent hover:text-accent lg:hidden"
                type="button"
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="<?php esc_attr_e('Open navigation', 'lawyer-theme'); ?>"
                data-menu-toggle>
                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="mobile-menu hidden border-t border-white/10 bg-primary px-6 py-6 lg:hidden" data-mobile-menu>
            <nav aria-label="<?php esc_attr_e('Mobile navigation', 'lawyer-theme'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_id'        => 'mobile-primary-menu',
                    'menu_class'     => 'mobile-nav',
                    'fallback_cb'    => 'lawyer_theme_menu_fallback',
                    'depth'          => 1,
                ]);
                ?>
            </nav>

            <a class="mt-6 flex justify-center bg-accent px-5 py-3 font-semibold text-primary"
                href="<?php echo esc_url(home_url('/#contact')); ?>">
                <?php esc_html_e('Free Consultation', 'lawyer-theme'); ?>
            </a>
        </div>
    </header>

    <?php if (!is_front_page()) : ?>
        <div class="h-20 bg-primary" aria-hidden="true"></div>
    <?php endif; ?>
