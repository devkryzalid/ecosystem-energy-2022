<?php
/*
 *	Template Name: Error 404
 */

$context = Timber::context();
$timber_post = new Timber\Post();
$context['post'] = $timber_post;

Timber::render( array( 'pages/404.twig' ), $context );