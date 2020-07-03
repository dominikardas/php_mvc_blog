<?php

    class PostsController extends Controller {

        public function __construct($controller, $action) {

            parent::__construct($controller, $action);
            $this->_model = new PostsModel('Posts');

            // Set layout
            // $this->view->setLayout('posts/indexLayout');
        }

        /**
         * Render the index page for Posts
         */
        public function indexAction() {

            $this->_view->data = $this->_model->getAllPosts();
            $this->_view->render('posts/index');
        }

        /**
         * Render all pages from given category
         * 
         * @param array $params Param 0 expected to be categoryName
         */
        // Param 0 expected to be categoryName
        public function displayCategoryAllAction($params = []) {

            $categoryName = $params[0];

            if (!empty($categoryName)) {
                $posts = $this->_model->getPostsByCategory($categoryName);
                $this->_view->data = $posts;
                $this->_view->render('posts/category');
            }
            // If something goes wrong, redirect to the index - all posts
            else {
                $this->indexAction();
            }
        }

        /**
         * Render a specific post by the slug parsed
         * 
         * params[0] expected to be categoryName
         * 
         * params[1] expected to be slug
         * @param array $params
         */
        public function displayPostAction($params = []) {

            $categoryName = $params[0];
            $slug         = $params[1];

            // If a slug is actually parsed
            if (count($params) > 0) {

                $post = $this->_model->getPostBySlug($categoryName, $slug);
                // dump($post);

                // TODO: Should display error
                if (!$post) $this->indexAction();
                else {
                    $post = (array)$post;

                    // Set the data accordingly               
                    
                    $this->_view->data = [
                        
                        'title'        => $post['title'],
                        'publishedAt'  => $post['publishedAt'],
                        'smallDesc'    => $post['smallDesc'],
                        'image'        => $post['postImage'],
                        'authorName'   => $post['authorName'],
                        'content'      => $post['content'],
                    ];
                    
                    $this->_view->setTitle($post['title']);
                    $this->_view->render('posts/post');
                }
            }
            // If something goes wrong, redirect to the index - all posts
            else {
                $this->indexAction();
            }
        }   
    }