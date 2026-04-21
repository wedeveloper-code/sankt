<?php
defined('ABSPATH') || exit;

define('SA_VERSION', '1.0.0');
define('SA_DIR', get_template_directory());
define('SA_URI', get_template_directory_uri());

/* =============================================
   THEME SETUP
   ============================================= */
add_action('after_setup_theme', function () {
    load_theme_textdomain('sant-andreasberg', SA_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('automatic-feed-links');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Hauptmenü', 'sant-andreasberg'),
        'footer'  => __('Fußzeilen-Menü', 'sant-andreasberg'),
    ]);

    add_image_size('sa-card',      640, 360, true);
    add_image_size('sa-hero',      1600, 700, true);
    add_image_size('sa-thumb',     400, 300, true);
    add_image_size('sa-wide',      1200, 500, true);
});

/* =============================================
   ENQUEUE ASSETS
   ============================================= */
add_action('wp_enqueue_scripts', function () {
    /* Critical CSS — loaded normally (render-blocking is acceptable for layout CSS) */
    wp_enqueue_style('sa-main', SA_URI . '/assets/css/main.css', [], SA_VERSION);
    /* JS in footer — non-blocking */
    wp_enqueue_script('sa-main', SA_URI . '/assets/js/main.js', [], SA_VERSION, true);
    wp_script_add_data('sa-main', 'defer', true);
});

/* Load Google Fonts asynchronously to avoid render-blocking */
add_action('wp_head', function () {
    $font_url = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Merriweather:wght@400;700&display=swap';
    /* Preconnect hints */
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    /* Non-blocking font load */
    echo '<link rel="preload" href="' . esc_url($font_url) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
    echo '<noscript><link rel="stylesheet" href="' . esc_url($font_url) . '"></noscript>' . "\n";
}, 5);

/* =============================================
   CUSTOM TITLE TAG
   ============================================= */
add_filter('document_title_parts', function ($parts) {
    $meta_title = sa_get_custom_meta('title');
    if ($meta_title) {
        $parts['title'] = $meta_title;
        unset($parts['page'], $parts['tagline']);
    }
    return $parts;
}, 20);

/* =============================================
   CATEGORY URL HELPER
   ============================================= */
function sa_get_cat_url(string $slug): string {
    $term = get_term_by('slug', $slug, 'category');
    return $term ? esc_url(get_category_link($term->term_id)) : esc_url(home_url('/'));
}

/* =============================================
   BODY CLASSES
   ============================================= */
add_filter('body_class', function ($classes) {
    if (is_singular()) {
        $classes[] = 'single-' . get_post_type();
    }
    return $classes;
});

/* =============================================
   EXCERPT LENGTH
   ============================================= */
add_filter('excerpt_length', fn() => 22);
add_filter('excerpt_more', fn() => '…');

/* =============================================
   WIDGETS
   ============================================= */
add_action('widgets_init', function () {
    register_sidebar([
        'name'          => __('Seiten-Sidebar', 'sant-andreasberg'),
        'id'            => 'sidebar-main',
        'description'   => __('Widgets für die rechte Seiten-Spalte.', 'sant-andreasberg'),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ]);
    register_sidebar([
        'name'          => __('Footer Spalte 1', 'sant-andreasberg'),
        'id'            => 'footer-1',
        'before_widget' => '<div class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ]);
    register_sidebar([
        'name'          => __('Footer Spalte 2', 'sant-andreasberg'),
        'id'            => 'footer-2',
        'before_widget' => '<div class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ]);
});

/* =============================================
   BREADCRUMB HELPER
   ============================================= */
function sa_breadcrumb() {
    echo '<nav class="breadcrumb" aria-label="Breadcrumb"><div class="container">';
    echo '<span><a href="' . esc_url(home_url('/')) . '">' . __('Startseite', 'sant-andreasberg') . '</a></span>';

    if (is_category()) {
        echo '<span>' . single_cat_title('', false) . '</span>';
    } elseif (is_singular()) {
        $cats = get_the_category();
        if ($cats) {
            echo '<span><a href="' . esc_url(get_category_link($cats[0]->term_id)) . '">' . esc_html($cats[0]->name) . '</a></span>';
        }
        echo '<span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_page()) {
        $post = get_post();
        if ($post && $post->post_parent) {
            echo '<span><a href="' . esc_url(get_permalink($post->post_parent)) . '">' . esc_html(get_the_title($post->post_parent)) . '</a></span>';
        }
        echo '<span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_search()) {
        echo '<span>' . sprintf(__('Suche: %s', 'sant-andreasberg'), esc_html(get_search_query())) . '</span>';
    } elseif (is_404()) {
        echo '<span>404</span>';
    }
    echo '</div></nav>';
}

/* =============================================
   TEMPLATE HELPERS
   ============================================= */
function sa_the_post_thumbnail_url(string $size = 'sa-card'): string {
    if (has_post_thumbnail()) {
        return get_the_post_thumbnail_url(null, $size);
    }
    return SA_URI . '/assets/images/placeholder.webp';
}

function sa_get_custom_meta(string $key): string {
    $post_id = is_home() ? (int) get_option('page_for_posts') : get_the_ID();
    if (is_front_page() && is_home()) {
        return (string) get_option('sa_home_meta_' . $key, '');
    }
    if (is_front_page()) {
        $v = get_option('sa_home_meta_' . $key, '');
        if ($v) return (string) $v;
    }
    if (is_category()) {
        $term_id = get_queried_object_id();
        return (string) get_term_meta($term_id, 'sa_meta_' . $key, true);
    }
    if ($post_id) {
        return (string) get_post_meta($post_id, 'sa_meta_' . $key, true);
    }
    return '';
}

function sa_the_custom_h1(string $fallback = '') {
    $h1 = sa_get_custom_meta('h1');
    echo '<h1>' . esc_html($h1 ?: $fallback) . '</h1>';
}

/* =============================================
   FRONT PAGE HELPERS (used in front-page.php)
   ============================================= */
function sa_feature_card(string $icon, string $title, string $text, string $url): void { ?>
  <div class="feature-item">
    <div class="feature-icon" aria-hidden="true" style="font-size:1.75rem;background:none"><?php echo $icon; /* numeric HTML entity — safe, hardcoded */ ?></div>
    <h3><?php echo esc_html($title); ?></h3>
    <p style="font-size:.9rem;color:var(--color-text-light)"><?php echo esc_html($text); ?></p>
    <a href="<?php echo esc_url($url); ?>" class="card-link"><?php esc_html_e('Mehr erfahren', 'sant-andreasberg'); ?></a>
  </div>
<?php }

function sa_fact(string $value, string $label): void { ?>
  <div class="feature-item" style="padding:1rem">
    <div class="stat-number" style="font-size:1.75rem"><?php echo $value; /* hardcoded numeric entity — safe */ ?></div>
    <div class="stat-label"><?php echo esc_html($label); ?></div>
  </div>
<?php }

/* Fallback menu when no nav menu is assigned */
function sa_default_menu(array $args = []): void {
    echo '<ul class="main-nav">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Startseite', 'sant-andreasberg') . '</a></li>';
    $cats = get_categories(['hide_empty' => true, 'number' => 6]);
    foreach ($cats as $cat) {
        echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
    }
    echo '</ul>';
}

/* =============================================
   LOAD MODULES
   ============================================= */
require SA_DIR . '/inc/custom-meta.php';
require SA_DIR . '/inc/sitemap.php';
require SA_DIR . '/inc/image-webp.php';
require SA_DIR . '/inc/content-import.php';
