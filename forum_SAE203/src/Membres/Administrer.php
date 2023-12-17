<?php
namespace Membres;

use PDO;
use SplFileObject;
use Exception;

/**
 * Administrer
 */
class Administrer
{

    private $myHost;

    private $myDb;

    private $myUser;

    private $myPass;
	
    private $debug;

    /**
     * Administrer
     *
     * @param string $myHost
     * @param string $myDb
     * @param string $myUser
     * @param string $myPass
     *
     * @return Administrer
     */
    function __construct($myHost = null, $myDb = null, $myUser = null, $myPass = null)
    {
        $this->myHost = $myHost;
        $this->myDb = $myDb;
        $this->myUser = $myUser;
        $this->myPass = $myPass;
		
		$this->debug = true ;
    }

    /**
     * Installer la base de données
     *
     * @return Administrer
     */
    public function installerBaseDeDonnees()
    {
		try{
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost, $this->myUser, $this->myPass);
			$pdo->query("CREATE DATABASE IF NOT EXISTS " . $this->myDb . " DEFAULT CHARACTER SET utf8 COLLATE utf8_bin");
			$pdo = null;
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$requetesSQL = <<<EOF
			DROP TABLE IF EXISTS membreForum ;
			CREATE TABLE membreForum (
			id INT NOT NULL AUTO_INCREMENT,
			pseudo VARCHAR(255),
			age INT,
			mail VARCHAR(255),
			motdepasse TEXT,
			valide BOOLEAN,
			avatar VARCHAR(255),
			
				PRIMARY KEY(id) ) ;
EOF;
			$pdo->query($requetesSQL);
			
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;  
		}
		catch(Exception $e) {
			if ($this->debug) {
				echo($e->getMessage()) ;
			}
		}
		
        return $this;
    }

    /**
     * Inscrire un nouveau membre
     *
     * @param string $pseudo
     * @param string $mail
     * @param string $mdp
     *            
     * @exception string
     */
    public function inscrire($pseudo, $mail, $mdp)
    {
        $erreur = "" ;
		if(!empty($pseudo) 
			AND !empty($mail) 
			AND !empty($mdp)) {
			$pseudo = htmlspecialchars($pseudo);
			$mail = htmlspecialchars($mail);
			$mdp = sha1($mdp);
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");

			$pseudolength = mb_strlen($pseudo);
			if($pseudolength >= 4) {
			if($pseudolength <= 255) {
				if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
					$reqmail = $pdo->prepare("SELECT * FROM membreForum WHERE mail = ?");
					$reqmail->execute(array($mail));
					$ligne = $reqmail->fetch(PDO::FETCH_ASSOC) ;
					if($ligne == false) {
						$reqpseudo = $pdo->prepare("SELECT * FROM membreForum WHERE pseudo = ?");
						$reqpseudo->execute(array($pseudo));
						$ligne = $reqpseudo->fetch(PDO::FETCH_ASSOC);
						if($ligne == false){
						// Etape 2 : envoi de la requête SQL au serveur
						$avatar = "./images/avatar_base.jpg";
						$insertmbr = $pdo->prepare("INSERT INTO membreForum(pseudo, mail, motdepasse, valide, avatar) VALUES(?, ?, ?, ?, ?)");
						$insertmbr->execute(array($pseudo, $mail, $mdp, false, $avatar));
						$id = $pdo->lastInsertId() ;
						if(isset($_SERVER["HTTP_REFERER"])){
							$url = $_SERVER["HTTP_REFERER"];  //https://la-perso.univ-lemans.fr/~mmi1_i2101718/test_sae203/inscription.php
							$url = dirname($url); //https://la-perso.univ-lemans.fr/~mmi1_i2101718/test_sae203
							$this->envoyerMail($mail, "Valider l'inscription", $url."/validationParMail.php?id=".$id);
						}
					}else{
						$erreur = "Pseudo déjà utilisé";
					}
					} else {
						$erreur = "Adresse mail déjà utilisée !";
					}
				} else {
					$erreur = "Votre adresse mail n'est pas valide !";
				}
			} else {
				$erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null ;
		} else {
			$erreur = "Tous les champs doivent être complétés !";
		}
	}else{
		$erreur = "Votre pseudo doit posséder au moins 4 caractères !";
	}
		if ($erreur != "") {
			throw new Exception($erreur);
		}
	}  

    /**
     * Connecter un nouveau membre
     *
     * @param string $mailconnect
     * @param string $mdpconnect
     *            
     * @exception string
     * @return array $user (tableau associatif) ou null
     */
    public function connecter($mailconnect, $mdpconnect)
    {
        $erreur = "" ;
		$user = null; 
		if(!empty($mailconnect) 
			AND !empty($mdpconnect)) {
			$mailconnect = htmlspecialchars($mailconnect);
			$mdpconnect = sha1($mdpconnect);
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			// Etape 2 : envoi de la requête SQL au serveur
			$requser = $pdo->prepare("SELECT * FROM membreForum WHERE mail = ? AND motdepasse = ?");
			$requser->execute(array($mailconnect,$mdpconnect));
			$user = $requser->fetch(PDO::FETCH_ASSOC) ;
			if($user == false) {
				$erreur = "Mauvais mail ou mot de passe !";
				$user = null; 
			}else {
				if($user["valide"] == false) {
					$erreur = "En attente de validation par mail !";
					$user = null;
				}
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null ;
		} else {
			$erreur = "Tous les champs doivent être complétés !";
		}

		if ($erreur != "") {
			throw new Exception($erreur);
		}
		
		return $user ;
	}
	
   /**
     * Obtenir un membre
     *
     * @param int $id (identifiant du membre)
     *
     * @return array $user (tableau associatif) ou null
     */
    public function obtenirMembre($id = null)
    {
		$user = null ;
		if ($id != null) {
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			// Etape 2 : envoi de la requête SQL au serveur
			$requser = $pdo->prepare("SELECT * FROM membreForum WHERE id = ?");
			$requser->execute(array($id));
			// Etape 3 : récupère les données
			$user = $requser->fetch(PDO::FETCH_ASSOC);
			if($user == false) {
				$user = null; 
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null ;
		}
		return $user ; 
	}
	
    /**
     * Mettre à jour l'un des membres
     *
     * @param int $id (identifiant du membre)
     * @param string $newpseudo
     * @param string $newmail
     * @param string $newmdp
     * @param int $newage
     *
     * @exception string
     * @return array $user (tableau associatif) ou null
     */
    public function mettreAJour($id = null, $newpseudo, $newmail, $newmdp, $newage)
    {
        $erreur = "Aucune modification !";
		if($id != null) {
			$user = $this->obtenirMembre($id) ;
			$erreur = "" ;
			
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			
			if(isset($newpseudo) AND !empty($newpseudo) AND $newpseudo != $user['pseudo']) {
				$newpseudo = htmlspecialchars($newpseudo);
				$pseudolength = mb_strlen($newpseudo);
				if($pseudolength <= 255) {
					$insertpseudo = $pdo->prepare("UPDATE membreForum SET pseudo = ? WHERE id = ?");
					$insertpseudo->execute(array($newpseudo, $id));
				} else {
					$erreur = $erreur . "Votre pseudo ne doit pas dépasser 255 caractères !</br>";
				}
			}
			if(isset($newmail) AND !empty($newmail) AND $newmail != $user['mail']) {
				$newmail = htmlspecialchars($newmail);
				if(filter_var($newmail, FILTER_VALIDATE_EMAIL)) {
					$insertmail = $pdo->prepare("UPDATE membreForum SET mail = ? WHERE id = ?");
					$insertmail->execute(array($newmail, $id));
				} else {
					$erreur = $erreur . "Votre adresse mail n'est pas valide !</br>";
				}
			}
			if(isset($newmdp) AND !empty($newmdp)) {
				if(mb_strlen($newmdp) >= 4)
				$newmdp = sha1($newmdp);
				$insertmdp = $pdo->prepare("UPDATE membreForum SET motdepasse = ? WHERE id = ?");
				$insertmdp->execute(array($newmdp, $id));
			}else{
				$erreur = $erreur . "Votre mot de passe doit posséder au moins 4 caractères !";
			}

			if(isset($newage) AND !empty($newage)) {
				if($newage >=0) {
				$insertmdp = $pdo->prepare("UPDATE membreForum SET age = ? WHERE id = ?");
				$insertmdp->execute(array($newage, $id));
				}else{
					$erreur = $erreur . "Votre age doit être supérieur à 0";
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null ;
		}
		if ($erreur != "") {
			throw new Exception($erreur);
		}
		
		return $this->obtenirMembre($id) ; // Utilisateur avec les données mises à jour
	}
}

public function envoyerMail($destinataire, $sujet, $message){
	$mail = new \PHPMailer\PHPMailer\PHPMailer();
// Configuration du serveur SMTP
$mail->SMTPDebug = 0; // Active/désactive les messages de mise au point
$mail->isSMTP(); // Utilise le protocole SMTP
$mail->Host = "smtp-relay.sendinblue.com"; // Configure le nom du serveur serveur SMTP
$mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS; // Active le cryptage sécurisé TLS
$mail->Port = 587; // Configure le numéro de port
$mail->SMTPAuth = true; // Active le mode authentification
$mail->Username = "Telio.garnier.etu@univ-lemans.fr"; // Identifiant du compte SMTP
$mail->Password = "HvA0TtWUXcZswh7P"; // Mot de passe du compte SMTP
// Destinataires
$mail->setFrom("telio.garnier.etu@univ-lemans.fr");
$mail->addAddress($destinataire); // Ajout du destinataire
// Contenu du mail
$mail->isHTML(true);
$mail->Subject = $sujet;
$mail->Body = $message;
$mail->CharSet = \PHPMailer\PHPMailer\PHPMailer::CHARSET_UTF8 ;
if($mail->send() != false) {
	echo("Le message électronique a été transmis.");
	return true;
}
else {
	echo("Le message électronique n'a pas été transmis.");
	return false;
}
	}

	/**
     * Valider l'utilisateur
     *
     * @param int $id identifiant de l'utilisateur. 
     *            
     * @return Administrer
     */
    public function validerMembre($id = null) {
		if ($id != null) {
			if (is_numeric($id)) {
				// Etape 1 : connexion au serveur de base de données
				$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
				$pdo->query("SET NAMES utf8");
				$pdo->query("SET CHARACTER SET 'utf8'");
				// Etape 2 : envoi de la requête SQL au serveur
				$validupdate = $pdo->prepare("UPDATE membreForum SET valide = ? WHERE id = ?");
				$validupdate->execute(array(true, $id));
				
				// Etape 4 : ferme la connexion au serveur de base de données
				$pdo = null ;
			}
		}
		return $this ;
	}

	public function obtenirTheme($motCle)
    {
		$nomTheme = null ;
		
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			// Etape 2 : envoi de la requête SQL au serveur
			if($motCle==null){
			$requser = $pdo->query("SELECT titreTheme, idTheme FROM theme");
			// Etape 3 : récupère les données
			$nomTheme = $requser->fetchAll(PDO::FETCH_ASSOC);
			if($nomTheme == false) {
				$nomTheme = null;
			}
			}else{
				$requser = $pdo->prepare("SELECT titreTheme, idTheme FROM theme WHERE titreTheme LIKE ?");
				$requser->execute(array("%".$motCle."%"));
				$nomTheme = $requser->fetchAll(PDO::FETCH_ASSOC);
				if($nomTheme == false) {
					$nomTheme = null;
				}
		}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null ;
		
		return $nomTheme ; 
	}

	public function obtenirInfoTheme($idTheme)
    {
		$infoTheme = null ;
		
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			// Etape 2 : envoi de la requête SQL au serveur
			$requser = $pdo->prepare("SELECT * FROM theme WHERE idTheme = ?");
			$requser->execute(array($idTheme));
			// Etape 3 : récupère les données
			$infoTheme = $requser->fetch(PDO::FETCH_ASSOC);
			if($infoTheme == false) {
				$infoTheme = null;
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null ;
		
		return $infoTheme; 
	}

	public function obtenirListeMessage($idTheme, $motCle)
    {
		$infoMessage = null ;
		
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			// Etape 2 : envoi de la requête SQL au serveur
			if($motCle==null){
			$requser = $pdo->prepare("SELECT * FROM message WHERE idTheme=? AND affiche=1");
			$requser->execute(array($idTheme));
			// Etape 3 : récupère les données
			$infoMessage = $requser->fetchAll(PDO::FETCH_ASSOC);
			if($infoMessage == false) {
				$infoMessage = null;
			}}else{
				$requser = $pdo->prepare("SELECT * FROM message WHERE idTheme=? AND affiche=1 AND contenu LIKE ?");
				$requser->execute(array($idTheme, "%".$motCle."%"));
				$infoMessage = $requser->fetchAll(PDO::FETCH_ASSOC);
				if($infoMessage == false) {
					$infoMessage = null;
				}
		}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null ;
		
		return $infoMessage ; 
	}

	public function publierMessage($id, $contenu, $idTheme){
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		// Etape 2 : envoi de la requête SQL au serveur
		$requser = $pdo->prepare("INSERT INTO message(contenu, date, id, idTheme, affiche) VALUES (?, NOW(), ?, ?, ?)");
		$requser->execute(array($contenu, $id, $idTheme, 1));
		// Etape 4 : ferme la connexion au serveur de base de données
		
		$infoMessage = $requser->fetchAll(PDO::FETCH_ASSOC);
		$pdo = null ;
		return $infoMessage ;
	}

	public function supprimerMessage($idMessage){
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		// Etape 2 : envoi de la requête SQL au serveur
		$requser = $pdo->prepare("UPDATE message SET affiche=? WHERE idMessage=$idMessage");
		$requser->execute(array(0));
		// Etape 4 : ferme la connexion au serveur de base de données
		
		$infoMessage = $requser->fetchAll(PDO::FETCH_ASSOC);
		$pdo = null ;
		return $infoMessage ;
	}

}
