<?php

$context = Timber::context();

$timber_post = new Timber\Post();
/**
 * Timber context assignments
 */
$context['post'] = $timber_post;

// Get ACF
$context['clients_block']       = $timber_post->meta('clients-block');
$context['featured_blocks']     = $timber_post->meta('featured-block');
$context['informations_blocks'] = $timber_post->meta('informations-blocks');

// Get Case studies
// TODO Add local
$args = [
   'post_type'       => 'case_study',
   'post_status'     => 'publish',
   'orderby'         => 'publish_date',
   'order'           => 'DESC',
   'suppress_filter' => true,
   'posts_per_page'  => 1,
   'meta_query' => [
      array(
         'key'     => 'related_industry',             // name of custom field
         'value'   => '"' . $timber_post->ID . '"',   // matches exaclty "123", not just 123. This prevents a match for "1234"
         'compare' => 'LIKE'
      ),
      array (
         'key' => 'featured',
         'value' => 1
      ),
   ]
];
$context['featured_case_study'] = new Timber\PostQuery($args);

$args2 = [
   'post_type'       => 'case_study',
   'post_status'     => 'publish',
   'orderby'         => 'publish_date',
   'order'           => 'DESC',
   'suppress_filter' => true,
   'posts_per_page'  => -1,
   'meta_query' => [
      array(
         'key' => 'related_industry', // name of custom field
         'value' => '"' . $timber_post->ID . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
         'compare' => 'LIKE'
      ),
      array(
         'relation' => 'OR',
         array(
             'key'     => 'featured',
             'compare' => 'NOT EXISTS',
         ),
         array (
            'key' => 'featured',
            'value' => 0
         ),
      ),
   ]
];
$context['case_studies'] = new Timber\PostQuery($args2);
dd($context['case_studies']);

Timber::render('pages/single-industry.twig', $context);
