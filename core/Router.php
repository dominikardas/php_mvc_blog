<?php

    class Router {

        /**
         * List of URIs pointing to given controller & action
         */
        public static $routes;

        /**
         * Get calls for static route
         * 
         * @param string $uri URI
         */
        public static function getStaticRoute($uri) {

            $routes = Router::$routes;

            $key = array_search($uri, array_keys($routes), true);

            $call = $routes[$uri];

            return array(
                'controller' => $call['controller'],
                'action'     => $call['action'],
                'params'     => []
            );
        }

        /**
         * Get calls for given route
         * 
         * @param string $uri URI
         */
        public static function getRoute($uri) {

            $uri = rtrim(ltrim($uri, '/'), '/'); // Remove the backslashes

            $routes = Router::$routes;
            
            // Check if the uri is in the array
            // If it is, it's a static route
            if (in_array($uri, array_keys($routes))) {
                return Router::getStaticRoute($uri);
            }

            $match = false;

            $matchedRoute = [];
            $call = [];
            $params = [];

            // Foreach route in routes
            foreach($routes as $route => $calls) {

                // Split the uris by /
                $uriSplit = explode('/', $uri);
                $routeSplit = explode('/', $route);

                // If is not a dynamic route, skip the iteration
                if (!strpos($route, ':')) continue;

                // If the length of the array is the same, continue in the loop
                if (count($uriSplit) === count($routeSplit)) {
                    
                    // Get an iterator
                    foreach($uriSplit as $key => $section) {

                        // Find if there is a dynamic significator on the same position of the URL
                        // as in the the submitted URI
                        if (strpos($routeSplit[$key], ':') !== false) {

                            // Make sure the calls are inserted only once, since this loop will iterate
                            // as many times as there are dynamic vars
                            if (empty($call)) $call[] = $calls;

                            $params[] = $section;
                        }
                    }
                }
            }
           
            return array(
                'controller' => $call[0]['controller'],
                'action'     => $call[0]['action'],
                'params'     => $params
            );

        }

        /**
         * Route the URI to a given controller and action
         * 
         * @param string $uri URI
         */
        public static function route($uri) {

            $calls = Router::getRoute($uri);

            $controller = $calls['controller'] . 'Controller';
            $action     = $calls['action']     . 'Action';
            $params     = $calls['params'];

            $c = new $controller($controller, $action);

            if (method_exists($controller, $action)) {
                call_user_func_array(array($c, $action), array($params));
            }
            else {
                die('[ROUTER] Method doesn\'t exist in the controller ' . $controller);
            }
        }

    }