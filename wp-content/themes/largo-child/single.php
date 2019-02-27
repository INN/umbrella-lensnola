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

		<div id="sidebar" class="span4">
			<?php get_sidebar('single'); ?>
			
		</div><!-- /.grid_4 -->
		
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
