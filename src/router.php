<?php
session_start();

require 'routes.php';

$url = parse_url($_SERVER['REQUEST_URI']);
$route = trim(str_replace(APP_ROOT_URL, '', $url['path']));

$route = $route === '' ? '/' : $route;

foreach ($routes as $r) {
    if (in_array($route, $r['route']) && in_array($_SERVER['REQUEST_METHOD'], $r['method'])) {

        if (isset($r['auth']) && isset($_COOKIE['account_type'])) {
            if ($r['auth'] != $_COOKIE['account_type']) {
                require 'templates/403.php';
            }
        }

        require 'templates/' . $r['script'];
        exit;
    }
}

require 'templates/404.php';
