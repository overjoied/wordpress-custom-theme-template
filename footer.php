<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the main tag and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */
?>

</main>

<footer class="site-footer">
	<?php get_template_part( 'template-parts/footer/footer-nav' ); ?>

	<div class="site-info">
		<div class="site-info__name">
			<?php if ( has_custom_logo() ) : ?>
				<div class="site-logo"><?php the_custom_logo(); ?></div>
			<?php else : ?>
				<?php if ( get_bloginfo( 'name' ) && get_theme_mod( 'display_title_and_tagline', true ) ) : ?>
					<?php if ( is_front_page() && ! is_paged() ) : ?>
						<?php bloginfo( 'name' ); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		</div><!-- .site-info__name -->

		<?php
		if ( function_exists( 'the_privacy_policy_link' ) ) {
			the_privacy_policy_link( '<div class="privacy-policy">', '</div>' );
		}
		?>

	</div><!-- .site-info -->
</footer>

<?php wp_footer(); ?>
</body>
</html>
