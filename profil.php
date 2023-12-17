<?php
   // profil.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
	session_start();
	header("Content-Type: text/html; charset=utf-8") ;

    require (__DIR__ . "/param.inc.php");

    require (__DIR__ . "/src/Membres/Administrer.php");
	
	$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ; 

    if(isset($_POST['id']) || isset($_SESSION['id'])){

    if(isset($_POST['id'])){
        $user = $administrerMembres->obtenirMembre($_POST['id']) ;
    }
    elseif(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
        $user = $administrerMembres->obtenirMembre($_SESSION['id']) ;
    }
    
        
?><!DOCTYPE html>
<html lang="fr">
	<head>
		<title>EcoStara | Profil</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Il s'agit d'une page indiquant toutes les informations personnelles sur un utilisateur du forum EcoStara" />
        <link rel="shortcut icon" href="./images/logo_ecostaraoff.png" type="image/x-icon">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
        <link rel="stylesheet" href="./css/style.css">
        <script src="scripts/menu.js"></script>
	</head>
	<body>
		<main class="profil">
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
                <a class="underline" href="<?php
                    if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
                        echo("./profil.php");
                    }else{
                        echo("./connexion.php");
                    }
                        ?>">
                        
                        <?php
                    if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
                        echo("Profil");
                    }else{
                        echo("Connexion & Inscription");
                    }
                        ?>
                </a>
            </li>
            <li>
                <a href="./aPropos.php">À propos</a>
            </li>
            </ul>
            <div class="menu-img">
            <a href="https://la-mytp.univ-lemans.fr/~mmi1_i2101718/wp/" target="_blank" rel="noreferrer noopener">
                   <img src="./images/logo_ecostaraoff.png" alt="Logo du site Ecostara"/>
                </a>
            </div>
        </div>
    </nav>

        <div class="boiteInfos">
			<h1>Profil de <?php echo($user['pseudo']); ?></h1>
            <div class="imageProfil"><img src="<?php
            echo("./images/membres/avatars/".$user['avatar']);
            ?>" alt="Photo de profil"/></div>
			<p>Mail : <?php echo($user['mail']); ?></p>
			<p>Age : <?php echo($user['age']); ?></p>
        <?php 
        if(isset($_SESSION['id'])){
        if($user['id'] == $_SESSION['id']){ ?>
            <div class="lien">
			<a href="editionprofil.php" class="editerProfil">Editer mon profil</a>
			<a href="deconnexion.php" class="deconnexion">Se déconnecter</a>
            </div>
        <?php }} ?>
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