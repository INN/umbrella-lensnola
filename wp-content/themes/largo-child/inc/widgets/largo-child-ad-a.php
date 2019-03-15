<?php
/*
 * Largo ad testimonials Widget
 */

class largo_child_ad_testimonials_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	public function __construct() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' 	=> 'largo-child-ad-testimonials',
			'description' 	=> __('Show ad testimonials', 'largo'),
		);

		/* Create the widget. */
		parent::__construct( 'largo-child-ad-testimonials-widget', __('Largo Child Ad Testimonials', 'largo'), $widget_ops );
		$this->alt_option_name = 'largo_child_ad_testimonials';

		add_action( 'ad_testimonial_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_ad_testimonial_status', array(&$this, 'flush_widget_cache') );
	}

	public function flush_widget_cache() {
		wp_cache_delete('largo_child_ad_testimonials', 'widget');
	}

	/**
	 * How to display the widget on the screen.
	 */
	public function widget( $args, $instance ) {
		global $adtestimonials, $adtestimonial;

		$cache = wp_cache_get('widget_ad_testimonial', 'widget');

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

		$adtestimonials = get_posts( apply_filters( 'widget_ad_testimonials_args', array( 'showposts' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'topbox', 'orderby' => 'rand' ) ) );

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		if ( $adtestimonials ) {
			foreach ( (array) $adtestimonials as $adtestimonial) {	
				$output .= '<div class="testimonial_content">';
				$output .=  $adtestimonial->post_content;
				$output .= '</div>';
				$output .= '<div class="testimonial_author">';
				$output .=  $adtestimonial->post_title;
				$output .= '</div>';
			}
 		}
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_ad_testimonials', $cache, 'widget');
	}

	/**
	 * Update the widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = absint( $new_instance['number'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['largo_child_ad_testimonials']) ) {
			delete_option('largo_child_ad_testimonials');
		}

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title'  => '',
			'number' => 1,
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = strip_tags($instance['title']);
		$number = isset($instance['number']) ? absint($instance['number']) : 5;

		?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'largo'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:90%;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of ad testimonials to show:', 'largo'); ?></label>
				<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" value="<?php echo $number; ?>" size="3" />
			</p>

		<?php
	}
}
