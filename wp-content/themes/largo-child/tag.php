<?php
/**
 * The template for displaying Tag Archive pages.
 */

get_header();

if ( is_tax() || is_tag() || is_category() ) $term = $wp_query->get_queried_object();
?>

		<div id="content" class="content-category stories span8" role="main">

			<?php if ( have_posts() ) { ?>

			<header class="category-background clearfix">
				<h5 class="<?php echo $term->slug;?>">
					<span><?php echo $term->name;?></span>
				</h5>
			</header> <!-- /.category-background -->

				<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'content', 'category' );
					endwhile;
					largo_content_nav( 'nav-below' );

				} else {
					get_template_part( 'content', 'not-found' );
				}
				?>

		</div>
		<!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
