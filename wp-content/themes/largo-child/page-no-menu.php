<?php
/*
Template Name: Page (No Menu)
*/

get_header();

?>

<div id="content" class="span8" role="main">
	<?php the_post(); ?>
	<?php get_template_part( 'partials/content', 'page' ); ?>
</div><!-- /.grid_8 #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
