<?php
global $params;
do_action('wpml_switch_language', $params['lang']);
// set the query strings
$expertise_id = empty($params['id']) ? -1 : $params['id'];

$context = Timber::context();

$currentPost = Timber::get_post($expertise_id);

// Get Case studies
$case_studies = $currentPost->meta('projects_list');

// Get pagination
$next= null;
$previous = null;

$expertises = new Timber\PostQuery([
    'post_type'       => 'expertise',
    'post_status'     => 'publish',
    'orderby'         => 'publish_date',
    'order'           => 'DESC',
    'suppress_filter' => true,
    'posts_per_page'  => -1,
]);

foreach ($expertises as $key => $expertise) {
    if ($expertise->id == $currentPost->ID) {
        if (isset($expertises[($key -1)])) {
            $previous = $expertises[($key -1)];
        }
        if (isset($expertises[($key +1)])) {
            $next = $expertises[($key +1)];
        }
        break;
    }
}

/**
 * Render view (return)
 */
if ($currentPost) {
    $response = '';
    $response .= Timber::compile('partials/expertise.twig', [
        'expertise'     => $currentPost,
        'case_studies'  => $case_studies,
        'next'          => $next,
        'previous'      => $previous,
        'cs_link'       => $context['static_links']['case-studies_link']['url']
    ]);
    $message = $response;
} else {
    $message = Timber::compile('partials/common/no-results.twig');
}

wp_reset_query();
wp_reset_postdata();
return wp_send_json($message);
