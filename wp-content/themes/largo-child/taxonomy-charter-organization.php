<?php
/**
 * The template for displaying a School Board page
 */

get_header();

if ( is_tax() || is_tag() || is_category() ) {
	$term = $wp_query->get_queried_object();
	$slug = $term->slug;
}
?>

		<div id="content" class="content-category stories span8" role="main">
			<header class="category-background clearfix">
				<h5 class="charterschools chartermain">
					Charter School Board
				</h5>
			</header> <!-- /.category-background -->

			<h2 class="school"><?php echo $term->name;?></h2>

			<div class="board-schools-list">
				<?php
				$args = array(
					'tax_query' => array(
						array(
							'taxonomy' => 'charter-organization',
							'field' => 'slug',
							'terms' => $slug
						)
					),
					'post_type'	=> 'school',
					'nopaging'	=> true
				);
				$schools = new WP_Query($args);

				if ( $schools->have_posts() ) {

					$school_ids = array();
					while ( $schools->have_posts() ) : $schools->the_post();
						$school_ids[] = $post->ID;
						get_template_part( 'content', 'school' );
					endwhile;
				}
				?>
                <div class="clearfix"></div>
			</div>

			<div class="content-main">
				<?php
					$args = array(
						'meta_query' => array(
							array(
								'key' => '_custom_post_type_onomies_relationship',
								'value' => $school_ids,
							)
						),
						'posts_per_page'	=> -1,
						'post_type'			=> 'post'
					);
					$wp_query = new WP_Query($args);

					if ( have_posts() ) :
						$count = 1;
						while ( have_posts() ) : the_post(); $ids[] = get_the_ID();
								get_template_part( 'content', 'category' );
						endwhile;
					endif; // end more featured posts ?>
			</div>
		</div>
		<!-- /.grid_8 #content -->

<?php get_sidebar('schools'); ?>

<?php get_footer(); ?>
