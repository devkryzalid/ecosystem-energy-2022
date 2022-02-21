<?php
/**
 * You should not put any add_action in this file, please configue all hooks in functions.php
 */

/**
 * Call .css and .js files
 */
function adding_scripts_and_styles() {
	// -- Main JS
	wp_enqueue_script( 'site-main', get_template_directory_uri() . '/dist/scripts/app.js', array(), true, true );

  // -- Page-specific JS
	// global $post;
  // print_r($post);
  // $root = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/ecosystem-energy';
  // $script_name = str_replace('_', '-', $post->post_type);
  // $script_file = '/dist/scripts/pages/' . $script_name . '.js';

  // if (file_exists($root . $script_file)) {
  //   wp_enqueue_script( 'site-page', get_template_directory_uri() . $script_file, array(), true, true );
  // }

	// -- Wysiwyg block Js
	// wp_enqueue_script( 'site-custom-wysiwyg', get_template_directory_uri() . '/dist/scripts/utils/wysiwyg-blocks.min.js', array( 'jquery' ), true );
	
	// -- CSS
	wp_enqueue_style( 'site-style', get_template_directory_uri() . '/dist/styles/app.css', array() );
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
		array('wp-blocks', 'wp-dom'),
		filemtime(get_stylesheet_directory() . '/assets/scripts/editor.js'),
		true,
    true
	);
}

/**
 * Registers an editor stylesheet for the theme.
 */
function wpdocs_theme_add_editor_styles() {
	wp_enqueue_style( 'site-admin-style', get_template_directory_uri() . '/dist/styles/editor.css', array() );
}
add_action('enqueue_block_editor_assets', 'wpdocs_theme_add_editor_styles');
