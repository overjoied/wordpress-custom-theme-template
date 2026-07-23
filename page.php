<?php
/**
 * The template for displaying all pages.
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/content/content-page' );

endwhile; // End of the loop.

get_footer();
