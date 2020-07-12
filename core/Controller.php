<?php

    class Controller extends Application {

        protected $_controller, $_action, $_view, $_model;

        public function __construct($controller, $action) {
            parent::__construct();

            $this->_controller = $controller;
            $this->_action = $action;
            $this->_view = new View();
        }

        /**
         * Load the model by name
         * 
         * @param string $m Model name
         */
        protected function _loadModel($m) {

            $model = $m . 'Model';

            if (class_exists($model)) {
                $this->{$model} = new $model($m);
            }
        }

    }