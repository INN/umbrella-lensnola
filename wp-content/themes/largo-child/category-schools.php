<?php
/**
 * The template for displaying Schools Archive pages.
 */

get_header(); 

if ( is_tax() || is_tag() || is_category() ) $term = $wp_query->get_queried_object();
?>

		<div id="content" class="content-category stories span8" role="main">
			<header class="category-background clearfix">
				<h5 class="<?php echo $term->slug;?>">
					<span><?php echo $term->cat_name;?></span>
				</h5>
				<?php
					$category_description = category_description();
					if ( $category_description )
						echo '<div class="category-description">' . $category_description . '</div>';
				?>
			</header> <!-- /.category-background -->
			
			<?php if($paged < 2):?>
				<div class="content-top clearfix">
					
					<div class="category-featured">
						<?php 
						$args = array(
									'category_name' => 'schools',
									'posts_per_page'=> 3,
									'post__not_in' 	=> $ids
									);
						$wp_query = new WP_Query( $args );
	
						if ( $wp_query->have_posts() ) {
							while ( $wp_query->have_posts() ) : $wp_query->the_post();
								//if the post is in the array of post IDs already on this page, skip it
								if ( in_array( get_the_ID(), $ids ) ) {
									continue;
								} else {
									$ids[] = get_the_ID();
									get_template_part( 'partials/content', 'category-no-title' );
								}
							endwhile;
						} else {
							get_template_part( 'partials/content', 'not-found' );
						} ?>
					</div>
					
					<div class="subcategory-featured sub-stories" id="csrc">
						<header>
							<h5 class="charterschools">
								<a href="<?php echo home_url('/charterschools');?>">Charter School Reporting Corps</a>
							</h5>
						</header>
						
						<?php $substories = largo_get_featured_posts( array(
							'tax_query' => array(
								array(
									'taxonomy' 	=> 'prominence',
									'field' 	=> 'slug',
									'terms' 	=> 'charter-featured'
								)
							),
							'showposts'		=> 5,
							'post__not_in' 	=> $ids
						) );
						if ( $substories->have_posts() ) :
							$count = 1;
							while ( $substories->have_posts() ) : $substories->the_post(); $ids[] = get_the_ID();?>
									<div class="story">
										<header>
									 		<h3><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
										</header><!-- / entry header -->
									
										<div class="entry-content">
									        <span class="byline"><?php largo_byline(); ?><span class="smaller_byline_comments">&nbsp;&nbsp;&nbsp;&nbsp;<?php largo_child_comments();?></span><?php edit_post_link( __('Edit This Post', 'largo'), ' <div class="edit-link">', '</div>'); ?></span>
										</div><!-- .entry-content -->
									</div>
							<?php endwhile;
						endif; // end more featured posts ?>
						
						<div class="charter-coverage-link"><span class="directive">&gt;</span> <a href="<?php echo home_url('/charterschools');?>">Complete Charter Schools Coverage</a></div>
					</div>
				</div>
			<?php endif;?>

			<div class="content-main">
            	<?php if ($paged < 2):?> <hr class="schoolmain" /> <?php endif;?>
            	
            	<?php 
					$args = array(
								'category_name' => 'schools',
								'posts_per_page'=> ($paged<2) ? 5 : 10,
								'post__not_in' 	=> $ids,
								'paged'			=> $paged
								);
					$wp_query = new WP_Query( $args );

					if ( $wp_query->have_posts() ) {
						while ( $wp_query->have_posts() ) : $wp_query->the_post();
							//if the post is in the array of post IDs already on this page, skip it
							if ( in_array( get_the_ID(), $ids ) ) {
								continue;
							} else {
								$ids[] = get_the_ID();
								get_template_part( 'partials/content', 'archive' );
							}
						endwhile;
						largo_content_nav( 'nav-below' );
					} else {
						get_template_part( 'partials/content', 'not-found' );
					} ?>
			</div>
		</div>
		<!-- /.grid_8 #content -->

<?php get_sidebar(); ?>

<!-- /.grid_4 -->
<?php get_footer(); ?>
