<?php
/**
 * The Sidebar containing the schools widget area.
 *
 * @since Largo 0.6.1
 */

$span_class = largo_sidebar_span_class();
do_action('largo_before_sidebar');
?>
<aside id="sidebar" class="<?php echo $span_class; ?> nocontent">
	<?php do_action('largo_before_sidebar_content'); ?>
	<div class="widget-area" role="complementary">
		<?php
			do_action('largo_before_sidebar_widgets');

			dynamic_sidebar( 'sidebar-schools' );

			do_action('largo_after_sidebar_widgets');
		?>
	</div><!-- #main .widget-area -->
	<?php do_action('largo_after_sidebar_content'); ?>
</aside>
<?php do_action('largo_after_sidebar');
