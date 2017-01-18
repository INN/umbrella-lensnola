<?php
/**
 * The default template for displaying a school
 *
 * @package WordPress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('school-board clearfix'); ?>>

	<header>
		<a href="<?php the_permalink(); ?>">
			<?php  if ( has_post_thumbnail() ):?>
				<?php the_post_thumbnail('school',array('class'=>'school_thumbnail'));?>
			<?php else:?>
				<img src="<?php echo get_stylesheet_directory_uri().'/images/school_thumb_generic.png';?>" class="attachment-school school_thumbnail"/>
			<?php endif;?>
		</a>
 		<h3><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
	</header><!-- / entry header -->

</article><!-- #post-<?php the_ID(); ?> -->