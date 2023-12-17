<?php
    // installerBaseDeDonnees.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    require (__DIR__ . "/param.inc.php");
	
	require (__DIR__ . "/src/Membres/Administrer.php");
	
	$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ;
    $administrerMembres->installerBaseDeDonnees() ;
    
    header("Content-type: text/html; charset=UTF-8");
?><!DOCTYPE html>
<html lang="fr">
<head>
	<title>installerBaseDeDonnees.php</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<code>
		Tout se passe du côté serveur de base de données.<br>
Les tables de la base de données "<?php echo(MYDB) ; ?>" ont été créées.<br>
		Sur la-perso.univ-lemans.fr, l'application <a
			href="https://la-perso.univ-lemans.fr/pma-tp" target="_blank">phpmyadmin</a>
		vous permet de vérifier.
	</code>
</body>
</html>
