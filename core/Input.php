<?php

    class Input {

        /**
         * Sanitize an input from HTML
         */
        public static function sanitize($input) {

            $sanitized = htmlentities($input, ENT_QUOTES, 'UTF-8');
            return $sanitized;
        }

        /**
         * Sanitize an array from HTML
         */
        public static function sanitizeArray($array) {

            $sanitized = [];

            foreach($array as $v => $k) {
                $sanitized[$v] = Input::sanitize($k);
            }

            return $sanitized;
        }

        /**
         * Sanitize a variable from POST or GET
         */
        public static function get($inputName) {
            if (isset($_POST[$inputName]) && !empty($_POST[$inputName])){
                return Input::sanitize($_POST[$inputName]);
            }
            else if (isset($_GET[$inputName]) && !empty($_GET[$inputName])){
                return Input::sanitize($_GET[$inputName]);
            }
        }

        /**
         * Hash a password
         */
        public static function hashPassword($pwd) {

            $pwd = hash('sha512', $pwd);
            $pwd = password_hash($pwd, PASSWORD_DEFAULT);

            return $pwd;
        }

        /**
         * Upload an image
         */
        public static function uploadImage() {

                             // 10MB
            $MAX_FILE_SIZE = 10 * 1000000;
            $ALLOWED_FORMATS = array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            );
            $FILENAME = UPLOAD_IMG_DIR . getRandomString(64);

            try {

                // Check filesize
                if ($_FILES['upload_image']['size'] > $MAX_FILE_SIZE) {
                    return 'ERR_FILESIZE';
                }
                
                // Check MIME
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                if (false === $ext = array_search(
                    $finfo->file(strtolower($_FILES['upload_image']['tmp_name'])),
                    $ALLOWED_FORMATS,
                    true
                )) {
                    return 'ERR_INVALID_FORMAT';
                }

                // Generate the path
                $path =  sprintf('%s.%s',
                    $FILENAME,
                    $ext
                );
                
                // Try to upload the file
                if (!move_uploaded_file(
                    $_FILES['upload_image']['tmp_name'],
                    $path
                )) {
                    return 'ERR_UPLOAD';
                }

                // Return the image path
                return $path;

            }
            catch (RuntimeException $e) {        
                return 'ERR_UNKNOWN';
            }
        }
    }