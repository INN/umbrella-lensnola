<?php
/**
 * The default template for displaying content-search
 *
 * @package WordPress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> style="border-bottom:1px solid #BABCBE;">

    <header class="search-header">
        <h3><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
        <div class="post-meta">
        </div>
    </header><!-- / entry header -->
</article><!-- #post-<?php the_ID(); ?> -->