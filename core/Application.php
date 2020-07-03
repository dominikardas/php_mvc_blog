<?php

    class Application {
        
        public function __construct() {
            $this->_autoload();
            $this->_setReporting();
            $this->_setEnvironment();
            $this->_setRoutes();
        }

        /**
         * Autoload classes
         */
        private function _autoload() {            

            spl_autoload_register(function($className) {

                // Setup the possible paths for the class
                $pathCore        = ROOT . DS . 'core' . DS . $className    . '.php';
                $pathControllers = ROOT . DS . 'app'  . DS . 'controllers' . DS . $className . '.php';
                $pathModels      = ROOT . DS . 'app'  . DS . 'models'      . DS . $className . '.php';

                // Require them depending on their location
                if (file_exists($pathCore)) {
                    require_once ($pathCore);
                }
                else if (file_exists($pathControllers)) {
                    require_once ($pathControllers);
                }
                else if (file_exists($pathModels)) {
                    require_once ($pathModels);
                }
            });
        }

        /**
         * Enable error displaying if the DEBUG parameter is set in $_GET
         */
        private function _setReporting() {

            if (DEBUG){                
                ini_set('display_errors', 1);
                error_reporting(E_ALL);
            }
            else {                
                ini_set('display_errors', 0);
                error_reporting(0);
                ini_set('log_errors', 1);
                ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'errors.log');
            }
        }

        /**
         * Set environment variables from .env file located in the root directory
         */
        private function _setEnvironment() {

            $file = ROOT . DS . '.env';

            $f = fopen($file, 'r') or die('No .env file found in root');
            
            while(!feof($f)) {                
                $line = trim(fgets($f));
                $line = explode('=', $line);                
                $env = sprintf('%s=%s', $line[0], $line[1]);
                putenv($env);
            }

            fclose($f);
        }

        /**
         * Set the router from given file
         */
        private function _setRoutes() {

            $file = ROOT . DS . 'routes.json';
            $str = file_get_contents($file);
            $json = json_decode($str, true);

            $r = [];

            foreach($json as $key => $value) { $r[$key] = $value; }            

            Router::$routes = $r;
        }
    }