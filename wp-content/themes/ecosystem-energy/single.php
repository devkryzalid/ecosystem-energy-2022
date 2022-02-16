<?php

$context = Timber::context();

$timber_post = new Timber\Post();
/**
 * Timber context assignments
 */
$context['post']     = $timber_post;
$context['author']   = $timber_post->meta('author');
$context['category'] = get_terms(['taxonomy' => 'category'])[0];
$context['tags']     = get_the_tags($timber_post->ID);
// TODO add local

Timber::render('pages/single-perspective.twig', $context);
