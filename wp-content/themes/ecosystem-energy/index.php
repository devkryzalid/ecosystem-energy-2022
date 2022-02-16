<?php
// set the query strings
$limit      = empty($_GET['limit']) ? 10 : $_GET['limit'];
$paged      = empty($_GET['paged']) ? 1 : $_GET['paged'];
$locales    = empty($_GET['locale']) ? [] : $_GET['locale'];
$categories = empty($_GET['category']) ? [] : $_GET['category'];

$context = Timber::context();
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

// Filter by local
if (!empty($locales) && $locale != '') {
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
