<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<header>
 		<h3><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
	</header><!-- / entry header -->

	<div class="entry-content clearfix">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('home_right'); ?></a>
		<?php largo_excerpt( $post, 2, true ); ?>
        <span class="byline"><?php largo_byline(); ?><span class="small_comments">&nbsp;&nbsp;&nbsp;&nbsp;<?php largo_child_comments();?></span><?php edit_post_link( __('Edit This Post', 'largo'), ' <div class="edit-link">', '</div>'); ?></span>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->