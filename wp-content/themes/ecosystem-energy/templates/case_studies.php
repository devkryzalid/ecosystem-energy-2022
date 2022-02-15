<?php
/*
 *	Template Name: Expertises
 */
$limit   = empty($_GET['limit']) ? 6 : $_GET['limit'];
$paged   = empty($_GET['paged']) ? 1 : $_GET['paged'];
$context = Timber::context();
$timber_post = new Timber\Post();
$context['post'] = $timber_post;
$context['limit'] = $limit;
$context['paged'] = $paged;

$args = [
   'post_type'       => 'case_study',
   'post_status'     => 'publish',
   'orderby'         => 'publish_date',
   'order'           => 'DESC',
   'suppress_filter' => true,
   'posts_per_page'  => -1,
];
$context['case_studies'] = new Timber\PostQuery($args);

Timber::render( array( 'pages/case_studies.twig' ), $context );
