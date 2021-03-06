<?php
/*
 *	Template Name: Archive Perspective
 */

// Get params
$limit      = empty($_GET['limit']) ? 9 : $_GET['limit'];
$paged      = empty($_GET['pg']) ? 1 : $_GET['pg'];
$categories = empty($_GET['categories']) ? [] : $_GET['categories'];
$featured   = empty($_GET['featured']) ? [] : $_GET['featured'];

$context = Timber::context();

// Create ou change current_locale cookie and get local for request
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) { $context = set_current_locale_cookie($newLocale, $context); }
$locales = empty($_GET['filter_locale']) ? $context['current_locale'] : $_GET['filter_locale'];

// Set base informations for context
$timber_post = new Timber\Post();
$context['post']       = $timber_post;
$context['limit']      = $limit;
$context['paged']      = $paged;
$context['categories'] = get_terms([ 'taxonomy' => 'category' ]);
$context['industries'] = get_terms([ 'taxonomy' => 'industry_tax' ]);
$context['featured']   = null;

// Get perspectives
$args = [
    'post_type'       => 'post',
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

// Filter by category
if (!empty($categories) && $categories != '') {
    $categoriesTab = explode(',', $categories);
    $args['tax_query'][] = [
        'taxonomy' => 'category',
        'field'    => 'term_id',
        'terms'    => $categoriesTab
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

// Get Post
$context['posts'] = new Timber\PostQuery($args);
Timber::render('pages/index.twig', $context);
