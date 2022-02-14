<?php
/**
 * The template for displaying the homepage.
 */
$context = Timber::context();
$timber_post = new Timber\Post();
$context['post'] = $timber_post;

Timber::render( array( 'pages/front-page.twig' ), $context );
