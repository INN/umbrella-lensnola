<?php
/**
 * Search results on the bottom of the search results page.
 *
 * @package WordPress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> style="border-bottom:1px solid #BABCBE;">

	<header class="search-header">

		<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

	</header><!-- / entry header -->
</article><!-- #post-<?php the_ID(); ?> -->
