<?php

namespace View;


class RegisterView {
    private static $name = "RegisterView::UserName";
    private static $password = "RegisterView::Password";
    private static $passwordConfirm = "RegisterView::PasswordRepeat";
    private static $messageId = "RegisterView::Message";
    private static $register = "RegisterView::Register";
    private static $usernameValue = "";
    private $mes = "";

    public function response(bool $isLoggedIn) {
		$message = $this->getRegisterMessage();
			
		$response = $this->generateRegisterFormHTML($message); 
		return $response;
    }
    
    public function getRegisterMessage() {
        //if register button is pressed
        if(isset($_POST[self::$register])) {

            if(strlen($_POST[self::$name]) < 3) {
                $this->showMessage(\View\Messages::$usernameShort);
                $this->userWannaRegister();
            }
            if(strlen($_POST[self::$password]) < 6) {
                $this->showMessage(\View\Messages::$passwordShort);
                if(strlen($_POST[self::$name]) >= 3) {
                    $this->userWannaRegister();
                }
            }
            if(strlen($_POST[self::$name]) < 3 && strlen($_POST[self::$password] < 6)) {
                $this->showMessage(\View\Messages::$emptyFields);
            }
            if($_POST[self::$password] != $_POST[self::$passwordConfirm]) {
                $this->showMessage(\View\Messages::$passwordMissMatch);
                self::$usernameValue = $_POST[self::$name];
            } if ($_POST[self::$name] == "Admin") {
                $this->showMessage(\View\Messages::$userExists);
            }
        }
    }

    public function showMessage(string $msg) : void {
		$this->mes = $msg;
	}


    private function generateRegisterFormHTML($message) {
        // TODO: need to create registercontroller works with this

        return '
        <h2>Register new user</h2>
         <form action="??register" method="post" ectype="multipart/form-data">
             <fieldset>
                <legend> Register a new user - Write username and password </legend>
                    <p id ="' . self::$messageId . '" > ' . $this->mes . ' </p>

                    <label for="' . self::$name . '">Username : </label>
                    <input type="text" size="20" name="' . self::$name .'" id="' . self::$name . '"  value="' . self::$usernameValue .'" />
                    <br>
                    <label for="' . self::$password . '">Password :</label>
                    <input type="password" size="20" name="' . self::$password . '" id="' . self::$password . '" value=""/>
                    <br>
                    <label for="' . self::$passwordConfirm . '">Repeat password :</label>
                    <input type="password" size="20" name="' . self::$passwordConfirm . '" id="' . self::$passwordConfirm . '" value="" />
                    <br>
					<input type="submit" name="' . self::$register . '" id="'. self::$register .'" value="Register" />
                </fieldset>
          </form>
        ';
    }

    public function userWannaRegister () {
        $usernameInput = $_POST[self::$name];
        return self::$usernameValue = $usernameInput;
    }
}