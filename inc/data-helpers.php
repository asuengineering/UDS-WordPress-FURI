<?php
/**
 * Helping functions for various symposium detail outputs.
 *
 * @package uds-wordpress-furi
 */


/**
 * Gathers meta data relates to a furi participant and returns a formatted location string.
 *
 * @return $location
 */
function asufse_symposium_get_location_details() {
	$location = '';

	if ( ! empty( get_field( '_participant_city' ) ) ) {
		$location .= get_field( '_participant_city' ) . ', ';
	}

	if ( ! empty( get_field( '_participant_state' ) ) ) {
		$location .= get_field( '_participant_state' ) . ', ';
	}

	if ( ! empty( get_field( '_participant_country' ) ) ) {
		$location .= get_field( '_participant_country' ) . ', ';
	}

	$location = trim( $location, ', ' );
	return $location;
}
