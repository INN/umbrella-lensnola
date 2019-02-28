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
