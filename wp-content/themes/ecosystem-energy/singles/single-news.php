<?php

$context = Timber::context();

$timber_post = new Timber\Post();
/**
 * Timber context assignments
 */
$context['post']   = $timber_post;

// Pagination previous/next
$context['next'] = null;
$context['previous'] = null;

$news = new Timber\PostQuery([
   'post_type'       => 'news',
   'post_status'     => 'publish',
   'orderby'         => 'publish_date',
   'order'           => 'ASC',
   'suppress_filter' => true,
   'posts_per_page'  => -1,
]);

foreach ($news as $key => $new) {
    if ($new->id == $timber_post->ID) {
        if (isset($news[($key -1)])) {
            $context['previous'] = $news[($key -1)];
        }
        if (isset($news[($key +1)])) {
            $context['next'] = $news[($key +1)];
        }
        break;
    }
}

Timber::render('pages/single-news.twig', $context);
