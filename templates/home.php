<?php
/**
 * Template Name: Home Page
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

get_header();

\CustomTheme\custom_theme_posts_loop( 'template-parts/content/content-page' );

get_footer();
