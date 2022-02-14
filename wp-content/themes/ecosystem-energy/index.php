<?php
$context = Timber::context();
global $paged;
if ( ! isset( $paged ) || ! $paged ) {
	$paged = 1;
}
/**
 * Query arguments
 */
$args = [
	'posts_per_page' => 12,
	'orderby' => [
		'ID' => 'ASC',
	],
	'paged' => $paged,
];
/**
 * Timber context assignments
 */
$context['params'] = $_GET;
$context['posts'] = new Timber\PostQuery( $args );
$timber_post = new Timber\Post();
$context['categories'] = get_terms( [ 'taxonomy' => 'category' ] );
$context['post'] = $timber_post;

Timber::render( 'pages/index.twig', $context );
