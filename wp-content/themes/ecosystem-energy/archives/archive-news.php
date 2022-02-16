<?php

// set the query strings
$limit       = empty($_GET['limit']) ? 9 : $_GET['limit'];
$paged       = empty($_GET['page']) ? 1 : $_GET['page'];

$context = Timber::context();
$args = [
    'post_type'       => 'news',
    'post_status'     => 'publish',
    'orderby'         => 'publish_date',
    'order'           => 'DESC',
    'suppress_filter' => true,
    'paged'           => $paged,
    'posts_per_page'  => $limit,
];

// Todo add local if exist

$context['posts']   = new Timber\PostQuery($args);
$context['locales'] = get_terms( [ 'taxonomy' => 'localization' ] );
$context['limit']   = $limit;
$context['params']  = $_GET;

Timber::render(['pages/archive-news.twig'], $context);
