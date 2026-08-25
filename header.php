<?php
$header_logo        = lawyer_theme_get_option('header_logo', 0);
$header_cta_default = [
    'url'    => home_url('/#contact'),
    'title'  => __('Free Consultation', 'lawyer-theme'),
    'target' => '_self',
];
$header_cta = lawyer_theme_normalize_link(
    lawyer_theme_get_option('header_cta_link', $header_cta_default),
    $header_cta_default
);
?>
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
        <div class="mx-auto flex min-h-20 max-w-7xl items-center justify-between gap-4 px-6 py-3 lg:px-8">
            <?php if ($header_logo) : ?>
                <a class="inline-flex items-center"
                    href="<?php echo esc_url(home_url('/')); ?>"
                    aria-label="<?php echo esc_attr(sprintf(__('%s — Home', 'lawyer-theme'), get_bloginfo('name'))); ?>">
                    <?php
                    echo wp_get_attachment_image($header_logo, 'full', false, [
                        'class' => 'h-10 w-auto sm:h-12',
                    ]);
                    ?>
                </a>
            <?php endif; ?>

            <nav class="desktop-navigation hidden xl:block" aria-label="<?php esc_attr_e('Primary navigation', 'lawyer-theme'); ?>">
                <?php
                $primary_menu = wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'site-nav',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                    'echo'           => false,
                ]);

                if ($primary_menu) {
                    echo wp_kses_post($primary_menu);
                } else {
                    lawyer_theme_menu_fallback((object) [
                        'menu_id'    => 'primary-menu',
                        'menu_class' => 'site-nav',
                    ]);
                }
                ?>
            </nav>

            <a class="hidden border border-accent bg-accent px-5 py-3 text-sm font-semibold text-primary transition-colors hover:bg-transparent hover:text-white xl:inline-flex"
                href="<?php echo esc_url($header_cta['url']); ?>"
                target="<?php echo esc_attr($header_cta['target'] ?: '_self'); ?>">
                <?php echo esc_html($header_cta['title']); ?>
            </a>

            <button class="menu-toggle ml-auto inline-flex size-11 flex-col items-center justify-center gap-1.5 border border-white/20 text-white xl:hidden"
                type="button"
                aria-expanded="false"
                aria-controls="mobile-navigation"
                aria-label="<?php esc_attr_e('Open navigation', 'lawyer-theme'); ?>"
                data-menu-toggle>
                <span class="menu-toggle__line"></span>
                <span class="menu-toggle__line"></span>
                <span class="menu-toggle__line"></span>
            </button>

        </div>

        <div id="mobile-navigation" class="mobile-navigation hidden border-t border-white/10 bg-primary xl:hidden" data-mobile-menu>
            <div class="mx-auto max-w-7xl px-6 pb-6 pt-2">
                <nav aria-label="<?php esc_attr_e('Mobile navigation', 'lawyer-theme'); ?>">
                    <?php
                    $mobile_menu = wp_nav_menu([
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_id'        => 'mobile-menu',
                        'menu_class'     => 'mobile-nav',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                        'echo'           => false,
                    ]);

                    if ($mobile_menu) {
                        echo wp_kses_post($mobile_menu);
                    } else {
                        lawyer_theme_menu_fallback((object) [
                            'menu_id'    => 'mobile-menu',
                            'menu_class' => 'mobile-nav',
                        ]);
                    }
                    ?>
                </nav>

                <a class="mt-5 inline-flex w-full items-center justify-center border border-accent bg-accent px-5 py-3 text-sm font-semibold text-primary"
                    href="<?php echo esc_url($header_cta['url']); ?>"
                    target="<?php echo esc_attr($header_cta['target'] ?: '_self'); ?>">
                    <?php echo esc_html($header_cta['title']); ?>
                </a>
            </div>
        </div>
    </header>

    <?php if (!is_front_page()) : ?>
        <div class="h-20 bg-primary" aria-hidden="true"></div>
    <?php endif; ?>
