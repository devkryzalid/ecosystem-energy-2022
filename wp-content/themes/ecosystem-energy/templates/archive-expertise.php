<?php
/*
 *	Template Name: Expertises
 */
$limit   = empty($_GET['limit']) ? -1 : $_GET['limit'];
$paged   = empty($_GET['paged']) ? 1 : $_GET['paged'];

$context     = Timber::context();
$timber_post = new Timber\Post();

$context['post']             = $timber_post;
$context['featured_content'] = $timber_post->meta('featured_content');

/**
 * Query arguments
 */
$args = [
   'post_type'       => 'expertise',
   'post_status'     => 'publish',
   'orderby'         => 'publish_date',
   'order'           => 'DESC',
   'suppress_filter' => true,
   'paged'           => $paged,
   'posts_per_page'  => $limit,
];

/**
* Timber context assignments
*/
$context['expertises'] = new Timber\PostQuery( $args );

Timber::render( array( 'pages/expertises.twig' ), $context );