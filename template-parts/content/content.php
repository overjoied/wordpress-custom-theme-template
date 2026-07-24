<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */
?>

<article id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_singular() ) : ?>
			<?php get_template_part( 'template-parts/header/entry-header' ); ?>
		<?php else : ?>
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php endif; ?>

		<?php \CustomTheme\custom_theme_post_thumbnail(); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content(
			\CustomTheme\custom_theme_continue_reading_text()
		);

		\CustomTheme\custom_theme_link_pages();
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php \CustomTheme\custom_theme_entry_meta_footer(); ?>
	</footer><!-- .entry-footer -->
</article>