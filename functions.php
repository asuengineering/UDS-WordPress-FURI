<?php
/**
 * UDS WordPress FURI child theme functions and definitions
 *
 * @package uds-wordpress-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'wp_enqueue_scripts', 'uds_wordpress_child_scripts' );
/**
 * Enqueue theme assets.
 */
function uds_wordpress_child_scripts() {
	// Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$css_child_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . '/css/child-theme.min.css' );
	wp_enqueue_style( 'uds-wordpress-child-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array( 'uds-wordpress-styles' ), $css_child_version );

	$js_child_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . '/js/child-theme.js' );
	wp_enqueue_script( 'uds-wordpress-child-script', get_stylesheet_directory_uri() . '/js/child-theme.js', array( 'jquery' ), $js_child_version );
	
	// Load Font Awesome 5, from our kit.
	wp_dequeue_script( 'uds-wordpress-fa-scripts' );
	wp_enqueue_script( 'uds-furi-fontawesome-pro', 'https://kit.fontawesome.com/3fdebab6fc.js', array(), null, true );
}

/**
 * Enqueue scripts and styles.
 */
function furi_child_theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	// Check for page templates and load more things.
	if ( is_page() ) {
		global $wp_query;
		$template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );

		if ( 'symposium.php' == $template_name ) {
			wp_enqueue_style( 'bs-select', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css', array(), null );
			wp_enqueue_script( 'isotope-js', 'https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js', array(), '', true );
			wp_enqueue_script( 'bs-select-js', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'furi-symposium-js', get_stylesheet_directory_uri() . '/js/custom-symposium.js', array( 'jquery' ), $theme_version, true );
		}

		if ( 'fullpage-about.php' == $template_name ) {
			wp_enqueue_script( 'google-charts', 'https://www.gstatic.com/charts/loader.js', array(), $theme_version, true );
			wp_enqueue_script( 'furi-about', get_stylesheet_directory_uri() . '/js/custom-charts.js', array( 'google-charts' ), $theme_version, true );
		}

		if ( 'fullpage-home.php' == $template_name ) {
			wp_enqueue_style( 'animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), null );
		}
	}

	// Check for symposium-date archive pages and load DataTables JS.
	if ( is_tax( 'symposium_date' ) ) {
		wp_enqueue_style( 'datatables-bootstrap4', '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css', array(), null );
		wp_enqueue_script( 'datatables-js', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', array(), '', true );
		wp_enqueue_script( 'datatables-bootstrap4-js', '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js', array(), '', true );
		wp_enqueue_script( 'custom-datatables-js', get_stylesheet_directory_uri() . '/js/custom-datatables.js', array( 'jquery' ), $theme_version, true );
	}
}

add_action( 'wp_enqueue_scripts', 'furi_child_theme_enqueue_styles' );


// Included files. The order is important.
// ===============================================

require get_stylesheet_directory() . '/inc/custom-post-types.php';
require get_stylesheet_directory() . '/inc/posts-to-posts.php';
require get_stylesheet_directory() . '/inc/data-helpers.php';


// Gravity Forms. Create participant_to_project connections after post submission.
// ===============================================
add_action( 'gform_after_submission_1', 'create_project_connections', 10, 2 );
function create_project_connections( $entry, $form ) {
	// More than one post may be created for a form submission.
	// The created post ids are stored as an array in the entry meta
	$created_posts = gform_get_meta( $entry['id'], 'gravityformsadvancedpostcreation_post_id' );

	// Count the number of things in the array.
	if ( count( $created_posts ) > 1 ) {
		// Greater than one item in the array means it created a project & a person.
		// Get both items in the array and create a connection.
		$from = $created_posts[0]['post_id'];
		$to = $created_posts[1]['post_id'];
	} else {
		// The form submission created exactly one post object. It will be a project. Get the id.
		// Also get the value of the post ID already selected in the form. That's stored in fieldID=5
		$from = $created_posts[0]['post_id'];
		$to = $entry[5];
	}

	// Create the connection.
	p2p_type( 'participants_to_projects' )->connect( $from, $to, array( 'date' => current_time( 'mysql' ) ) );

}
/**
 * Prints inline styles for research project categories.
 * Useful for color coding elements on the fly with a CSS class instead of inline styles.
 * Produces classes in the pattern of ".theme-{$term->slug}-bg"
 */
function furiproject_research_category_colors() {

	$output = '';

	$terms = get_terms(
		array(
			'taxonomy'   => 'research_theme', // Swap in your custom taxonomy name
			'hide_empty' => true,
		)
	);

	// Loop through all terms with a foreach loop
	foreach ( $terms as $term ) {
		$bg_hexvalue = get_field( 'researchtheme_bg_color', $term );
		$text_hexvalue = get_field( 'researchtheme_text_color', $term );
		if ( ! empty( $bg_hexvalue ) ) {
			$output .= '.theme-' . $term->slug . '-bg { background-color: ' . esc_attr( $bg_hexvalue ) . ' !important; } ';
			$output .= '.theme-' . $term->slug . '-bg:hover { background-color: ' . esc_attr( $bg_hexvalue ) . ' !important; } ';
			$output .= '.theme-' . $term->slug . '-text, .theme-' . $term->slug . ':visited { color: ' . esc_attr( $text_hexvalue ) . ' !important; } ';
			$output .= '.theme-' . $term->slug . '-text:hover { color: ' . esc_attr( $text_hexvalue ) . ' !important; } ';
		}
	}

	if ( ! empty( $output ) ) {
		wp_add_inline_style( 'uds-wordpress-child-styles', $output );
	}

}
add_action( 'wp_enqueue_scripts', 'furiproject_research_category_colors' );


/** 
 * Adds a section of content right above the global footer.
 */
function uds_furi_add_symposium_totals() {
	get_template_part( 'templates/snapshot', 'footer' );
}
add_action( 'uds_wp_before_global_footer', 'uds_furi_add_symposium_totals' );
