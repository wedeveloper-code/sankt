<?php
defined('ABSPATH') || exit;

/*
 * Content import orchestrator.
 * Runs once on theme activation via after_switch_theme.
 * Split into sub-files to keep each file small.
 */

require SA_DIR . '/inc/import/categories.php';
require SA_DIR . '/inc/import/pages.php';
require SA_DIR . '/inc/import/posts-winter.php';
require SA_DIR . '/inc/import/posts-summer.php';
require SA_DIR . '/inc/import/menus.php';
require SA_DIR . '/inc/import/images.php';

add_action('after_switch_theme', function () {
    if (get_option('sa_content_imported')) {
        return;
    }

    sa_import_categories();
    sa_import_pages();
    sa_import_posts_winter();
    sa_import_posts_summer();
    sa_import_menus();

    /* Set permalink structure */
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%category%/%postname%/');
    update_option('rewrite_rules', '');
    $wp_rewrite->flush_rules(true);

    update_option('sa_content_imported', 1);
});
