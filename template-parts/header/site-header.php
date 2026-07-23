<?php
/**
 * Displays the site header.
 *
 * @package CustomTheme
 */

?>

<header class="site-header">
    <?php get_template_part( 'template-parts/header/header-nav' ); ?>

    <?php echo do_shortcode('[button text="Shortcode Button"]'); ?>
    <?php echo do_shortcode('[button-link text="Shortcode Button Link"]'); ?>
</header>
