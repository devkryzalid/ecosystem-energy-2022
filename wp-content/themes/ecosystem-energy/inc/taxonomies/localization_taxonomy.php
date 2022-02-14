<?php

/**
 * create taxo for Sample
 */
function localization_taxonomy($labelsGlobal, $argsGlobal)
{
    $labels = [
        'name'          => _x('Localizations', 'taxonomy general name', 'ecosystem-energy'),
        'singular_name' => _x('Localization', 'taxonomy singular name', 'ecosystem-energy'),
        'menu_name'     => __('Localizations', 'ecosystem-energy'),
    ];
    $args = [
        'labels'  => array_merge($labelsGlobal, $labels),
        'rewrite' => ['slug' => __('localizations', 'ecosystem-energy')],
    ];

    register_taxonomy('localization', ['news', 'post', 'case_study'], array_merge($argsGlobal, $args));
}
