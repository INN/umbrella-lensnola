<!DOCTYPE html>
<!--[if lt IE 7]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<?php
	// get the current page url (used for rel canonical and open graph tags)
	global $current_url;
	$current_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$childtheme_dir = get_stylesheet_directory_uri();
?>
<title>
	<?php
		global $page, $paged;
		wp_title( '|', true, 'right' );
		bloginfo( 'name' ); // Add the blog name.

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . 'Page ' . max( $paged, $page );
	?>
</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_head();
?>

</head>

<body <?php body_class(); ?>>

<div id="ad-banner-container">
	<div id="ad-banner" class="row-fluid clearfix">
	    <?php
	    	if ( is_active_sidebar ( 'top_banner' ) ) dynamic_sidebar( 'top_banner' );
	    	if ( is_active_sidebar ( 'top_text' ) ) dynamic_sidebar( 'top_text' );
	    ?>
	</div>
</div>

<div id="header-container">
	<header id="site-header" class="row-fluid clearfix">
		<?php largo_header(); ?>
        <div id="top_about_section">
	        <a href="/about-us/">About the Lens</a>
	        <div id="social_media">
				<a href="http://www.twitter.com/thelensnola" target="_blank"><img src="<?php echo $childtheme_dir; ?>/images/twitter_red_icon.png"></a>
				<a href="http://www.facebook.com/thelensnola" target="_blank"><img src="<?php echo $childtheme_dir; ?>/images/fb_red_icon.png"></a>
				<a href="http://thelensnola.org/feed/"><img src="<?php echo $childtheme_dir; ?>/images/rss_red_icon.png"></a>
			</div>
			<div id="call_to_action">
				<a href="/about-us/contact-us/"><img src="<?php echo $childtheme_dir; ?>/images/send_tip_btn.png" /></a>
				<a href="/get-involved"><img src="<?php echo $childtheme_dir; ?>/images/get_involved_btn.png" /></a>
			</div>
		</div>
	</header>

	<header class="print-header">
		<p><strong><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></strong> (<?php echo $current_url ?>)</p>
	</header>
</div>

<div id="main-nav-container">
	<nav id="main-nav" class="navbar clearfix">
	  <div class="navbar-inner">
	    <div class="container">

	      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
	      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	        <div class="label"><?php _e('More', 'largo'); ?></div>
	        <div class="bars">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
	        </div>
	      </a>
	      <ul class="nav hidden-phone">
	        <?php
				$args = array(
					'theme_location' => 'navbar-categories',
					'depth'		 => 0,
					'container'	 => false,
					'items_wrap' => '%3$s',
					'menu_class' => 'nav',
					'walker'	 => new Bootstrap_Walker_Nav_Menu()
				);
				wp_nav_menu($args);
			?>
	      </ul>
	      <ul class="nav">
	        <li class="dropdown visible-phone" id="category-list">
			  <a class="dropdown-toggle" data-toggle="dropdown" href="#category-list">
			    Categories
				<b class="caret"></b>
			  </a>
			  <ul class="dropdown-menu">
			    <?php
					$args = array(
						'theme_location' => 'navbar-categories',
						'depth'		 => 1,
						'container'	 => false,
						'items_wrap' => '%3$s'
					);
					wp_nav_menu($args);
				?>
			  </ul>
			</li>
	      </ul>

	      <!-- Everything you want hidden at 940px or less, place within here -->
	      <div class="nav-collapse">
	        <ul class="nav">
	        	<?php
					$args = array(
						'theme_location' => 'navbar-supplemental',
						'depth'		 => 1,
						'container'	 => false,
						'items_wrap' => '%3$s'
					);

					wp_nav_menu($args);
				?>
	        </ul>
	        <ul class="nav visible-phone">
		        <li class="divider"></li>
		        <?php
					$args = array(
						'theme_location' => 'global-nav',
						'depth'		 => 1,
						'container'	 => false,
						'items_wrap' => '%3$s'
					);
					wp_nav_menu($args);
				?>
	         </ul>
	      </div>
	    </div>
	  </div>
	</nav>
	<?php if ( of_get_option( 'show_dont_miss_menu') ) : ?>
    <div id="secondary-nav-centered">
		<nav id="secondary-nav" class="clearfix">
	    	<div id="topics-bar" class="span12 hidden-phone">
				<?php wp_nav_menu( array( 'theme_location' => 'dont-miss', 'container' => false, 'depth' => 1 ) ); ?>
			</div>
		</nav>
    </div>
	<?php endif; ?>
</div>

<div id="page" class="hfeed clearfix">
	<div id="main" class="row-fluid clearfix">