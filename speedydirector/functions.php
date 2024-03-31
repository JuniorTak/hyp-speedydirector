<?php
/* Define two constants that we’ll use in our theme */
define( 'TEMPPATH', get_bloginfo('stylesheet_directory'));
define( 'IMAGES', TEMPPATH. "/images");

/* Add menu support */
add_theme_support('nav-menus');
if (function_exists('register_nav_menus')) {
    register_nav_menus(
        array(
            'main' => 'Main Nav'
        )
    );
}

/* Add support for a sidebar */
if (function_exists('register_sidebar')) {
    register_sidebar(
        array (
            'name' => __( 'Primary Sidebar', 'primary-sidebar' ),
            'id' => 'primary-widget-area',
            'description' => __( 'The primary widget area', 'dir' ),
            'before_widget' => '<div class="widget">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}

require_once('business-manager.php');
require_once('theme-options.php');

/* Apply the rewrite to include CPT */
add_action('init', 'speedydirector_rewrite');
function speedydirector_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->add_permastruct('typename', 'typename/%year%/%postname%/', true, 1);
    add_rewrite_rule('typename/([0-9]{4})/(.+)/?$', 'index.php?typename=$matches[2]', 'top');
    $wp_rewrite->flush_rules();
}

?>