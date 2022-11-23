<?php

namespace ApplicationController;

class MainController {
    private $username;
    
    public function __construct() {
        $this->layoutView = new \ApplicationView\LayoutView();
        $this->database = new \ApplicationModel\Database();
        $this->username = $_SESSION['username'];
    }
    
    public function renderHTML() {
        if($this->layoutView->wantToAddNewPost()) {
            $newPost = $this->layoutView->getNewPost($this->username);
            //TODO: Creates messages incases when textarefield is empty
            $this->database->sendNewPostToDB( $newPost ,$this->username);
        }

        if($this->layoutView->wantToDeletePost()) {
            $postToDelete = $this->layoutView->getPost();
            //TODO: Create messages after a post got deleted succesfull or if user tries to delete post that is not theirs.
            //Or make it so users can only see delete botton if they are the one that posted.
            $this->database->deletePost($this->username, $postToDelete);
        }

        $data = $this->database->showPostedContent();
        $this->layoutView->setPosts($data);
        return $this->layoutView->render();
    }
}