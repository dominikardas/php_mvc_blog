<?php

    define ('DEBUG', (isset($_GET['DEBUG']) ? true : false));

    define ('DEFAULT_CONTROLLER', 'Home');
    define ('DEFAULT_ACTION'    , 'index');
    define ('DEFAULT_LAYOUT'    , 'default');

    define ('SROOT', '/blog/');

    define ('STATIC_TITLE', ' - MVC Framework Blog');

    define ('HEADER_PATH', ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'header.php');
    define ('FOOTER_PATH', ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'footer.php');
    define ('NAVBAR_PATH', ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'navbar.php');

    define ('PAGE_HOME'     , SROOT);
    define ('PAGE_ALL_POSTS', SROOT . 'posts');
    define ('PAGE_ABOUT'    , SROOT . '#');