<?php
    // editionprofil.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
	session_start();
	header("Content-Type: text/html; charset=utf-8") ;
	
	require (__DIR__ . "/param.inc.php");
	
	require (__DIR__ . "/src/Membres/Administrer.php");
	
	$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ; 
	
	if(isset($_SESSION['id'])) {
		$user = $administrerMembres->obtenirMembre($_SESSION['id']) ;
		if($user != null) {
			if(isset($_POST['formeditionprofil'])) {
				$id = $_SESSION['id'] ;
				$newpseudo = htmlspecialchars($_POST['newpseudo']);
				$newmail = htmlspecialchars($_POST['newmail']);
				$actuMdp = htmlspecialchars($_POST['actuMdp']);
				$newage = htmlspecialchars($_POST['newage']);
				$newmdp1 = htmlspecialchars($_POST['newmdp1']);
				$newmdp2 = htmlspecialchars($_POST['newmdp2']);
				if($newmdp1 == $newmdp2) {
					try {
						$user = $administrerMembres->mettreAJour($id, $newpseudo, $newmail, $actuMdp, $newage, $newmdp1, $newmdp2) ;
						$_SESSION['id'] = $user['id'];
						$_SESSION['pseudo'] = $user['pseudo'];
						$_SESSION['mail'] = $user['mail'];
						header("Location: profil.php");
					}
					catch (Exception $e) {
						$erreur = $e->getMessage() ;
					}
				}
			}



			
?><!DOCTYPE html>
<html lang="fr">
	<head>
		<title>EcoStara | Profil</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Édition du profil afin de pouvoir modifier son pseudo, son avatar, son image de profil, etc. sur le site EcoStara" />
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
			<h1>Edition de mon profil</h1>
			<form method="post" action="editionprofil.php" enctype="multipart/form-data">
			<div class="requete">
				<div class="champs">
					<label for="newpseudo">Pseudo* :</label>
					<input type="text" name="newpseudo" id="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" required minlength="4" maxlength="255"/>
				</div>
				<div class="champs">
					<label for="newmail">Mail* :</label>
					<input type="email" name="newmail" id="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>" required/>
				</div>
				<div class="champs">
					<label for="newage">Age :</label>
					<input type="number" name="newage" id="newage" placeholder="age" value="<?php echo $user['age']; ?>" min="1" max="120"/>
				</div>
				<div class="champs">
					<label for="newavatar">Avatar :</label>
					<input type="file" name="avatar" id="newavatar" accept=".png,.jpg,.jpeg"/> 
				</div>
				<div class="champs">
						<label for="newmdp1">Nouveau mot de passe :</label>
						<input type="password" name="newmdp1" id="newmdp1" placeholder="4 caractères minimum" minlength="4" maxlength="255"/>
				</div>
				<div class="champs">
						<label for="newmdp2">Confirmation - mot de passe :</label>
						<input type="password" name="newmdp2" id="newmdp2" placeholder="Ré-écrivez votre mot de passe" minlength="4" maxlength="255"/>
				</div>
				<div class="champs">
					<label for="actuMdp">Mot de passe actuel* :</label>
					<input type="password" name="actuMdp" id="actuMdp" placeholder="Saisir le mot de passe pour toute modification" minlength="4" maxlength="255" required/>
				</div>
			</div>
				<div class="bouton">
				<a href="./profil.php">Annuler</a>
				<input type="submit" name="formeditionprofil" value="Mettre à jour mon profil !" />
				</div>

<?php if (isset($erreur)) { ?>
				<div>
					<div><?php echo ($erreur); ?></div>
				</div>
<?php } ?>
			</form>





		</main>
	</body>
</html>
<?php
		} // if($user != null)
		else {
			header("Location: connexion.php");
		}
	} // if(isset($_SESSION['id']))
	else {
		header("Location: connexion.php");
	}
?>