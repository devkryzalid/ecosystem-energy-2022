<?php
/**
 * You should not put any add_action in this file, please configue all hooks in functions.php
 */

/**
 * Include every file in /inc/post_types
 */
$includes = scandir( __DIR__ . '/post_types' );
foreach ( $includes as $file ) {
	$path_file = __DIR__ . '/post_types/' . $file;
	if ( file_exists( $path_file ) && ! is_dir( $path_file ) ) {
		require_once $path_file;
	}
}

/**
 * change folder path for archive and single CPT
 */
function redirect_archive_template($template)
{
	if (is_post_type_archive()) {
		if ($_template = locate_template('archives/archive-' . get_post_type() . '.php')) {
			$template = $_template;
		}
	} elseif (is_single()) {
		if ($_template = locate_template('singles/single-' . get_post_type() . '.php')) {
			$template = $_template;
		}
	}
	return $template;
}

/**
 * Calls the registration functions of all custom post types
 *
 * This hook will be called on init
 * Put here every register function that are in /post_types/*.php files
 */
function register_post_types() {
	sample_custom_post_type();
}


/**
 * DOESN'T MISSING CALL THERE HOOK IN FUNCTIONS.PHP
 * in hook actions : 
 * 		'generate_rewrite_rules' => [10 => ['name' => 'add_rewrite_rules', 'args' => 1]]
 * in hook filters : 
 * 		'post_link' => [1 => ['name' => 'change_nouvelle_links', 'args' => 3]]
 *		'post_type_archive_link' => [10 => ['name' => 'change_nouvelle_archive_link', 'args' => 2]]
 *   	'register_post_type_args' => [20 => ['name' => 'customize_default_wp_post_type', 'args' => 2]]
 */

/**
 * IF YOU WANT CHANGING DEFAULT POST NAME AND ALL TITLE IN ADMIN PANEL
 */
function customize_default_wp_post_type($args, $post_type)
{
	if ($post_type == "post") {
		$custom_args = [
			'labels' => [
				'name'                     => 'Nouvelles',
				'singular_name'            => 'Nouvelle',
				'all_items'                => 'Toutes les nouvelles',
				'view_item'                => 'Voir la nouvelle',
				'search_items'             => 'Trouver une nouvelle',
				'menu_name'                => 'Nouvelle',
				'name_admin_bar'           => 'Nouvelle',
			],
			'has_archive' => true,
		];
		return array_merge($args, $custom_args);
	}

	return $args;
}

// CHANGE PREFIX FOR DEFAULT POST URL
function add_rewrite_rules($wp_rewrite)
{
	$new_rules = array(
		'nouvelles/(.+?)/?$' => 'index.php?post_type=post&name=' . $wp_rewrite->preg_index(1),
	);

	$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

function change_nouvelle_links($post_link, $id = 0)
{
	$post = get_post($id);

	if (is_object($post) && $post->post_type == 'post') {
		return home_url('/nouvelles/' . $post->post_name . '/');
	}

	return $post_link;
}

function change_nouvelle_archive_link($link, $post_type)
{
	if ('post' == $post_type) {
		return '/nouvelles/';
	}
	return $link;
}