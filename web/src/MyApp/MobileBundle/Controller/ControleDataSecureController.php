<?php
namespace MyApp\MobileBundle\Controller;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * 
 * @author leonardc
 * 
 * Contrôle la validité des données soumissent par formulaire pour les éditeurs de texte.
 * 
 * Vérifie le rôle de la personne qui accède à l'admin.
 * 
 * Remplace la virgule par un point pour les coordonnées latitude et longitude.
 * EX: -1,5448 -> -1.5448
 * 
 * Ajoute un espace au milieu dans le code postal et retourne le code en masjuscule.
 * EX: g2k1a7 -> G2K 1A7
 * 
 * Contrôle que deux chiffres où deux nombre ne se retrouvent pas en double pour les aléatoire dans les suggestions.
 * 
 * Contrôle les premières lettres de la région pour placer devant le bon article
 * 
 * Contrôle la valeur passée à la pagination
 * 
 * Contrôle les valeurs valeurs des moteurs de recherche coté admin
 */
class ControleDataSecureController extends Controller {
	
	
	/**
	 * Contrôle le contenu des éditeurs CKE valide et retourne au controller les données
	 * 
	 */
	public function getSecureData($text)
	{
		/*$tab = ["<?php>", "<php", "<?", "?>", "<script>", "</script>", "select", "SELECT", "INSERT", "insert", "UPDATE", "update", "DELETE", "delete", "root", "*", "%", ";", "{", "}", "[", "]", "$"];
		$text = str_replace($tab, " ", $text);*/		
		return $text;
	}
        
        /**
         * Contrôle les noms des répertoires pour la création ou l'édition des clients
         */
        public function valideNomRepertoire($repertoire)
        {
            $tabValidation = ["à", "é", "è", "ê", "ô", "î", "ù", "ç", "â", "ï", "ë"];
            $tabRemplace = ["a", "e", "e", "e", "o", "i", "u", "c", "a", "i", "e"];  
            $repertoire  = str_replace($tabValidation, $tabRemplace, $repertoire);
            return $repertoire;
        }
	
	/**
	 * Contrôle le rôle de la personne connecter pour déterminer ses droits dans la gestion
	 */
	public function getValidRoles($user)
	{	
		//On reçoit l'objet $user on le tri pour récupérer ron role (admin, user, super_admin)
		foreach($user->getRoles() as $role){
			$tab = array($role);
			if(in_array("ROLE_SUPER_ADMIN", $tab))
				return "ROLE_SUPER_ADMIN" ;
			elseif(in_array("ROLE_ADMIN", $tab) )
				return "ROLE_ADMIN" ;
			elseif(in_array("ROLE_USER", $tab) )
				return "ROLE_USER" ;
			else
				return "Inconnu";
		}
	}               
	
	/**
	 * Contrôle les valeurs GPS pour enlever la virgule et la remplacer par un point pour le fonctionnement de l'API Google Map.
	 */
	public function getFormatValueGps($gps)
	{
		//On remplace la virgule par un point.
		$gps = str_ireplace(',', '.', $gps);
		return $gps;
	}
	
	/**
	 * Ajoute un espace au milieu dans le code postal
	 */
	public function getCodePostalAddSpace($codepostal)
	{
		$milieu = strlen($codepostal);
		$space = " ";
		if($milieu == 7)//Si on a 7 caractères on enlève le 4 caractère que l'on remplace par un espace et on remet en masjuscule.
		{
			$tr = substr($codepostal, 3,-3);
			return strtoupper(str_replace($tr, $space, $codepostal));
		}
		if($milieu == 6)//Si on a 6 caractères on sépare le code postal en deux et concatène avec un espace au milieu et on remet en masjuscule.
		{
			$debut = substr($codepostal, 0, 3);
			$fin = substr($codepostal, 3,6);
			return strtoupper($debut.$space.$fin);
		}
	}
	
	/**
	 * Contrôle que deux chiffres où deux nombres ne se retrouvent pas en double pour tout ce qui est des suggestions
	 */
	public function getCompareNumerique($val1, $val2, $val3, $val4)
	{
		if($val1 == $val2)
		{
			if($val2 == 1)
			 	$val2 = $val2 * 2;
			else
				$val2 = ceil($val2 / 2);
		}
		if($val1 == $val3)
		{
			if($val3 == 1)					// pour la valeur 1
				$val3 = $val3 * 2;
			else
				$val3 = ceil($val3 / 2);
		}
		if($val1 == $val4)
		{
			if($val4 == 1)
				$val4 = $val4 * 2;
			else
				$val4 = ceil($val4 / 2);
		}
		if($val2 == $val3)
		{
			if($val3 == 1)					// pour la valeur 2
				$val3 = $val3 * 2;
			else
				$val3 = ceil($val3 / 2);
		}
		if($val2 == $val4)
		{
			if($val4 == 1)
				$val4 = $val4 * 2;
			else
				$val4 = ceil($val4 / 2);
		}
		if($val4 == $val3)
		{
			if($val3 == 1)					// pour la valeur 4
				$val3 = $val3 * 2;
			else
				$val3 = ceil($val3 / 2);
		}
		if($val1 == $val2 or $val1 == $val3 or $val1 == $val4 or $val2 == $val3 or $val2 == $val4 or $val3 == $val4)
		{
			$i = 0;
			while($i < 1000){
				
				if($val1 == $val2)
				{
					if($val2 == 1)
						$val2 = $val2 * 2;
					else
						$val2 = ceil($val2 / 2);
				}
				if($val1 == $val3)
				{
					if($val3 == 1)					// pour la valeur 1
						$val3 = $val3 * 2;
					else
						$val3 = ceil($val3 / 2);
				}
				if($val1 == $val4)
				{
					if($val4 == 1)
						$val4 = $val4 * 2;
					else
						$val4 = ceil($val4 / 2);
				}
				if($val2 == $val3)
				{
					if($val3 == 1)					// pour la valeur 2
						$val3 = $val3 * 2;
					else
						$val3 = ceil($val3 / 2);
				}
				if($val2 == $val4)
				{
					if($val4 == 1)
						$val4 = $val4 * 2;
					else
						$val4 = ceil($val4 / 2);
				}
				if($val4 == $val3)
				{
					if($val3 == 1)					// pour la valeur 4
						$val3 = $val3 * 2;
					else
						$val3 = ceil($val3 / 2);
				}
				if($val1 != $val2 and $val1 != $val3 and $val1 != $val4 and $val2 != $val3 and $val2 != $val4 and $val3 != $val4){
					break;
				}
				$i++;
			}	
		}
		//On déclare un tableau pour stocker et passer les valeurs
		$tab = array();
		array_push($tab, (int)$val1, (int)$val2, (int)$val3, (int)$val4);
		return $tab;
	}
	
	/**
	 * Valide la valeur passé pour la pagination
	 */
	public function getValideEntierPagination($page, $displaypage)
	{
		if(isset($page) and is_numeric($page) == 1)
			if($page > $displaypage)
				$page = $displaypage;
			elseif($page <= 0)
				$page = 1;
			else
				$page;
		else
			$page = 1;
		//Renvoie la valeur nettoyée
		return $page;
	}
	
	/**
	 * Controle l'entier pour la pagination dans les methodes pour l'update
	 */
	public function getValideIntMethodeUpdate($int)
	{
		 is_numeric($int)? $int : $int = 2;
		 if($int <= 0)
		 {
		 	$int = 2;
		 }
		 return $int;
	}
	
	
	/**
	 * Fonction qui valide le nom géographique (Province, région, zone ou encore ville)
	 */
	public function getCleanNameGeography($nameGeo, $index)
	{
		$tab = array( '/', '"', '""', '--', ';', '$', '%', '<', '>', '!', '=', '*', '!=', '==', 'FROM ', 'from ', 'select ', 'SELECT ', 'GRANT ', 'grant ', 'SHOW ', 'show ', 'LIKE ', 'like ', 'insert ', 'INSERT ', 'delete ', 'DELETE ', 'update ', 'UPDATE ');
		if($index == "province"){
			$nameGeo = str_replace($tab, '', $nameGeo);
			$text = trim($nameGeo);
			$text = addslashes($text);
			$text = quotemeta($text);
			$text = strip_tags($text);
			//$text = htmlentities($text);
			if($text != "" )
			{
				if(strlen($text) >= 3)
				{
					$text;
				}
				else
				{
					$text = "Québec";
				}
			}
			else
			{
				$text = "Québec";
			}
		}
		if($index == "region"){
			$nameGeo = str_replace($tab, '', $nameGeo);
			$text = trim($nameGeo);
			$text = addslashes($text);
			$text = quotemeta($text);
			$text = strip_tags($text);
			//$text = htmlentities($text);
			if($text != "" )
			{
				if(strlen($text) >= 3)
				{
					$text;
				}
				else
				{
					$text = "Québec";
				}
			}
			else
			{
				$text = "Québec";
			}
		}
		if($index == "nomRestaurant"){
			$nameGeo = str_replace($tab, '', $nameGeo);
			$text = trim($nameGeo);
			$text = addslashes($text);
			$text = quotemeta($text);
			$text = strip_tags($text);
			//$text = htmlentities($text);
			if($text != "" )
			{
				if(strlen($text) >= 3)
				{
					$text;
				}
				else
				{
					$text = "Restaurant";
				}
			}
			else
			{
				$text = "Restaurant";
			}
		}
		if($index == "cuisine"){
			$nameGeo = str_replace($tab, '', $nameGeo);
			$text = trim($nameGeo);
			$text = addslashes($text);
			$text = quotemeta($text);
			$text = strip_tags($text);
			//$text = htmlentities($text);
			if($text != "" )
			{
				if(strlen($text) >= 3)
				{
					$text;
				}
				else
				{
					$text = "Français";
				}
			}
			else
			{
				$text = "Français";
			}
		}
		if($index == "name"){
			$nameGeo = str_replace($tab, '', $nameGeo);
			$text = trim($nameGeo);
			$text = addslashes($text);
			$text = quotemeta($text);
			$text = strip_tags($text);
			//$text = htmlentities($text);
			if($text == "" )
			{
				$text = trigger_error("Sorry information was not found");
			}
			
		}
		return $text;	
	}
	
	/**
	 * Génère une liste de nombres et chiffres uniques pour créer les clients de nos suggestions
	 */
	public function getGenereListClientPourNosSuggestions($tablo)
	{
		$r1 = array_rand($tablo);
		$r2 = array_rand($tablo);
		$r3 = array_rand($tablo);
		$r4 = array_rand($tablo);
		$r5 = array_rand($tablo);
		$long = count($tablo);
		if($long == 2){
			if($r1 == $r2)
			{
				if($r2 == 1)
					$r2 = ceil($r2 / 2);
			}
		}
		else{
			if($r1 == $r2 or $r1 == $r3 or $r1 == $r4 or $r1 == $r5 or $r2 == $r3 or $r2 == $r4 or $r2 == $r5 or $r3 == $r4 or $r3 == $r5 or $r4 == $r5)
			{
				$i = 0;
				while($i < 1000){
					
					if($r1 == $r2)
					{
						if($r2 == 1)
							$r2 = $r2 * 2;
						else
							$r2 = ceil($r2 / 2);
					}
					if($r1 == $r3)
					{
						if($r3 == 1)					// pour la valeur 1
							$r3 = $r3 * 2;
						else
							$r3 = ceil($r3 / 2);
					}
					if($r1 == $r4)
					{
						if($r4 == 1)
							$r4 = $r4 * 2;
						else
							$r4 = ceil($r4 / 2);
					}
					if($r1 == $r5)
					{
						if($r5 == 1)
							$r5 = $r5 * 2;
						else
							$r5 = ceil($r5 / 2);
					}
					if($r2 == $r3)
					{
						if($r3 == 1)					// pour la valeur 2
							$r3 = $r3 * 2;
						else
							$r3 = ceil($r3 / 2);
					}
					if($r2 == $r4)
					{
						if($r4 == 1)
							$r4 = $r4 * 2;
						else
							$r4 = ceil($r4 / 2);
					}
					if($r2 == $r5)
					{
						if($r5 == 1)
							$r5 = $r5 * 2;
						else
							$r5 = ceil($r5 / 2);
					}
					if($r3 == $r4)
					{
						if($r4 == 1)					// pour la valeur 3
							$r4 = $r4 * 2;
						else
							$r4 = ceil($r4 / 2);
					}
					if($r3 == $r5)
					{
						if($r5 == 1)					
							$r5 = $r5 * 2;
						else
							$r5 = ceil($r5 / 2);
					}
					if($r4 == $r5)
					{
						if($r5 == 1)					// pour la valeur 4
							$r5 = $r5 * 2;
						else
							$r5 = ceil($r5 / 2);
					}
					//Valide que les valeurs générées ne sont pas plus grande que le nombre d'élément dans le tableau contenant les id
					if($r1 < $long && $r2 < $long && $r3 < $long && $r4 < $long && $r5 < $long)
					{
						if($r1 != $r2 and $r1 != $r3 and $r1 != $r4 and $r1 = $r5 and $r2 != $r3 and $r2 != $r4 and $r2 != $r5 and $r3 != $r4 and $r3 != $r5 and $r4 != $r5){
							break;
						}
						else 
							$i++;
					}
					$i++;
				}
			}	
		}
		$tab = array($tablo[$r1], $tablo[$r2], $tablo[$r3], $tablo[$r4], $tablo[$r5]);
		return $tab;		
	}
	
	/**
	 * Génère une liste de nombres et chiffres uniques pour créer les 4 suggestions
	 */
	public function getGenere4ClientsPourNosSuggestions($tablo)
	{
            if(count($tablo) >= 4){
                $tab = [];
                $tab = array_rand($tablo, 4);
		$r1 = array_rand($tab);
		$r2 = array_rand($tab);
		$r3 = array_rand($tab);
		$r4 = array_rand($tab);
                    if($r1 == $r2 or $r1 == $r3 or $r1 == $r4 or $r2 == $r3 or $r2 == $r4 or $r3 == $r4 )
                    {
                            $i = 0;
                            while($i < 1000){
                                    if($r1 == $r2)
                                    {
                                            $r2 = array_rand($tablo);
                                    }
                                    if($r1 == $r3)
                                    {
                                            $r3 = array_rand($tablo);
                                    }
                                    if($r1 == $r4)
                                    {
                                            $r4 = array_rand($tablo);
                                    }
                                    if($r2 == $r3)
                                    {
                                            $r3 = array_rand($tablo);
                                    }
                                    if($r2 == $r4)
                                    {
                                            $r4 = array_rand($tablo);
                                    }
                                    if($r3 == $r4)
                                    {
                                            $r4 = array_rand($tablo);
                                    }
                                    if($r1 != $r2 and $r1 != $r3 and $r1 != $r4 and $r2 != $r3 and $r2 != $r4 and $r3 != $r4 ){
                                            break;
                                    }
                                    $i++;
                            }
                    }
		$tab = array($tablo[$r1], $tablo[$r2], $tablo[$r3], $tablo[$r4]);
            }elseif(count($tablo) == 3){
                $r1 = $tablo[0];
		$r2 = $tablo[1];
		$r3 = $tablo[2];
                if($r1 == $r2 or $r1 == $r3 or $r2 == $r3  )
                    {
                            $i = 0;
                            while($i < 1000){

                                    if($r1 == $r2)
                                    {
                                            $r2 = array_rand($tablo);
                                    }
                                    if($r1 == $r3)
                                    {
                                            $r3 = array_rand($tablo);
                                    }                          
                                    if($r2 == $r3)
                                    {
                                            $r3 = array_rand($tablo);
                                    }                      
                                    if($r1 != $r2 and $r1 != $r3 and $r2 != $r3 ){
                                            break;
                                    }
                                    $i++;
                            }
                    }
		$tab = array($tablo[$r1], $tablo[$r2], $tablo[$r3]);
            }elseif(count($tablo) == 2){
                $r1 = $tablo[0];
		$r2 = $tablo[1];
                if($r1 == $r2 )
                    {
                            $i = 0;
                            while($i < 1000){

                                    if($r1 == $r2)
                                    {
                                            $r2 = array_rand($tablo);
                                    }                          
                                    if($r1 != $r2 ){
                                            break;
                                    }
                                    $i++;
                            }
                    }
		$tab = array($tablo[$r1], $tablo[$r2]);
            }else{
                $tab = array($tablo[0]);
            }
            return $tab;
	}
	
	/**
	 * Fonction qui contrôle la valeur transmise par les moteurs de recherche dans l'admin
	 */
	public function getSearchEngineAdmin($text)
	{
			$tab = array( '/', '"', '""', '--', ';', '$', '%', '<', '>', '!', '=', '*', '!=', '==', 'FROM', 'from', 'select', 'SELECT', 'GRANT', 'grant', 'SHOW', 'show', 'LIKE', 'like');
			$text = str_replace($tab, '', $text);
			$text = trim($text);
			$text = quotemeta($text);
			$text = strip_tags($text);
			return $text;
	}
	
	/**
	 * Vérifie si on a un entier en paramêtre
	 */
	public function getValidInteger($id)
	{
		$id = (integer) $id;
		(is_numeric($id) ==  true)? $id : trigger_error("Failure value is not an integer");
		return $id;
	}
	
	/**
	 * Valide si le client a des textes résumés sinon traite les textes descriptifs 
	 */
	public function getValideTexteResumeEtTexteDescriptif( $client)
	{
		$tab = [];
		if($client[0]->getTexteDescriptionFr() != null){
			array_push($tab, str_replace(array("\r\n"), " ", html_entity_decode( $client[0]->getTexteDescriptionFr())));
		}
		if($client[0]->getTexteDescriptionEn() != null){
			array_push($tab, str_replace(array("\r\n"), " ", html_entity_decode( $client[0]->getTexteDescriptionEn())));
		}
		return $tab;
	}
	
	/**
	 * Néttoyage du prix
	 */
	public function getCleanPrice($prix)
	{
		$prixclean = str_replace("$", "", $prix);
		$prixclean = trim($prixclean);
		$prixclean = str_replace(",", ".", $prixclean);
		(is_numeric($prixclean) == true)? $prixclean: $prixclean = null;
		return $prixclean;
	}
	
}