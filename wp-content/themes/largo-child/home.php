<?php
get_header();

//collect post IDs in each loop so we can avoid duplicating posts
global $ids;
$ids = array();
?>

<div id="content" class="stories span8" role="main">
<?php
// get the optional homepage top section (if set)
if ( of_get_option('homepage_top') == 'topstories' ) {
	get_template_part( 'home-part-topstories' );
} else if ( of_get_option('homepage_top' ) == 'slider') {
	get_template_part( 'home-part-slider-substories' );
}

// sticky posts box if this site uses it
if ( of_get_option( 'show_sticky_posts' ) ) {
	get_template_part( 'home-part-sticky-posts' );
}

?>

<div class="homebottom_left clearfix">
<?php
if ( of_get_option('homepage_bottom') == 'widgets' ) {
	get_sidebar('homepage-bottom');
} else {
	$category = get_category_by_slug('opinion');
	
	$args = array(
		'category_name' => $category->slug,
		'paged'			=> $paged,
		'post_status'	=> 'publish',
		'posts_per_page'=> 3,
		'post__not_in' 	=> $ids
		);
	$wp_query = new WP_Query( $args );

	if ( $wp_query->have_posts() ) {
		?>
		<header>
			<h5 class="<?php echo $category->slug;?>">
				<a href="<?php echo esc_url( largo_child_category_link($category->term_id, $category->slug) );?>"><?php echo $category->name;?></a>
			</h5>
		</header>
		<?php
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			//if the post is in the array of post IDs already on this page, skip it
			if ( in_array( get_the_ID(), $ids ) ) {
				continue;
			} else {
				$ids[] = get_the_ID();
				get_template_part( 'content', 'home-left' );
			}
		endwhile;
	}
}
?>

</div>

<div class="homebottom_right clearfix">
<?php
// homepage bottom
if ( of_get_option('homepage_bottom') == 'widgets' ) {
	get_sidebar('homepage-bottom');
} else {
	$category = get_category_by_slug('charterschools');
	
	$args = array(
				'tax_query' => array(
					array(
						'taxonomy' 	=> 'prominence',
						'field' 	=> 'slug',
						'terms' 	=> 'charter-featured'
					)
				),
				'post__not_in' 	=> $ids,
				'showposts' => 2);
	$wp_query = new WP_Query( $args );
	
	if ( $wp_query->have_posts() ) {
		?><header>
		<header>
			<h5 class="<?php echo $category->slug;?>">
				<a href="<?php echo home_url('/charterschools');?>"><?php echo $category->name;?></a>
			</h5>
		</header>
		<?php 
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			//if the post is in the array of post IDs already on this page, skip it
			if ( in_array( get_the_ID(), $ids ) ) {
				continue;
			} else {
				$ids[] = get_the_ID();
				get_template_part( 'content', 'home-right' );
			}
		endwhile;
	}
	?>
	
<?php
	$args = array(
		'category_name' => 'investigations',
		'paged'			=> $paged,
		'post_status'	=> 'publish',
		'posts_per_page'=> 1,
		'post__not_in' 	=> $ids
		);
	$wp_query = new WP_Query( $args );

	if ( $wp_query->have_posts() ) {
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			//if the post is in the array of post IDs already on this page, skip it
			if ( in_array( get_the_ID(), $ids ) ) {
				continue;
			} else {
				$ids[] = get_the_ID();
				get_template_part( 'content', 'investigations' );
			}
		endwhile;
	}
}
?>
</div>
<div class="clearfix"></div>
<div id="muckreads" class="hidden-phone hidden-tablet">
	<header>
		<h5 class="muckreads">
			<a href="http://www.propublica.org/">MuckReads <br/>ProPublica's ongoing collection of watchdog reporting</a>
		</h5>
	</header>
	
	<script type="text/javascript" id="rebelmouse-embed-script" src="https://www.rebelmouse.com/static/js-build/embed/embed.js?site=MuckReads&height=500&flexible=0"></script>
</div>

</div><!--/.grid_8 #content-->

<!-- BEGIN SLIDING POP OUT --> 
<script>

jQuery(document).ready(function($) {
    

    // Floating donate box
    var popout_exists = false;
    var popout_appeared = false;
    
    $(window).scroll(function() {
        // If already showed up once we dont need to show it again - so return
        if( popout_appeared ) return;
        // Just above the comments area
        //var position = Math.floor($('.singular #content .post').height() / 3);
        var position = jQuery("#muckreads").offset().top - 250;
        var theWindow = $(window).scrollTop();
        var removePoint = position + 1500;
        
        if( theWindow >= position /*&& theWindow <= removePoint*/ ) {
            if( !popout_exists ) {
                $('#popout-box').animate({right : '10'}, 500).delay(10000).animate({right: '-330'}, 500);
                popout_exists = true;
            }
        }/* else {
            if( popout_exists ) {
                $('#popout-box').animate({right : '-330'}, 500);
                popout_exists = false;
                popout_appeared = true;
            }
        }*/
    });

    $('.close-donate').click(function(e) {
        e.preventDefault();
        $('#popout-box').animate({right : '-330'}, 500);
        popout_exists = false;
        popout_appeared = true;
    });

});

</script>
<!-- END SLIDING POP OUT -->

<div id="sidebar" class="span4">
	<?php get_sidebar(); ?>
</div><!-- /.grid_4 -->
<?php get_footer(); ?>