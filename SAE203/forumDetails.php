<?php
// connexion.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header("Content-Type: text/html; charset=utf-8");

require(__DIR__ . "/param.inc.php");

require(__DIR__ . "/src/Membres/Administrer.php");

$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS);

$idTheme = $_GET["idTheme"];

$infoTheme = $administrerMembres->obtenirInfoTheme($idTheme);


if (isset($_GET["motCle"])) {
    $motCle = $_GET["motCle"];
} else {
    $motCle = null;
}

if(isset($_POST["triPar"])){
    $trierPar = $_POST["triPar"];
}else{
    $trierPar = null;
}

$listeMessages = $administrerMembres->obtenirListeMessage($idTheme, $motCle, $trierPar);

$cacheMots = $administrerMembres->filtre();



?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <title>EcoStara | Discussion</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Page permettant au utilisateur d'envoyer un message, de partager d'échanger avec d'autres utilisateurs sur le thème de la sobriété numérique" />
    <link rel="shortcut icon" href="./images/logo_ecostaraoff.png" type="image/x-icon"/>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'/>
    <link rel="stylesheet" href="./css/style.css"/>
    <script src="scripts/menu.js"></script>
    <script src="scripts/forum.js"></script>

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
    <main class="forumDetails">
        <div class="popup">
            <div class="text">
                <div class="fermer">X</div>
                <h1><?php
                    echo $infoTheme["titreTheme"];
                    ?></h1>
                <p><?php
                    echo $infoTheme["descriptionTheme"];
                    ?></p>
            </div>
        </div>
        <div class="question">
            <h1><?php
                echo $infoTheme["titreTheme"];
                ?></h1>
            <p class="cercle">?</p>
        </div>
        <form method="post" action="rechercherMessage.php" class="rechercherTheme">
            <input type="hidden" name="idTheme" value="<?php echo ($idTheme) ?>" />
            <label for="motCle">RECHERCHER :</label>
            <div class="recherche">
                <input type="text" id="motCle" name="motCle" placeholder="Tapez votre mot clé ici..." class="loupe" />
                <input type="image" name="rechercherMessage" src="./images/loupe.png" class="chercher" alt="Chercher"/>
            </div>
        </form>

        <form method="post" action="forumDetails.php?idTheme=<?php echo ($idTheme) ?>" class="triMessage">
            <label for="triPar" class="labelTri">TRIER PAR :</label>
            <select id="triPar" name="triPar">
                <option value="parDate" <?php if($trierPar!="parLike"){ echo("selected"); }?>>Date</option>
                <option value="parLike" <?php if($trierPar=="parLike"){ echo("selected");} ?>>Like</option>
            </select>
            <input type="submit" name="triDesMessages" value="Trier"/>
        </form>
        <?php if (isset($_SESSION['id'])==false){?>
            <div class="participe">
                <p>Connectez-vous pour participer à la discussion </p>
                <p><a href="./connexion.php"> en cliquant ici !</a></p>
            </div>
        <?php } 

        if ($listeMessages != null) {
            foreach ($listeMessages as $message) {

        ?>
                <div class="message">
                    <div class="avatar">
                        <div class="avatarPseudo">
                            <form method="post" action="profil.php">
                                    <input type="hidden" name="id" value="<?php $userMessage = $administrerMembres->obtenirMembre($message["id"]); 
                                    echo ($userMessage['id']); ?>" />
                                    <input class="avatarUser" type="image" name="afficherLeProfil" src="./images/membres/avatars/<?php
                                                                echo $userMessage["avatar"];
                                                                ?>" alt="Afficher le profil de l'utilisateur"/>
                            </form>
                            <p class="pseudo">
                                <?php
                                echo $userMessage["pseudo"]; ?>
                            </p>
                        </div>
                        <?php
                        if (isset($_SESSION['id']) and $_SESSION['id'] > 0) {
                            if ($_SESSION['id'] == $userMessage['id'] || $_SESSION['estAdmin'] == 1) {
                        ?>

                                <form method="post" action="supprimerMessage.php">
                                    <input type="hidden" name="idMessage" value="<?php echo $message["idMessage"] ?>" />
                                    <input type="hidden" name="idTheme" value="<?php echo ($idTheme) ?>" />
                                    <input type="image" name="supprimerLeMessage" src="./images/corbeille.png" alt="Supprimer le message" class="corbeille"/>
                                </form>
                    </div>
                <?php } else { ?>
                </div>
            <?php
                            }
                        }else { ?>
            </div>
        <?php } ?>
        <p class="contenu">
            <?php
                $reponse = $message["contenu"];
                echo $reponse;
            ?>
        </p>






        <div class="ligneInfo">
            <div class="like">
                <p class="nbrLike"><?php echo ($administrerMembres->compterAime($message["idMessage"])) ?></p>
                <form method="post" action="aimerMessage.php">
                    <input type="hidden" name="idMessage" value="<?php echo $message["idMessage"] ?>" />
                    <input type="hidden" name="idTheme" value="<?php echo ($idTheme) ?>" />
                    <input type="image" name="aimerLeMessage" class="like" src="
                    <?php
                    if (isset($_SESSION['id']) and $_SESSION['id'] > 0) {
                        $dejaLike = $administrerMembres->dejaLike($message["idMessage"], $_SESSION["id"]);
                        if ($dejaLike == true) {
                            echo ("./images/LikeVert.png");
                        } else {
                            echo ("./images/Like.png");
                        }
                    } else {
                        echo ("./images/Like.png");
                    }
                    ?>
                    " alt="Liker le message" />
                </form>
            </div>
            <p class="dateMessage"><?php echo $message["date"] ?></p>
        </div>
        </div>

    <?php
            }
        } else {
    ?>
    <p class="pasDeMessages">Soyez le premier à poster un message sur ce sujet !</p>
<?php
        }

        if (isset($_SESSION['id']) and $_SESSION['id'] > 0) {
?>

    <form method="post" action="redigerMessage.php" class="publierMessage">
        <input type="hidden" name="idTheme" value="<?php echo ($idTheme) ?>">
        <label for="contenu">Contenu du message</label>
        <textarea placeholder="Rédigez votre message ici..." id="contenu" name="contenu" maxlength="1000"></textarea>
        <div>
            <input type="submit" name="posterMessage" value="Publier" class="publier" />
        </div>
    </form>
    <div class="rondMessage open"><img src="./images/message.png" alt="Envoyer un message"></div>

<?php
        }
?>

    </main>
</body>

</html>