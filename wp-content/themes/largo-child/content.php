<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<header>
		<?php $category = largo_child_get_the_category();?>
        <h5 class="<?php echo $category->slug;?>">
			<a href="<?php echo esc_url( largo_child_category_link($category->term_id, $category->slug) );?>"><?php echo $category->name;?></a>
		</h5>
 		<h3><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
 		<div class="post-meta">
 		</div>
	</header><!-- / entry header -->

	<div class="entry-content">
    
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
		<?php largo_excerpt( $post, 2, true ); ?>
        <?php if ( largo_has_categories_or_tags() ): ?>
            <div class="post-meta bottom-meta">
    			<!-- <h5><strong><?php _e('Filed under:', 'largo'); ?></strong> <?php largo_categories_and_tags(); ?></h5> -->
            </div><!-- /.post-meta -->
        <?php endif; ?>
        <div class="byline"><?php largo_byline(); ?><span class="small_comments"><?php largo_child_comments();?></span><?php edit_post_link( __('Edit This Post', 'largo'), ' <div class="edit-link">', '</div>'); ?></div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->