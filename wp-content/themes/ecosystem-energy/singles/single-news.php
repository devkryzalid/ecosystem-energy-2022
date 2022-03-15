<?php

$context = Timber::context();

// Create ou change current_locale cookie and get local for request
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) {
    $context = set_current_locale_cookie($newLocale, $context);
}
$locales = empty($params['filter_locale']) ? $context['current_locale'] : $params['filter_locale'];

$timber_post = new Timber\Post();
/**
 * Timber context assignments
 */
$context['post']     = $timber_post;
$context['next']     = null;
$context['previous'] = null;
$notInIds = [$timber_post->ID];

// Pagination previous/next
$args = [
   'post_type'       => 'news',
   'post_status'     => 'publish',
   'orderby'         => 'publish_date',
   'order'           => 'ASC',
   'suppress_filter' => true,
   'posts_per_page'  => -1,
];

$args2 = [
    'post_type'       => 'news',
    'post_status'     => 'publish',
    'orderby'         => 'publish_date',
    'order'           => 'ASC',
    'suppress_filter' => true,
    'posts_per_page'  => 3,
];

$news = new Timber\PostQuery($args);

// Filter next and previous by local
if (!empty($locales) && $locales != '' && $locales != '-1') {
    $localesTab = explode(',', $locales);
    $args['tax_query'][] = [
       'taxonomy' => 'localization',
       'field'    => 'term_id',
       'terms'    => $localesTab
    ];
    $args2['tax_query'][] = [
        'taxonomy' => 'localization',
        'field'    => 'term_id',
        'terms'    => $localesTab
    ];
}

foreach ($news as $key => $new) {
    if ($new->id == $timber_post->ID) {
        if (isset($news[($key -1)])) {
            $context['previous'] = $news[($key -1)];
            array_push($notInIds, $context['previous']->id);
        }
        if (isset($news[($key +1)])) {
            $context['next'] = $news[($key +1)];
            array_push($notInIds, $context['next']->id);
        }
        break;
    }
}

// Get related news
$args2['post__not_in'] = $notInIds;
$context['related_news'] = new Timber\PostQuery($args2);

Timber::render('pages/single-news.twig', $context);
