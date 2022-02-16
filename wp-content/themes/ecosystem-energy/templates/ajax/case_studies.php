<?php
global $params;
do_action('wpml_switch_language', $params['lang']);
// set the query strings
$limit      = empty($params['limit']) ? -1 : $params['limit'];
$paged      = empty($params['paged']) ? 9 : $params['paged'];
$locales    = empty($params['locale']) ? [] : $params['locale'];
$industries = empty($params['industry']) ? [] : $params['industry'];

$context = Timber::context();

$args = [
   'post_type'       => 'case_study',
   'post_status'     => 'publish',
   'orderby'         => 'publish_date',
   'order'           => 'DESC',
   'suppress_filter' => true,
   'paged'           => $paged,
   'posts_per_page'  => $limit,
];

// Filter by local
if (!empty($locales) && $locale != '') {
    $localesTab = explode(',', $locales);
    $args['tax_query'][] = [
        'taxonomy' => 'localization',
        'field'    => 'term_id',
        'terms'    => $localesTab
    ];
}

// Filter by industry
if (!empty($industries) && $industries != '') {
    $industriesTab = explode(',', $industries);
    $args['tax_query'][] = [
        'taxonomy' => 'industry_tax',
        'field'    => 'term_id',
        'terms'    => $industriesTab
    ];
}

/**
 * Get post and render view (return)
 */
$posts = new Timber\PostQuery($args);

if ($posts->found_posts > 0) {
    $response = '';
    $response .= Timber::compile('partials/lists/case_studies.twig', ['posts' => $posts]);
    $message = $response;
} else {
    $message = Timber::compile('partials/lists/no-result-item.twig');
}

wp_reset_query();
wp_reset_postdata();
return wp_send_json($message);
