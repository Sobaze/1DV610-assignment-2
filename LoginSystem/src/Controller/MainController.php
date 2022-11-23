<?php

namespace Controller;

class MainController {
    private $loginController;

    private $loginView;
    private $registerView;
    private $layoutView;

    private $dayAndTime;

    public function __construct() {
        
        $this->loginView = new \View\LoginView();
        $this->registerView = new \View\RegisterView();
        $this->layoutView = new \View\LayoutView($this->loginView, $this->registerView);
        
        $this->checker = $this->loginView->loggedInOrNot();
        $this->dayAndTime = new \Model\DateAndTimeModel();
        
        $this->loginController = new \Controller\LoginController($this->loginView);
    }

    public function startLogin() {

        //TODO: Want to move more stuff and make loginController work instead of having it in loginview

        return $this->layoutView->render($this->checker, $this->dayAndTime);
    }
}