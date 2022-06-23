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
	// Theme configs
	$context['theme_infos']         = get_field('infos', 'options');
	$context['social_networks']     = get_field('social_networks', 'options');
	$context['cta_contact']         = get_field('cta_contact', 'options');
	$context['static_links']        = get_field('static_links', 'options');
	$context['current_lang']        = ICL_LANGUAGE_CODE;
	$context['current_locale']      = !empty($_COOKIE['es_current_locale']) ? $_COOKIE['es_current_locale'] : '-1';
	$context['current_locale_name'] = $context['current_locale'] != '-1' ? get_term($context['current_locale'])->name : '';
	$context['locales']             = get_terms( [ 'taxonomy' => 'localization' ] );
	$context['current_url']         = Timber\URLHelper::get_current_url();

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

  // Translate month name, since ajax locale is kinda fucked up
	$twig->addFilter(
		new Twig\TwigFilter(
			'translate_date',
			function($date) {
        $isDateFr = !strpos($date, ',');
        if ($isDateFr) {
          $en = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
          $fr = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
          $str = str_replace($en, $fr, $date);
          return (!$str[0]) ? ltrim($str, '0') : $str; 
        }
        else return $date;
			}
		)
	);

	return $twig;
}

function set_current_locale_cookie($newLocale, $context) {
	if ($newLocale == '-1') {
		setcookie('es_current_locale', null, strtotime('-1 day'));
	} else {
		setcookie('es_current_locale', $newLocale, strtotime("+1 year"));
		// Testing purposes
		// setcookie('es_current_locale', $newLocale, strtotime("+1 minute"));
	}
	
	$context['current_locale'] = $newLocale;
	$context['current_locale_name'] = $newLocale != '-1' ? get_term($newLocale)->name : '';
	return $context;
}
