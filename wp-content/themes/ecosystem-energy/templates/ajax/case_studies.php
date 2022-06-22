<?php
global $params;
do_action('wpml_switch_language', $params['lang']);

// Params
$limit      = empty($params['limit']) ? 9 : $params['limit'];
$paged      = empty($params['pg']) ? 1 : $params['pg'];
$industries = empty($params['industries']) ? [] : $params['industries'];

$context = Timber::context();

$locales = empty($params['filter_locale']) ? $context['current_locale'] : $params['filter_locale'];

// Main query
$args = [
  'post_type'       => 'case_study',
  'post_status'     => 'publish',
  'orderby'         => 'publish_date',
  'order'           => 'DESC',
  'suppress_filter' => true,
  'paged'           => $paged,
  'posts_per_page'  => $limit,
];

// Filter by locale
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

// Render view
$posts = new Timber\PostQuery($args);
if ($posts->found_posts > 0) {
  $message  = Timber::compile('partials/case-studies-list.twig', ['items' => $posts, 'paged' => $paged]);
} else {
  $message = Timber::compile('partials/common/no-results.twig');
}

wp_reset_query();
wp_reset_postdata();
return wp_send_json($message);
