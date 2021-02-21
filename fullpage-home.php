<?php
/**
 * Template Name: Home Page
 *
 * @package uds-wordpress-theme
 */

get_header();

/**
 * Gathers meta data relates to a furi participant and returns a formatted location string.
 *
 * @return $location
 */
function furi_participant_location_details() {
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

$term_ids = get_active_symposium_terms();
$args = array(
    'post_type' => 'furiproject',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'symposium_date',
            'terms'    => $term_ids,
        ),
    ),
    'meta_query' => array(
        array(
            'key' => '_furiproject_featured',
            'value' => true,
            'compare' => '=',
        )
        ),
    'orderby' => 'rand',
);

?>

<!-- Markup for the page -->
<div class="wrapper" id="page-wrapper">

    <?php get_template_part( 'templates-global/hero' ); ?>

    <?php get_template_part( 'templates-global/global-banner' ); ?>

	<div class="container" id="main-content">

        <div class="row">
            <div class="col">
                
                <div id="featured-projects" class="carousel carousel-animation slide" data-ride="carousel" data-interval="10000">
                    <h2>Featured students</h2>
                    <div class="carousel-inner">

                        <?php

                        $query = new WP_Query( $args );
                        p2p_type( 'participants_to_projects' )->each_connected( $query, array(), 'relatedparticipants' );
                        
                        $activeclass = 0;
                        $indicators = '';
                        while ( $query->have_posts() ) :

                            $query->the_post();
                            
                            $featured_thumb = get_the_post_thumbnail( $query->ID, array(950,700), array( 'class' => 'img-fluid' ) );

                            // Grab all related participants from the projects query above.
                            foreach ( $post->relatedparticipants as $related ) :
                                setup_postdata( $related );

                                $relatedparticipant = furi_participant_name( $related->ID );
                                $major = wp_strip_all_tags( get_the_term_list( $related->ID, 'degree_program', '', ', ', '' ) );
                                $participantlink = get_permalink( $related->ID );

                            endforeach;

                            $presentationtype = wp_strip_all_tags( get_the_term_list( $query->ID, 'presentation_type', '', ', ', '' ) );
                            $projectimpact = get_field( '_furiproject_impact_statement', $query->ID );
                            $projectclassname = get_research_theme_class_names( $query->ID );

                            $indicators .= '<li data-target="#featured-projects" data-slide-to="' . $activeclass . '"';
                            if ( 0 == $activeclass ) {
                                $indicators .= ' class="active"';
                            }
                            $indicators .= "></li>";

                            // Output.

                            if ( 0 == $activeclass ) {
                                echo '<div class="carousel-item active">';
                            } else {
                                echo '<div class="carousel-item">';
                            }
                            echo '<div class="animate__animated featured-image">';
                            echo $featured_thumb;
                            echo '</div>';

                            ?>

                            <div class="card card-symposium card-home animate__animated">
                                <div class="card-header <?php echo esc_html( $projectclassname ); ?>">
                                    <h3 class="participant"><?php echo esc_html( $relatedparticipant ); ?></h3>
                                    <h5 class="major"><?php echo esc_html( $major ); ?></h5>
                                </div>
                                <div class="card-body">
                                    <?php
                                    the_title(
                                        sprintf( '<h4 class="card-title"><a href="%s" rel="bookmark">', esc_url( $participantlink ) ),
                                        '</a></h4>'
                                    );
                                    ?>
                                    <p class="card-text"><?php echo esc_html( $projectimpact ); ?></p>
                                    <p class="card-text project-mentor">
                                        <strong>Mentor: </strong><?php echo get_the_term_list( $query->ID, 'faculty_mentor', '', ', ', '' ); ?>
                                    </p>
                                    <p class="card-text project-type">
                                        <strong>Program: </strong><?php echo esc_html( $presentationtype ); ?>
                                    </p>
                                </div>
                            </div>
                            
                            <?php 

                            echo '</div><!-- end .carousel-item -->';

                        $activeclass ++;
                        endwhile;
                
                        ?>
                    </div><!-- end .carousel-inner -->

                    <div class="carousel-controls">
                        <button type="button" class="btn btn-circle btn-circle-alt-white" href="#featured-projects" data-slide="prev">
                            <i class="fas fa-chevron-left"></i>
                            <span class="sr-only" >Previous</span>
                        </button>

                        <button type="button" class="btn btn-circle btn-circle-alt-white" href="#featured-projects" data-slide="next">
                            <i class="fas fa-chevron-right"></i>
                            <span class="sr-only" >Next</span>
                        </button>

                        <ol class="carousel-indicators">
                            <?php echo $indicators; ?>
                        </ol>
                    </div>

                </div><!-- end #featured-projects -->
            
            </div><!-- end .col -->

        </div><!-- end .row -->
    </div><!-- .container --> 

    <div class="container" id="program-descriptions">
        <div class="row">
            <div class="col-md-6">
                <h4>Fulton Undergraduate Research Initiative</h4>
                <p>The Fulton Undergraduate Research Initiative enhances an undergraduate student’s engineering experience and technical education by providing hands-on lab experience, independent and thesis-based research, and travel to national conferences.</p>
            </div>
            <div class="col-md-6">
                <h4>Master’s Opportunity for Research in Engineering</h4>
                <p>The Master’s Opportunity for Research in Engineering is designed to enrich a graduate student’s engineering and technical graduate curriculum with hands-on lab experience and independent and thesis-based research.</p>
            </div>
            <div class="col-md-6">
                <h4>Grand Challenges Scholars Program</h4>
                <p>The Fulton Schools Grand Challenges Scholars Program combines innovative curriculum and cutting-edge research experiences into an intellectual fusion that spans academic disciplines and includes entrepreneurial, global and service learning opportunities. Students in GCSP conduct research in a grand challenges theme and are invited to present their research at the FURI Symposium.</p>
            </div>
            <div class="col-md-6">
                <h4>KEEN Student Mini Grants</h4>
                <p>Students who apply curiosity and connections to create extraordinary value for stakeholders are supported by KEEN Student Mini Grants, funded by the ASU Kern Project. Their projects can be part of student organization activities, group research or individual work that exemplifies an entrepreneurial-minded approach. These students are invited to present their entrepreneurial projects at the FURI Symposium.</p>
            </div>
        </div>
    </div>

    <div class="container" id="current-snapshot">
        <div class="row">
            <div class="col-md-8">
                <h2>Snapshot</h2>
                <p>Students from three signature programs present at the FURI Symposium: Fulton Undergraduate Research Initiative, Master’s Opportunity for Research in Engineering and Grand Challenges Scholars Program. Students who earned KEEN Student Mini Grants also participate. In Summer and Fall 2020, 144 students participated.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
				<div class="stat-package d-flex flex-row">
					<h3><span>FURI</span>students</h3>
					<div class="counter" data-count="134">0</div>
                </div>
                <div class="stat-package d-flex flex-row">
					<h3><span>FURI</span>mentors</h3>
					<div class="counter" data-count="58">0</div>
				</div>
            </div>
            <div class="col-md-3">
				<div class="stat-package d-flex flex-row">
					<h3><span>MORE</span>students</h3>
					<div class="counter" data-count="30">0</div>
                </div>
                <div class="stat-package d-flex flex-row">
					<h3><span>MORE</span>mentors</h3>
					<div class="counter" data-count="19">0</div>
				</div>
            </div>
            <div class="col-md-3">
				<div class="stat-package d-flex flex-row">
					<h3><span>GCSP</span>students</h3>
					<div class="counter" data-count="4">0</div>
                </div>
                <div class="stat-package d-flex flex-row">
					<h3><span>GCSP</span>mentors</h3>
					<div class="counter" data-count="3">0</div>
				</div>
            </div>
            <div class="col-md-3">
				<div class="stat-package d-flex flex-row">
					<h3><span>KEEN</span>students</h3>
					<div class="counter" data-count="1">0</div>
                </div>
                <div class="stat-package d-flex flex-row">
					<h3><span>KEEN</span>mentors</h3>
					<div class="counter" data-count="1">0</div>
				</div>
			</div>
        </div>
    </div>
    
    <section id="research-themes" class="bg network-white">
        <div class="container">
            <div class="row row-header">
                <div class="col-md-7">
                    <h2>Research themes</h2>
                    <p class="lead">Students work on projects related to six different themes that represent the Fulton Schools’ core research disciplines.</p>
                </div>
            </div>

            <div class="row">

                <?php 

                $themes = get_terms( 
                    array(
                        'taxonomy' => 'research_theme',
                        'hide_empty' => false,
                    )
                );

                foreach ($themes as $theme) {
                    $themeicon = get_field( 'researchtheme_icon', $theme );
                    echo '<div class="col-md-6"><div class="media">';
                    echo '<img class="img-fluid mr-3" src="' . esc_url( $themeicon['url'] ) . '" alt="' . esc_attr( $themeicon['alt'] ) . '" />';
                    echo '<div class="media-body"><h3 class="mt-0">' . esc_html( $theme->name ) . '</h3>';
                    echo wp_kses_post( $theme->description );
                    echo '</div></div></div>';
                }
                ?>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Project count in the current symposium</h3>
                    <div id="subject-chart"></div>
                </div>
            </div>

        </div>
    </section>

    <section id="sponsored-students">
        <div class="container">
                <div class="row row-header">
                    <div class="col-md-8">
                        <h2>Sponsored students</h2>
                        <p class="lead">Some of our researchers get extra funding through grants, industry and alumni sponsors.</p>
                    </div>
                </div>

                <div class="row">

                    <?php 
                    $sponsors = get_terms( 
                        array(
                            'taxonomy' => 'industry_sponsor',
                            'hide_empty' => false,
                        )
                    );

                    foreach ($sponsors as $sponsor) {
                        echo '<div class="col pr-6">';
                        echo '<h3>' . esc_html( $sponsor->name ) . '</h3>';
                        echo '<p>' . wp_kses_post( $sponsor->description ) . '</p>';
                        echo '<p><a class="btn btn-md btn-maroon" href="'. get_term_link($sponsor) . '" title="' . esc_html( $sponsor->name ). '">View sponsored projects</a></p>';
                        echo '</div>';
                    }
                    ?>

                </div>
            </div>
        </section>

        <section id="featured-mentors">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Featured Mentors</h2>
                    </div>
                </div>

                <?php 

                $args = array(
                    'taxonomy'   => 'faculty_mentor',
                    'hide_empty' => true,
                    'meta_query' => array(
                        array(
                            'key'       => '_mentor_featured_yn',
                            'value'     => true,
                            'compare'   => 'LIKE'
                        )
                    ),
                    'orderby' => 'rand',
                    'posts_per_page' => -1,
                );
                $featuredmentors = get_terms($args);

                foreach ($featuredmentors as $mentor) {
                    
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

                ?>
                </div>
            </div>
        </section>



</div><!-- Wrapper end -->

<?php get_footer(); ?>
