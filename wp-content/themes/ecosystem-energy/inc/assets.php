<?php
/**
 * You should not put any add_action in this file, please configue all hooks in functions.php
 */

/**
 * Call .css and .js files
 */
function adding_scripts_and_styles() {
	global $post;
	$template = get_page_template_slug( $post->ID );
	// Javacript
	// -- Jquery
	wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true );
	// -- Google Maps
	wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDRiCqeIhDRY-8COkjQC5vTSh03LiQCWAg', array(), null, true );
	// -- Swiper JS
	wp_enqueue_script( 'swiper-js', 'https://unpkg.com/swiper/js/swiper.min.js', array(), null, true );
	// -- Swiper CSS
	wp_enqueue_style( 'swiper-css', 'https://unpkg.com/swiper/css/swiper.min.css', array() );
	// -- Main JS
	wp_enqueue_script( 'site-main', get_template_directory_uri() . '/dist/scripts/main.min.js', array( 'jquery' ), true );
	// -- Wysiwyg block Js
	wp_enqueue_script( 'site-custom-wysiwyg', get_template_directory_uri() . '/dist/scripts/utils/wysiwyg-blocks.min.js', array( 'jquery' ), true );
	// -- Pages
	/*
	switch ( $template ) {
		case 'templates/jobs.php':
			wp_enqueue_script( 'jobs', get_template_directory_uri() . '/dist/scripts/pages/jobs.js', array( 'jquery' ), true );
			break;
	}
	*/
	// CSS
	wp_enqueue_style( 'site-style', get_template_directory_uri() . '/dist/styles/main.css', array() );
}

/**
 * Gutenberg scripts and styles
 * @link https://www.billerickson.net/block-styles-in-gutenberg/
 *
 */
function be_gutenberg_scripts() {
	wp_enqueue_script(
		'be-editor',
		get_stylesheet_directory_uri() . '/assets/scripts/editor.js',
		array( 'wp-blocks', 'wp-dom' ),
		filemtime( get_stylesheet_directory() . '/assets/scripts/editor.js' ),
		true
	);
}

/**
 * Registers an editor stylesheet for the theme.
 */
function wpdocs_theme_add_editor_styles()
{
	wp_enqueue_style( 'site-admin-style', get_template_directory_uri() . '/editor-style.css', array() );
}
add_action('enqueue_block_editor_assets', 'wpdocs_theme_add_editor_styles');
