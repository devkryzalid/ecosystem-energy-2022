<?php
/*
 *	Template Name: Expertises
 */
$context = Timber::context();
$timber_post = new Timber\Post();
$context['post'] = $timber_post;
$context['featured_content'] = $timber_post->meta('featured_content');

Timber::render( array( 'pages/expertises.twig' ), $context );
