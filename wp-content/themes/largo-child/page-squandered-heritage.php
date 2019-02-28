<?php
/*
Template Name: Best Of Squandered Heritage
*/

get_header(); ?>

<div id="content" class="content-page span8" role="main">
	<?php the_post(); ?>
	<?php get_template_part( 'partials/content', 'page' ); ?>

	<div class="content-category stories">
		<?php
			$args = array(
				'category_name' => 'best-of-squandered-heritage-vintage',
				'paged'			=> $paged,
				'posts_per_page'=> 10,
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
						get_template_part( 'partials/content', 'no-title' );
					}
				endwhile;
				largo_content_nav( 'nav-below' );
			} else {
				get_template_part( 'partials/content', 'not-found' );
			} ?>
	</div>
</div><!-- /.grid_8 #content -->
<div id="sidebar" class="span4">
	<?php get_sidebar(); ?>
</div>
<!-- /.grid_4 -->
<?php get_footer(); ?>
