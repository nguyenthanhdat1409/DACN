<?php
   
    require_once("includes/config.php");
    require_once("includes/classes/FormSancitizer.php");
    require_once("includes/classes/Constants.php");
    require_once("includes/classes/Account.php");

   


    $account = new Account($con);

    // ham isset dung de kiem tra gia tri co rong, null hay ko -> false 
    if(isset($_POST["submitButton"])){
     
        $firstName = FormSancitizer:: sanitizeFormString( $_POST["firstName"]);
        $lastName = FormSancitizer:: sanitizeFormString( $_POST["lastName"]);
        $username = FormSancitizer:: sanitizeFormUsername( $_POST["username"]);
        $email = FormSancitizer:: sanitizeFormEmail( $_POST["email"]);
        $email2 = FormSancitizer:: sanitizeFormEmail( $_POST["email2"]);
        $password = FormSancitizer:: sanitizeFormPassword( $_POST["passsword"]);
        $password2 = FormSancitizer:: sanitizeFormPassword( $_POST["passsword2"]);

        // echo $firstName. " " . $lastName;
       //$success =  $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);
       $success =  $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);

       if($success){
        $_SESSION["userLoggedIn"] = $username;

        header("Location: index.php");
       }
       
    }

    function getInputValue($name){
       if(isset($_POST[$name])){
            echo $_POST[$name];
    } 
}
   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to DLTflix</title>
    <link rel="stylesheet" href="./assets/style/style.css">
</head>

<body>
    <div class="signInContainer">
        <div class="column">
            <div class="header">
                <img src="./assets/imagines/logo_DLT.png" alt="logo">
                <h3>Sign Up</h3>
                <span>to countinue to DLTflix</span>
            </div>
            <form method="POST">
                <?php echo  $account->getError(Constants::$firstNameCharacters); ?>
                <input type="text" name="firstName" placeholder="First Name: " value="<?php getInputValue("fi") ?>"
                    required>


                <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                <input type="text" name="lastName" placeholder="Last Name: " value="<?php getInputValue("lang") ?>"
                    required>

                <?php echo $account->getError(Constants::$usernameCharacters); ?>
                <?php echo $account->getError(Constants::$usernameTaken); ?>

                <input type="text" name="username" placeholder="User Name: " value="<?php getInputValue("username") ?>"
                    required>
                <?php  echo $account->getError(Constants::$emailDonMatch); ?>
                <?php echo $account->getError(Constants::$emailInvalid); ?>
                <?php echo $account->getError(Constants::$emailTaken); ?>

                <input type="email" name="email" placeholder="Email: " value="<?php getInputValue("email") ?>" required>
                <input type="email" name="email2" placeholder="Confirm email: " value="<?php getInputValue("em") ?>"
                    required>

                <?php echo $account->getError(Constants::$passwordsDonMatch); ?>
                <?php echo $account->getError(Constants::$passwordLength); ?>


                <input type="password" name="passsword" placeholder="Password: " required>
                <input type="password" name="passsword2" placeholder="Confirm Password: " required>
                <input type="submit" name="submitButton" value="SUBMIT">
            </form>
            <a href="login.php" class="signInMessage">Already have an account? <span style="color: blue;">Sign in
                    here!</span></a>
        </div>
    </div>
</body>

</html>