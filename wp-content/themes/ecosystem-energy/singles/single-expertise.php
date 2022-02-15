<?php

$context = Timber::context();

$timber_post = new Timber\Post();
/**
 * Timber context assignments
 */
$context['post'] = $timber_post;

// Get Case studies
// TODO Add local
$context['case_studies'] = $timber_post->meta('projects_list');

// Pagination
$context['next'] = null;
$context['previous'] = null;

$args2 = [
   'post_type'       => 'expertise',
   'post_status'     => 'publish',
   'orderby'         => 'title',
   'order'           => 'ASC',
   'suppress_filter' => true,
   'posts_per_page'  => -1,
];
$expertises = new Timber\PostQuery($args2);

foreach ($expertises as $key => $expertise) {
    if ($expertise->id == $timber_post->ID) {
        if (isset($expertises[($key -1)])) {
            $context['previous'] = $expertises[($key -1)];
        }
        if (isset($expertises[($key +1)])) {
            $context['next'] = $expertises[($key +1)];
        }
        break;
    }
}

Timber::render('pages/single-expertise.twig', $context);
