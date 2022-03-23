<?php
global $params;
do_action('wpml_switch_language', $params['lang']);

// Params
$limit  = empty($params['limit']) ? 9 : $params['limit'];
$paged  = empty($params['pg']) ? 1 : $params['pg'];
$featured   = empty($params['featured']) ? '' : $params['featured'];

$context = Timber::context();
$locales = empty($params['filter_locale']) ? $context['current_locale'] : $params['filter_locale'];

// Main query
$args = [
    'post_type'       => 'news',
    'post_status'     => 'publish',
    'orderby'         => 'publish_date',
    'order'           => 'DESC',
    'suppress_filter' => true,
    'paged'           => $paged,
    'posts_per_page'  => empty($featured) ? 1 : $limit,
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

// Render view
$posts = new Timber\PostQuery($args);

if ($posts->found_posts > 0) {
    $response = '';
    $response .= Timber::compile(
      'partials/news-list.twig', 
      ['posts' => $posts, 'featured' => $paged == 1 ? $context['featured'] : null]
    );
    $message = $response;

} else { $message = Timber::compile('partials/common/no-results.twig'); }

wp_reset_query();
wp_reset_postdata();
return wp_send_json($message);
