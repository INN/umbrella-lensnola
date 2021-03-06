<?php
/**
 * Largo Child WP Most Pupular
 *
 * Depends upon https://wordpress.org/plugins/wp-most-popular/
 */

class largo_child_most_popular extends WP_Widget {

	// constructor
	public function __construct() {
		parent::__construct( 'wmp_widget', 'Largo Child WP Most Popular', array( 'description' => 'Display your most popular blog posts on your sidebar' ) );
	}

	// form
	public function form( $instance ) {
		$defaults = $this->default_options( $instance );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $defaults['title']; ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of posts to show:</label><br />
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $defaults['number']; ?>" size="3">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>">Choose post type:</label><br />
			<select id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<option value="all">All post types</option>
				<?php
				$post_types = get_post_types( array( 'public' => true ), 'names' );
				foreach ($post_types as $post_type ) {
					// Exclude attachments
					if ( $post_type == 'attachment' ) continue;
					$defaults['post_type'] == $post_type ? $sel = " selected" : $sel = "";
					echo '<option value="' . $post_type . '"' . $sel . '>' . $post_type . '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'timeline' ); ?>">Timeline:</label><br />
			<select id="<?php echo $this->get_field_id( 'timeline' ); ?>" name="<?php echo $this->get_field_name( 'timeline' ); ?>">
				<option value="all_time"<?php if ( $defaults['timeline'] == 'all_time' ) echo "selected"; ?>>All time</option>
				<option value="monthly"<?php if ( $defaults['timeline'] == 'monthly' ) echo "selected"; ?>>Past month</option>
				<option value="weekly"<?php if ( $defaults['timeline'] == 'weekly' ) echo "selected"; ?>>Past week</option>
				<option value="daily"<?php if ( $defaults['timeline'] == 'daily' ) echo "selected"; ?>>Today</option>
			</select>
		</p>
		<?php
	}

	// Helper to set default options
	private function default_options( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
			$options['title'] = esc_attr( $instance[ 'title' ] );
		else
			$options['title'] = 'Popular posts';
			
		if ( isset( $instance[ 'number' ] ) )
			$options['number'] = (int) $instance[ 'number' ];
		else
			$options['number'] = 5;
		
		if ( isset( $instance[ 'post_type' ] ) )
			$options['post_type'] = esc_attr( $instance[ 'post_type' ] );
		else
			$options['post_type'] = 'all';

		if ( isset( $instance[ 'timeline' ] ) )
			$options['timeline'] = esc_attr( $instance[ 'timeline' ] );
		else
			$options['timeline'] = 'all_time';
		
		return $options;
	}
	
	public function update( $new, $old ) {
		$instance = wp_parse_args( $new, $old );
		return $instance;
	}
	
	public function widget( $args, $instance ) {
		if ( ! function_exists( 'wmp_get_popular' ) ) {
			echo '<!-- The Largo Child WP Most Popular Widget depends on the wp-most-popular plugin, which does not appear to be active, or has ceased to provide the function wmp_most_popular. Please remedy the situation. -->';
			return;
		}

		// Find default args
		extract( $args );
		
		// Get our posts
		$defaults			= $this->default_options( $instance );
		$options['limit']	= (int) $defaults[ 'number' ];
		$options['range']	= $defaults['timeline'];

		if ( $defaults['post_type'] != 'all' ) {
			$options['post_type'] = $defaults['post_type'];
		}

		$posts = wmp_get_popular( $options );
		
		// Display the widget
		echo $before_widget . '<div class="right_sidebar_content">';
		if ( $defaults['title'] ) echo $before_title . $defaults['title'] . $after_title;
		echo '<ul>';
		global $post;
		foreach ( $posts as $post ):
			setup_postdata( $post );
			?>
			<li><p><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a><hr style="display: block; height: 1px; border: 0; border-top: 1px solid #cfd0cf; margin: 7px 0; width: 15%"></p></li>
			<?php
		endforeach;
		echo '</ul>';
		echo '</div>' . $after_widget;
		
		// Reset post data
		wp_reset_postdata();
	}
}
