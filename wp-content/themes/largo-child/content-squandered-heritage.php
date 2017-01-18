<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<?php $category = get_category_by_slug('squandered-heritage');?>
	<header>
		<h5 class="<?php echo $category->slug;?>">
			<a href="<?php echo esc_url( largo_child_category_link($category->term_id, $category->slug) );?>"><?php echo $category->name;?></a>
			<span class="author">By <?php the_author();?></span>
		</h5>
 		<h3><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
	</header><!-- / entry header -->

	<div class="entry-content">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('home_right'); ?></a>
		<?php largo_excerpt( $post, 2, true ); ?>
        <div class="byline"><?php largo_byline(true, false); ?><span class="small_comments">&nbsp;&nbsp;&nbsp;&nbsp;<?php largo_child_comments();?></span><?php edit_post_link( __('Edit This Post', 'largo'), ' <div class="edit-link">', '</div>'); ?></div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->