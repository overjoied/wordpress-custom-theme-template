<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

get_header();
?>

<div class="error-404 not-found">
	<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', TEXT_DOMAIN ); ?></p>
	<?php get_search_form(); ?>
</div><!-- .error-404 -->

<?php get_footer(); ?>