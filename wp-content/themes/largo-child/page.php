<?php
/*
Template Name: Page
*/

get_header(); 

?>

<div id="content" class="span8" role="main">
	<?php $args = array(
						'child_of' => ($post->post_parent) ? $post->post_parent : $post->ID,
						'title_li' => '',
						'echo' => false
					);?>
	
	<?php if($sub_nav_menu = wp_list_pages($args)):?>
		<div class="subcategory-featured">
			<ul>
				<?php echo $sub_nav_menu;?>
			</ul>
		</div>
	<?php endif;?>
	<?php the_post(); ?>
	<?php get_template_part( 'partials/content', 'page' ); ?>

</div><!-- /.grid_8 #content -->
<aside id="sidebar" class="span4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>
