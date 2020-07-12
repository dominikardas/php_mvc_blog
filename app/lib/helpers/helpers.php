<?php

    function dump($data){
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }

    /* String operations */
    function startswith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    function endswith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    function getRandomString($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
    
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    
        return $string;
    }   
    
    /* Format SQL date */
    function FormatSQLDate($d) {
        return date('d M, Y', strtotime($d));
    }

    /* HTML Rendering */
    function getTopPostHtml($post) {        

        $result = '';

        $post = (array)$post;
        $path = SROOT . 'posts' . '/' . $post['categoryName'] . '/' . $post['slug'];

        $result .= sprintf(
        '  <div><a href="%s">
                <span class="l-post_image">
                    <img src="%s">
                </span>

                <div class="l-top-post_description">
                    <span class="l-description_title">%s</span>
                    <div>
                        <span class="l-description_authorName">%s • </span>
                        <span class="l-description_publishedAt">%s</span>
                    </div>
                </div>
            </a></div>
        ',  $path, SROOT . $post['postImage'], $post['title'], $post['authorName'], FormatSQLDate($post['publishedAt']));

        return $result;
    }

    function getPostsHtml($posts) {

        $result = '';

        foreach($posts as $post) {

            $post = (array)$post;
            $path = SROOT . 'posts' . '/' . $post['categoryName'] . '/' . $post['slug'];

            $result .= sprintf(
            '   <div><a href="%s">
                    <div class="c-container-post">
                        <span class="l-post_image">
                            <img src="%s">
                        </span>

                        <div class="l-post_description">
                            <div>
                                <span class="l-description_publishedAt">%s</span>
                                <span class="l-description_authorName">by %s</span>
                            </div>
                            <span class="l-description_title">%s</span>
                            <span class="l-description_smallDesc">%s</span>
                        </div>
                    </div>
                </a></div>
            ',  $path, SROOT . $post['postImage'], FormatSQLDate($post['publishedAt']), $post['authorName'], $post['title'], $post['smallDesc']);
        }       

        return $result;

    }

    /* User data */
    function currentUser() {
        return UsersModel::currentLoggedInUser();
    }

    function currentUserArr() {
        return (array)(UsersModel::currentLoggedInUser());
    }
    
    function currentLoggedUser() {
        return currentUserArr()['username'];
    }
    
    function currentUserFullName() {
        return currentUserArr()['fname'] . ' ' . currentUserArr()['lname'];
    }

    function isLoggedIn() {
        return (currentUser() !== null);
    }

    function isAdmin() {
        return empty(currentUserArr()) ? false : (boolean)(currentUserArr()['isAdmin']);
    }

    /* DB */

    function getAllCategories() {

        $sql = "SELECT * FROM categories";
        $results = Database::getInstance()->query($sql)->results();
        return (array)$results;
    }

    function isValidCategory($categoryName) {

        $categories = getAllCategories();

        for($i = 0; $i < count($categories); $i++) {

            if (((array)$categories[$i])['categoryName'] == $categoryName) 
                return true;
        }
        
        return false;
    }

    /* Redirects */
    function redirectIfNotAuthenticated() {
        if (!isLoggedIn())
            Router::redirect();
    }

    function redirectIfAuthenticated() {
        if (isLoggedIn())
            Router::redirect();
    }

    function setPushMessage($msg) {
        Session::set('pushMessage', $msg);
    }

    function display404() {
        http_response_code(404);
        setPushMessage('Page was not found');
        Router::redirect();
    }

    // Generates a 50 chars long slug from the title and 12 random characters
    function generateSlugFromTitle($title) {

        $slug = '';

        $title = strtolower($title);
        $title = explode(' ', $title);

        foreach($title as $word) {
            $slug = $slug . $word . '-';
        }

        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
        $slug = substr($slug, 0, 38);

        $slug = $slug . getRandomString(12);
        return $slug;
    }

