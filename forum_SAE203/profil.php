<?php
   // profil.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
	session_start();
	header("Content-Type: text/html; charset=utf-8") ;

    require (__DIR__ . "/param.inc.php");

    require (__DIR__ . "/src/Membres/Administrer.php");
	
	$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ; 
	 
	if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
        $user = $administrerMembres->obtenirMembre($_SESSION['id']) ;
?><!DOCTYPE html>
<html lang="fr">
	<head>
		<title>FORUM Profil</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://cdn.tailwindcss.com"></script>
	</head>
	<body class="lg:text-xl md:text-lg text-green-900 font-bold bg-green-100">
		<main>



		<nav>
        <ul class="flex items-center bg-green-300 justify-between">
            <div class="flex">
            <li class="p-5 ml-6">
                <a href="./index.php" class="hover:text-green-600">Accueil</a>
            </li>
            <li class="p-5">
                <a href="./forum.php" class="hover:text-green-600">Forum</a>
            </li>
            <li class="p-5">
                <a href="<?php
                    if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
                        echo("./profil.php");
                    }else{
                        echo("./connexion.php");
                    }
                        ?>" class="hover:text-green-600">
                        
                        <?php
                    if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
                        echo("Profil");
                    }else{
                        echo("Connexion & Inscription");
                    }
                        ?>
                </a>
            </li>
            <li class="p-5">
                <a href="" class="hover:text-green-600">À propos</a>
            </li>
        </div>
            <div class="hover:scale-110 mr-6">
            <li class="p-3">
                <a href="https://la-mytp.univ-lemans.fr/~mmi1_i2101718/wp/">
                   <img src="./images/logo_ecostaraoff.png" class="h-20 w-auto"/>
                </a>
            </li>
            </div>
        </ul>
    </nav>






        <div class="bg-white my-5 mx-auto p-4 rounded-md shadow-lg border-solid border border-stone-100 text-center w-1/3">
			<h1>Profil de <?php echo($_SESSION['pseudo']); ?></h1>
			<div class="colspan-2">
                <img src="<?php
                    echo($user['avatar']);
                ?>" class="w-12 mx-auto"/>
				<p class="my-2">Pseudo : <?php echo($_SESSION['pseudo']); ?></p>
				<p class="my-2">Mail : <?php echo($_SESSION['mail']); ?></p>
				<p class="my-2">Age : <?php echo($user['age']); ?></p>
				<a href="editionprofil.php" class="mx-4 text-blue-500">Editer mon profil</a>
				<a href="deconnexion.php" class="text-red-500">Se déconnecter</a>
			</div>
        </div>
		</main>
	</body>
</html>
<?php   
	}
	else{
		header("Location: connexion.php") ;
	}
?>