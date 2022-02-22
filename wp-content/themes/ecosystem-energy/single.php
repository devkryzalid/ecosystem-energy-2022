<?php

$context = Timber::context();

// Create ou change current_locale cookie and get local for request
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) {
    $context = set_current_locale_cookie($newLocale, $context);
}
$locales = empty($_GET['filter_locale']) ? $context['current_locale'] : $_GET['filter_locale'];

$timber_post = new Timber\Post();

// Set base informations for context
$context['post']     = $timber_post;
$context['author']   = $timber_post->meta('author');
$category = get_the_terms($timber_post->ID, 'category');
$context['category'] = isset($category[0]) ? $category[0] : null;
$context['tags']     = get_the_tags($timber_post->ID);

// Get related expertises
$args = [
   'post_type'       => 'post',
   'post_status'     => 'publish',
   'orderby'         => 'title',
   'order'           => 'ASC',
   'suppress_filter' => true,
   'paged'           => 1,
   'post__not_in'    => [$timber_post->ID],
   'posts_per_page'  => 3,
];

// Filter by category
if (isset($category[0])) {
    $args['tax_query'][] = [
       'taxonomy' => 'category',
       'field'    => 'term_id',
       'terms'    => $category[0]->term_id
    ];
}

// Filter by locale
if (!empty($locales) && $locales != '' && $locales != '-1') {
    $localesTab = explode(',', $locales);
    $args['tax_query'][] = [
        'taxonomy' => 'localization',
        'field'    => 'term_id',
        'terms'    => $localesTab
    ];
}

$context['related_posts'] = new Timber\PostQuery($args);

Timber::render('pages/single-perspective.twig', $context);
