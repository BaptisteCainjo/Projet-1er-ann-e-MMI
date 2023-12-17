<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header("Content-Type: text/html; charset=utf-8") ;

require (__DIR__ . "/param.inc.php");
require (__DIR__ . "/src/Membres/Administrer.php");
	
$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ; 


if(isset($_SESSION['id']) && $_SESSION['estAdmin']==1) {
    if(isset($_POST["idTheme"])){
        $idTheme = $_POST["idTheme"];
        $administrerMembres->supprimerLeTheme($idTheme);
        header("Location: forum.php");
}else{
    header("Location: forum.php");
}
}else{
    header("Location: forum.php");
}

?>