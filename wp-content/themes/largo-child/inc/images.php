<?php

/**
 * Create custom image sizes used by the largo child theme
 *
 * @since 1.0
 */
function largo_child_create_image_sizes() {
//  add_image_size( 'slideshow', 460, 280, true ); 
//	add_image_size( 'latest', 220, 130, true ); 
//	add_image_size( 'post', 560, 338, true ); 
//	add_image_size( 'side', 120, 80, true ); 
	
	add_image_size( 'carousel', 260, 195, true ); 
	add_image_size( 'home_left', 110, 80, true ); 
	add_image_size( 'home_right', 260, 165, true ); 
	add_image_size( 'category', 185, 140, true ); 
	add_image_size( 'school', 417, 252, true ); 
}
add_action( 'after_setup_theme', 'largo_child_create_image_sizes' );