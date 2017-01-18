<?php
/**
 * Single Product Suggested Price, including microdata for SEO
 */

global $product, $WC_Donations;

if ( isset( $_POST['donation'] ) &&  floatval( $_POST['donation'] ) >= 0 ) {

	$num_decimals = ( int ) get_option( 'woocommerce_price_num_decimals' );

	$price = round( floatval( $_POST['donation'] ), $num_decimals );

} elseif ( $product->suggested && floatval( $product->suggested ) > 0 ) {

	$price = $product->suggested;

} elseif ( $product->minimum && floatval( $product->minimum ) > 0 ) {

	$price =  $product->minimum;

} else {

	$price = '';
}

?>

<div class="donation">

	<label for="donation">
		<?php printf( _x( '%s', 'In case you need to change the order of Your Donation ( $currency_symbol )', 'woocommerce' ), get_option( 'woocommerce_donation_label_text', __('Your Donation', 'woocommerce' ) ) ); ?>
	</label>

	<?php echo $WC_Donations->donation_input_helper( esc_attr( $price ), array( 'name'=>'donation' )); ?>

</div>