<?php

$context = Timber::context();

$timber_post = new Timber\Post();
/**
 * Timber context assignments
 */
$context['post'] = $timber_post;

Timber::render('pages/sample-template.twig', $context);
