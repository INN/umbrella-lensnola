<?php
/*
 * Largo child find school widget
 */
class largo_child_find_school_widget extends WP_Widget {

	public function __construct() {
		$widget_opts = array(
			'classname' => 'largo-child-find-school',
			'description'=> __('Allows visitors to navigate to charter school and school board pages', 'largo')
		);
		parent::__construct('largo-child-find-school-widget', __('Largo Child Find School Widget', 'largo'),$widget_opts);
	}

	/**
	 * How to display the widget on the screen.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );

		/* Before widget*/
		echo $before_widget;

		/* Display the widget title if one was input */
		if ( $title )
			echo $before_title . $title . $after_title;

			?>
			<p>
			<select id="charter_schools">
				<option value="#">Select a Charter School</option>
				<?php

					$args=array(
						'post_type' => 'school',
						'order' => 'ASC',
						'orderby' => 'title',
						'nopaging' => true,
					);

					$schools = new WP_Query($args);

					if( $schools->have_posts() ) {
						while ($schools->have_posts()) {
							$schools->the_post();
							if ( get_post_type( get_the_ID() ) == 'school' ) {
								?>
									<option value="<?php the_permalink();?>"><?php the_title(); ?></option>
								<?php
							}
						}
					}

				?>
			</select>
			</p>
			
			<p>
			<select id="school_boards">
				<option value="#">Select a School Board</option>
				<?php
					$args=array(
						'type' => 'school',
						'order' => 'ASC',
						'orderby' => 'title',
						'taxonomy' => 'charter-organization'
					);

					$boards = get_categories($args);

					foreach ($boards as $board) {
						?>
							<option value="<?php echo esc_url(home_url('/charter-organization/'.$board->slug));?>"><?php echo $board->name; ?></option>
						<?php
					}
				?>
			</select>
			</p>

			<span class="directive">&gt;</span>
			<a href="<?php echo home_url('/charterschools');?>">Back to Charter Schools Home</a>
		<?php

		/* After widget */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' 			=> __('Find a Charter School or Board', 'largo'),
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:90%;" type="text" />
		</p>

	<?php
	}
}
