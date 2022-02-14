<?php

/**
 * create taxo for Sample
 */
function industry_taxonomy($labelsGlobal, $argsGlobal)
{
    $labels = [
        'name'          => _x('Industries', 'taxonomy general name', 'ecosystem-energy'),
        'singular_name' => _x('Industry', 'taxonomy singular name', 'ecosystem-energy'),
        'menu_name'     => __('Industries', 'ecosystem-energy'),
    ];
    $args = [
        'labels'  => array_merge($labelsGlobal, $labels),
        'rewrite' => ['slug' => __('case-studies-industries', 'ecosystem-energy')],
    ];

    register_taxonomy('industry', ['case_study'], array_merge($argsGlobal, $args));
}
