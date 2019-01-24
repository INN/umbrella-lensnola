<?php

/**
 * Enqueue all of our javascript and css files
 *
 * @since 1.0
 */
if ( ! function_exists( 'largo_enqueue_js' ) ) {
	function largo_enqueue_js() {

		//the jquery plugins and our main js file
		wp_enqueue_script( 'largoPlugins', get_template_directory_uri() . '/js/largoPlugins.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'largoCore', get_template_directory_uri() . '/js/largoCore.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'largoChildCore', get_stylesheet_directory_uri() . '/js/largoChildCore.js', array( 'jquery' ), '1.0', true );

		//only load the carousel and top stories js and css if those homepage options are selected
		if ( is_home() && of_get_option( 'homepage_top') == 'slider' ) {
			wp_enqueue_script( 'bootstrap-carousel', get_template_directory_uri() . '/js/bootstrap-carousel.min.js', array( 'jquery' ), '1.0', true );
			wp_enqueue_style( 'carousel-styles', get_stylesheet_directory_uri() . '/css/carousel.css', false, false, 'screen' );
		}
		if ( is_home() && of_get_option( 'homepage_top') == 'topstories' )
			wp_enqueue_style( 'topstory-styles', get_template_directory_uri() . '/css/top-stories.css', false, false, 'screen' );

		//only load sharethis on single pages and load jquery tabs for the related content box if it's active
		if ( is_single() ) {
			wp_enqueue_script( 'sharethis', get_template_directory_uri() . '/js/st_buttons.js', array( 'jquery' ), '1.0', true );
			if ( of_get_option( 'show_related_content' ) )
				wp_enqueue_script( 'idTabs', get_template_directory_uri() . '/js/jquery.idTabs.js', array( 'jquery' ), '1.0', true );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'largo_enqueue_js' );
