<?php
require_once("includes/header.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSancitizer.php");
require_once("includes/classes/Constants.php");
$detailsMessage = "";
$passwordMessage = "";


if (isset($_POST["saveDetailsButton"])) {
    $account = new Account($con);
    $firstName = FormSancitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSancitizer::sanitizeFormString($_POST["lastName"]);
    $email = FormSancitizer::sanitizeFormEmail($_POST["email"]);
    if ($account->updateDetails($firstName, $lastName, $email, $userLoggedIn)) {
        $detailsMessage = "<div class ='alertSuccess'>
        Details update success
        </div>";
    } else {
        $errorMessage = $account->getFirstError();
        $detailsMessage = "<div class ='alertError'>
        $errorMessage;
        </div>";
    }
}


if (isset($_POST["savePasswordButton"])) {
    $account = new Account($con);
    $oldPassword = FormSancitizer::sanitizeFormPassword($_POST["oldPassword"]);
    $newPassword = FormSancitizer::sanitizeFormPassword($_POST["newPassword"]);
    $newPassword2 = FormSancitizer::sanitizeFormPassword($_POST["newPassword2"]);

    if ($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedIn)) {
        $passwordMessage = "<div class ='alertSuccess'>
        Password Update Success
        </div>";
    } else {
        $errorMessage = $account->getFirstError();
        $passwordMessage = "<div class ='alertError'>
        $errorMessage;
        </div>";
    }
}
?>
<div class="settingsContainer column">
    <div class="formSection">
        <form method="POST">
            <h2>USER DETAILS</h2>
            <?php
            $user = new User($con, $userLoggedIn);
            $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $user->getFirstName();
            $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $user->getLastName();
            $email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();
            ?>

            <input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName ?>">
            <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">

            <div class="message">
                <?php echo $detailsMessage ?>
            </div>

            <input type="submit" name="saveDetailsButton" value="Save">
        </form>
    </div>

    <div class="formSection">
        <form method="POST">
            <h2>UPDATE PASSWORD</h2>
            <input type="password" name="oldPassword" placeholder="Old Password">
            <input type="password" name="newPassword" placeholder="New Password">
            <input type="password" name="newPassword2" placeholder="Confirm New Password">
            <div class="message">
                <?php echo $passwordMessage ?>
            </div>
            <input type="submit" name="savePasswordButton" value="Save">
        </form>
    </div>
</div>