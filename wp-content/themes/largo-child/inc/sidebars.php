<?php

/**
 * Register our sidebars and other widget areas
 *
 * @since 1.0
 */
function largochild_register_sidebars() {

	register_sidebar( array(
		'name' => 'Top Banner (left)',
		'id' => 'top_banner',
		'before_widget' => '<div id="sponsor" class="%2$s">',
		'after_widget' 	=> '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
	
	register_sidebar( array(
		'name' => 'Top Text (right)',
		'id' => 'top_text',
		'before_widget' => '<div id="top_comments" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
		
	register_sidebar( array(
		'name' => 'Top About Section',
		'id' => 'top_about_section',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	
	register_sidebar( array(
		'name' 			=> 'Schools Sidebar',
		'id' 			=> 'sidebar-schools',
		'before_widget' => '<aside id="%1$s" class="%2$s odd_even clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );
}
add_action( 'widgets_init', 'largochild_register_sidebars' );