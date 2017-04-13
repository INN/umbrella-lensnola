<?php
/*
Template Name: Page (No Menu)
*/

get_header(); 

?>

<div id="content" class="span8" role="main">
	
	<?php the_post(); ?>
	<?php get_template_part( 'content', 'page' ); ?>

</div><!-- /.grid_8 #content -->
<aside id="sidebar" class="span4">
<?php get_sidebar(); ?>
</aside>
<!-- /.grid_4 -->
<?php get_footer(); ?>