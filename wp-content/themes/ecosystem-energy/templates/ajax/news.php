<?php
global $params;
do_action('wpml_switch_language', $params['lang']);
// set the query strings
$limit  = empty($params['limit']) ? 9 : $params['limit'];
$paged  = empty($params['page']) ? 1 : $params['page'];

$context = Timber::context();
$locale = empty($params['filter_locale']) ? $context['current_locale'] : $params['filter_locale'];

$args = [
    'post_type'       => 'news',
    'post_status'     => 'publish',
    'orderby'         => 'publish_date',
    'order'           => 'DESC',
    'suppress_filter' => true,
    'paged'           => $paged,
    'posts_per_page'  => $limit,
];

// Filter by local
if (!empty($locales) && $locales != '' && $locales != '-1') {
    $localesTab = explode(',', $locales);
    $args['tax_query'][] = [
        'taxonomy' => 'localization',
        'field'    => 'term_id',
        'terms'    => $localesTab
    ];
}

/**
 * Get post and render view (return)
 */
$posts = new Timber\PostQuery($args);

if ($posts->found_posts > 0) {
    $response = '';
    $response .= Timber::compile('partials/lists/news.twig', ['posts' => $posts]);
    $message = $response;
} else {
    $message = Timber::compile('partials/lists/no-result-item.twig');
}

wp_reset_query();
wp_reset_postdata();
return wp_send_json($message);
