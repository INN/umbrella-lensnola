<?php
/*
 * Largo recent-comments Widget
 */

class largo_child_recent_comments_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	public function __construct() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' 	=> 'largo-recent-comments',
			'description' 	=> __('Show recent comments', 'largo'),
		);

		/* Create the widget. */
		parent::__construct( 'largo-recent-comments-widget', __('Largo Child Recent Comments', 'largo'), $widget_ops );
		$this->alt_option_name = 'largo_recent_comments';

		add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array(&$this, 'flush_widget_cache') );
	}

	public function flush_widget_cache() {
		wp_cache_delete('largo_recent_comments', 'widget');
	}

	/**
	 * How to display the widget on the screen.
	 */
	public function widget( $args, $instance ) {
		global $comments, $comment;

		$cache = wp_cache_get('widget_recent_comments', 'widget');

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
 			$number = 5;

		$comments = get_comments( apply_filters( 'widget_comments_args', array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish' ) ) );

		$output .= $before_widget;
				$output .= '<div class="right_sidebar_content">';
		if ( $title )
			$output .= $before_title . $title . $after_title;
		$output .= '<ul id="recentcomments">';
		if ( $comments ) {
			foreach ( (array) $comments as $comment) {
				$output .=  '<li class="recentcomments">';
				$output .= '<p class="comment-excerpt"><a href="'.get_comment_link().'">' . get_comment_excerpt() . '<hr style="display: block; height: 1px; border: 0; border-top: 1px solid #cfd0cf; margin: 7px 0; width: 15%"></a></p>';
				$output .= '</li>';
				$output .= '';
			}
 		}
		$output .= '</ul>';
		$output .= '</div>';
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_recent_comments', $cache, 'widget');
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
		if ( isset($alloptions['largo_recent_comments']) )
			delete_option('largo_recent_comments');

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' 			=> '',
			'number'			=> 5,
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
				<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to show:', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" value="<?php echo $number; ?>" size="3" />
			</p>

		<?php
	}
}
