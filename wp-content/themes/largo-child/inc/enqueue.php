<?php
function lens_typekit() { ?>
	<script type="text/javascript" src="http://use.typekit.net/lcw1yog.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<?php
}
add_action( 'wp_head', 'lens_typekit' );


function lens_cat_icons() {
	$childtheme_dir = get_stylesheet_directory_uri();
	if ( $categories = get_categories() ) :
		echo '<style type="text/css">';
		foreach ( $categories as $category ) {
			if ( file_exists( 'wp-content/themes/largo-child/images/icons/' . $category->slug . '.png' ) ) {
				echo '.' . $category->slug . ' {
					background: url("' . $childtheme_dir . '/images/icons/' . $category->slug . '.png") no-repeat left top;
					line-height: 22px;
					padding: 0 0 5px 30px;
					}
				';
			}
		}
		echo '</style>';
	endif;
}
add_action ( 'wp_head', 'lens_cat_icons' );


function lens_enqueue() {
	wp_enqueue_script( 'largoChildCore', get_stylesheet_directory_uri() . '/js/largoChildCore.js', array( 'jquery' ), '1.0', true );
	if ( is_home() ) {
		wp_enqueue_script( 'bootstrap-carousel', get_template_directory_uri() . '/js/bootstrap-carousel.min.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'carousel-styles', get_stylesheet_directory_uri() . '/css/carousel.css', false, false, 'screen' );
	}
}
add_action( 'wp_enqueue_scripts', 'lens_enqueue' );