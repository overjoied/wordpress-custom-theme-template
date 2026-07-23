<?php
    if ( has_nav_menu( 'footer' ) ) {
        $args = array(
            'theme_location'  => 'footer',
            'menu_class'      => 'footer-menu',
            'menu_id'         => 'footer-menu',
            'container'       => 'nav',
            'container_class' => 'site-footer__nav',
        );

        wp_nav_menu( $args );
    }
?>
