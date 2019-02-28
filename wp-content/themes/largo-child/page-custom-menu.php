<?php
/*
Template Name: Page (Custom Menu)
*/

get_header();

?>

<div id="content" class="span8" role="main">
	<?php $args = array(
						'menu' => $post->post_name.'-navigation',
						'depth'		 => 0,
						'container'	 => false,
						'items_wrap' => '%3$s',
						'menu_class' => 'nav',
						'echo' => false,
						'fallback_cb' => false,
						'theme_location' => 'subcategory-featured',
						'walker'	 => new Bootstrap_Walker_Nav_Menu()
					);?>
	
	<?php if($sub_nav_menu = wp_nav_menu($args)):?>
		<div class="subcategory-featured">
			<ul>
				<?php echo $sub_nav_menu;?>
			</ul>
		</div>
	<?php endif;?>
	<?php the_post(); ?>
	<?php get_template_part( 'content', 'page' ); ?>

</div><!-- /.grid_8 #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
