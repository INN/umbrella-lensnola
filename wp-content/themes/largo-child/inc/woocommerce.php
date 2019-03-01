<?php
/**
 * Functions modifying Woocommerce behavior
 */


/**
 * Something about the woocommerce donation input
 */
function woocommerce_display_donation_input() {
	global $product, $WC_Donations;

	if ( ! empty( $product->donation ) ) $WC_Donations->display_donation_input();
}
add_action( 'woocommerce_before_add_to_cart_button', 'woocommerce_display_donation_input');

/**
 * Custom checkout field
 */
function my_custom_checkout_field($checkout) {
	//echo '<input type="checkbox" id="recur_donate_checkbox" name="recurring_donation" style="float:left; position:relative; top:3px;"><label for="recur_donate_checkbox" style="margin:0 0 10px 50px;">Make this a <b>monthly</b> recurring donation</label>';
	echo '<div id="recur_donate_checkbox" style="margin-top:80px;">';
	woocommerce_form_field('recurring_donation', array(
		'type' => 'checkbox',
		'class' => array('recur_donate_checkbox'),
		'label' => __('Make this a <b>monthly</b> recurring donation<br> <em>To make changes to your monthly donation, please <a href="mailto:amueller@thelensnola.org">e-mail Anne Mueller</a>.</em>')
	), $checkout->get_value('recurring_donation'));
	echo '</div>';
}
add_action('woocommerce_after_order_notes', 'my_custom_checkout_field');


function my_custom_checkout_field_update_order_meta( $order_id ) {
	if ( $_POST['recurring_donation'] ) {
		update_post_meta( $order_id, 'Recurring Donation', esc_attr( $_POST['recurring_donation']) );
	}
}
add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');
