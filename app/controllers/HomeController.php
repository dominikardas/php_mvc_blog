<?php

    class HomeController extends Controller {

        public function __construct($controller, $action) {

            // Call Controller constructor
            parent::__construct($controller, $action);
            
            // Set layout
            // $this->view->setLayout('home/indexLayout');
        }

        /**
         * Render the homepage
         */
        public function indexAction() {
            $m = new PostsModel('Posts');
            $this->_view->data = $m->getAllPosts();
            $this->_view->render('home/index');
        }

    }