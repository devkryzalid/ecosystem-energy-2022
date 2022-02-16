<?php
/*
 *	Template Name: Awards
 */
$context = Timber::context();
$timber_post = new Timber\Post();
$context['post'] = $timber_post;

$awards = new Timber\PostQuery([
   'post_type'       => 'award',
   'post_status'     => 'publish',
   'orderby'         => 'year',
   'order'           => 'ASC',
   'suppress_filter' => true,
   'posts_per_page'  => -1,
]);
$awardByYears = [];
foreach ($awards as $award) {
    if (!isset($awardByYears[$award->year])) {
        $awardByYears[$award->year] = [];
    }
    $caseStudy = new Timber\PostQuery([
        'post__in'           => $award->case_study,
        'post_type'   => 'case_study',
        'post_status' => 'publish',
    ]);
    if (count($caseStudy) > 0) {
        $caseStudy = $caseStudy[0];
    }
    array_push($awardByYears[$award->year], ['award' => $award, 'case_study' => $caseStudy]);
}
$context['awards'] = $awardByYears;

Timber::render( array( 'pages/awards.twig' ), $context );
