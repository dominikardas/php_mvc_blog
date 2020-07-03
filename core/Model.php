<?php

    class Model {

        protected $_db, $_table, $_modelName;

        public function __construct($table) {
            $this->_db = Database::getInstance();
            $this->_table = $table;

            $this->_modelName = $table . 'Model';
        }

    }