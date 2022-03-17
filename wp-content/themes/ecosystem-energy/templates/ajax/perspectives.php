<?php
global $params;
do_action('wpml_switch_language', $params['lang']);
// set the query strings
$limit      = empty($params['limit']) ? 9 : $params['limit'];
$paged      = empty($params['paged']) ? 1 : $params['paged'];
$categories = empty($params['categories']) ? [] : $params['categories'];

$context = Timber::context();
$locales = empty($params['filter_locale']) ? $context['current_locale'] : $params['filter_locale'];

/**
 * Query arguments
 */
$args = [
    'post_type'       => 'post',
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
// Filter by category
if (!empty($categories) && $categories != '') {
    $categoriesTab = explode(',', $categories);
    $args['tax_query'][] = [
        'taxonomy' => 'category',
        'field'    => 'term_id',
        'terms'    => $categoriesTab
    ];
}

/**
 * Get post and render view (return)
 */
$posts = new Timber\PostQuery($args);
// dd($categories);

if ($posts->found_posts > 0) {
    $response = '';
    $response .= Timber::compile('partials/perspectives-list.twig', ['posts' => $posts]);
    $message = $response;
} else {
    $message = Timber::compile('partials/common/no-results.twig');
}

wp_reset_query();
wp_reset_postdata();
return wp_send_json($message);
