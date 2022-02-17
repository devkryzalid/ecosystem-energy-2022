<?php
/**
 * This file contains all Timber routing routes
 */

/**
 * Ajax calls
 */
Routes::map('/ajax/:lang/news', function ($params) {
   Routes::load('templates/ajax/news.php', array_merge($params, $_POST), 200);
});

Routes::map('/ajax/:lang/perspectives', function ($params) {
   Routes::load('templates/ajax/perspectives.php', array_merge($params, $_POST), 200);
});

Routes::map('/ajax/:lang/case_studies', function ($params) {
   Routes::load('templates/ajax/case_studies.php', array_merge($params, $_POST), 200);
});

Routes::map('/ajax/:lang/expertise/:id', function ($params) {
   Routes::load('templates/ajax/expertise.php', array_merge($params, $_POST), 200);
});

Routes::map('/ajax/:lang/search', function ($params) {
   Routes::load('templates/ajax/search.php', array_merge($params, $_POST), 200);
});
