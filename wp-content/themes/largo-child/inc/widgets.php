<?php
function lens_widgets() {
	$unregister = array(
		'largo_recent_comments_widget',
		'largo_INN_RSS_widget',
		'WMP_Widget'
	);
	foreach ( $unregister as $widget ) {
		unregister_widget( $widget );
	}
	$register = array(
		'largo_child_ad_banners_widget'			=> '/inc/widgets/largo-child-ad-banners.php',
		'largo_child_ad_sidebars_widget'		=> '/inc/widgets/largo-child-ad-sidebars.php',
		'largo_child_ad_testimonials_widget'	=> '/inc/widgets/largo-child-ad-testimonials.php',
		'largo_child_awards_widget' 			=> '/inc/widgets/largo-child-awards.php',
		'largo_child_find_school_widget'		=> '/inc/widgets/largo-child-find-school.php',
		'largo_child_recent_comments_widget'	=> '/inc/widgets/largo-child-recent-comments.php',
		'largo_child_most_popular'				=> '/inc/widgets/largo-child-most-popular.php',
		'largo_child_INN_RSS_widget'			=> '/inc/widgets/largo-child-inn-rss.php'
	);
	foreach ( $register as $key => $val ) {
		require_once( get_stylesheet_directory() . $val );
		register_widget( $key );
	}
}
add_action( 'widgets_init', 'lens_widgets', 11 );