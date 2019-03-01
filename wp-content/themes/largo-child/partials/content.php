<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<header>
		<?php largo_maybe_top_term(); ?>
		<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
		<div class="post-meta">
		</div>
	</header><!-- / entry header -->

	<div class="entry-content">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

		<?php largo_excerpt( $post, 2, true ); ?>

		<div class="byline">
			<?php largo_byline(); ?>
		</div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
