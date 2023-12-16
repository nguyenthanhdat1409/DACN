<?php
    require_once("includes/config.php");
    require_once("includes/classes/FormSancitizer.php");
    require_once("includes/classes/Constants.php");
    require_once("includes/classes/Account.php");


    $account = new Account($con);

    if(isset($_POST["submitButton"])){

      
        $username = FormSancitizer:: sanitizeFormUsername( $_POST["username"]);
      
        $password = FormSancitizer:: sanitizeFormPassword( $_POST["passsword"]);
        
        $success  = $account->login($username, $password);
        
        // echo $firstName. " " . $lastName;
       //$success =  $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);
       $success =  $account->login( $username, $password);

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
                <h3>Sign In</h3>
                <span>to countinue to DLTflix</span>
            </div>
            <form method="POST" action="">

                <?php echo  $account->getError(Constants::$LoginFailed); ?>

                <input type="text" name="username" placeholder="User Name: " value="<?php getInputValue("username") ?>"
                    required>

                <input type="password" name="passsword" placeholder="Password: " required>

                <input type="submit" name="submitButton" value="SUBMIT">


            </form>
            <a href="register.php" class="signInMessage">Need an account?<span style="color: blue;"> Sign up
                    here!</span></a>
        </div>
    </div>
</body>

</html>