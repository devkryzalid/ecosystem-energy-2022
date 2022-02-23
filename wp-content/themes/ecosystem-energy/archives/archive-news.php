<?php
/*
 *	Template Name: Archive Nouvelles
 */

// set the query strings
$limit  = empty($_GET['limit']) ? 9 : $_GET['limit'];
$paged  = empty($_GET['page']) ? 1 : $_GET['page'];

$context = Timber::context();

// Create ou change current_locale cookie
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) {
    $context = set_current_locale_cookie($newLocale, $context);
}

$locales = empty($_GET['filter_locale']) ? $context['current_locale'] : $_GET['filter_locale'];

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
if (!empty($locales) && $locales != '' && $locales != '-1') {
    $localesTab = explode(',', $locales);
    $args['tax_query'][] = [
        'taxonomy' => 'localization',
        'field'    => 'term_id',
        'terms'    => $localesTab
    ];
}

$context['posts']   = new Timber\PostQuery($args);
$context['limit']   = $limit;
$context['paged']   = $paged;

Timber::render(['pages/archive-news.twig'], $context);
