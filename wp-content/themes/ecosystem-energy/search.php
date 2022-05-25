<?php

$search = empty($_GET['s']) ? null : $_GET['s'];
$limit  = empty($_GET['limit']) ? 12 : $_GET['limit'];
$paged  = empty($_GET['paged']) ? 1 : $_GET['paged'];

$context = Timber::context();

$args = [
    'post_type'      => ['post', 'page', 'award', 'case_study', 'expertise', 'industry', 'news'],
    'post_status'    => 'publish',
    'posts_per_page' => $limit,
    'paged'          => $paged,
];

if ($search) {
    $args['s'] = $search;
}

$context['posts'] = new Timber\PostQuery($args);
$context['limit'] = $limit;
$context['paged'] = $paged;
$context['s'] = $search;
$context['total'] = $context['posts']->found_posts;

Timber::render( array( 'pages/search.twig' ), $context );
