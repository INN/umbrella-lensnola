<?php
/**
 * Load up all of the stuff in the /inc directory
 */
$includes = array(
	'/inc/widgets.php',
	'/inc/sidebars.php',
	'/inc/post-tags.php',
	'/inc/images.php',
	'/inc/enqueue.php'
);
foreach ( $includes as $include ) {
	require_once( get_stylesheet_directory() . $include );
}



function get_current_template( $echo = false ) {
    if( !isset( $GLOBALS['current_theme_template'] ) )
        return false;
    if( $echo )
        echo $GLOBALS['current_theme_template'];
    else
        return $GLOBALS['current_theme_template'];
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

function largo_child_comments() {
	if (get_comments_number() >= 1) {
		echo '<a href="';
		the_permalink();
		echo '#comments">';
		comments_number('No comments','1 comment','% comments');
		echo '</a>';
	}
}

function largo_child_get_parents() {
	$parents = array();
	$args=array('orderby' => 'none');
	$terms = wp_get_post_terms( get_the_ID() , 'category', $args);
	foreach($terms as $term) {
	  if ($term->parent == 0) $parents[] = $term;
	}

	return $parents;
}

function largo_child_get_the_category() {
	$parents = largo_child_get_parents();

	// If nothing, return first category from get_the_category (could be subcategory only)
	if (count($parents) == 0) {
		$category = get_the_category();
		return $category[0];
	}

	if (count($parents) == 1) return $parents[0];

	$unacceptable = array('government-and-politics','investigations','opinion');

	foreach ($parents as $category) {
		if (!in_array($category->slug,$unacceptable)) return $category;
	}

	return $parents[0];
}

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

function consume_meta($key,&$meta) {
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

function preg_array_key_exists($pattern, $array) {
    $keys = array_keys($array);
    return (int) preg_grep($pattern,$keys);
}

add_action( 'woocommerce_before_add_to_cart_button', 'woocommerce_display_donation_input');

function woocommerce_display_donation_input() {
	global $product, $WC_Donations;

	if ( ! empty( $product->donation ) ) $WC_Donations->display_donation_input();
}

add_action('woocommerce_after_order_notes', 'my_custom_checkout_field');

function my_custom_checkout_field($checkout) {
	echo '<div id="recur_donate_checkbox" style="margin-top:80px;">';
	woocommerce_form_field('recurring_donation', array(
		'type' => 'checkbox',
		'class' => array('recur_donate_checkbox'),
		'label' => __('Make this a <b>monthly</b> recurring donation<br> <em>To make changes to your monthly donation, please <a href="mailto:amueller@thelensnola.org">e-mail Anne Mueller</a>.</em>')
	), $checkout->get_value('recurring_donation'));
	echo '</div>';
}

add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');

function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ($_POST['recurring_donation']) update_post_meta( $order_id, 'Recurring Donation', esc_attr($_POST['recurring_donation']));
}

function change_argo_rss_link($link) {
    $post_id = get_the_ID();
    if(get_post_type($post_id) == 'argolinks') {
	    $link = get_post_meta($post_id, "argo_link_url", true);
    }
   	return $link;
}
add_filter('the_permalink_rss','change_argo_rss_link');



/**
 * Intended to override add_largo_mce_plugin().
 * 
 * Override $plugin_array['modulize'] set by Largo to a newer version 
 * of the script until Largo is upgraded. Necessary because of a 
 * WP core update of tinymce.
 * 
 * Changes to tinymce.js script can be seen here:
 * @see https://github.com/INN/Largo/commit/3a465b1bfab9b97c867f857f075dc5d44cb24866
 * 
 */
function add_nola_mce_plugin( $plugin_array ) {

	$plugin_array['modulize'] = get_stylesheet_directory_uri() . '/js/tinymce/plugins/largo/editor_plugin.js';
	return $plugin_array;

}

/**
 * Intended to extend largo_add_mce_buttons().
 * 
 * Register our hook in the appropriate place and time.
 * 
 */
function nola_add_mce_buttons() {
	if ( get_user_option( 'rich_editing' ) == 'true' ) {
		add_filter( 'mce_external_plugins', 'add_nola_mce_plugin', 5 );
	}
}
add_action( 'init', 'nola_add_mce_buttons' );

