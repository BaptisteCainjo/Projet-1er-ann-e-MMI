<?php
    // connexion.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

	session_start();
	header("Content-Type: text/html; charset=utf-8") ;
	
	require (__DIR__ . "/param.inc.php");

    require (__DIR__ . "/src/Membres/Administrer.php");

    $administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS);

    $idTheme = $_GET["idTheme"];

    $infoTheme = $administrerMembres->obtenirInfoTheme($idTheme);

    if(isset($_GET["motCle"])) {
        $motCle=$_GET["motCle"];
    }
        else {
            $motCle=null;
        }

    $listeMessages = $administrerMembres->obtenirListeMessage($idTheme, $motCle);
    ?>

<html lang="fr">
	<head>
		<title>FORUM</title>
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
    <main>
        <h1 class="text-center text-3xl m-5"><?php
            echo $infoTheme["titreTheme"];
            
        ?></h1>

        <form method="post" action="rechercherMessage.php" class="my-5 mx-32">
            <input type="hidden" name="idTheme" value="<?php echo($idTheme)?>"/>
            <label for="motCle" class="block">Rechercher un message :</label>
            <input type="text" id="motCle" name="motCle" placeholder="Tapez votre mot clé ici..." class="rounded-lg border-solid border border-stone-100 p-1.5"/>
            <input type="submit" name="rechercherMessage" value="Chercher"/>
        </form>

        <?php
            if($listeMessages!=null){
            foreach($listeMessages as $message){
                
        ?>
        <div class="bg-white my-5 mx-32 p-4 rounded-md shadow-lg border-solid border border-stone-100">
                <p class="font-mono">
                    <?php
                    $usermessage = $administrerMembres->obtenirMembre($message["id"]) ;
                     echo $usermessage["pseudo"]; ?>
                </p>

               <p class="text-black"><?php
                            echo $message["contenu"];
                    ?></p>

                <p class="text-gray-400 text-xs"><?php echo $message["date"] ?></p>
                <?php
                  if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
                 if($_SESSION['id']==$usermessage['id']){
                ?>
                <form method="post" action="supprimerMessage.php">
                    <input type="hidden" name="idMessage" value="<?php echo $message["idMessage"] ?>"/>
                    <input type="hidden" name="idTheme" value="<?php echo($idTheme)?>"/>
                    <input type="submit" name="supprimerLeMessage" value="Supprimer"/>
                </form>
                <?php }} ?>
        </div>
        <?php
            }}else{
                
            }

            if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
        ?>

        <form method="post" action="redigerMessage.php">
            <input type="hidden" name="idTheme" value="<?php echo($idTheme)?>">
            <label for="contenu">Contenu du message</label>
            <textarea placeholder="Rédigez votre message ici..." id="contenu" name="contenu"></textarea>
            <input type="submit" name="posterMessage" value="Publier"/>
        </form>

        <?php 
            }else{
?>
<p>Si vous souhaitez participer à la discussion, vous devez tout d'abord vous connectez</p>
<a href="./connexion.php">en cliquant ici</a>
<?php
            }
        ?>
    </main>
    </body>

</html>