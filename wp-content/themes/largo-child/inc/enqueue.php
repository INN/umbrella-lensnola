<?php
/**
 * Functions related to enqueueing stylesheets and scripts and other assets
 */

/**
 * Enqueue Largo child theme CSS
 *
 * This replaces Largo's funciton for doing so.
 *
 * @link https://github.com/INN/largo/blob/v0.6.1/inc/enqueue.php#L103-L123
 */
function largo_enqueue_child_theme_css() {
	$suffix = (LARGO_DEBUG)? '' : '.min';
	wp_enqueue_style(
		'largo-child-styles',
		get_stylesheet_directory_uri() . '/css/style' . $suffix . '.css',
		array( 'largo-stylesheet' ),
		filemtime( get_stylesheet_directory() . '/css/style' . $suffix . '.css' )
	);
}
add_action( 'wp_enqueue_scripts', 'largo_enqueue_child_theme_css', 0, 20 );

/**
 * Enqueue all of our javascript and css files
 *
 * @since 1.0
 */
function largo_child_enqueue_js() {
	wp_enqueue_script( 'largoChildCore', get_stylesheet_directory_uri() . '/js/largoChildCore.js', array( 'jquery' ), '1.0', true );

	//only load sharethis on single pages and load jquery tabs for the related content box if it's active
	if ( is_single() ) {
		if ( of_get_option( 'show_related_content' ) )
			wp_enqueue_script( 'idTabs', get_template_directory_uri() . '/js/jquery.idTabs.js', array( 'jquery' ), '1.0', true );
	}
}
add_action( 'wp_enqueue_scripts', 'largo_child_enqueue_js' );

/**
 * Fonts!
 */
add_action( 'wp_head', function() {
	echo '<link rel="stylesheet" type="text/css" href="https://use.typekit.net/oct0mkd.css" />';
} );

/**
 * Dynamic CSS classes for categories
 */
function largo_child_categories_css() {
	echo '<style type="text/css" id="largo_child_categories_css">';

	// Used to output certain per-category styles
	$what_nowdoc = <<<'EOF'
		.documents {
			background-image: url( '%1$s' );
			background-position:  left top;
			background-repeat: no-repeat;
			line-height: 20px;
			padding: 0 0 5px 30px;
		}
		.squandered-heritage, h5.top-tag .category-squandered-heritage {padding-top: 0!important; line-height: 18px!important;}

EOF;
	printf(
		$what_nowdoc,
		home_url('/wp-content/themes/largo-child/images/icons/documents.png')
	);
	
	// some more per-term spacing
	foreach ( array( 'schools', 'environment', 'investigations', 'criminal_justice' ) as $term ) {
		printf(
			'.%1$s, h5.top-tag .category-%1$s { padding-top: 4px!important; }' . "\n",
			$term
		);
	}
	foreach ( array( 'charterschools', 'government-and-politics' ) as $term ) {
		printf(
			'.%1$s, h5.top-tag .category-%1$s { padding-top: 3px!important; }' . "\n",
			$term
		);
	}

	// Used to output per-category styles
	$category_nowdoc = <<<'EOF'
	%1$s {
		background-image:url('%2$s');
		background-position:  left top;
		background-repeat: no-repeat;
		line-height: 22px;
		padding: 0 0 5px 30px;
	}
EOF;

	$categories = get_categories();
	foreach ($categories as $category) {
		$path = sprintf(
			'/images/icons/%1$s.png',
			$category->slug
		);
		if (file_exists( get_stylesheet_directory() . $path ) ) {
			printf(
				$category_nowdoc,
				sprintf(
					'.%1$s, h5.top-tag .%2$s',
					$category->slug,
					$category->taxonomy . '-' . $category->slug
				),
				get_stylesheet_directory_uri() . $path
			);
		}
	}

	echo '</style>'; 
}
add_action( 'wp_head', 'largo_child_categories_css' );
