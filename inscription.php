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
					if(($mdplength >= 4) && ($mdplength <= 255)){
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
		<title>EcoStara | Inscription</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Inscrivez-vous au forum d'EcoStara afin de participer, avec d'autres utilisateurs, aux discussions liées à la sobriété numérique " />
		<link rel="shortcut icon" href="./images/logo_ecostaraoff.png" type="image/x-icon">
		<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
		<link rel="stylesheet" href="./css/style.css">
		<script src="scripts/menu.js"></script>
	</head>
	<body>
	<nav>
    <div id="mobileMenu" class="mobile-menu">
                    <i class="fa fa-bars"></i>
                    <img src="./images/menuburger.png" alt="Logo permettant d'ouvrir le menu burger" />
</div>
        <div class="menu">
            <ul>
                <li>
                    <a href="./index.php">Accueil</a>
                </li>
                <li>
                    <a href="./forum.php">Forum</a>
                </li>
                <li>
                    <a class="underline" href="<?php if (
                        isset($_SESSION['id']) and
                        $_SESSION['id'] > 0
                    ) {
                        echo './profil.php';
                    } else {
                        echo './connexion.php';
                    } ?>">

                        <?php if (
                            isset($_SESSION['id']) and
                            $_SESSION['id'] > 0
                        ) {
                            echo 'Profil';
                        } else {
                            echo 'Connexion & Inscription';
                        } ?>
                    </a>
                </li>
                <li>
                    <a href="./aPropos.php">À propos</a>
                </li>
            </ul>
            <div class="menu-img">
			<a href="https://la-mytp.univ-lemans.fr/~mmi1_i2101718/wp/" target="_blank" rel="noreferrer noopener">
                    <img src="./images/logo_ecostaraoff.png" alt="Logo du site Ecostara" />
                </a>
            </div>
        </div>
    </nav>
		<main class="inscription">
			<h1 class="text-center my-5">Inscription :</h1>
			<form method="post" action="inscription.php">
			<div class="requete">
				<div class="champs">
					<label for="pseudo">Pseudo* :</label>
					<input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" minlength="4" maxlength="255" value="<?php if(isset($_POST['pseudo'])) { echo (htmlspecialchars($_POST['pseudo'])); } ?>" required/>
				</div>
				<div class="champs">
					<label for="mail">Mail* :</label>
					<input type="email"  placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($_POST['mail'])) { echo (htmlspecialchars($_POST['mail'])); } ?>" required/>
				</div>
				<div class="champs">
					<label for="mail2">Confirmation du mail* :</label>
					<input type="email"  placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($_POST['mail2'])) { echo (htmlspecialchars($_POST['mail2'])); } ?>" required/>
				</div>
				<div class="champs">
					<label for="mdp">Mot de passe* :</label>
					<input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" required minlength="4" maxlength="255"/>
				</div>
				<div class="champs">
					<label for="mdp2">Confirmation du mot de passe* :</label>
					<input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" required minlength="4" maxlength="255"/>
				</div>
			</div>
			<div class="bouton">
			<a href="connexion.php" class="font-thin">Me connecter</a>

						<input type="submit" name="forminscription" value="Je m'inscris"/>
			</div>
<?php
	if(isset($_POST['forminscription'])) {
		if(isset($erreur)) {
?>
				<div>
					<div>
						<div><?php echo($erreur) ; ?></div>
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
			</form>
		</main>
	</body>
</html>