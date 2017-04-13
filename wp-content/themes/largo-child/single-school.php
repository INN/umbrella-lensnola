<?php
/**
 * The template for displaying Schools Archive pages.
 */

get_header();

$postmeta = get_post_meta_all();
consume_meta('wpcf-_school_state_rating',$postmeta);	// not used
$grades = array('A-plus'=>'A+',
				'A'=>'A',
				'A-minus'=>'A-',
				'B-plus'=>'B+',
				'B'=>'B',
				'B-minus'=>'B-',
				'C-plus'=>'C+',
				'C'=>'C',
				'C-minus'=>'C-',
				'D-plus'=>'D+',
				'D'=>'D',
				'D-minus'=>'D-',
				'F-plus'=>'F+',
				'F'=>'F',
				'F-minus'=>'F-');
?>

		<div id="content" class="content-category stories span8" role="main">
			<header class="category-background clearfix">
				<h5 class="single_school">
					Charter School
				</h5>
			</header> <!-- /.category-background -->

			<h2 class="school"><?php echo the_title();?></h2>
			<h3 class="governed_by">Governed by <?php echo consume_meta('wpcf-_schoolboard_name',$postmeta);?></h3>

			<div class="school-meta clearfix">
				<?php if (has_post_thumbnail()):?>
				<div class="left-box image-container"><?php the_post_thumbnail('school'); ?></div>
				<?php endif;?>

				<?php if ($postmeta['wpcf-_school_street_address'] || $postmeta['wpcf-_school_zip']):?>
				<div class="right-box image-container">
					<a href="<?php echo consume_meta('wpcf-_school_map_code',$postmeta);?>"><img src="http://maps.googleapis.com/maps/api/staticmap?zoom=13&size=417x252&maptype=roadmap&markers=color:redmarkers=size:tiny%7C<?php echo urlencode($postmeta['wpcf-_school_street_address'].'+'.$postmeta['wpcf-_school_zip']);?>&sensor=false" /></a>
				</div>
				<?php endif;?>

				<div class="clearfix"></div>
				<?php if ($postmeta['wpcf-_state_report_card']):?>
					<div class="left-box grey">
						<div class="content-container">
							<div class="report-card-label">Report Card Grade
                                <div class="help">
                                    <a href="<?php echo home_url('/how-to-understand-school-performance-scores-and-grades');?>">What does this mean?</a>
                                </div>
                            </div>
                            <div id="grade_container">
								<span class="report-card-grade"><?php echo (key_exists($postmeta['wpcf-_state_report_card'],$grades)) ? $grades[consume_meta('wpcf-_state_report_card',$postmeta)] : consume_meta('wpcf-_state_report_card',$postmeta);?></span>
                        	</div>
						</div>
					</div>
				<?php endif;?>

				<div class="right-box grey">
					<div class="content-container">
						<h5>Main Office</h5>
                     	<div class="school-address">
						<?php if ($postmeta['wpcf-_school_street_address']):?>
							<div class="street-address"><?php echo consume_meta('wpcf-_school_street_address',$postmeta);?></div>
						<?php endif;?>
						<?php if ($postmeta['wpcf-_school_zip']):?>
							<div class="zip"><?php echo consume_meta('wpcf-_school_zip',$postmeta);?></div>
						<?php endif;?>
                        	<div class="social">
								<?php if ($postmeta['wpcf-_school_facebook']):?>
									<a href="<?php echo consume_meta('wpcf-_school_facebook',$postmeta);?>">
                                    	<img src="<?php bloginfo('stylesheet_directory'); ?>/images/fb_icon_white.png" /></a>
								<?php endif;?>

								<?php if ($postmeta['wpcf-_school_twitter']):?>
									<a href="<?php echo consume_meta('wpcf-_school_twitter',$postmeta);?>">
                                    <img src="<?php bloginfo('stylesheet_directory'); ?>/images/twitter_icon_white.png" /></a>
								<?php endif;?>
							</div>
                        </div>

						<?php if ($postmeta['wpcf-_school_phone']):?>
							<div class="phone"><?php echo consume_meta('wpcf-_school_phone',$postmeta);?></div>
						<?php endif;?>

						<?php if ($postmeta['wpcf-_school_web_address']):?>
							<div class="website">
								<a href="<?php echo consume_meta('wpcf-_school_web_address',$postmeta);?>">
									website
								</a>
							</div>
						<?php endif;?>

						<?php if ($postmeta['wpcf-_school_facebook'] || $postmeta['wpcf-_school_twitter']):?>

						<?php endif;?>
					</div>
				</div>

				<div class="clearfix"></div>
				<div class="left-box">
					<?php if ($postmeta['wpcf-_school_years']):?>
						<div class="grades">
							<h5>Grades Served</h5>
							<?php echo consume_meta('wpcf-_school_years',$postmeta);?>

                            <?php if ($postmeta['wpcf-_school_enrollment']):?>
								<div class="enrollment">
								<h5>Enrollment</h5>
							<?php echo consume_meta('wpcf-_school_enrollment',$postmeta);?>
						</div>
					<?php endif;?>
						</div>
					<?php endif;?>

					<?php if ($postmeta['wpcf-_school_perf_score']):?>
						<div class="perf_score">
							<h5>School Performance Score</h5>
							<?php echo consume_meta('wpcf-_school_perf_score',$postmeta);?>
						</div>
					<?php endif;?>
					<?php if ($postmeta['wpcf-_school_prev_perf_score']):?>
						<div class="prev_perf_score">
							<h6>Previous School Performance Score</h6>
							<?php echo consume_meta('wpcf-_school_prev_perf_score',$postmeta);?>

					<div class="help">
						<a href="<?php echo home_url('/how-to-understand-school-performance-scores-and-grades');?>">What does this mean?</a>
					</div>
						</div>
					<?php endif;?>

				</div>
				<div class="right-box">
					<?php $foundMore=false;?>
					<?php foreach ($postmeta as $key => $value):?>
						<?php if (strpos($key,'wpcf-') !== false && $value):?>
							<?php $foundMore=true;?>
							<?php break;?>
						<?php endif;?>
					<?php endforeach;?>

					<?php if ($foundMore):?>
						<h5>More about this school</h5>
						<ul class="directives">
							<?php if ($postmeta['wpcf-_charter_application']):?>
								<li>
									<a href="<?php echo consume_meta('wpcf-_charter_application',$postmeta);?>">
										Charter Application
									</a>
								</li>
							<?php endif;?>

							<?php if ($postmeta['wpcf-_charter_contract']):?>
								<li>
									<a href="<?php echo consume_meta('wpcf-_charter_contract',$postmeta);?>">
										Charter Contract
									</a>
								</li>
							<?php endif;?>

							<?php if ($postmeta['wpcf-_student_handbook']):?>
								<li>
									<a href="<?php echo consume_meta('wpcf-_student_handbook',$postmeta);?>">
										Student Handbook
									</a>
								</li>
							<?php endif;?>

							<?php foreach ($postmeta as $key => $value):?>
								<?php if (strpos($key,'wpcf-') !== false && $value):?>
									<li id="<?php echo $key;?>"><?php echo consume_meta($key,$postmeta);?></li>
								<?php endif;?>
							<?php endforeach;?>
						</ul>
					<?php endif;?>
				</div>
			</div>

			<div class="content-main">
				<?php
					$args = array(
						'meta_key' => '_custom_post_type_onomies_relationship',
						'meta_value' => get_the_ID(),
						'post_type'		=> 'post',
						'posts_per_page' => -1
					);
					$wp_query = new WP_Query($args);
					if ( $wp_query->have_posts() ) :
						while ( $wp_query->have_posts() ) : $wp_query->the_post(); $ids[] = get_the_ID();
								get_template_part( 'content', 'category' );
						endwhile;
						//largo_content_nav( 'nav-below' );
					endif; // end more featured posts ?>
			</div>
		</div>
		<!-- /.grid_8 #content -->
		<div id="sidebar" class="span4">
			<?php get_sidebar('schools'); ?>
		</div>

<!-- /.grid_4 -->
<?php get_footer(); ?>
