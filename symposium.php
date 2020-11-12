<?php
/**
 * Template Name: Symposium Archive
 *
 * @package uds-wordpress-theme
 */

get_header();
?>

<!-- Markup for the page -->
<div class="wrapper" id="page-wrapper">
	<div class="container" id="main-content">
		<div class="row">

			<div class="col-lg-9 order-2">
				<div class="row" id="symposium-grid">

					<?php
					$term_ids = get_active_symposium_terms();

					// Separate query arguments for a few of the select box terms.
					$filterargs = '';
					$filterargs = array(
						'post_type' => 'furiproject',
						'posts_per_page' => -1,
						'fields' => 'ids',
						'tax_query' => array(
							array(
								'taxonomy' => 'symposium_date',
								'terms'    => $term_ids,
							),
						),
					);


					// The actual query.
					$args = '';
					$featured = new WP_Query( $args );

					$args = array(
						'post_type' => 'furiproject',
						'posts_per_page' => -1,
						'tax_query' => array(
							array(
								'taxonomy' => 'symposium_date',
								'terms'    => $term_ids,
							),
						),
						'orderby' => 'rand',
					);

					$query = new WP_Query( $args );

					p2p_type( 'participants_to_projects' )->each_connected( $query );

					// The Loop.
					if ( $query->have_posts() ) {

						$titleselect = '';
						$participantselect = '';

						while ( $query->have_posts() ) {
							$query->the_post();

							$project_classes = 'project-' . $post->ID . ' ';
							$titleselect .= '<option value=".' . $project_classes . '">' . get_the_title() . '</option>';
							$project_classes .= asufse_symposium_tax_filteritem_classes();

							$projecttitle = get_the_title();
							$projectexcerpt = get_the_excerpt();
							$projectimpact = get_field( '_furiproject_impact_statement' );
							$projectlink = get_the_permalink();

							$researchtheme = wp_strip_all_tags( get_the_term_list( $post->ID, 'research_theme', '', ', ', '' ) );
							$mentorlist = get_the_term_list( $post->ID, 'faculty_mentor', '', ', ', '' );
							$presentationtype = wp_strip_all_tags( get_the_term_list( $post->ID, 'presentation_type', '', ', ', '' ) );
							$symposiumdate = wp_strip_all_tags( get_the_term_list( $post->ID, 'symposium_date', '', ', ', '' ) );

							// Link destination for each project. Set all at once according to the symposium it belongs to.
							$thissymposium = '';
							$thissymposium = get_the_terms( $post->ID, 'symposium_date' );

							$presentationtype = wp_strip_all_tags( get_the_term_list( $post->ID, 'presentation_type', '', ', ', '' ) );
							$projectimpact = get_field( '_furiproject_impact_statement', $post->ID );
							$projectclassname = get_research_theme_class_names( $post->ID );

							// Get Connected particpant data and assign variables.
							foreach ( $post->connected as $post ) :
								setup_postdata( $post );

								$relatedparticipant = furi_participant_name( $post->ID );
								$participantlink = get_the_permalink();
								$major = wp_strip_all_tags( get_the_term_list( $post->ID, 'degree_program', '', ', ', '' ) );

								$program = wp_strip_all_tags( get_the_term_list( $post->ID, 'degree_program', '', ', ', '' ) );

								$participant_classes = 'participant-' . $post->ID . ' ';
								$participantselect .= '<option value=".' . $participant_classes . '">' . get_field( '_participant_last_name' ) . ', ' . get_field( '_participant_first_name' ) . '</option>';
								$participant_classes .= asufse_symposium_tax_filteritem_classes();

								$participant_ids[] = $post->ID;

							endforeach;

							wp_reset_postdata(); // Set $post back to original post.

							// Output a single card with correct classes for filtering.
							?>
							<div class="col-md-4 grid-item <?php echo esc_html( $project_classes . $participant_classes ); ?>">
								<div class="card card-hover card-symposium">
									<div class="card-header <?php echo esc_html( $projectclassname ); ?>">
										<h4 class="participant"><?php echo esc_html( $relatedparticipant ); ?></h3>
										<h5 class="major"><?php echo esc_html( $major ); ?></h5>
									</div>
									<div class="card-body">
										<h5 class="card-title">
											<a href="<?php echo esc_url( $participantlink ); ?>" rel="bookmark">
												<?php echo esc_html( $projecttitle ); ?>
											</a>
										</h5>
										<p class="card-text"><?php echo esc_html( $projectimpact ); ?></p>
										<p class="card-text project-mentor">
											<strong>Mentor: </strong><?php echo wp_kses_post( $mentorlist ); ?>
										</p>
										<p class="card-text project-type">
											<strong>Program: </strong><?php echo esc_html( $presentationtype ); ?>
										</p>
									</div>
								</div>
							</div>
							<?php

						} // end while.
					}
					// Restore original post data.
					wp_reset_postdata();

					?>
				</div><!-- end #symposium-grid -->
			</div><!-- end col-md-8 -->

			<div class="col-lg-3 order-1">
				<div class="above-filters">
					<h4 class="symposium-date">
						<?php echo esc_html( get_active_symposium_names() ) . ' Symposium'; ?>
					</h4>
					<p><?php echo esc_html( $query->found_posts ); ?> projects</p>
				</div>
				<div class="filter-group">
					<div class="filter-container">
						
						<form class="form-inline">
							<!-- <label data-placeholder="Search for a Participant" for="filter-participant">Participant Name</label> -->
							<select id="filter-participant" class="filter" multiple title="Select a participant.">
								<?php echo $participantselect; ?>
							</select>
						</form>

						<form class="form-inline">
							<!-- <label for="filter-titles">Project Title</label> -->
							<select id="filter-titles" class="filter" multiple title="Select a project.">
								<?php echo $titleselect; ?>
							</select>
						</form>
					   
						<form class="form-inline">
							<!-- <label for="filter-degree_program">Degree Program</label> -->
							<?php echo get_all_participant_tax_terms( $participant_ids, 'degree_program', 'degree program.' ); ?>
						</form>
						
						<form class="form-inline">
							<!-- <label for="filter-faculty_mentor">Faculty Mentor</label> -->
							<?php echo get_all_project_tax_terms( $filterargs, 'faculty_mentor', 'faculty mentor.' ); ?>
						</form>
						
						<form class="form-inline">
							<!-- <label for="filter-symposium_group">Symposium Group</label> -->
							<?php echo get_all_project_tax_terms( $filterargs, 'symposium_group', 'symposium group.' ); ?>
						</form>

						<form id="presentation-type-filters">
							<label for="filter-presentation_type">Presentation Type</label>
							<?php echo get_project_type_radios( $filterargs, 'presentation_type', 'Presentation Type' ); ?>
						</form>
						
						<form id="research-theme-filters">
							<label for="filter-research_theme">Research Theme</label>
							<?php echo get_research_theme_radios( $filterargs, 'research_theme', 'Research Theme' ); ?>
						</form>

					</div>
				</div><!-- end .filter-group -->
			</div><!-- end .col -->

		</div><!-- end .row -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
