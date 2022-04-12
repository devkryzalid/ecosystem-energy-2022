<?php
/**
 * Load composer namespacing
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Includes
 */

import_folder( __DIR__ . '/inc' );
import_folder( __DIR__ . '/commands' );

/**
 *  Non-environnement Constants
 */
define( 'DEFAULT_IMAGE', 'https://source.unsplash.com/random' );

/**
 * Load translations for wpdocs_theme
 */
function wpdocs_theme_setup()
{
	load_theme_textdomain('ecosystem-energy', get_template_directory() . '/languages');
}

function add_file_types_to_uploads($mimes)
{
	$mimes['svg'] = 'image/svg';
	$mimes['epub'] = 'application/epub+zip';
	return $mimes;
}

/**
 * Hook actions
 * functions are imported from files in /inc
 * default values are pririty 10 and args 1
 */
$hooks_actions = [
	'init' => [
		15 => ['name' => 'register_post_types', 'args' => 1],
		10 => ['name' => 'register_taxonomies', 'args' => 1],
	],
	'after_setup_theme' => [
		10 => ['name' => 'theme_supports', 'args' => 1],
	],
	'wp_enqueue_scripts' => [
		10 => ['name' => 'adding_scripts_and_styles', 'args' => 1],
	],
	'enqueue_block_editor_assets' => [
		10 => ['name' => 'be_gutenberg_scripts', 'args' => 1],
	],
	'timber/context' => [
		10 => ['name' => 'add_to_context', 'args' => 1],
	],
	'timber/twig' => [
		10 => ['name' => 'add_to_twig', 'args' => 1],
	],
	'acf/init' => [
		10 => ['name' => 'register_custom_blocks', 'args' => 1],
	],
	'pre_get_posts' => [
		10 => ['name' => 'meta_or_title', 'args' => 1],
	],
	'phpmailer_init' => [
        10 => ['name' => 'mailtrap', 'args' => 1],
    ],
	'generate_rewrite_rules' => [
		10 => ['name' => 'add_rewrite_rules', 'args' => 1]
	],
	'user_register' => [
		10 => ['name' => 'add_custom_user_meta', 'args' => 1],
	],
	'edit_user_profile_update' => [
		10 => ['name' => 'add_custom_user_meta', 'args' => 1],
	],
	'personal_options_update' => [
		10 => ['name' => 'add_custom_user_meta', 'args' => 1],
	],
];
foreach ( $hooks_actions as $hook => $functions ) {
	foreach ($functions as $priority => $function) {
		add_action($hook, $function['name'], $priority, $function['args']);
	}
};

/**
 * Hook filters
 * functions are imported from files in $includes
 * default values are pririty 10 and args 1
 */
$hooks_filters = [
	'acf/validate_value/name=postal_code' => [
		10 => ['name' => 'validate_postal_code', 'args' => 4],
	],
	'acf/settings/show_admin' => [
		10 => ['name' => 'hide_acf_admin', 'args' => 1],
	],
	'acf/settings/save_json' => [
		10 => ['name' => 'acf_json_save', 'args' => 1],
	],
	'acf/settings/load_json' => [
		10 => ['name' => 'acf_json_load', 'args' => 1],
	],
	'use_block_editor_for_post_type' => [
		10 => ['name' => 'disable_gutenberg', 'args' => 1],
	],
	'allowed_block_types_all' => [
		10 => ['name' => 'gutenberg_allowed_block_types', 'args' => 1],
	],
	'upload_mimes' => [
		10 => ['name' => 'add_file_types_to_uploads', 'args' => 1],
	],
	'template_include' => [
		10 => ['name' => 'redirect_archive_template', 'args' => 1],
	],
	'pre_get_posts' => [
		10 => ['name' => 'search_filter', 'args' => 1],
	],
	'locale' => [
		10 => ['name' => 'set_current_language', 'args' => 1],
	],
 	'post_link' =>
	 	[1 => ['name' => 'change_nouvelle_links', 'args' => 3]
	],
 	'post_type_archive_link' =>
	 	[10 => ['name' => 'change_nouvelle_archive_link', 'args' => 2]
	],
 	'register_post_type_args' =>
	 	[20 => ['name' => 'customize_default_wp_post_type', 'args' => 2]
	],
];
foreach ( $hooks_filters as $hook => $functions ) {
	foreach ($functions as $priority => $function) {
        add_filter($hook, $function['name'], $priority, $function['args']);
	}
}

/**
 * Commands
 */
if (class_exists('WP_CLI')) { // this condition is important, ad WP_CLI class does not exist in admin.
	WP_CLI::add_command('duplicate_post', 'DuplicatePost');
	WP_CLI::add_command('import_old_data', 'ImportOldData');
}

/**
 * Functions
 * Put here any function which use is very general. Please always try to keep this
 * file small and clean, and divide it into the /inc folder.
 */
function import_folder( string $path ) {
	$includes = scandir( $path );
	foreach ( $includes as $file ) {
		$path_file = $path . '/' . $file;
		// Require every file in path
		if ( ! is_dir( $path_file ) ) {
			require_once $path_file;
		} elseif ( $file !== '.' && $file !== '..' ) { // Import recursively files in directories that are not the directory itself nor the parent
			import_folder( $path_file );
		}
	}
}

// ####################
// redefined Wordpress local value if in ajax/fr url
// @TODO: change this in the future
// ####################
function set_current_language($locale)
{
	if (empty($_SERVER['REQUEST_URI'])) {
		return;
	}
	$split = explode('/', $_SERVER['REQUEST_URI']);
	if ($split[1] == 'ajax') {
		if ($split[2] == 'fr') {
			return 'fr_FR';
		}
	}
	return $locale;
}

/**
 * Used to init google map, simply sets the api key
 */
function google_map_api( $api ) {
	$api['key'] = GOOGLE_MAP_API_KEY;

	return $api;
}

function mailtrap($phpmailer)
{
	if (WP_DEBUG == true) {
		$phpmailer->isSMTP();
		$phpmailer->Host = 'smtp.mailtrap.io';
		$phpmailer->SMTPAuth = true;
		$phpmailer->Port = 2525;
		$phpmailer->Username = 'c42372a24b3ca7';
		$phpmailer->Password = '3c0244a1dafdd6';
	}
}

/**
 * Add Config Options Page for Theme (Custom with ACF)
 */
if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		 'page_title' => 'Paramètres du thème Ecosystem-energy',
		 'menu_title' => 'Thème Config',
		 'menu_slug'  => 'theme-general-settings',
		 // limit acces for only admin and super_admin
		 'capability' => 'manage_options',
		 'redirect'   => true
	));
	
	// Footer Option Page
	acf_add_options_sub_page(array(
		 'page_title'  => 'Paramètres Global',
		 'menu_title'  => 'Paramètres Global',
		 'parent_slug' => 'theme-general-settings',
	));
}

/**
 * IT'S FUNCTION IT'S JUSTE FOR OVERWRITE WPML MANAGER TRANSLATOR FUNCTION
 */
function add_custom_user_meta($user_id)
{
	global $wpdb;
	$default = ["fr" => ["en" => 1], "en" => ["fr" => 1]];
	$user_meta = get_user_meta(
		$user_id,
		$wpdb->prefix . 'language_pairs',
		true
	);

	if (empty($user_meta)) {
		add_user_meta($user_id, $wpdb->prefix . 'language_pairs', $default);
	} elseif ($default !== $user_meta) {
		update_user_meta($user_id, $wpdb->prefix . 'language_pairs', $default);
	}
}
