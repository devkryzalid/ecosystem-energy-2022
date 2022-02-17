<?php
// set the query strings
$limit  = empty($_GET['limit']) ? 9 : $_GET['limit'];
$paged  = empty($_GET['page']) ? 1 : $_GET['page'];
$locale = empty($_GET['locale']) ? [] : $_GET['locale'];

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

// Filter by local
if (!empty($locales) && $locales != '' && $locales != 'n/a') {
    $localesTab = explode(',', $locales);
    $args['tax_query'][] = [
        'taxonomy' => 'localization',
        'field'    => 'term_id',
        'terms'    => $localesTab
    ];
}

$context['posts']   = new Timber\PostQuery($args);
$context['locales'] = get_terms( [ 'taxonomy' => 'localization' ] );
$context['limit']   = $limit;
$context['paged']   = $paged;

Timber::render(['pages/archive-news.twig'], $context);
