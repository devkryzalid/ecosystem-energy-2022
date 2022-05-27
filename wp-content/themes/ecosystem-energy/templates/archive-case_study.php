<?php
/*
 *	Template Name: Projets
 */

// Get params
$limit      = empty($_GET['limit']) ? 9 : $_GET['limit'];
$paged      = empty($_GET['pg']) ? 1 : $_GET['pg'];
$industries = empty($_GET['industries']) ? [] : $_GET['industries'];

$context = Timber::context();

// Create ou change current_locale cookie and get local for request
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) { $context = set_current_locale_cookie($newLocale, $context); }
$locales = empty($_GET['filter_locale']) ? $context['current_locale'] : $_GET['filter_locale'];

// Set base informations for context
$timber_post = new Timber\Post();
$context['post']     = $timber_post;
$context['limit']    = $limit;
$context['paged']    = $paged;

// Get industries tax
$context['industries'] = get_terms( [ 'taxonomy' => 'industry_tax' ] );

// Get cases studies
$args = [
   'post_type'       => 'case_study',
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

// Filter by industry
if (!empty($industries) && $industries != '') {
    $industriesTab = explode(',', $industries);
    $args['tax_query'][] = [
        'taxonomy' => 'industry_tax',
        'field'    => 'term_id',
        'terms'    => $industriesTab
    ];
}

// Get Post
$context['case_studies'] = new Timber\PostQuery($args);
Timber::render( array( 'pages/case_studies.twig' ), $context );
