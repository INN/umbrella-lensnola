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
