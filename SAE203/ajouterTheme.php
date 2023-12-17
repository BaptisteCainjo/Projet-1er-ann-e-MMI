<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header("Content-Type: text/html; charset=utf-8") ;

require (__DIR__ . "/param.inc.php");
require (__DIR__ . "/src/Membres/Administrer.php");
	
$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ; 

if(isset($_SESSION['id']) AND $_SESSION['id'] > 0 AND $_SESSION['estAdmin']==1) {
    $user = $administrerMembres->obtenirMembre($_SESSION['id']) ;

if(isset($_POST['ajouterTheme'])) {
    if(isset($_POST['titreNewTheme']) AND isset($_POST['descNewTheme'])){
        $administrerMembres->ajouterTheme($_POST['titreNewTheme'], $_POST['descNewTheme']);
        header("Location: forum.php");
    }
    else{
        echo("Veuillez renseigner tous les champs.");
        header("Location: forum.php");
    }
}else{
    header("Location: forum.php");
}
}else{
    header("Location: forum.php");
}


    ?>