<?php
// profil.php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header("Content-Type: text/html; charset=utf-8");


require(__DIR__ . "/param.inc.php");

require(__DIR__ . "/src/Membres/Administrer.php");

$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS);
?>





<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoStara | Accueil</title>
    <link rel="shortcut icon" href="./images/logo_ecostaraoff.png" type="image/x-icon">
    <meta name="description" content="Ecostara consiste à proposer du contenu de prévention de manière interactive en libre accès via un site web. Un forum est disponible permettant aux utilisateurs de communiquer entre eux" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style_non_minifie.css">
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
                    <a href="./index.php" class="underline">Accueil</a>
                </li>
                <li>
                    <a href="./forum.php">Forum</a>
                </li>
                <li>
                    <a href="<?php
                                if (isset($_SESSION['id']) and $_SESSION['id'] > 0) {
                                    echo ("./profil.php");
                                } else {
                                    echo ("./connexion.php");
                                }
                                ?>">

                        <?php
                        if (isset($_SESSION['id']) and $_SESSION['id'] > 0) {
                            echo ("Profil");
                        } else {
                            echo ("Connexion & Inscription");
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
                    <img src="./images/logo_ecostaraoff.png" alt="Logo du site Ecostara" />
                </a>
            </div>
        </div>
    </nav>

    <main class="index">
        <div class="accueil">
            <div class="accueil-text">
            <h1 class="grosTitre">FORUM</h1>

            <div class="text1">
                <p>LA SOBRIÉTÉ NUMÉRIQUE EST UN SUJET QUI VOUS INTÉRESSE ?</p>
            </div>
            <div class="text2">
                <p>NOUS AUSSI !</p>
            </div>
            <div class="text3">
                <p>VENEZ DÉBATTRE ET ARGUMENTER SUR DIFFÉRENTS SUJETS OU ENCORE DÉCOUVRIR L'AVIS DES AUTRES...</p>
            </div>

            <h2>PAR ECOSTARA</h2>
            </div>
        </div>
    </main>


</body>

</html>