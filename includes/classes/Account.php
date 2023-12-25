<?php
class Account
{
    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function updateDetails($fn, $ln, $em, $un)
    {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateNewEmails($em, $un);
        if (empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET firstName=:fn, lastName=:ln, email=:em WHERE username=:un");
            $query->bindValue(":fn", $fn);
            $query->bindValue(":ln", $ln);
            $query->bindValue(":em", $em);
            $query->bindValue(":un", $un);
            return $query->execute();
        }
        return false;
    }

    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2)
    {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUsername($un);
        $this->validateEmails($em, $em2);
        $this->validatePassword($pw, $pw2);
        if (empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        }
        return false;
    }

    public function login($un, $pw)
    {
        $pw = hash("sha512", $pw);
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindValue(":un", $un);
        $query->bindValue(":pw", $pw);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);
        if ($query->rowCount() == 1) {
            $query = $this->con->prepare("INSERT INTO history_logs(user_id, status) VALUES (:ud, :stt)");
            $query->bindValue(":ud", $results["id"]);
            $query->bindValue(":stt", "Thanh Cong");
            $query->execute();
            return true;
        }
        array_push($this->errorArray, Constants::$LoginFailed);
        return false;
    }

    private function insertUserDetails($fn, $ln, $un, $em, $pw)
    {
        $pw = hash("sha512", $pw);
        $query = $this->con->prepare("INSERT INTO users (firstName, lastName, username, email, password) VALUES (:fn, :ln, :un, :em, :pw)");
        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":un", $un);
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $pw);
        return $query->execute();
    }

    public function validateFirstName($firstName)
    {
        if (strlen($firstName) < 2 || strlen($firstName) > 25) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    public function validateLastName($lastName)
    {
        if (strlen($lastName) < 2 || strlen($lastName) > 25) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    public function validateUsername($username)
    {
        if (strlen($username) < 2 || strlen($username) > 25) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un");
        $query->bindValue(":un", $username);
        $query->execute();
        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    private function validateEmails($email, $email2)
    {
        if ($email != $email2) {
            array_push($this->errorArray, Constants::$emailDonMatch);
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }
        $query = $this->con->prepare("SELECT * FROM users WHERE email=:em");
        $query->bindValue(":em", $email);
        $query->execute();
        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validateNewEmails($email, $username)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }
        $query = $this->con->prepare("SELECT * FROM users WHERE email=:email AND username!=:username");
        $query->bindValue(":email", $email);
        $query->bindValue(":username", $username);
        $query->execute();
        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return $error;
        }
    }

    public function validatePassword($password, $password2)
    {
        if ($password != $password2) {
            array_push($this->errorArray, Constants::$passwordsDonMatch);
            return;
        }
        if (strlen($password) < 5 || strlen($password) > 25) {
            array_push($this->errorArray, Constants::$passwordLength);
        }
    }
    public function getFirstError(){
        if(!empty($this->errorArray)){
            return $this->errorArray[0];
        }
    }

    public function updatePassword($oldPw, $pw, $pw2, $un){
        $this->validateOldPassword($oldPw, $un);
        $this->validatePassword($pw,$pw2);
        if (empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET passsword=:pw 
            WHERE username=:un");
            $pw = hash("sha512", $pw);
            $query->bindValue(":pw", $pw);
            $query->bindValue(":un", $un);
            return $query->execute();
        }
        return false;

    }
    public function validateOldPassword($oldPw, $un){
        $pw = hash("sha512", $oldPw);
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindValue(":un", $un);
        $query->bindValue(":pw", $pw);
        $query->execute();
        if($query->rowCount()==0){
                array_push($this->errorArray, Constants::$passwordIncorrect);
        }
    }

}