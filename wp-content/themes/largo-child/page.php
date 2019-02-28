<?php
/**
 * The Template for displaying all pages.
 *
 * Differs from Largo's page.php through the addition of this action.
 * Differs from page-no-menu.php through the non-addition of this action.
 */
add_action( 'largo_after_hero', 'lens_sidebar_page_nav' );

locate_template( 'single.php', true );
