<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header("Content-Type: text/html; charset=utf-8") ;

require (__DIR__ . "/param.inc.php");
require (__DIR__ . "/src/Membres/Administrer.php");
	
$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ; 


if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
    if(isset($_POST["idMessage"]) AND isset($_POST["idTheme"])){
    $idMessage = $_POST["idMessage"];
    $idTheme = $_POST["idTheme"];
    $user = $administrerMembres->obtenirMembre($_SESSION['id']) ;
    $administrerMembres->likerMessage($idMessage,$_SESSION['id']);
    header("Location: forumDetails.php?idTheme=".$idTheme);
    }else{
        header("Location: forum.php");
    }
}else{
        header("Location: connexion.php");
}

?>