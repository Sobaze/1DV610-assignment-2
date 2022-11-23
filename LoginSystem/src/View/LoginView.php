<?php

namespace View;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $usernameValue = "";

	private static $decidedUsername = "Admin";
	private static $decidedPassword = "Password";

	private $mes = "";


	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response(bool $isLoggedIn) {
		$message = $this->getMessage();

		$this->loginAttemptUserSentCredentials();

		if( $this->loggedInOrNot() == true || $_SESSION['username'] != null) {
			$response = $this->generateLogoutButtonHTML($this->mes);
			//TODO: Fix so user gets logged out on 1 click.
			$this->logoutUser();
		} else {
			
			$response = $this->generateLoginFormHTML($message); 
		}
		
		return $response;
	}

	public function loggedInOrNot() {
		if($this->loginAttemptUserSentCredentials() == true ) {
			$_SESSION['username'] = $_POST[self::$name];
			return true;
		}
		else {
			return false;
		}
	}

	public function loginAttemptUserSentCredentials() {
		if($_POST[self::$name] == self::$decidedUsername && $_POST[self::$password] == self::$decidedPassword) {
			return true;

		} else {
			return false;
		}
	}

	public function getMessage() {
		//if button submitt pressed

		//TODO: The messages to display should be implemented into loginController.
		if($this->userSeeksToLogin()) {

			if(strlen($_POST[self::$name]) == 0 ) {
				$this->showMessage(\View\Messages::$usernameMissgin);
			} 
			else if(strlen($_POST[self::$password]) == 0) {
				$this->showMessage(\View\Messages::$passwordMissing);
				self::$usernameValue = $_POST[self::$name];
			}
			else if ($_POST[self::$name] == self::$decidedUsername &&  $_POST[self::$password] != self::$decidedPassword) {
				$this->showMessage(\View\Messages::$incorrectInfo);

			}
			else if ($_POST[self::$name] != self::$decidedUsername && $_POST[self::$password] == self::$decidedPassword) {
				$this->showMessage(\View\Messages::$incorrectInfo);
			}
			else if ($_POST[self::$name] == self::$decidedUsername && $_POST[self::$password] == self::$decidedPassword) {
				$this->showMessage(\View\Messages::$welcome);
			} else if(isset($_POST[self::$logout])) {
				if(isset($_SESSION['username'])) {
					$this->showMessage(\View\Messages::$byebye);
				}
			}
		}
	}
	public function showMessage(string $msg) : void {
		$this->mes = $msg;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML(string $message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->mes .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	public function logoutUser() {
		if(isset($_POST[self::$logout])) {

			unset($_SESSION['username']);
			session_unset();
		}
	}

	public function userSeeksToLogin() {
		return isset($_POST[self::$login]) && !$this->userStored();
	}

	public function userSeeksToLogout() {
		return isset($_POST[self::$logout]) && $this->userStored();
	}

	public function userStored() {
		return isset($_SESSION['username']);
	}

	public function storeUserSession($sessionToStore) {
		$_SESSION['username'] = $sessionToStore;
	}

	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $this->mes . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. self::$usernameValue .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
		$username = $_POST[self::$name];
		$password = $_POST[self::$password];
	}
	
}