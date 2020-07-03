<?php

    class Database {
        private static $_instance = null;
        private $_pdo, $_query, $_error = false, $_result;

        private function __construct() {

            $dsn  = sprintf('mysql:host=%s;port=%s;dbname=%s', getenv('DB_HOST'), getenv('DB_PORT'), getenv('DB_NAME'));
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');

            try {
                $this->_pdo = new PDO($dsn, $user, $pass);
            }
            catch (PDOException $e) {
                die('PDO Error: ' . $e->getMessage());
            }
        }

        public static function getInstance() {

            if (!isset(self::$_instance)) {
                self::$_instance = new Database();
            }

            return self::$_instance;
        }

        /**
         * Process SQL Query
         * @param string $sql    - SQL Query as String
         * @param array  $params - SQL Params as Dictionary
         * 
         * @return object Database object
         */

        public function query($sql, $params = []) {

            $this->_error = false;
            $this->_result = null;

            // $stmt = $this->_pdo->prepare($sql);

            if ($this->_query = $this->_pdo->prepare($sql)) {
                if ($this->_query->execute($params)){
                    $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                }
                else {
                    $this->_error = true;
                }
            }

            return $this;
        }

        /**
         * Return all results
         * 
         * @return object Database result if not null, otherwise false
         */
        public function results() {
            return ($this->_result == null) ? false : $this->_result;
        }        

        /**
         * Return first results
         * 
         * @return object First database result if not null, otherwise false
         */
        public function resultsFirst() {
            return ($this->_result[0] == null) ? false : $this->_result[0];
        }
    }