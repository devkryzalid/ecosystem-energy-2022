<?php

$context = Timber::context();

// Create ou change current_locale cookie and get local for request
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) {
    $context = set_current_locale_cookie($newLocale, $context);
}
$locales = empty($params['filter_locale']) ? $context['current_locale'] : $params['filter_locale'];

$timber_post = new Timber\Post();
/**
 * Timber context assignments
 */
$context['post'] = $timber_post;

// Get ACF
$context['clients_block'] = $timber_post->meta('clients-block');
$context['featured_blocks']     = $timber_post->meta('featured-block');
$context['informations_blocks'] = $timber_post->meta('informations-blocks');

// Spread client list in multiple equal-ish rows
$max_per_row = 6;
$clients = $context['clients_block']['clients_list'] ?: [];
// $clients = array_merge($clients, $clients, $clients);  // For testing purposes when not enough clients
$nb = count($clients) <= $max_per_row ? $max_per_row : ceil(count($clients) / 2);
$context['clients_block']['clients_list'] = array_chunk($clients, $nb);

// Get Featured Case study
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

// Get Case studies
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

// Filter news and perspective by local
if (!empty($locales) && $locales != '' && $locales != '-1') {
      $localesTab = explode(',', $locales);
      $args['tax_query'][] = [
         'taxonomy' => 'localization',
         'field'    => 'term_id',
         'terms'    => $localesTab
      ];
      $args2['tax_query'][] = [
         'taxonomy' => 'localization',
         'field'    => 'term_id',
         'terms'    => $localesTab
      ];
}

// Get featured and cases studies
$context['featured_case_study'] = new Timber\PostQuery($args);
$context['case_studies'] = new Timber\PostQuery($args2);

Timber::render('pages/single-industry.twig', $context);
