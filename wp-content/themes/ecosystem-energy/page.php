<?php
// Create ou change current_locale cookie and get local for request
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];

$context = Timber::context();
$timber_post = new Timber\Post();

if (isset($newLocale)) {
   $context = set_current_locale_cookie($newLocale, $context);
}

$context['post'] = $timber_post;
$context['title'] = $timber_post->title;
$context['thumbnail'] = $timber_post->thumbnail;

Timber::render(array( 'pages/page.twig' ), $context);
