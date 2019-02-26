<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 */
?>

<?php
$argo_link = get_post_meta(get_the_ID(), 'argo_link_url');
$argo_description = get_post_meta(get_the_ID(), 'argo_link_description');
$argo_source = get_post_meta(get_the_ID(), 'argo_link_source');
?>


<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<header>
		<h5 class="what-were-reading">What We're Reading</h5>
 		<h3><a href="<?php echo $argo_link[0]; ?>" rel="bookmark"><?php the_title(); ?></a></h3>
 		<div class="post-meta">
 		</div>
	</header><!-- / entry header -->

	<div class="entry-content">
    
		<a href="<?php echo $argo_link[0]; ?>"><?php the_post_thumbnail('category'); ?></a>
		<p><?php echo $argo_description[0]; ?></p>
        <span class="byline"><a href="<?php echo $argo_link[0]; ?>"><?php echo $argo_source[0];?></a></span>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->