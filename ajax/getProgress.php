<?php
require_once("../includes/config.php");
if(isset($_POST["videoId"]) && isset($_POST["username"]) ){
    $query = $con->prepare("SELECT progress FROM videoprogress 
                                WHERE username=:username AND videoId=:videoId");
        $query->bindValue(":username",$_POST["username"]);
        $query->bindValue(":videoId",$_POST["videoId"]);
        $query->execute();
        echo $query->fetchColumn();
        // $query->execute();
      
}
else{
    echo "No videoId or username into file";
}
?>