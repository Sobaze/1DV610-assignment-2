<?php

namespace View;


class LayoutView {
  private $v;
  private $rv;

  public function __construct(\View\LoginView $v, \View\RegisterView $rv ) {
    $this->rv = $rv;
    $this->v = $v;
  }

  public function render(bool $isLoggedIn, \Model\DateAndTimeModel $dtm) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 3</h1>
          ' . $this->renderRegisterLink($isLoggedIn) . '
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $this->checkWhatViewToRender($isLoggedIn) . '
              
              ' . $dtm->show() . '
          </div>
          ' . $this->application($isLoggedIn) . '
         </body>
      </html>
    ';
  }

  // Creates the application if we are logged (a session username is set) in.
  private function application(bool $isLoggedIn) {
    while($_SESSION['username'] != null){
      $app = new \Application\Application();
      return $app->renderApplication();
    }
  }
  
  private function renderIsLoggedIn(bool $isLoggedIn) {
    if ($isLoggedIn == true || $_SESSION['username'] != null) {
      return '<h2>Logged in</h2>';
      $this->application($isLoggedIn);
    }
    else if ($isLoggedIn == false) {
      return '<h2>Not logged in</h2>';
    }
  }

  private function renderRegisterLink(bool $isLoggedIn) {
    if(isset($_GET['?register'])) {
      return 
      '<a href=?>Back to login</a>';
    } else if ($isLoggedIn == false && $_SESSION['username'] == null) {
      return '<a href=??register>Register a new user</a>';
    } 
  }
  public function checkWhatViewToRender(bool $isLoggedIn) {
      if (isset($_GET['?register'])) {
        return $this->rv->response($isLoggedIn);
      } else {
        return  $this->v->response($isLoggedIn);
      }
  }
}
