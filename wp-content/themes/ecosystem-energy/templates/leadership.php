<?php
/*
 *	Template Name: Leadership
 */

$context = Timber::context();

// Create ou change current_locale cookie and get local for request
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) {
    $context = set_current_locale_cookie($newLocale, $context);
}
// Set base informations for context
$timber_post = new Timber\Post();
$context['post'] = $timber_post;
$context['leaders_list'] = $timber_post->meta('leaders_list');

Timber::render( array( 'pages/leadership.twig' ), $context );
