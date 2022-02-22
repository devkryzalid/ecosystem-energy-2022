<?php
/**
 * The template for displaying the homepage.
 */

$context = Timber::context();

// Create ou change current_locale cookie and get local for request
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) {
    $context = set_current_locale_cookie($newLocale, $context);
}
$locales = empty($params['filter_locale']) ? $context['current_locale'] : $params['filter_locale'];

// Set base informations for context
$timber_post = new Timber\Post();
$context['post']           = $timber_post;
$context['home_hero']      = $timber_post->meta('home-hero');
$context['sectors']        = $timber_post->meta('sectors');
$context['featured_block'] = $timber_post->meta('featured-block');
$context['career_block']   = $timber_post->meta('career-block');

// Get Industries
$context['industries'] = new Timber\PostQuery([
   'post_type'       => 'industry',
   'post_status'     => 'publish',
   'orderby'         => 'title',
   'order'           => 'ASC',
   'suppress_filter' => true,
   'posts_per_page'  => 6,
]);

// Get last news args
$newsArgs = [
    'post_type'       => 'news',
    'post_status'     => 'publish',
    'orderby'         => 'publish_date',
    'order'           => 'DESC',
    'suppress_filter' => true,
    'posts_per_page'  => 1,
];

// Get perspective args
$perspecArgs = [
    'post_type'       => 'post',
    'post_status'     => 'publish',
    'orderby'         => 'publish_date',
    'order'           => 'DESC',
    'suppress_filter' => true,
    'posts_per_page'  => 1,
];

// Filter news and perspective by local
if (!empty($locales) && $locales != '' && $locales != '-1') {
    $localesTab = explode(',', $locales);
    $newsArgs['tax_query'][] = [
        'taxonomy' => 'localization',
        'field'    => 'term_id',
        'terms'    => $localesTab
    ];
    $perspecArgs['tax_query'][] = [
        'taxonomy' => 'localization',
        'field'    => 'term_id',
        'terms'    => $localesTab
    ];
}

// Get last news and perspective
$context['news'] = new Timber\PostQuery($newsArgs);
$context['perspective'] = new Timber\PostQuery($perspecArgs);

// Get Case studies
$caseStudies = [];
foreach ($context['industries'] as $industry) {
    $caseStudy = new Timber\PostQuery([
        'post_type'       => 'case_study',
        'post_status'     => 'publish',
        'orderby'         => 'publish_date',
        'order'           => 'DESC',
        'suppress_filter' => true,
        'posts_per_page'  => 1,
        'meta_query' => [
            array(
                'key'     => 'related_industry',
                'value'   => '"' . $industry->ID . '"',
                'compare' => 'LIKE'
            ),
            array (
                'key' => 'featured',
                'value' => 1
            ),
        ]
    ]);
    if (count($caseStudy) != 0) {
        array_push($caseStudies, ['case_study' => $caseStudy[0], 'industry' => $industry->title]);
    }
}
$context['case_studies'] = $caseStudies;

Timber::render( array( 'pages/front-page.twig' ), $context );
