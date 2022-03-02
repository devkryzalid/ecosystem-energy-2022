<?php
global $params;
do_action('wpml_switch_language', $params['lang']);
// set the query strings
$expertise_id = empty($params['id']) ? -1 : $params['id'];

$context = Timber::context();

$post = Timber::get_post($expertise_id);

// Get Case studies
$context['case_studies'] = $post->meta('projects_list');

// Get pagination
$next= null;
$previous = null;

$expertises = new Timber\PostQuery([
    'post_type'       => 'expertise',
    'post_status'     => 'publish',
    'orderby'         => 'title',
    'order'           => 'ASC',
    'suppress_filter' => true,
    'posts_per_page'  => -1,
]);

foreach ($expertises as $key => $expertise) {
    if ($expertise->id == $post->ID) {
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
if ($post) {
    $response = '';
    $response .= Timber::compile('partials/expertise.twig', [
        'expertise' => $post,
        'next'      => $next,
        'previous'  => $previous,
    ]);
    $message = $response;
} else {
    $message = Timber::compile('partials/lists/no-results.twig');
}

wp_reset_query();
wp_reset_postdata();
return wp_send_json($message);
