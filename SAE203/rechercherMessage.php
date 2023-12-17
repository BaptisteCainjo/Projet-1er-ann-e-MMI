<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header("Content-Type: text/html; charset=utf-8") ;


if(isset($_POST["idTheme"])){
    if(isset($_POST['motCle'])) {
        $idTheme=$_POST["idTheme"];
        header("Location: forumDetails.php?idTheme=".$idTheme."&motCle=".$_POST["motCle"]);
    }else{
        header("Location: forumDetails.php?idTheme=".$idTheme);
    }
}else{
    header("Location: forum.php");
}


?>