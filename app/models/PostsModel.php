<?php

    class PostsModel extends Model {

        private $_postsToReturn = 6;

        public function __construct($table) {            
            parent::__construct($table);
        }

        /**
         * Returns posts by given page
         * 
         * This method is created for loading more posts using AJAX. It gets the posts in HTML format, echos it, and dies
         * 
         * Requires the 'page' parameter set in GET
         * 
         * @return object Posts object if $_GET['page'] is set, otherwise false
         */
        public function getPostsByPage($categoryName = '', $params = []) {

            $sql = 'SELECT * FROM posts';

            if (isset($_GET['page'])) {

                // Rewrite the query if a category name is set
                if (!empty($categoryName)) { $sql = "{$sql} WHERE categoryName = '{$categoryName}'"; }

                // Set the offset for sql query
                $offset = ((int)$_GET['page']) * $this->_postsToReturn;

                // First argument in limit is offset, second is number of rows to return
                $sql = "{$sql} ORDER BY postId DESC LIMIT {$offset},{$this->_postsToReturn}"; 

                // Get the posts from DB and transform it into HTML
                $posts = $this->_db->query($sql, $params)->results();
                $posts = getPostsHtml($posts);

                echo $posts;
                die();
            }

            return false;
        }

        /**
         * Returns the first x posts in descending order
         * 
         * @return object Posts object if query if no error, posts by page if $_GET['page'] is set, otherwise false
         */
        public function getAllPosts() {

            if (isset($_GET['page'])) { $this->getPostsByPage(); }
            $sql = "SELECT * FROM posts ORDER BY postId DESC LIMIT {$this->_postsToReturn}"; // First argument in limit is offset, second is number of rows to return
            return $this->_db->query($sql)->results();
        }
        
        /**
         * Get posts by given category
         * 
         * @param string $categoryName Category name
         * 
         * @return object Posts object if query was successful, posts by page if $_GET['page'] is set, otherwise false
         */
        public function getPostsByCategory($categoryName) {

            if (isset($_GET['page'])) { $this->getPostsByPage($categoryName); }

            $sql = "SELECT * FROM posts WHERE categoryName = :categoryName ORDER BY postId DESC LIMIT {$this->_postsToReturn}";
            $params = [
                'categoryName' => $categoryName
            ];

            $posts = $this->_db->query($sql, $params)->results();
            
            return $posts;
        }

        
        /**
         * Get posts by given category and slug
         * 
         * @param string $categoryName Category name
         * @param string $slug Blog post slug
         * 
         * @return object Post object if query was successful, otherwise false
         */
        public function getPostBySlug($categoryName, $slug) {

            $sql = 'SELECT * FROM posts WHERE categoryName = :categoryName AND slug = :slug';
            $params = [
                'categoryName' => $categoryName,
                'slug'         => $slug
            ];
            $post = $this->_db->query($sql, $params)->resultsFirst();

            return $post;
        }

    }