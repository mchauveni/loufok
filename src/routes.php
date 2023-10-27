<?php

$routes = [
    [
        'route' => ['/'],
        'method' => ['GET', 'POST'],
        'script' => 'index.php'
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
    [
        'route' => ['/login'],
        'method' => ['GET', 'POST'],
        'script' => 'login.php',
    ],
    [
        'route' => ['/logout'],
        'method' => ['GET'],
        'script' => 'logout.php',
    ],
    [
        'route' => ['/submitContrib'],
        'method' => ['POST'],
        'script' => 'submitContrib.php',
    ],
    [
        'route' => ['/assignRandomContrib'],
        'method' => ['GET'],
        'script' => 'assignContrib.php',
    ],
    [
        'route' => ['/admin'],
        'method' => ['GET'],
        'script' => 'admin.php',
        'auth' => 'admin'
    ],
    [
        'route' => ['/admin/newloufok'],
        'method' => ['GET'],
        'script' => 'newloufok.php',
        'auth' => 'admin'
    ],
    [
        'route' => ['/admin/endloufok'],
        'method' => ['GET'],
        'script' => 'endloufok.php',
        'auth' => 'admin'
    ],
];
