<?php

    function dump($data){
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }

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

    function FormatSQLDate($d) {
        $date = explode('-', $d);
        $f = $date[2] . ' ';

        switch($date[1]){
            case '01': 
                $f .= 'January';
                break;  
            case '02': 
                $f .= 'February';
                break;
            case '03': 
                $f .= 'March';
                break;
            case '04': 
                $f .= 'April';
                break;
            case '05': 
                $f .= 'May';
                break;
            case '06': 
                $f .= 'June';
                break;
            case '07': 
                $f .= 'July';
                break;
            case '08': 
                $f .= 'August';
                break;
            case '09': 
                $f .= 'September';
                break;
            case '10': 
                $f .= 'October';
                break;
            case '11': 
                $f .= 'November';
                break;
            case '12': 
                $f .= 'December';
                break;
            default: 
                break;
        }

        $f .= ', ' . $date[0];

        return $f;

        // dump($f);
    }

    function getTopPost($post) {        

        $result = '';

        $post = (array)$post;
        $path = SROOT . 'posts' . '/' . $post['categoryName'] . '/' . $post['slug'];

        // dump($post);

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