<?php

global $params;
do_action('wpml_switch_language', $params['lang']);

$search = (!empty($params['s'])) ? $params['s'] : null;
$limit  = empty($params['limit']) ? 10 : $params['limit'];
$paged  = empty($params['paged']) ? 1 : $params['paged'];

$args = [
    'post_type'      => ['post', 'page', 'award', 'case_study', 'expertise', 'industry', 'news'],
    'post_status'    => 'publish',
    'paged'          => $paged,
    'posts_per_page' => $limit,
];
if ($search) {
    $args['s'] = $search;
}
$results = new Timber\PostQuery($args);

if ($results->found_posts > 0) {
    $response   = '';
    $context    = Timber::context();
    $response   .= Timber::compile('partials/lists/list-search.twig', ['results' => $results]);
    $message    = $response;
} else {
    $message = Timber::compile('partials/lists/no-result-item.twig');
}

wp_reset_query();
wp_reset_postdata();

return wp_send_json($message);
