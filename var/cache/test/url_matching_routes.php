<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/posts' => [
            [['_route' => 'app_post_create', '_controller' => 'App\\Controller\\PostController::create'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'app_post_index', '_controller' => 'App\\Controller\\PostController::index'], null, ['GET' => 0], null, true, false, null],
        ],
        '/mail' => [[['_route' => 'mail', '_controller' => 'App\\Controller\\DefaultController::mail'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/posts/([^/]++)(?'
                    .'|(*:25)'
                .')'
                .'|/hello\\-([^/]++)(*:49)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        25 => [
            [['_route' => 'app_post_details', '_controller' => 'App\\Controller\\PostController::details'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'app_post_update', '_controller' => 'App\\Controller\\PostController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'app_post_delete', '_controller' => 'App\\Controller\\PostController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        49 => [
            [['_route' => 'index', '_controller' => 'App\\Controller\\DefaultController::index'], ['name'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
