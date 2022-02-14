<?php

/**
 * create taxo for Sample
 */
function sample_type_taxonomy($labelsGlobal, $argsGlobal)
{
    $labels = [
        'name'          => _x('Types', 'taxonomy general name', 'ecosystem-energy'),
        'singular_name' => _x('Type', 'taxonomy singular name', 'ecosystem-energy'),
        'menu_name'     => __('Types', 'ecosystem-energy'),
    ];
    $args = [
        'labels'  => array_merge($labelsGlobal, $labels),
        'rewrite' => ['slug' => __('type', 'ecosystem-energy')],
    ];

    register_taxonomy('sample_type', ['sample'], array_merge($argsGlobal, $args));
}
