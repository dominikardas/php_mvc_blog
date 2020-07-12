<?php

    class HomeController extends Controller {

        public function __construct($controller, $action) {

            parent::__construct($controller, $action);
        }

        /**
         * Render the homepage
         */
        public function indexAction() {
            
            $pm = new PostsModel();
            $this->_view->data = $pm->getAllPosts();
            $this->_view->render('home/index');
        }

    }