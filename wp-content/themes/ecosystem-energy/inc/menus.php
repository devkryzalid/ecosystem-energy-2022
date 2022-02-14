<?php
/**
 * You should not put any add_action in this file, please configue all hooks in functions.php
 */


/**
 * Create menu positioning.
 */
register_nav_menus(
	[
		'menu-primary' => esc_html__( 'Primary', 'ecosystem-energy' ),
		'menu-secondary' => esc_html__( 'Secondary', 'ecosystem-energy' ),
		'menu-footer' => esc_html__( 'Footer Main', 'ecosystem-energy' ),
		'submenu-footer' => esc_html__( 'Footer Sub', 'ecosystem-energy' ),
	]
);
