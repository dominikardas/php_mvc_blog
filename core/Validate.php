<?php

    class Validate {

        private $_passed = true, $_errors = [], $_db = null;

        public function __construct() {
            $this->_db = Database::getInstance();
        }

        /**
         * Check if there are any errors in given form
         * 
         * @param array $source POST/GET
         * 
         * @param array $items  Rules for given inputs
         */
        public function check($source, $items = []) {

            // Empty the errors array
            $this->_errors = [];

            foreach($items as $item => $rules) {

                // Sanitize the input
                $item = Input::sanitize($item);
                $display = $rules['display'];

                // Check for each rule
                foreach($rules as $rule => $ruleValue) {

                    // Returns sanitized value of given variable from POST/GET
                    //                            $_POST['username']
                    $value = Input::sanitize(trim($source[$item]));

                    // Check if is required
                    if ($rule == 'required' && empty($value)) {
                        $this->addError(["{$display} is required"]);
                    }
                    else if (!empty($value)) {
                        switch($rule) {
                            // Check minimum length
                            case 'min':
                                if (strlen($value) < $ruleValue) {
                                    $this->addError(["{$display} must be a minimum of {$ruleValue} characters", $item]);
                                }
                                break;
                            // Check maximum length
                            case 'max':
                                if (strlen($value) > $ruleValue) {
                                    $this->addError(["{$display} must be a maximum of {$ruleValue} characters", $item]);
                                }
                                break;
                            // Check if values match
                            case 'matches':
                                if ($value != $source[$ruleValue]) {
                                    $matchDisplay = $items[$ruleValue]['display'];
                                    $this->addError(["{$matchDisplay} and {$display} must match", $item]);
                                }
                                break;
                            // Check if value is unique
                            case 'unique':
                                $check = $this->_db->query("SELECT {$item} FROM {$ruleValue} WHERE {$item} = :value", ['value' => $value]);

                                if ($check->resultLength() != 0) {
                                    $this->addError(["{$display} is already used", $item]);
                                }
                                break;
                            case 'exists':
                                $check = $this->_db->query("SELECT {$item} FROM {$ruleValue} WHERE {$item} = :value", ['value' => $value]);

                                if ($check->resultLength() == 0) {
                                    $this->addError(["{$display} does not exist", $item]);
                                }
                                break;
                            default:
                                break;
                        }
                    }
                }
            }
        }

        /**
         * Add error into errors array
         * 
         * @param array $error Error message and HTML class of the item which the error relates to
         */
        public function addError($error) {
            $this->_errors[] = $error;
            $this->_passed = false; //;empty($this->_errors);
        }

        /**
         * Return all errors
         * 
         * @return array List of errors
         */
        public function errors() {
            return $this->_errors;
        }

        /**
         * Returns a value representing if the error check has passed or not
         * 
         * @return boolean
         */
        public function passed() {
            return $this->_passed;
        }

        /**
         * Returns an HTML string with all the errors
         * 
         * @return string HTML string of all the errors
         */
        public function displayErrors() {

            $html = '<div class="c-errors">';

            foreach($this->_errors as $error) {
                $html .= sprintf('<div class="l-error">%s</div>', $error[0]);
                $html .= sprintf('<script>$("document").ready(() => { $(".%s").parent().closest("div").addClass("has-error");});</script>', $error[1]);
            }

            $html .= '</div>';

            return $html;
        }
    }