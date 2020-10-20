<?php
/**
 * Single Furi Participant
 *
 * @package uds-wordpress-theme
 */

get_header();
?>

<div class="wrapper" id="single-wrapper">

	<div class="container" id="content" tabindex="-1">

		<main class="site-main" id="main">

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();
				?>

				<div class="row">

					<?php
					if ( has_post_thumbnail() ) {
						echo '<div class="col-md-4 order-md-first order-last" id="sidebar" role="secondary" tabindex="-1">';
						echo get_the_post_thumbnail( $post->ID, 'full' );
					}
					?>

				</div><!-- #primary -->

				<div class="col order-md-last order-first" id="content" role="primary">

					<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<header class="entry-header">
							<?php
								$first = get_field( '_participant_first_name' );
								$middle = get_field( '_participant_middle_name' );
								$last = get_field( '_participant_last_name' );
								$suffix = get_field( '_participant_suffix' );
								$hometown = asufse_symposium_get_location_details();

								// Append spaces if not blank. Assume there's always a last name.
							if ( ! empty( $first ) ) {
								$first .= ' ';
							}

							if ( ! empty( $middle ) ) {
								$middle .= ' ';
							}

							if ( ! empty( $suffix ) ) {
								$suffix .= ' ';
							}

								echo '<h1 class="participant-name">' . $first . $middle . $last . ' ' . $suffix . '</h1>';
								echo '<div class="info-bar">';
								echo '<strong>Hometown: </strong>' . $hometown . ' | ';
								echo '<strong>Graduation Date: </strong>' . wp_strip_all_tags( get_the_term_list( $post->ID, 'graduation_date', '', ', ', '' ) );
								echo '</div>';

								$major = '<div class="participant-major">' . wp_strip_all_tags( get_the_term_list( $post->ID, 'degree_program', '', ', ', '' ) ) . '</div>';

								$participant_fb = get_field( '_participant_facebook' );
								$participant_li = get_field( '_participant_linkedin' );
								$participant_tw = get_field( '_participant_twitter' );
								$participant_ig = get_field( '_participant_instagram' );

								$participantsocial = '';

							if ( ! empty( $participant_tw ) ) {
								$participantsocial .= '<li><a href="' . $participant_tw . '" target=_blank><i class="fab fa-twitter"></i></a></li>';
							}

							if ( ! empty( $participant_li ) ) {
								$participantsocial .= '<li"><a href="' . $participant_li . '" target=_blank><i class="fab fa-linkedin"></i></a></li>';
							}

							if ( ! empty( $participant_fb ) ) {
								$participantsocial .= '<li><a href="' . $participant_fb . '" target=_blank><i class="fab fa-facebook"></i></a></li>';
							}

							if ( ! empty( $participant_ig ) ) {
								$participantsocial .= '<li><a href="' . $participant_ig . '" target=_blank><i class="fab fa-instagram"></i></a></li>';
							}

							if ( ! empty( $participantsocial ) ) {
								$participantsocial = '<ul class="participant-social">' . $participantsocial . '</ul>';
							}

							?>
						</header>

						<!-- Where are they now content goes here.  -->

						<div class="latest-project entry-content p-3">

							<?php echo $major; ?>

							<?php
								// Find connected projects
								$firstconnected = new WP_Query(
									array(
										'connected_type' => 'participants_to_projects',
										'connected_items' => get_queried_object(),
										'posts_per_page' => 1,
									)
								);

								// Display connected projects with greater detail.
							if ( $firstconnected->have_posts() ) :
								while ( $firstconnected->have_posts() ) :
									$firstconnected->the_post();

									$symposiumdate = wp_strip_all_tags( get_the_term_list( $post->ID, 'symposium_date', '', ', ', '' ) );
									$presentationtype = wp_strip_all_tags( get_the_term_list( $post->ID, 'presentation_type', '', ', ', '' ) );
									$facultymentor = get_the_term_list( $post->ID, 'faculty_mentor', '', ', ', '' );
									$researchtheme = wp_strip_all_tags( get_the_term_list( $post->ID, 'research_theme', '', ', ', '' ) );
									?>
									<div class="project-info">
										<h2 class="project-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
										<div class="project-mentor"><strong>Mentor: </strong><?php echo $facultymentor; ?></div>
										<div class="project-theme"><strong>Research Theme: </strong><?php echo $researchtheme; ?></div>
										<div class="project-meta"><strong><?php echo $presentationtype; ?>: </strong><?php echo $symposiumdate; ?></div>
										<?php the_content(); ?>
										<?php echo $participantsocial; ?>
									</div>

									<?php
							endwhile;

								wp_reset_postdata();

								endif;
							?>
						</div><!-- end .entry-content -->

						<?php

							// Find the rest of the connected projects.
							$otherconnected = new WP_Query(
								array(
									'connected_type' => 'participants_to_projects',
									'connected_items' => get_queried_object(),
									'posts_per_page' => 10,
									'offset' => 1,
								)
							);

						if ( $otherconnected->have_posts() ) :
							?>
							<div class="entry-content other-projects p-3">
								<div class="participant-major">Other Projects</div>

								<?php
								while ( $otherconnected->have_posts() ) :
									$otherconnected->the_post();

									$symposiumdate = wp_strip_all_tags( get_the_term_list( $post->ID, 'symposium_date', '', ', ', '' ) );
									$presentationtype = wp_strip_all_tags( get_the_term_list( $post->ID, 'presentation_type', '', ', ', '' ) );
									$facultymentor = get_the_term_list( $post->ID, 'faculty_mentor', '', ', ', '' );
									?>

									<div class="project-info">
										<h2 class="project-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
										<div class="project-mentor"><strong>Mentor: </strong><?php echo $facultymentor; ?></div>
										<div class="project-theme"><strong>Research Theme: </strong><?php echo $researchtheme; ?></div>
										<div class="project-meta"><strong><?php echo $presentationtype; ?>: </strong><?php echo $symposiumdate; ?></div>
										<?php the_content(); ?>
									</div>
									<?php
									endwhile;

									echo '</div></div>';

									wp_reset_postdata();

								endif;
						?>

							</div><!-- end .row -->
							</footer>

					</article><!-- #post-## -->
				</div><!-- end col -->
				<?php
			endwhile; // end of the loop.
			?>
	</div><!-- end #main -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
