<?php
/*
 *	Template Name: Contact us
 */

// Create ou change current_locale cookie
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) {
    set_current_locale_cookie($newLocale);
}
$context = Timber::context();
$timber_post = new Timber\Post();
$context['post'] = $timber_post;
$context['offices_list'] = $timber_post->meta('offices_list');

Timber::render( array( 'pages/contact.twig' ), $context );
