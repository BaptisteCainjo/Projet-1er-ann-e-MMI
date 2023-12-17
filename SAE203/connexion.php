<?php
// connexion.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/param.inc.php';

require __DIR__ . '/src/Membres/Administrer.php';

$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS);
if (isset($_POST['formconnexion'])) {
    try {
        $user = $administrerMembres->connecter(
            $_POST['mailconnect'],
            $_POST['mdpconnect']
        );
        $_SESSION['id'] = $user['id'];
        $_SESSION['pseudo'] = $user['pseudo'];
        $_SESSION['mail'] = $user['mail'];
        $_SESSION['estAdmin'] = $user['estAdmin'];
        header('Location: forum.php');
    } catch (Exception $e) {
        $erreur = $e->getMessage();
    }
}
?><!DOCTYPE html>
<html lang="fr">
	<head>
		<title>EcoStara | Connexion</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Connectez-vous au forum d'EcoStara afin de participer, avec d'autres utilisateurs, aux discussions liées à la sobriété numérique" />
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

		<main class="connexion">
			
			<h1>Connexion :</h1>
			<form method="post" action="connexion.php">
				<div class="requete">
				<div class="champs">
					<label for="mail">Mail* :</label>
					<input id="mail" type="email" name="mailconnect" placeholder="Mail" aria-label="email" required/>
				</div>
				<div class="champs">
					<label for="motDePasse">Mot de Passe* :</label>
					<input id="motDePasse" type="password" name="mdpconnect" placeholder="Mot de passe" aria-label="mot de passe" minlength="4" maxlength="255" required/>
				</div>
			</div>
				<div class="bouton">
				<a href="./inscription.php">Pas de compte ?</a>
				<input type="submit" name="formconnexion" value="Se connecter !" />
				</div>

<?php if (isset($erreur)) { ?>
				<div></div>
					<div><?php echo $erreur; ?></div>
				</div>	
<?php } ?>
			</form>
		</main>

	</body>
</html>