<?php
/*
 * Largo ad banners Widget
 */

class largo_child_ad_banners_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function largo_child_ad_banners_widget() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' 	=> 'largo-child-ad-banners',
			'description' 	=> __('Show ad banners', 'largo'),
		);

		/* Create the widget. */
		$this->WP_Widget( 'largo-child-ad-banners-widget', __('Largo Child Ad Banners', 'largo'), $widget_ops );
		$this->alt_option_name = 'largo_child_ad_banners';

		add_action( 'ad_banner_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_ad_banner_status', array(&$this, 'flush_widget_cache') );
	}

	function flush_widget_cache() {
		wp_cache_delete('largo_child_ad_banners', 'widget');
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		global $adBanners, $adBanner;

		$cache = wp_cache_get('widget_ad_banner', 'widget');

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		extract( $args );
		$output = '';
		$title = apply_filters('widget_title', $instance['title'] );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 1;

		$adBanners = get_posts( apply_filters( 'widget_ad_banners_args', array( 'showposts' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'ad728', 'orderby' => 'rand' ) ) );

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		if ( $adBanners ) {
			foreach ( (array) $adBanners as $adBanner) {
				$output .=  $adBanner->post_content;
			}
 		}
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_ad_banners', $cache, 'widget');
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = absint( $new_instance['number'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['largo_child_ad_banners']) )
			delete_option('largo_child_ad_banners');

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' 			=> '',
			'number'			=> 1
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = strip_tags($instance['title']);
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:90%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of ad banners to show:', 'largo'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

	<?php
	}
}