<?php
global $paged;

$limit             = empty($_GET['limit']) ? 10 : $_GET['limit'];
$paged             = empty($_GET['paged']) ? 1 : $_GET['paged'];
$selected_category = $_GET ? get_term_by('id', $_GET['category'], 'category') : null;
$timber_post       = new Timber\Post();

$context['params'] = $_GET;
$context['limit']  = $limit;
$context['paged']  = $paged;
$context['post']   = $timber_post;

/**
 * Query arguments
 */
$args = [
    'post_type'       => 'post',
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
$context['posts'] = new Timber\PostQuery( $args );

// Get locales
$context['locales'] = get_terms( [ 'taxonomy' => 'localization' ] );
// TODO filter by local

// Get category if expertise
$context['categories'] = get_terms( [ 'taxonomy' => 'category' ] );

// TODO Filter if there is a selected category

Timber::render( 'pages/index.twig', $context );
