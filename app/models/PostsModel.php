<?php

    class PostsModel extends Model {

        private $_postsToReturn = 6;

        public function __construct() {       

            $table = 'Posts';
            parent::__construct($table);
        }

        /**
         * Returns all posts including unpublished ones
         * 
         * This method is created for the admin controller
         * 
         * @return array All posts from db by given page
         */
        public function getAllPostsByPage() {

            $sql = 'SELECT * FROM posts';
            $offset = 0;

            if (isset($_GET['page']) && !empty($_GET['page'])) {

                // Set the offset for sql query
                $offset = ((int)$_GET['page'] - 1) * $this->_postsToReturn;
            }
            

            // First argument in limit is offset, second is number of rows to return
            $sql = "{$sql} ORDER BY postId DESC LIMIT {$offset},{$this->_postsToReturn}"; 
            $posts = $this->_db->query($sql)->results();

            return $posts;
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

            $sql = 'SELECT * FROM posts WHERE published = true';

            if (isset($_GET['page']) && !empty($_GET['page'])) {

                // Rewrite the query if a category name is set
                if (!empty($categoryName)) { $sql = "{$sql} AND categoryName = '{$categoryName}'"; }

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
            $sql = "SELECT * FROM posts WHERE published = :published ORDER BY postId DESC LIMIT {$this->_postsToReturn}"; // First argument in limit is offset, second is number of rows to return
            $params = [
                'published' => true
            ];
            return $this->_db->query($sql, $params)->results();
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

            $sql = "SELECT * FROM posts WHERE categoryName = :categoryName AND published = :published ORDER BY postId DESC LIMIT {$this->_postsToReturn}";
            $params = [
                'categoryName' => $categoryName,
                'published'    => true
            ];

            $posts = $this->_db->query($sql, $params)->results();
            
            return $posts;
        }
        
        /**
         * Get posts by given category and slug
         * This method is set up so that an admin user can also see unpublished posts
         * 
         * @param string $categoryName Category name
         * @param string $slug Blog post slug
         * 
         * @return object Post object if query was successful, otherwise false
         */
        public function getPostBySlug($categoryName, $slug) {

            $sql = "SELECT * FROM posts WHERE categoryName = :categoryName AND slug = :slug";
            $params = [
                'categoryName' => $categoryName,
                'slug'         => $slug
            ];
            if (!isAdmin()) {
                $sql .= ' AND published = :published';
                $params['published'] = true;
            }
            $post = $this->_db->query($sql, $params)->resultsFirst();

            return $post;
        }

        /**
         * Returns number of posts
         * 
         * @return int Post count
         */
        public function getNumberOfPosts() {

            $sql = "SELECT COUNT(*) FROM {$this->_table}";
            $result = $this->_db->query($sql)->resultsFirst();
            $count = (int)($result['COUNT(*)']);

            return $count;
        }

        /**
         * Returns number of pages to display on a page
         * 
         * @return int Number of posts on a page
         */
        public function getPostsCountPerPage() {
            return (int)$this->_postsToReturn;
        }

        /**
         * Returns the number of pages
         * 
         * @return int Number of pages
         */
        public function getNumberOfPages() {
            return ceil($this->getNumberOfPosts() / $this->getPostsCountPerPage());
        }

        /**
         * Publishes a post
         * 
         * @param array $params
         * 
         * @return object DB obj if successful, otherwise false
         */
        public function publishPost($params) {

            $sql = "INSERT INTO {$this->_table} (title, slug, published, publishedAt, smallDesc, content, postImage, authorName, categoryName) VALUES (:title, :slug, :published, :publishedAt, :smallDesc, :content, :postImage, :authorName, :categoryName)";
            return $this->_db->query($sql, $params);
        }

        /**
         * Approves a post
         * 
         * @param int Post id
         * 
         * @return object DB obj if successful, otherwise false
         */
        public function approvePost($id) {

            $sql = "UPDATE {$this->_table} SET published = true WHERE postId = {$id}";
            return $this->_db->query($sql);
        }

        /**
         * Unpublished a post
         * 
         * @param int Post id
         * 
         * @return object DB obj if successful, otherwise false
         */
        public function unpublishPost($id) {

            $sql = "UPDATE {$this->_table} SET published = false WHERE postId = {$id}";
            return $this->_db->query($sql);
        }

        /**
         * Deletes a post
         * 
         * @param int Post id
         * 
         * @return object DB obj if successful, otherwise false
         */
        public function deletePost($id) {

            $sql = "DELETE FROM {$this->_table} WHERE postId = {$id}";
            return $this->_db->query($sql);
        }

    }