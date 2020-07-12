<?php

    class LogoutController extends Controller {

        public function __construct($controller, $action) {
            
            parent::__construct($controller, $action);
            redirectIfNotAuthenticated();
        }

        /**
         * Check if the user is logged and logout
         */
        public function indexAction() {

            if (isLoggedIn()) { currentUser()->logout(); }

            // Redirect to homepage
            setPushMessage('You have been logged out');
            Router::redirect();
        }

    }