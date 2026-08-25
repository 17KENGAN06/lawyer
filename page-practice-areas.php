<?php
/* Template Name: Practice Areas Page */
get_header();

$page_id = get_the_ID();
$practice_field = static function ($name, $default = '') use ($page_id) {
    if (!function_exists('get_field')) {
        return $default;
    }
    $value = get_field($name, $page_id);
    return ($value !== null && $value !== false && $value !== '') ? $value : $default;
};
$practice_image_url = static function ($value, $fallback = '') {
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
$practice_lines = static function ($value) {
    if (is_array($value)) {
        return array_values(array_filter(array_map('trim', $value)));
    }
    return array_values(array_filter(array_map('trim', preg_split('/\R/u', (string) $value))));
};

$hero_image = $practice_image_url($practice_field('practice_hero_image'), get_template_directory_uri() . '/assets/images/blog-hero.png');
$intro_image = $practice_image_url($practice_field('practice_intro_image'), get_template_directory_uri() . '/assets/images/home-about.png');
$cta_link = lawyer_theme_normalize_link(
    $practice_field('practice_cta_link'),
    ['url' => home_url('/#contact'), 'title' => __('Schedule a consultation', 'lawyer-theme'), 'target' => '_self']
);

$stats = $practice_field('practice_stats', [
    ['value' => '15+', 'label' => __('Years of practice', 'lawyer-theme')],
    ['value' => '6', 'label' => __('Core practice areas', 'lawyer-theme')],
    ['value' => '500+', 'label' => __('Matters handled', 'lawyer-theme')],
    ['value' => '92%', 'label' => __('Favorable outcomes', 'lawyer-theme')],
]);
$areas = $practice_field('practice_areas', [
    ['icon' => '◇', 'title' => __('Family Law', 'lawyer-theme'), 'text' => __('Sensitive family matters handled with discretion, clarity and care.', 'lawyer-theme'), 'bullets' => "Divorce and separation\nChild custody and support\nMarital agreements", 'link' => []],
    ['icon' => '§', 'title' => __('Inheritance Law', 'lawyer-theme'), 'text' => __('Protection of inheritance rights and careful planning for the future.', 'lawyer-theme'), 'bullets' => "Probate and estate administration\nWill disputes\nEstate planning", 'link' => []],
    ['icon' => '▤', 'title' => __('Contracts & Transactions', 'lawyer-theme'), 'text' => __('Clear agreements that reduce risk and support your objectives.', 'lawyer-theme'), 'bullets' => "Contract drafting\nLegal review\nNegotiation support", 'link' => []],
    ['icon' => '⌂', 'title' => __('Court Representation', 'lawyer-theme'), 'text' => __('Strategic preparation and confident advocacy at every stage.', 'lawyer-theme'), 'bullets' => "Civil disputes\nCommercial litigation\nAppeals", 'link' => []],
    ['icon' => '▥', 'title' => __('Real Estate', 'lawyer-theme'), 'text' => __('Legal security for property ownership and transactions.', 'lawyer-theme'), 'bullets' => "Due diligence\nPurchase and sale\nProperty disputes", 'link' => []],
    ['icon' => '▣', 'title' => __('Business Counsel', 'lawyer-theme'), 'text' => __('Practical support for companies, founders and entrepreneurs.', 'lawyer-theme'), 'bullets' => "Company formation\nCorporate agreements\nOngoing legal support", 'link' => []],
]);
$support_points = $practice_field('practice_support_points', [
    ['number' => '01', 'title' => __('Clear risk assessment', 'lawyer-theme'), 'text' => __('You receive a practical explanation of the strengths, risks and available options.', 'lawyer-theme')],
    ['number' => '02', 'title' => __('Personal legal strategy', 'lawyer-theme'), 'text' => __('Every plan is tailored to your priorities, timeline and circumstances.', 'lawyer-theme')],
    ['number' => '03', 'title' => __('Direct communication', 'lawyer-theme'), 'text' => __('You work directly with the attorney handling your matter.', 'lawyer-theme')],
]);
$steps = $practice_field('practice_steps', [
    ['number' => '01', 'title' => __('Initial consultation', 'lawyer-theme'), 'text' => __('We discuss the situation, documents and immediate priorities.', 'lawyer-theme')],
    ['number' => '02', 'title' => __('Legal analysis', 'lawyer-theme'), 'text' => __('We identify risks, possible outcomes and the strongest route forward.', 'lawyer-theme')],
    ['number' => '03', 'title' => __('Action plan', 'lawyer-theme'), 'text' => __('You receive a clear strategy, scope and expected timeline.', 'lawyer-theme')],
    ['number' => '04', 'title' => __('Representation', 'lawyer-theme'), 'text' => __('We implement the strategy and keep you informed throughout.', 'lawyer-theme')],
]);
?>

<main class="practice-page bg-surface-soft">
    <section class="practice-hero" style="background-image:url('<?php echo esc_url($hero_image); ?>')">
        <div class="practice-hero-overlay"></div>
        <div class="relative z-10 mx-auto flex min-h-[540px] max-w-7xl items-center px-6 py-20 lg:px-8">
            <div class="max-w-2xl text-white">
                <p class="home-kicker text-accent-light"><?php echo esc_html($practice_field('practice_hero_eyebrow', __('Practice Areas', 'lawyer-theme'))); ?></p>
                <h1 class="mt-5 text-5xl font-semibold leading-[1.06] md:text-7xl"><?php echo esc_html($practice_field('practice_hero_title', __('Focused legal guidance for life and business', 'lawyer-theme'))); ?></h1>
                <p class="mt-7 max-w-xl text-lg leading-8 text-neutral-300"><?php echo esc_html($practice_field('practice_hero_text', __('Strategic, practical support across the legal matters that affect your family, property and business.', 'lawyer-theme'))); ?></p>
            </div>
        </div>
    </section>

    <section class="home-section bg-white"><div class="mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8"><div><p class="home-kicker"><?php echo esc_html($practice_field('practice_intro_eyebrow', __('How we can help', 'lawyer-theme'))); ?></p><h2 class="home-title text-left"><?php echo esc_html($practice_field('practice_intro_title', __('Legal solutions shaped around your real priorities', 'lawyer-theme'))); ?></h2><div class="article-content mt-6"><?php echo wp_kses_post(wpautop($practice_field('practice_intro_text', __('Legal problems rarely exist in isolation. We look at the full picture, explain the available options and build a strategy designed to protect your long-term interests.', 'lawyer-theme')))); ?></div></div><img class="min-h-[440px] w-full object-cover" src="<?php echo esc_url($intro_image); ?>" alt="<?php echo esc_attr($practice_field('practice_intro_image_alt', __('Legal consultation', 'lawyer-theme'))); ?>"></div></section>

    <section class="border-y border-primary/10 bg-surface-soft"><div class="mx-auto grid max-w-7xl grid-cols-2 px-6 md:grid-cols-4 lg:px-8"><?php foreach ($stats as $stat) : ?><div class="border-primary/10 px-4 py-10 text-center md:border-r md:last:border-r-0"><p class="font-serif text-4xl text-accent"><?php echo esc_html($stat['value'] ?? ''); ?></p><p class="mt-2 text-sm text-neutral-600"><?php echo esc_html($stat['label'] ?? ''); ?></p></div><?php endforeach; ?></div></section>

    <section class="home-section bg-surface-soft"><div class="mx-auto max-w-7xl px-6 lg:px-8"><div class="mx-auto max-w-3xl text-center"><p class="home-kicker"><?php echo esc_html($practice_field('practice_areas_eyebrow', __('Our expertise', 'lawyer-theme'))); ?></p><h2 class="home-title"><?php echo esc_html($practice_field('practice_areas_title', __('Legal practice areas', 'lawyer-theme'))); ?></h2><p class="home-intro"><?php echo esc_html($practice_field('practice_areas_text', __('Comprehensive support with focused experience in each area.', 'lawyer-theme'))); ?></p></div>
        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3"><?php foreach ($areas as $index => $area) : $area_link = lawyer_theme_normalize_link($area['link'] ?? [], ['url' => home_url('/#contact'), 'title' => __('Discuss your matter', 'lawyer-theme'), 'target' => '_self']); ?><article class="home-card group relative overflow-hidden p-8"><span class="absolute right-6 top-4 font-serif text-6xl text-primary/5"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span><span class="text-3xl text-accent"><?php echo esc_html($area['icon'] ?? '◇'); ?></span><h3 class="mt-5 text-2xl font-semibold"><?php echo esc_html($area['title'] ?? ''); ?></h3><p class="mt-3 text-sm leading-6 text-neutral-600"><?php echo esc_html($area['text'] ?? ''); ?></p><?php $bullets = $practice_lines($area['bullets'] ?? ''); ?><?php if ($bullets) : ?><ul class="mt-5 space-y-2 border-t border-primary/10 pt-5 text-sm text-neutral-600"><?php foreach ($bullets as $bullet) : ?><li class="flex gap-2"><span class="text-accent">—</span><span><?php echo esc_html($bullet); ?></span></li><?php endforeach; ?></ul><?php endif; ?><a class="mt-6 inline-flex text-sm font-semibold text-accent" href="<?php echo esc_url($area_link['url']); ?>" target="<?php echo esc_attr($area_link['target']); ?>"><?php echo esc_html($area_link['title']); ?> →</a></article><?php endforeach; ?></div>
    </div></section>

    <section class="home-section bg-primary text-white"><div class="mx-auto grid max-w-7xl items-start gap-12 px-6 lg:grid-cols-[0.8fr_1.2fr] lg:px-8"><div><p class="home-kicker text-accent-light"><?php echo esc_html($practice_field('practice_support_eyebrow', __('Our commitment', 'lawyer-theme'))); ?></p><h2 class="home-title text-left text-white"><?php echo esc_html($practice_field('practice_support_title', __('More than legal answers', 'lawyer-theme'))); ?></h2><p class="mt-5 leading-7 text-neutral-300"><?php echo esc_html($practice_field('practice_support_text', __('You receive a clear strategy, direct communication and representation focused on the outcome that matters to you.', 'lawyer-theme'))); ?></p></div><div class="space-y-5"><?php foreach ($support_points as $point) : ?><article class="grid gap-5 border border-white/15 p-6 sm:grid-cols-[56px_1fr]"><span class="font-serif text-3xl text-accent"><?php echo esc_html($point['number'] ?? ''); ?></span><div><h3 class="text-xl font-semibold"><?php echo esc_html($point['title'] ?? ''); ?></h3><p class="mt-2 text-sm leading-6 text-neutral-300"><?php echo esc_html($point['text'] ?? ''); ?></p></div></article><?php endforeach; ?></div></div></section>

    <section class="home-section bg-white"><div class="mx-auto max-w-7xl px-6 lg:px-8"><div class="text-center"><p class="home-kicker"><?php echo esc_html($practice_field('practice_steps_eyebrow', __('What happens next', 'lawyer-theme'))); ?></p><h2 class="home-title"><?php echo esc_html($practice_field('practice_steps_title', __('A clear process from the first conversation', 'lawyer-theme'))); ?></h2></div><div class="mt-14 grid gap-10 md:grid-cols-2 lg:grid-cols-4"><?php foreach ($steps as $step) : ?><article class="relative border-t border-primary/15 pt-8 text-center"><span class="absolute -top-5 left-1/2 flex size-10 -translate-x-1/2 items-center justify-center rounded-full bg-accent text-xs font-semibold text-white"><?php echo esc_html($step['number'] ?? ''); ?></span><h3 class="text-xl font-semibold"><?php echo esc_html($step['title'] ?? ''); ?></h3><p class="mt-3 text-sm leading-6 text-neutral-600"><?php echo esc_html($step['text'] ?? ''); ?></p></article><?php endforeach; ?></div></div></section>

    <section class="border-b border-white/10 bg-primary py-14 text-white"><div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-8 px-6 md:flex-row md:items-center lg:px-8"><div><p class="home-kicker text-accent-light"><?php echo esc_html($practice_field('practice_cta_eyebrow', __('Need legal guidance?', 'lawyer-theme'))); ?></p><h2 class="mt-3 text-3xl font-semibold md:text-4xl"><?php echo esc_html($practice_field('practice_cta_title', __('Let’s identify the right legal strategy', 'lawyer-theme'))); ?></h2><p class="mt-3 max-w-2xl text-neutral-300"><?php echo esc_html($practice_field('practice_cta_text', __('Tell us about your situation and receive a clear assessment of the next steps.', 'lawyer-theme'))); ?></p></div><a class="home-button home-button--gold shrink-0" href="<?php echo esc_url($cta_link['url']); ?>" target="<?php echo esc_attr($cta_link['target']); ?>"><?php echo esc_html($cta_link['title']); ?></a></div></section>
</main>

<?php get_footer(); ?>
