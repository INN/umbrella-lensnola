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

		$widget_class = !empty($instance['widget_class']) ? $instance['widget_class'] : '';
		if ($instance['hidden_desktop'] === 1)
			$widget_class .= ' hidden-desktop';
		if ($instance['hidden_tablet'] === 1)
			$widget_class .= ' hidden-tablet';
		if ($instance['hidden_phone'] === 1)
			$widget_class .= ' hidden-phone';
		/* Add the widget class to $before widget, used as a style hook */
		if( strpos($before_widget, 'class') === false ) {
			$before_widget = str_replace('>', 'class="'. $widget_class . '"', $before_widget);
		}
		else {
			$before_widget = str_replace('class="', 'class="'. $widget_class . ' ', $before_widget);
		}

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
					  'nopaging' => true);
					
					$schools = new WP_Query($args);

					if( $schools->have_posts() ) {
					  while ($schools->have_posts()) : $schools->the_post();?>
					  	<?php if(get_post_type(get_the_ID()) == 'school'):?>
					    	<option value="<?php the_permalink();?>"><?php the_title(); ?></option>
					    <?php endif;?>
					    <?php
					  endwhile;
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
					  'taxonomy' => 'charter-organization');
					
					$boards = get_categories($args);

					foreach ($boards as $board) {
						?>
					    <option value="<?php echo esc_url(home_url('/charter-organization/'.$board->slug));?>"><?php echo $board->name; ?></option>
					    <?php
					}
				?>
			</select>
			</p>
			
			<span class="directive">&gt;</span> <a href="<?php echo home_url('/charterschools');?>">Back to Charter Schools Home</a>
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
		$instance['widget_class'] = $new_instance['widget_class'];
		$instance['hidden_desktop'] = $new_instance['hidden_desktop'] ? 1 : 0;
		$instance['hidden_tablet'] = $new_instance['hidden_tablet'] ? 1 : 0;
		$instance['hidden_phone'] = $new_instance['hidden_phone'] ? 1 : 0;
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' 			=> __('Find a Charter School or Board', 'largo'),
			'widget_class' 		=> 'default',
			'hidden_desktop' 	=> '',
			'hidden_tablet' 	=> '',
			'hidden_phone'		=> ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$desktop = $instance['hidden_desktop'] ? 'checked="checked"' : '';
		$tablet = $instance['hidden_tablet'] ? 'checked="checked"' : '';
		$phone = $instance['hidden_phone'] ? 'checked="checked"' : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'largo'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:90%;" />
		</p>

		<label for="<?php echo $this->get_field_id( 'widget_class' ); ?>"><?php _e('Widget Background', 'largo'); ?></label>
		<select id="<?php echo $this->get_field_id('widget_class'); ?>" name="<?php echo $this->get_field_name('widget_class'); ?>" class="widefat" style="width:90%;">
		    <option <?php selected( $instance['widget_class'], 'default'); ?> value="default"><?php _e('Default', 'largo'); ?></option>
		    <option <?php selected( $instance['widget_class'], 'rev'); ?> value="rev"><?php _e('Reverse', 'largo'); ?></option>
		    <option <?php selected( $instance['widget_class'], 'no-bg'); ?> value="no-bg"><?php _e('No Background', 'largo'); ?></option>
		</select>

		<p style="margin:15px 0 10px 5px">
			<input class="checkbox" type="checkbox" <?php echo $desktop; ?> id="<?php echo $this->get_field_id('hidden_desktop'); ?>" name="<?php echo $this->get_field_name('hidden_desktop'); ?>" /> <label for="<?php echo $this->get_field_id('hidden_desktop'); ?>"><?php _e('Hidden on Desktops?', 'largo'); ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $tablet; ?> id="<?php echo $this->get_field_id('hidden_tablet'); ?>" name="<?php echo $this->get_field_name('hidden_tablet'); ?>" /> <label for="<?php echo $this->get_field_id('hidden_tablet'); ?>"><?php _e('Hidden on Tablets?', 'largo'); ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $phone; ?> id="<?php echo $this->get_field_id('hidden_phone'); ?>" name="<?php echo $this->get_field_name('hidden_phone'); ?>" /> <label for="<?php echo $this->get_field_id('hidden_phone'); ?>"><?php _e('Hidden on Phones?', 'largo'); ?></label>
		</p>

	<?php
	}
}
