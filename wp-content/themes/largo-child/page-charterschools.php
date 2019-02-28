<?php
/*
 * Template Name: Charter Schools
 * Description: Shows the Charter Schools archive and Schools sidebar in a two-column layout.
 */

global $shown_ids;

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
			<h5 class="charterschools">
				<span>Charter Schools</span>
			</h5>
		</header> <!-- /.category-background -->
		<?php
			$args = array(
				'category_name' => 'charterschools',
				'posts_per_page'=> 4,
				'post__not_in' 	=> $shown_ids,
				'paged'			=> $paged
				);
			$wp_query = new WP_Query( $args );

			if ( $wp_query->have_posts() ) {
				while ( $wp_query->have_posts() ) {
					$wp_query->the_post();
					$shown_ids[] = get_the_ID();
					get_template_part( 'partials/content', 'category-no-title' );
				}
				largo_content_nav( 'nav-below' );
			} else {
				get_template_part( 'partials/content', 'not-found' );
			} ?>
	</div>
</div><!-- /.grid_8 #content -->

<?php get_sidebar('schools'); ?>

<?php get_footer(); ?>
