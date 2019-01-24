<?php

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
 
/**
 * @author James Lafferty
 * @since 0.1
 */

class largo_child_mailchimp extends WP_Widget {
	private $default_failure_message;
	private $default_loader_graphic = '/wp-content/plugins/mailchimp-widget/images/ajax-loader.gif';
	private $default_signup_text;
	private $default_signup_class;
	private $default_success_message;
	private $default_title;
	private $successful_signup = false;
	private $subscribe_errors;
	private $ns_mc_plugin;
	
	/**
	 * @author James Lafferty
	 * @since 0.1
	 */
	public function largo_child_mailchimp () {
		if (is_plugin_active('mailchimp-widget/mailchimp-widget.php')) {
			$this->default_failure_message = __('There was a problem processing your submission.');
			$this->default_signup_text = __('Join now!');
			$this->default_signup_class = __('');
			$this->default_success_message = __('Thank you for joining our mailing list. Please check your email for a confirmation link.');
			$this->default_title = __('Sign up for our mailing list.');
			$widget_options = array('classname' => 'widget_ns_mailchimp', 'description' => __( "Displays a sign-up form for a MailChimp mailing list.", 'mailchimp-widget'));
			$this->WP_Widget('ns_widget_mailchimp', __('Largo Child MailChimp List Signup', 'mailchimp-widget'), $widget_options);
			$this->ns_mc_plugin = NS_MC_Plugin::get_instance();
			$this->default_loader_graphic = get_bloginfo('wpurl') . $this->default_loader_graphic;
			add_action('init', array(&$this, 'add_scripts'));
			add_action('parse_request', array(&$this, 'process_submission'));
		}
	}
	
	/**
	 * @author James Lafferty
	 * @since 0.1
	 */
	
	public function add_scripts () {
		wp_enqueue_script('ns-mc-widget', get_bloginfo('wpurl') . '/wp-content/plugins/mailchimp-widget/js/mailchimp-widget-min.js', array('jquery'), false);
	}
	
	/**
	 * @author James Lafferty
	 * @since 0.1
	 */
	
	public function form ($instance) {
		$mcapi = $this->ns_mc_plugin->get_mcapi();
		if (false == $mcapi) {
			echo $this->ns_mc_plugin->get_admin_notices();
		} else {
			$this->lists = $mcapi->lists();
			$defaults = array(
				'failure_message' => $this->default_failure_message,
				'title' => $this->default_title,
				'signup_text' => $this->default_signup_text,
				'signup_class' => $this->default_signup_class,
				'success_message' => $this->default_success_message,
				'collect_first' => false,
				'collect_last' => false,
				'old_markup' => false,
				'widget_class' 		=> 'default',
				'hidden_desktop'	=> '',
				'hidden_tablet' 	=> '',
				'hidden_phone'		=> ''
			);
			$vars = wp_parse_args($instance, $defaults);
			$desktop = $vars['hidden_desktop'] ? 'checked="checked"' : '';
			$tablet = $vars['hidden_tablet'] ? 'checked="checked"' : '';
			$phone = $vars['hidden_phone'] ? 'checked="checked"' : '';
			
			extract($vars);
			
			?>
					<h3><?php echo  __('General Settings', 'mailchimp-widget'); ?></h3>
					<p>
						<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo  __('Title HTML:', 'mailchimp-widget'); ?></label>
						<textarea class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"><?php echo $title; ?></textarea>
					</p>
					<p>
						<label for="<?php echo $this->get_field_id('current_mailing_list'); ?>"><?php echo __('Select a Mailing List :', 'mailchimp-widget'); ?></label>
						<select class="widefat" id="<?php echo $this->get_field_id('current_mailing_list');?>" name="<?php echo $this->get_field_name('current_mailing_list'); ?>">
			<?php	
			foreach ($this->lists['data'] as $key => $value) {
				$selected = (isset($current_mailing_list) && $current_mailing_list == $value['id']) ? ' selected="selected" ' : '';
				?>	
						<option <?php echo $selected; ?>value="<?php echo $value['id']; ?>"><?php echo __($value['name'], 'mailchimp-widget'); ?></option>
				<?php
			}
			?>
						</select>
					</p>
					<p><strong>N.B.</strong><?php echo  __('This is the list your users will be signing up for in your sidebar.', 'mailchimp-widget'); ?></p>
					<p>
						<label for="<?php echo $this->get_field_id('signup_text'); ?>"><?php echo __('Sign Up Button Text :', 'mailchimp-widget'); ?></label>
						<input class="widefat" id="<?php echo $this->get_field_id('signup_text'); ?>" name="<?php echo $this->get_field_name('signup_text'); ?>" value="<?php echo $signup_text; ?>" />
					</p>
					<p>
						<label for="<?php echo $this->get_field_id('signup_class'); ?>"><?php echo __('Sign Up Button Class:', 'mailchimp-widget'); ?></label>
						<input class="widefat" id="<?php echo $this->get_field_id('signup_class'); ?>" name="<?php echo $this->get_field_name('signup_class'); ?>" value="<?php echo $signup_class; ?>" />
					</p>
					<h3><?php echo __('Personal Information', 'mailchimp-widget'); ?></h3>
					<p><?php echo __("These fields won't (and shouldn't) be required. Should the widget form collect users' first and last names?", 'mailchimp-widget'); ?></p>
					<p>
						<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('collect_first'); ?>" name="<?php echo $this->get_field_name('collect_first'); ?>" <?php echo  checked($collect_first, true, false); ?> />
						<label for="<?php echo $this->get_field_id('collect_first'); ?>"><?php echo  __('Collect first name.', 'mailchimp-widget'); ?></label>
						<br />
						<input type="checkbox" class="checkbox" id="<?php echo  $this->get_field_id('collect_last'); ?>" name="<?php echo $this->get_field_name('collect_last'); ?>" <?php echo checked($collect_last, true, false); ?> />
						<label><?php echo __('Collect last name.', 'mailchimp-widget'); ?></label>
					</p>
					<h3><?php echo __('Notifications', 'mailchimp-widget'); ?></h3>
					<p><?php echo  __('Use these fields to customize what your visitors see after they submit the form', 'mailchimp-widget'); ?></p>
					<p>
						<label for="<?php echo $this->get_field_id('success_message'); ?>"><?php echo __('Success :', 'mailchimp-widget'); ?></label>
						<textarea class="widefat" id="<?php echo $this->get_field_id('success_message'); ?>" name="<?php echo $this->get_field_name('success_message'); ?>"><?php echo $success_message; ?></textarea>
					</p>
					<p>
						<label for="<?php echo $this->get_field_id('failure_message'); ?>"><?php echo __('Failure :', 'mailchimp-widget'); ?></label>
						<textarea class="widefat" id="<?php echo $this->get_field_id('failure_message'); ?>" name="<?php echo $this->get_field_name('failure_message'); ?>"><?php echo $failure_message; ?></textarea>
					</p>
					
					<label for="<?php echo $this->get_field_id( 'widget_class' ); ?>"><?php _e('Widget Class', 'largo'); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id('widget_class'); ?>" name="<?php echo $this->get_field_name('widget_class'); ?>" value="<?php echo $widget_class; ?>" />
			
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
	
	/**
	 * @author James Lafferty
	 * @since 0.1
	 */
	
	public function process_submission () {
		
		if (isset($_GET[$this->id_base . '_email'])) {
			
			header("Content-Type: application/json");
			
			//Assume the worst.
			$response = '';
			$result = array('success' => false, 'error' => $this->get_failure_message($_GET['ns_mc_number']));
			
			$merge_vars = array();
			
			if (! is_email($_GET[$this->id_base . '_email'])) { //Use WordPress's built-in is_email function to validate input.
				
				$response = json_encode($result); //If it's not a valid email address, just encode the defaults.
				
			} else {
				
				$mcapi = $this->ns_mc_plugin->get_mcapi();
				
				if (false == $this->ns_mc_plugin) {
					
					$response = json_encode($result);
					
				} else {
					
					if (isset($_GET[$this->id_base . '_first_name']) && is_string($_GET[$this->id_base . '_first_name'])) {
						
						$merge_vars['FNAME'] = $_GET[$this->id_base . '_first_name'];
						
					}
					
					if (isset($_GET[$this->id_base . '_last_name']) && is_string($_GET[$this->id_base . '_last_name'])) {
						
						$merge_vars['LNAME'] = $_GET[$this->id_base . '_last_name'];
						
					}
					
					$subscribed = $mcapi->listSubscribe($this->get_current_mailing_list_id($_GET['ns_mc_number']), $_GET[$this->id_base . '_email'], $merge_vars);
				
					if (false == $subscribed) {
						
						$response = json_encode($result);
						
					} else {
					
						$result['success'] = true;
						$result['error'] = '';
						$result['success_message'] =  $this->get_success_message($_GET['ns_mc_number']);
						$response = json_encode($result);
						
					}
					
				}
				
			}
			
			exit($response);
			
		} elseif (isset($_POST[$this->id_base . '_email'])) {
			
			$this->subscribe_errors = '<div class="error">'  . $this->get_failure_message($_POST['ns_mc_number']) .  '</div>';
			
			if (! is_email($_POST[$this->id_base . '_email'])) {
				
				return false;
				
			}
			
			$mcapi = $this->ns_mc_plugin->get_mcapi();
			
			if (false == $mcapi) {
				
				return false;
				
			}
			
			if (is_string($_POST[$this->id_base . '_first_name'])  && '' != $_POST[$this->id_base . '_first_name']) {
				
				$merge_vars['FNAME'] = strip_tags($_POST[$this->id_base . '_first_name']);
				
			}
			
			if (is_string($_POST[$this->id_base . '_last_name']) && '' != $_POST[$this->id_base . '_last_name']) {
				
				$merge_vars['LNAME'] = strip_tags($_POST[$this->id_base . '_last_name']);
				
			}
			
			$subscribed = $mcapi->listSubscribe($this->get_current_mailing_list_id($_POST['ns_mc_number']), $_POST[$this->id_base . '_email'], $merge_vars);
			
			if (false == $subscribed) {

				return false;
				
			} else {
				
				$this->subscribe_errors = '';
				
				setcookie($this->id_base . '-' . $this->number, $this->hash_mailing_list_id(), time() + 31556926);
				
				$this->successful_signup = true;
				
				$this->signup_success_message = '<p>' . $this->get_success_message($_POST['ns_mc_number']) . '</p>';
				
				return true;
				
			}	
			
		}
		
	}
	
	/**
	 * @author James Lafferty
	 * @since 0.1
	 */
	
	public function update ($new_instance, $old_instance) {
		
		$instance = $old_instance;
		
		$instance['collect_first'] = ! empty($new_instance['collect_first']);
		
		$instance['collect_last'] = ! empty($new_instance['collect_last']);
		
		$instance['current_mailing_list'] = esc_attr($new_instance['current_mailing_list']);
		
		$instance['failure_message'] = esc_attr($new_instance['failure_message']);
		
		$instance['signup_text'] = esc_attr($new_instance['signup_text']);
		
		$instance['signup_class'] = esc_attr($new_instance['signup_class']);
		
		$instance['success_message'] = esc_attr($new_instance['success_message']);
		
		$instance['title'] = esc_attr($new_instance['title']);
		
		$instance['widget_class'] = $new_instance['widget_class'];
		$instance['hidden_desktop'] = $new_instance['hidden_desktop'] ? 1 : 0;
		$instance['hidden_tablet'] = $new_instance['hidden_tablet'] ? 1 : 0;
		$instance['hidden_phone'] = $new_instance['hidden_phone'] ? 1 : 0;
		
		return $instance;
		
	}
	
	/**
	 * @author James Lafferty
	 * @since 0.1
	 */
	
	public function widget ($args, $instance) {
		
		extract($args);
		
		if ((isset($_COOKIE[$this->id_base . '-' . $this->number]) && $this->hash_mailing_list_id($this->number) == $_COOKIE[$this->id_base . '-' . $this->number]) || false == $this->ns_mc_plugin->get_mcapi()) {
			
			return 0;
			
		} else {
			
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
	
			echo $before_widget;
			?>
			<div class="right_sidebar_content">
			<?php
			echo $before_title . html_entity_decode($instance['title']) . $after_title;
			
			if ($this->successful_signup) {
				echo $this->signup_success_message;
			} else {
				?>	
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="<?php echo $this->id_base . '_form-' . $this->number; ?>" method="post">
					<?php echo $this->subscribe_errors;?>
					<?php	
						if ($instance['collect_first']) {
					?>	
					<label><?php echo __('First Name :', 'mailchimp-widget'); ?><input type="text" name="<?php echo $this->id_base . '_first_name'; ?>" /></label>
					<br />
					<?php
						}
						if ($instance['collect_last']) {
					?>	
					<label><?php echo __('Last Name :', 'mailchimp-widget'); ?><input type="text" name="<?php echo $this->id_base . '_last_name'; ?>" /></label>
					<br />
					<?php	
						}
					?>
						<input type="hidden" name="ns_mc_number" value="<?php echo $this->number; ?>" />
						<input id="<?php echo $this->id_base; ?>-email-<?php echo $this->number; ?>" type="text" name="<?php echo $this->id_base; ?>_email" />
						<input class="button" type="submit" id="mailchimp_sumbit" name="<?php echo __($instance['signup_text'], 'mailchimp-widget'); ?>" value="<?php echo __($instance['signup_text'], 'mailchimp-widget'); ?>" class="<?php echo __($instance['signup_class'], 'mailchimp-widget'); ?>" />
					</form>
					<script>jQuery('#<?php echo $this->id_base; ?>_form-<?php echo $this->number; ?>').ns_mc_widget({"url" : "<?php echo $_SERVER['PHP_SELF']; ?>", "cookie_id" : "<?php echo $this->id_base; ?>-<?php echo $this->number; ?>", "cookie_value" : "<?php echo $this->hash_mailing_list_id(); ?>", "loader_graphic" : "<?php echo $this->default_loader_graphic; ?>"}); </script>
				<?php
			}
			?>
			</div>
			<?php
			echo $after_widget;
		}
		
	}
	
	/**
	 * @author James Lafferty
	 * @since 0.1
	 */
	
	private function hash_mailing_list_id () {
		
		$options = get_option($this->option_name);
		
		$hash = md5($options[$this->number]['current_mailing_list']);
		
		return $hash;
		
	}
	
	/**
	 * @author James Lafferty
	 * @since 0.1
	 */
	
	private function get_current_mailing_list_id ($number = null) {
		
		$options = get_option($this->option_name);
		
		return $options[$number]['current_mailing_list'];
		
	}
	
	/**
	 * @author James Lafferty
	 * @since 0.5
	 */
	
	private function get_failure_message ($number = null) {
		
		$options = get_option($this->option_name);
		
		return $options[$number]['failure_message'];
		
	}
	
	/**
	 * @author James Lafferty
	 * @since 0.5
	 */
	
	private function get_success_message ($number = null) {
		
		$options = get_option($this->option_name);
		
		return $options[$number]['success_message'];
		
	}
	
}

?>