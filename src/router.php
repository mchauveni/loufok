<?php
session_start();

require 'routes.php';

$url = parse_url($_SERVER['REQUEST_URI']);
$route = trim(str_replace(APP_ROOT_URL, '', $url['path']));

$route = $route === '' ? '/' : $route;

foreach ($routes as $r) {
    if (in_array($route, $r['route']) && in_array($_SERVER['REQUEST_METHOD'], $r['method'])) {
        if (!isset($_COOKIE['is_logged_in'])) {
            setcookie("is_logged_in", '0');
        }


        if (!$_COOKIE['is_logged_in'] && $route != "/login") {
            HTTP::redirect('/login');
        }

        if (isset($r['auth']) && isset($_COOKIE['account_type'])) {
            if ($r['auth'] != $_COOKIE['account_type']) {
                require 'templates/403.php';
                exit;
            }
        }

        require 'templates/' . $r['script'];
        exit;
    }
}

require 'templates/404.php';
