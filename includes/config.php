<?php

ob_start(); //bo dem luu tru
session_start();// khoi dong, cho phep truy xuat data

date_default_timezone_set("Europe/London");
try{
    $con = new PDO("mysql:dbname=dltflix;host=localhost","root","");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOException $e){
    exit("Connection failed " . $e->getMessage());
}

?>