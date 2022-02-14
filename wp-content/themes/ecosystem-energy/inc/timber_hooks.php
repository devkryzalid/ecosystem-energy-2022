<?php
/**
 * You should not put any add_action in this file, please configue all hooks in functions.php
 */


/**
 * This is where you add some context
 *
 * @param string $context context['this'] Being the Twig's {{ this }}.
 */
function add_to_context( $context ) {
	// Menus
	$context['menu_primary'] = new \Timber\Menu( 'menu-primary', [ 'depth' => 4 ] );
	$context['menu_secondary'] = new \Timber\Menu( 'menu-secondary' );
	$context['menu_footer'] = new \Timber\Menu( 'menu-footer' );
	$context['submenu_footer'] = new \Timber\Menu( 'submenu-footer' );

	/*
     * Create a custom breadcrumb
     */
    $timber_post = new Timber\Post();
    $breadcrumbs = [];
    foreach (get_post_ancestors($timber_post) as $item) {
        $breadcrumbs[] = new Timber\Post($item);
    }
    $context['breadcrumbs']       = array_reverse($breadcrumbs);
    $context['yoast_description'] = \WPSEO_Meta::get_value('metadesc');

	return $context;
}

/** This is where you can add your own functions to twig.
 *
 * @param string $twig get extension.
 */
function add_to_twig( $twig ) {
	$twig->addExtension( new Twig\Extensions\DateExtension() );
	/**
	 * Filter time_ago, but modifiable !
	 */
	$twig->addFilter(
		new Twig\TwigFilter(
			'timey_ago',
			function( $string ) {
				return time_elapsed_string( $string ); // this function is in functions.php
			}
		)
	);

	return $twig;
}
