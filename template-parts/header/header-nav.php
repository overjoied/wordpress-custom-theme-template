<?php
	if ( has_nav_menu( 'primary' ) ) {
		$args = array(
			'theme_location'  => 'primary',
			'menu_class'      => 'header-menu',
			'menu_id'         => 'header-menu',
			'container'       => 'nav',
			'container_class' => 'site-header__nav',
			'fallback_cb'     => false,
			'walker'          => new Custom_Theme_Walker_Nav_Menu(),
		);

		wp_nav_menu( $args );
	}
