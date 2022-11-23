<?php

namespace Controller;


// NOT BEING USED, NEVER MANAGED TO IMPLEMENT THIS.

// TODO: Make this work and move out some stuff from login view to work here instead!!
class LoginController {
    private $loginView;

    private static $standardUsername = "Admin";
	private static $standardPassword = "Password";

    public function __construct(\View\LoginView $lv) {
        $this->loginView = $lv;
    }

    public function lookForUserSession() {
        if($this->loginView->userStored()) {
            $this->loginView->storeUserSession(true);
        } 
    }

    public function controllIfUserSeeksToLogout() {
        if($this->loginView->userSeeksToLogout()) {
            $this->loginView->showMessage(\View\Messages::$byebye);
        }
    }

    public function controllIfUserSeeksToLogin() {
        if($this->loginView->userSeeksToLogin()) {
            $user = $this->loginView->getRequestUserName();
            $this->loginView->storeUserSession($user.name);
        }
    }

    public function attemptToLogin() {
        if($this->loginView->userSeeksToLogin()) {
        }
    }
}