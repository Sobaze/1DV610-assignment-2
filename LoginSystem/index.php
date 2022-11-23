<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

//INCLUDE THE FILES NEEDED...
require_once('src/Controller/MainController.php');
require_once('src/Controller/LoginController.php');

require_once('src/View/LoginView.php');
require_once('src/Model/DateTimeModel.php');
require_once('src/View/LayoutView.php');
require_once('src/View/RegisterView.php');
require_once('src/View/Messages.php');

require_once('Application/index.php');
//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER


//CREATE OBJECTS OF THE VIEWS

class LoginSystem {

    public function startMainController() {
    
        $login = new \Controller\MainController();
        
        $login->startLogin();
    }
}
