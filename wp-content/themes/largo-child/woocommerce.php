<?php
/*
Template Name: Page-Woo
*/

get_header(); 

?>

<div id="content" class="span8" role="main">
	<?php $args = array(
						'child_of' => ($post->post_parent) ? $post->post_parent : $post->ID,
						'title_li' => '',
						'echo' => false
					);?>
	
	
	
	<?php woocommerce_content(); ?>

</div><!-- /.grid_8 #content -->
<aside id="sidebar" class="span4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>