<?php
/*
 *	Template Name: Leadership
 */
$context = Timber::context();
$timber_post = new Timber\Post();
$context['post'] = $timber_post;
$context['leaders_list'] = $timber_post->meta('leaders_list');

Timber::render( array( 'pages/leadership.twig' ), $context );
