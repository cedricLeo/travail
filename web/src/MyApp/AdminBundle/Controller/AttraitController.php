<?php
namespace MyApp\AdminBundle\Controller;
use MyApp\GlobalBundle\Entity\Galery;
use MyApp\GlobalBundle\Entity\Provinces_etats;
use Symfony\Component\Validator\Constraints\All;
use MyApp\GlobalBundle\Entity\Temporaire_attraits;
use Doctrine\ORM\Mapping\Entity;
use MyApp\AdminBundle\Forms\AddClientForm;
use MyApp\GlobalBundle\Entity\Videos;
use MyApp\AdminBundle\MyAppAdminBundle;
use MyApp\GlobalBundle\MyAppGlobalBundle;
use MyApp\AdminBundle\Forms\AddAttraits_photosForm;
use MyApp\GlobalBundle\Entity\Attraits_photos;
use MyApp\AdminBundle\Forms\AddSoinSanteForm;
use MyApp\GlobalBundle\Entity\Soins_sante;
use MyApp\AdminBundle\Forms\AddTypesSoinsForm;
use MyApp\GlobalBundle\Entity\Types_soins_sante;
use MyApp\AdminBundle\Forms\AddCuisinesForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_AttraitForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\GlobalBundle\Controller\ControleDataSecureController;
use MyApp\GlobalBundle\Entity\Attraits_categories;
use MyApp\GlobalBundle\Entity\Attraits_sous_categories;
use MyApp\GlobalBundle\Entity\Attraits_activites;
use MyApp\GlobalBundle\Entity\Attraits_services;
use MyApp\GlobalBundle\Entity\Attraits;
use MyApp\AdminBundle\Forms\CategorieAttraitForm;
use MyApp\AdminBundle\Forms\SousCategorieAttraitForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_attraits_activitesForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_attraits_servicesForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_hebergementForm;
use MyApp\AdminBundle\Forms\AttraitsServiceForm;
use MyApp\AdminBundle\Forms\AttraitsActiviteForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_categorie_attraitForm;
use MyApp\AdminBundle\Forms\AttraitForm; 
use MyApp\GlobalBundle\Entity\Cuisines;
use MyApp\AdminBundle\Forms\AddCuisinesFrom;
use JMS\SecurityExtraBundle\Annotation\Secure;
use MyApp\GlobalBundle\Entity\OptionUtilisateur;
use MyApp\GlobalBundle\Entity\Utilisateur;
use MyApp\GlobalBundle\Entity\Villes;
use MyApp\GlobalBundle\Entity\Textes_attrait_fr;
use MyApp\GlobalBundle\Entity\Textes_attrait_en;

/**
 * @author leonardc
 * 
 * Classe pour la gestion coté administration des actions affichage, ajout, modification et suppréssion pour:
 * 
 * Attraits,
 * Catégories des attraits,	
 * Sous catégories,
 * Types soins santé,
 * Soins santé,
 * Activités,
 * Services,
 * Cuisines,
 * Photos
 * 
 * @Secure(roles="ROLE_SUPER_ADMIN")
 * 
 */
class AttraitController extends Controller
{
	
/*####################################################################################*/
/*############### SECTION ATTRAITS ###################################################*/
/*####################################################################################*/

	/**
	 * Page du tableau de bord pour afficher et gérer les attraits dans la partie administration.
	 */
	public function attraitAction($page, $letter)
	{
		$number = 0; //Variable qui va déterminer pour le template quel résultat afficher pour les différentes recherches.
		$numberPaginate = 30;
		$result = $result2 = $valideExisteNInterne = "";
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère le nombre d'attrait dans la table
		$nbAttrait = $em->getRepository('MyAppGlobalBundle:Attraits')->getCompteIdAttrait();
		foreach($nbAttrait as $result){
			$total = $result['nbAttrait'];
		}
		//On divise le nombre total d'attrait par le nombre que l'on souhaite afficher.
		$displaypage = ceil($total/$numberPaginate);
		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
		$page = $validRole->getValideEntierPagination($page, $displaypage);
		//Récupère la liste des attraits pour l'auto completion.
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Attraits')->getListAttrait();
		//Récupère la liste des attraits avec la pagination.
		$attrait = $em->getRepository('MyAppGlobalBundle:Attraits')->getAdminAttrait($page, $numberPaginate);
		$number = 1;
		//Moteur de recherche.
		$form = $this->container->get('form.factory')->create(new Moteur_recherche_AttraitForm());
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{	
			//On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			//Si le formulaire est valide
			foreach($form->getData() as $word)
			{
			 	$word = $validRole->getSearchEngineAdmin($word);
                                $valideExisteNInterne = is_numeric($word);
			}
			//On recherche l'attrait entré dans le moteur de recherche.
			$result = $em->getRepository('MyAppGlobalBundle:Attraits')->getSearchAttrait($word);
                        if($valideExisteNInterne == false){
                            $result = null;
                            $result = $em->getRepository('MyAppGlobalBundle:Attraits')->getSearchAttraitSansRelationUtilisateur($word);
                        }                     
                        if($valideExisteNInterne == true and $result != null){
                            $result2 = $em->getRepository("MyAppGlobalBundle:Attraits")->getRetourneAttraitAvecIdUtilisateur($result[0]['id']);
                        }
			$number = 2;
		}
		//Deuxième moteur de recherche celui la pour les catégories des attraits.
		$formCat = $this->container->get('form.factory')->create(new Moteur_recherche_categorie_attraitForm());
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			//On fait le lien Requête <-> Formulaire.
			$formCat->bindRequest($request);
			//Si le formulaire est valide.
			foreach($formCat->getData() as $category){
			 	 $category;
			}
			if($category != ""){
				//On tri les attraits par la catégorie recherchée.
				$result = $em->getRepository('MyAppGlobalBundle:Attraits')->getSortAttraitByCategory($category);
				$number = 4;
			}
		}
		//S'il existe une lettre alphabétique dans l'url.
		if($letter === 'letter'){
			$lettre = "";
		}else{
			$lettre = $em->getRepository('MyAppGlobalBundle:Attraits')->getAttraitByFirstLetter($letter);
			$number = 3;
		}
		//On force la variable number à garder la valeur 2 si besoin. 
		(isset($word))? $number = 2 : $number ;
		//Préparation de la view dashboard_categorie_hebergement_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_attrait.html.twig',
				array(
						'annee' 		   		=> date('Y'),
						'name_admin' 	   		=> $user->getUsername(),
						'pointeur' 		  		=> 'pointeur',
						'addatt' 		   		=> "menu_attrait",
						'attrait'		        => $attrait,
						'autocompletion'		=> $autocompletion,
						'form' 					=> $form->createView(),
						'formCat'				=> $formCat->createView(),
						'displaypage'			=> $displaypage,
						'nbattrait'				=> $total,
						'page'					=> $page,
						'firstpage'				=> 1,
						'lettre'				=> $lettre,
						'letter'				=> $letter,
						'result'				=> $result,
						'number'				=> $number,
						'role'					=> $role,
                                                'result2'                               => $result2,
                                                'valideExisteNInterne'                  => $valideExisteNInterne,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les attraits dans la partie administration.
	 */
	public function addAttraitAction()
	{
		gc_enable();
		$injecterole = "ROLE_ADMIN";
		//Gestionnaire d'entitiés
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'un attrait.
		$attrait = new Attraits();
		$form = $this->createForm(new AttraitForm($injecterole), $attrait);
		//Création des textes pour les attraits temporaires cela va nous servir pour la fiche client.
		$temporaireAttrait = new Temporaire_attraits();
		// On récupére la requète.
		$request = $this->get('request');
		// On vérifie qu'elle est de type << POST >>.
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
				//On enregistre la région, la zone et la ville
				$region = $_POST['listeregion'];
				$zone = $_POST['listezone'];
				$ville = $_POST['listeville'];
				$attrait->setRegionId($em->find("MyAppGlobalBundle:Regions", $region));
				$attrait->setZoneId($em->find("MyAppGlobalBundle:Zones", $zone));
				$attrait->setVilleId($em->find("MyAppGlobalBundle:Villes", $ville));
				//On valide les textes de l'éditeur
				//$txtfr = $validRole->getSecureData($form->getData()->getTexteDescriptionFr());
				//$txten = $validRole->getSecureData($form->getData()->getTexteDescriptionEn());
				// entity attraits
				//$attrait->setTexteDescriptionFr($txtfr); //Texte descriptif FR
				//$attrait->setTexteDescriptionEn($txten); //Texte descriptif EN
				$attrait->setLatitude($validRole->getFormatValueGps($form->getData()->getLatitude())); //On valide la valeur de la latitude
				$attrait->setLongitude($validRole->getFormatValueGps($form->getData()->getLongitude())); //Ici on valide la valeur pour la longitude
				$attrait->setCodePostal($validRole->getCodePostalAddSpace($form->getData()->getCodePostal())); //On vérifie le code postal
				$attrait->setDateCreation(new \DateTime("now"));
				$utilisateur = $em->find('MyAppGlobalBundle:Utilisateur', $form->getData()->getUtilisateur()->getId());
				$utilisateur->setAttraitExiste(true);		
				$em->persist($utilisateur);
				//$em->persist($attrait);
				/*foreach($attrait->getUrl1Fr() as $mov)
				{
					$em->persist($mov);
				}*/
				$em->persist($form->getData()->getLundiMatinEte());
				//On vérifie que la valeur du champ photo n'est pas vide.
				/*$img = $form->getData()->getImageDoctrine();
				if($img != null)
				{
					$attrait->setImage($img);
				}*/
				//traitement des types de soins
				$tabTypeSoinCompare = [];
				//Récupère les id des types de soin du formulaire
				foreach($form->getData()->getSoinsSanteId() as $tw){
					if($tw->getTypesSoinsSanteId() != null)
						array_push($tabTypeSoinCompare, $tw->getTypesSoinsSanteId()->getId());
				}
				$tabReturnTypeSoin = $em->getRepository("MyAppGlobalBundle:Types_soins_sante")->getReturnTableauTypeSoin($tabTypeSoinCompare, $attrait->getId());
				//persiste les nouveaux type de soins s'il y a.
				if($tabReturnTypeSoin != null){
					foreach($tabReturnTypeSoin as $ts){
						$instanceTypeSoin = $em->find("MyAppGlobalBundle:Types_soins_sante", $ts);
						$attrait->addTypes_soins_sante($instanceTypeSoin);
						$instanceTypeSoin = null;
					}
				}
				//On enregistre qui à créer l'attrait
				$attrait->setValiderPar($user->getUsername());
				$em->persist($attrait);
				$em->flush();
				//Nettoyage de la mémoire.
				gc_collect_cycles();	
				gc_disable();
				echo 'Attrait ajouté avec succés !';
				//On redirige vers la liste des attraits.
				return $this->redirect($this->generateUrl('_Dashboard_attrait'));
		}
                gc_collect_cycles();	
		//Préparation de la view dashboard_addattrait_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addattrait.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin'                       => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'addatt'			   => "menu_attrait",
						'exist' 			   => "false",
						'role'				   => $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier les attraits dans la partie adminsitration.
	 */
	public function updateAttraitAction($id, $number, $page, $lettre)
	{
		gc_enable();
		$client = "";
		$tabReturnTypeSoin = $formuCustomer = null;
		$injecterole = "ROLE_ADMIN"; 
		//On valide les arguments dans l'url
		$validRole = new ControleDataSecureController();
		$id = $validRole->getValidInteger($id);
		($number != "number")? $number = $validRole->getValidInteger($number) : $number;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$role = $validRole->getValidRoles($user);
		//Valide la valeur pour la pagination
		if($page != "page"){
			$page = $validRole->getValideIntMethodeUpdate($page);
		}
		//Récupère la catégorie à modifier.
		$attraitModif = $em->find('MyAppGlobalBundle:Attraits',$id);	
		define("OLDCUSTOMER", $attraitModif->getUtilisateur()->getId());
		//Formulaire d'ajout d'un attrait.
		$form = $this->container->get('form.factory')->create(new AttraitForm($injecterole), $attraitModif);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
				//On enregistre la région, la zone et la ville
				$region = $request->request->get("listeregion");
				$zone = $request->request->get('listezone');
				$ville = $request->request->get('listeville');
				$attraitModif->setRegionId($em->find("MyAppGlobalBundle:Regions", $region));
				$attraitModif->setZoneId($em->find("MyAppGlobalBundle:Zones", $zone));
				$attraitModif->setVilleId($em->find("MyAppGlobalBundle:Villes", $ville));
				//Si l'utilisateur est différent on met à jour les données.
				if(OLDCUSTOMER != $form->getData()->getUtilisateur()->getId()){
					$utilisateur = $em->find('MyAppGlobalBundle:Utilisateur', OLDCUSTOMER);
					$utilisateur->setAttraitExiste(false);		
					$attraitModif->getUtilisateur()->setAttraitExiste(true);
				}
				//Valide les textes descriptions FR et EN.
				/*$txtfr = $validRole->getSecureData($form->getData()->getTexteDescriptionFr());
				$txten = $validRole->getSecureData($form->getData()->getTexteDescriptionEn());
				$attraitModif->setTexteDescriptionFr($txtfr);
				$attraitModif->setTexteDescriptionEn($txten);*/
				//Ici on valide les valeurs des coordonnées gps et on remplace la virgule par un point. 
				$attraitModif->setLatitude($validRole->getFormatValueGps($form->getData()->getLatitude()));
				$attraitModif->setLongitude($validRole->getFormatValueGps($form->getData()->getLongitude()));
				//Ici on ajoute un espace au milieu du code postal
				$codePostal = $validRole->getCodePostalAddSpace($form->getData()->getCodePostal());
				$attraitModif->setCodePostal($codePostal);	
				//traitement des types de soins
				$tabTypeSoinCompare = [];
				//Récupère les id des types de soin du formulaire 				
				foreach($form->getData()->getSoinsSanteId() as $tw){
					if($tw->getTypesSoinsSanteId() != null)
						array_push($tabTypeSoinCompare, $tw->getTypesSoinsSanteId()->getId());
				}
				$tabReturnTypeSoin = $em->getRepository("MyAppGlobalBundle:Types_soins_sante")->getReturnTableauTypeSoin($tabTypeSoinCompare, $attraitModif->getId()); 
				//persiste les nouveaux type de soins s'il y a.
				if($tabReturnTypeSoin != null){
					foreach($tabReturnTypeSoin as $ts){
						$instanceTypeSoin = $em->find("MyAppGlobalBundle:Types_soins_sante", $ts);
						$attraitModif->addTypes_soins_sante($instanceTypeSoin);
						$instanceTypeSoin = null;
					}
				}
				//On vérifie que la valeau du champ photo est pas vide
				/*$img = $form->getData()->getImageDoctrine();
				if($img != null)
				{
					$attraitModif->setImage($img);
				}
				//On valide l'image du logo si le champ est pas vide
				$logo = $form->getData()->getLogoDoctrine();
				if($logo != null)
				{
					$attraitModif->setLogo($logo);
				}
                                //Grande Image
                                $grandeImage = $form->getData()->getPhotoPayanteDoctrine();
                                if($grandeImage != null)
                                {
                                    $attraitModif->setPhotoPayante($grandeImage);
                                }*/
                                //On ne veut pas changer la date de création.
                                $attraitModif->setDateCreation($attraitModif->getDateCreation());
				//Et là les horaires de l'attrait dans la table «HORAIRES»
				$em->persist($attraitModif->getLundiMatinEte());
				//Ici ce sont les vidéos de l'attraits
				/*foreach($attraitModif->getUrl1Fr() as $mov)
				{
					$em->persist($mov);
				}*/
				//On enregistre qui a valider l'attrait
				$attraitModif->setValiderPar($user->getUsername());		
				//Ici les infos de l'attrait.
				$em->persist($attraitModif);
				$em->flush();					
				echo 'Attrait modifié avec succés !';
				//nettoyage de la mémoire
				gc_collect_cycles();	
				gc_disable();
							
				//On regarde vers ou on redirige la liste des clients où la liste des attraits
				if($number != "number")
				{
				    //On redirige vers la liste des clients.
					if($page != "page"){
						return $this->redirect($this->generateUrl('_Dashboard_clients', array('page' => $page)));
					}else{
						return $this->redirect($this->generateUrl('_Dashboard_clients', array('page' => 1)));
					}
				}
				elseif($number == "number" and $lettre == "lettre")
				{
					//On redirige vers la liste des attraits.					
					return $this->redirect($this->generateUrl('_Dashboard_attrait', array('page' => $page)));
				}
				elseif($lettre != "lettre")
				{
					//On redirige vers la liste des attraits commençant par cette lettre.
					return $this->redirect($this->generateUrl('_Dashboard_attrait', array('page' => $page, 'letter' => $lettre)));
				}
		}
		//Liste des régions
		$listeregion = $em->getRepository("MyAppGlobalBundle:Regions")->getRegions($attraitModif->getProvinceId()->getId());
		//Liste des zones
		$listezone = $em->getRepository("MyAppGlobalBundle:Zones")->getZonesbyRegion($attraitModif->getRegionId()->getId());
		//Liste des villes
		$listeville = $em->getRepository("MyAppGlobalBundle:Villes")->getSelectTownByArea($attraitModif->getZoneId()->getId());
                gc_collect_cycles();	
		//Préparation de la view dashboard_addattrait_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addattrait.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'form' 					=> $form->createView(),
						'addatt' 				=> "menu_attrait",
						'txtFr'					=> str_replace(array("\r\n"), " ", html_entity_decode($attraitModif->getTexteDescriptionFr())),
						'txtEn'					=> str_replace(array("\r\n"), " ", html_entity_decode($attraitModif->getTexteDescriptionEn())),
						'infoid'				=> $id,
						'infonom'				=> $attraitModif->getNomFr(),
						'infoimg'				=> $attraitModif->getImage(),
						'infologo'				=> $attraitModif->getLogo(),
                                                'infoGrandePhoto'               => $attraitModif->getPhotoPayante(),
						'role'					=> $role,
						'repertoirefr'			=> $attraitModif->getRepertoireFr(),
						'lat'					=> $attraitModif->getLatitude(),
						'long'					=> $attraitModif->getLongitude(),
						'regionrecorder'		=> $listeregion,
						'zonerecorder'			=> $listezone,
						'villerecorder'			=> $listeville,
						'utilisateur'			=> $attraitModif->getUtilisateur()->getId(),
						'regionSelected'		=> $attraitModif->getRegionId()->getId(),
						'zoneSelected'			=> $attraitModif->getZoneId()->getId(),
						'villeSelected'			=> $attraitModif->getVilleId()->getId(),
				));
	}
	
	/**
	 * Page du tableau de bord pour supprimer les attraits dans la partie administration.
	 */
	public function deleteAttraitAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère La catégorie à supprimer
		$attrait = $em->find('MyAppGlobalBundle:Attraits', $id);
		//Liste attrait
		$listeAttrait = $em->getRepository("MyAppGlobalBundle:Attraits")->getRechercheAttraitParUtilisateur($attrait->getUtilisateur()->getId());
		if(sizeof($listeAttrait) == 1){
			//Fait une mise à jour du client
			$utilisateur = $em->find("MyAppGlobalBundle:Utilisateur", $attrait->getUtilisateur()->getId());
			$utilisateur->setAttraitExiste(false);
		}
		$em->remove($attrait);
		$em->flush();
		//On redirige vers la page d'accueil des attraits
		return $this->redirect($this->generateUrl('_Dashboard_attrait'));
	}
	
	/**
	 * Retourne la liste des images pour l'affichage des vignettes galerie attrait
	 */
	public function getDisplayThumbnailAttraitAdminAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$listeimg = '';
			$listeimg = $request->request->get('listeimgattrait');
			$tabarray = [];
			$tabarray = preg_split("/[\s,]+/", $listeimg);//Supprime les virgules
			$tab = [];
			foreach($tabarray as $tw){
				array_push($tab, (integer)$tw); //cast les id en integer
			}
			$em = $this->getDoctrine()->getEntityManager();
			if($tab != ''){
				//Retourne la liste
				$retourliste = $em->getRepository('MyAppGlobalBundle:Galerie_attraits')->getDisplayThumbnailAttrait($tab);
				return $this->render('MyAppAdminBundle:Attrait:display_gallery_attrait_admin.xml.twig',
						array(
								'listeimgattrait'	=> $retourliste,
						));
			}
		}
	}
	
	/**
	 * Suppression des images pour la galerie de l'attrait avec ajax
	 */
	public function getGaleriePackageAttraitAdminDeleteAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$galimgdelete = '';
			$galimgdelete = $request->request->get('galimgdelete');
			$em = $this->getDoctrine()->getEntityManager();
			if($galimgdelete != ''){
				//Recherche et suppréssion de l'image
				$retourdel = $em->find('MyAppGlobalBundle:Galerie_attraits', $galimgdelete);
				$em->remove($retourdel);
				$em->flush();
				return $this->render('MyAppAdminBundle:Attrait:display_gallery_attrait_admin.xml.twig');
			}
		}
	}
	
	
/*####################################################################################*/
/*############### SECTION CATÉGORIES ATTRAITS ########################################*/
/*####################################################################################*/

	/**
	 * Page du tableau de bord pour afficher et gérer les catégories des attraits.
	 */
	public function categorieAttraitAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des catégories_attraits pour les afficher.
		$attraitCategory = $em->getRepository('MyAppGlobalBundle:Attraits_categories')->getListAttraitCategorie();
		//Préparation de la view dashboard_categorie_hebergement_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_categorieattrait.html.twig',
				array(
						'annee' 		  		=> date('Y'),
						'name_admin' 	   		=> $user->getUsername(),
						'pointeur' 		   		=> 'pointeur',
						'cat' 			   		=> "menu_attrait",
						'attraitCategory'  		=> $attraitCategory,
						'role'					=> $role,
				));
	}

	/**
	 * Page du tableau de bord pour ajouter les catégories des attraits.
	 */
	public function addCategorieAttraitAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout de catégorie.
		$categoryAttrait = new Attraits_categories();
		$form = $this->container->get('form.factory')->create(new CategorieAttraitForm(), $categoryAttrait);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $categoryAttrait dans la base de données
				$txtFr = $validRole->getSecureData($_POST['editor1']);
				$txtEn = $validRole->getSecureData($_POST['editor2']);
				$categoryAttrait->setTexteFr($txtFr);
				$categoryAttrait->setTexteEn($txtEn);
				//On valide que le champ photo est pas vide pour ne pas écraser la valeur en stocke
				$img = $form->getData()->getImageDoctrine();
				if($img != null){
					$categoryAttrait->setImage($img);
				}
				$em->persist($categoryAttrait);
				$em->flush();
				echo 'Catégorie ajoutée avec succés !';
				//On redirige vers la liste des catégories.
				return $this->redirect($this->generateUrl('_Dashboard_attraitcategories'));
			}
		}
		//Préparation de la view dashboard_addcategorieattrait_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addcategorieattrait.html.twig',
				array(
						'annee' 			   =>  date('Y'),
						'name_admin'                       => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'cat'			  	   => "menu_attrait",
						'exist' 			   => "false",
						'role'				   => $role,
				));
	}

	/**
	 * Page du tableau de bord pour modifier une catégorie des attraits.
	 */
	public function updateCategorieAttraitAction($id)
	{

		$em = $this->getDoctrine()->getEntityManager();
		//Récup�re le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la catégorie à modifier.
		$categorieAttraitModif = $em->find('MyAppGlobalBundle:Attraits_categories',$id);
		//Formulaire d'ajout d'une catégorie.
		$form = $this->container->get('form.factory')->create(new CategorieAttraitForm(), $categorieAttraitModif);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentr�es sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $categorieAttraitModif dans la base de données.
				$img = $form->getData()->getImageDoctrine();
				if($img != null){
					$categorieAttraitModif->setImage($img);
				}
                                // On l'enregistre notre objet $categoryAttrait dans la base de données
				$txtFr = $validRole->getSecureData($_POST['editor1']);
				$txtEn = $validRole->getSecureData($_POST['editor2']);
				$categorieAttraitModif->setTexteFr($txtFr);
				$categorieAttraitModif->setTexteEn($txtEn);
				$em->persist($categorieAttraitModif);
				$em->flush();
				echo 'Catégorie modifiée avec succés !';
				//On redirige vers la liste des catégorie.
				return $this->redirect($this->generateUrl('_Dashboard_attraitcategories'));
			}
		}
		//Préparation de la view dashboard_addcategorieattrait_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addcategorieattrait.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin'                            => $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'form' 					=> $form->createView(),
						'cat' 					=> "menu_attrait",
						'txtFr'					=> str_replace(array("\r\n"), " ", html_entity_decode($categorieAttraitModif->getTexteFr())),
						'txtEn'					=> str_replace(array("\r\n"), " ", html_entity_decode($categorieAttraitModif->getTexteEn())),
						'infoid'				=> $id,
						'infonom'				=> $categorieAttraitModif->getNomFr(),
						'infoimg'				=> $categorieAttraitModif->getImage(),
						'role'					=> $role,
				));
	}

	/**
	 * Page du tableau de bord pour supprimer une catégorie des attraits.
	 */
	public function deleteCategorieAttraitAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère la catégorie à supprimer
		$categorie = $em->find('MyAppGlobalBundle:Attraits_categories', $id);
		//On supprime le parent
		$em->remove($categorie);
		$em->flush();
		//On redirige vers la page d'accueil des catégories
		return $this->redirect($this->generateUrl('_Dashboard_attraitcategories'));
	}
        
/*####################################################################################*/
/*############### SOUS CATÉGORIE #####################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les sous cat�gorie des attraits
	 */
	public function sousCategorieAttraitAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//R�cup�re la liste des cat�gories_attraits pour les afficher.
		$attraitSousCategory = $em->getRepository('MyAppGlobalBundle:Attraits_sous_categories')->getListAttraitSousCategorie();
		//Pr�paration de la view dashboard_souscategorieattrait_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_souscategorieattrait.html.twig',
				array(
						'annee' 		   		=> date('Y'),
						'name_admin' 	   		=> $user->getUsername(),
						'pointeur' 		  		=> 'pointeur',
						'soucat' 		   		=> "menu_attrait",
						'attraitSousCategory'           => $attraitSousCategory,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter une sous cat�gorie
	 */
	public function addSousCategorieAttraitAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout de sous cat�gorie.
		$sousCategoryAttrait = new Attraits_sous_categories();
		$form = $this->container->get('form.factory')->create(new SousCategorieAttraitForm(), $sousCategoryAttrait);
		// On r�cup�re la requ�te.
		$request = $this->get('request');
		// On v�rifie qu'elle est de type � POST �.
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requ�te <-> Formulaire.
			$form->bindRequest($request);
			// On v�rifie que les valeurs rentr�es sont correctes.
			if( $form->isValid() )
			{	
				// On l'enregistre notre objet $sousCategorieAttrait dans la base de donn�es.
                                $sousCategoryAttrait->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $sousCategoryAttrait->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $img = $form->getData()->getImageDoctrine();
                                if($img != null){
                                    $sousCategoryAttrait->setImage($img);
                                }
				$em->persist($sousCategoryAttrait);
				$em->flush();
				echo 'Sous catégorie ajoutée avec succés !';
				//On redirige vers la liste des sous cat�gories.
				return $this->redirect($this->generateUrl('_Dashboard_attraitsouscategorie'));
			}
		}
		//Pr�paration de la view dashboard_addcategorieattrait_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addsouscategorieattrait.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin'                       => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'soucat'			   => "menu_attrait",
						'exist' 			   => "false",
						'role'				   => $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier une sous cat�gorie 
	 */
	public function updateSousCategorieAttraitAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout de sous catégorie.
		$modifSousCat = $em->find('MyAppGlobalBundle:Attraits_sous_categories',$id);
		$form = $this->container->get('form.factory')->create(new SousCategorieAttraitForm(), $modifSousCat);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $ModifSousCat dans la base de données.
                                $modifSousCat->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $modifSousCat->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $img = $form->getData()->getImageDoctrine();
                                if($img != null){
                                    $modifSousCat->setImage($img);
                                }
				$em->persist($modifSousCat);
				$em->flush();
				echo 'Sous catégorie modifiée avec succès !';
				//On redirige vers la liste des sous_catégories.
				return $this->redirect($this->generateUrl('_Dashboard_attraitsouscategorie'));
			}     
		}
		//Pr�paration de la view dashboard_addcategorieattrait_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addsouscategorieattrait.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin'                       => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'soucat'			   => "menu_attrait",
						'infoid'			   => $id,
						'infonom'			   => $modifSousCat->getNomFr(),
						'infoimg'			   => $modifSousCat->getImage(),
						'role'				   => $role,
                                                'txtFr'                            => str_replace(array("\r\n"), " ", html_entity_decode($modifSousCat->getTexteFr())),
                                                'txtEn'                            => str_replace(array("\r\n"), " ", html_entity_decode($modifSousCat->getTexteEn())),
				));
	}
	
	/**
	 * Suppréssion d'une sous catégorie
	 */
	public function deleteSousCategorieAttraitAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On r�cup�re la sous cat�gorie � supprimer
		$sousCat = $em->find('MyAppGlobalBundle:Attraits_sous_categories', $id);
		$em->remove($sousCat);
		$em->flush();
		//On redirige vers la page d'accueil des sous cat�gories.
		return $this->redirect($this->generateUrl('_Dashboard_attraitsouscategorie'));
	}
	
/*####################################################################################*/
/*############### TYPES SOINS SANTÉ ##################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les types de soins
	 */
	public function typeSoinsSanteAction()
	{
	
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//R�cup�re la liste des cat�gories_attraits pour les afficher.
		$type_soin = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getListTypeSoin();
		//Pr�paration de la view dashboard_souscategorieattrait_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_typesoinsante.html.twig',
				array(
						'annee' 		   	=> date('Y'),
						'name_admin' 	   		=> $user->getUsername(),
						'pointeur' 		  	=> 'pointeur',
						'typesoinat' 		   	=> "menu_attrait",
						'typesoin'   			=> $type_soin,
						'role'				=> $role
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter ou modifier un type de soin
	 */
	public function addTypeSoinSanteAction($id)
	{	
		$infoimg = "";
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		if($id == "id")
		{
			$exist == "false";
			//Formulaire d'ajout de sous catégorie.
			$typeSoin = new Types_soins_sante();
			$form = $this->createForm(new AddTypesSoinsForm(), $typeSoin);
			// On récupère la requête.
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{
					// On l'enregistre notre objet $typesoin dans la base de données.
					$em->persist($typeSoin);
					$em->flush();
					echo 'Type soin de santé ajouté avec succés !';
					//On redirige vers la liste des types de soin.
					return $this->redirect($this->generateUrl('_Dashboard_attraittypesoins'));
				}
			}
		}
		else{
			$exist = "true";
			//Formulaire de modification d'un type de soin.
			$modifTypeSoin = $em->find('MyAppGlobalBundle:Types_soins_sante',$id);
			$form = $this->container->get('form.factory')->create(new AddTypesSoinsForm(), $modifTypeSoin);
			// On récupère la requête.
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{
					// On l'enregistre notre objet $modiftypeSoin dans la base de données.
					//Contrôle la valeur du champ de l'image pour savoir si on met le champ à jour
					$img = $form->getData()->getImageDoctrine();
					if($img != null)
					{
						$modifTypeSoin->setImage($img);
					}
					$em->persist($modifTypeSoin);
					$em->flush();
					echo 'Type de soin santé modifiés avec succés !';
					//On redirige vers la liste des types de soins santé.
					return $this->redirect($this->generateUrl('_Dashboard_attraittypesoins'));
				}
			}
		}
		//Préparation de la view dashboard_addtypesoinsante_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addtypesoinsante.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin' 		   => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'typesoinat'		   => "menu_attrait",
						'exist' 			   => $exist,
						'role'				   => $role,
						'infoid'			   => $id,
						'infonom'			   => $modifTypeSoin->getNomFr(),
						'infoimg'			   => $modifTypeSoin->getImage(),
						'txtFr'			       => trim($modifTypeSoin->getTexteFr()),
						'txtEn'			       => trim($modifTypeSoin->getTexteEn()),
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier un type de soin
	 */
	public function updateTypeSoinSanteAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'un type de soin.
		$modifTypeSoin = $em->find('MyAppGlobalBundle:Types_soins_sante',$id);
		$form = $this->container->get('form.factory')->create(new AddTypesSoinsForm(), $modifTypeSoin);
		// On r�cup�re la requ�te.
		$request = $this->get('request');
		// On v�rifie qu'elle est de type � POST �.
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requ�te <-> Formulaire.
			$form->bindRequest($request);
			// On v�rifie que les valeurs rentr�es sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $modiftypeSoin dans la base de donn�es.
				$validData = new ControleDataSecureController();
				$cleanTextFr = $validData->getSecureData($_POST['editor1'], "editor1");
				$cleanTextEn = $validData->getSecureData($_POST['editor2'], "editor2");
				$typeSoin->setTexteFr(strip_tags($cleanTextFr));
				$typeSoin->setTexteEn(strip_tags($cleanTextEn));
				$em->persist($modifTypeSoin);
				$em->flush();
				echo 'Type de soin sant� modifi� avec succ�s !';
				//On redirige vers la liste des sous_cat�gories.
				return $this->redirect($this->generateUrl('_Dashboard_attraittypesoins'));
			}
		}
		//Pr�paration de la view dashboard_addtypesoinsante_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addtypesoinsante.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin' 		   => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'typesoinat'		   => "menu_attrait",
						'infoid'			   => $id,
						'infonom'			   => $modifTypeSoin->getNomFr(),
						'infoimg'			   => $modifTypeSoin->getImage(),
						'txtFr'			       => trim($modifTypeSoin->getTexteFr()),
						'txtEn'			       => trim($modifTypeSoin->getTexteEn()),
						'role'				   => $role,
				));
	}
	
	/**
	 * Suppréssion d'un type de soin
	 */
	public function deleteTypeSoinSanteAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le type de soin à supprimer
		$typesoin = $em->find('MyAppGlobalBundle:Types_soins_sante', $id);
		$em->remove($typesoin);
		$em->flush();
		//On redirige vers la page d'accueil des types de soin.
		return $this->redirect($this->generateUrl('_Dashboard_attraittypesoins'));
	}
	
/*####################################################################################*/
/*############### SOINS SANTÉ ########################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les soins de sant�
	 */
	public function soinsSanteAction($page, $letter)
	{
		$numberPaginate = 30;
		$number = 0;
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Auto-complétion plus on compte le nombre de soin.
		$NbSoin = $em->getRepository('MyAppGlobalBundle:Soins_sante')->getComptSoin();
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Soins_sante')->getAutotcompletion();
		foreach($NbSoin as $nb){
			 $total = $nb['nbSoin'];
		}
		//On divise le nombre total de soin par le nombre que l'on souhaite afficher.
		$displaypage = ceil($total/$numberPaginate);
		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
		if(isset($page) and is_numeric($page) == 1)
			if($page > $displaypage)
				$page = $displaypage;
			elseif($page <= 0)
				$page = 1;
			else
				$page;
		else
			$page = 1;
		//Récupère la liste des soins avec la pagination.
		$soin = $em->getRepository('MyAppGlobalBundle:Soins_sante')->getAdminSoin($page, $numberPaginate);
		$number = 1;
		//Moteur de recherche.
		$form = $this->createForm(new Moteur_recherche_AttraitForm());
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			//On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			//Si le formulaire est valide
			foreach($form->getData() as $word)
			{
				$word;
			}
			//On recherche le soin par le nom entrer avec l'auto-completion
			$result = $em->getRepository('MyAppGlobalBundle:Soins_sante')->getSearchSoin($word);
			$number = 2;
		}
		else
			$result = "";
		//S'il existe une lettre alphabétique dans l'url.
		if($letter === 'letter')
		{
			$lettre = "";
		}
		else
		{
			$lettre = $em->getRepository('MyAppGlobalBundle:Soins_sante')->getSoinByFirstLetter($letter);
			$number = 3;
		}
		(isset($word))? $number = 2 : $number ;
		//Préparation de la view dashboard_soinsante_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_soinsante.html.twig',
				array(
						'annee' 		   		=> date('Y'),
						'name_admin' 	   		=> $user->getUsername(),
						'pointeur' 		  		=> 'pointeur',
						'soinat' 		   		=> "menu_attrait",
						'autocompletion'  		=> $autocompletion,
						'page'					=> $page,
						'displaypage'			=> $displaypage,
						'number'				=> $number,
						'lettre'				=> $lettre,
						'result'				=> $result,
						'soin'					=> $soin,
						'firstpage'				=> 1,
						'form'					=> $form->createView(),
						'nbsoin'				=> $total,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter et modifier un soin 
	 */
	public function addSoinSanteAction($id)
	{
		$infoId = $infoNom = $infoImg = $textEn = $textFr = "";		
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		if($id == "id")
		{
			$reponse = "false";
			//Formulaire d'ajout d'un soin.
			$soin = new Soins_sante();
			$form = $this->createForm(new AddSoinSanteForm(), $soin);
			// On récupère la requête.
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
				if( $request->getMethod() == 'POST' )
				{
					// On fait le lien Requête <-> Formulaire.
					$form->bindRequest($request);
					// On vérifie que les valeurs rentrées sont correctes.
					if( $form->isValid() )
					{
						// On l'enregistre notre objet $soin dans la base de données.
						$validData = new ControleDataSecureController();
						$cleanTxtFr = $validData->getSecureData($_POST['editor1'], "editor1");
						$cleanTxtEn = $validData->getSecureData($_POST['editor2'], "editor2");
						$soin->setTexteFr(strip_tags($cleanTxtFr));
						$soin->setTexteEn(strip_tags($cleanTxtEn));
						$em->persist($soin);
						$em->flush();
						echo 'Soin ajouté avec succés !';
						//On redirige vers la liste des soins.
						return $this->redirect($this->generateUrl('_Dashboard_attraitsoins'));
					}
				}
		}
		if($id != "id")
		{
			$reponse = "true";
			//Formulaire de modification des soins.
			$ModifSoin = $em->find('MyAppGlobalBundle:Soins_sante',$id);
			$infoId = $ModifSoin->getId();
			$infoNom = $ModifSoin->getNomFr();
			$infoImg = $ModifSoin->getImage();
			$textFr = trim($ModifSoin->getTexteFr());
			$textEn = trim($ModifSoin->getTexteEn());
			$form = $this->createForm(new AddSoinSanteForm(), $ModifSoin);
			// On récupère la requête.
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{
					// On l'enregistre notre objet $ModifSoin dans la base de données.
					$validData = new ControleDataSecureController();
					$cleanTxtFr = $validData->getSecureData($_POST['editor1'], "editor1");
					$cleanTxtEn = $validData->getSecureData($_POST['editor2'], "editor2");
					$ModifSoin->setTexteFr(strip_tags($cleanTxtFr));
					$ModifSoin->setTexteEn(strip_tags($cleanTxtEn));
					//On récupère la valeur du champ image
					$img = $form->getData()->getImageDoctrine();
					//Si la valeur est pas vide on la transmet aux methode pour enregistrer dans la table.
					if($img != null)
					{
						$ModifSoin->setImage($img);
					}
					$em->persist($ModifSoin);
					$em->flush();
					echo 'Soin modifié avec succés !';
					//On redirige vers la liste des soins.
					return $this->redirect($this->generateUrl('_Dashboard_attraitsoins'));
				}
			}
		}
		//Préparation de la view dashboard_addsoinsante_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addsoinsante.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin' 		   => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'soinat'			   => "menu_attrait",
						'exist' 			   => $reponse,
						'role'				   => $role,
						'infoid'			   => $infoId,
						'infonom'			   => $infoNom,
						'infoimg'			   => $infoImg,
						'txtFr'				   => $textFr,
						'txtEn'				   => $textEn,
				));
	}
	
	/**
	 * Suppréssion d'un soin
	 */
	public function deleteSoinSanteAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le soin à supprimer
		$soin = $em->find('MyAppGlobalBundle:Soins_sante', $id);
		$em->remove($soin);
		$em->flush();
		//On redirige vers la page d'accueil des soins.
		return $this->redirect($this->generateUrl('_Dashboard_attraitsoins'));
	}
/*####################################################################################*/
/*############### ACTIVITÉS ##########################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les activités des attraits
	 */
	public function activiteAttraitAction($page, $letter)
	{
		$number = 0; //Variable qui va d�terminer pour le template quel r�sultat afficher pour les diff�rentes recherches.
		$numberPaginate = 30;
	
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Liste les activit�s pour l'auto-completion
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Attraits_activites')->getListAttraitActivites();
		//R�cup�re le nombre d'activit�s dans la table 
		$nbActivite = $em->getRepository('MyAppGlobalBundle:Attraits_activites')->getCompteIdActivite();
		foreach($nbActivite as $result){
			$total = $result['nbActivite'];
		}
		//On divise le nombre total de r�gion par le nombre que l'on souhaite afficher de zone sur la page et on le transforme en entier.
		$displaypage = ceil($total/$numberPaginate);
		//Contr�le s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
		if(isset($page) and is_numeric($page) == 1)
			if($page > $displaypage)
				$page = $displaypage;
			elseif($page <= 0)
				$page = 1;
			else
				$page;
		else
			$page = 1;
		//R�cup�re la liste des activit�s.
		$attraitActivite = $em->getRepository('MyAppGlobalBundle:Attraits_activites')->getAdminActivites($page, $numberPaginate);
		$number = 1;
		//Formulaire de recherche.
		$form = $this->container->get('form.factory')->create(new Moteur_recherche_attraits_activitesForm());
		// On r�cup�re la requ�te.
		$request = $this->get('request');
		// On v�rifie qu'elle est de type � POST �.
		if( $request->getMethod() == 'POST' )
		{	
			// On fait le lien Requ�te <-> Formulaire.
			$form->bindRequest($request);
			foreach($form->getData() as $word)
			{
				$word;
			}
			//On recherche l'activit� par le nom entrer avec l'auto-completion
			$result = $em->getRepository('MyAppGlobalBundle:Attraits_activites')->getSearchActivite($word);
			$number = 2;
		}
		else 
			$result = "";
		//S'il existe une lettre alphab�tique dans l'url.
		if($letter === 'letter')
		{
			$lettre = "";
		}
		else
		{	
			$lettre = $em->getRepository('MyAppGlobalBundle:Attraits_activites')->getActiviteByFirstLetter($letter);
			$number = 3;
		}
		//on force la variable number a garder 2 comme valeur car si on recherche par lettre alphab�tique et que ensuite on utilise le moteur 
		//la variable �galait toujours 3 du � la lettre dans l'url.
		(isset($word))? $number = 2 : $number ;
		//Pr�paration de la view dashboard_activite_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_activite.html.twig',
				array(
						'annee' 		   		=> date('Y'),
						'name_admin' 	   		=> $user->getUsername(),
						'pointeur' 		  		=> 'pointeur',
						'actat' 		   		=> "menu_attrait",
						'attraitActivite'       => $attraitActivite,
						'autocompletion'		=> $autocompletion,
						'form' 					=> $form->createView(),
						'displaypage'			=> $displaypage,
						'nbactivite'			=> $total,
						'page'					=> $page,
						'firstpage'				=> 1,
						'lettre'				=> $lettre,
						'result'				=> $result,
						'number'				=> $number,
						'role'					=> $role,
				));
		
	}
	
	/**
	 * Page du tableau de bord pour ajouter une activit�
	 */
	public function addActiviteAttraitAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'activit�.
		$activiteAttrait = new Attraits_activites();
		$form = $this->container->get('form.factory')->create(new AttraitsActiviteForm(), $activiteAttrait);
		// On r�cup�re la requ�te.
		$request = $this->get('request');
		// On v�rifie qu'elle est de type � POST �.
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requ�te <-> Formulaire.
			$form->bindRequest($request);
			// On v�rifie que les valeurs rentr�es sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $activiteAttrait dans la base de donn�es.
				$em->persist($activiteAttrait);
				$em->flush();
				echo 'Activit� ajout�e avec succ�s !';
				//On redirige vers la liste des activit�s.
				return $this->redirect($this->generateUrl('_Dashboard_attraitactivites'));
			}
		}
		//Pr�paration de la view dashboard_addcategorieattrait_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addactivite.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin' 		   => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'actat'			   	   => "menu_attrait",
						'exist' 			   => "false",
						'role'				   => $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier une activit�
	 */
	public function updateActiviteAttraitAction($id)
	{

		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration.
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//On r�cup�re l'activit� � modifier.
		$ModifActivite = $em->find('MyAppGlobalBundle:Attraits_activites',$id);
		//Formulaire d'ajout d'activit�.
		$form = $this->container->get('form.factory')->create(new AttraitsActiviteForm(), $ModifActivite);
		// On r�cup�re la requ�te.
		$request = $this->get('request');
		// On v�rifie qu'elle est de type � POST �.
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requ�te <-> Formulaire.
			$form->bindRequest($request);
			// On v�rifie que les valeurs rentr�es sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $ModifActivite dans la base de donn�es.
				$em->persist($ModifActivite);
				$em->flush();
				echo 'Activit� modifi�e avec succ�s !';
				//On redirige vers la liste des activit�s.
				return $this->redirect($this->generateUrl('_Dashboard_attraitactivites'));
			}
		}
		//Pr�paration de la view dashboard_addactivite_html.twig.
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addactivite.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin' 		   => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'actat'			   	   => "menu_attrait",
						'infoid'			   => $id,
						'infonom'			   => $ModifActivite->getNomFr(),
						'infoimg'			   => $ModifActivite->getImage(),
						'role'				   => $role,
				)
		);
	}
	
	/**
	 * Suppr�ssion d'une activité
	 */
	public function deleteActiviteAttraitAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On r�cup�re l'activit� � supprimer
		$activite = $em->find('MyAppGlobalBundle:Attraits_activites', $id);
		$em->remove($activite);
		$em->flush();
		//On redirige vers la page d'accueil des activit�s.
		return $this->redirect($this->generateUrl('_Dashboard_attraitactivites'));
	}
/*####################################################################################*/
/*############### SERVICES ###########################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les services des attraits
	 */
	public function serviceAttraitAction($page, $letter)
	{
		$number = 0; //Variable qui va d�terminer pour le template quel r�sultat afficher pour les diff�rentes recherches.
		$numberPaginate = 30; //Variable pour determiner le nombre de resultat visible par page pour la pagination.
		
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Liste les services pour l'auto-completion.
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Attraits_services')->getListAttraitService();
		//R�cup�re le nombre de service dans la table
		$nbService = $em->getRepository('MyAppGlobalBundle:Attraits_services')->getCompteIdService();
		foreach($nbService as $result){
			$total = $result['nbService'];
		}
		//On divise le nombre total d'attrait par le nombre que l'on souhaite afficher .
		$displaypage = ceil($total / $numberPaginate);
		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
		$page = $validRole->getValideIntMethodeUpdate($page);
		//R�cup�re la liste des services avec la pagination.
		$attraitService = $em->getRepository('MyAppGlobalBundle:Attraits_services')->getAdminService($page, $numberPaginate);
		$number = 1;
		//Formulaire de recherche.
		$form = $this->container->get('form.factory')->create(new Moteur_recherche_attraits_servicesForm());
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requ�te <-> Formulaire.
			$form->bindRequest($request);
			foreach($form->getData() as $word)
			{
                            $word;
			}
			//On recherche le service par le nom entrer avec l'auto-completion
			$result = $em->getRepository('MyAppGlobalBundle:Attraits_services')->getSearchService($word);
			$number = 2;
		}
		else
			$result = "";
		//S'il existe une lettre alphabétique dans l'url.
		if($letter === 'letter')
		{
			$lettre = "";
		}
		else
		{
			$lettre = $em->getRepository('MyAppGlobalBundle:Attraits_services')->getServiceByFirstLetter($letter);
			$number = 3;
		}
		//Ici une condition pour forcer la variable number à garder la bonne valeur
		//Si on recherche par lettre alphabétique et que ensuite on recherche par nom dans le moteur de recherche la variable number garder toujours la valeur du � la lettre dans l'url
		(isset($word))? $number = 2: $number ;
		//Préparation de la view dashboard_service_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_service.html.twig',
				array(
						'annee' 		   		=> date('Y'),
						'name_admin' 	   		=> $user->getUsername(),
						'pointeur' 		  		=> 'pointeur',
						'serat' 		   		=> "menu_attrait",
						'attraitService'        => $attraitService,
						'autocompletion'		=> $autocompletion,
						'form' 					=> $form->createView(),
						'displaypage'			=> $displaypage,
						'nbservice'				=> $total,
						'page'					=> $page,
						'firstpage'				=> 1,
						'lettre'				=> $lettre,
						'result'				=> $result,
						'number'				=> $number,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter un service
	 */
	public function addServiceAttraitAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Hydratation du formulaire avec l'entity
		$serviceAttrait = new Attraits_services();
		//Formulaire d'ajout d'un service.
		$form = $this->container->get('form.factory')->create(new AttraitsServiceForm(), $serviceAttrait);
		// On récupère la requête.
		$request = $this->get('request');
		// On v�rifie qu'elle est de type � POST �.
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requ�te <-> Formulaire.
			$form->bindRequest($request);
			// On v�rifie que les valeurs rentr�es sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $state dans la base de donn�es.
				$em->persist($serviceAttrait);
				$em->flush();
				echo 'Service ajouté avec succés !';
				//On redirige vers la liste des services.
				return $this->redirect($this->generateUrl('_Dashboard_attraitservices'));
			}
		}
		//Préparation de la view dashboard_addservice_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addservice.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin' 		   => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'serat'			  	   => "menu_attrait",
						'exist' 			   => "false",
						'role'				   => $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier un service
	 */
	public function updateServiceAttraitAction($id, $page)
	{
	
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Valide la valeur pour la pagination
		$validRole->getValideIntMethodeUpdate($page);
		//R�cup�re le service � modifier
		$modifService = $em->find('MyAppGlobalBundle:Attraits_services', $id);
		//Formulaire d'ajout d'un service.
		$form = $this->container->get('form.factory')->create(new AttraitsServiceForm(), $modifService);
		// On r�cup�re la requ�te.
		$request = $this->get('request');
		// On v�rifie qu'elle est de type � POST �.
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requ�te <-> Formulaire.
			$form->bindRequest($request);
			// On v�rifie que les valeurs rentr�es sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $modifService dans la base de données.
				$img = $form->getData()->getImageDoctrine();
				if($img != null)
				{
					$modifService->setImage($img);
				}
				$em->persist($modifService);
				$em->flush();
				echo 'Service modifié avec succés !';
				if($page == "page")
				{
					//On redirige vers la liste des services.
					return $this->redirect($this->generateUrl('_Dashboard_attraitservices'));
				}
				else
				{
					//On redirige vers la liste des services.
					return $this->redirect($this->generateUrl('_Dashboard_attraitservices', array('page' => $page)));
				}
			}
		}
		//Pr�paration de la view dashboard_addservice_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addservice.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin' 		   => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'serat'			  	   => "menu_attrait",
						'infoid'			   => $id,
						'infonom'			   => $modifService->getNomFr(),
						'infoimg'			   => $modifService->getImage(),
						'role'				   => $role,
						'page'				   => $page,
				));
		
	}
	
	/**
	 * Suppréssion d'un service
	 */
	public function deleteServiceAttraitAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le service à supprimer.
		$service = $em->find('MyAppGlobalBundle:Attraits_services', $id);
		$em->remove($service);
		$em->flush();
		//On redirige vers la page d'accueil des services.
		return $this->redirect($this->generateUrl('_Dashboard_attraitservices'));
	}
	
	/**
	 * Page du tableau de bord pour la gestion des cuisines
	 */
	public function cusineAttraitAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//R�cup�re la liste des cusines pour les afficher.
		$cuisine = $em->getRepository('MyAppGlobalBundle:Cuisines')->getListCuisine();
		//Pr�paration de la view dashboard_cuisine.html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_cuisine.html.twig',
				array(
						'annee' 		   		=> date('Y'),
						'name_admin' 	   		=> $user->getUsername(),
						'pointeur' 		  		=> 'pointeur',
						'cuisiat' 		   		=> "menu_cuisine",
						'cuisine'  				=> $cuisine,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page pour ajouter un nouveau type de cuisine 
	 */
	public function addCuisineAttraitAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Hydratation du formulaire avec l'entity
		$cuisine = new Cuisines();
		//Formulaire d'ajout d'une cuisine.
		$form = $this->container->get('form.factory')->create(new AddCuisinesForm(), $cuisine);
		// On r�cup�re la requ�te.
		$request = $this->get('request');
		// On v�rifie qu'elle est de type � POST �.
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requ�te <-> Formulaire.
			$form->bindRequest($request);
			// On v�rifie que les valeurs rentr�es sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $cuisine dans la base de donn�es.
				$em->persist($cuisine);
				$em->flush();
				echo 'Cuisine ajoutée avec succés !';
				//On redirige vers la liste des cuisines.
				return $this->redirect($this->generateUrl('_Dashboard_attraitcusines'));
			}
		}
		//Pr�paration de la view dashboard_addservice_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addcuisine.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin' 		   => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'cuisiat'			   => "menu_cuisine",
						'exist' 			   => "false",
						'role'				   => $role,
				));
	}
	
	/**
	 * Page pour modifier un type de cuisine
	 */
	public function updateCuisineAttraitAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//R�cup�re le nom de la personne qui acc�de � l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Hydratation du formulaire avec l'entity
		$modifCuisine = $em->find('MyAppGlobalBundle:Cuisines', $id);
		//Formulaire d'ajout d'une cuisine.
		$form = $this->container->get('form.factory')->create(new AddCuisinesForm(), $modifCuisine);
		// On r�cup�re la requ�te.
		$request = $this->get('request');
		// On v�rifie qu'elle est de type � POST �.
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requ�te <-> Formulaire.
			$form->bindRequest($request);
			// On v�rifie que les valeurs rentr�es sont correctes.
			if( $form->isValid() )
			{
				// On enregistre notre objet $modifCuisine dans la base de données.
				$em->persist($modifCuisine);
				$em->flush();
				echo 'Cuisine Modifiée avec succés !';
				//On redirige vers la liste des cuisines.
				return $this->redirect($this->generateUrl('_Dashboard_attraitcusines'));
			}
		}
		//Pr�paration de la view dashboard_addservice_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addcuisine.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin' 		   => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'cuisiat'			   => "menu_cuisine",
						'infonom'			   => $modifCuisine->getNomFr(),
						'infoid'			   => $id,
						'role'				   => $role,
				));
	}
	
	/**
	 * Supprimer un type de cuisine
	 */
	public function deleteCuisineAttraitAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le type de cuisine à supprimer.
		$cuisine = $em->find('MyAppGlobalBundle:Cuisines', $id);
		$em->remove($cuisine);
		$em->flush();
		//On redirige vers la liste des cuisines
		return $this->redirect($this->generateUrl('_Dashboard_attraitcusines'));
	}
	
	/**
	 * Page du tableau de bord pour la gestion des photos
	 */
	public function photoAttraitAction($page, $letter)
	{
		$number = 0; //Variable qui va déterminer pour le template quel résultat afficher pour les différentes recherches.
		$numberPaginate = 30;
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère le nombre de photo dans la table
		$nbPhoto = $em->getRepository('MyAppGlobalBundle:Attraits_photos')->getCountPicture();
		foreach($nbPhoto as $result){
			$total = $result['nbPhoto'];
		}
		//On divise le nombre total d'attrait par le nombre que l'on souhaite afficher (30 par défault).
		$displaypage = ceil($total/$numberPaginate);
		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
		if(isset($page) and is_numeric($page) == 1)
			if($page > $displaypage)
				$page = $displaypage;
			elseif($page <= 0)
				$page = 1;
			else
				$page;
		else
			$page = 1;
		//Récupère la liste des photos pour l'auto-complétion.
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Attraits')->getListAttrait();		
		//Récupère la liste des photos avec la pagination.
		$attraitPhoto = $em->getRepository('MyAppGlobalBundle:Attraits_photos')->getAdminPhotos($page, $numberPaginate);
		$number = 1;
		//Moteur de recherche.
		$form = $this->container->get('form.factory')->create(new Moteur_recherche_AttraitForm());
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			//On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			//Si le formulaire est valide
			foreach($form->getData() as $word)
			{
		 		if($word != ""){
		 			//On recherche l'attrait entré avec l'auto-complétion
		 			$result = $em->getRepository('MyAppGlobalBundle:Attraits')->getSearchPhoto($word);
		 			$number = 2;
		 		}
			}	
		}
		else
			$result = "";
		//S'il existe une lettre alphabétique dans l'url.
		if($letter === 'letter')
		{
			$lettre = "";
		}
		else
		{
			$lettre = $em->getRepository('MyAppGlobalBundle:Attraits_photos')->getLegendeByFirstLetter($letter);
			$number = 3;
		}
		//Si la variable word est pas vide on force $number à garder sa valeur à 2.
		(!empty($word))? $number = 2 : $number ;
		//Préparation de la view dashboard_photo.html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_photo.html.twig',
				array(
						'annee' 		   		=> date('Y'),
						'name_admin' 	   		=> $user->getUsername(),
						'pointeur' 		  		=> 'pointeur',
						'photoat' 		   		=> "menu_photo",
						'photo'  				=> $attraitPhoto,
						'form'					=> $form->createView(),
						'autocompletion'		=> $autocompletion,
						'number'				=> $number,
						'total'					=> $total,
						'page'					=> $page,
						'firstpage'				=> 1,
						'lettre'				=> $lettre,
						'displaypage'			=> $displaypage,
						'result'				=> $result,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page pour ajouter de nouvelles photos
	 */
	public function addPhotoAttraitAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède è l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Hydratation du formulaire avec l'entity
		$photo= new Attraits_photos();
		//Formulaire d'ajout d'une photo.
		$form = $this->container->get('form.factory')->create(new AddAttraits_photosForm(), $photo);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type << POST >>.
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			$img = $form->getData()->getFile();
			$image = $photo->getImage1();
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On enregistre notre objet $photo dans la base de données.
				if($img != null or $img != $image){
					$photo->setImage1($img);
				}
				$em->persist($photo);
				$em->flush();
				echo 'Photo ajoutée avec succés !';
				//On redirige vers la liste des photos des attraits.
				return $this->redirect($this->generateUrl('_Dashboard_attraitphotos'));
			}
		}
		//Pr�paration de la view dashboard_addservice_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addphoto.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin' 		   => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'photoat'			   => "menu_photo",
						'exist' 			   => "false",
						'role'				   => $role,
				));
	}
	
	/**
	 * Page pour modifier les photos des attraits
	 */
	public function updatePhotoAttraitAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire de modification des photos.
		$modifPhoto = $em->find('MyAppGlobalBundle:Attraits_photos', $id);
		$form = $this->container->get('form.factory')->create(new AddAttraits_photosForm(), $modifPhoto);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			$image = $modifPhoto->getFile();
			
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On enregistre notre objet $modifPhoto dans la base de données.
				$testFieldFile = $form->getData()->getImage1();
				if($testFieldFile != null){
					$modifPhoto->setImage1($testFieldFile);
				}
				$em->persist($modifPhoto);
				$em->flush();
				echo 'Photo modifié avec succés !';
				//On redirige vers la liste des photos.
				return $this->redirect($this->generateUrl('_Dashboard_attraitphotos'));
			}
		}
		//Préparation de la view dashboard_addphoto_html.twig
		return $this->render('MyAppAdminBundle:Attrait:dashboard_addphoto.html.twig',
				array(
						'annee' 			   => date('Y'),
						'name_admin' 		   => $user->getUsername(),
						'pointeur' 			   => 'pointeur',
						'form' 				   => $form->createView(),
						'photoat'			   => "menu_photo",
						'infonom'			   => $modifPhoto->getFile(),
						'infoid'			   => $id,
						'infoimg'			   => $modifPhoto->getImage1(),
						'role'				   => $role,
				));
	}
	
	/**
	 * Supprimer une photo
	 */
	public function deletePhotoAttraitAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère la photo à supprimer.
		$deletePhoto = $em->find('MyAppGlobalBundle:Attraits_photos', $id);
		$em->remove($deletephoto);
		$em->flush();
		//On redirige vers le formulaire de modification des photos
		return $this->redirect($this->generateUrl('_Dashboard_attraitphoto'));
	}
}