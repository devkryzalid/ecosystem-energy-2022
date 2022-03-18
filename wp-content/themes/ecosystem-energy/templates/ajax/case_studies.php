<?php
global $params;
do_action('wpml_switch_language', $params['lang']);
// set the query strings
$limit      = empty($params['limit']) ? 9 : $params['limit'];
$paged      = empty($params['pg']) ? 1 : $params['pg'];
$industries = empty($params['industries']) ? [] : $params['industries'];
$featured   = empty($params['featured']) ? '' : $params['featured'];

$context = Timber::context();
$locales = empty($params['filter_locale']) ? $context['current_locale'] : $params['filter_locale'];

$args = [
   'post_type'       => 'case_study',
   'post_status'     => 'publish',
   'orderby'         => 'publish_date',
   'order'           => 'DESC',
   'suppress_filter' => true,
   'paged'           => $paged,
   'posts_per_page'  => empty($featured) ? 1 : $limit,
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

// Filter by industry
if (!empty($industries) && $industries != '') {
    $industriesTab = explode(',', $industries);
    $args['tax_query'][] = [
        'taxonomy' => 'industry_tax',
        'field'    => 'term_id',
        'terms'    => $industriesTab
    ];
}

// Get featured
$context['featured'] = null;
if (empty($featured)) {
    $featured = new Timber\PostQuery($args);
    if (isset($featured[0])) {
        $context['featured'] = $featured[0];
        $args['post__not_in'] = [$featured[0]->ID];
    }
    $args['posts_per_page'] = $limit;
}

/**
 * Get post and render view (return)
 */
$posts = new Timber\PostQuery($args);
if ($posts->found_posts > 0 || (isset($featured[0]) && $paged == 1)) {
    $response = '';
    $response .= Timber::compile(
        'partials/case-studies-list.twig',
        ['items' => $posts, 'featured' => $paged == 1 ? $context['featured'] : null]
    );
    $message  = $response;
} else {
    $message = Timber::compile('partials/common/no-results.twig');
}

wp_reset_query();
wp_reset_postdata();
return wp_send_json($message);
