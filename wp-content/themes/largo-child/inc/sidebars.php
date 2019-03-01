<?php

/**
 * Register our sidebars and other widget areas
 *
 * @since 1.0
 */
function largochild_register_sidebars() {

	register_sidebar( array(
		'name' => 'Top Banner (left)',
		'id' => 'top_banner',
		'before_widget' => '<div id="sponsor" class="%2$s">',
		'after_widget' 	=> '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
	
	register_sidebar( array(
		'name' => 'Top Text (right)',
		'id' => 'top_text',
		'before_widget' => '<div id="top_comments" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
		
	register_sidebar( array(
		'name' => 'Top About Section',
		'id' => 'top_about_section',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	
	register_sidebar( array(
		'name' 			=> 'Schools Sidebar',
		'id' 			=> 'sidebar-schools',
		'before_widget' => '<aside id="%1$s" class="%2$s odd_even clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );
}
add_action( 'widgets_init', 'largochild_register_sidebars' );

/**
 * Squandered Heritage category sidebar
 */
function lens_sidebar_squandered() {
	if ( in_category( 'squandered-heritage-vintage' ) ) {
		?>
			<aside class="widget single" id="widget-squandered">
				This story was originally published on Squandered Heritage, the blog that Karen Gadbois created to track threatened historic houses in New Orleans. That work led to the <a href="<?php echo home_url('/about-us');?>" title="About The Lens">founding of The Lens in 2009</a>. We&#8217;ve moved all of those early stories to The Lens, including this one. You also can read her <a href="<?php echo home_url('/hbos-treme-spotlights-lens-founder-karen-gadbois');?>" title="Best of Squandered Heritage 2006-2010">best stories from 2006 to 2010</a> and <a href="<?php echo home_url('/squandered-heritage-archives');?>" title="Squandered Heritage 2006-2010 Archives">browse the archives from that time</a>. Gadbois continues to <a href="<?php echo home_url('/category/squandered-heritage');?>">cover land use and historic preservation</a> for The Lens.
			</aside>
		<?php
	}
}
add_action( 'largo_after_sidebar_widgets', 'lens_sidebar_squandered' );

/**
 * Charter School Reporting Corps sidebar
 */
function lens_sidebar_csrc() {
	if ( ! is_category( 'schools' ) ) {
		return;
	}
	global $shown_ids, $paged;
	if ( isset( $paged ) && $paged > 1 ) {
		return;
	}

	?>
		<div class="subcategory-featured sub-stories" id="csrc">
			<header>
				<h5 class="charterschools">
					<a href="<?php echo home_url('/charterschools');?>">Charter School Reporting Corps</a>
				</h5>
			</header>

			<?php
			$substories = largo_get_featured_posts( array(
				'tax_query' => array(
					array(
						'taxonomy' 	=> 'prominence',
						'field' 	=> 'slug',
						'terms' 	=> 'charter-featured'
					)
				),
				'showposts'		=> 5,
				'post__not_in' 	=> $shown_ids,
			) );
			if ( $substories->have_posts() ) {
				$count = 1;
				while ( $substories->have_posts() ) {
					$substories->the_post();
					$ids[] = get_the_ID();
					?>
						<div class="story">
							<header>
								<h3 class="entry-title">
									<a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h3>
							</header><!-- / entry header -->

							<div class="entry-content byline">
								<?php largo_byline(); ?>
							</div><!-- .entry-content -->
						</div>
					<?php
				}
			}
			?>
			
			<div class="charter-coverage-link">
				<a href="<?php echo home_url('/charterschools');?>">Complete Charter Schools Coverage</a> &rarr;
			</div>
		</div>
	<?php
}
add_action( 'largo_before_category_river', 'lens_sidebar_csrc' );

/**
 * Page navigation
 *
 * Applies to pages using page.php
 */
function lens_sidebar_page_nav() {
	if ( ! is_page() ) {
		return;
	}
	$args = array(
		'child_of' => ($post->post_parent) ? $post->post_parent : $post->ID,
		'title_li' => '',
		'echo' => false,
	);
	$sub_nav_menu = wp_list_pages( $args );
	
	if ( ! empty( $sub_nav_menu ) ) {
		?>
			<div class="subcategory-featured">
				<ul>
					<?php echo $sub_nav_menu;?>
				</ul>
			</div>
		<?php
	}
}

/**
 * Custom page navigation, for when a page needs a menu other than the default menu
 *
 * Implemented on pages that use the page-custom-menu.php template
 */
function lens_sidebar_page_nav_custom() {
	if ( ! is_page() ) {
		return;
	}
	$args = array(
		'menu'           => $post->post_name.'-navigation',
		'depth'          => 0,
		'container'      => false,
		'items_wrap'     => '%3$s',
		'menu_class'     => 'nav',
		'echo'           => false,
		'fallback_cb'    => false,
		'theme_location' => 'subcategory-featured',
		'walker'         => new Bootstrap_Walker_Nav_Menu(),
		'echo'           => false,
	);
	$sub_nav_menu = wp_list_pages( $args );
	
	if ( ! empty( $sub_nav_menu ) ) {
		?>
			<div class="subcategory-featured">
				<ul>
					<?php echo $sub_nav_menu;?>
				</ul>
			</div>
		<?php
	}
}

/**
 * The related schools coverage link
 *
 * Affected post ID examples: 57851
 *
 * Before, this used to be part of the pseudo-top-term presentation of the post's categoris, which appeared in the header in Largo post-0.4's "top term" position.
 */
function lens_sidebar_schooling() {
	if ( ! is_single() ) {
		return;
	}

	$category = largo_child_get_the_category();
	$meta = get_post_meta(get_the_ID(),'_custom_post_type_onomies_relationship',false);
	
	if ( ! empty( $meta ) ) {
		echo '<div id="more_coverage" class="clearfix widget span2">';
		?>
			<h5 id="more_coverage_hover" >Related schools coverage</h5>
		<?php
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
				<ul class="school_link">
					<li>
						<?php echo implode( '</li><li>', $links ); ?>
					</li>
				</ul>
			<?php
		}

		echo '</div>';
	}
}
add_action( 'largo_after_hero', 'lens_sidebar_schooling' );

/**
 * Something about disclosures?
 *
 * Uses .entry-content to match the column above and below.
 *
 * @see lens_sliding_popout
 */
function lens_sidebar_disclosure_container() {
	if ( ! is_single() ) {
		return;
	}

	?>
		<div class="disclosure-container entry-content clearfix">
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
	<?php
}
add_action( 'largo_after_post_content', 'lens_sidebar_disclosure_container' );
