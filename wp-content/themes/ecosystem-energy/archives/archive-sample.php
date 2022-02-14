<?php

// set the query strings
$limit       = empty($_GET['limit']) ? 9 : $_GET['limit'];
$paged       = empty($_GET['page']) ? 1 : $_GET['page'];

$context = Timber::context();
$samples = [
    'post_type'      => 'sample',
    'post_status'    => 'publish',
    'posts_per_page' => $limit,
    'page'           => $paged,
];

$context['post'] = new Timber\PostQuery($samples);
$context['limit'] = $limit;
$context['params'] = $_GET;

Timber::render(['pages/index.twig'], $context);
