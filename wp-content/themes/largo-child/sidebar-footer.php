<?php
/**
 * The Footer widget areas.
 */
?>

<div class="span3 widget-area" role="complementary" style="margin-top: -50px">
<h3 class="footer_title">THE LENS</h3>
	<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1, 'link_after' => '<hr />'  ) ); ?>
</div> <!-- /.grid_2 -->

<div class="span6 widget-area" role="complementary"  style="margin-top: -50px">
	<?php if ( ! dynamic_sidebar( 'footer-featured-posts' ) )
		the_widget( 'largo_footer_featured_widget', array( 'title' => __('In Case You Missed It', 'largo'), 'num_sentences' => 2, 'num_posts' => 2 ) );
	?>
	<div class="largo-about"><p align="center"><a href="http://inn.org/" target="_blank"><img src="http://thelensnola.org/wp-content/uploads/2015/05/institute-for-nonprofit-news-logo.png" height="55" alt="INN logo" /></a></p></div>
</div> <!-- /.grid_6 -->

<div class="span3 widget-area" role="complementary">
	<?php if ( ! dynamic_sidebar( 'footer-widget-area' ) ) : ?>

		<div id="searchform-footer">
			<?php get_search_form(); ?>
		</div>
		
	<?php endif; // end sidebar widget area ?>
	
	<ul id="ft-social">
		<?php largo_social_links(); ?>
	</ul>

</div> <!-- /.span3 -->
