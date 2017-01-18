<?php
/**
 * The template for displaying content in the single.php template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'hnews item' ); ?>>
	<header class="category-background">
		<?php $category = largo_child_get_the_category();?>
        <?php $meta = get_post_meta(get_the_ID(),'_custom_post_type_onomies_relationship',false);?>
        <h5 class="<?php echo $category->slug;?>">
            <a href="<?php echo esc_url( largo_child_category_link($category->term_id, $category->slug) );?>"><?php echo $category->name;?></a>
            <?php if ($meta): ?><a href="#" id="more_coverage_hover" onclick="return false;">Related schools coverage &raquo;</a><?php endif; ?>
        </h5>
        <?php if ($meta):?>
            <?php if (is_array($meta)):
                foreach ($meta as $value):
                    $school = get_post($value);
                    if($school->post_type == 'school'):
                        $links[] = '<a href="'.get_permalink($school->ID).'">'.get_the_title($school->ID).'</a>';
                    endif;
                endforeach;
            else:
                $school = get_post($meta);
                if($school->post_type == 'school'):
                    $links[] = '<a href="'.get_permalink($school->ID).'">'.get_the_title($school->ID).'</a>';
                endif;
            endif;?>
            <ul class="school_link" style="display: none;">
                <li><?php echo implode('</li><li>',$links);?></li>
            </ul>
        <?php endif;?>
		<div class="clearfix">&nbsp;</div>
 		<h1 class="entry-title"><?php the_title(); ?></h1>
 		<div class="clearfix">
 			<div class="left">
 				<div class="byline"><?php largo_byline(true,true,true,true,true); ?><span class="small_comments">&nbsp;&nbsp;&nbsp;&nbsp;<?php largo_child_comments();?></span><?php edit_post_link( __('Edit This Post', 'largo'), ' <div class="edit-link">', '</div>'); ?></div>
 			</div>
 			<div class="right">
 				<?php get_template_part( 'largo-social-single' ); ?>
 			</div>
 		</div>
	</header><!-- / entry header -->

	<div class="entry-content clearfix">
		<?php largo_entry_content( $post ); ?>

		<div class="disclosure-container">
			<span class="help">
				<a href="<?php echo home_url('/about-us/contact-us');?>">Help us report this story</a>
			</span>
			&nbsp;&nbsp;&nbsp;
			<span class="help">
				<a href="<?php echo home_url('/about-us/contact-us');?>">Report an error</a>
			</span>
			&nbsp;&nbsp;&nbsp;
			<div class="disclosure">
				The Lens' <a href="<?php echo home_url('/support-us/supported-by/');?>">donors</a> and <a href="<?php echo home_url('/support-us/supported-by-2/');?>">partners</a> may be mentioned or have a stake in the stories we cover.</a>
			</div>
		</div>
	</div><!-- .entry-content -->

	<footer class="post-meta bottom-meta">

 		<!-- Other posts in this series -->
 		<?php if ( largo_post_in_series() ): ?>
			<div class="labels clearfix">
            	<h5><?php _e('More In This Series', 'largo'); ?></h5>
            	<?php largo_the_series_list(); ?>
        	</div>
        <?php endif; ?>

		<!-- Author bio and social links -->
		<?php if ( largo_show_author_box() )
			get_template_part( 'largo-author-box' );
		?>

		<!-- Related posts -->
		<?php if ( of_get_option( 'show_related_content' ) )
			get_template_part( 'largo-related-posts' );
		?>


	</footer><!-- /.post-meta -->
</article><!-- #post-<?php the_ID(); ?> -->