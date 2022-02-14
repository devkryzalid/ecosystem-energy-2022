<?php
/**
 * You should not put any add_action in this file, please configue all hooks in functions.php
 */


$timber = new Timber\Timber();
/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {
	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not present, please run a composer install.</p></div>';
		}
	);
	add_filter(
		'template_include',
		function( $template ) {
			return __DIR__ . '/no-timber.html';
		}
	);
	return;
}
/**
 * Sets the directories to find .twig files
 */
Timber::$dirname = array( 'views' );
/**
 * Twig's autoescape
 */
Timber::$autoescape = false;
