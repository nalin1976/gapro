<?php
/**
 * [fr] Encodage d'adresse email a la sauce http://aspirine.org/emailcode.php mais en Php
 * [en] Email address encoder like http://aspirine.org/emailcode_en.html but in Php
 *
 * @package Emailcode
 * @author [original] François Pirsch
 * @author [Php adaptation] Philippe
 * @version 0.2	(27 déc 2007)
 * @since 2007-07-05
 * 
 * This class is written in Php4, without Php5 specific functions... (!)
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * See changelog at the bottom of this script
 * 
 *
 * -----
 * USE :
 * -----
 *     ________________________________
 * ___/ Quick start with a simple link \_________________________________
 *
 *		require 'emailcode.class.php';
 *		$emailcode = new ClassEmailcode();
 *		echo $emailcode->emailgetencode('mymail@myprovider.com','Contact me');	// returns '' if an error occurs.
 *
 * Generates and prints a <script> tag with a JavaScript encoded version of :
 * Génère et affiche une balise <script> contenant une version encodée en JavaScript du lien :
 *		<a href="mymail@myprovider.com">Contact me</a>
 *
 * Error handling : see below.
 * Gestion des erreurs : voir plus bas.
 *     _____________________
 * ___/ for an email adress \____________________________________________
 *
 * ~ Method 1 (extended) ~
 * ~~~~~~~~~~~~~~~~~~~~~~~
 *		require 'emailcode.class.php';
 *		$emailcode = new ClassEmailcode();
 *		$emailcode->coding = 'xhtml';					// [opt] xhtml (default) | html
 *		$emailcode->email = 'mymail@myprovider.com';	// [required]
 *		$emailcode->text = 'Contact me';				// [opt] = email by default
 *		$emailcode->subject = '';						// [opt] empty by default : mail subject
 *		$emailcode->cssClassName = '';					// [opt] empty by default : link class name
 * 
 *			// Then in 2 steps :
 *		$emailcode->emailencode();
 *		echo $emailcode->emailget();
 *			// Or in one step :
 *		echo $emailcode->emailgetencode();	// returns '' if an error occurs.
 * 
 * ~ Method 2 (short) ~
 * ~~~~~~~~~~~~~~~~~~~~~~~~~
 * //$v->emailencode($email[,$text[,$subject[,$cssClassName[,$coding]]]]);
 *		require 'emailcode.class.php';
 *		$emailcode = new ClassEmailcode();
 * 
 *			// In one step :
 *		echo $emailcode->emailgetencode('mymail@myprovider.com','Contact me');
 * 
 * 
 *     _____________________
 * ___/ for (x)html content \____________________________________________
 *
 * This class can be used to encrypt any *short* html content, like image or button links.
 * The generated code size and server encoding / browser decoding time grows quickly !
 *
 * Cette classe peut êtr utilisée pour chiffrer du contenu html *court*, comme des liens sur des images ou des boutons.
 * Le code généré et le temps d'encodage sur le serveur / décodage dans le navigateur peut vite devenir énorme !
 *
 * ~ Method 1 (extended) ~
 * ~~~~~~~~~~~~~~~~~~~~~~~
 *		require 'emailcode.class.php';
 *		$emailcode = new ClassEmailcode();
 *		$emailcode->htmltext = '<a href="mymail@myprovider.com"><img src="mypic.jpg" width="100" height="30" alt="contact me" /></a>';
 * 
 *		$emailcode->htmlencode();
 *		echo $emailcode->htmlget();
 *			// Or in one step :
 *		echo $emailcode->htmlgetencode();
 * 
 * ~ Method 2 (short) ~
 * ~~~~~~~~~~~~~~~~~~~~~~~~~
 * //$v->htmlencode($text);
 *		require 'emailcode.class.php';
 *		$emailcode = new ClassEmailcode();
 * 
 *			// In one step :
 *		echo $emailcode->htmlgetencode('<a href="mymail@myprovider.com"><img src="mypic.jpg" width="100" height="30" alt="contact me" /></a>');
 *
 *     ________________
 * ___/ Error handling \________________________________________________
 * The emailgetencode() and htmlgetencode() functions both return an empty string '' when an error occurs.
 * Les fonctions emailgetencode() et htmlgetencode() renvoient une chaîne vide '' en cas d'erreur.
 * $emailcode->getErrorCode() returns the error code, and
 * $emailcode->getErrorDescription() returns a description (english or french)
 * 
 * Error code   type      where & when     Description
 * ----------------------------------------------------------------------------
 *     2        fatal     htmlencode()     you are trying to encode a <meta> tag
 *     3        fatal     htmlencode()     you are trying to encode a <link> tag
 *     4        warning   htmlencode()     you are trying to encode a <script> tag
 *     5        warning   emailencode()    the generated code mays be not be properly viewed with Internet Explorer
 *     6        fatal     emailencode()    you are using an anti-slash in the link text
 * Error 5 is caused by a strange IE6/7 bug when you try to encode an mailto:link with a subject AND an @ in the link text.
 * L'erreur 5 est causée par un bug étrange d'IE6/7 quand on encode un lien mailto: avec un sujet ET un @ dans le texte du lien.
 *
 * Example of error-testing code :
 *
 *		require 'emailcode.class.php';
 *		$emailcode = new ClassEmailcode();
 *		$emailcode->language('en');			// 'fr' by default.
 *		echo $emailcode->emailgetencode('mymail@myprovider.com','Contact me');	// This one can't generate an error.
 *		$enc = $emailcode->emailgetencode($address, $text);
 *		if($enc) {
 *			// everything is OK, output the generated code.
 *			echo $enc . "\n";
 *		} else {
 *			// Something was wrong with parameters $address or $text
 *			echo "Error " . $emailcode->getErrorDescription() . "\n";
 *		}
 */



class ClassEmailcode {
		
//////////////////////////////////////////////////
// public variables
//////////////////////////////////////////////////
		
		/**
		 * Html coding type (xhtml | html)
		 * @access public
		 * @var string
		 */
		var $coding = 'xhtml';		// xhtml (default) | html
		
		/**
		 * Email (!)
		 * @access public
		 * @var string
		 */
		var $email = '';
		
		/**
		 * Text display as link, if empty, email adress is used
		 * @access public
		 * @var string
		 */
		var $text = '';
		
		/**
		 * Subject of the email to send ("mailto:mymail@myprovider.com?subject=xxx")
		 * @access public
		 * @var string
		 */
		var $subject = '';
		
		/**
		 * Css class name for the link
		 * @access public
		 * @var string
		 */
		var $cssClassName = '';
		
		/**
		 * Error code (the last one only)
		 * @access public
		 * @var int
		 */
		var $errCode = 0;
		
		/**
		 * Error message
		 * @access public
		 * @var string
		 */
		var $errString = '';
		
		/**
		 * String (coded in (x)html) returned after an email encoded
		 * @access public
		 * @var string
		 */
		var $emailencoded = '';
		
		/**
		 * String (coded in (x)html) returned after an (x)html source encoded
		 * @access public
		 * @var string
		 */
		var $htmlencoded = '';
		
		
// ----- private variables -----
	    /**#@+
	     * @access private
	     */
		var $lng = 'fr';			// Language code, for messages
		var $messages = array();	// 
	    /**#@-*/
		
		
		
		
		
//////////////////////////////////////////////////
// emailcode specific variables
//////////////////////////////////////////////////
	    /**#@+
	     * @access private
	     */
		var $js_version = '2.11';
		var $passes = 2;
	     
		var $nb_retournements = 0;
		var $nb_base64 = 0;

		// Hash contenant la liste des variables générées pour le script.
		var $liste_des_variables = array();
		var $premier_caractere;		// Caractères à utiliser pour créer les noms de variables.
		var $second_caractere;

		// Liste de caractères spéciaux dans une expression régulière JS : ils peuvent être précédés d'un anti-slash.
		var $speciaux;
		
		// Liste des caractères utilisés pour l'encodage en base 64 sustomisé.
		var $base64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789*-';
		
		// liste de caractères qu'on peut ajouter au hasard. Ils ne doivent
		// pas être des caractères spéciaux des expressions régulières.
		var $listecar;			// La même liste en tableau.
		/**#@-*/
		
		
		
		
		
//////////////////////////////////////////////////
// class methods
//////////////////////////////////////////////////
		
		
//	----------------------------------------------------------------------
	/**
	 * Constructeur.
	 *
	 * @access public
	 * @return void
	 */
		function ClassEmailcode()
		{
			$this->dictionary();
			$this->premier_caractere = $this->str_split_php4('abcdefghijklmnopqrstuvwxyz');
			$this->second_caractere = $this->str_split_php4('0123456789_Ol');	// A la fin c'est les lettres O et L
			$this->speciaux = $this->str_split_php4('!$%#*+/?');
			$this->listecar = $this->str_split_php4(' !#%&,-0123456789:<=>ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz~');
		}
		
		
//	----------------------------------------------------------------------
	/**
	 * Email encoder.
	 *
	 * @access public
	 * @param string $email Email to encode
	 * @param string $text Text to display as link
	 * @param string $coding Html type coding
	 * @param string $subject Subject of email
	 * @param string $css Css class name for the link
	 * @return void
	 */
		function emailencode($email=NULL,$text=NULL,$subject=NULL,$css=NULL,$coding=NULL)
		{
			$p = false;		// Is a parameter transmitted to this function ?
			if (!is_null($email))
			{
				$p = true;
				$this->email = $email;
			}
			if ($p && !is_null($text))		{	$this->text = $text;} else {$p = false;}
			if ($p && !is_null($coding))
			{	if ($coding=='xhtml'||$coding=='html') $this->coding = $coding;} else {$p = false;}
			if ($p && !is_null($subject))	{	$this->subject = $subject;} else {$p = false;}
			if ($p && !is_null($css))		{	$this->cssClassName = $css;} else {$p = false;}
			
			// -----
			$this->emailencoded = $this->encode($this->email,$this->text);
		}
		
		
//	----------------------------------------------------------------------
	/**
	 * Return the email string encoded.
	 *
	 * @access public
	 * @return void
	 */
		function emailget()
		{
			return $this->emailencoded;
		}
		
		
//	----------------------------------------------------------------------
	/**
	 * Encoded and return email string encoded in one step.
	 *
	 * @access public
	 * @param string $email Email to encode
	 * @param string $text Text to display as link
	 * @param string $coding Html type coding
	 * @param string $subject Subject of email
	 * @param string $css Css class name for the link
	 * @return void
	 */
		function emailgetencode($email=NULL,$text=NULL,$subject=NULL,$css=NULL,$coding=NULL)
		{
			$this->emailencode($email,$text,$coding,$subject,$css);
			return $this->emailget();
		}
		
		
//	----------------------------------------------------------------------
	/**
	 * Source html encoder.
	 *
	 * @access public
	 * @param string $text Html to encode
	 * @return void
	 */
		function htmlencode($text=NULL)
		{
			if ($text) {
				$this->text = $text;
			}
			$this->encode2($this->text);
		}
		
		
//	----------------------------------------------------------------------
	/**
	 * Return the source html encoded.
	 *
	 * @access public
	 * @return void
	 */
		function htmlget()
		{
			return $this->htmlencoded;
		}
		
		
//	----------------------------------------------------------------------
	/**
	 * Encoded and return email string encoded in one step.
	 *
	 * @access public
	 * @param string $text Html to encode
	 * @return void
	 */
		function htmlgetencode($text=NULL)
		{
			if(!$text) return '';
			$this->htmlencode($text);
			return $this->htmlget();
		}
		
		
		
		
		
//////////////////////////////////////////////////
// miscellaneous methods
//////////////////////////////////////////////////
		
//	----------------------------------------------------------------------
	/**
	 * Modify language (and reload dictionary).
	 *
	 * @access public
	 * @param string $lng Language code
	 * @return void
	 */
		function language($lng='')
		{
			if ($lng=='fr' || $lng='en')
			{
				$this->lng = $lng;
				$this->dictionary();
			}
		}
		
		
//	----------------------------------------------------------------------
	/**
	 * Load dictionary in selected language.
	 *
	 * @access public
	 * @return void
	 */
		function dictionary()
		{
			$messages_lng = array();
			
			// French
			$messages_lng['fr'][2] = 'On ne peut pas coder les balises <meta> avec des scripts !';
			$messages_lng['fr'][3] = 'On ne peut pas coder les balises <link> avec des scripts, ni d\'ailleurs aucune balise de la section <head> !';
			$messages_lng['fr'][4] = 'Recoder un script ne marche que rarement, et donne souvent des r&eacute;sultats curieux !\nEssayez l\'aperçu pour voir.';
			$messages_lng['fr'][5] = 'Le texte de votre lien comporte un caract&egrave;re @\nUn bug d\'Internet Explorer (6 et 7) rendra l\'affichage bizarre, mais dans les autres navigateurs le lien apparaîtra normalement.\nPour &eacute;viter ça, mettez un texte de lien sans @, du genre "contact", ou ne mettez pas de sujet au mail.';
			$messages_lng['fr'][6] = 'Pas d\'anti-slash dans le texte du lien svp.';

			// English
			$messages_lng['en'][2] = '<meta> tags can\'t be encoded with javascript.';
			$messages_lng['en'][3] = '<link> tags can\'t be encoded with javascript, like all other tags in the HEAD section.';
			$messages_lng['en'][4] = 'Re-encoding a script rarely works, and results are often unexpected. Preview won\'t work.';
			$messages_lng['en'][5] = 'You\'ve got a subject, and a link text containing the @ character. A bug in Internet Explorer (6 and 7) will make this link have a funny behavior, but it will be OK when viewed in other browsers.\n Give a link text without @, like "contact me", or remove the subject to avoid this.';
			$messages_lng['en'][6] = 'Please don\'t use anti-slashes.';
			
			$this->messages = $messages_lng[$this->lng];
			unset($messages_lng);
		}
		
		
//	----------------------------------------------------------------------
	/**
	 * Error alert.
	 *
	 * @access public
	 * @param int $s Error code
	 * @return void
	 */
		function alert($s)
		{
			$this->errCode = $s;
			$this->errString = $this->messages[$s];
		}
		
		
//	----------------------------------------------------------------------
	/**
	 * Return error code.
	 *
	 * @access public
	 * @return int
	 */
		function getErrorCode()
		{
			return $this->errCode;
		}
		
		
//	----------------------------------------------------------------------
	/**
	 * Return error message.
	 *
	 * @access public
	 * @return string
	 */
		function getErrorDescription()
		{
			return $this->errString;
		}
		
		
		
		
//////////////////////////////////////////////////
// emailcode methods
//////////////////////////////////////////////////

	// Fonctions de sous-traitance pour code_arrobas_point_JS().
	// N'utiliser que des guillemets " pour délimiter les chaînes ajoutées, les simples sont réservés aux
	// chaînes à brouiller par la suite. C'est pour faciliter la détection.
	//     _______________
	// ___/               \__________________________________________________
	//
	function h($max)
	{
		return rand(0,($max-1));
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	// vérifiée OK
	function remplace_point()
	{
		switch($this->h(6))
		{
			case 0 : return '\\x2e';
			case 1 : return '\\u002e';
			case 2 : return "'+String.fromCharCode(46)+'";
			case 3 : return "'+[\".\"][0]+'";
			case 4 : return "'+\".\".charAt(0)+'";
			case 5 : return "'+\".\"+'";
		}
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	// vérifiée OK
	function remplace_arrobas ()
	{
		switch($this->h(6))
		{
			case 0 : return '\\x40';
			case 1 : return '\\u0040';
			case 2 : return "'+String.fromCharCode(64)+'";
			case 3 : return "'+[\"@\"][0]+'";
			case 4 : return "'+\"@\".charAt(0)+'";
			case 5 : return "'+\"@\"+'";
		}
	}
	
	//     _______________
	// ___/               \__________________________________________________
	//
	// Renvoie un caractère choisi au hasard dans le tableau $whitelist
	// et absent du tableau $blacklist.
	// Renvoie null si tous les caractères de $whitelist sont dans blacklist.
	// vérifiée OK
	function choisit_caractere($whitelist, $blacklist)
	{
		$good_list = array_values(array_diff($whitelist, $blacklist));
		return $good_list[rand(0, count($good_list)-1)];
	}
	function caractere_aleatoire($char_list) {
		return $char_list[rand(0, count($char_list)-1)];
	}
	
	//     _______________
	// ___/               \__________________________________________________
	//
	// Le paramètre $s doit être une chaîne entre apostrophes.
	// Cette fonction remplace toutes les occurrences du point par des expressions plus compliquées équivalentes,
	// ou par un caractère aléatoire + une instruction replace qui remettra les points.
	// vérifiée OK
	function code_point_JS($s)
	{
		if ($this->h(7) == 0) 		// avec 1 chance sur 7 ...
		{
			// Remplacement des points par un autre caractère, et ajout d'une instruction replace.
			// Exemple : 'moi@ici.point.fr' -> ('moi@ici#point#fr').replace(/\\#/g,".")
			$c = $this->choisit_caractere($this->speciaux, $this->str_split_php4($s));
			if($c !== null) {						// Si c'est impossible on laisse tomber.
				$v = "(".str_replace('.', $c, $s).").replace(/\\$c/g,\".\")";
				return $v;
			}
		}

		// Remplacement des points par des expressions plus complexes équivalentes.
		// Exemple : 'moi@ici.point.fr' -> 'moi@ici'+"."+'point\\x40fr'
		$resultat = preg_replace("/\./e", "\$this->remplace_point()", $s);
		return $resultat;
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	// L'entrée dans cette fonction doit être une expression javascript valide, donc si c'est une simple
	// chaîne elle doit avoir des apostrophes.
	// Cette fonction remplace toutes les occurrences du @ par des expressions plus compliquées équivalentes,
	// ou par un caractère aléatoire + une instruction replace qui remettra les @.
	// vérifiée OK
	function code_arrobas_point_JS($s)
	{
		$s = $this->code_point_JS($s);
		if ($this->h(7) == 0)		// avec 1 chance sur 7 ...
		{
			// Remplacement des arrobas par un autre caractère, et ajout d'une instruction replace.
			// Exemple : 'moi@ici.fr' -> ('moi#ici.fr').replace(/\\#/g,"@")
			$c = $this->choisit_caractere($this->speciaux, $this->str_split_php4($s));	// choisit un caractère de $speciaux absent dans $s.
			if($c !== null) {
				$po = '';
				$pf = '';
				if (strpos($s,'+')>=0) { $po = '('; $pf = ')'; }
				$v = $po.str_replace('@', $c, $s).$pf.".replace(/\\$c/g,\"@\")";
				return $v;
			}
		}

		// Remplacement des arrobas par des expressions plus complexes équivalentes.
		// Attention $s peut être une expression JS complexe, comme une concaténation ou un .replace.
		// Exemple : 'moi@ici'+"."+'fr' -> 'moi'+"@"+'ici'+"."+'fr'
		$s = preg_replace("/@/e", "\$this->remplace_arrobas()", $s);
		if (strpos($s,'.replace')>0) $s = "($s)";
		return $s;
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	// vérifiée OK
	function code_arrobas_point_HTML($s)
	{
		$zero = '00000';															// Quelques zéros
		switch($this->h(2))
		{
			case 0: $a = '&#'.substr($zero,$this->h(6)).'64;';break;			// On ajoute des 0, 5 maximum à cause d'IE.
			case 1: $a = '&#x'.substr($zero,$this->h(5)+1).'40;';break;			// Ici 4 zéros maxi. ( 0 <= h(5) <= 4 )
		}
		$s = str_replace('@',$a,$s);
		switch($this->h(2))
		{
			case 0: $a = '&#'.substr($zero,$this->h(6)).'46;';break;			// On ajoute des 0, 5 maximum à cause d'IE.
			case 1: $a = '&#x'.substr($zero,$this->h(5)+1).'2e;';break;			// Ici 4 zéros maxi. ( 0 <= h(5) <= 4 )
		}
		$s = str_replace('.',$a,$s);
		return $s;
	}
	
	
	// Prend une chaîne contenant une chaine JS entourée d'apostrophes ou de guillemets, et la convertit en chaîne normale.
	// Exemples :
	//		'coucou l\\'artiste' --> coucou l'artiste
	//		'coucou'             --> coucou
	//		"coucou"             --> coucou
	//		 coucou              --> coucou
	// (suppression des apostrophes de début et de fin, des doubles-anti-slashes et des \'   )
	//     _______________
	// ___/               \__________________________________________________
	//
	// vérifiée OK
	function decortique($s)
	{
		// Supprime les guillemets ou apostrophes de début et de fin.
		$s = preg_replace("/^(['\"])(.*)\\1$/", "$2", $s);
		// Supprime les double-anti-slashes et les \'
		return stripslashes($s);
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	// Remplace un nombre par une opération, histoire de polymorpher à donf.
	// vérifiée OK
	function complique($n)
	{
		switch ($this->h(5))
		{
			case 0: return $n;								// nombre tel quel, on ne complique pas systématiquement.
			case 1: return '0x'.base_convert($n,10,16);		// nombre en hexa.
			case 2: $k = rand(0,99);						// Exprime le nombre sous forme d'une addition.
					return ($n-$k).'+'.$k;
			case 3: $k = rand(0,99);						// Exprime le nombre sous forme d'une soustraction.
					return ($n+$k).'-'.$k;
			case 4: $k = rand(0,9);							// Exprime le nombre sous la forme n*m+p.
					$m = rand(0,9);
					$p = $n-($k*$m);
					$s = $k.'*'.$m;
					if ($p >= 0)
						$s .= '+'.$p;
					else
						$s .= '-'.(-$p);
					return $s;
		}
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	// Codage d'une chaîne (courte) avec String.fromCharCode. La chaîne attendue est entre apostrophes.
	// Doit accepter une chaîne vide entre apostrophes.
	// Exemples : 'coucou' -> String.fromCharCode(99,111,117,99,111,117)
	//            ''       -> String.fromcharCode()
	// vérifiée OK
	function fromcharcode($s)
	{
		// Supprime les '', puis découpe la chaîne en un tableau de codes de caractères.
		$listecar = array_map('ord', $this->str_split_php4($this->decortique($s)));

		// Applique à tous ces codes la méthode "complique".
		$listecar = array_map(array($this, 'complique'), $listecar);

		// Recolle les morceaux et ajoute un appel à String.fromCharCode.
		return 'String.fromCharCode('.implode(',',$listecar).')';
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	// $a est un tableau d'un élément, passé par la fonction brouille_JS()
	// Cet élément $s est une chaîne JS entre apostrophes ''.
	// Cette fonction insère des caractères aléatoires inutiles dans cette chaîne, + une instruction replace pour les supprimer.
	// Attention la chaîne peut contenir des caractères unicode avec \u.... ou \x..
	// Dans ce cas on ne doit rien insérer entre le \ , le u et les chiffres qui suivent.
	// C'est toute la difficulté de cette fonction.
	// vérifiée OK
	function brouille_chaine($a) {
		$s = $a[0];
		if (strlen($s) < 5) return $this->fromcharcode($s);             // $s doit faire au moins 3 caractères + les guillemets

		// Tableau de boolean qui indique, pour chaque position dans $s, si on peut (true)
		// ou pas (false) insérer un caractère juste après. La longueur de ce tableau est strlen($s)-1.
		//  Un . veut dire qu'on peut insérer un caractère juste après, un x veut dire que non.
		//  'abc'       '\u0064abc'      '\x64abc'   'a\\x40'  'a\\\x40'   'a\\\\x40'
		//  ....        .xxxxx....       .xxx....    ..x....   ..x.xxx.    ..x.x....
		// On peut toujours insérer après l'apostrophe du début, donc la première valeur est true.
		$position_autorisee = array(true);
		$nb_autorisees = 0;				// Nombre de positions où on peut insérer qqch.

		// Automate qui parcourt la chaîne, détecte les caractères unicode \u.... et \x..  ,
		// construit le tableau $position_autorisee et décode les \u et \x dans $s_clair.
		// états :
		//		0 : pas de problème, insertion autorisée après ce caractère.
		//		1 : après un anti-slash, insertion interdite
		$s_clair = "";
		$state = 0;
		for($i = 1; $i < strlen($s)-1; $i++)
			switch($state) {
				case 0 :
					if($s{$i} == '\\') {
						$position_autorisee[$i] = false;
						$state = 1;
					}
					else {
						$s_clair .= $s{$i};
						$position_autorisee[$i] = true;
						$nb_autorisees++;
					}
					break;
				case 1 :
					switch($s{$i}) {
						case 'u' :
							$s_clair .= chr(intval(substr($s, $i+1, 4), 16));
							for($j = 0; $j < 4; $j++, $i++) $position_autorisee[$i] = false;
							break;
						case 'x' :
							$s_clair .= chr(intval(substr($s, $i+1, 2), 16));
							for($j = 0; $j < 2; $j++, $i++) $position_autorisee[$i] = false;
							break;
					}
					// Fin d'un caractère spécial utilisant l'anti-slash. Ignoré dans $s_clair.
					$position_autorisee[$i] = true;
					$nb_autorisees++;
					$state = 0;
			}

		// Choisit un caractère dans $listecar qui n'est pas dans la chaîne $s.
		$c = $this->choisit_caractere($this->listecar, $this->str_split_php4($s_clair));	// caractère choisi

		// Si c'est impossible, tant pis on n'ajoute rien à la chaîne $s.
		if($c === null) return $s;

		// On va insérer de 2 à 5 fois ce caractère.
		$nb_insertions = rand(2, 5);
		$pos = 0;
		for($i = 0; $i < $nb_insertions; $i++) {
			do { $pos = rand(0, strlen($s)-2); } while (!$position_autorisee[$pos]);
			$s = substr($s, 0, $pos+1) . $c . substr($s, $pos+1);
			array_splice($position_autorisee, $pos, 0, true);
		}
	
		// On choisit une façon d'exprimer la chaîne nulle (sans apostrophes, c'est important).
		$nulle = "";
		switch ($this->h(3))
		{
			case 0 : $nulle = '""'; break;
			case 1 : $nulle = '[""][0]'; break;
			case 2 : $nulle = '"'.chr(65+rand(0,26)).'".substr(1)'; break;
		}
		
		return $s.".replace(/".$c.'/g,'.$nulle.')';
	}

	
	// La chaîne d'entrée s représente une expression javascript valide, en principe composée de plusieurs
	// chaînes entre apostrophes, séparées par des instructions.
	// Cette fonction parcourt cette expression, en extrait les chaînes de caractères entre '' (pas "")
	// et appelle brouille_chaine() qui insère des caractères aléatoires dans ces chaînes.
	//     _______________
	// ___/               \__________________________________________________
	//
	// vérifiée OK
	function brouille_JS($s)
	{
		return preg_replace_callback("/'(?:\\\\[\\\\'\"]|[^'])*'/", array($this, 'brouille_chaine'), $s);
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	// Transforme du texte en une chaîne javascript : échappe certains caractères, remplace les retours à la ligne par des espaces et ajoute les apostrophes.
	// vérifiée OK
	function to_JS_string($s)
	{
		return "'" . addslashes(preg_replace("/[\r\n]/", " ", $s)) . "'";
	}

	//     _______________
	// ___/               \__________________________________________________
	//
	// Source : http://fr.php.net/manual/fr/function.str-split.php
	function str_split_php4($text,$split=1)
	{
		if (!is_string($text)) return false;
		if (!is_numeric($split) && $split < 1) return false;
		$len = strlen($text);
		$array = array();
		$i = 0;
		while ($i < $len)
		{
			$key = NULL;
			for ($j = 0; $j < $split; $j += 1)
			{
				$key .= $text{$i};
				$i += 1;   
			}
			$array[] = $key;
		}
		return $array;
	}

	//     _______________
	// ___/               \__________________________________________________
	//
	// Créee un nouveau nom de variable pour le script.
	// vérifiée OK
	function variable()
	{
		// On boucle tant que le nom généré est déjà utilisé.
		do {
			$name = $this->caractere_aleatoire($this->premier_caractere)
					. $this->caractere_aleatoire($this->second_caractere);
		} while (isset($this->liste_des_variables[$name]));

		// On stocke ce nouveau nom dans la liste des variables.
		$this->liste_des_variables[$name] = true;
		return $name;
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	function chiffre($s,$force=NULL)
	{
		if (is_null($force))
		{
			do {
				$num_chiffre = $this->h(5);
			}
			while (	(($this->nb_retournements > 0) && ($num_chiffre == 0)) ||   // 1 retournement maximum (car 2 retournements s'annulent)
					(($this->passes <= 2)          && ($num_chiffre == 4)) ||   // hexa seulement pour les fous, trop long
					(($this->nb_base64        > 0) && ($num_chiffre == 3)));    // et 1 base64 maximum (question de longueur)
		} else {
			$num_chiffre = $force;
		}

		switch ($num_chiffre)
		{
			// ----------
			// Retournement par blocs de longueur aléatoire. (107 octets + la chaîne codée)
			case 0:
				$this->nb_retournements++;
				$taille = 20 + $this->h(31);
				$code = '';
				for ($i=0; $i<strlen($s); $i+=$taille)
				{
					$code .= strrev(substr($s,$i,$taille));
				}
				$s = $this->variable();
				$d = $this->variable();
				$i = $this->variable();
				$r = '';
				$r .= 'var '.$s.'="';
				$r .= addslashes($code).'";'.$d.'="";'.'for(var '.$i.'=0;'.$i.'<'.$s.'.length;'.$i.'+='.$taille.')'.$d.'+='.$s.'.substr('.$i.','.$taille;
				$r .= ').split("").reverse().join("");eval('.$d.')';
				return $r;
			break;
			
			// ----------
			// Permutation de blocs de 1 à 3 caractères. (46 octets + la chaîne codée)
			case 1:
				$n1 = 1 + $this->h(3);			// nombre de caractères du 1er bloc
				$n2 = 1 + $this->h(3);			// nombre de caractères du 2ème bloc
				$n = $n1 + $n2;
				$padding = strlen($s) % $n;
				$s = substr('000000',0,$padding).$s;
				$re = '(.{'.$n1.'})(.{'.$n2.'})';
				$re1 = substr('...',0,$n1);
				$re2 = substr('...',0,$n2);
				$code = 'eval('.$this->to_JS_string(preg_replace("/$re/",'$2$1',$s)).'.replace(/('.$re2.')('.$re1.')/g,"$2$1")';
				if ($padding) $code .= '.substr('.$padding.')';
				$code .= ')';
				return $code;
			break;
			
			// ----------
			// Rotation de caractères (?? octets + la chaîne codée)
			// ROT-1 à ROT-43 sur les caractères 32 à 126.
			case 2:
				$s2 = '';
				for ($i=0; $i<strlen($s); $i++)		// Conversion des caractères > 126 ou < 32
				{
					if ((ord(substr($s,$i,1))>126) || (ord(substr($s,$i,1))<32))
					{
						//n.toString(16); -> base_convert($n,10,16);
						$a = ord(substr($s,$i,1));
						$s2 .= '\\x'.base_convert($a,10,16);
					} else {
						$s2 .= $s[$i];
					}
				}
				$s = $s2;
				$co = '';
				$n = $this->h(43)+1;
				for ($i=0; $i<strlen($s); $i++)
				{
					//String.fromCharCode(65+Math.random()*26) -> chr(65+rand(0,26))
					$co .= chr(((ord(substr($s,$i,1))-32+$n)%95)+32);
				}
				$d = $this->variable();
				$i = $this->variable();
				$v = 'var '.$d.'="";for(var '.$i.'=0;'.$i.'<'.strlen($s).';'.$i.'++)'.$d;
				$v .= '+=String.fromCharCode(("'.addslashes($co).'".charCodeAt('.$i.')-(';
				$v .= $this->complique($n).')+'.$this->complique(63);
				$v .= ')%('.$this->complique(95).')+'.$this->complique(32).');eval('.$d.')';
				return $v;
			break;
			
			// ----------
			// Base64 (avec une table différente à chaque fois) (4/3 de la chaîne + 248 octets !)
			case 3:
				$this->nb_base64++;
				$bits = 0;
				$l = strlen($s);
				$txt = '';									// texte codé en base64
				$padding = (3-(strlen($s) % 3)) % 3;		// Cas où la taille ne serait pas multiple de 3.
				$s .= substr('  ',0,$padding);
				$this->base64 = str_shuffle($this->base64);
				for ($i=0; $i<strlen($s); $i+=3)
				{
					$bits = ord(substr($s,$i,1)) << 16 | ord(substr($s,$i+1,1)) << 8 | ord(substr($s,$i+2,1));
					$txt .= $this->base64[($bits >> 18) & 63].$this->base64[($bits >> 12) & 63].
							$this->base64[($bits >> 6)  & 63].$this->base64[($bits >> 0)  & 63];
				}
				if ($padding)
					$txt = substr($txt,0,strlen($txt)-$padding).substr(($this->base64[0].$this->base64[0]),0,$padding); // Complète avec des #
				$t=$this->variable();
				$d=$this->variable();
				$b=$this->variable();
				$s=$this->variable();
				$i=$this->variable();
				$v = 'var '.$t.'="'.$this->base64.'",'.$d.'="",'.$b.','.$s.'="'.$txt.'";';
				$v .= 'for(var '.$i.'=0;'.$i.'<'.strlen($txt).';'.$i.'+=4){'.$b.'=('.$t.'.indexOf('.$s.'.charAt('.$i;
				$v .= '))<<18)|'.'('.$t.'.indexOf('.$s.'.charAt('.$i.'+1))<<12)|('.$t.'.indexOf('.$s.'.charAt('.$i;
				$v .= '+2))<<6)|'.$t.'.indexOf('.$s.'.charAt('.$i.'+3));';
				$v .= $d.'+=String.fromCharCode('.$b.'>>>16,('.$b.'>>>8)&255,'.$b.'&255)};eval('.$d.'.substr(0,'.$l.'))';
				return $v;
			break;
			
			// ----------
			// Hexadécimal
			// Codage +/- abandonné car trop long : il multiplie au moins par 2 la taille du code entré.
			case 4:
				$co = '';
				for ($i=0; $i<strlen($s); $i++)
				{
					$c = ord(substr($s,$i,1));
					$c = base_convert($c,10,16);
					if (strlen($c)==1) $c = '0'.$c;
					$co .= $c;
				}
				$v = 'var d="";for(var i=0;i<'.strlen($co).';i+=2)d+=String.fromCharCode(parseInt("'.$co.'".substr(i,2),16));eval(d)';
				return $v;
			break;
		}
	}
	
	
	
	//============ Différentes façons de créér un lien en javascript
	//     _______________
	// ___/               \__________________________________________________
	//
	function cree_lien_JS($a, $t) {
		// Éventuellement, dans le sujet on filtre les apostrophes, les guillemets et les antislashes.
		// Les guillemets sont interdits à cause qu'ils sont utilisés dans la balise href="", quant à
		// l'apostrophe c'est parce qu'après ça complique sévèrement le brouillage (l'apostrophe sert
		// de délimiteur de chaînes, et c'est plus chiant s'il y en a aussi dans les chaînes).
		$sujet = '';
		if (!empty($this->subject))
		{
			$v = $this->subject;
			$v = str_replace("'",'%27',$v);
			$v = str_replace('"','%22',$v);
			$v = str_replace('\\','%5c',$v);
			$sujet = '?Subject='.$v;
		}
		$css = '';
		if (!empty($this->cssClassName))
		{
			$css = ' class="'.$this->cssClassName.'"';
		}
		$adresse = $this->code_arrobas_point_JS("'".$a."'");
		$v = '\'<a href="" onmouseover="this.href=\\\'mailto:\'+'.$adresse.'+\''.$sujet.
			'\\\'" onmouseout="this.href=\\\'\\\'"'.$css.'>'.$this->code_arrobas_point_HTML($t).'</a>\'';
		return $v;
	}
	
	
	//========= Réalise le codage
	//     _______________
	// ___/               \__________________________________________________
	//
	function xhtml_embed($js) {
	    if (!$js) return '';
	    return '<script type="text/javascript">'."\n"
	    		.'//<![CDATA['."\n"
	    		.$js."\n"
	    		.'//]]>'."\n"
	    		.'</script>';
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	function html_embed($js) {
	    if (!$js) return '';
	    return '<script type="text/javascript" language="javascript">'."\n"
	    		.'<!--'."\n"
	    		.$js."\n"
	    		.'//-->'."\n"
	    		.'</script>';
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	function is_xhtml()
	{
		if ($this->coding=='xhtml')	return true;
		else						return false;
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	function embed($js)
	{
	    if ($this->is_xhtml())	return $this->xhtml_embed($js);
	    else					return $this->html_embed($js);
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	function code_moi_tout_ca($s)
	{
		$code = $this->brouille_JS($s);
		for ($i=0; $i<$this->passes-1; $i++)
		{
			$code = $this->chiffre($code);
		}
		// La dernière passe se fait obligatoirement en rotation
		$code = $this->chiffre($code, 2);
		$code = preg_replace('/eval\(([^)]+)\)/','document.write(eval($1))',$code);
		return $code;
	}
	
	
	//     _______________
	// ___/               \__________________________________________________
	//
	function init_encode()
	{
	    $this->nb_retournements = 0;
	    $this->nb_base64 = 0;
	    $this->liste_des_variables = array();          // Ne pas oublier de réinitialiser la liste des variables à chaque fois !
		$this->errCode = null;
		$this->errStrings = array();
	}
	
	
	
	// Sorte de contrôle qualité en post-production : si le JS n'est pas correct, on rennvoie false, ce qui
	// déclenchera la génération d'un nouveau script.
	// On teste la présence de certains codes qui pourraient être mal interprétés.
	//     _______________
	// ___/               \__________________________________________________
	//
	function dernierControleJS($js_a_tester)
	{
		// "< ?" ferait tout merder s'il apparaissait dans une page en php.
		return (strpos($js_a_tester, '<?') === false);
	}
	
	
	
	//========= Déclenche la création du code HTML ou du script
	//     _______________
	// ___/               \__________________________________________________
	//
	function encode($a='',$t='')
	{
		if(!$a) return '';
		if(!$t) $t = $a;		// If no link text is provided, the address is used.
		do {
  			$this->init_encode();
			$source = '';
			if (strpos($t,'\\') !== false)
			{
				$this->alert(6);
				return '';
			}
			if ((strpos($t,'@') !== false) && (!empty($this->subject) || ($t!=$a)))
			{
				$this->alert(5);
			}
			$t = str_replace("'", "\'", $t);
			if (!empty($t))	$source = $this->cree_lien_JS($a, $t);						// lien
			else			$source = $this->code_arrobas_point_JS($this->to_JS_string($a));	// texte sans lien
			$this->emailencoded = $this->code_moi_tout_ca($source);
		} while (!$this->dernierControleJS($this->emailencoded));
		return $this->embed($this->emailencoded);
	}
	
	
	
	//========= Déclenche la création du script
	//     _______________
	// ___/               \__________________________________________________
	//
	function encode2($source='')
	{											// $source : code HTML à chiffrer.
		if(!$source) return '';
		do {
			$this->init_encode();
			$s = strtolower($source);
			if (strpos($s,'<meta') !== false)
			{
				$this->alert(2);
				return '';
			}
			if (strpos($s,'<link') !== false)
			{
				$this->alert(3);
				return '';
			}
			if (strpos($s,'<script') !== false)
			{
				$this->alert(4);
				// On essaye quand-même, en enlevant les balises de commentaires.
				$source = preg_replace("/<!--[\n\r]+/",'',$source);
				$source = preg_replace("/[\n\r]+\/\/-->/",'',$source);
				$source = preg_replace("/\/\/<!\[CDATA\[[\n\r]+/",'',$source);
				$source = preg_replace("/[\n\r]+\/\/\]\]>/",'',$source);
			}
			if ((strpos($s,'<a ') !== false) && (strpos($s,'mailto:') !== false))
			{
				// Corrige les liens paramètres sans guillemets
				$source = preg_replace('/href=([^"\'][^" >]+)/i','href="$1"',$source);
				// Détecte un lien href (sans antislash)
				$regex_param_single = "'([^']*)'";
				$regex_param_double = '"([^"]*)"';
				$regex_param = "$regex_param_double|$regex_param_single";
				$regex_href = "/href=($regex_param)/i";
				$regex_over = "/onmouseover=($regex_param)/i";
				$regex_out  = "/onmouseout=($regex_param)/i";
				$matches = array();
				if(preg_match($regex_href, $source, $matches) > 0) {
					// On supprime le lien href, et on crée ou on complète onmouseover et oumouseout.
					$over = "onmouseover=\"this.href='$matches[2]';";
					$out  = "onmouseout=\"this.href='';";
					if(preg_match($regex_over, $source, $matches)) {
						$over .= $matches[2];
						$source = preg_replace($regex_over, '', $source);
					}
					if(preg_match($regex_out, $source, $matches)) {
						$out .= $matches[2];
						$source = preg_replace($regex_out, '', $source);
					}
					$source = preg_replace($regex_href, "href=\"\" $over\" $out\"", $source);
				}
			}
			// Ensuite seulement on code.
			$this->htmlencoded = $this->code_moi_tout_ca($this->code_arrobas_point_JS($this->to_JS_string($source)));
		} while (!$this->dernierControleJS($this->htmlencoded));
		return $this->embed($this->htmlencoded);
	}
}



/*
 * CHANGELOG
 * ---------
 *
 *	@dateN		2007-12-27
 *	@version	0.2
 *	@auteur		François Pirsch
 *	@comment	bug corrected : sometimes too many zeroes were inserted in encodings like &#x0002e; (IE accepts only 4 zeroes)
 *
 *	@dateN		2007-11-03
 *	@version	0.1.1
 *	@auteur		François Pirsch
 *	@comment	bug corrected : a white space was inserted before and after each encoded address
 *
 *	@dateN		2007-07-05
 *	@version	0.1.0
 *	@auteur		[Php adaptation] Philippe
 *	@comment	- Writing this class, Php adaptation of js script written by François Pirsch
 *
 */
?>