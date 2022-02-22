<?php
/*
 *	Template Name: Expertises
 */

// Get params
$limit   = empty($_GET['limit']) ? -1 : $_GET['limit'];
$paged   = empty($_GET['paged']) ? 1 : $_GET['paged'];

$context = Timber::context();

// Create ou change current_locale cookie and get local for request
$newLocale = empty($_GET['set_locale']) ? null : $_GET['set_locale'];
if (isset($newLocale)) {
    $context = set_current_locale_cookie($newLocale, $context);
}

// Set base informations for context
$timber_post = new Timber\Post();
$context['post']             = $timber_post;
$context['featured_content'] = $timber_post->meta('featured_content');

// Get expertises
$args = [
   'post_type'       => 'expertise',
   'post_status'     => 'publish',
   'orderby'         => 'publish_date',
   'order'           => 'DESC',
   'suppress_filter' => true,
   'paged'           => $paged,
   'posts_per_page'  => $limit,
];
$context['expertises'] = new Timber\PostQuery( $args );

Timber::render( array( 'pages/expertises.twig' ), $context );
