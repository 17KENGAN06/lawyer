<?php
/* Template Name: About Page */
get_header();

$page_id = get_the_ID();
$about_field = static function ($name, $default = '') use ($page_id) {
    if (!function_exists('get_field')) {
        return $default;
    }
    $value = get_field($name, $page_id);
    return ($value !== null && $value !== false && $value !== '') ? $value : $default;
};
$about_image_url = static function ($value, $fallback = '') {
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

$hero_image = $about_image_url($about_field('about_hero_image'), get_template_directory_uri() . '/assets/images/home-hero.png');
$portrait_image = $about_image_url($about_field('about_portrait_image'), get_template_directory_uri() . '/assets/images/home-about.png');
$approach_image = $about_image_url($about_field('about_approach_image'), get_template_directory_uri() . '/assets/images/blog-hero.png');
$cta_link = lawyer_theme_normalize_link(
    $about_field('about_cta_link'),
    ['url' => home_url('/#contact'), 'title' => __('Schedule a consultation', 'lawyer-theme'), 'target' => '_self']
);

$stats = $about_field('about_stats', [
    ['value' => '15+', 'label' => __('Years of legal practice', 'lawyer-theme')],
    ['value' => '500+', 'label' => __('Matters successfully handled', 'lawyer-theme')],
    ['value' => '92%', 'label' => __('Favorable outcomes', 'lawyer-theme')],
    ['value' => '24/7', 'label' => __('Support in urgent matters', 'lawyer-theme')],
]);
$values = $about_field('about_values', [
    ['icon' => '◇', 'title' => __('Integrity', 'lawyer-theme'), 'text' => __('Honest advice and a realistic assessment of every legal situation.', 'lawyer-theme')],
    ['icon' => '▢', 'title' => __('Confidentiality', 'lawyer-theme'), 'text' => __('Careful protection of personal information and client interests.', 'lawyer-theme')],
    ['icon' => '◎', 'title' => __('Personal attention', 'lawyer-theme'), 'text' => __('Direct communication and a strategy tailored to your circumstances.', 'lawyer-theme')],
    ['icon' => '☆', 'title' => __('Results', 'lawyer-theme'), 'text' => __('Practical solutions focused on meaningful and measurable outcomes.', 'lawyer-theme')],
]);
$experience = $about_field('about_experience', [
    ['period' => __('2011–2015', 'lawyer-theme'), 'title' => __('Foundation of legal practice', 'lawyer-theme'), 'place' => __('Civil and family law', 'lawyer-theme'), 'text' => __('Built broad litigation experience and developed a disciplined approach to complex cases.', 'lawyer-theme')],
    ['period' => __('2015–2020', 'lawyer-theme'), 'title' => __('Senior legal counsel', 'lawyer-theme'), 'place' => __('Private practice', 'lawyer-theme'), 'text' => __('Led negotiations, court matters and strategic legal projects for private and business clients.', 'lawyer-theme')],
    ['period' => __('2020–Present', 'lawyer-theme'), 'title' => __('Independent attorney', 'lawyer-theme'), 'place' => __('Client-focused representation', 'lawyer-theme'), 'text' => __('Provides personal legal guidance with an emphasis on clarity, trust and sustainable results.', 'lawyer-theme')],
]);
$credentials = $about_field('about_credentials', [
    ['year' => '2011', 'title' => __('Law degree', 'lawyer-theme'), 'organization' => __('Faculty of Law', 'lawyer-theme')],
    ['year' => '2016', 'title' => __('Advanced civil litigation', 'lawyer-theme'), 'organization' => __('Professional legal programme', 'lawyer-theme')],
    ['year' => '2022', 'title' => __('Negotiation and mediation', 'lawyer-theme'), 'organization' => __('Continuing legal education', 'lawyer-theme')],
]);
$approach_points = $about_field('about_approach_points', [
    ['title' => __('Listen first', 'lawyer-theme'), 'text' => __('Every engagement begins with a careful understanding of your goals and concerns.', 'lawyer-theme')],
    ['title' => __('Explain clearly', 'lawyer-theme'), 'text' => __('Complex legal issues are translated into understandable choices and consequences.', 'lawyer-theme')],
    ['title' => __('Act strategically', 'lawyer-theme'), 'text' => __('Each step supports an agreed plan and the strongest practical outcome.', 'lawyer-theme')],
]);
?>

<main class="about-page bg-surface-soft">
    <section class="about-hero" style="background-image:url('<?php echo esc_url($hero_image); ?>')">
        <div class="about-hero-overlay"></div>
        <div class="relative z-10 mx-auto flex min-h-[560px] max-w-7xl items-center px-6 py-20 lg:px-8">
            <div class="max-w-2xl text-white">
                <p class="home-kicker text-accent-light"><?php echo esc_html($about_field('about_hero_eyebrow', __('About', 'lawyer-theme'))); ?></p>
                <h1 class="mt-5 text-5xl font-semibold leading-[1.06] md:text-7xl"><?php echo esc_html($about_field('about_hero_title', __('Experience, integrity and personal commitment', 'lawyer-theme'))); ?></h1>
                <p class="mt-7 max-w-xl text-lg leading-8 text-neutral-300"><?php echo esc_html($about_field('about_hero_text', __('Legal representation built around careful preparation, clear communication and respect for every client.', 'lawyer-theme'))); ?></p>
            </div>
        </div>
    </section>

    <section class="home-section bg-white"><div class="mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
        <div class="overflow-hidden"><img class="min-h-[560px] w-full object-cover" src="<?php echo esc_url($portrait_image); ?>" alt="<?php echo esc_attr($about_field('about_portrait_alt', __('Attorney portrait', 'lawyer-theme'))); ?>"></div>
        <div><p class="home-kicker"><?php echo esc_html($about_field('about_intro_eyebrow', __('My story', 'lawyer-theme'))); ?></p><h2 class="home-title text-left"><?php echo esc_html($about_field('about_intro_title', __('A thoughtful approach to difficult legal decisions', 'lawyer-theme'))); ?></h2><div class="article-content mt-6"><?php echo wp_kses_post(wpautop($about_field('about_intro_text', __('I help individuals, families and businesses resolve complex legal issues with confidence. Every matter receives direct attention, careful analysis and a strategy built around the client’s real priorities.', 'lawyer-theme')))); ?></div>
        <?php $quote = $about_field('about_intro_quote', __('The strongest legal strategy begins with listening carefully and explaining every option clearly.', 'lawyer-theme')); ?><?php if ($quote) : ?><blockquote class="mt-8 border-l-4 border-accent bg-surface-soft p-6 font-serif text-2xl leading-relaxed"><?php echo esc_html($quote); ?></blockquote><?php endif; ?></div>
    </div></section>

    <section class="border-y border-primary/10 bg-surface-soft"><div class="mx-auto grid max-w-7xl grid-cols-2 px-6 md:grid-cols-4 lg:px-8"><?php foreach ($stats as $stat) : ?><div class="border-primary/10 px-4 py-10 text-center md:border-r md:last:border-r-0"><p class="font-serif text-4xl text-accent"><?php echo esc_html($stat['value'] ?? ''); ?></p><p class="mt-2 text-sm text-neutral-600"><?php echo esc_html($stat['label'] ?? ''); ?></p></div><?php endforeach; ?></div></section>

    <section class="home-section bg-primary text-white"><div class="mx-auto max-w-7xl px-6 lg:px-8"><div class="text-center"><p class="home-kicker text-accent-light"><?php echo esc_html($about_field('about_values_eyebrow', __('Professional principles', 'lawyer-theme'))); ?></p><h2 class="home-title text-white"><?php echo esc_html($about_field('about_values_title', __('Values that guide every matter', 'lawyer-theme'))); ?></h2></div><div class="mt-12 grid gap-4 md:grid-cols-2 lg:grid-cols-4"><?php foreach ($values as $value) : ?><article class="border border-white/15 p-7 text-center"><span class="text-3xl text-accent"><?php echo esc_html($value['icon'] ?? '◇'); ?></span><h3 class="mt-4 text-xl font-semibold"><?php echo esc_html($value['title'] ?? ''); ?></h3><p class="mt-3 text-sm leading-6 text-neutral-300"><?php echo esc_html($value['text'] ?? ''); ?></p></article><?php endforeach; ?></div></div></section>

    <section class="home-section bg-white"><div class="mx-auto max-w-5xl px-6 lg:px-8"><div class="text-center"><p class="home-kicker"><?php echo esc_html($about_field('about_experience_eyebrow', __('Experience', 'lawyer-theme'))); ?></p><h2 class="home-title"><?php echo esc_html($about_field('about_experience_title', __('Professional journey', 'lawyer-theme'))); ?></h2></div><div class="mt-14 space-y-8"><?php foreach ($experience as $item) : ?><article class="grid gap-5 border-l-2 border-accent pl-7 md:grid-cols-[160px_1fr]"><p class="font-serif text-2xl text-accent"><?php echo esc_html($item['period'] ?? ''); ?></p><div><h3 class="text-2xl font-semibold"><?php echo esc_html($item['title'] ?? ''); ?></h3><p class="mt-1 text-sm font-semibold uppercase tracking-wider text-accent"><?php echo esc_html($item['place'] ?? ''); ?></p><p class="mt-3 leading-7 text-neutral-600"><?php echo esc_html($item['text'] ?? ''); ?></p></div></article><?php endforeach; ?></div></div></section>

    <section class="home-section bg-surface-soft"><div class="mx-auto max-w-7xl px-6 lg:px-8"><div class="text-center"><p class="home-kicker"><?php echo esc_html($about_field('about_credentials_eyebrow', __('Qualifications', 'lawyer-theme'))); ?></p><h2 class="home-title"><?php echo esc_html($about_field('about_credentials_title', __('Education and professional development', 'lawyer-theme'))); ?></h2></div><div class="mt-12 grid gap-6 md:grid-cols-3"><?php foreach ($credentials as $item) : ?><article class="home-card p-7"><p class="font-serif text-4xl text-accent"><?php echo esc_html($item['year'] ?? ''); ?></p><h3 class="mt-5 text-2xl font-semibold"><?php echo esc_html($item['title'] ?? ''); ?></h3><p class="mt-3 text-sm leading-6 text-neutral-600"><?php echo esc_html($item['organization'] ?? ''); ?></p></article><?php endforeach; ?></div></div></section>

    <section class="home-section bg-white"><div class="mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-2 lg:px-8"><div><p class="home-kicker"><?php echo esc_html($about_field('about_approach_eyebrow', __('My approach', 'lawyer-theme'))); ?></p><h2 class="home-title text-left"><?php echo esc_html($about_field('about_approach_title', __('Clear advice. Deliberate action.', 'lawyer-theme'))); ?></h2><p class="mt-5 leading-7 text-neutral-600"><?php echo esc_html($about_field('about_approach_text', __('Good representation is not only about knowing the law. It is about understanding the client, anticipating risks and communicating with complete clarity.', 'lawyer-theme'))); ?></p><div class="mt-8 space-y-6"><?php foreach ($approach_points as $index => $item) : ?><div class="grid grid-cols-[44px_1fr] gap-4"><span class="flex size-11 items-center justify-center rounded-full bg-accent text-sm font-semibold text-white"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span><div><h3 class="text-xl font-semibold"><?php echo esc_html($item['title'] ?? ''); ?></h3><p class="mt-2 text-sm leading-6 text-neutral-600"><?php echo esc_html($item['text'] ?? ''); ?></p></div></div><?php endforeach; ?></div></div><img class="min-h-[520px] w-full object-cover" src="<?php echo esc_url($approach_image); ?>" alt=""></div></section>

    <section class="border-b border-white/10 bg-primary py-14 text-white"><div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-8 px-6 md:flex-row md:items-center lg:px-8"><div><p class="home-kicker text-accent-light"><?php echo esc_html($about_field('about_cta_eyebrow', __('Ready to talk?', 'lawyer-theme'))); ?></p><h2 class="mt-3 text-3xl font-semibold md:text-4xl"><?php echo esc_html($about_field('about_cta_title', __('Let’s discuss your legal matter', 'lawyer-theme'))); ?></h2><p class="mt-3 max-w-2xl text-neutral-300"><?php echo esc_html($about_field('about_cta_text', __('Contact us for a confidential conversation and a clear assessment of your next steps.', 'lawyer-theme'))); ?></p></div><a class="home-button home-button--gold shrink-0" href="<?php echo esc_url($cta_link['url']); ?>" target="<?php echo esc_attr($cta_link['target']); ?>"><?php echo esc_html($cta_link['title']); ?></a></div></section>
</main>

<?php get_footer(); ?>
