<?php
    // connexion.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

	session_start();
	header("Content-Type: text/html; charset=utf-8") ;
	
	require (__DIR__ . "/param.inc.php");

    require (__DIR__ . "/src/Membres/Administrer.php");

    $administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS);
    if(isset($_GET["motCle"])) {
    $motCle=$_GET["motCle"];
}
    else {
        $motCle=null;
    }

    $nomTheme = $administrerMembres->obtenirTheme($motCle);
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
        <form method="post" action="rechercherTheme.php" class="my-5 m-4">
            <label for="motCle" class="block">Rechercher un thème</label>
            <input type="text" name="motCle" placeholder="Tapez votre mot clé ici..." class="rounded-lg border-solid border border-stone-100 p-1.5"/>
            <input type="submit" name="rechercherTheme" value="Chercher"/>
        </form>

        </form>
        <?php
        if($nomTheme!=null){
            foreach($nomTheme as $theme){
        ?>
        <a href="./forumDetails.php?idTheme=<?php echo($theme["idTheme"]); ?>" class="m-4 p-2 bg-white block">
                    <?php
                            echo $theme["titreTheme"];
                    ?>
        </a>
        <?php
            }}
        ?>
    </main>
    </body>

</html>