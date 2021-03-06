<?php
/*
 *	Template Name: Archive Nouvelles
 */

// Get params
$limit    = empty($_GET['limit']) ? 9 : $_GET['limit'];
$paged    = empty($_GET['pg']) ? 1 : $_GET['pg'];
$featured = empty($_GET['featured']) ? [] : $_GET['featured'];

$context['featured'] = null;
$context['limit']    = $limit;
$context['paged']    = $paged;

$context = Timber::context();

// Create ou change current_locale cookie
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) { $context = set_current_locale_cookie($newLocale, $context); }
$locales = empty($_GET['filter_locale']) ? $context['current_locale'] : $_GET['filter_locale'];

// Get news
$args = [
    'post_type'       => 'news',
    'post_status'     => 'publish',
    'orderby'         => 'publish_date',
    'order'           => 'DESC',
    'suppress_filter' => true,
    'paged'           => $paged,
    'posts_per_page'  => empty($featured) ? 1 : $limit,
];

// Filter by locale
if (!empty($locales) && $locales != '' && $locales != '-1') {
    $localesTab = explode(',', $locales);
    $args['tax_query'][] = [
        'taxonomy' => 'localization',
        'field'    => 'term_id',
        'terms'    => $localesTab
    ];
}

// Get featured
if (empty($featured)) {
    $featured = new Timber\PostQuery($args);
    if (isset($featured[0])) {
        $context['featured']    = $paged == 1 ? $featured[0] : null;
        $args['post__not_in']   = [$featured[0]->ID];
    }
    $args['posts_per_page'] = $limit;
}
$context['posts'] = new Timber\PostQuery($args);

Timber::render(['pages/archive-news.twig'], $context);
