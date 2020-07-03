<?php

    class Controller extends Application {

        protected $_controller, $_action, $_view, $_model;

        public function __construct($controller, $action) {
            parent::__construct();

            $this->_controller = $controller;
            $this->_action = $action;
            $this->_view = new View();
        }

    }