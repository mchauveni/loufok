<?php

session_start();
if (!isset($_SESSION['load'])) {
    $_SESSION['load'] = false;
}

require 'routes.php';

$url = parse_url($_SERVER['REQUEST_URI']);
$route = trim(str_replace(APP_ROOT_URL, '', $url['path']));

$route = $route === '' ? '/' : $route;

foreach ($routes as $r) {
    if (in_array($route, $r['route']) && in_array($_SERVER['REQUEST_METHOD'], $r['method'])) {
        if (str_contains($route, '/admin')) {
            if (isset($_COOKIE['username']) && isset($_COOKIE['usertoken'])) {
                $admin = Admin::getInstance()->findBy(['username' => $_COOKIE['username']]);
                $admin = $admin[0];

                require 'templates/'.$r['script'];

                exit;
            }
            require 'templates/403.php';
            exit;
        }

        require 'templates/'.$r['script'];
        if ($_SESSION['load'] == false) {
            include 'templates/loader.php';
            $_SESSION['load'] = true;
        }
        exit;
    }
}

require 'templates/404.php';
