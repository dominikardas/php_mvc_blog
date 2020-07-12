<?php

    class PostsController extends Controller {

        private $_allowedTags = '<h1> <h2> <h3> <b> <i> <u> <a> <br> <p> <img> <div> <ul> <ol> <li>';

        private $_validateRules = [
            'post_title' => [
                'display'  => 'Post title',
                'required' => true
            ],
            'post_desc' => [
                'display'  => 'Post description',
                'required' => true
            ],
            'post_content' => [
                'display'  => 'Post content',
                'required' => true
            ],
            'categoryName' => [
                'display'  => 'Category',
                'required' => true,
                'exists'   => 'categories'
            ]
        ];        

        public function __construct($controller, $action) {

            parent::__construct($controller, $action);
            $this->_loadModel('Posts');
        }

        /**
         * Render the index page for Posts
         */
        public function indexAction() {

            $this->_view->data = $this->PostsModel->getAllPosts();
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

                $posts = $this->PostsModel->getPostsByCategory($categoryName);

                if ($posts) {
                    $this->_view->data = $posts;
                    $this->_view->render('posts/category');
                }
                else {
                    display404();
                }
            }
            // If something goes wrong, redirect to the index - all posts
            else {
                display404();
            }
        }

        /**
         * Render a specific post by the slug parsed
         * 
         * @param array $params params[0] expected to be categoryName, params[1] expected to be slug
         */
        public function displayPostAction($params = []) {

            $categoryName = $params[0];
            $slug         = $params[1];

            // If the args are actually parsed
            if (!empty($categoryName) && !empty($slug)) {

                $post = $this->PostsModel->getPostBySlug($categoryName, $slug);

                if ($post) {

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
                // If no post is found, throw an error
                else {
                    display404();
                }
            }
            // If something goes wrong, redirect to the homepage
            else {
                display404();
            }
        }   

        /**
         * Render the designer page
         */
        public function designerAction() { 

            redirectIfNotAuthenticated();
            $this->_view->data['categories'] = getAllCategories();
            $this->_view->render('posts/designer');
        } 

        /**
         * Preview a post with posted parameters
         */
        public function previewAction() {      

            redirectIfNotAuthenticated();

            // Redirect is no post data is set
            if (!$_POST) Router::redirect();
            
            // Setup the view data and render the page
            $this->_view->data = [                        
                'title'        => Input::sanitize($_POST['post_title']),
                'publishedAt'  => date('Y-m-d'),
                'smallDesc'    => Input::sanitize($_POST['post_desc']),
                'authorName'   => currentUserFullName(),
                'content'      => strip_tags($_POST['post_content'], $this->_allowedTags),
            ];
            $this->_view->render('posts/post');
        }

        /**
         * Insert the post into the database
         */
        public function publishAction() {    

            redirectIfNotAuthenticated();

            // Form validation
            $validation = new Validate();
            $validation->check($_POST, $this->_validateRules);

            // Check if the validation has passed
            if (!$validation->passed()) {                

                $this->_view->displayErrors = $validation->displayErrors(); 
                $this->_view->data['categories'] = getAllCategories();
                $this->_view->render('posts/designer');
                exit;
            }

            // Verify the image 
            $postImage = Input::uploadImage();

            switch ($postImage) {
                case 'ERR_FILESIZE':
                    $error = "Your image exceeded the allowed filesize";      
                    break;
                case 'ERR_INVALID_FORMAT':
                    $error = "Invalid format of uploaded image";    
                    break;
                case 'ERR_UPLOAD':
                    $error = "Unknown error while uploading the image";  
                    break;
                default:
                    $error = null;
                    break;
            }

            if (!empty($error)) {                

                setPushMessage($error);
                $this->_view->data['categories'] = getAllCategories();
                $this->_view->render('posts/designer');
                exit;
            }

            // Verify the category
            
            // Setup the parameters array
            $params = [
                'title'        => Input::sanitize($_POST['post_title']),                    // Sanitize and set the post title 
                'slug'         => generateSlugFromTitle($_POST['post_title']),              // Generate post slug from title
                'published'    => 0,                                                        // Setup the published variable to false
                'publishedAt'  => date('Y-m-d'),                                            // Get current date
                'smallDesc'    => Input::sanitize($_POST['post_desc']),                     // Sanitize and set the post description 
                'content'      => strip_tags($_POST['post_content'], $this->_allowedTags),  // Strip the post content from unallowed tags
                'postImage'    => $postImage,                                               // The image path
                'authorName'   => currentUserFullName(),                                    // Get full name of logged in user
                'categoryName' => Input::sanitize($_POST['categoryName'])                   // Get the category
            ];

            // Insert the post into the database
            if ($this->PostsModel->publishPost($params)) {
                setPushMessage('Your post was submitted for review');
                Router::redirect();
            }
        }

    }