<?php

    class View {

        protected $_head, $_newPosts, $_body, $_outputBuffer, $_layout = DEFAULT_LAYOUT, $_title;
        public $data;

        public function __construct() {

        }

        /**
         * Renders a view by given view name
         * 
         * @param string $viewName View name
         */
        public function render($viewName) {

            // Make sure this works cross-platform
            $viewArray  = explode('/', $viewName);
            $view       = implode(DS, $viewArray);

            $path       = ROOT . DS . 'app' . DS . 'views' . DS . $view . '.php';
            $layoutPath = ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php';

            // If the path is valid, render the view simultaneously with the layout
            if (file_exists($path)) {
                require_once($path);
                require_once($layoutPath);
            }
            else {
                die('The view was not found');
            }
        }

        /**
         * Return content by given content type
         * 
         * @param string $contentType Name of content
         */
        public function getContent($contentType) {

            // Return the content on given content-type
            switch ($contentType) {

                case 'head':
                    return $this->_head;
                    break;
                case 'newPosts':
                    return $this->_newPosts;
                    break;
                case 'body':
                    return $this->_body;
                    break;
                default:
                    break;
            }
        }

        /**
         * Render part of the page by given content
         */
        public function start($contentType) {
            $this->_outputBuffer = $contentType;
            ob_start();
        }

        /**
         * End given part of page
         */
        public function end() {

            switch ($this->_outputBuffer) {
                case 'head':
                    $this->_head = ob_get_clean();
                    break;
                case 'newPosts':
                    $this->_newPosts = ob_get_clean();
                    break;
                case 'body':
                    $this->_body = ob_get_clean();
                    break;
                default:
                    die('The start method must be run before end()');
                    break;
            }
        }
        
        /**
         * Setter for the layout
         */
        public function setLayout($layoutName) {
            $this->_layout = $layoutName;
        }

        /**
         * Setter for the title
         */
        public function setTitle($title){
            $this->_title = $title . STATIC_TITLE;;
        }
    } 