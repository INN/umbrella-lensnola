<?php


if ( ! defined( 'INN_MEMBER' ) )
	define( 'INN_MEMBER', TRUE || INN_HOSTED );

/**
 * Load up all of the other goodies in the /inc directory
 *
 * @see for more information about the formatting of this, see https://github.com/INN/largo/issues/1494
 */
$includes = array(
	'/inc/widgets.php',
	'/inc/sidebars.php',
	'/inc/enqueue.php',
	'/inc/post-tags.php',
	'/inc/images.php',
	'/inc/header-footer.php',
	'/inc/floating-donate-box.php',
	'/inc/woocommerce.php',
);
foreach ( $includes as $include ) {
	if ( 0 === validate_file( get_stylesheet_directory() . $include ) ) {
		require_once( get_stylesheet_directory() . $include );
	}
}

// Configure CPT-onomies school taxonomy display as list, not autocomplete on post edit
add_filter( 'custom_post_type_onomies_meta_box_format', 'schools_custom_post_type_onomies_meta_box_format', 1, 3 );
function schools_custom_post_type_onomies_meta_box_format( $format, $taxonomy, $post_type ) {
	if ( $taxonomy == 'school' ) return 'checklist';

	// WordPress filters must always return a value
	return $format;
}

// Post navigation attributes
add_filter('next_posts_link_attributes', 'largo_child_next_attr');
function largo_child_next_attr() {
	return 'class="next_link"';
}
add_filter('previous_posts_link_attributes', 'largo_child_prev_attr');
function largo_child_prev_attr() {
	return 'class="prev_link"';
}

add_action( 'wp_loaded', 'largo_child_rewrite_rules' );
function largo_child_rewrite_rules() {
   add_rewrite_rule( '^school/([^\/]+)/feed/?$','index.php?feed=feed&school=$matches[1]&cpt_onomy_archive=1', 'top' );
}

/**
 * Helper to get post parents
 */
function largo_child_get_parents() {
	$parents = array();
	$args=array('orderby' => 'none');
	$terms = wp_get_post_terms( get_the_ID() , 'category', $args);
	foreach($terms as $term) {
	  if ($term->parent == 0) $parents[] = $term;
	}

	return $parents;
}

/**
 * Helper to get a category for a post, as long as it's not the wrong one
 */
function largo_child_get_the_category() {
	$parents = largo_child_get_parents();

	// If nothing, return first category from get_the_category (could be subcategory only)
	if (count($parents) == 0) {
		$category = get_the_category();
		return $category[0];
	}

	if (count($parents) == 1) return $parents[0];

	$unacceptable = array(
		'government-and-politics',
		'investigations',
		'opinion'
	);

	foreach ($parents as $category) {
		if ( ! in_array( $category->slug, $unacceptable ) ) {
			return $category;
		}
	}

	return $parents[0];
}


/**
 * Helper to get all post meta keys from a post
 */
function get_post_meta_all() {
	$meta = array();
	if ( $keys = get_post_custom_keys() ) {
		foreach ( (array) $keys as $key ) {
			$keyt = trim($key);
			if ( is_protected_meta( $keyt, 'post' ) )
					continue;
			$values = array_map('trim', get_post_custom_values($key));
			$meta[$key] = $values[0];
		}
	}

	return $meta;
}

/**
 * Get value from array by key, remove key from array, return value
 */
function consume_meta( $key, &$meta ) {
	$value = $meta[$key];
	unset($meta[$key]);
	return $value;
}

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
	$GLOBALS['current_theme_template'] = basename($t);
	return $t;
}
