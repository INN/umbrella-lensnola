<?php
/*
 * Largo awards Widget
 */

class largo_child_awards_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	public function __construct() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' 	=> 'largo-child-awards',
			'description' 	=> __('Show awards', 'largo'),
		);

		/* Create the widget. */
		parent::__construct( 'largo-child-awards-widget', __('Largo Child Awards', 'largo'), $widget_ops );
		$this->alt_option_name = 'largo_child_awards';

		add_action( 'award_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_award_status', array(&$this, 'flush_widget_cache') );
	}

	public function flush_widget_cache() {
		wp_cache_delete('largo_child_awards', 'widget');
	}

	/**
	 * How to display the widget on the screen.
	 */
	public function widget( $args, $instance ) {
		global $awards, $award;

		$cache = wp_cache_get('widget_awards', 'widget');

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

		$awards = get_posts( apply_filters( 'widget_awards_args', array( 'showposts' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'awardtext', 'orderby' => 'rand' ) ) );

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<ul id="awards">';
		if ( $awards ) {
			foreach ( (array) $awards as $award) {
				$output .=  '<div class="award">';
				$output .= '<div class="award-image"><img src="'. get_stylesheet_directory_uri() .'/images/award.png" border="0" /></div>';
				$output .= '<div class="award-text">' . $award->post_title . '</p>';
				$output .= '</div>';
			}
 		}
		$output .= '</ul>';
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_awards', $cache, 'widget');
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
		if ( isset($alloptions['largo_child_awards']) )
			delete_option('largo_child_awards');

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' 			=> '',
			'number'			=> 1,
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
				<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of awards to show:', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" value="<?php echo $number; ?>" size="3" />
			</p>

		<?php
	}
}
