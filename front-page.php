<?php
get_header();

$page_id = get_queried_object_id();
$get = static function ($name, $default = '') use ($page_id) {
    if (!function_exists('get_field')) {
        return $default;
    }
    $value = get_field($name, $page_id);
    return ($value !== null && $value !== false && $value !== '') ? $value : $default;
};
$img = static function ($value, $fallback = '') {
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
$link = static function ($value, $url, $title) {
    return lawyer_theme_normalize_link($value, ['url' => $url, 'title' => $title, 'target' => '_self']);
};

$hero_image = $img($get('home_hero_image'), get_template_directory_uri() . '/assets/images/home-hero.png');
$about_image = $img($get('home_about_image'), get_template_directory_uri() . '/assets/images/home-about.png');
$hero_primary = $link($get('home_hero_primary_link'), '#contact', __('Schedule a Consultation', 'lawyer-theme'));
$hero_secondary = $link($get('home_hero_secondary_link'), '#practice-areas', __('Our Services', 'lawyer-theme'));
$about_link = $link($get('home_about_link'), home_url('/about/'), __('More About the Attorney', 'lawyer-theme'));
$bottom_link = $link($get('home_bottom_cta_link'), '#contact', __('Schedule a Consultation', 'lawyer-theme'));

$stats = $get('home_stats', [
    ['value' => '15+', 'label' => __('Years of experience', 'lawyer-theme')],
    ['value' => '500+', 'label' => __('Successful cases', 'lawyer-theme')],
    ['value' => '92%', 'label' => __('Favorable outcomes', 'lawyer-theme')],
    ['value' => '24/7', 'label' => __('Client availability', 'lawyer-theme')],
]);
$services = $get('home_services', [
    ['icon' => '§', 'title' => __('Inheritance Law', 'lawyer-theme'), 'text' => __('Estate planning, probate and inheritance disputes.', 'lawyer-theme'), 'link' => []],
    ['icon' => '◇', 'title' => __('Family Law', 'lawyer-theme'), 'text' => __('Divorce, custody, support and family agreements.', 'lawyer-theme'), 'link' => []],
    ['icon' => '▤', 'title' => __('Contracts & Transactions', 'lawyer-theme'), 'text' => __('Drafting, review and support for complex agreements.', 'lawyer-theme'), 'link' => []],
    ['icon' => '⌂', 'title' => __('Court Representation', 'lawyer-theme'), 'text' => __('Confident advocacy in civil and commercial disputes.', 'lawyer-theme'), 'link' => []],
    ['icon' => '▥', 'title' => __('Real Estate', 'lawyer-theme'), 'text' => __('Legal review of property and real-estate transactions.', 'lawyer-theme'), 'link' => []],
    ['icon' => '▣', 'title' => __('Business Counsel', 'lawyer-theme'), 'text' => __('Practical legal support for companies and entrepreneurs.', 'lawyer-theme'), 'link' => []],
]);
$about_features = $get('home_about_features', [
    ['icon' => '✧', 'title' => __('Experience and specialization', 'lawyer-theme'), 'text' => __('Focused expertise and careful attention to every detail.', 'lawyer-theme')],
    ['icon' => '♙', 'title' => __('Individual approach', 'lawyer-theme'), 'text' => __('A strategy shaped around your goals and circumstances.', 'lawyer-theme')],
    ['icon' => '◇', 'title' => __('My values', 'lawyer-theme'), 'text' => __('Honesty, confidentiality and responsibility in every matter.', 'lawyer-theme')],
]);
$advantages = $get('home_advantages', [
    ['icon' => '◎', 'title' => __('Individual approach', 'lawyer-theme'), 'text' => __('Personal attention and a tailored legal strategy.', 'lawyer-theme')],
    ['icon' => '▢', 'title' => __('Confidentiality', 'lawyer-theme'), 'text' => __('Your information and interests remain protected.', 'lawyer-theme')],
    ['icon' => '▤', 'title' => __('Transparency', 'lawyer-theme'), 'text' => __('Clear terms, expectations and regular updates.', 'lawyer-theme')],
    ['icon' => '☆', 'title' => __('Practical experience', 'lawyer-theme'), 'text' => __('Advice grounded in real cases and measurable results.', 'lawyer-theme')],
]);
$steps = $get('home_steps', [
    ['number' => '01', 'title' => __('Consultation', 'lawyer-theme'), 'text' => __('We discuss your situation and priorities.', 'lawyer-theme')],
    ['number' => '02', 'title' => __('Case analysis', 'lawyer-theme'), 'text' => __('We review documents, risks and options.', 'lawyer-theme')],
    ['number' => '03', 'title' => __('Strategy', 'lawyer-theme'), 'text' => __('We agree on a clear plan and timeline.', 'lawyer-theme')],
    ['number' => '04', 'title' => __('Representation', 'lawyer-theme'), 'text' => __('We implement the strategy and report progress.', 'lawyer-theme')],
]);
$cases = $get('home_cases', [
    ['image' => 0, 'category' => __('Family Law', 'lawyer-theme'), 'title' => __('Fair resolution of a family dispute', 'lawyer-theme'), 'text' => __('A negotiated outcome that protected the client’s priorities.', 'lawyer-theme'), 'link' => []],
    ['image' => 0, 'category' => __('Inheritance Law', 'lawyer-theme'), 'title' => __('Contested inheritance resolved', 'lawyer-theme'), 'text' => __('Evidence and careful negotiation restored the client’s rights.', 'lawyer-theme'), 'link' => []],
    ['image' => 0, 'category' => __('Real Estate', 'lawyer-theme'), 'title' => __('Secure property transaction', 'lawyer-theme'), 'text' => __('Comprehensive due diligence reduced risk before closing.', 'lawyer-theme'), 'link' => []],
]);
$testimonials = $get('home_testimonials', [
    ['quote' => __('A calm, precise and highly professional approach. I always understood what would happen next.', 'lawyer-theme'), 'name' => __('Catherine S.', 'lawyer-theme'), 'location' => __('Moscow', 'lawyer-theme')],
    ['quote' => __('Every question was answered clearly, and the result exceeded my expectations.', 'lawyer-theme'), 'name' => __('Alex P.', 'lawyer-theme'), 'location' => __('Moscow', 'lawyer-theme')],
    ['quote' => __('Thoughtful guidance and strong representation from start to finish.', 'lawyer-theme'), 'name' => __('Maria K.', 'lawyer-theme'), 'location' => __('Saint Petersburg', 'lawyer-theme')],
]);
$faqs = $get('home_faqs', [
    ['question' => __('How much does a consultation cost?', 'lawyer-theme'), 'answer' => __('The fee depends on the subject and complexity. Contact us for a clear estimate.', 'lawyer-theme')],
    ['question' => __('How do I know whether my case has a strong chance?', 'lawyer-theme'), 'answer' => __('We assess the documents, facts, risks and available remedies during the initial review.', 'lawyer-theme')],
    ['question' => __('How long can a case take?', 'lawyer-theme'), 'answer' => __('Timing depends on complexity, the court schedule and whether an agreement can be reached.', 'lawyer-theme')],
    ['question' => __('Which documents should I prepare?', 'lawyer-theme'), 'answer' => __('Bring all contracts, correspondence and decisions related to the matter.', 'lawyer-theme')],
    ['question' => __('Can the matter be resolved without court?', 'lawyer-theme'), 'answer' => __('Whenever appropriate, we explore negotiation and settlement before litigation.', 'lawyer-theme')],
]);
$articles = $get('home_articles', [
    ['image' => 0, 'category' => __('Inheritance Law', 'lawyer-theme'), 'date' => __('10 May 2026', 'lawyer-theme'), 'title' => __('How to challenge a will: a practical guide', 'lawyer-theme'), 'link' => []],
    ['image' => 0, 'category' => __('Family Law', 'lawyer-theme'), 'date' => __('2 May 2026', 'lawyer-theme'), 'title' => __('Division of marital property: what to know', 'lawyer-theme'), 'link' => []],
    ['image' => 0, 'category' => __('Real Estate', 'lawyer-theme'), 'date' => __('24 April 2026', 'lawyer-theme'), 'title' => __('Seven checks before buying an apartment', 'lawyer-theme'), 'link' => []],
]);
?>

<main class="home-page">
    <section class="home-hero" style="background-image:url('<?php echo esc_url($hero_image); ?>')">
        <div class="home-hero-overlay"></div>
        <div class="relative z-10 mx-auto flex min-h-[720px] max-w-7xl items-center px-6 pb-20 pt-40 lg:px-8">
            <div class="max-w-2xl text-white">
                <p class="home-kicker text-accent-light"><?php echo esc_html($get('home_hero_eyebrow', __('Legal guidance you can trust', 'lawyer-theme'))); ?></p>
                <h1 class="mt-5 text-5xl font-semibold leading-[1.06] md:text-7xl"><?php echo esc_html($get('home_hero_title', __('Legal help built on experience and trust', 'lawyer-theme'))); ?></h1>
                <p class="mt-7 max-w-xl text-lg leading-8 text-neutral-300"><?php echo esc_html($get('home_hero_text', __('We protect your rights and interests in complex legal matters with clarity, strategy and personal attention.', 'lawyer-theme'))); ?></p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a class="home-button home-button--gold" href="<?php echo esc_url($hero_primary['url']); ?>" target="<?php echo esc_attr($hero_primary['target']); ?>"><?php echo esc_html($hero_primary['title']); ?></a>
                    <a class="home-button home-button--outline" href="<?php echo esc_url($hero_secondary['url']); ?>" target="<?php echo esc_attr($hero_secondary['target']); ?>"><?php echo esc_html($hero_secondary['title']); ?></a>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-primary/10 bg-white"><div class="mx-auto grid max-w-7xl grid-cols-2 px-6 md:grid-cols-4 lg:px-8">
        <?php foreach ($stats as $stat) : ?><div class="border-primary/10 px-4 py-9 text-center md:border-r md:last:border-r-0"><p class="font-serif text-4xl text-accent"><?php echo esc_html($stat['value'] ?? ''); ?></p><p class="mt-2 text-sm text-neutral-600"><?php echo esc_html($stat['label'] ?? ''); ?></p></div><?php endforeach; ?>
    </div></section>

    <section id="practice-areas" class="home-section bg-surface-soft"><div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center"><p class="home-kicker"><?php echo esc_html($get('home_services_eyebrow', __('Our expertise', 'lawyer-theme'))); ?></p><h2 class="home-title"><?php echo esc_html($get('home_services_title', __('Core Legal Services', 'lawyer-theme'))); ?></h2><p class="home-intro"><?php echo esc_html($get('home_services_text', __('Practical legal solutions designed around your goals, risks and circumstances.', 'lawyer-theme'))); ?></p></div>
        <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3"><?php foreach ($services as $index => $service) : $service_link = $link($service['link'] ?? [], '#contact', __('Learn more', 'lawyer-theme')); ?><article class="home-card group relative overflow-hidden p-7"><span class="absolute right-6 top-4 font-serif text-6xl text-primary/5"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span><span class="text-2xl text-accent"><?php echo esc_html($service['icon'] ?? '◇'); ?></span><h3 class="mt-5 text-2xl font-semibold"><?php echo esc_html($service['title'] ?? ''); ?></h3><p class="mt-3 min-h-14 text-sm leading-6 text-neutral-600"><?php echo esc_html($service['text'] ?? ''); ?></p><a class="mt-5 inline-flex text-sm font-semibold hover:text-accent" href="<?php echo esc_url($service_link['url']); ?>"><?php echo esc_html($service_link['title']); ?> →</a></article><?php endforeach; ?></div>
    </div></section>

    <section id="about" class="home-section bg-white"><div class="mx-auto grid max-w-7xl items-stretch gap-12 px-6 lg:grid-cols-2 lg:px-8">
        <div class="min-h-[520px] overflow-hidden"><img class="h-full w-full object-cover" src="<?php echo esc_url($about_image); ?>" alt="<?php echo esc_attr($get('home_about_image_alt', __('Attorney portrait', 'lawyer-theme'))); ?>"></div>
        <div class="flex flex-col justify-center"><p class="home-kicker"><?php echo esc_html($get('home_about_eyebrow', __('About the attorney', 'lawyer-theme'))); ?></p><h2 class="home-title text-left"><?php echo esc_html($get('home_about_title', __('An advocate clients can trust', 'lawyer-theme'))); ?></h2><p class="mt-5 leading-7 text-neutral-600"><?php echo esc_html($get('home_about_text', __('For more than 15 years, I have helped clients navigate difficult decisions and protect what matters most.', 'lawyer-theme'))); ?></p>
        <div class="mt-7 space-y-5"><?php foreach ($about_features as $feature) : ?><div class="flex gap-4"><span class="mt-1 text-xl text-accent"><?php echo esc_html($feature['icon'] ?? '◇'); ?></span><div><h3 class="text-lg font-semibold"><?php echo esc_html($feature['title'] ?? ''); ?></h3><p class="mt-1 text-sm leading-6 text-neutral-600"><?php echo esc_html($feature['text'] ?? ''); ?></p></div></div><?php endforeach; ?></div>
        <a class="home-button home-button--gold mt-8 self-start" href="<?php echo esc_url($about_link['url']); ?>"><?php echo esc_html($about_link['title']); ?></a></div>
    </div></section>

    <section class="home-section bg-primary text-white"><div class="mx-auto max-w-7xl px-6 lg:px-8"><div class="text-center"><p class="home-kicker text-accent-light"><?php echo esc_html($get('home_advantages_eyebrow', __('Why clients choose us', 'lawyer-theme'))); ?></p><h2 class="home-title text-white"><?php echo esc_html($get('home_advantages_title', __('Your interests are our priority', 'lawyer-theme'))); ?></h2></div><div class="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-4"><?php foreach ($advantages as $item) : ?><article class="border border-white/15 p-7 text-center"><span class="text-3xl text-accent"><?php echo esc_html($item['icon'] ?? '◇'); ?></span><h3 class="mt-4 text-xl font-semibold"><?php echo esc_html($item['title'] ?? ''); ?></h3><p class="mt-3 text-sm leading-6 text-neutral-300"><?php echo esc_html($item['text'] ?? ''); ?></p></article><?php endforeach; ?></div></div></section>

    <section class="home-section bg-white"><div class="mx-auto max-w-7xl px-6 lg:px-8"><div class="text-center"><p class="home-kicker"><?php echo esc_html($get('home_steps_eyebrow', __('How we work', 'lawyer-theme'))); ?></p><h2 class="home-title"><?php echo esc_html($get('home_steps_title', __('The path to a clear result', 'lawyer-theme'))); ?></h2></div><div class="mt-12 grid gap-10 md:grid-cols-2 lg:grid-cols-4"><?php foreach ($steps as $step) : ?><article class="relative border-t border-primary/15 pt-8 text-center"><span class="absolute -top-5 left-1/2 flex size-10 -translate-x-1/2 items-center justify-center rounded-full bg-accent text-xs font-semibold text-white"><?php echo esc_html($step['number'] ?? ''); ?></span><h3 class="text-xl font-semibold"><?php echo esc_html($step['title'] ?? ''); ?></h3><p class="mt-3 text-sm leading-6 text-neutral-600"><?php echo esc_html($step['text'] ?? ''); ?></p></article><?php endforeach; ?></div></div></section>

    <section id="cases" class="home-section bg-surface-soft"><div class="mx-auto max-w-7xl px-6 lg:px-8"><div class="text-center"><p class="home-kicker"><?php echo esc_html($get('home_cases_eyebrow', __('Cases and results', 'lawyer-theme'))); ?></p><h2 class="home-title"><?php echo esc_html($get('home_cases_title', __('Real matters. Meaningful outcomes.', 'lawyer-theme'))); ?></h2></div><div class="mt-12 grid gap-6 lg:grid-cols-3"><?php foreach ($cases as $case) : $case_link = $link($case['link'] ?? [], '#contact', __('View case', 'lawyer-theme')); ?><article class="home-card overflow-hidden"><img class="h-52 w-full object-cover" src="<?php echo esc_url($img($case['image'] ?? 0, $hero_image)); ?>" alt=""><div class="p-7"><p class="home-kicker text-xs"><?php echo esc_html($case['category'] ?? ''); ?></p><h3 class="mt-3 text-2xl font-semibold"><?php echo esc_html($case['title'] ?? ''); ?></h3><p class="mt-3 text-sm leading-6 text-neutral-600"><?php echo esc_html($case['text'] ?? ''); ?></p><a class="mt-5 inline-flex text-sm font-semibold hover:text-accent" href="<?php echo esc_url($case_link['url']); ?>"><?php echo esc_html($case_link['title']); ?> →</a></div></article><?php endforeach; ?></div></div></section>

    <section class="home-section bg-white"><div class="mx-auto max-w-7xl px-6 lg:px-8"><div class="text-center"><p class="home-kicker"><?php echo esc_html($get('home_testimonials_eyebrow', __('Client feedback', 'lawyer-theme'))); ?></p><h2 class="home-title"><?php echo esc_html($get('home_testimonials_title', __('What clients say', 'lawyer-theme'))); ?></h2></div><div class="mt-12 grid gap-6 lg:grid-cols-3"><?php foreach ($testimonials as $item) : ?><blockquote class="home-card p-7"><span class="font-serif text-5xl text-accent">“</span><p class="mt-2 leading-7 text-neutral-600"><?php echo esc_html($item['quote'] ?? ''); ?></p><div class="mt-6"><cite class="not-italic font-semibold"><?php echo esc_html($item['name'] ?? ''); ?></cite><p class="mt-1 text-xs text-neutral-600"><?php echo esc_html($item['location'] ?? ''); ?></p></div></blockquote><?php endforeach; ?></div></div></section>

    <section id="faq" class="home-section bg-surface-soft"><div class="mx-auto max-w-5xl px-6 lg:px-8"><div class="text-center"><p class="home-kicker"><?php echo esc_html($get('home_faq_eyebrow', __('FAQ', 'lawyer-theme'))); ?></p><h2 class="home-title"><?php echo esc_html($get('home_faq_title', __('Frequently asked questions', 'lawyer-theme'))); ?></h2></div><div class="mt-10 border border-primary/10 bg-white"><?php foreach ($faqs as $faq) : ?><details class="group border-b border-primary/10 p-5 last:border-b-0"><summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold"><?php echo esc_html($faq['question'] ?? ''); ?><span class="text-xl text-accent group-open:rotate-45">+</span></summary><p class="mt-4 text-sm leading-6 text-neutral-600"><?php echo esc_html($faq['answer'] ?? ''); ?></p></details><?php endforeach; ?></div></div></section>

    <section id="latest-articles" class="home-section bg-white"><div class="mx-auto max-w-7xl px-6 lg:px-8"><div class="text-center"><p class="home-kicker"><?php echo esc_html($get('home_articles_eyebrow', __('Latest insights', 'lawyer-theme'))); ?></p><h2 class="home-title"><?php echo esc_html($get('home_articles_title', __('Useful articles', 'lawyer-theme'))); ?></h2></div><div class="mt-12 grid gap-6 lg:grid-cols-3"><?php foreach ($articles as $article) : $article_link = $link($article['link'] ?? [], '#', __('Read article', 'lawyer-theme')); ?><article class="home-card overflow-hidden"><img class="h-48 w-full object-cover" src="<?php echo esc_url($img($article['image'] ?? 0, $about_image)); ?>" alt=""><div class="p-6"><div class="flex justify-between gap-3 text-xs text-neutral-600"><span class="font-semibold uppercase tracking-wider text-accent"><?php echo esc_html($article['category'] ?? ''); ?></span><time><?php echo esc_html($article['date'] ?? ''); ?></time></div><h3 class="mt-4 text-xl font-semibold"><?php echo esc_html($article['title'] ?? ''); ?></h3><a class="mt-5 inline-flex text-sm font-semibold hover:text-accent" href="<?php echo esc_url($article_link['url']); ?>"><?php echo esc_html($article_link['title']); ?> →</a></div></article><?php endforeach; ?></div></div></section>

    <section class="border-b border-white/10 bg-primary py-12 text-white"><div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-8 px-6 md:flex-row md:items-center lg:px-8"><div><p class="home-kicker text-accent-light"><?php echo esc_html($get('home_bottom_cta_eyebrow', __('Need legal guidance?', 'lawyer-theme'))); ?></p><h2 class="mt-3 text-3xl font-semibold md:text-4xl"><?php echo esc_html($get('home_bottom_cta_title', __('Let’s discuss your situation', 'lawyer-theme'))); ?></h2><p class="mt-3 max-w-2xl text-neutral-300"><?php echo esc_html($get('home_bottom_cta_text', __('Leave a request and we will contact you to arrange a confidential consultation.', 'lawyer-theme'))); ?></p></div><a class="home-button home-button--gold shrink-0" href="<?php echo esc_url($bottom_link['url']); ?>"><?php echo esc_html($bottom_link['title']); ?></a></div></section>
</main>

<?php get_footer(); ?>
