<?php

    class AdminController extends Controller {


        public function __construct($controller, $action) {

            parent::__construct($controller, $action);

            redirectIfNotAuthenticated();
            if (!isAdmin()) Router::redirect();
        }

        /**
         * Render the homepage
         */
        public function indexAction() {

            $pm = new PostsModel();
            
            $this->_view->data['posts'] = $pm->getAllPostsByPage();
            $this->_view->data['pages'] = $pm->getNumberOfPages();

            $this->_view->render('admin/index');
        }

        /**
         * Approve an unpublished post
         */
        public function publishPostAction($params = []) {

            $pm = new PostsModel();
            $id = $params[0];

            if (isset($id) && !empty($id)) {

                if($pm->approvePost($id)) { setPushMessage("Post no. {$id} has been published"); }
                else                      { setPushMessage("There has been an error publishing this post"); }

                Router::redirect('admin');
            }
        }

        /**
         * Hide a published post
         */
        public function unpublishPostAction($params = []) {

            $pm = new PostsModel();
            $id = $params[0];

            if (isset($id) && !empty($id)) {

                if($pm->unpublishPost($id)) { setPushMessage("Post no. {$id} has been unpublished"); }
                else                        { setPushMessage("There has been an error unpublishing this post"); }
                
                Router::redirect('admin');
            }

        }

        /**
         * Delete a post 
         */
        public function deletePostAction($params = []) {

            $pm = new PostsModel();
            $id = $params[0];

            if (isset($id) && !empty($id)) {

                if($pm->deletePost($id)) { setPushMessage("Post no. {$id} has been deleted"); }
                else                     { setPushMessage("There has been an error deleting this post"); }

                Router::redirect('admin');
            }

        }

    }