<?php

//ini_set('display_errors','On');
//error_reporting(E_ALL);

/**
 * Setup the Largo child custom widgets
 *
 * @since 1.0
 */

$priority = 11;

// remove Largo widgets that we will override
function largo_child_unregister_widgets() {
	unregister_widget( 'largo_donate_widget' );
	unregister_widget( 'largo_recent_comments_widget' );
	unregister_widget( 'largo_INN_RSS_widget' );
	unregister_widget( 'NS_Widget_MailChimp' );
	unregister_widget( 'WMP_Widget' );
}
add_action( 'widgets_init', 'largo_child_unregister_widgets', $priority );

// load our new widgets
require_once( get_stylesheet_directory() . '/inc/widgets/largo-child-ad-banners.php' );
require_once( get_stylesheet_directory() . '/inc/widgets/largo-child-ad-sidebars.php' );
require_once( get_stylesheet_directory() . '/inc/widgets/largo-child-ad-testimonials.php' );
require_once( get_stylesheet_directory() . '/inc/widgets/largo-child-awards.php' );
require_once( get_stylesheet_directory() . '/inc/widgets/largo-child-donate.php' );
require_once( get_stylesheet_directory() . '/inc/widgets/largo-child-find-school.php' );
require_once( get_stylesheet_directory() . '/inc/widgets/largo-child-recent-comments.php' );
require_once( get_stylesheet_directory() . '/inc/widgets/largo-child-most-popular.php' );
require_once( get_stylesheet_directory() . '/inc/widgets/largo-child-mailchimp.php' );
require_once( get_stylesheet_directory() . '/inc/widgets/largo-child-inn-rss.php' );

// and then register them
function largo_child_load_widgets() {
    register_widget( 'largo_child_ad_banners_widget' );
    register_widget( 'largo_child_ad_sidebars_widget' );
    register_widget( 'largo_child_ad_testimonials_widget' );
    register_widget( 'largo_child_awards_widget' );
    register_widget( 'largo_child_donate_widget' );
    register_widget( 'largo_child_find_school_widget' );
    register_widget( 'largo_child_recent_comments_widget' );
    register_widget( 'largo_child_most_popular' );
    register_widget( 'largo_child_mailchimp' );
    register_widget( 'largo_child_INN_RSS_widget' );
}
add_action( 'widgets_init', 'largo_child_load_widgets' );