<?php
/**
 * Block template: Featured Mentors
 *
 * @package uds-wordpress-furi
 */

$headline = get_field('block_generic_headline');
$description = get_field('block_generic_description');
$mentors = get_field('block_featured_mentor_select');

if ( $mentors ) {

    echo '<section id="featured-mentors">';
    echo '<div class="container">';
    echo '<div class="row row-header">';
    echo '<div class="col-md-8">';
    echo '<h2>' . $headline . '</h2>';
    echo wp_kses_post($description);
    echo '</div></div>';
    echo '<div class="row">';

    foreach ($mentors as $mentor) {
                        
        // Additional term meta here is required if the mentor is a featured mentor. 
        // No need to check if empty.
        $mentorprogram = get_field( '_mentor_featured_program', $mentor );
        $mentorquote = get_field( '_mentor_featured_quote', $mentor );
        $mentorcite = get_field( '_mentor_featured_citation', $mentor );
        $mentorlinkcite = get_field( '_mentor_featured_linked_citation', $mentor );

        $mentorimage = get_field( '_mentor_acf_thumbnail', $mentor );

        echo '<div class="row">';

        if ( ! empty( $mentorimage ) ) {
            echo '<div class="col-md-3">';
            echo '<img class="img-fluid" src="' . esc_html( $mentorimage ) . '" alt="' . esc_html( $mentor->name ) . '" />';
            echo '</div>';
        }
        
        echo '<div class="col-md-9">';
        echo '<h3><a href="'. get_term_link($mentor) . '" title="' . esc_html( $mentor->name ). '">' . esc_html( $mentor->name ) . '</a>, featured ' . esc_html( $mentorprogram->name ) . ' mentor</h3>';
        echo '<blockquote class="ws2-element-gold ws2-element-style ws2-element-spacing-entity">';
        echo '<p>' . wp_kses_post( $mentorquote ) . '</p>';

        if ( ! empty( $mentorlinkcite )) {
            $citedname = furi_participant_name( $mentorlinkcite->ID );
            $citedmajor = wp_strip_all_tags( get_the_term_list( $mentorlinkcite->ID, 'degree_program', '', ', ', '' ) );
        
            echo '<cite>';
            echo '<a href="' . esc_url( get_permalink( $mentorlinkcite ) ) . '" title="' . esc_html( $citedname ) . '">';
            echo  esc_html( trim( $citedname ) ) . '</a>, <span class="cited-degree-program">' . esc_html( $citedmajor ) . '</span>';
            echo '</cite>';
        } else {
            echo '<cite>' . wp_kses_post( $mentorcite ) . '</cite>';
        }

        echo '</blockquote>';
        echo '</div>';

        echo '</div>';
    }
}

