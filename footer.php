<footer id="contact" class="bg-primary-dark text-neutral-300">
    <div class="mx-auto grid max-w-7xl gap-12 px-6 py-16 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr] lg:px-8 lg:py-20">
        <div class="max-w-md">
            <a class="inline-flex items-center gap-3 text-white"
                href="<?php echo esc_url(home_url('/')); ?>"
                aria-label="<?php esc_attr_e('Lawyer Theme — Home', 'lawyer-theme'); ?>">
                <span class="flex size-11 items-center justify-center border border-accent text-lg font-semibold text-accent" aria-hidden="true">LT</span>
                <span class="leading-none">
                    <span class="block font-serif text-xl tracking-[0.12em]">LAWYER</span>
                    <span class="mt-1 block text-[0.6rem] uppercase tracking-[0.42em] text-accent">Theme</span>
                </span>
            </a>

            <p class="mt-6 leading-7">
                <?php esc_html_e('Strategic legal guidance built on clarity, integrity and a personal commitment to every client.', 'lawyer-theme'); ?>
            </p>
        </div>

        <div>
            <h2 class="font-serif text-xl text-white"><?php esc_html_e('Navigation', 'lawyer-theme'); ?></h2>
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
                <?php esc_html_e('Need legal guidance?', 'lawyer-theme'); ?>
            </p>
            <h2 class="mt-3 font-serif text-2xl leading-tight text-white">
                <?php esc_html_e('Let’s discuss your case.', 'lawyer-theme'); ?>
            </h2>
            <a class="mt-6 inline-flex border border-accent bg-accent px-5 py-3 font-semibold text-primary transition-colors hover:bg-transparent hover:text-white"
                href="<?php echo esc_url(home_url('/#contact-form')); ?>">
                <?php esc_html_e('Request Consultation', 'lawyer-theme'); ?>
            </a>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-6 py-6 text-sm sm:flex-row sm:items-center sm:justify-between lg:px-8">
            <p>
                &copy; <?php echo esc_html(wp_date('Y')); ?> <?php bloginfo('name'); ?>.
                <?php esc_html_e('All rights reserved.', 'lawyer-theme'); ?>
            </p>
            <p><?php esc_html_e('Professional legal representation with personal attention.', 'lawyer-theme'); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>

</html>
