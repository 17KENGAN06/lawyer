<?php
/**
 * The template for displaying 404 pages.
 *
 * The copy is intentionally kept in the template: this page does not depend
 * on ACF and remains available even when no content has been configured.
 *
 * @package Lawyer_Theme
 */

get_header();
?>

<main id="primary" class="overflow-hidden bg-surface-soft">
    <section class="relative isolate flex min-h-[calc(100vh-5rem)] items-center py-20 lg:py-28" aria-labelledby="error-page-title">
        <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
            <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 font-serif text-[15rem] font-semibold leading-none text-primary/[0.035] sm:text-[22rem] lg:text-[32rem]">
                404
            </span>
            <span class="absolute -left-24 top-20 size-72 rounded-full border border-accent/20"></span>
            <span class="absolute -bottom-40 -right-24 size-96 rounded-full border border-primary/10"></span>
        </div>

        <div class="mx-auto w-full max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <div class="mx-auto flex size-20 items-center justify-center rounded-full border border-accent/40 bg-white shadow-sm" aria-hidden="true">
                    <span class="font-serif text-3xl text-accent">§</span>
                </div>

                <p class="mt-8 text-xs font-semibold uppercase tracking-[0.28em] text-accent">
                    <?php esc_html_e('Error 404', 'lawyer-theme'); ?>
                </p>
                <h1 id="error-page-title" class="mt-4 text-5xl font-semibold leading-tight text-primary sm:text-6xl lg:text-7xl">
                    <?php esc_html_e('Page not found', 'lawyer-theme'); ?>
                </h1>
                <p class="mx-auto mt-6 max-w-xl text-base leading-7 text-neutral-600 sm:text-lg sm:leading-8">
                    <?php esc_html_e('The page may have been moved, deleted, or the address may be incorrect. Let us help you find the right way forward.', 'lawyer-theme'); ?>
                </p>

                <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <a class="home-button home-button--gold min-w-52" href="<?php echo esc_url(home_url('/')); ?>">
                        <?php esc_html_e('Return to homepage', 'lawyer-theme'); ?>
                    </a>
                    <a class="home-button min-w-52 border-primary/25 bg-transparent text-primary hover:border-accent hover:text-accent" href="<?php echo esc_url(home_url('/practice-areas/')); ?>">
                        <?php esc_html_e('View practice areas', 'lawyer-theme'); ?>
                    </a>
                </div>

                <div class="mx-auto mt-14 flex max-w-md items-center gap-4 text-xs font-semibold uppercase tracking-[0.2em] text-neutral-600" aria-hidden="true">
                    <span class="h-px flex-1 bg-primary/15"></span>
                    <span><?php esc_html_e('Legal guidance with clarity', 'lawyer-theme'); ?></span>
                    <span class="h-px flex-1 bg-primary/15"></span>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
