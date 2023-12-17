<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header("Content-Type: text/html; charset=utf-8") ;

require (__DIR__ . "/param.inc.php");
require (__DIR__ . "/src/Membres/Administrer.php");
	
$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ; 

if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
    $user = $administrerMembres->obtenirMembre($_SESSION['id']) ;
if(isset($_POST["idTheme"])) {
    $idTheme = $_POST["idTheme"];
    if(isset($_POST['contenu']) && $_POST['contenu'] != "" && isset($_POST['posterMessage'])){
        $administrerMembres->publierMessage($user['id'], $_POST['contenu'], $idTheme);
        header("Location: forumDetails.php?idTheme=".$idTheme);
    }else{
        header("Location: forumDetails.php?idTheme=".$idTheme);
    }
}else{
    header("Location: forum.php");
}
}else{
    header("Location: connexion.php");
}


    ?>