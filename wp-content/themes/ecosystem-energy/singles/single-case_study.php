<?php

$context = Timber::context();

$timber_post = new Timber\Post();
/**
 * Timber context assignments
 */
$context['post']             = $timber_post;
$industry                    = get_terms(['taxonomy' => 'industry_tax'])[0];
$context['industry']         = $industry;
$context['local']            = get_terms(['taxonomy' => 'localization']);
$context['related_industry'] = $timber_post->meta('related_industry');
$context['outcomes_list']    = $timber_post->meta('outcomes_list');

// Get awards
$args = [
    'post_type'       => 'award',
    'post_status'     => 'publish',
    'orderby'         => 'year',
    'order'           => 'ASC',
    'suppress_filter' => true,
    'posts_per_page'  => -1,
    'meta_query' => [
        array(
            'key'     => 'case_study',             // name of custom field
            'value'   => '"' . $timber_post->ID . '"',   // matches exaclty "123", not just 123. This prevents a match for "1234"
            'compare' => 'LIKE'
        ),
    ]
];
$context['awards_list'] = new Timber\PostQuery($args);

// Get other case studies in the same category
$args2 = [
   'post_type'       => 'case_study',
   'post_status'     => 'publish',
   'orderby'         => 'publish_date',
   'order'           => 'DESC',
   'suppress_filter' => true,
   'posts_per_page'  => -1,
   'tax_query' => array(
      array(
          'taxonomy' => 'industry_tax',
          'field'    => 'term_id',
          'terms'    => $industry->term_id,
          ),
      ),
];
$context['related_case_studies'] = new Timber\PostQuery($args2);

Timber::render('pages/single-case_study.twig', $context);
