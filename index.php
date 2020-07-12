<?php

    ini_set('display_errors', 0);
    error_reporting(0);

    // Directory seperator
    define('DS', DIRECTORY_SEPARATOR);
    // Root directory of the project
    define('ROOT', dirname(__FILE__));

    require_once (ROOT . DS . 'core'   . DS . 'Application.php');
    require_once (ROOT . DS . 'config' . DS . 'config.php');
    require_once (ROOT . DS . 'app'    . DS . 'lib'    . DS . 'helpers' . DS . 'helpers.php');

    // Run the application constructor
    new Application();

    $url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    Router::route($url);
