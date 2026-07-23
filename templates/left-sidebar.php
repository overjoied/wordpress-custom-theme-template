<?php
/**
 * Template Name: Page with Left Sidebar
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

get_header();
?>

<div>
  <?php
  get_sidebar();

  \CustomTheme\custom_theme_posts_loop();
  ?>
</div>

<?php get_footer(); ?>