<?php
/**
 * You should not put any add_action in this file, please configue all hooks in functions.php
 */

/**
 * Include every file in /inc/taxonomies
 */
$includes = scandir( __DIR__ . '/taxonomies' );
foreach ( $includes as $file ) {
	$path_file = __DIR__ . '/taxonomies/' . $file;
	if ( file_exists( $path_file ) && ! is_dir( $path_file ) ) {
		require_once $path_file;
	}
}

/** This is where you can register custom taxonomies. */
function register_taxonomies() {

	/**
     * Init global params
     */

    $labelsGlobal = [
        'search_items'  => __('Recherche', 'ecosystem-energy'),
        'all_items'     => __('Tous', 'ecosystem-energy'),
        'edit_item'     => __('Modifier', 'ecosystem-energy'),
        'update_item'   => __('Modifier', 'ecosystem-energy'),
        'add_new_item'  => __('Ajouter', 'ecosystem-energy'),
        'new_item_name' => __('Nouveau', 'ecosystem-energy'),
    ];
    $argsGlobal = [
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true
	];
	
	localization_taxonomy($labelsGlobal, $argsGlobal);
    industry_taxonomy($labelsGlobal, $argsGlobal);
}
