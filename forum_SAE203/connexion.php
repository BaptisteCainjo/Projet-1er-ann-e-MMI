<?php
    // connexion.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

	session_start();
	header("Content-Type: text/html; charset=utf-8") ;
	
	require (__DIR__ . "/param.inc.php");
	
	require (__DIR__ . "/src/Membres/Administrer.php");
	
	$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ; 
	if(isset($_POST['formconnexion'])) {
		try {
			$user = $administrerMembres->connecter($_POST['mailconnect'], $_POST['mdpconnect']) ;
			$_SESSION['id'] = $user['id'];
			$_SESSION['pseudo'] = $user['pseudo'];
			$_SESSION['mail'] = $user['mail'];
			header("Location: index.php");
		} 
		catch (Exception $e) {
			$erreur = $e->getMessage() ;f
		}
	}
?><!DOCTYPE html>
<html lang="fr">
	<head>
		<title>FORUM Connexion</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://cdn.tailwindcss.com"></script>
	</head>
	<body class="lg:text-xl md:text-lg text-green-900 font-bold bg-green-100">
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

		<main class="bg-white my-5 mx-auto p-4 rounded-md shadow-lg border-solid border border-stone-100 w-1/4">
			<h1 class="text-center my-5">Connexion</h1>
			<form method="post" action="connexion.php">
				<div class="border-solid border border-stone-100 my-5 mx-auto w-2/3">
					<input class="" type="email" name="mailconnect" placeholder="Mail" aria-label="email" />
				</div>
				<div class="border-solid border border-stone-100 my-5 m-auto w-2/3">
					<input class="" type="password" name="mdpconnect" placeholder="Mot de passe" aria-label="mot de passe"/>
				</div>
				<div class="text-right">
					<input class="text-blue-500 font-bold" type="submit" name="formconnexion" value="Se connecter !" />
				</div>
<?php
	if(isset($erreur)) {
?>
				<div class="row"></div>
					<div class="colspan-2 error"><?php echo($erreur) ; ?></div>
				</div>	
<?php
	}
?>
			</form>
			<a href="./inscription.php" class="font-thin">Pas de compte ?</a>
		</main>
	</body>
</html>