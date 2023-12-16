<?php
    require_once("includes/header.php");

    $prevew = new PreviewProvider($con, $userLoggedIn);
    echo $prevew->createPreviewVideo(null);
    $containers = new CategoryConatiners($con, $userLoggedIn);
    echo $containers->showAllCategories();
    

?>