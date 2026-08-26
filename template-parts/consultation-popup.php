<?php
/**
 * Delayed consultation popup.
 *
 * @package Lawyer_Theme
 */

if (is_page_template('page-contact.php')) {
    return;
}

$popup_form_shortcode = lawyer_theme_get_contact_form_shortcode();

if (!$popup_form_shortcode) {
    return;
}
?>

<div
    class="consultation-popup fixed inset-0 z-[100] overflow-y-auto"
    data-consultation-popup
    data-delay="30000"
    role="dialog"
    aria-modal="true"
    aria-labelledby="consultation-popup-title"
    hidden>
    <button
        class="fixed inset-0 size-full cursor-default bg-primary/80 backdrop-blur-sm"
        type="button"
        aria-label="<?php esc_attr_e('Close consultation form', 'lawyer-theme'); ?>"
        data-popup-close></button>

    <div class="relative flex min-h-full items-start justify-center px-4 py-8 sm:px-6 sm:py-10 lg:py-12">
        <div class="relative w-full max-w-2xl border border-white/10 bg-surface shadow-2xl">
            <div class="h-1.5 bg-accent" aria-hidden="true"></div>

            <button
                class="absolute right-4 top-5 flex size-11 items-center justify-center border border-primary/15 bg-white text-2xl leading-none text-primary transition-colors hover:border-accent hover:text-accent"
                type="button"
                aria-label="<?php esc_attr_e('Close consultation form', 'lawyer-theme'); ?>"
                data-popup-close>
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="p-6 pr-20 sm:p-10 sm:pr-20">
                <p class="home-kicker"><?php esc_html_e('Confidential consultation', 'lawyer-theme'); ?></p>
                <h2 id="consultation-popup-title" class="mt-3 text-3xl font-semibold leading-tight text-primary sm:text-4xl">
                    <?php esc_html_e('Let’s discuss your situation', 'lawyer-theme'); ?>
                </h2>
                <p class="mt-4 max-w-xl text-sm leading-6 text-neutral-600 sm:text-base sm:leading-7">
                    <?php esc_html_e('Leave your details and we will contact you to clarify the next steps.', 'lawyer-theme'); ?>
                </p>

                <div class="contact-form-shell mt-7">
                    <?php echo do_shortcode($popup_form_shortcode); ?>
                </div>

                <p class="mt-5 text-xs leading-5 text-neutral-600">
                    <?php esc_html_e('By submitting the form, you agree to the processing of your information for the purpose of responding to your request.', 'lawyer-theme'); ?>
                </p>
            </div>
        </div>
    </div>
</div>
