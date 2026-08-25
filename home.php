<?php
get_header();

$blog_page_id = (int) get_option('page_for_posts');
$blog_field = static function ($name, $default = '') use ($blog_page_id) {
    if (!function_exists('get_field') || !$blog_page_id) {
        return $default;
    }

    $value = get_field($name, $blog_page_id);

    return ($value !== null && $value !== false && $value !== '') ? $value : $default;
};
$blog_image_url = static function ($value, $fallback = '') {
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

$hero_image = $blog_image_url(
    $blog_field('blog_hero_image'),
    get_template_directory_uri() . '/assets/images/blog-hero.png'
);
$blog_url = $blog_page_id ? get_permalink($blog_page_id) : home_url('/blog/');
$read_more_label = $blog_field('blog_read_more_label', __('Read article', 'lawyer-theme'));
$featured_value = $blog_field('blog_featured_post', 0);
$featured_id = is_object($featured_value) ? (int) $featured_value->ID : (int) $featured_value;
$paged = max(1, (int) get_query_var('paged'));
$show_featured = is_home() && $paged === 1;

if ($show_featured && !$featured_id) {
    $latest_post = get_posts([
        'numberposts' => 1,
        'post_status' => 'publish',
        'fields'      => 'ids',
    ]);
    $featured_id = !empty($latest_post) ? (int) $latest_post[0] : 0;
}

$query_args = [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => (int) get_option('posts_per_page', 6),
    'paged'          => $paged,
];

if ($show_featured && $featured_id) {
    $query_args['post__not_in'] = [$featured_id];
}

if (is_category()) {
    $query_args['cat'] = (int) get_queried_object_id();
}

$blog_query = new WP_Query($query_args);
$categories = get_categories(['hide_empty' => true]);
$current_category_id = is_category() ? (int) get_queried_object_id() : 0;
?>

<main class="blog-page bg-surface-soft">
    <section class="blog-hero" style="background-image:url('<?php echo esc_url($hero_image); ?>')">
        <div class="blog-hero-overlay"></div>
        <div class="relative z-10 mx-auto flex min-h-[430px] max-w-7xl items-center px-6 py-20 lg:px-8">
            <div class="max-w-xl text-white">
                <p class="home-kicker text-accent-light"><?php echo esc_html($blog_field('blog_hero_eyebrow', __('Blog', 'lawyer-theme'))); ?></p>
                <h1 class="mt-4 text-6xl font-semibold leading-none md:text-7xl"><?php echo esc_html($blog_field('blog_hero_title', __('Insights', 'lawyer-theme'))); ?></h1>
                <div class="mt-7 h-px w-12 bg-accent"></div>
                <p class="mt-7 max-w-md leading-7 text-neutral-300"><?php echo esc_html($blog_field('blog_hero_text', __('Practical articles and clear legal explanations on relevant questions of law.', 'lawyer-theme'))); ?></p>
            </div>
        </div>
    </section>

    <section class="py-16 lg:py-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <nav class="flex flex-wrap justify-center gap-3" aria-label="<?php esc_attr_e('Article categories', 'lawyer-theme'); ?>">
                <a class="blog-filter <?php echo !$current_category_id ? 'is-active' : ''; ?>" href="<?php echo esc_url($blog_url); ?>"><?php echo esc_html($blog_field('blog_all_categories_label', __('All articles', 'lawyer-theme'))); ?></a>
                <?php foreach ($categories as $category) : ?>
                    <a class="blog-filter <?php echo $current_category_id === (int) $category->term_id ? 'is-active' : ''; ?>" href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo esc_html($category->name); ?></a>
                <?php endforeach; ?>
            </nav>

            <?php if ($show_featured && $featured_id && get_post_status($featured_id) === 'publish') : ?>
                <?php
                $featured_category = get_the_category($featured_id);
                $featured_image = get_the_post_thumbnail_url($featured_id, 'large') ?: $hero_image;
                ?>
                <article class="mt-12 grid overflow-hidden border border-primary/10 bg-white shadow-sm lg:grid-cols-[1fr_1.45fr]">
                    <a href="<?php echo esc_url(get_permalink($featured_id)); ?>"><img class="h-full min-h-80 w-full object-cover" src="<?php echo esc_url($featured_image); ?>" alt=""></a>
                    <div class="grid p-8 md:grid-cols-[1fr_auto] md:gap-8 lg:p-10">
                        <div>
                            <p class="home-kicker"><?php echo esc_html($blog_field('blog_featured_eyebrow', __('Recommended article', 'lawyer-theme'))); ?></p>
                            <h2 class="mt-4 text-4xl font-semibold leading-tight"><a class="hover:text-accent" href="<?php echo esc_url(get_permalink($featured_id)); ?>"><?php echo esc_html(get_the_title($featured_id)); ?></a></h2>
                            <p class="mt-5 leading-7 text-neutral-600"><?php echo esc_html(wp_trim_words(get_the_excerpt($featured_id), 28)); ?></p>
                            <a class="mt-7 inline-flex text-sm font-semibold text-accent" href="<?php echo esc_url(get_permalink($featured_id)); ?>"><?php echo esc_html($read_more_label); ?> →</a>
                        </div>
                        <div class="mt-7 space-y-4 border-primary/10 text-sm text-neutral-600 md:mt-0 md:border-l md:pl-8">
                            <p>▣ <?php echo esc_html(get_the_date('', $featured_id)); ?></p>
                            <?php if (!empty($featured_category)) : ?><p>◇ <?php echo esc_html($featured_category[0]->name); ?></p><?php endif; ?>
                            <p>◷ <?php echo esc_html(sprintf(_n('%d min read', '%d min read', lawyer_theme_reading_time($featured_id), 'lawyer-theme'), lawyer_theme_reading_time($featured_id))); ?></p>
                        </div>
                    </div>
                </article>
            <?php endif; ?>

            <?php if ($blog_query->have_posts()) : ?>
                <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                        <?php $post_categories = get_the_category(); ?>
                        <article <?php post_class('blog-card overflow-hidden border border-primary/10 bg-white'); ?>>
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large', ['class' => 'h-56 w-full object-cover']); ?>
                                <?php else : ?>
                                    <img class="h-56 w-full object-cover" src="<?php echo esc_url($hero_image); ?>" alt="">
                                <?php endif; ?>
                            </a>
                            <div class="p-7">
                                <?php if (!empty($post_categories)) : ?><p class="home-kicker text-xs"><?php echo esc_html($post_categories[0]->name); ?></p><?php endif; ?>
                                <h2 class="mt-3 text-2xl font-semibold leading-snug"><a class="hover:text-accent" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <div class="mt-5 flex items-center gap-4 text-xs text-neutral-600"><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time><span>•</span><span><?php echo esc_html(sprintf(_n('%d min read', '%d min read', lawyer_theme_reading_time(), 'lawyer-theme'), lawyer_theme_reading_time())); ?></span></div>
                                <a class="mt-6 inline-flex text-sm font-semibold text-accent" href="<?php the_permalink(); ?>"><?php echo esc_html($read_more_label); ?> →</a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <nav class="blog-pagination mt-12 flex justify-center" aria-label="<?php esc_attr_e('Posts pagination', 'lawyer-theme'); ?>">
                    <?php
                    echo wp_kses_post(paginate_links([
                        'total'     => $blog_query->max_num_pages,
                        'current'   => $paged,
                        'mid_size'  => 2,
                        'prev_text' => '←',
                        'next_text' => '→',
                        'type'      => 'list',
                    ]));
                    ?>
                </nav>
            <?php else : ?>
                <p class="mt-12 text-center text-neutral-600"><?php echo esc_html($blog_field('blog_empty_text', __('No articles have been published yet.', 'lawyer-theme'))); ?></p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
