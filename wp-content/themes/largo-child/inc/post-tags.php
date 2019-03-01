<?php

/**
 * Display navigation to next/previous pages when applicable
 *
 * @since 1.0
 */
if ( ! function_exists( 'largo_content_nav' ) ) {
	function largo_content_nav( $nav_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) : ?>

	<nav id="<?php echo $nav_id; ?>" class="pager post-nav">
		<?php previous_posts_link( __( 'Later Stories', 'largo' ) ); ?>
        <?php next_posts_link( __( 'Earlier Stories', 'largo' ) ); ?>
	</nav><!-- .post-nav -->

		<?php endif;
	}
}

function largo_child_category_link($term,$slug)
{
	if ($slug == "charterschools") return home_url('/charterschools');
	
	return get_category_link($term);
}
