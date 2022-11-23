<?php

namespace ApplicationModel;

class Post {
    private $postedByUser;
    private $postedText;
    private $postedTime;
    private $postedByID;

    public function __construct($postedByUser, $postedText, $postedTime, $postedByID) {
        $this->postedByUser = $postedByUser;
        $this->postedText = $postedText;
        $this->postedTime = $postedTime;
        $this->postedByID = $postedByID;
    }

    public function getPostUser() {
        return $this->postedByUser;
    }

    public function getPostID() {
        return $this->postedByID;
    }
    public function getPostedText() {
        return $this->postedText;
    }
    
    public function getPostedTime() {
        return $this->postedTime;
    }
}