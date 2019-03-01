<?php

function largo_child_before_largo_header() {
	?>
		<div id="ad-banner-container">
			<div id="ad-banner" class="row-fluid clearfix">
				<?php
					dynamic_sidebar( 'top_banner' );
					dynamic_sidebar( 'top_text' );
				?>
				<div class="clearfix"></div>
			</div>
		</div>
	<?php
}
add_action( 'largo_header_before_largo_header', 'largo_child_before_largo_header' );

function largo_child_after_largo_header() {
	?>
		<div id="top_about_section">
			<?php if ( dynamic_sidebar( 'top_about_section' ) ) :
				  else : ?>
			<?php endif; ?>
			<div class="clearfix"></div>
		</div>
	<?php
}
add_action( 'largo_header_after_largo_header', 'largo_child_after_largo_header' );
