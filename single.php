<?php
get_header();

$post_id = get_the_ID();
$article_field = static function ($name, $default = '') use ($post_id) {
    if (!function_exists('get_field')) {
        return $default;
    }

    $value = get_field($name, $post_id);

    return ($value !== null && $value !== false && $value !== '') ? $value : $default;
};
$article_image_url = static function ($value, $fallback = '') {
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

$blog_page_id = (int) get_option('page_for_posts');
$blog_url = $blog_page_id ? get_permalink($blog_page_id) : home_url('/blog/');
$categories = get_the_category();
$primary_category = !empty($categories) ? $categories[0] : null;
$default_hero = get_the_post_thumbnail_url($post_id, 'full') ?: get_template_directory_uri() . '/assets/images/blog-hero.png';
$hero_image = $article_image_url($article_field('article_hero_image'), $default_hero);
$sidebar_link = lawyer_theme_normalize_link(
    $article_field('article_sidebar_link'),
    ['url' => home_url('/#contact'), 'title' => __('Request a consultation', 'lawyer-theme'), 'target' => '_self']
);
$bottom_link = lawyer_theme_normalize_link(
    $article_field('article_bottom_cta_link'),
    ['url' => home_url('/#contact'), 'title' => __('Schedule a consultation', 'lawyer-theme'), 'target' => '_self']
);
$author_image = $article_image_url(
    $article_field('article_author_image'),
    get_avatar_url((int) get_the_author_meta('ID'), ['size' => 240])
);
$author_name = $article_field('article_author_name', get_the_author());
$author_role = $article_field('article_author_role', __('Attorney at Law', 'lawyer-theme'));
$author_bio = $article_field('article_author_bio', get_the_author_meta('description'));

$related_value = $article_field('article_related_posts', []);
$related_ids = [];
if (is_array($related_value)) {
    foreach ($related_value as $related_item) {
        $related_ids[] = is_object($related_item) ? (int) $related_item->ID : (int) $related_item;
    }
    $related_ids = array_values(array_filter($related_ids));
}

if (!$related_ids) {
    $related_ids = get_posts([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 3,
        'post__not_in'   => [$post_id],
        'category__in'   => wp_list_pluck($categories, 'term_id'),
        'fields'         => 'ids',
    ]);
}
?>

<main class="article-page bg-surface-soft">
    <article>
        <header class="article-hero" style="background-image:url('<?php echo esc_url($hero_image); ?>')">
            <div class="article-hero-overlay"></div>
            <div class="relative z-10 mx-auto flex min-h-[560px] max-w-7xl items-end px-6 pb-20 pt-24 lg:px-8">
                <div class="max-w-4xl text-white">
                    <nav class="mb-8 flex flex-wrap items-center gap-2 text-xs text-neutral-300" aria-label="<?php esc_attr_e('Breadcrumbs', 'lawyer-theme'); ?>">
                        <a class="hover:text-accent" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'lawyer-theme'); ?></a>
                        <span>/</span>
                        <a class="hover:text-accent" href="<?php echo esc_url($blog_url); ?>"><?php esc_html_e('Blog', 'lawyer-theme'); ?></a>
                        <?php if ($primary_category) : ?><span>/</span><a class="hover:text-accent" href="<?php echo esc_url(get_category_link($primary_category)); ?>"><?php echo esc_html($primary_category->name); ?></a><?php endif; ?>
                    </nav>
                    <p class="home-kicker text-accent-light"><?php echo esc_html($article_field('article_eyebrow', $primary_category ? $primary_category->name : __('Legal insight', 'lawyer-theme'))); ?></p>
                    <h1 class="mt-5 text-5xl font-semibold leading-[1.08] md:text-7xl"><?php the_title(); ?></h1>
                    <?php $intro = $article_field('article_intro', get_the_excerpt()); ?>
                    <?php if ($intro) : ?><p class="mt-6 max-w-3xl text-lg leading-8 text-neutral-300"><?php echo esc_html($intro); ?></p><?php endif; ?>
                    <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-neutral-300">
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                        <span>•</span>
                        <span><?php echo esc_html(sprintf(_n('%d min read', '%d min read', lawyer_theme_reading_time(), 'lawyer-theme'), lawyer_theme_reading_time())); ?></span>
                        <span>•</span>
                        <span><?php echo esc_html($author_name); ?></span>
                    </div>
                </div>
            </div>
        </header>

        <div class="mx-auto grid max-w-7xl gap-12 px-6 py-16 lg:grid-cols-[minmax(0,1fr)_340px] lg:px-8 lg:py-24">
            <div class="min-w-0">
                <?php $highlight = $article_field('article_highlight_quote'); ?>
                <?php if ($highlight) : ?><blockquote class="mb-10 border-l-4 border-accent bg-white p-7 font-serif text-2xl leading-relaxed text-primary shadow-sm"><?php echo esc_html($highlight); ?></blockquote><?php endif; ?>

                <div class="article-content">
                    <?php the_content(); ?>
                </div>

                <?php $tags = get_the_tags(); ?>
                <?php if ($tags) : ?>
                    <div class="mt-12 flex flex-wrap gap-2 border-t border-primary/10 pt-8">
                        <?php foreach ($tags as $tag) : ?><a class="border border-primary/15 bg-white px-4 py-2 text-xs hover:border-accent hover:text-accent" href="<?php echo esc_url(get_tag_link($tag)); ?>">#<?php echo esc_html($tag->name); ?></a><?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <section class="mt-12 grid items-center gap-7 border border-primary/10 bg-white p-7 shadow-sm sm:grid-cols-[120px_1fr]">
                    <img class="size-28 rounded-full object-cover" src="<?php echo esc_url($author_image); ?>" alt="<?php echo esc_attr($author_name); ?>">
                    <div>
                        <p class="home-kicker"><?php esc_html_e('About the author', 'lawyer-theme'); ?></p>
                        <h2 class="mt-2 text-2xl font-semibold"><?php echo esc_html($author_name); ?></h2>
                        <p class="mt-1 text-sm text-accent"><?php echo esc_html($author_role); ?></p>
                        <?php if ($author_bio) : ?><p class="mt-3 text-sm leading-6 text-neutral-600"><?php echo esc_html($author_bio); ?></p><?php endif; ?>
                    </div>
                </section>
            </div>

            <aside class="space-y-7">
                <div class="sticky top-28 border border-primary/10 bg-primary p-8 text-white shadow-lg">
                    <p class="home-kicker text-accent-light"><?php echo esc_html($article_field('article_sidebar_eyebrow', __('Need legal guidance?', 'lawyer-theme'))); ?></p>
                    <h2 class="mt-4 text-3xl font-semibold leading-tight"><?php echo esc_html($article_field('article_sidebar_title', __('Discuss your situation with an attorney', 'lawyer-theme'))); ?></h2>
                    <p class="mt-4 text-sm leading-6 text-neutral-300"><?php echo esc_html($article_field('article_sidebar_text', __('Get a clear assessment of your options and practical next steps.', 'lawyer-theme'))); ?></p>
                    <a class="home-button home-button--gold mt-7 w-full" href="<?php echo esc_url($sidebar_link['url']); ?>" target="<?php echo esc_attr($sidebar_link['target']); ?>"><?php echo esc_html($sidebar_link['title']); ?></a>
                </div>
            </aside>
        </div>
    </article>

    <?php if ($related_ids) : ?>
        <section class="border-t border-primary/10 bg-white py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <p class="home-kicker text-center"><?php echo esc_html($article_field('article_related_eyebrow', __('Continue reading', 'lawyer-theme'))); ?></p>
                <h2 class="home-title"><?php echo esc_html($article_field('article_related_title', __('Related articles', 'lawyer-theme'))); ?></h2>
                <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <?php foreach (array_slice($related_ids, 0, 3) as $related_id) : ?>
                        <?php $related_categories = get_the_category($related_id); ?>
                        <article class="blog-card overflow-hidden border border-primary/10 bg-white">
                            <a href="<?php echo esc_url(get_permalink($related_id)); ?>">
                                <?php echo get_the_post_thumbnail($related_id, 'large', ['class' => 'h-52 w-full object-cover']); ?>
                            </a>
                            <div class="p-6">
                                <?php if ($related_categories) : ?><p class="home-kicker text-xs"><?php echo esc_html($related_categories[0]->name); ?></p><?php endif; ?>
                                <h3 class="mt-3 text-2xl font-semibold leading-snug"><a class="hover:text-accent" href="<?php echo esc_url(get_permalink($related_id)); ?>"><?php echo esc_html(get_the_title($related_id)); ?></a></h3>
                                <a class="mt-5 inline-flex text-sm font-semibold text-accent" href="<?php echo esc_url(get_permalink($related_id)); ?>"><?php esc_html_e('Read article', 'lawyer-theme'); ?> →</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="border-b border-white/10 bg-primary py-12 text-white">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-8 px-6 md:flex-row md:items-center lg:px-8">
            <div><p class="home-kicker text-accent-light"><?php echo esc_html($article_field('article_bottom_cta_eyebrow', __('A question remains?', 'lawyer-theme'))); ?></p><h2 class="mt-3 text-3xl font-semibold md:text-4xl"><?php echo esc_html($article_field('article_bottom_cta_title', __('Get advice for your situation', 'lawyer-theme'))); ?></h2><p class="mt-3 max-w-2xl text-neutral-300"><?php echo esc_html($article_field('article_bottom_cta_text', __('Contact us for a confidential consultation and a clear plan of action.', 'lawyer-theme'))); ?></p></div>
            <a class="home-button home-button--gold shrink-0" href="<?php echo esc_url($bottom_link['url']); ?>" target="<?php echo esc_attr($bottom_link['target']); ?>"><?php echo esc_html($bottom_link['title']); ?></a>
        </div>
    </section>
</main>

<?php get_footer(); ?>
