<?php

$context = Timber::context();

// Create ou change current_locale cookie and get local for request
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) {
   $context = set_current_locale_cookie($newLocale, $context);
}

$timber_post = new Timber\Post();

// Set base informations for context
$context['post']     = $timber_post;
$context['author']   = $timber_post->meta('author');
$context['category'] = get_terms(['taxonomy' => 'category'])[0];
$context['tags']     = get_the_tags($timber_post->ID);

Timber::render('pages/single-perspective.twig', $context);
