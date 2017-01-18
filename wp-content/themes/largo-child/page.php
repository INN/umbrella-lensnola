<?php
/*
Template Name: Page
*/
get_header();
?>

<div id="content" class="span8" role="main">
	<?php
		$args = array(
			'child_of' 	=> ($post->post_parent) ? $post->post_parent : $post->ID,
			'title_li' 	=> '',
			'echo' 		=> false
		);
		if( $sub_nav_menu = wp_list_pages( $args ) ):
	?>
		<div class="subcategory-featured">
			<ul>
				<?php echo $sub_nav_menu; ?>
			</ul>
		</div>
	<?php
		endif;
		the_post();
		get_template_part( 'content', 'page' );
	?>
</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>