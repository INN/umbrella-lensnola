<?php
/**
 * The template for displaying content in the single.php template
 */
$category = largo_child_get_the_category();
$meta = get_post_meta(get_the_ID(),'_custom_post_type_onomies_relationship',false);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'hnews item' ); ?>>

	<header class="category-background">

		<h5 class="<?php echo $category->slug;?>">
			<a href="<?php echo esc_url( largo_child_category_link($category->term_id, $category->slug) );?>"><?php echo $category->name;?></a>
			<?php if ($meta): ?><a href="#" id="more_coverage_hover" onclick="return false;">Related schools coverage &raquo;</a><?php endif; ?>
		</h5>

		<?php
			if ( ! empty( $meta ) ) {
				if (is_array($meta)) {
					foreach ($meta as $value):
						$school = get_post($value);
						if($school->post_type == 'school'):
							$links[] = '<a href="'.get_permalink($school->ID).'">'.get_the_title($school->ID).'</a>';
						endif;
					endforeach;
				} else {
					$school = get_post($meta);
					if ( isset( $school->post_type ) && $school->post_type == 'school' ) {
						$links[] = '<a href="'.get_permalink($school->ID).'">'.get_the_title($school->ID).'</a>';
					}
				}

				if ( ! empty( $links ) ) {
					?>
						<ul class="school_link" style="display: none;">
							<li>
								<?php echo implode( '</li><li>', $links ); ?>
							</li>
						</ul>
					<?php
				}
			}
		?>

		<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
		<?php if ( $subtitle = get_post_meta( $post->ID, 'subtitle', true ) ) : ?>
			<h2 class="subtitle"><?php echo $subtitle ?></h2>
		<?php endif; ?>
		<h5 class="byline"><?php largo_byline( true, false, get_the_ID() ); ?></h5>
		<?php if ( ! of_get_option( 'single_social_icons' ) == false ) {
			largo_post_social_links();
		} ?>

<?php largo_post_metadata( $post->ID ); ?>

	</header><!-- / entry header -->

	<?php
		do_action( 'largo_after_post_header' );

		largo_hero( null, 'span12' );

		do_action( 'largo_after_hero' );
	?>

	<?php get_sidebar(); ?>

	<section class="entry-content clearfix" itemprop="articleBody">

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
	</section><!-- .entry-content -->

	<?php do_action( 'largo_after_post_content' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
