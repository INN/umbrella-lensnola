<?php
function lens_create_image_sizes() {
	add_image_size( 'carousel', 260, 195, true );
	add_image_size( 'home_left', 110, 80, true );
	add_image_size( 'home_right', 260, 165, true );
	add_image_size( 'category', 185, 140, true );
	add_image_size( 'school', 417, 252, true );
}
add_action( 'after_setup_theme', 'lens_create_image_sizes' );