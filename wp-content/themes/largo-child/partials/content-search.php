<?php
/**
 * Search results on the top of the search results page.
 *
 * @package WordPress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<header class="search-header">
		<?php largo_maybe_top_term(); ?>

		<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
	</header><!-- / entry header -->

	<div class="entry-content">
		<div class="byline"><?php largo_byline( true, false, get_the_ID() ); ?></div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
