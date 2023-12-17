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
		$this->debug = true;
	}

	/**
	 * Installer la base de données
	 *
	 * @return Administrer
	 */
	public function installerBaseDeDonnees()
	{
		try {
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost, $this->myUser, $this->myPass);
			$pdo->query("CREATE DATABASE IF NOT EXISTS " . $this->myDb . " DEFAULT CHARACTER SET utf8 COLLATE utf8_bin");
			$pdo = null;
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$requetesSQL = <<<EOF
			DROP TABLE IF EXISTS membreForum, aime, theme, message, filtre;
			
			CREATE TABLE `aime` (
				`idAime` int(11) NOT NULL,
				`id` int(11) NOT NULL,
				`idMessage` int(11) NOT NULL
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			  
			  
			  --
			  -- Structure de la table `filtre`
			  --
			  
			  CREATE TABLE `filtre` (
				`mot` varchar(41) DEFAULT NULL,
				`resultatMot` varchar(41) DEFAULT NULL,
				`idmot` int(11) NOT NULL
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			  
			  --
			  -- Déchargement des données de la table `filtre`
			  --
			  
			  INSERT INTO `filtre` (`mot`, `resultatMot`, `idmot`) VALUES
			  ('abruti', '*br*t*', 1),
			  ('aller chier dans sa caisse', '*ll*r ch**r d*ns s* c**ss*', 2),
			  ('aller niquer sa mère', '*ll*r n*q**r s* m*r*', 3),
			  ('aller se faire enculer', '*ll*r s* f**r* *nc*l*r', 4),
			  ('aller se faire endauffer', '*ll*r s* f**r* *nd**ff*r', 5),
			  ('aller se faire foutre', '*ll*r s* f**r* f**tr*', 6),
			  ('aller se faire mettre', '*ll*r s* f**r* m*ttr*', 7),
			  ('andouille', '*nd***ll*', 8),
			  ('anglo-fou', '*ngl*-f**', 9),
			  ('appareilleuse', '*pp*r**ll**s*', 10),
			  ('assimilé', '*ss*m*l*', 11),
			  ('assimilée', '*ss*m*l**', 12),
			  ('astèque', '*st*q**', 13),
			  ('avorton', '*v*rt*n', 14),
			  ('bachi-bouzouk', 'b*ch*-b**z**k', 15),
			  ('baleine', 'b*l**n*', 16),
			  ('bande d\'abrutis', 'b*nd* d\'*br*t*s', 17),
			  ('baraki', 'b*r*k*', 18),
			  ('bâtard', 'b*t*rd', 19),
			  ('baudet', 'b**d*t', 20),
			  ('beauf', 'b***f', 21),
			  ('bellicole', 'b*ll*c*l*', 22),
			  ('bête', 'b*t*', 23),
			  ('bête à pleurer', 'b*t* * pl**r*r', 24),
			  ('bête comme ses pieds', 'b*t* c*mm* s*s p**ds', 25),
			  ('bête comme un chou', 'b*t* c*mm* *n ch**', 26),
			  ('bête comme un cochon', 'b*t* c*mm* *n c*ch*n', 27),
			  ('bête comme un cygne', 'b*t* c*mm* *n c*gn*', 28),
			  ('bête comme une oie', 'b*t* c*mm* *n* ***', 29),
			  ('biatch', 'b**tch', 30),
			  ('bibi', 'b*b*', 31),
			  ('bic', 'b*c', 32),
			  ('bicot', 'b*c*t', 33),
			  ('bicotte', 'b*c*tt*', 34),
			  ('bique', 'b*q**', 35),
			  ('bite', 'b*t*', 36),
			  ('bitembois', 'b*t*mb**s', 37),
			  ('bitembois', 'b*t*mb**s', 38),
			  ('bolos', 'b*l*s', 39),
			  ('bordille', 'b*rd*ll*', 40),
			  ('boucaque', 'b**c*q**', 41),
			  ('boudin', 'b**d*n', 42),
			  ('bouffi', 'b**ff*', 43),
			  ('bouffon', 'b**ff*n', 44),
			  ('bouffonne', 'b**ff*nn*', 45),
			  ('bougnoul', 'b**gn**l', 46),
			  ('bougnoule', 'b**gn**l*', 47),
			  ('bougnoulie', 'b**gn**l**', 48),
			  ('bougnoulisation', 'b**gn**l*s*t**n', 49),
			  ('bougnouliser', 'b**gn**l*s*r', 50),
			  ('bougre', 'b**gr*', 51),
			  ('boukak', 'b**k*k', 52),
			  ('boulet', 'b**l*t', 53),
			  ('bounioul', 'b**n***l', 54),
			  ('bounioule', 'b**n***l*', 55),
			  ('bourdille', 'b**rd*ll*', 56),
			  ('bourrer', 'b**rr*r', 57),
			  ('bourricot', 'b**rr*c*t', 58),
			  ('bovo', 'b*v*', 59),
			  ('branleur', 'br*nl**r', 60),
			  ('bridé', 'br*d*', 61),
			  ('bridée', 'br*d**', 62),
			  ('brigand', 'br*g*nd', 63),
			  ('brise-burnes', 'br*s*-b*rn*s', 64),
			  ('bulot', 'b*l*t', 65),
			  ('cacou', 'c*c**', 66),
			  ('cafre', 'c*fr*', 67),
			  ('cageot', 'c*g**t', 68),
			  ('caldoche', 'c*ld*ch*', 69),
			  ('carcavel', 'c*rc*v*l', 70),
			  ('casse-bonbon', 'c*ss*-b*nb*n', 71),
			  ('casse-couille', 'c*ss*-c***ll*', 72),
			  ('casse-couilles', 'c*ss*-c***ll*s', 73),
			  ('cave', 'c*v*', 74),
			  ('chagasse', 'ch*g*ss*', 75),
			  ('chaoui', 'ch****', 76),
			  ('charlot de vogue', 'ch*rl*t d* v*g**', 77),
			  ('charogne', 'ch*r*gn*', 78),
			  ('chauffard', 'ch**ff*rd', 79),
			  ('chbeb', 'chb*b', 80),
			  ('cheveux bleus', 'ch*v**x bl**s', 81),
			  ('chiabrena', 'ch**br*n*', 82),
			  ('chien de chrétien', 'ch**n d* chr*t**n', 83),
			  ('chiennasse', 'ch**nn*ss*', 84),
			  ('chienne', 'ch**nn*', 85),
			  ('chier', 'ch**r', 86),
			  ('chieur', 'ch***r', 87),
			  ('chieuse', 'ch***s*', 88),
			  ('chinetoc', 'ch*n*t*c', 89),
			  ('chinetoque', 'ch*n*t*q**', 90),
			  ('chinetoque', 'ch*n*t*q**', 91),
			  ('chintok', 'ch*nt*k', 92),
			  ('chleuh', 'chl**h', 93),
			  ('chnoque', 'chn*q**', 94),
			  ('choucroutard', 'ch**cr**t*rd', 95),
			  ('citrouille', 'c*tr***ll*', 96),
			  ('coche', 'c*ch*', 97),
			  ('colon', 'c*l*n', 98),
			  ('complotiste', 'c*mpl*t*st*', 99),
			  ('con comme la lune', 'c*n c*mm* l* l*n*', 101),
			  ('con comme ses pieds', 'c*n c*mm* s*s p**ds', 102),
			  ('con comme un balai', 'c*n c*mm* *n b*l**', 103),
			  ('con comme un manche', 'c*n c*mm* *n m*nch*', 104),
			  ('con comme une chaise', 'c*n c*mm* *n* ch**s*', 105),
			  ('con comme une valise', 'c*n c*mm* *n* v*l*s*', 106),
			  ('con comme une valise à poignée intérieure', 'c*n c*mm* *n* v*l*s* * p**gn** *nt*r***r*', 107),
			  ('con comme une valise sans poignée', 'c*n c*mm* *n* v*l*s* s*ns p**gn**', 108),
			  ('conasse', 'c*n*ss*', 109),
			  ('conchier', 'c*nch**r', 110),
			  ('conchita', 'c*nch*t*', 111),
			  ('connard', 'c*nn*rd', 112),
			  ('connarde', 'c*nn*rd*', 113),
			  ('connasse', 'c*nn*ss*', 114),
			  ('conspirationniste', 'c*nsp*r*t**nn*st*', 115),
			  ('contracibête', 'c*ntr*c*b*t*', 116),
			  ('couille molle', 'c***ll* m*ll*', 117),
			  ('counifle', 'c**n*fl*', 118),
			  ('courtaud', 'c**rt**d', 119),
			  ('courtaude', 'c**rt**d*', 120),
			  ('cpf', 'c**', 121),
			  ('crétin', 'cr*t*n', 122),
			  ('crevure', 'cr*v*r*', 123),
			  ('cricri', 'cr*cr*', 124),
			  ('crotté', 'cr*tt*', 125),
			  ('crouïa', 'cr****', 126),
			  ('crouillat', 'cr***ll*t', 127),
			  ('crouille', 'cr***ll*', 128),
			  ('croûton', 'cr*ût*n', 129),
			  ('dago', 'd*g*', 130),
			  ('débile', 'd*b*l*', 131),
			  ('débougnouliser', 'd*b**gn**l*s*r', 132),
			  ('doryphore', 'd*r*ph*r*', 133),
			  ('doxosophe', 'd*x*s*ph*', 134),
			  ('doxosophie', 'd*x*s*ph**', 135),
			  ('drouille', 'dr***ll*', 136),
			  ('du schnoc', 'd* schn*c', 137),
			  ('ducon', 'd*c*n', 138),
			  ('duconnot', 'd*c*nn*t', 139),
			  ('dugenoux', 'd*g*n**x', 140),
			  ('dugland', 'd*gl*nd', 141),
			  ('duschnock', 'd*schn*ck', 142),
			  ('emmanché', '*mm*nch*', 143),
			  ('emmerder', '*mm*rd*r', 144),
			  ('emmerdeur', '*mm*rd**r', 145),
			  ('emmerdeuse', '*mm*rd**s*', 146),
			  ('empafé', '*mp*f*', 147),
			  ('empaffé', '*mp*ff*', 148),
			  ('empapaouté', '*mp*p***t*', 149),
			  ('enculé', '*nc*l*', 150),
			  ('enculé de ta race', '*nc*l* d* t* r*c*', 151),
			  ('enculer', '*nc*l*r', 152),
			  ('enfant de fusil', '*nf*nt d* f*s*l', 153),
			  ('enfant de garce', '*nf*nt d* g*rc*', 154),
			  ('enfant de putain', '*nf*nt d* p*t**n', 155),
			  ('enfant de pute', '*nf*nt d* p*t*', 156),
			  ('enfant de salaud', '*nf*nt d* s*l**d', 157),
			  ('enflure', '*nfl*r*', 158),
			  ('enfoiré', '*nf**r*', 159),
			  ('envaselineur', '*nv*s*l*n**r', 160),
			  ('envoyer faire foutre', '*nv***r f**r* f**tr*', 161),
			  ('épais', '*p**s', 162),
			  ('espèce de', '*sp*c* d*', 163),
			  ('espingoin', '*sp*ng**n', 164),
			  ('espingouin', '*sp*ng***n', 165),
			  ('étron', '*tr*n', 166),
			  ('face de chien', 'f*c* d* ch**n', 167),
			  ('face de craie', 'f*c* d* cr***', 168),
			  ('face de pet', 'f*c* d* p*t', 169),
			  ('face de rat', 'f*c* d* r*t', 170),
			  ('fachiste', 'f*ch*st*', 171),
			  ('fdp', 'f**', 172),
			  ('fell', 'f*ll', 173),
			  ('fermer sa gueule', 'f*rm*r s* g***l*', 174),
			  ('fils de bâtard', 'f*ls d* b*t*rd', 175),
			  ('fils de chien', 'f*ls d* ch**n', 176),
			  ('fils de chienne', 'f*ls d* ch**nn*', 177),
			  ('fils de garce', 'f*ls d* g*rc*', 178),
			  ('fils de pute', 'f*ls d* p*t*', 179),
			  ('fils de ta race', 'f*ls d* t* r*c*', 180),
			  ('fiotte', 'f**tt*', 181),
			  ('floco', 'fl*c*', 182),
			  ('folle', 'f*ll*', 183),
			  ('fouteur', 'f**t**r', 184),
			  ('foutriquet', 'f**tr*q**t', 185),
			  ('franco-frog', 'fr*nc*-fr*g', 186),
			  ('fripouille', 'fr*p***ll*', 187),
			  ('frisé', 'fr*s*', 188),
			  ('fritz', 'fr*tz', 189),
			  ('fritz', 'fr*tz', 190),
			  ('fumelard', 'f*m*l*rd', 191),
			  ('fumier', 'f*m**r', 192),
			  ('garage à bite', 'g*r*g* * b*t*', 193),
			  ('garage à bites', 'g*r*g* * b*t*s', 194),
			  ('garce', 'g*rc*', 195),
			  ('gaupe', 'g**p*', 196),
			  ('gdm', 'g**', 197),
			  ('gestapette', 'g*st*p*tt*', 198),
			  ('gestapette', 'g*st*p*tt*', 199),
			  ('gland', 'gl*nd', 200),
			  ('glandeur', 'gl*nd**r', 201),
			  ('glandeuse', 'gl*nd**s*', 202),
			  ('glandouillou', 'gl*nd***ll**', 203),
			  ('glandu', 'gl*nd*', 204),
			  ('glandue', 'gl*nd**', 205),
			  ('gnoul', 'gn**l', 206),
			  ('gnoule', 'gn**l*', 207),
			  ('godon', 'g*d*n', 208),
			  ('gogol', 'g*g*l', 209),
			  ('gogole', 'g*g*l*', 210),
			  ('gogolito', 'g*g*l*t*', 211),
			  ('goï', 'g**', 212),
			  ('gook', 'g**k', 213),
			  ('gouilland', 'g***ll*nd', 214),
			  ('gouine', 'g***n*', 215),
			  ('goulou-goulou', 'g**l**-g**l**', 216),
			  ('gourdasse', 'g**rd*ss*', 217),
			  ('gourde', 'g**rd*', 218),
			  ('gourgandine', 'g**rg*nd*n*', 219),
			  ('grognasse', 'gr*gn*ss*', 220),
			  ('gueniche', 'g**n*ch*', 221),
			  ('guide de merde', 'g**d* d* m*rd*', 222),
			  ('guindoule', 'g**nd**l*', 223),
			  ('gwer', 'gw*r', 224),
			  ('habitant', 'h*b*t*nt', 225),
			  ('halouf', 'h*l**f', 226),
			  ('hippopotame', 'h*pp*p*t*m*', 227),
			  ('imbécile', '*mb*c*l*', 228),
			  ('incapable', '*nc*p*bl*', 229),
			  ('islamo-gauchisme', '*sl*m*-g**ch*sm*', 230),
			  ('islamo-gauchiste', '*sl*m*-g**ch*st*', 231),
			  ('islamogauchiste', '*sl*m*g**ch*st*', 232),
			  ('jean-foutre', 'j**n-f**tr*', 233),
			  ('jean-fesse', 'j**n-f*ss*', 234),
			  ('jeannette', 'j**nn*tt*', 235),
			  ('journalope', 'j**rn*l*p*', 236),
			  ('judéo-bolchévisme', 'j*d**-b*lch*v*sm*', 237),
			  ('juivaillon', 'j**v**ll*n', 238),
			  ('kahlouche', 'k*hl**ch*', 239),
			  ('karlouche', 'k*rl**ch*', 240),
			  ('kawish', 'k*w*sh', 241),
			  ('khel', 'kh*l', 242),
			  ('khmer rose', 'khm*r r*s*', 243),
			  ('khmer rouge', 'khm*r r**g*', 244),
			  ('khmer vert', 'khm*r v*rt', 245),
			  ('kikoo', 'k*k**', 246),
			  ('kikou', 'k*k**', 247),
			  ('koreaboo', 'k*r**b**', 248),
			  ('kraut', 'kr**t', 249),
			  ('la fermer', 'l* f*rm*r', 250),
			  ('lâche', 'l*ch*', 251),
			  ('lâcheux', 'l*ch**x', 252),
			  ('lavette', 'l*v*tt*', 253),
			  ('loche', 'l*ch*', 254),
			  ('lopette', 'l*p*tt*', 255),
			  ('lorpidon', 'l*rp*d*n', 256),
			  ('macaroni', 'm*c*r*n*', 257),
			  ('magot', 'm*g*t', 258),
			  ('makoumé', 'm*k**m*', 259),
			  ('mal blanchi', 'm*l bl*nch*', 260),
			  ('mange-merde', 'm*ng*-m*rd*', 261),
			  ('manger du nègre', 'm*ng*r d* n*gr*', 262),
			  ('manger ses morts', 'm*ng*r s*s m*rts', 263),
			  ('mangeux de marde', 'm*ng**x d* m*rd*', 264),
			  ('marchandot', 'm*rch*nd*t', 265),
			  ('margouilliste', 'm*rg***ll*st*', 266),
			  ('marlouf', 'm*rl**f', 267),
			  ('marsouin', 'm*rs***n', 268),
			  ('mauviette', 'm**v**tt*', 269),
			  ('maya', 'm***', 270),
			  ('melon', 'm*l*n', 271),
			  ('mercon', 'm*rc*n', 272),
			  ('merdaille', 'm*rd**ll*', 273),
			  ('merdaillon', 'm*rd**ll*n', 274),
			  ('merde', 'm*rd*', 275),
			  ('merdeux', 'm*rd**x', 276),
			  ('merdouillard', 'm*rd***ll*rd', 277),
			  ('michto', 'm*cht*', 278),
			  ('minable', 'm*n*bl*', 279),
			  ('minus', 'm*n*s', 280),
			  ('misérable', 'm*s*r*bl*', 281),
			  ('moinaille', 'm**n**ll*', 282),
			  ('moins-que-rien', 'm**ns-q**-r**n', 283),
			  ('mollusque', 'm*ll*sq**', 284),
			  ('monacaille', 'm*n*c**ll*', 285),
			  ('mongol', 'm*ng*l', 286),
			  ('mongol à batteries', 'm*ng*l * b*tt*r**s', 287),
			  ('moricaud', 'm*r*c**d', 288),
			  ('mort aux vaches', 'm*rt **x v*ch*s', 289),
			  ('morue', 'm*r**', 290),
			  ('moule à gaufres', 'm**l* * g**fr*s', 291),
			  ('moule à merde', 'm**l* * m*rd*', 292),
			  ('mouloud', 'm**l**d', 293),
			  ('muzz', 'm*zz', 294),
			  ('naze', 'n*z*', 295),
			  ('nazi', 'n*z*', 296),
			  ('ndepso', 'nd*ps*', 297),
			  ('nèg', 'n*g', 298),
			  ('négraille', 'n*gr**ll*', 299),
			  ('nègre', 'n*gr*', 300),
			  ('nègre d\'océanie', 'n*gr* d\'*c**n**', 301),
			  ('négresse', 'n*gr*ss*', 302),
			  ('négro', 'n*gr*', 303),
			  ('newfie', 'n*wf**', 304),
			  ('nez de b*uf', 'n*z d* b**f', 305),
			  ('niac', 'n**c', 306),
			  ('niafou', 'n**f**', 307),
			  ('niaiseux', 'n***s**x', 308),
			  ('niakoué', 'n**k***', 309),
			  ('nique sa mère', 'n*q** s* m*r*', 310),
			  ('nique ta mère', 'n*q** t* m*r*', 311),
			  ('niquer', 'n*q**r', 312),
			  ('niquer sa mère', 'n*q**r s* m*r*', 313),
			  ('niquer sa reum', 'n*q**r s* r**m', 314),
			  ('niquez votre mère', 'n*q**z v*tr* m*r*', 315),
			  ('nodocéphale', 'n*d*c*ph*l*', 316),
			  ('nœud', 'n**d', 317),
			  ('noob', 'n**b', 318),
			  ('nord-phocéen', 'n*rd-ph*c**n', 319),
			  ('ntm', 'n**', 320),
			  ('ntr', 'n**', 321),
			  ('nul', 'n*l', 322),
			  ('nulle', 'n*ll*', 323),
			  ('orchidoclaste', '*rch*d*cl*st*', 324),
			  ('ordure', '*rd*r*', 325),
			  ('ortho', '*rth*', 326),
			  ('pakos', 'p*k*s', 327),
			  ('panoufle', 'p*n**fl*', 328),
			  ('patarin', 'p*t*r*n', 329),
			  ('pd', 'p*', 330),
			  ('peau', 'p***', 331),
			  ('peau de couille', 'p*** d* c***ll*', 332),
			  ('peau de fesse', 'p*** d* f*ss*', 333),
			  ('peau de vache', 'p*** d* v*ch*', 334),
			  ('pecque', 'p*cq**', 335),
			  ('pédale', 'p*d*l*', 336),
			  ('pédé', 'p*d*', 337),
			  ('pédoque', 'p*d*q**', 338),
			  ('pelle à merde', 'p*ll* * m*rd*', 339),
			  ('péquenaud', 'p*q**n**d', 340),
			  ('personnage de comédie', 'p*rs*nn*g* d* c*m*d**', 341),
			  ('petite bite', 'p*t*t* b*t*', 342),
			  ('petite merde', 'p*t*t* m*rd*', 343),
			  ('pignouf', 'p*gn**f', 344),
			  ('pignoufe', 'p*gn**f*', 345),
			  ('pisser à la raie', 'p*ss*r * l* r***', 346),
			  ('pissou', 'p*ss**', 347),
			  ('pithécanthrope', 'p*th*c*nthr*p*', 348),
			  ('pleutre', 'pl**tr*', 349),
			  ('plouc', 'pl**c', 350),
			  ('pochard', 'p*ch*rd', 351),
			  ('poissonnière', 'p**ss*nn**r*', 352),
			  ('pompe à vélo', 'p*mp* * v*l*', 353),
			  ('porc', 'p*rc', 354),
			  ('porcas', 'p*rc*s', 355),
			  ('porcasse', 'p*rc*ss*', 356),
			  ('pot de merde', 'p*t d* m*rd*', 357),
			  ('pouf', 'p**f', 358),
			  ('pouffiasse', 'p**ff**ss*', 359),
			  ('poufiasse', 'p**f**ss*', 360),
			  ('poundé', 'p**nd*', 361),
			  ('pourriture', 'p**rr*t*r*', 362),
			  ('punaise', 'p*n**s*', 363),
			  ('putain', 'p*t**n', 364),
			  ('putain de ta race', 'p*t**n d* t* r*c*', 365),
			  ('pute', 'p*t*', 366),
			  ('pute borgne', 'p*t* b*rgn*', 367),
			  ('putois', 'p*t**s', 368),
			  ('raclure', 'r*cl*r*', 369),
			  ('raclure de bidet', 'r*cl*r* d* b*d*t', 370),
			  ('radoteur', 'r*d*t**r', 371),
			  ('rat', 'r*t', 372),
			  ('raté', 'r*t*', 373),
			  ('ratée', 'r*t**', 374),
			  ('raton', 'r*t*n', 375),
			  ('résidu de capote', 'r*s*d* d* c*p*t*', 376),
			  ('résidu de fausse couche', 'r*s*d* d* f**ss* c**ch*', 377),
			  ('retourne aux asperges', 'r*t**rn* **x *sp*rg*s', 378),
			  ('ripopée', 'r*p*p**', 379),
			  ('robespierrot', 'r*b*sp**rr*t', 380),
			  ('roi des cons', 'r** d*s c*ns', 381),
			  ('roi nègre', 'r** n*gr*', 382),
			  ('rond de chiotte', 'r*nd d* ch**tt*', 383),
			  ('rosbif', 'r*sb*f', 384),
			  ('roulure', 'r**l*r*', 385),
			  ('sac à foutre', 's*c * f**tr*', 386),
			  ('sac à merde', 's*c * m*rd*', 387),
			  ('sac à papier', 's*c * p*p**r', 388),
			  ('sagouin', 's*g***n', 389),
			  ('sagouine', 's*g***n*', 390),
			  ('salaud', 's*l**d', 391),
			  ('salaude', 's*l**d*', 392),
			  ('sale', 's*l*', 393),
			  ('salop', 's*l*p', 394),
			  ('salope', 's*l*p*', 395),
			  ('sans-couilles', 's*ns-c***ll*s', 396),
			  ('satrouille', 's*tr***ll*', 397),
			  ('sauvage', 's**v*g*', 398),
			  ('sauvagesse', 's**v*g*ss*', 399),
			  ('schbeb', 'schb*b', 400),
			  ('schlague', 'schl*g**', 401),
			  ('schleu', 'schl**', 402),
			  ('schleu', 'schl**', 403),
			  ('schleue', 'schl***', 404),
			  ('schnock', 'schn*ck', 405),
			  ('schnoque', 'schn*q**', 406),
			  ('sent-la-pisse', 's*nt-l*-p*ss*', 407),
			  ('sidi', 's*d*', 408),
			  ('social-traître', 's*c**l-tr**tr*', 409),
			  ('sorcière', 's*rc**r*', 410),
			  ('sottiseux', 's*tt*s**x', 411),
			  ('sous-merde', 's**s-m*rd*', 412),
			  ('stéarique', 'st**r*q**', 413),
			  ('ta bouche', 't* b**ch*', 414),
			  ('ta gueule', 't* g***l*', 415),
			  ('ta mère', 't* m*r*', 416),
			  ('ta mère la pute', 't* m*r* l* p*t*', 417),
			  ('ta race', 't* r*c*', 418),
			  ('ta yeule', 't* ***l*', 419),
			  ('tache', 't*ch*', 420),
			  ('tafiole', 't*f**l*', 421),
			  ('tantouserie', 't*nt**s*r**', 422),
			  ('tantouze', 't*nt**z*', 423),
			  ('tapette', 't*p*tt*', 424),
			  ('tapettitude', 't*p*tt*t*d*', 425),
			  ('tarlouze', 't*rl**z*', 426),
			  ('tata', 't*t*', 427),
			  ('tchoutche', 'tch**tch*', 428),
			  ('tebé', 't*b*', 429),
			  ('tête carrée', 't*t* c*rr**', 430),
			  ('tête de boche', 't*t* d* b*ch*', 431),
			  ('tête de cochon', 't*t* d* c*ch*n', 432),
			  ('tête de con', 't*t* d* c*n', 433),
			  ('tête de gland', 't*t* d* gl*nd', 434),
			  ('tête de linotte', 't*t* d* l*n*tt*', 435),
			  ('tête de mort', 't*t* d* m*rt', 436),
			  ('tête de mule', 't*t* d* m*l*', 437),
			  ('tête de n*ud', 't*t* d* n**d', 438),
			  ('tête de veau', 't*t* d* v***', 439),
			  ('téteux', 't*t**x', 440),
			  ('teub', 't**b', 441),
			  ('teubé', 't**b*', 442),
			  ('thénardier', 'th*n*rd**r', 443),
			  ('thon', 'th*n', 444),
			  ('tocard', 't*c*rd', 445),
			  ('tonnerre', 't*nn*rr*', 446),
			  ('traînée', 'tr**n**', 447),
			  ('travail d\'arabe', 'tr*v**l d\'*r*b*', 448),
			  ('travailler comme un nègre', 'tr*v**ll*r c*mm* *n n*gr*', 449),
			  ('triple buse', 'tr*pl* b*s*', 450),
			  ('trou de cul', 'tr** d* c*l', 451),
			  ('trou du cul', 'tr** d* c*l', 452),
			  ('trouduc', 'tr**d*c', 453),
			  ('truiasse', 'tr***ss*', 454),
			  ('truie', 'tr***', 455),
			  ('va te faire foutre', 'v* t* f**r* f**tr*', 456),
			  ('va te faire une soupe d\'esques', 'v* t* f**r* *n* s**p* d\'*sq**s', 457),
			  ('vaurien', 'v**r**n', 458),
			  ('vaurienne', 'v**r**nn*', 459),
			  ('vendu', 'v*nd*', 460),
			  ('vert-de-gris', 'v*rt-d*-gr*s', 461),
			  ('vide-couilles', 'v*d*-c***ll*s', 462),
			  ('viédase', 'v**d*s*', 463),
			  ('vieille conne', 'v***ll* c*nn*', 464),
			  ('vier', 'v**r', 465),
			  ('vieux', 'v***x', 466),
			  ('vieux blanc', 'v***x bl*nc', 467),
			  ('vieux con', 'v***x c*n', 468),
			  ('vipère lubrique', 'v*p*r* l*br*q**', 469),
			  ('visage à deux faces', 'v*s*g* * d**x f*c*s', 470),
			  ('weeaboo', 'w***b**', 471),
			  ('xéropineur', 'x*r*p*n**r', 472),
			  ('y\'a bon', '*\'* b*n', 473),
			  ('youd', '***d', 474),
			  ('youp', '***p', 475),
			  ('youpin', '***p*n', 476),
			  ('youpine', '***p*n*', 477),
			  ('youpinisation', '***p*n*s*t**n', 478),
			  ('youpiniser', '***p*n*s*r', 479),
			  ('youtre', '***tr*', 480),
			  ('zemel', 'z*m*l', 481),
			  ('zguègue', 'zg**g**', 482),
			  ('zoulette', 'z**l*tt*', 483);
			  
			  -- --------------------------------------------------------
			  
			  --
			  -- Structure de la table `membreForum`
			  --
			  
			  CREATE TABLE `membreForum` (
				`id` int(11) NOT NULL,
				`pseudo` varchar(255) DEFAULT NULL,
				`age` int(11) DEFAULT NULL,
				`mail` varchar(255) DEFAULT NULL,
				`motdepasse` text DEFAULT NULL,
				`valide` tinyint(1) DEFAULT NULL,
				`avatar` varchar(255) DEFAULT NULL,
				`estAdmin` tinyint(1) DEFAULT NULL
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			  
			  
			  --
			  -- Structure de la table `message`
			  --
			  
			  CREATE TABLE `message` (
				`idMessage` int(11) NOT NULL,
				`contenu` varchar(1000) DEFAULT NULL,
				`date` datetime DEFAULT NULL,
				`id` int(11) DEFAULT NULL,
				`idTheme` int(11) DEFAULT NULL,
				`affiche` tinyint(1) DEFAULT NULL,
				`nbAime` int(11) DEFAULT NULL
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			  
			  
			  
			  --
			  -- Structure de la table `theme`
			  --
			  
			  CREATE TABLE `theme` (
				`idTheme` int(11) NOT NULL,
				`titreTheme` varchar(150) DEFAULT NULL,
				`descriptionTheme` varchar(1000) DEFAULT NULL,
				`dateTheme` date DEFAULT NULL,
				`affiche` tinyint(1) DEFAULT NULL
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			  
			  
			  --
			  -- Index pour les tables déchargées
			  --
			  
			  --
			  -- Index pour la table `aime`
			  --
			  ALTER TABLE `aime`
				ADD PRIMARY KEY (`idAime`),
				ADD KEY `id` (`id`),
				ADD KEY `idMessage` (`idMessage`);
			  
			  --
			  -- Index pour la table `filtre`
			  --
			  ALTER TABLE `filtre`
				ADD PRIMARY KEY (`idmot`);
			  
			  --
			  -- Index pour la table `membreForum`
			  --
			  ALTER TABLE `membreForum`
				ADD PRIMARY KEY (`id`);
			  
			  --
			  -- Index pour la table `message`
			  --
			  ALTER TABLE `message`
				ADD PRIMARY KEY (`idMessage`),
				ADD KEY `id` (`id`),
				ADD KEY `idTheme` (`idTheme`);
			  
			  --
			  -- Index pour la table `theme`
			  --
			  ALTER TABLE `theme`
				ADD PRIMARY KEY (`idTheme`);
			  
			  --
			  -- AUTO_INCREMENT pour les tables déchargées
			  --
			  
			  --
			  -- AUTO_INCREMENT pour la table `aime`
			  --
			  ALTER TABLE `aime`
				MODIFY `idAime` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
			  
			  --
			  -- AUTO_INCREMENT pour la table `filtre`
			  --
			  ALTER TABLE `filtre`
				MODIFY `idmot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=484;
			  
			  --
			  -- AUTO_INCREMENT pour la table `membreForum`
			  --
			  ALTER TABLE `membreForum`
				MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
			  
			  --
			  -- AUTO_INCREMENT pour la table `message`
			  --
			  ALTER TABLE `message`
				MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
			  
			  --
			  -- AUTO_INCREMENT pour la table `theme`
			  --
			  ALTER TABLE `theme`
				MODIFY `idTheme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
			  
			  --
			  -- Contraintes pour les tables déchargées
			  --
			  
			  --
			  -- Contraintes pour la table `aime`
			  --
			  ALTER TABLE `aime`
				ADD CONSTRAINT `aime_ibfk_1` FOREIGN KEY (`id`) REFERENCES `membreForum` (`id`),
				ADD CONSTRAINT `aime_ibfk_2` FOREIGN KEY (`idMessage`) REFERENCES `message` (`idMessage`);
			  
			  --
			  -- Contraintes pour la table `message`
			  --
			  ALTER TABLE `message`
				ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id`) REFERENCES `membreForum` (`id`),
				ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`idTheme`) REFERENCES `theme` (`idTheme`);
			  COMMIT;
			  
			  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
			  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
			  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
EOF;
			$pdo->query($requetesSQL);
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		} catch (Exception $e) {
			if ($this->debug) {
				echo ($e->getMessage());
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
		$erreur = "";
		if (
			!empty($pseudo)
			and !empty($mail)
			and !empty($mdp)
		) {
			$pseudo = htmlspecialchars($pseudo);
			$mail = htmlspecialchars($mail);
			$mdp = sha1($mdp);
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pseudolength = mb_strlen($pseudo);
			if ($pseudolength >= 4) {
				if ($pseudolength <= 255) {
					if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
						$reqmail = $pdo->prepare("SELECT * FROM membreForum WHERE mail = ?");
						$reqmail->execute(array($mail));
						$ligne = $reqmail->fetch(PDO::FETCH_ASSOC);
						if ($ligne == false) {
							$reqpseudo = $pdo->prepare("SELECT * FROM membreForum WHERE pseudo = ?");
							$reqpseudo->execute(array($pseudo));
							$ligne = $reqpseudo->fetch(PDO::FETCH_ASSOC);
							if ($ligne == false) {
								// Etape 2 : envoi de la requête SQL au serveur
								$avatar = "avatar_base.png";
								$insertmbr = $pdo->prepare("INSERT INTO membreForum(pseudo, mail, motdepasse, valide, avatar, estAdmin) VALUES(?, ?, ?, ?, ?, ?)");
								$insertmbr->execute(array($pseudo, $mail, $mdp, false, $avatar, 0));
								$id = $pdo->lastInsertId();
								if (isset($_SERVER["HTTP_REFERER"])) {
									$url = $_SERVER["HTTP_REFERER"]; 
									$url = dirname($url);
									$this->envoyerMail($mail, "Valider l'inscription de votre compte du forum EcoStara", $url . "/validationParMail.php?id=" . $id);
								}
							} else {
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
				$pdo = null;
			} else {
				$erreur = "Votre pseudo doit posséder au moins 4 caractères !";
			}
		} else {
			$erreur = "Tous les champs doivent être complétés !";
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
		$erreur = "";
		$user = null;
		if (
			!empty($mailconnect)
			and !empty($mdpconnect)
		) {
			$mailconnect = htmlspecialchars($mailconnect);
			$mdpconnect = sha1($mdpconnect);
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// Etape 2 : envoi de la requête SQL au serveur
			$requser = $pdo->prepare("SELECT * FROM membreForum WHERE mail = ? AND motdepasse = ?");
			$requser->execute(array($mailconnect, $mdpconnect));
			$user = $requser->fetch(PDO::FETCH_ASSOC);
			if ($user == false) {
				$erreur = "Mauvais mail ou mot de passe !";
				$user = null;
			} else {
				if ($user["valide"] == false) {
					$erreur = "En attente de validation par mail !";
					$user = null;
				}
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		} else {
			$erreur = "Tous les champs doivent être complétés !";
		}

		if ($erreur != "") {
			throw new Exception($erreur);
		}

		return $user;
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
		$user = null;
		if ($id != null) {
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// Etape 2 : envoi de la requête SQL au serveur
			$requser = $pdo->prepare("SELECT * FROM membreForum WHERE id = ?");
			$requser->execute(array($id));
			// Etape 3 : récupère les données
			$user = $requser->fetch(PDO::FETCH_ASSOC);
			if ($user == false) {
				$user = null;
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		}
		return $user;
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
	public function mettreAJour($id = null, $newpseudo, $newmail, $actuMdp, $newage, $newmdp1, $newmdp2)
	{
		$erreur = "Aucune modification !";
		if ($id != null) {
			$user = $this->obtenirMembre($id);
			$erreur = "";

			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ) ;

			if (isset($actuMdp) and !empty($actuMdp)) {

				$actuMdp = sha1($actuMdp);
				$requser = $pdo->prepare("SELECT * FROM membreForum WHERE motdepasse = ? AND id = ?");
				$requser->execute(array($actuMdp, $id));
				$user = $requser->fetch(PDO::FETCH_ASSOC);

			if($user != false){

			if (isset($newpseudo) and !empty($newpseudo) and $newpseudo != $user['pseudo']) {

				$requser = $pdo->prepare("SELECT * FROM membreForum WHERE pseudo=?");
				$requser->execute(array($newpseudo));
				$existe = $requser->fetch(PDO::FETCH_ASSOC);

				if ($existe == false){

				$newpseudo = htmlspecialchars($newpseudo);
				$pseudolength = mb_strlen($newpseudo);
				if ($pseudolength <= 20) {
					$insertpseudo = $pdo->prepare("UPDATE membreForum SET pseudo = ? WHERE id = ?");
					$insertpseudo->execute(array($newpseudo, $id));
				} else {
					$erreur = $erreur . "Votre pseudo ne doit pas dépasser 20 caractères !</br>";
				}
			}else{
				$erreur = $erreur . "Votre pseudo est déjà utilisé, veuillez en choisir un autre.";
			}
		}


			if (isset($newmail) and !empty($newmail) and $newmail != $user['mail']) {

				$requser = $pdo->prepare("SELECT * FROM membreForum WHERE mail=?");
				$requser->execute(array($newmail));
				$existe = $requser->fetch(PDO::FETCH_ASSOC);

				if ($existe == false){

				$newmail = htmlspecialchars($newmail);
				if (filter_var($newmail, FILTER_VALIDATE_EMAIL)) {
					$insertmail = $pdo->prepare("UPDATE membreForum SET mail = ? WHERE id = ?");
					$insertmail->execute(array($newmail, $id));
				} else {
					$erreur = $erreur . "Votre adresse mail n'est pas valide !</br>";
				}
			}else{
				$erreur = $erreur . "Cette adresse mail est déjà utilisée !</br>";
			}
		
		}

				if ($user == false) {
					$erreur = "Vous avez indiqué un mauvais mot de passe !";
				}
			




			if (isset($newage) and !empty($newage)) {
				if (($newage >= 1) && ($newage <= 120)) {
					$insertmdp = $pdo->prepare("UPDATE membreForum SET age = ? WHERE id = ?");
					$insertmdp->execute(array($newage, $id));
				} else {
					$erreur = $erreur . "Votre age doit être compris entre 0 et 120 ans";
				}
			}


			if (isset($_FILES['avatar']) and !empty($_FILES['avatar']['name'])) {
				$poidsMax = 1048576;
				$formatsValides = array('jpg', 'jpeg', 'png');
				if ($_FILES['avatar']['size'] <= $poidsMax) {
					$formatsTelecharge = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
					if (in_array($formatsTelecharge, $formatsValides)) {
						$arborescence = "./images/membres/avatars/" . $_SESSION['id'] . "." . $formatsTelecharge;
						$resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $arborescence);
						if ($resultat) {
							$newavatar = $pdo->prepare('UPDATE membreForum SET avatar = :avatar WHERE id = :id');
							$newavatar->execute(array('avatar' => $_SESSION['id'] . "." . $formatsTelecharge, 'id' => $_SESSION['id']));
						} else {
							$erreur = "Erreur durant l'importation de votre photo de profil";
						}
					} else {
						$erreur = "Votre photo de profil doit être au format jpg, jpeg ou png";
					}
				} else {
					$erreur = "Votre photo de profil ne doit pas dépasser 1Mo";
				}
				
			}

			if (isset($newmdp1) and !empty($newmdp1)) {
				if (mb_strlen($newmdp1) >= 4) {
					if ($newmdp1 == $newmdp2) {
						$newmdp1 = sha1($newmdp1);
						if($newmdp1 != $actuMdp){
						$requser = $pdo->prepare("UPDATE membreForum SET motdepasse = ? WHERE id = ?");
						$requser->execute(array($newmdp1, $id));}
						else{
							$erreur = "Le nouveau mot de passe est identique à l'ancien !";
						}
					}else{
						$erreur = "Vos deux mots de passe ne sont pas identiques !";
					}
				}else{
					$erreur = "Votre mot de passe doit dépasser 4 caractères !";
				}
			}

			}else{
			$erreur = $erreur . "Votre mot de passe n'est pas correct !";
			}

			}else{
			$erreur = "Merci d'indiquer votre mot de passe !";
			}

			if ($erreur != "") {
				throw new Exception($erreur);
			}

			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;

			return $this->obtenirMembre($id); // Utilisateur avec les données mises à jour
		}
	}


	public function envoyerMail($destinataire, $sujet, $message)
	{
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
		$mail->CharSet = \PHPMailer\PHPMailer\PHPMailer::CHARSET_UTF8;
		if ($mail->send() != false) {
			echo ("");
			return true;
		} else {
			echo ("");
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
	public function validerMembre($id = null)
	{
		if ($id != null) {
			if (is_numeric($id)) {
				// Etape 1 : connexion au serveur de base de données
				$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
				$pdo->query("SET NAMES utf8");
				$pdo->query("SET CHARACTER SET 'utf8'");
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				// Etape 2 : envoi de la requête SQL au serveur
				$validupdate = $pdo->prepare("UPDATE membreForum SET valide = ? WHERE id = ?");
				$validupdate->execute(array(true, $id));
				// Etape 3 : ferme la connexion au serveur de base de données
				$pdo = null;
			}
		}
	}

	public function obtenirTheme($motCle)
	{
		$nomTheme = null;

		// Etape 1 : connexion au serveur de base de données
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Etape 2 : envoi de la requête SQL au serveur
		if ($motCle == null) {
			$requser = $pdo->query("SELECT * FROM theme WHERE affiche = 1 ORDER BY theme.dateTheme DESC");
			// Etape 3 : récupère les données
			$nomTheme = $requser->fetchAll(PDO::FETCH_ASSOC);
			if ($nomTheme == false) {
				$nomTheme = null;
			}
		} else {
			$requser = $pdo->prepare("SELECT * FROM theme WHERE titreTheme LIKE ? AND affiche = 1 ORDER BY theme.dateTheme DESC");
			$requser->execute(array("%" . $motCle . "%"));
			// Etape 3 : récupère les données
			$nomTheme = $requser->fetchAll(PDO::FETCH_ASSOC);
			if ($nomTheme == false) {
				$nomTheme = null;
			}
		}
		// Etape 4 : ferme la connexion au serveur de base de données
		$pdo = null;

		return $nomTheme;
	}

	public function obtenirInfoTheme($idTheme)
	{
		$infoTheme = null;

		// Etape 1 : connexion au serveur de base de données
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Etape 2 : envoi de la requête SQL au serveur
		$requser = $pdo->prepare("SELECT * FROM theme WHERE idTheme = ?");
		$requser->execute(array($idTheme));
		// Etape 3 : récupère les données
		$infoTheme = $requser->fetch(PDO::FETCH_ASSOC);
		if ($infoTheme == false) {
			$infoTheme = null;
		}
		// Etape 4 : ferme la connexion au serveur de base de données
		$pdo = null;

		return $infoTheme;
	}

	public function supprimerLeTheme($idTheme)
	{
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Etape 2 : envoi de la requête SQL au serveur
		$requser = $pdo->prepare("UPDATE theme SET affiche=? WHERE idTheme=?");
		$requser->execute(array(0, $idTheme));
		// Etape 3 : ferme la connexion au serveur de base de données
		$pdo = null;
	}

	public function obtenirListeMessage($idTheme, $motCle, $trierPar)
	{
		$infoMessage = null;

		// Etape 1 : connexion au serveur de base de données
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Etape 2 : envoi de la requête SQL au serveur
		if ($motCle == null) {
			if($trierPar == "parLike"){
			$requser = $pdo->prepare("SELECT * FROM message WHERE idTheme=? AND affiche=1 ORDER BY message.nbAime DESC, message.date DESC");
		}else{
			$requser = $pdo->prepare("SELECT * FROM message WHERE idTheme=? AND affiche=1 ORDER BY message.date DESC");
		}
			$requser->execute(array($idTheme));
			// Etape 3 : récupère les données
			$infoMessage = $requser->fetchAll(PDO::FETCH_ASSOC);
			if ($infoMessage == false) {
				$infoMessage = null;
			}
		} else {
			$requser = $pdo->prepare("SELECT * FROM message WHERE idTheme=? AND affiche=1 AND contenu LIKE ? ORDER BY message.nbAime DESC");
			$requser->execute(array($idTheme, "%" . $motCle . "%"));
			$infoMessage = $requser->fetchAll(PDO::FETCH_ASSOC);
			if ($infoMessage == false) {
				$infoMessage = null;
			}
		}
		// Etape 4 : ferme la connexion au serveur de base de données
		$pdo = null;

		return $infoMessage;
	}

	public function compterAime($idMessage)
	{
		// Etape 1 : connexion au serveur de base de données
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Etape 2 : envoi de la requête SQL au serveur
		$requser = $pdo->prepare("SELECT COUNT(*) AS 'nbAime' FROM aime WHERE idMessage=?");
		$requser->execute(array($idMessage));
		$nombreAime = $requser->fetch(PDO::FETCH_ASSOC);
		$requser = $pdo->prepare("UPDATE message SET nbAime=? WHERE idMessage=? ");
		$requser->execute(array($nombreAime["nbAime"], $idMessage));
		$pdo = null;
		return $nombreAime["nbAime"];
	}

	public function ajouterTheme($titre, $description)
	{
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Etape 2 : envoi de la requête SQL au serveur
		$exist = $pdo->prepare("SELECT * FROM theme WHERE titreTheme=?");
		$exist->execute(array($titre));
		$exist = $exist->fetchAll(PDO::FETCH_ASSOC);

		if ($exist == false) {
			$requser = $pdo->prepare("INSERT INTO theme(titreTheme, descriptionTheme, dateTheme, affiche) VALUES (?, ?, NOW(), ?)");
			$requser->execute(array($titre, $description, 1));
			$infoTheme = $requser->fetchAll(PDO::FETCH_ASSOC);
		}
		// Etape 4 : ferme la connexion au serveur de base de données

		$pdo = null;
		return $infoTheme;
	}

	public function publierMessage($id, $contenu, $idTheme)
	{
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Etape 2 : envoi de la requête SQL au serveur

		$mots = $pdo->query('SELECT mot FROM filtre');
		$mots = $mots->fetchAll(PDO::FETCH_COLUMN);

		$resultatMot = $pdo->query('SELECT resultatMot FROM filtre');
		$resultatMot = $resultatMot->fetchAll(PDO::FETCH_COLUMN);


		$contenu = str_ireplace($mots, $resultatMot, $contenu);
		$contenu = ucfirst($contenu);


		$requser = $pdo->prepare("INSERT INTO message(contenu, date, id, idTheme, affiche, nbAime) VALUES (?, NOW(), ?, ?, ?, ?)");
		$requser->execute(array($contenu, $id, $idTheme, 1, 0));
		// Etape 4 : ferme la connexion au serveur de base de données


		$pdo = null;

	}

	public function supprimerMessage($idMessage)
	{
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Etape 2 : envoi de la requête SQL au serveur
		$requser = $pdo->prepare("UPDATE message SET affiche=? WHERE idMessage=$idMessage");
		$requser->execute(array(0));
		// Etape 4 : ferme la connexion au serveur de base de données
		$pdo = null;
	}

	public function likerMessage($idMessage, $id)
	{
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$requser = $pdo->prepare("SELECT * FROM aime WHERE id=? AND idMessage=?");
		$requser->execute(array($id, $idMessage));
		$likeExiste = $requser->fetchAll(PDO::FETCH_ASSOC);
		if ($likeExiste != null) {
			$requser = $pdo->prepare("DELETE FROM aime WHERE id=? AND idMessage=?");
			$requser->execute(array($id, $idMessage));
		} else {
			$requser = $pdo->prepare("INSERT INTO aime(id, idMessage) VALUES (?, ?)");
			$requser->execute(array($id, $idMessage));
		}
		$pdo = null;
	}

	public function dejaLike($idMessage, $id)
	{
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$requser = $pdo->prepare("SELECT * FROM aime WHERE id=? AND idMessage=?");
		$requser->execute(array($id, $idMessage));
		$likeExiste = $requser->fetchAll(PDO::FETCH_ASSOC);
		if ($likeExiste != null) {
			$resultat = true;
		} else {
			$resultat = false;
		}
		$pdo = null;
		return $resultat;
	}

	public function filtre(){

	}

}
