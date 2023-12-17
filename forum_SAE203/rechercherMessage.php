<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header("Content-Type: text/html; charset=utf-8") ;

$idTheme=$_POST["idTheme"];

if(isset($_POST['rechercherMessage'])) {
    header("Location: forumDetails.php?idTheme=".$idTheme."&motCle=".$_POST["motCle"]);
}

?>