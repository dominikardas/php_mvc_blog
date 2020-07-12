<?php

    class RegisterController extends Controller {

        private $_validateRules = [
            'first_name' => [
                'display'    => 'First name',
                'required'   => true,
                'max'        => 64
            ],
            'last_name'  => [
                'display'    => 'Last name',
                'required'   => true,
                'max'        => 64
            ],
            'username'   => [
                'display'    => 'Username',
                'required'   => true,
                'min'        => 6,
                'max'        => 64,
                'unique'     => 'Users'
            ],
            'password'   => [
                'display'    => 'Password',
                'required'   => true,
                'min'        => 6,
                'max'        => 64
            ],
            'password_r' => [
                'display'    => 'Repeat password',
                'required'   => true,
                'matches'    => 'password'
            ],
        ];

        public function __construct($controller, $action) {
            parent::__construct($controller, $action);
            $this->_loadModel('Users');

            redirectIfAuthenticated();
        }

        /**
         * Render the index register form
         */
        public function indexAction() {
            $this->_view->render('register/index');
        }

        /**
         * Check the register credentials
         */
        public function checkAction() {

            if ($_POST) {
                
                // Form validation
                $validation = new Validate();
                $validation->check($_POST, $this->_validateRules);

                // Check if the validation has passed
                // Redirect to login page if registration is successful
                if ($validation->passed()) {              
                    $this->UsersModel->register();                    
                    setPushMessage('Registration was successfull<br>You can now log in');
                    Router::redirect('login/');
                }

            }

            // If there are errors, parse errors into the view and render the registration page
            $this->_view->displayErrors = $validation->displayErrors(); 
            $this->_view->render('register/index');
        }

    }