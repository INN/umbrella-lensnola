<?php
/*
 * Template Name: Squandered Heritage Archives
 * Description: Shows the Squandered Heritage archive at the bottom of the page.
 */

add_filter('body_class', function($classes) {
	$classes[] = 'classic';
	return $classes;
});

get_header();

?>

<div id="content" class="content-page span8" role="main">
	<?php
		while ( have_posts() ) : the_post();
			$shown_ids[] = get_the_ID();
			get_template_part( 'partials/content-page' );
		endwhile;
	?>

	<div class="content-category stories">
		<header class="category-background clearfix">
			<h5 class="squandered-heritage">
				<span>Squandered Heritage Archives</span>
			</h5>
		</header> <!-- /.category-background -->
		<?php
			$args = array(
				'category_name' => 'squandered-heritage-vintage',
				'paged'			=> $paged,
				'posts_per_page'=> 10,
				'post__not_in' 	=> $shown_ids
				);
			$wp_query = new WP_Query( $args );

			if ( $wp_query->have_posts() ) {
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
					//if the post is in the array of post IDs already on this page, skip it
					if ( in_array( get_the_ID(), $shown_ids ) ) {
						continue;
					} else {
						$ids[] = get_the_ID();
						get_template_part( 'partials/content', 'category' );
					}
				endwhile;
				largo_content_nav( 'nav-below' );
			} else {
				get_template_part( 'partials/content', 'not-found' );
			} ?>
	</div>
</div><!-- /.grid_8 #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
