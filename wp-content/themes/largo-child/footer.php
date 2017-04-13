<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 */
?>

	</div> <!-- #main .container_12 -->

</div><!-- #page -->

<div class="footer-bg clearfix">
	<footer id="site-footer">
                			<?php wp_nav_menu( array( 'theme_location' => 'footer-bottom', 'container' => false, 'depth' => 1  ) ); ?>
		<div id="supplementary" class="row-fluid">
			<?php get_sidebar( 'footer' ); ?>
		</div>
		<div id="boilerplate" class="row-fluid clearfix">
			<div class="footer-bottom clearfix">
				<p class="footer-credit"><?php _e('This site built with <a href="http://largoproject.org">Project Largo</a> from the <a href="http://inn.org">Institute for Nonprofit News</a> and proudly powered by <a href="http://wordpress.org" rel="nofollow">WordPress</a>.', 'largo'); ?></p>
				<p class="back-to-top"><a href="#top"><?php _e('Back to top &uarr;', 'largo'); ?></a></p>
			</div>
		</div><!-- /#boilerplate -->
	</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>