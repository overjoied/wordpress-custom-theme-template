<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

foreach ( \CustomTheme\get_custom_sidebars() as $sidebar ) :
	if ( is_page_template( $sidebar['template'] ) ) :
		?>
		<aside id="<?php echo esc_attr( $sidebar['id'] ); ?>" class="widget-area">
			<?php dynamic_sidebar( $sidebar['id'] ); ?>
		</aside>
		<?php
		break;
	endif;
endforeach;
?>