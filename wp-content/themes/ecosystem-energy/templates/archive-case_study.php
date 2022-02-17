<?php
/*
 *	Template Name: Projets
 */
$limit      = empty($_GET['limit']) ? 9 : $_GET['limit'];
$paged      = empty($_GET['paged']) ? 1 : $_GET['paged'];
$locales    = empty($_GET['locale']) ? [] : $_GET['locale'];
$industries = empty($_GET['industries']) ? [] : $_GET['industries'];
$featured   = empty($_GET['featured']) ? [] : $_GET['featured'];

$context = Timber::context();

$timber_post = new Timber\Post();
$context['post']     = $timber_post;
$context['featured'] = null;
$context['limit']    = $limit;
$context['paged']    = $paged;

$args = [
   'post_type'       => 'case_study',
   'post_status'     => 'publish',
   'orderby'         => 'publish_date',
   'order'           => 'DESC',
   'suppress_filter' => true,
   'paged'           => $paged,
   'posts_per_page'  => empty($featured) ? 1 : $limit,
];

// Filter by local
if (!empty($locales) && $locale != '') {
    $localesTab = explode(',', $locales);
    $args['tax_query'][] = [
        'taxonomy' => 'localization',
        'field'    => 'term_id',
        'terms'    => $localesTab
    ];
}

// Filter by industry
if (!empty($industries) && $industries != '') {
    $industriesTab = explode(',', $industries);
    $args['tax_query'][] = [
        'taxonomy' => 'industry_tax',
        'field'    => 'term_id',
        'terms'    => $industriesTab
    ];
}

// Get featured
if (empty($featured)) {
    $featured = new Timber\PostQuery($args);
    $context['featured'] = $featured[0];
    $args['post__not_in'] = [$featured[0]->ID];
    $args['posts_per_page'] = $limit;
}

// Get case studies
$context['case_studies'] = new Timber\PostQuery($args);

Timber::render( array( 'pages/case_studies.twig' ), $context );
