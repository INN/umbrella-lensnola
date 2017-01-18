<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

		<div id="content" class="content-single span8" role="main">

				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'single' );
					comments_template( '', true );
				endwhile; // end of the loop.
				?>

		</div><!--/.grid_8 #content-->


			<?php get_sidebar('single'); ?>

			<?php if ( in_category( 'squandered-heritage-vintage' )): ?>
				<aside class="widget single"><em>This story was originally published on Squandered Heritage, the blog that Karen Gadbois created to track threatened historic houses in New Orleans. That work led to the <a href="<?php echo home_url('/about-us');?>" title="About The Lens">founding of The Lens in 2009</a>. We&#8217;ve moved all of those early stories to The Lens, including this one. You also can read her <a href="<?php echo home_url('/hbos-treme-spotlights-lens-founder-karen-gadbois');?>" title="Best of Squandered Heritage 2006-2010">best stories from 2006 to 2010</a> and <a href="<?php echo home_url('/squandered-heritage-archives');?>" title="Squandered Heritage 2006-2010 Archives">browse the archives from that time</a>. Gadbois continues to <a href="<?php echo home_url('/category/squandered-heritage');?>">cover land use and historic preservation</a> for The Lens.</em></aside>
			<?php endif; ?>

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
        var position = jQuery(".disclosure-container").offset().top - 250;
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

<?php get_footer(); ?>