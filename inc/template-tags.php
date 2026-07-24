<?php
/**
 * Custom template tags for this theme
 *
 * @package CustomTheme
 */

namespace CustomTheme;

if ( ! function_exists( 'custom_theme_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 * @return void
	 */
	function custom_theme_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);
		echo '<span class="posted-on">';
		printf(
			/* translators: %s: Publish date. */
			esc_html__( 'Published %s', 'custom-theme' ),
			$time_string // phpcs:ignore WordPress.Security.EscapeOutput
		);
		echo '</span>';
	}
}

if ( ! function_exists( 'custom_theme_posted_by' ) ) {
	/**
	 * Prints HTML with meta information about theme author.
	 *
	 * @return void
	 */
	function custom_theme_posted_by() {
		if ( ! get_the_author_meta( 'description' ) && post_type_supports( get_post_type(), 'author' ) ) {
			echo '<span class="byline">';
			printf(
				/* translators: %s: Author name. */
				esc_html__( 'By %s', 'custom-theme' ),
				'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . esc_html( get_the_author() ) . '</a>'
			);
			echo '</span>';
		}
	}
}

if ( ! function_exists( 'custom_theme_entry_meta_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 * Footer entry meta is displayed differently in archives and single posts.
	 *
	 * @return void
	 */
	function custom_theme_entry_meta_footer() {

		// Early exit unless the post type opts in (see register_entry_meta_footer_support()).
		if ( ! post_type_supports( get_post_type(), 'entry-meta-footer' ) ) {
			return;
		}

		// Hide meta information on pages.
		if ( ! is_single() ) {

			if ( is_sticky() ) {
				echo '<p>' . esc_html_x( 'Featured post', 'Label for sticky posts', 'custom-theme' ) . '</p>';
			}

			$post_format = get_post_format();
			if ( 'aside' === $post_format || 'status' === $post_format ) {
				echo '<p><a href="' . esc_url( get_permalink() ) . '">' . custom_theme_continue_reading_text() . '</a></p>'; // phpcs:ignore WordPress.Security.EscapeOutput
			}

			// Posted on.
			custom_theme_posted_on();

			// Edit post link.
			edit_post_link(
				sprintf(
					/* translators: %s: Post title. Only visible to screen readers. */
					esc_html__( 'Edit %s', 'custom-theme' ),
					'<span class="screen-reader-text">' . get_the_title() . '</span>'
				),
				'<span class="edit-link">',
				'</span><br>'
			);
		} else {

			echo '<div class="posted-by">';
			// Posted on.
			custom_theme_posted_on();
			// Posted by.
			custom_theme_posted_by();
			// Edit post link.
			edit_post_link(
				sprintf(
					/* translators: %s: Post title. Only visible to screen readers. */
					esc_html__( 'Edit %s', 'custom-theme' ),
					'<span class="screen-reader-text">' . get_the_title() . '</span>'
				),
				'<span class="edit-link">',
				'</span>'
			);
			echo '</div>';
		}

		if ( has_category() || has_tag() ) {

			echo '<div class="post-taxonomies">';

			$categories_list = get_the_category_list( wp_get_list_item_separator() );
			if ( $categories_list ) {
				printf(
					/* translators: %s: List of categories. */
					'<span class="cat-links">' . esc_html__( 'Categorized as %s', 'custom-theme' ) . ' </span>',
					$categories_list // phpcs:ignore WordPress.Security.EscapeOutput
				);
			}

			$tags_list = get_the_tag_list( '', wp_get_list_item_separator() );
			if ( $tags_list && ! is_wp_error( $tags_list ) ) {
				printf(
					/* translators: %s: List of tags. */
					'<span class="tags-links">' . esc_html__( 'Tagged %s', 'custom-theme' ) . '</span>',
					$tags_list // phpcs:ignore WordPress.Security.EscapeOutput
				);
			}
			echo '</div>';
		}
	}
}

/**
 * Registers post-type support for the entry meta footer, so any post type
 * can opt in without touching the shared custom_theme_entry_meta_footer().
 */
function register_entry_meta_footer_support() {
	add_post_type_support( 'post', 'entry-meta-footer' );
}
add_action( 'init', __NAMESPACE__ . '\register_entry_meta_footer_support' );

if ( ! function_exists( 'custom_theme_link_pages' ) ) {
	/**
	 * Prints pagination links for paginated posts/pages.
	 *
	 * @return void
	 */
	function custom_theme_link_pages() {
		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'custom-theme' ) . '">',
				'after'    => '</nav>',
				/* translators: %: Page number. */
				'pagelink' => esc_html__( 'Page %', 'custom-theme' ),
			)
		);
	}
}

if ( ! function_exists( 'custom_theme_posts_loop' ) ) {
	/**
	 * Runs the standard WordPress Loop, rendering each post through the given
	 * template part slug (respecting the excerpt/full-post customizer
	 * setting), or the "no posts found" template part when the query is empty.
	 *
	 * @param string $template Template part slug passed to get_template_part().
	 * @return void
	 */
	function custom_theme_posts_loop( $template = 'template-parts/content/content' ) {
		if ( ! have_posts() ) {
			get_template_part( 'template-parts/content/content-none' );
			return;
		}

		$content_type = get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' );

		while ( have_posts() ) {
			the_post();
			get_template_part( $template, $content_type );
		}
	}
}

if ( ! function_exists( 'custom_theme_search_results_title' ) ) {
	/**
	 * Prints the "Results for %s" search-results heading.
	 *
	 * @return void
	 */
	function custom_theme_search_results_title() {
		printf(
			/* translators: %s: Search term. */
			esc_html__( 'Results for "%s"', 'custom-theme' ),
			'<span class="page-description search-term">' . esc_html( get_search_query() ) . '</span>'
		);
	}
}

if ( ! function_exists( 'custom_theme_post_thumbnail' ) ) {
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @return void
	 */
	function custom_theme_post_thumbnail() {
		if ( ! custom_theme_can_show_post_thumbnail() ) {
			return;
		}
		?>

		<?php if ( is_singular() ) : ?>

			<figure class="post-thumbnail">
				<?php
				// Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
				the_post_thumbnail( 'post-thumbnail', array( 'loading' => false ) );
				?>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure><!-- .post-thumbnail -->

		<?php else : ?>

			<figure class="post-thumbnail">
				<a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'post-thumbnail' ); ?>
				</a>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure><!-- .post-thumbnail -->

		<?php endif; ?>
		<?php
	}
}
