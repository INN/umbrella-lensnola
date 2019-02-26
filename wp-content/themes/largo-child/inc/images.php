<?php

/**
 * Create custom image sizes used by the largo child theme
 *
 * @since 1.0
 */
function largo_child_create_image_sizes() {
	add_image_size( 'category', 185, 140, true ); 
	add_image_size( 'school', 417, 252, true ); 
}
add_action( 'after_setup_theme', 'largo_child_create_image_sizes' );
