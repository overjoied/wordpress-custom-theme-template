<?php
/**
 * Template Name: Page with Right Sidebar
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

get_header();
?>

<div>
  <?php
    \CustomTheme\custom_theme_posts_loop();

    get_sidebar();
  ?>
</div>

<?php get_footer(); ?>