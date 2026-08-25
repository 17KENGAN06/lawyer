<?php
$footer_logo             = lawyer_theme_get_option('footer_logo', $header_logo ?? 0);
$footer_description      = lawyer_theme_get_option('footer_description', __('Strategic legal guidance built on clarity, integrity and a personal commitment to every client.', 'lawyer-theme'));
$footer_navigation_title = lawyer_theme_get_option('footer_navigation_title', __('Navigation', 'lawyer-theme'));
$footer_cta_eyebrow      = lawyer_theme_get_option('footer_cta_eyebrow', __('Need legal guidance?', 'lawyer-theme'));
$footer_cta_title        = lawyer_theme_get_option('footer_cta_title', __('Let’s discuss your case.', 'lawyer-theme'));
$footer_cta_default      = [
    'url'    => home_url('/#contact-form'),
    'title'  => __('Request Consultation', 'lawyer-theme'),
    'target' => '_self',
];
$footer_cta              = lawyer_theme_normalize_link(
    lawyer_theme_get_option('footer_cta_link', $footer_cta_default),
    $footer_cta_default
);
$footer_copyright        = lawyer_theme_get_option('footer_copyright_text', __('All rights reserved.', 'lawyer-theme'));
$footer_bottom_text      = lawyer_theme_get_option('footer_bottom_text', __('Professional legal representation with personal attention.', 'lawyer-theme'));
?>
<footer id="contact" class="bg-primary-dark text-neutral-300">
    <div class="mx-auto grid max-w-7xl gap-12 px-6 py-16 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr] lg:px-8 lg:py-20">
        <div class="max-w-md">
            <a class="inline-flex items-center gap-3 text-white"
                href="<?php echo esc_url(home_url('/')); ?>"
                aria-label="<?php esc_attr_e('Lawyer Theme — Home', 'lawyer-theme'); ?>">
                <?php if ($footer_logo) : ?>
                    <?php
                    echo wp_get_attachment_image($footer_logo, 'full', false, [
                        'class' => 'h-12 w-auto',
                    ]);
                    ?>
                <?php else : ?>
                    <span class="flex size-11 items-center justify-center border border-accent text-lg font-semibold text-accent" aria-hidden="true">LT</span>
                    <span class="leading-none">
                        <span class="block font-serif text-xl tracking-[0.12em]"><?php echo esc_html($header_logo_text ?? 'LAWYER'); ?></span>
                        <span class="mt-1 block text-[0.6rem] uppercase tracking-[0.42em] text-accent"><?php echo esc_html($header_logo_tagline ?? 'Theme'); ?></span>
                    </span>
                <?php endif; ?>
            </a>

            <p class="mt-6 leading-7">
                <?php echo esc_html($footer_description); ?>
            </p>
        </div>

        <div>
            <h2 class="font-serif text-xl text-white"><?php echo esc_html($footer_navigation_title); ?></h2>
            <?php
            wp_nav_menu([
                'theme_location' => 'footer',
                'container'      => false,
                'menu_id'        => 'footer-menu',
                'menu_class'     => 'footer-nav mt-6',
                'fallback_cb'    => 'lawyer_theme_menu_fallback',
                'depth'          => 1,
            ]);
            ?>
        </div>

        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-accent">
                <?php echo esc_html($footer_cta_eyebrow); ?>
            </p>
            <h2 class="mt-3 font-serif text-2xl leading-tight text-white">
                <?php echo esc_html($footer_cta_title); ?>
            </h2>
            <a class="mt-6 inline-flex border border-accent bg-accent px-5 py-3 font-semibold text-primary transition-colors hover:bg-transparent hover:text-white"
                href="<?php echo esc_url($footer_cta['url']); ?>"
                target="<?php echo esc_attr($footer_cta['target'] ?: '_self'); ?>">
                <?php echo esc_html($footer_cta['title']); ?>
            </a>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-6 py-6 text-sm sm:flex-row sm:items-center sm:justify-between lg:px-8">
            <p>
                &copy; <?php echo esc_html(wp_date('Y')); ?> <?php bloginfo('name'); ?>.
                <?php echo esc_html($footer_copyright); ?>
            </p>
            <p><?php echo esc_html($footer_bottom_text); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>

</html>
