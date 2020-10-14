<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'wp_enqueue_scripts', 'asu_wp2020_child_scripts' );
function asu_wp2020_child_scripts() {
    // Get the theme data.
    $the_theme     = wp_get_theme();
    $theme_version = $the_theme->get( 'Version' );

    $css_child_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . '/css/child-theme.min.css' );
    wp_enqueue_style( 'asu-wp2020-child-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array('asu-wp2020-styles'), $css_child_version );

    $js_child_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . '/js/child-theme.min.js' );
    wp_enqueue_style( 'asu-wp2020-child-styles', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array('jquery'), $js_child_version );
}
