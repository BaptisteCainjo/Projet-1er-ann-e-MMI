<?php
// connexion.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header("Content-Type: text/html; charset=utf-8");

require(__DIR__ . "/param.inc.php");

require(__DIR__ . "/src/Membres/Administrer.php");

$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS);
if (isset($_GET["motCle"])) {
    $motCle = $_GET["motCle"];
} else {
    $motCle = null;
}

$nomTheme = $administrerMembres->obtenirTheme($motCle);
?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <title>EcoStara | Forum</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Le forum d'EcoStara permet à chaque utilisateur de participer à une discussion sur le numérique et l'environnement en fonction du thème sélectionné" />
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
                    <a class="underline" href="./forum.php">Forum</a>
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
    <main class="forum">
        <form method="post" action="rechercherTheme.php" class="rechercherTheme">
            <label for="motCle">RECHERCHER :</label>
            <div class="recherche">
                <input type="text" id="motCle" name="motCle" placeholder="Tapez votre mot clé" class="loupe" />
                <input type="image" name="rechercherMessage" src="./images/loupe.png" class="chercher" alt="Chercher" />
            </div>
        </form>
        <div class="theme">
            <?php
            if ($nomTheme != null) {
                foreach ($nomTheme as $theme) {
            ?>
                <div class="unTheme">
                    <a href="./forumDetails.php?idTheme=<?php echo ($theme["idTheme"]); ?>">
                        <p class="titre">
                            <?php
                            echo $theme["titreTheme"]; ?>
                        </p>
                        <p class="description">
                            <?php
                            echo $theme["descriptionTheme"]; ?>
                        </p>
                        <p class="date">
                            <?php
                            echo ("Discussion ayant débutée le " . $theme["dateTheme"]) ?>
                        </p>
                    </a>

                    <?php if(isset($_SESSION['id']) && $_SESSION['estAdmin'] == 1){ ?>

                    <form method="post" action="supprimerTheme.php">
                        <input type="hidden" name="idTheme" value="<?php echo $theme["idTheme"] ?>" />
                        <input type="image" name="supprimerLeTheme" src="./images/corbeille.png" alt="Supprimer le theme" class="corbeille"/>
                    </form>

                    <?php } ?>
                </div>
                

                <?php
                }
            }?>
            </div>
            <?php
            if (isset($_SESSION['id']) and $_SESSION['id'] > 0 and $_SESSION['estAdmin'] == 1) {
                ?>
        
        <div class="trait"></div>
        <form method="post" action="ajouterTheme.php" class="admin">
            <div class="titreTheme">
                <label for="titreNewTheme">Titre du thème :</label>
                <input type="text" name="titreNewTheme" id="titreNewTheme" placeholder="Tapez un nouveau thème" />
            </div>
            <div class="descTheme">
                <label for="descNewTheme">Description du thème :</label>
                <textarea id="descNewTheme" name="descNewTheme" placeholder="Tapez la description du thème"></textarea>
                <input type="submit" name="ajouterTheme" value="Ajouter" class="ajouter" />
            </div>

        </form>
    <?php
            }
    ?>
    </main>
</body>

</html>