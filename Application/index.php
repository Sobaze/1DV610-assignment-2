<?php

namespace Application;

require_once('src/View/LayoutView.php');
require_once('src/Controller/MainController.php');
require_once('src/Model/DbModel.php');
require_once('src/Model/PostModel.php');

require_once('LocalSettings.php');
require_once('ProductionSettings.php');

class Application {
    public function __construct() {
        $this->mainController = new \ApplicationController\MainController();
    }

    public function renderApplication() {
        return $this->mainController->renderHTML();
    }
}