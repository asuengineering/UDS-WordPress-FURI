<?php

/**
 * The template for displaying results from a specific symposium date.
 * Used as an archive listing for all projects in the DB.
 */

get_header();
$term = get_queried_object();
?>

<div class="wrapper" id="page-wrapper">

	<div class="container" id="content">

		<main class="site-main" id="main">

			<div class="row">
				<div class="col-md-12">
					<h1 class="mentor-name"><?php echo $term->name; ?></h1>

					<?php
					$affiliations = available_mentor_affiliations();
					$affiliation = get_field( '_mentor_affiliation', $term );
					$affiliation_label = $affiliations[ $affiliation ];

					$title = get_field( '_mentor_title', $term );

					if ( ! empty( $affiliation ) ) {
						$affiliationString = '<a href="' . $affiliation . '" target=_blank>' . $affiliation_label . '</a>';
					}

					?>

					<h3 class="mentor-info"><?php echo wp_kses_post( $affiliationString ); ?> | <?php echo esc_html( $title ); ?></h2>

				</div>
			</div>

			<div class="row">
				<?php
				/** Get faculty image. Deal with legacy image storage from Carbon Fields.
				 *  Looks for ACF field first, then uses old carbon field meta location as backup.
				 */

				$portrait = get_field( '_mentor_thumbnail', $term );
				$portrait_acf = get_field( '_mentor_acf_thumbnail', $term );

				// Check to see if either is available. If so, output the markup for the column
				if ( ( ! empty( $portrait_acf ) ) || ( ! empty( $portrait ) ) ) {

					echo '<div class="col-md-4">';

					// Check to see if ACF field is populated. If so, display just that.
					// Otherwise check & display the CF image if there's something to display.
					if ( ! empty( $portrait_acf ) ) {
						echo '<img class="acf-image img-fluid" src="' . $portrait_acf . '" alt="Portrait of ' . get_queried_object()->term_name . '"/>';
					} else {
						if ( ! empty( $portrait ) ) {
							echo '<img class="cf-image img-fluid" src="' . $portrait . '" alt="Portrait of ' . get_queried_object()->term_name . '"/>';
						}
					}

					// Social Media Icons for the faculty member
					$mentor_fb = get_field( '_mentor_social_facebook', $term );
					$mentor_li = get_field( '_mentor_social_linkedin', $term );
					$mentor_tw = get_field( '_mentor_social_twitter', $term );
					$mentor_web = get_field( '_mentor_social_website', $term );

					$socialbar = '';

					if ( ! empty( $mentor_tw ) ) {
						$socialbar .= '<li><a href="' . $mentor_tw . '" target=_blank><i class="fab fa-twitter"></i></a></li>';
					}

					if ( ! empty( $mentor_li ) ) {
						$socialbar .= '<li><a href="' . $mentor_li . '" target=_blank><i class="fab fa-linkedin"></i></a></li>';
					}

					if ( ! empty( $mentor_fb ) ) {
						$socialbar .= '<li><a href="' . $mentor_fb . '" target=_blank><i class="fab fa-facebook"></i></a></li>';
					}

					if ( ! empty( $mentor_web ) ) {
						$socialbar .= '<li><a href="' . $mentor_web . '" target=_blank><i class="fas fa-globe"></i></a></li>';
					}

					if ( ! empty( $socialbar ) ) {
						echo '<ul class="social-icons">' . $socialbar . '</ul>';
					}

					echo '</div>';

				}
				?>

				<div class="col-md-8">
					<?php

					echo the_archive_description();
					echo '<p><strong>Total mentored projects: </strong> ' . $wp_query->post_count . '</p>';

					$mentor_isearch = get_field( '_mentor_isearch', $term );
					if ( ! empty( $mentor_isearch ) ) {
						echo '<a class="btn btn-maroon mentor-isearch" href="' . $mentor_isearch . '" target="_blank">iSearch</a>';
					}
					?>

				</div>
			</div>
		</div><!-- end .container -->

		<?php
		$_events = get_terms(
			'symposium_date',
			array(
				'orderby' => 'ID',
				'order' => 'DESC',
			)
		);

		foreach ( $_events as $event ) :

			$event_slug = $event->slug;

			$relatedprojects = new WP_Query(
				array(
					'post_type' => 'furiproject',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'symposium_date',
							'field' => 'slug',
							'terms'    => $event_slug,
						),
						array(
							'taxonomy' => 'faculty_mentor',
							'field'    => 'slug',
							'terms'    => $term->slug,
						),
					),
					'orderby' => '',
				)
			);

			// Grab all related participants from the projects query above.
			p2p_type( 'participants_to_projects' )->each_connected( $relatedprojects, array(), 'relatedparticipants' );

			if ( $relatedprojects->have_posts() ) :
				?>
				<div class="section-head">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<h3><?php echo esc_html( $event->name ); ?></h3>
							</div>
						</div>
					</div>
				</div>
			
				<section class="related-projects">
					<div class="container">
						<div class="row">
			
							<?php

							while ( $relatedprojects->have_posts() ) :
								$relatedprojects->the_post();

								foreach ( $post->relatedparticipants as $related ) :
									setup_postdata( $related );

									$relatedparticipant = furi_participant_name( $related->ID );
									$major = wp_strip_all_tags( get_the_term_list( $related->ID, 'degree_program', '', ', ', '' ) );
									$participantlink = get_permalink( $related->ID );

								endforeach;

								$presentationtype = wp_strip_all_tags( get_the_term_list( $post->ID, 'presentation_type', '', ', ', '' ) );
								$projectimpact = get_field( '_furiproject_impact_statement', $post->ID );
								$projectclassname = get_research_theme_class_names( $post->ID );

								?>
								<div class="col-md-4">
									<div class="card card-hover card-symposium">
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
											<p class="card-text project-type">
												<strong>Program: </strong><?php echo esc_html( $presentationtype ); ?>
											</p>
										</div>
									</div>
								</div>
			
								<?php

							endwhile;

							?>
			
						</div><!-- end .row -->
					</div><!-- end .container -->
				</section><!-- end #related-projects-->
			
				<?php

			endif;
			wp_reset_postdata();
		endforeach;
		?>

	</div><!-- end #main -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
