<?php
/*
 *	Template Name: Contact us
 */
$context = Timber::context();
$timber_post = new Timber\Post();
$context['post'] = $timber_post;
$context['offices_list'] = $timber_post->meta('offices_list');

Timber::render( array( 'pages/contact.twig' ), $context );
