<?php

    class LoginController extends Controller {

        private $_validateRules = [
            'username' => [
                'display'    => 'Username',
                'required'   => true
            ],
            'password' => [
                'display'  => 'Password',
                'required' => true
            ]
        ];

        public function __construct($controller, $action) {
            parent::__construct($controller, $action);
            $this->_loadModel('Users');

            redirectIfAuthenticated();
        }

        /**
         * Render the index login form
         */
        public function indexAction() {
            $this->_view->render('login/index');
        }

        /**
         * Check login credentials
         */
        public function checkAction() {

            if ($_POST) {

                // Form validation
                $validation = new Validate();
                $validation->check($_POST, $this->_validateRules);
                
                // Check if the validation has passed
                if ($validation->passed()) {

                    // Sanitize posted input
                    $username    = Input::get('username');
                    $password    = Input::get('password');
                    
                    // Get the user object
                    $user = (array)$this->UsersModel->findUserByUsername($username);
                    
                    $db_pwd      = $user['password'];          // Password from database
                    $posted_pwd  = hash('sha512', $password);  // Hashed password posted by user

                    // Compare the passwords
                    if ($user && password_verify($posted_pwd, $db_pwd)){

                        $this->UsersModel->login();

                        // Redirect to homepage
                        setPushMessage('You have been successfully logged in');
                        Router::redirect();
                    }
                    // If the username and password combination wasn't found, add an error to the list
                    else {
                        $validation->addError(["Incorrect username or password"]);
                    }
                }

                // If there are errors, parse errors into the view and render the login page
                $this->_view->displayErrors = $validation->displayErrors(); 
                $this->_view->render('login/index');
            }

        }
    }