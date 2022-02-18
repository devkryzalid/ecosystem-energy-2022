<?php
// Create ou change current_locale cookie
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) {
    set_current_locale_cookie($newLocale);
}
$context = Timber::context();

// set the query strings
$limit      = empty($_GET['limit']) ? 10 : $_GET['limit'];
$paged      = empty($_GET['paged']) ? 1 : $_GET['paged'];
// Locale filter
$locales    = empty($_GET['locale']) ? $context['current_locale'] : $_GET['locale'];
$categories = empty($_GET['category']) ? [] : $_GET['category'];

$timber_post = new Timber\Post();
$context['post']  = $timber_post;
$context['limit'] = $limit;
$context['paged'] = $paged;

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

// Get locales
$context['locales'] = get_terms( [ 'taxonomy' => 'localization' ] );
// Get category
$context['categories'] = get_terms( [ 'taxonomy' => 'category' ] );
// Get industries tax
$context['industries'] = get_terms( [ 'taxonomy' => 'industry_tax' ] );

// Filter by local
if (!empty($locales) && $locales != '' && $locales != 'n/a') {
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

// Get Post
$context['posts'] = new Timber\PostQuery( $args );

Timber::render( 'pages/index.twig', $context );
