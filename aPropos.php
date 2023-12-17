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
    <title>EcoStara | À propos</title>
    <link rel="shortcut icon" href="./images/logo_ecostaraoff.png" type="image/x-icon">
    <meta name="description" content="Découvrez plus sur les objectifs et les personnes dernières la réalisation du site EcoStara. " />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Oswald&display=swap" rel="stylesheet">
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
                    <a href="./aPropos.php" class="underline">À propos</a>
                </li>
            </ul>
            <div class="menu-img">
                <a href="https://la-mytp.univ-lemans.fr/~mmi1_i2101718/wp/" target="_blank" rel="noreferrer noopener">
                    <img src="./images/logo_ecostaraoff.png" alt="Logo du site Ecostara" />
                </a>
            </div>
        </div>
    </nav>

    <main class="aPropos">
    <p class="user">
        <?php echo ($nbrUser); ?>
    </p>

        <div class="propos">
            <div class="propos-text">
            <div class="propos-text1">
                <p>EcoStara a été créé en 2022, dans l'objectif de rendre le sujet de la sobriété numérique ouvert à tous, tout en étant interactif.</p>
            </div>
            <div class="propos-text2">
                <p>De nos jours, tous le monde est concerné par l'environnement, mais peu de gens sont informés et par conséquent ne savent pas comment s'y prendre pour agir.</p>
            </div>
            <div class="propos-text3">
                <p>Telio Garnier, Baptiste Cainjo et Killian Burel ont réalisé ce site web interactif afin d'informer les utilisateurs sur les pratiques et manières liées à la sobriété numérique</p>
            </div>
            </div>
        </div>
    </main>


</body>

</html>