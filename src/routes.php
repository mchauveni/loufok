<?php

$routes = [
    [
        'route' => ['/'],
        'method' => ['GET'],
        'script' => 'index.php',
    ],

    [
        'route' => ['/404'],
        'method' => ['GET'],
        'script' => '404.php',
    ],
    [
        'route' => ['/403'],
        'method' => ['GET'],
        'script' => '403.php',
    ],
    [
        'route' => ['/301'],
        'method' => ['GET'],
        'script' => '301.php',
    ],
];
