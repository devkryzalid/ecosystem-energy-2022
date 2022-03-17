<?php
/*
 *	Template Name: Awards
 */

// Get Params
$limit   = empty($_GET['limit']) ? -1 : $_GET['limit'];
$paged   = empty($_GET['paged']) ? 1 : $_GET['paged'];

$context = Timber::context();

// Create ou change current_locale cookie and get local for request
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) {
    $context = set_current_locale_cookie($newLocale, $context);
}

// Set base informations for context
$timber_post = new Timber\Post();
$context['post'] = $timber_post;

// Get awards
$awards = new Timber\PostQuery([
   'post_type'       => 'award',
   'post_status'     => 'publish',
   'orderby'         => 'year',
   'order'           => 'ASC',
   'suppress_filter' => true,
   'paged'           => $paged,
   'posts_per_page'  => $limit,
]);

// Order by years
$awardByYears = [];
foreach ($awards as $award) {
    if (!isset($awardByYears[$award->year])) {
        $awardByYears[$award->year] = [];
    }
    if (empty($award->case_study) || !isset($award->case_study)) {
        $caseStudy = null;
    } else {
        $caseStudy = new Timber\PostQuery([
            'post__in'    => $award->case_study,
            'post_type'   => 'case_study',
            'post_status' => 'publish',
        ]);
        if (count($caseStudy) > 0) {
            $caseStudy = $caseStudy[0];
        }
    }
    array_push($awardByYears[$award->year], ['award' => $award, 'case_study' => $caseStudy]);
}
$context['awards'] = $awardByYears;

Timber::render( array( 'pages/awards.twig' ), $context );
