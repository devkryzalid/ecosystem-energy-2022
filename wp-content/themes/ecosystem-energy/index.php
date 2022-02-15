<?php
$limit   = empty($_GET['limit']) ? 6 : $_GET['limit'];
$paged   = empty($_GET['paged']) ? 1 : $_GET['paged'];
$context['limit'] = $limit;
$context['paged'] = $paged;

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
