<?php
$header_logo = lawyer_theme_get_option('header_logo', 0);
$header_cta  = lawyer_theme_get_option('header_cta_link', [
    'url'    => home_url('/#contact'),
    'title'  => __('Free Consultation', 'lawyer-theme'),
    'target' => '_self',
]);
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
        <div class="mx-auto flex min-h-20 max-w-7xl flex-wrap items-center justify-between gap-x-5 gap-y-3 px-6 py-3 md:flex-nowrap md:py-0 lg:px-8">
            <?php if ($header_logo) : ?>
                <a class="inline-flex items-center"
                    href="<?php echo esc_url(home_url('/')); ?>"
                    aria-label="<?php echo esc_attr(sprintf(__('%s — Home', 'lawyer-theme'), get_bloginfo('name'))); ?>">
                    <?php
                    echo wp_get_attachment_image($header_logo, 'full', false, [
                        'class' => 'h-12 w-auto',
                    ]);
                    ?>
                </a>
            <?php endif; ?>

            <nav class="desktop-navigation order-3 block w-full overflow-x-auto md:order-none md:w-auto md:overflow-visible" aria-label="<?php esc_attr_e('Primary navigation', 'lawyer-theme'); ?>">
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

        </div>
    </header>

    <?php if (!is_front_page()) : ?>
        <div class="h-32 bg-primary md:h-20" aria-hidden="true"></div>
    <?php endif; ?>
