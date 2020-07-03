<?php

    // Directory seperator
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(__FILE__));

    require_once (ROOT . DS . 'config' . DS . 'config.php');
    require_once (ROOT . DS . 'app'    . DS . 'lib'    . DS . 'helpers' . DS . 'helpers.php');
    require_once (ROOT . DS . 'core'   . DS . 'Application.php');

    // Run the application constructor
    new Application();

    $url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    Router::route($url);
