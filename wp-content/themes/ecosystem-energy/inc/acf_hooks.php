<?php
/**
 * You should not put any add_action in this file, please configue all hooks in functions.php
 */

/**
 * Hides the ACF panel in admin
 *
 * This compares the current site url with a list of url
 * where the admin should be hidden. The goal is to avoid ACF conflicts
 * and force the productions servers to use only json.
 *
 */
function hide_acf_admin() {
	$site_url = get_bloginfo( 'url' );
	// Acf admin will be hidden for those urls
	$protected_urls = [
		//'http://ton-stage.kryzastage.com',
	];
	if ( in_array( $site_url, $protected_urls ) ) {
		return false;
	} else {
		return true;
	}
}

/**
 * Validates field postal_code for Canadian postal code format
 *
 * Format is A1A 1A1, where A is a letter and 1 is a digit,
 * with a space separating the third and fourth characters
 */
function validate_postal_code( $valid, $value, $field, $input ) {
	if ( ! $valid ) {
		return $valid;
	}
	if ( ! preg_match( '/[A-Z][0-9][A-Z] [0-9][A-Z][0-9]/', $value ) ) {
		$valid = __( 'Le format du code postal doit être le suivant : A1A 1A1', 'ecosystem-energy' );
	}

	return $valid;
}

// save ACF fields in json file
function acf_json_save($path)
{
	$path = get_template_directory() . '/acf-json';
	return $path;
}

// Load the json file for acf
function acf_json_load($paths)
{
	unset($paths[0]);
	$paths[] = get_template_directory() . '/acf-json';
	return $paths;
}
