<?php
    // inscription.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
	header("Content-Type: text/html; charset=utf-8") ;
	
	require (__DIR__ . "/param.inc.php");
	
	require (__DIR__ . "/src/Membres/Administrer.php");
	require(__DIR__ . "/src/PHPMailer.php");              // Ajoute le fichier contenant le code de la classe PHPMailer
	require(__DIR__ . "/src/SMTP.php");                   // le code de la classe SMTP
	require(__DIR__ . "/src/Exception.php");              // le code de la classe Exception
	
	$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ;
	
	if(isset($_POST['forminscription'])) {
		if(!empty($_POST['pseudo']) 
			AND !empty($_POST['mail']) 
			AND !empty($_POST['mail2']) 
			AND !empty($_POST['mdp']) 
			AND !empty($_POST['mdp2'])) {
			$pseudo = htmlspecialchars($_POST['pseudo']);
			$mail = htmlspecialchars($_POST['mail']);
			$mail2 = htmlspecialchars($_POST['mail2']);
			$mdp = $_POST['mdp'];
			$mdp2 = $_POST['mdp2'];

			if($mail == $mail2) {
				/**if($pseudo)**/
				if($mdp == $mdp2) {
					$mdplength = mb_strlen($mdp);
					if($mdplength >= 4){
						try {
							$administrerMembres->inscrire($pseudo, $mail, $mdp) ;
						}
						catch (Exception $e) {
							$erreur = $e->getMessage() ;
						}
					}else{
						$erreur = "Votre mot de passe doit posséder au moins 4 caractères !";
					}
				} else {
					$erreur = "Vos mots de passes ne correspondent pas !";
				}
			} else {
				$erreur = "Vos adresses mail ne correspondent pas !";
			}
		} else {
			$erreur = "Tous les champs doivent être complétés !";
		}
	}
?><!DOCTYPE html>
<html lang="fr">
	<head>
		<title>FORUM Inscription</title>
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
			<h1 class="text-center my-5">Inscription</h1>
			<form method="post" action="inscription.php" class="block">
				<div>
					<label for="pseudo">Pseudo :</label>
					<input type="text" class="border-solid border border-stone-100 my-5 mx-auto w-2/3" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($_POST['pseudo'])) { echo (htmlspecialchars($_POST['pseudo'])); } ?>" />
				</div>
				<div>
					<label for="mail">Mail :</label>
					<input type="email" class="border-solid border border-stone-100 my-5 mx-auto w-2/3" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($_POST['mail'])) { echo (htmlspecialchars($_POST['mail'])); } ?>" />
				</div>
				<div>
					<label for="mail2">Confirmation du mail :</label>
					<input type="email" class="border-solid border border-stone-100 my-5 mx-auto w-2/3" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($_POST['mail2'])) { echo (htmlspecialchars($_POST['mail2'])); } ?>" />
				</div>
				<div>
					<label for="mdp">Mot de passe :</label>
					<input type="password" class="border-solid border border-stone-100 my-5 mx-auto w-2/3" placeholder="Votre mot de passe" id="mdp" name="mdp" />
				</div>
				<div>
					<label for="mdp2">Confirmation du mot de passe :</label>
					<input type="password" class="border-solid border border-stone-100 my-5 mx-auto w-2/3" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
				</div>
						<input type="submit" name="forminscription" value="Je m'inscris" class="text-blue-500 font-bold m-auto block"/>
<?php
	if(isset($_POST['forminscription'])) {
		if(isset($erreur)) {
?>
				<div class="row">
					<div class="colspan-2">
						<div class="error"><?php echo($erreur) ; ?></div>
					</div>
				</div>
<?php
		} 
		else {
?>
					<div>
						Veuillez valider votre compte par email
					</div>					
<?php
		}
	}
?>
					<a href="connexion.php" class="font-thin">Me connecter</a>
			</form>
		</main>
	</body>
</html>