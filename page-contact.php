<?php
/* Template Name: Contact Page */
get_header();

$page_id = get_the_ID();
$contact_field = static function ($name, $default = '') use ($page_id) {
    if (!function_exists('get_field')) {
        return $default;
    }
    $value = get_field($name, $page_id);
    return ($value !== null && $value !== false && $value !== '') ? $value : $default;
};
$contact_image_url = static function ($value, $fallback = '') {
    if (is_array($value)) {
        if (!empty($value['url'])) {
            return $value['url'];
        }
        $value = $value['ID'] ?? $value['id'] ?? 0;
    }
    if (is_numeric($value)) {
        return wp_get_attachment_image_url((int) $value, 'full') ?: $fallback;
    }
    return is_string($value) && $value !== '' ? $value : $fallback;
};

$hero_image = $contact_image_url($contact_field('contact_hero_image'), get_template_directory_uri() . '/assets/images/blog-hero.png');
$form_shortcode = trim((string) $contact_field('contact_form_shortcode'));
$map_url = trim((string) $contact_field('contact_map_url'));
$details = $contact_field('contact_details', [
    ['icon' => '☎', 'label' => __('Phone', 'lawyer-theme'), 'value' => '+7 (495) 120-35-50', 'link' => ['url' => 'tel:+74951203550', 'title' => '+7 (495) 120-35-50', 'target' => '_self']],
    ['icon' => '✉', 'label' => __('Email', 'lawyer-theme'), 'value' => 'info@example.com', 'link' => ['url' => 'mailto:info@example.com', 'title' => 'info@example.com', 'target' => '_self']],
    ['icon' => '⌖', 'label' => __('Office', 'lawyer-theme'), 'value' => __('16 Tverskaya Street, Office 505', 'lawyer-theme'), 'link' => []],
]);
$hours = $contact_field('contact_hours', [
    ['days' => __('Monday – Friday', 'lawyer-theme'), 'time' => '09:00 – 19:00'],
    ['days' => __('Saturday', 'lawyer-theme'), 'time' => __('By appointment', 'lawyer-theme')],
    ['days' => __('Sunday', 'lawyer-theme'), 'time' => __('Closed', 'lawyer-theme')],
]);
$steps = $contact_field('contact_steps', [
    ['number' => '01', 'title' => __('Send your request', 'lawyer-theme'), 'text' => __('Briefly describe your situation and preferred way to contact you.', 'lawyer-theme')],
    ['number' => '02', 'title' => __('We contact you', 'lawyer-theme'), 'text' => __('We clarify the initial details and arrange a convenient time.', 'lawyer-theme')],
    ['number' => '03', 'title' => __('Confidential consultation', 'lawyer-theme'), 'text' => __('You receive a clear assessment and practical next steps.', 'lawyer-theme')],
]);
?>

<main class="contact-page bg-surface-soft">
    <section class="contact-hero" style="background-image:url('<?php echo esc_url($hero_image); ?>')">
        <div class="contact-hero-overlay"></div>
        <div class="relative z-10 mx-auto flex min-h-[500px] max-w-7xl items-center px-6 py-20 lg:px-8">
            <div class="max-w-2xl text-white">
                <p class="home-kicker text-accent-light"><?php echo esc_html($contact_field('contact_hero_eyebrow', __('Contact', 'lawyer-theme'))); ?></p>
                <h1 class="mt-5 text-5xl font-semibold leading-[1.06] md:text-7xl"><?php echo esc_html($contact_field('contact_hero_title', __('Let’s discuss your legal matter', 'lawyer-theme'))); ?></h1>
                <p class="mt-7 max-w-xl text-lg leading-8 text-neutral-300"><?php echo esc_html($contact_field('contact_hero_text', __('Tell us about your situation and receive a clear, confidential assessment of the next steps.', 'lawyer-theme'))); ?></p>
            </div>
        </div>
    </section>

    <section class="relative z-20 -mt-10"><div class="mx-auto grid max-w-7xl gap-4 px-6 md:grid-cols-3 lg:px-8"><?php foreach ($details as $detail) : $detail_link = lawyer_theme_normalize_link($detail['link'] ?? [], ['url' => '', 'title' => $detail['value'] ?? '', 'target' => '_self']); ?><article class="border border-primary/10 bg-white p-7 shadow-lg"><span class="text-2xl text-accent"><?php echo esc_html($detail['icon'] ?? '◇'); ?></span><p class="mt-4 text-xs font-semibold uppercase tracking-[0.2em] text-neutral-600"><?php echo esc_html($detail['label'] ?? ''); ?></p><?php if ($detail_link['url']) : ?><a class="mt-2 block font-serif text-2xl font-semibold hover:text-accent" href="<?php echo esc_url($detail_link['url']); ?>" target="<?php echo esc_attr($detail_link['target']); ?>"><?php echo esc_html($detail_link['title']); ?></a><?php else : ?><p class="mt-2 font-serif text-2xl font-semibold"><?php echo esc_html($detail['value'] ?? ''); ?></p><?php endif; ?></article><?php endforeach; ?></div></section>

    <section id="contact-form" class="home-section"><div class="mx-auto grid max-w-7xl gap-12 px-6 lg:grid-cols-[1.15fr_0.85fr] lg:px-8">
        <div class="border border-primary/10 bg-white p-7 shadow-sm md:p-10"><p class="home-kicker"><?php echo esc_html($contact_field('contact_form_eyebrow', __('Send a request', 'lawyer-theme'))); ?></p><h2 class="home-title text-left"><?php echo esc_html($contact_field('contact_form_title', __('How can we help?', 'lawyer-theme'))); ?></h2><p class="mt-5 leading-7 text-neutral-600"><?php echo esc_html($contact_field('contact_form_text', __('Complete the form and we will contact you as soon as possible.', 'lawyer-theme'))); ?></p><div class="contact-form-shell mt-8"><?php if ($form_shortcode) : echo do_shortcode($form_shortcode); else : ?><div class="border border-dashed border-primary/20 bg-surface-soft p-8 text-center text-sm text-neutral-600"><?php esc_html_e('Add your form shortcode in the Contact page ACF settings.', 'lawyer-theme'); ?></div><?php endif; ?></div><p class="mt-5 text-xs leading-5 text-neutral-600"><?php echo esc_html($contact_field('contact_privacy_text', __('By submitting the form, you agree to the processing of your information for the purpose of responding to your request.', 'lawyer-theme'))); ?></p></div>
        <aside class="space-y-7"><div class="bg-primary p-8 text-white"><p class="home-kicker text-accent-light"><?php echo esc_html($contact_field('contact_office_eyebrow', __('Office information', 'lawyer-theme'))); ?></p><h2 class="mt-4 text-3xl font-semibold"><?php echo esc_html($contact_field('contact_office_title', __('Visit by appointment', 'lawyer-theme'))); ?></h2><p class="mt-5 leading-7 text-neutral-300"><?php echo esc_html($contact_field('contact_office_address', __('16 Tverskaya Street, Office 505, Moscow', 'lawyer-theme'))); ?></p><div class="mt-7 border-t border-white/15 pt-5"><?php foreach ($hours as $row) : ?><div class="flex justify-between gap-5 border-b border-white/10 py-3 text-sm last:border-b-0"><span class="text-neutral-300"><?php echo esc_html($row['days'] ?? ''); ?></span><strong class="text-right font-medium"><?php echo esc_html($row['time'] ?? ''); ?></strong></div><?php endforeach; ?></div></div><?php if ($map_url) : ?><div class="overflow-hidden border border-primary/10 bg-white"><iframe class="h-80 w-full" src="<?php echo esc_url($map_url); ?>" title="<?php echo esc_attr($contact_field('contact_map_title', __('Office map', 'lawyer-theme'))); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div><?php endif; ?></aside>
    </div></section>

    <section class="home-section bg-white"><div class="mx-auto max-w-7xl px-6 lg:px-8"><div class="text-center"><p class="home-kicker"><?php echo esc_html($contact_field('contact_steps_eyebrow', __('What happens next', 'lawyer-theme'))); ?></p><h2 class="home-title"><?php echo esc_html($contact_field('contact_steps_title', __('A simple and confidential process', 'lawyer-theme'))); ?></h2></div><div class="mt-12 grid gap-6 md:grid-cols-3"><?php foreach ($steps as $step) : ?><article class="home-card p-8"><span class="font-serif text-4xl text-accent"><?php echo esc_html($step['number'] ?? ''); ?></span><h3 class="mt-5 text-2xl font-semibold"><?php echo esc_html($step['title'] ?? ''); ?></h3><p class="mt-3 text-sm leading-6 text-neutral-600"><?php echo esc_html($step['text'] ?? ''); ?></p></article><?php endforeach; ?></div></div></section>

    <section class="border-b border-white/10 bg-primary py-12 text-white"><div class="mx-auto max-w-4xl px-6 text-center lg:px-8"><p class="home-kicker text-accent-light"><?php echo esc_html($contact_field('contact_note_eyebrow', __('Confidentiality', 'lawyer-theme'))); ?></p><h2 class="mt-3 text-3xl font-semibold md:text-4xl"><?php echo esc_html($contact_field('contact_note_title', __('Your information remains protected', 'lawyer-theme'))); ?></h2><p class="mx-auto mt-4 max-w-2xl leading-7 text-neutral-300"><?php echo esc_html($contact_field('contact_note_text', __('Every enquiry is treated with discretion. Contacting us does not obligate you to proceed.', 'lawyer-theme'))); ?></p></div></section>
</main>

<?php get_footer(); ?>
