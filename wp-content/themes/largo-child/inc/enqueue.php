<?php

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
	echo <<<EOF
<script type="text/javascript" src="//use.typekit.net/oct0mkd.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
EOF;
} );

/**
 * Dynamic CSS classes for categories
 */
function largo_child_categories_css() {
		$heredoc = <<<EOF
		<style type="text/css">
			.what-were-reading {
				background-image:url('%1$s');
				background-repeat: no-repeat;
				line-height: 19px;
				padding: 2px 0 3px 25px;
			}
			.schools, .environment, .investigations, .criminal_justice {padding-top: 4px!important;}
			.charterschools, .government-and-politics {padding-top: 3px!important;}
			.squandered-heritage {padding-top: 0!important; line-height: 18px!important;}
			.documents {
				background-image:url('%2$s');
				background-position:  left top;
				background-repeat: no-repeat;
				line-height: 20px;
				padding: 0 0 5px 30px;
			}
EOF;
	printf(
		$heredoc,
		home_url('/wp-content/themes/largo-child/images/icons/government-and-politics.png'),
		home_url('/wp-content/themes/largo-child/images/icons/documents.png')
	);
	$categories = get_categories();
	foreach ($categories as $category) {
		if (file_exists('wp-content/themes/largo-child/images/icons/'.$category->slug.'.png')) {
			echo '.' . $category->slug . " {
				background-image:url('".home_url('/wp-content/themes/largo-child/images/icons/'.$category->slug.'.png')."');
				background-position:  left top;
				background-repeat: no-repeat;
				line-height: 22px;
				padding: 0 0 5px 30px;
				}";
		}
	}
	echo '</style>'; // started in that EOF block.
}
add_action( 'wp_head', 'largo_child_categories_css' );
