<?php
require_once("../includes/config.php");
if (isset($_POST["videoId"]) && isset($_POST["username"]) && isset($_POST["progress"])) {
    $query = $con->prepare("UPDATE videoprogress SET progress=:progress
                                 WHERE username=:username AND videoId=:videoId");
    $query->bindValue(":username", $_POST["username"]);
    $query->bindValue(":videoId", $_POST["videoId"]);
    $query->bindValue(":progress", $_POST["progress"]);

    $query->execute();
    if ($query->rowCount() == 0) {
        $query = $con->prepare("INSERT INTO videoprogress (username, videoId) 
                    VALUES(:username, :videoId)");
    }
} else {
    echo "No videoid or username into file";
}
