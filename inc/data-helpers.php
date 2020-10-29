<?php
/**
 * Helping functions for various symposium detail outputs.
 *
 * @package uds-wordpress-furi
 */

/**
 * Get list of term IDs with term meta 'furi_symposium_session_display' = 'yes'
 *
 * @return $term_ids
 */
function get_active_symposium_terms() {
	$term_args = array( 'taxonomy' => 'symposium_date' );
	$terms = get_terms( $term_args );

	$term_ids = array();

	foreach ( $terms as $term ) {
		$key = get_term_meta( $term->term_id, 'furi_symposium_session_display', true );

		if ( $key == true ) {
			// Push the ID into the array.
			$term_ids[] = $term->term_id;
		}
	};

	return $term_ids;
}

/**
 * Get list of term names with term meta 'furi_symposium_session_display' = 'yes'
 *
 * @return $term_names
 */
function get_active_symposium_names() {
	$term_args = array( 'taxonomy' => 'symposium_date' );
	$terms = get_terms( $term_args );

	$term_names = '';

	foreach ( $terms as $term ) {
		$key = get_term_meta( $term->term_id, 'furi_symposium_session_display', true );

		if ( $key == true ) {
			// Add term name to string.
			$term_names = $term_names . $term->name . ' ';
		}
	};

	return $term_names;
}

/**
 * Construct a set of CSS classes associated with a furiproject's research category
 *
 * @return $css_class
 */
function get_research_theme_class_names( $projectID ) {
	$css_class = '';

	$terms = get_the_terms( $projectID, 'research_theme' );

	foreach ( $terms as $term ) {
		$css_class .= 'theme-' . $term->slug . '-bg ';
		$css_class .= 'theme-' . $term->slug . '-text ';
	}

	return trim( $css_class );
}

/** 
 * Determine if a link should be displayed to join a Zoom session.
 * If so, which link should be displayed? 
 * Output is either empty or a fully marked up button.
 * 
 * @return $button;
 */
function get_symposium_status_url ( $projectID ) {
	
	$button = '';

	// Get the list of terms associated with this project.
	$terms = get_the_terms( $projectID, "symposium_date" );
	$term_ids = array();

	$display_conference_flag = false;
	foreach ( $terms as $term ) {
		$display_conference = get_field( 'furi_symposium_conference_display', $term );
		if ( $display_conference == true ) {
			$display_conference_flag = true;
		}
	}

	if ( $display_conference_flag == true) {
		// Game on. We should produce a button. Now find the right href value.

		$button = '<a class="btn btn-gold btn-conference" href="';

		$project_url = get_field( '_furiproject_conference_url' , $projectID );
		$groups = get_the_terms( $projectID, "symposium_group" );
		
		if ( ! empty( $project_url )) {
			// Use the included project URL as the href.
			$button .= $project_url;
		} elseif ( ! empty ( $groups )) {
			// Use the URL from the associated symposium group.
			$group_url = get_field( 'symposiumgroup_conference_URL', $groups[0]);
			$button .= $group_url;
		} else {
			// There should be a URL but there's not one indicated. Prevent an HTTP error
			$button = '';
		}
	}
	
	if ( ! empty( $button )) {
		$button .= '" target="_blank">Join the session<span class="fas fa-external-link-alt"></span></a>';
	}

	return $button;

}
