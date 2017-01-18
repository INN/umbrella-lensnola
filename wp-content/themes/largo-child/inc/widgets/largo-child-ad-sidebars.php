<?php
/*
 * Largo ad sidebars Widget
 */

class largo_child_ad_sidebars_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function largo_child_ad_sidebars_widget() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' 	=> 'largo-child-ad-sidebars',
			'description' 	=> __('Show ad sidebars', 'largo'),
		);

		/* Create the widget. */
		$this->WP_Widget( 'largo-child-ad-sidebars-widget', __('Largo Child Ad Sidebars', 'largo'), $widget_ops );
		$this->alt_option_name = 'largo_child_ad_sidebars';

		add_action( 'ad_sidebar_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_ad_sidebar_status', array(&$this, 'flush_widget_cache') );
	}

	function flush_widget_cache() {
		wp_cache_delete('largo_child_ad_sidebars', 'widget');
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		global $adSidebars, $adSidebar;

		$cache = wp_cache_get('largo_child_ad_sidebars', 'widget');

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

		$adsidebars = get_posts( apply_filters( 'largo_child_ad_sidebars_args', array( 'showposts' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'ad300', 'orderby' => 'rand' ) ) );

		$widget_class = !empty($instance['widget_class_secondary']) ? $instance['widget_class_secondary'] : '';

		/* Add the widget class to $before widget, used as a style hook */
		if( strpos($before_widget, 'class') === false ) {
			$before_widget = str_replace('>', 'class="'. $widget_class . '"', $before_widget);
		}
		else {
			$before_widget = str_replace('class="', 'class="'. $widget_class . ' ', $before_widget);
		}

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		if ( $adsidebars ) {
			foreach ( (array) $adsidebars as $adsidebar) {
				$output .=  $adsidebar->post_content;
			}
 		}
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('largo_child_ad_sidebars', $cache, 'widget');
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
		if ( isset($alloptions['largo_child_ad_sidebars']) )
			delete_option('largo_child_ad_sidebars');

		$instance['widget_class_secondary'] = $new_instance['widget_class_secondary'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' 			=> '',
			'number'			=> 1,
			'widget_class_secondary' => ''
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
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of ad sidebars to show:', 'largo'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'widget_class_secondary' ); ?>"><?php _e('Widget Class', 'largo'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('widget_class_secondary'); ?>" name="<?php echo $this->get_field_name('widget_class_secondary'); ?>" value="<?php echo esc_attr( $instance['widget_class_secondary'] ); ?>" />
		</p>

	<?php
	}
}