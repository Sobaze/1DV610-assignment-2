<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

require_once('LoginSystem/index.php');

session_start();
$loginSystem = new LoginSystem();

$login = $loginSystem->startMainController();