<?php

    class UsersModel extends Model {

        private $_sessionName;

        public static $currentLoggedInUser = null;

        public function __construct() {

            $table = 'Users';
            parent::__construct($table);

            $this->_sessionName = CURRENT_USER_SESSION_NAME;
        }

        /**
         * Define variable for given user
         */
        private function _setUserData($user) {

            if ($user) {
                foreach ($user as $key => $val) {
                    $this->$key = $val;
                }
            }
        }

        /**
         * Find user by given parameters
         */
        private function _findUser($sql, $params) {
            $user = $this->_db->query($sql, $params)->resultsFirst();
            $this->_setUserData($user);
            return $user;
        }

        /**
         * Find user by ID
         */
        public function findUserById($id) {

            $sql = "SELECT * FROM {$this->_table} WHERE userId = :userId";
            $params = [
                "userId" => $id
            ];

            return $this->_findUser($sql, $params);
        }

        /**
         * Find user by username
         */
        public function findUserByUsername($user) {

            $sql = "SELECT * FROM {$this->_table} WHERE username = :username";
            $params = [
                "username" => $user
            ];
            
            return $this->_findUser($sql, $params);
        }

        /**
         * Get the current logged in user object
         */
        public static function currentLoggedInUser() {

            if (!isset(UsersModel::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
                $um = new UsersModel('Users');
                $um->findUserById((int)Session::get(CURRENT_USER_SESSION_NAME));
                UsersModel::$currentLoggedInUser = $um;
            }
            
            return UsersModel::$currentLoggedInUser;
        }

        /**
         * Setups the session for given user
         */
        public function login() {

            Session::set($this->_sessionName, $this->userId);
        }

        /**
         * Registers the user
         */
        public function register() {

            $creds = Input::sanitizeArray($_POST);
            // dump($creds);
            
            $sql = "INSERT INTO Users (fname, lname, username, password) VALUES (:fname, :lname, :username, :password)";
            $params = [
                'fname'    => $creds['first_name'],
                'lname'    => $creds['last_name'],
                'username' => $creds['username'],
                'password' => Input::hashPassword($creds['password'])
            ];

            $this->_db->query($sql, $params);
        }

        /**
         * Log out
         */
        public function logout() {
            
            Session::delete($this->_sessionName);
            UsersModel::$currentLoggedInUser = null;
        }
    }