<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header("Content-Type: text/html; charset=utf-8") ;

if(isset($_POST["motCle"])) {
    header("Location: forum.php?motCle=".$_POST["motCle"]);
}else{
    header("Location: forum.php");
}

?>