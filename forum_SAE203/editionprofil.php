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
				$newmdp1 = htmlspecialchars($_POST['newmdp1']);
				$newmdp2 = htmlspecialchars($_POST['newmdp2']);
				$newage = htmlspecialchars($_POST['newage']);
				if($newmdp1 == $newmdp2) {
					try {
						$user = $administrerMembres->mettreAJour($id, $newpseudo, $newmail, $newmdp1, $newage) ;
						$_SESSION['id'] = $user['id'];
						$_SESSION['pseudo'] = $user['pseudo'];
						$_SESSION['mail'] = $user['mail'];
						header("Location: profil.php");
					}
					catch (Exception $e) {
						$erreur = $e->getMessage() ;
					}
				}
				else {
					$erreur = "Vos deux mdp ne correspondent pas !";
				}
			}
			
?><!DOCTYPE html>
<html lang="fr">
	<head>
		<title>FORUM Edition Profil</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://cdn.tailwindcss.com"></script>
	</head>
	<body class="lg:text-xl md:text-lg text-green-900 font-bold bg-green-100">
		<main>
			<h1>Edition de mon profil</h1>
			<form method="post" action="editionprofil.php" enctype="multipart/form-data">
				<div class="row">
					<label for="newpseudo">Pseudo :</label>
					<input type="text" name="newpseudo" id="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" />
				</div>
				<div class="row">
					<label for="newmail">Mail :</label>
					<input type="email" name="newmail" id="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>" />
				</div>
				<div class="row">
					<label for="newmdp1">Mot de passe :</label>
					<input type="password" name="newmdp1" id="newmdp1" placeholder="4 caractères minimum" />
				</div>
				<div class="row">
					<label for="newmdp2">Confirmation - mot de passe :</label>
					<input type="password" name="newmdp2" id="newmdp2" />
				</div>
				<div class="row">
					<label for="newmage">Age :</label>
					<input type="number" name="newage" id="newage" placeholder="age" value="<?php echo $user['age']; ?>" />
				</div>
				<div class="row">
					<input class="colspan-2" type="submit" name="formeditionprofil" value="Mettre à jour mon profil !" />
				</div>
<?php if (isset($erreur)) { ?>
				<div class="row">
					<div class="colspan-2 error"><?php echo ($erreur); ?></div>
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