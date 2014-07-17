<?php
namespace MyApp\AdminBundle\Controller;
use MyApp\AdminBundle\Forms\SearchMoteurEnginePortailType;
use MyApp\GlobalBundle\Entity\Galery;
use MyApp\GlobalBundle\Entity\Affiliations;
use MyApp\GlobalBundle\Entity\Hebergement_photo;
use MyApp\AdminBundle\Forms\AddPhotoHebergementForm;
use MyApp\AdminBundle\Forms\AddStyleForm;
use MyApp\GlobalBundle\Entity\Styles_hebergements;
use MyApp\GlobalBundle\Entity\Types_occupations;
use MyApp\AdminBundle\Forms\AddTypeOccupationForm;
use MyApp\AdminBundle\Forms\AddTypeChambreForm;
use MyApp\GlobalBundle\Entity\Types_chambres;
use MyApp\AdminBundle\Forms\AddHebergements_servicesForm;
use MyApp\GlobalBundle\Entity\Hebergements_services;
use MyApp\AdminBundle\Forms\AddHebergements_activitesForm;
use MyApp\GlobalBundle\Entity\Videos;
use MyApp\AdminBundle\Forms\AddVideoHebergementsForm;
use MyApp\AdminBundle\Forms\AddSalles_corporativesForm;
use MyApp\GlobalBundle\MyAppGlobalBundle;
use MyApp\AdminBundle\Forms\AddCorporatifServiceForm;
use MyApp\GlobalBundle\Entity\Corporatifs_services;
use MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives;
use MyApp\AdminBundle\Forms\AddTypesEvenementForm;
use MyApp\GlobalBundle\Entity\Types_evenements;
use MyApp\GlobalBundle\Entity\Equipements;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\GlobalBundle\Controller\ControleDataSecureController;
use MyApp\GlobalBundle\Entity\Categories_hebergements;
use MyApp\AdminBundle\Forms\AddCategorieHebergementForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_hebergementForm;
use MyApp\AdminBundle\Forms\AddHebergementForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_clientForm;
use MyApp\GlobalBundle\Entity\Hebergements;
use MyApp\GlobalBundle\Entity\Lits;
use MyApp\GlobalBundle\Entity\Chambres;
use MyApp\AdminBundle\Forms\AddLitsForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_chambreForm;
use MyApp\AdminBundle\Forms\AddChambresForm;
use MyApp\AdminBundle\Forms\AddAffiliationsForm;
use MyApp\AdminBundle\Forms\AddEquipementsForm;
use MyApp\GlobalBundle\Entity\Hebergements_activites;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Validator\Constraints\Date;
use MyApp\GlobalBundle\Entity\Utilisateur;
use MyApp\GlobalBundle\Entity\Villes;
use MyApp\GlobalBundle\Entity\Description_fr;
use MyApp\GlobalBundle\Entity\Devises;
use MyApp\GlobalBundle\Entity\Politique_fr;
use MyApp\GlobalBundle\Entity\Description_en;
use MyApp\GlobalBundle\Entity\Politique_en;
use MyApp\GlobalBundle\Entity\Classifications;
use MyApp\GlobalBundle\Entity\Cotations;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use Berriart\Bundle\SitemapBundle\Entity\ImageUrl;

/**
 * 
 * @author leonardc
 * 
 * Classe controlleur pour les actions sur les hébergements et leurs caractéristiques 
 * (exemples: la catégorie de l'établissement, ses services, etc )
 * 
 * @Secure(roles="ROLE_SUPER_ADMIN")
 *
 */
class HebergementController extends Controller
{
	
	/**
	 * Méthode pour récupérer les coordonnées gps des clients
	 */
	public function googlemapAction()
	{
		$lat = $long = "";
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Préparation de la view google_map_API.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:googlemaps.html.twig',
				array(
						'annee' 		=> date('Y'),
						'name_admin' 		=> $user->getUsername(),
						'role'                  => $role,
				));
	}
	
	
	
/*####################################################################################*/
/*############### SECTION HÉBERGEMENTS ###############################################*/
/*####################################################################################*/
	
	/**
	 * Page du tableau de bord pour afficher et gérer les hébergements.
	 */
	public function hebergementAction($page, $letter)
	{
		$searchByNInterne = $result2 = "";
		$numberPaginate = 30;
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des hébergements pour l'auto-complétion.
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAutocompletionHebergement();
		//Récupère le nombre d'hébergement dans la table
		$nbHebergement = $em->getRepository('MyAppGlobalBundle:hebergements')->getCompteIdHebergement();
		foreach($nbHebergement as $result){
			$total = $result['nbHebergement'];
		}
		//On divise le nombre total d'hébergement par le nombre que l'on souhaite afficher.
		$displaypage = ceil($total/$numberPaginate);
		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas supérieure au nombre max de page
		$page = $validRole->getValideEntierPagination($page, $displaypage);
		//Récupère la liste des hébergements avec la pagination.
		$hebergement = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAdminHebergement($page, $numberPaginate);
		$number = 1;
		//Moteur de recherche.
		$form = $this->container->get('form.factory')->create(new Moteur_recherche_hebergementForm());
		//On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			foreach($form->getData() as $word)
			{
			 	$word = $validRole->getSearchEngineAdmin($word);
                                $word = str_replace("\.", '.', $word);
                                $searchByNInterne = is_numeric($word);
                                if($searchByNInterne == false){
                                    $searchByNInterne = is_string($word);
                                }           
			}
			//On recherche l'hébergement par le nom entré avec l'auto-completion
			$result = $em->getRepository('MyAppGlobalBundle:Hebergements')->getSearchHebergement($word);
                        //Si on a une recherche par nom
                        /*if($searchByNInterne == false){
                                $result = null;
                                $result = $em->getRepository('MyAppGlobalBundle:Hebergements')->getSearchHebergementSansRelationAvecUtilisateur($word); 
                        }*/
                        //Si on a une recherche par n° de client
			if($searchByNInterne == true and $result != null){
				$result2 = $em->getRepository("MyAppGlobalBundle:Hebergements")->getExistHebergementNonValideActif($result[0]['id']);
			}	
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
			$lettre = $em->getRepository('MyAppGlobalBundle:Hebergements')->getHebergementByFirstLetter($letter);
			$number = 3;
		}
		//Récupère le nombre de client actifs
		$nbActif = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCompteHebergementActif();
		//Récupère le nombre de client inactifs
		$nbInactif = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCompteHebergementInActif();
		//Récupère le nombre de fiche non publiée
		$nbAttentPublication = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCompteHebergementPublier();
		//on force la variable number à garder 2 si besoin
		(isset($word))? $number = 2 : $number ;		
		//Préparation de la view dashboard_categorie_hebergement.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_hebergement.html.twig',
				array(
						'annee' 					=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'result' 					=> $result,
						'pointeur'					=> 'pointeur',
						'heb' 						=> "menu_hebergement",
						'autocompletion'				=> $autocompletion,
						'lettre'					=> $lettre,
						'number'					=> $number,
						'page'						=> $page,
						'displaypage'					=> $displaypage,
						'firstpage'					=> 1,
						'hebergement'					=> $hebergement,
						'form'						=> $form->createView(),
						'nbhebergement'					=> $total,
						'role'						=> $role,
						'nbClientActif'					=> $nbActif[0]['nbHebergement'],
						'nbClientInactif'				=> $nbInactif[0]['nbHebergement'],
						'nbNonPublication'				=> $nbAttentPublication[0]['nbHebergement'],
						'searchByNInterne'				=> $searchByNInterne,
						'result2'					=> $result2,
				));
	}
	
	/**
	 * Tri des régions avec une province choisie en ajax
	 */
	public function getSortRegionAjaxAdminAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$province = '';
			$province = $request->request->get('province');
			$em = $this->getDoctrine()->getEntityManager();
			if($province != ''){
				//Recherche les régions
				$regionListe = $em->getRepository('MyAppGlobalBundle:Regions')->getRegions($province);
				return $this->render('MyAppAdminBundle:Hebergement:sortRegionAdmin.xml.twig',
                                    array(
                                            "province"  	 => $regionListe,
                                    ));
			}
		}
	}
	
	/**
	 * Tri des zones avec une région choisie en ajax
	 */
	public function getSortZoneAjaxAdminAction()
	{
            $villeListe = "";
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$region = '';
			$region = $request->request->get('region');
			$em = $this->getDoctrine()->getEntityManager();
			if($region != ''){
				//Recherche les zones
				$zoneListe = $em->getRepository('MyAppGlobalBundle:Zones')->getZonesbyRegion($region);
                                // on stocke dans un tableau tous les id de zone qui va servir a voir si on plus 1 zone
                                $tab = [];
                                foreach($zoneListe as $key){
                                    array_push($tab, $key->getId());
                                }
				return $this->render('MyAppAdminBundle:Hebergement:sortZoneAdmin.xml.twig',
                                    array(
                                            "region"                => $zoneListe,
                                            "zoneSelected"          => $region,   
                                            "comptZone"             => count($tab),
                                    ));
			}
		}
	}
	
	/**
	 * Tri des villes avec une zone choisie en ajax
	 */
	public function getSortVilleAjaxAdminAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$zone = '';
			$zone = $request->request->get('zone');
			$em = $this->getDoctrine()->getEntityManager();
			if($zone != ''){
				//Recherche les villes
				$villeListe = $em->getRepository('MyAppGlobalBundle:Villes')->getSelectTownByArea($zone);
				return $this->render('MyAppAdminBundle:Hebergement:sortVilleAdmin.xml.twig',
						array(
							"zone"  	=> $villeListe,
							"villeSelected"	=> $zone,
						));
			}
		}
	}
	
	/**
	 * Retourne la liste des images pour l'affichage des vignettes
	 */
	public function getDisplayThumbnailHebergementAdminAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$listeimg = '';
			$listeimg = $request->request->get('listeimghebergement');
			$tabarray = [];
			$tabarray = preg_split("/[\s,]+/", $listeimg);//Supprime les virgules
			$tab = [];
			foreach($tabarray as $tw){
				array_push($tab, (integer)$tw); //cast les id en integer
			}
			$em = $this->getDoctrine()->getEntityManager();
			if($tab != ''){
				//Retourne la liste
				$retourliste = $em->getRepository('MyAppGlobalBundle:Galerie_hebergement')->getDisplayThumbnail($tab);
				return $this->render('MyAppAdminBundle:Hebergement:display_gallery_hebergement_admin.xml.twig',
						array(
							'listeimg'	=> $retourliste,
						));
			}
		}
	}
	
	/**
	 * Suppression des images pour la galerie de l'hébergement admin avec ajax
	 */
	public function getGalerieHebergementAdminDeleteAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$galimgdelete = '';
			$galimgdelete = $request->request->get('galimgdelete');
			$em = $this->getDoctrine()->getEntityManager();
			if($galimgdelete != ''){
				//Recherche et suppréssion de l'image
				$retourdel = $em->find('MyAppGlobalBundle:Galerie_hebergement', $galimgdelete);
				$em->remove($retourdel);
				$em->flush();
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_hebergement.xml.twig');
			}
		}
	}       
	
	/**
	 * Page du tableau de bord pour ajouter les hébergements.
	 */
	public function addHebergementAction()
	{
		gc_enable();
		$injectrole = "ROLE_ADMIN";
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'un hébergement
		$hebergement = new Hebergements();
		$form = $this->container->get('form.factory')->create(new AddHebergementForm($injectrole), $hebergement);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
				//On enregistre la région, la zone et la ville
				$region = $_POST['listeregion'];
				$zone = $_POST['listezone'];
				$ville = $_POST['listeville'];
				$hebergement->setRegionId($em->find("MyAppGlobalBundle:Regions", $region));
				$hebergement->setZoneId($em->find("MyAppGlobalBundle:Zones", $zone));
				$hebergement->setVilleId($em->find("MyAppGlobalBundle:Villes", $ville));				
				$hebergement->setLatitude($validRole->getFormatValueGps($form->getData()->getLatitude()));
				$hebergement->setLongitude($validRole->getFormatValueGps($form->getData()->getLongitude())); 
                                //validation des noms de répertoires
                                $hebergement->setRepertoireFr($validRole->valideNomRepertoire($form->getData()->getRepertoireFr()));
                                $hebergement->setRepertoireEn($validRole->valideNomRepertoire($form->getData()->getRepertoireEn()));
				$hebergement->setDateCreation(new \DateTime('now'));
				//On enregistre qui à créé l'hébergement
				$hebergement->setValiderPar($user->getUsername());	
				$hebergement->setClassification(substr($form->getData()->getClassificationId()->getValeur(), 0, 1));
				$utilisateur = $em->find('MyAppGlobalBundle:Utilisateur', $form->getData()->getUtilisateur()->getId());
				$utilisateur->setHebergementExiste(true);		
				$em->persist($utilisateur);
				$em->persist($hebergement);
				$em->flush();
				echo 'Hébergement ajouté avec succés !';
				//On redirige vers la liste des hébergements.
				gc_collect_cycles();
				gc_disable();
				return $this->redirect($this->generateUrl('_Dashboard_hebergement'));
		}
                gc_collect_cycles();	
		//Préparation de la view dashboard_addhebergement.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addhebergement.html.twig',
                    array(
                                    'annee' 			=> date('Y'),
                                    'name_admin'		=> $user->getUsername(),
                                    'pointeur' 			=> 'pointeur',
                                    'form'                      => $form->createView(),
                                    'heb' 			=> "menu_hebergement",
                                    'exist'                     => "false",
                                    'role'			=> $role,
                    ));
	}
	
	/**
	 * Page du tableau de bord pour modifier un hébergement.
	 */
	public function updateHebergementAction($id, $number)
	{
		$utilisateur = $classificationExiste = "";
		gc_enable();
		$injecterole = "ROLE_ADMIN";
		//Gestionnaire d'entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère l'hébergement à modifier.
		$modifHebergement = $em->find('MyAppGlobalBundle:Hebergements', $id);
		if($modifHebergement->getUtilisateur() != null){
			//propriétaire de cet hébergement
			define("OLDCUSTOMER", $modifHebergement->getUtilisateur()->getId());
			$utilisateur = $modifHebergement->getUtilisateur()->getId();
                        if($modifHebergement->getClassificationId() != null){
                            //classification de cet hébergement
                            define("OLDCLASSIFICATION", $modifHebergement->getClassificationId()->getId());
                            $classificationExiste = true;
                        }
		}
		//Formulaire de modification d'un hébergement.
		$form = $this->container->get('form.factory')->create(new AddHebergementForm($injecterole), $modifHebergement);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
				//On enregistre la région, la zone et la ville
				$region = $_POST['listeregion'];
				$zone = $_POST['listezone'];
				$ville = $_POST['listeville'];
				$modifHebergement->setRegionId($em->find("MyAppGlobalBundle:Regions", $region));
				$modifHebergement->setZoneId($em->find("MyAppGlobalBundle:Zones", $zone));
				$modifHebergement->setVilleId($em->find("MyAppGlobalBundle:Villes", $ville));
				//Si l'utilisateur est différent on met à jour les données
				if($utilisateur != null){
					if(OLDCUSTOMER != $form->getData()->getUtilisateur()->getId()){
						$userId = $em->find("MyAppGlobalBundle:Utilisateur", OLDCUSTOMER);
						$userId->setHebergementExiste(false);
						$modifHebergement->getUtilisateur()->setHebergementExiste(true);
					}
                                        if($classificationExiste == true){
                                            if(OLDCLASSIFICATION != $form->getData()->getClassificationId()->getId()){
                                                $modifHebergement->setClassification(substr($form->getData()->getClassificationId()->getValeur(), 0, 1));
                                            }
                                        }
				}                   				
				//On valide les cordonnées gps
				$modifHebergement->setLatitude($validRole->getFormatValueGps($form->getData()->getLatitude()));
				$modifHebergement->setLongitude($validRole->getFormatValueGps($form->getData()->getLongitude()));
                                $modifHebergement->setClassification(substr($form->getData()->getClassificationId()->getValeur(), 0, 1));  
                                //validation des noms de répertoires
                                $modifHebergement->setRepertoireFr($validRole->valideNomRepertoire($form->getData()->getRepertoireFr()));
                                $modifHebergement->setRepertoireEn($validRole->valideNomRepertoire($form->getData()->getRepertoireEn()));
				//On enregistre qui à modifié l'hébergement
				$modifHebergement->setValiderPar($user->getUsername());		
				$em->persist($modifHebergement);			
				$em->flush();
				gc_collect_cycles();	
				gc_disable();
				echo 'Hébergement modifié avec succés !';
				if(is_string($number) and $number != "number")
				{
					//On redirige vers la liste des clients.
					unset($modifHebergement);
					return $this->redirect($this->generateUrl('_Dashboard_clients'));
				}
				else 
				{
					//On redirige vers la liste des hébergements.
					unset($modifHebergement);
					return $this->redirect($this->generateUrl('_Dashboard_hebergement'));
				}
		}
		//Liste des régions
		$listeregion = $em->getRepository("MyAppGlobalBundle:Regions")->getRegions($modifHebergement->getProvinceId()->getId());
		//Liste des zones
		$listezone = $em->getRepository("MyAppGlobalBundle:Zones")->getZonesbyRegion($modifHebergement->getRegionId()->getId());	
		//Liste des villes
		$listeville = $em->getRepository("MyAppGlobalBundle:Villes")->getSelectTownByArea($modifHebergement->getZoneId()->getId());
                gc_collect_cycles();	
		//Préparation de la view dashboard_addhebergement.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addhebergement.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin' 				=> $user->getUsername(),
						'pointeur'				=> 'pointeur',
						'form' 					=> $form->createView(),
                                                'id'                                    => $id,
						'infonom' 				=> $modifHebergement->getNomFr(),
						'heb' 					=> "menu_hebergement",
						'role'					=> $role,
						'utilisateur'				=> $utilisateur,
						'repertoirefr'				=> $modifHebergement->getRepertoireFr(),
						'infoLogo'				=> $modifHebergement->getLogo(),
						'infoimg'				=> $modifHebergement->getPhotoCategoriePayante(),
						'photoPrincipale'			=> $modifHebergement->getPhotoPayante(),
						'txtFr'					=> str_replace(array("\r\n"), " ", html_entity_decode( $modifHebergement->getTexteDescriptionFr())),
						'txtEn'					=> str_replace(array("\r\n"), " ", html_entity_decode( $modifHebergement->getTexteDescriptionEn())),
						'lat'					=> $modifHebergement->getLatitude(),
						'long'					=> $modifHebergement->getLongitude(),
						'regionrecorder'			=> $listeregion,
						'zonerecorder'				=> $listezone,
						'villerecorder'				=> $listeville,
						'regionSelected'			=> $modifHebergement->getRegionId()->getId(),
						'zoneSelected'				=> $modifHebergement->getZoneId()->getId(),
						'villeSelected'				=> $modifHebergement->getVilleId()->getId(),
		));
	}
	
	/**
	 * Page du tableau de bord pour supprimer un hébergement.
	 */
	public function deleteHebergementAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère l'hébergement à supprimer
                (is_numeric($id) == true)? $id : trigger_error("Aucun id trouvé pour la suppression.");
		$hebergement = $em->find('MyAppGlobalBundle:Hebergements', $id);
                //On recherche ses galerie photos et chambres pour supprimer
                $listeChambre = $em->getRepository("MyAppGlobalBundle:Chambres")->getChambreDeLEtablissement($hebergement->getId());
                if($listeChambre != null){
                    for($i = 0; $i < count($listeChambre); $i++){
                        $chambres = $em->find("MyAppGlobalBundle:Chambres", $listeChambre[$i]->getId());
                        $em->remove($chambres);
                    }
                }
                //On recherche les forfaits
                $listeForfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getListeTousLesForfaits($hebergement->getId());
                if($listeForfait != null){
                    for($i = 0; $i < count($listeForfait); $i++){
                        $forfaits = $em->find("MyAppGlobalBundle:Forfaits_clients", $listeForfait[$i]->getId());
                        $em->remove($forfaits);                       
                    }
                }
                //On recherche ses attraits
                $listeAttrait = $em->getRepository("MyAppGlobalBundle:Attraits")->getHebergementByAttrait($hebergement->getId());
                if($listeAttrait != null){
                    for($i = 0; $i < count($listeAttrait); $i++){
                        $attraits = $em->find("MyAppGlobalBundle:Attraits", $listeAttrait[$i]->getId());
                        $em->remove($attraits);                       
                    }
                }
                if($hebergement->getUtilisateur() != null){
                    //Liste hébergement
                    $listeHebergement = $em->getRepository("MyAppGlobalBundle:Hebergements")->getExistHebergement($hebergement->getUtilisateur()->getId());
                    if(count($listeHebergement) == 1 ){
                            //Fait une mise à jour du client
                            $utilisateur = $em->find("MyAppGlobalBundle:Utilisateur", $hebergement->getUtilisateur()->getId());
                            $utilisateur->setHebergementExiste(false);
                    }
                }                       
		$em->remove($hebergement);
		$em->flush();
		//On redirige vers la page d'accueil des hébergements
		return $this->redirect($this->generateUrl('_Dashboard_hebergement'));
	}
	
/*####################################################################################*/
/*############### SECTION CATÉGORIES D'HÉBERGEMENTS ##################################*/
/*####################################################################################*/
	
	/**
	 * Page du tableau de bord pour afficher et gérer les catégories d'hébergements.
	 */
	public function categorieHebergementAction()
	{
		//Gestionnaire d'entité
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
               // var_dump($user);
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des pays pour les afficher.
		$categorie = $em->getRepository('MyAppGlobalBundle:Categories_hebergements')->getListCategoryHebergement();
		//Préparation de la view dashboard_categorie_hebergement_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_categoriehebergement.html.twig',
                    array(
                                    'annee' 			=> date('Y'),
                                    'name_admin' 		=> $user->getUsername(),
                                    'categorie' 		=> $categorie,
                                    'pointeur'			=> 'pointeur',
                                    'catheb'                    => "menu_hebergement",
                                    'role'                      => $role,
                    ));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les catégories d'hébergements.
	 */
	public function addCategorieHebergementAction()
	{
		//Gestionnaire d'entité
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'une catégorie
		$categorie = new Categories_hebergements();
		$form = $this->container->get('form.factory')->create(new AddCategorieHebergementForm(), $categorie);
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
				// On l'enregistre notre objet $categorie dans la base de données.
				$txtfr = $validRole->getSecureData($_POST['editor1']);
				$txten = $validRole->getSecureData($_POST['editor2']);
				//Persistance des textes descriptifs
				$categorie->setTexteFr($txtfr);
				$categorie->setTexteEn($txten);
				//On valide que le champs photo est pas vide
				$img = $form->getData()->getImageDoctrine();
				if($img != null){
					$modifCategorie->setImage($img);
				}
				$em->persist($categorie);
				$em->flush();
				echo 'Catégorie ajoutée avec succés !';
				//On redirige vers la liste des catégories.
				return $this->redirect($this->generateUrl('_Dashboard_categoriehebergement'));
			}
		}
		//Préparation de la view dashboard_addcategoriehebergement.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addcategoriehebergement.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'catheb' 						=> "menu_hebergement",
						'exist' 						=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier un pays.
	 */
	public function updateCategorieHebergementAction($id)
	{
                
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la catégorie à modifier.
		$modifCategorie = $em->find('MyAppGlobalBundle:Categories_hebergements', $id);
		//Formulaire d'ajout d'un pays.
		$form = $this->container->get('form.factory')->create(new AddCategorieHebergementForm(), $modifCategorie);
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
				//On valide les textes de l'éditeur
				$txtfr = $validRole->getSecureData($_POST['editor1']);
				$txten = $validRole->getSecureData($_POST['editor2']);
				//On persiste les textes de l'éditeur
				$modifCategorie->setTexteFr($txtfr);
				$modifCategorie->setTexteEn($txten);
				//On valide que le champs photo est pas vide
				$img = $form->getData()->getImageDoctrine();
				if($img != null){
					$modifCategorie->setImage($img);
				}
				$em->persist($modifCategorie);
				$em->flush();
                             
				echo 'Catégorie modifiée avec succés !';
				//On redirige vers la liste des catégories d'hébergements.
				return $this->redirect($this->generateUrl('_Dashboard_categoriehebergement'));
			}
		}
		//Préparation de la view dashboard_addcategoriehebergement.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addcategoriehebergement.html.twig',
				array(
						'annee' 					=> date('Y'),
						'name_admin'                                    => $user->getUsername(),
						'pointeur'				 	=> 'pointeur',
						'form' 						=> $form->createView(),
						'infoid' 					=> $id,
						'infonom' 					=> $modifCategorie->getNomFr(),
						'infoimg'					=> $modifCategorie->getImage(),
						'textFr'					=> str_replace(array("\r\n"), " ", html_entity_decode( $modifCategorie->getTexteFr())),
						'textEn'					=> str_replace(array("\r\n"), " ", html_entity_decode( $modifCategorie->getTexteEn())),
						'catheb' 					=> "menu_hebergement",
						'role'						=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour supprimer une catégorie d'hébergement.
	 */
	public function deleteCategorieHebergementAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère la catégorie d'hébergement à supprimer
		$categorie = $em->find('MyAppGlobalBundle:Categories_hebergements', $id);
		$em->remove($categorie);
		$em->flush();
		//On redirige vers la page d'accueil des catégories d'hébergements.
		return $this->redirect($this->generateUrl('_Dashboard_categoriehebergement'));
	}

/*####################################################################################*/
/*############### SECTION ACTIVITÉS ##################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les activités des hebergements
	 */
	public function activiteAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Affiche la liste des activités
		$activite = $em->getRepository('MyAppGlobalBundle:Hebergements_activites')->getListActivites();
		//Préparation de la view dashboard_activite_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_activite.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'actheb' 						=> "menu_hebergement",
						'activite'						=> $activite,
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter une activité 
	 */
	public function addActiviteAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Création du formulaire .
		$activite = new Hebergements_activites();
		$form = $this->container->get('form.factory')->create(new AddHebergements_activitesForm(), $activite);
		$request = $this->get('request');
		// On vérifie qu'elle est de type é POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requéte <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $activite dans la base de données.
				$em->persist($activite);
				$em->flush();
				echo 'Activité ajoutée avec succés !';
				//On redirige vers la liste des activités.
				return $this->redirect($this->generateUrl('_Dashboard_activiteshebergement'));
			}
		}
		//Préparation de la view dashboard_addactivite_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addactivite.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'actheb' 						=> "menu_hebergement",
						'form'							=> $form->createView(),
						'exist'							=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier une activité
	 */
	public function updateActiviteAction($id)
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupére le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Création du formulaire .
		$modifActivite = $em->find('MyAppGlobalBundle:Hebergements_activites', $id);
		$form = $this->container->get('form.factory')->create(new AddHebergements_activitesForm(), $modifActivite);
		$request = $this->get('request');
		// On vérifie qu'elle est de type é POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requéte <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $modifActivite dans la base de données.
				$em->persist($modifActivite);
				$em->flush();
				echo 'Activité modifiée avec succés !';
				//On redirige vers la liste des activités.
				return $this->redirect($this->generateUrl('_Dashboard_activiteshebergement'));
			}
		}
		//Préparation de la view dashboard_addactivite_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addactivite.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'actheb' 						=> "menu_hebergement",
						'form'							=> $form->createView(),
						'infoid'						=> $id,
						'infonom'						=> $modifActivite->getNomFr(),
						'infoimg'						=> $modifActivite->getImage(),
						'role'							=> $role,
				));
	}
	
	/**
	 * Suppréssion d'une activité
	 */
	public function deleteActiviteAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère l'activité à supprimer
		$activite = $em->find('MyAppGlobalBundle:Hebergements_activites', $id);
		$em->remove($activite);
		$em->flush();
		//On redirige vers la liste des activités.
		return $this->redirect($this->generateUrl('_Dashboard_activiteshebergement'));
	}
/*####################################################################################*/
/*############### SECTION SERVICES ###################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les services des hebergements
	 */
	public function serviceAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupére le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Affiche la liste des services
		$service = $em->getRepository('MyAppGlobalBundle:Hebergements_services')->getListservices();
		//Préparation de la view dashboard_service_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_service.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'serheb' 						=> "menu_hebergement",
						'service'						=> $service,
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter un service
	 */
	public function addServiceAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupére le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Création du formulaire .
		$service = new Hebergements_services();
		$form = $this->container->get('form.factory')->create(new AddHebergements_servicesForm(), $service);
		$request = $this->get('request');
		// On vérifie qu'elle est de type é POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requéte <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $service dans la base de données.
				$em->persist($service);
				$em->flush();
				echo 'Service ajouté avec succés !';
				//On redirige vers la liste des services
				return $this->redirect($this->generateUrl('_Dashboard_serviceshebergement'));
			}
		}
		//Préparation de la view dashboard_addservice_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addservice.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'serheb' 						=> "menu_hebergement",
						'form'							=> $form->createView(),
						'exist'							=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier un service
	 */
	public function updateServiceAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupére le nom de la personne qui accéde à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Création du formulaire .
		$modifService = $em->find('MyAppGlobalBundle:Hebergements_services', $id);
		$form = $this->container->get('form.factory')->create(new AddHebergements_servicesForm(), $modifService);
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST é.
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $service dans la base de données.
				$em->persist($modifService);
				$em->flush();
				echo 'Service modifié avec succés !';
				//On redirige vers la liste des services
				return $this->redirect($this->generateUrl('_Dashboard_serviceshebergement'));
			}
		}
		//Préparation de la view dashboard_addservice_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addservice.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'serheb' 						=> "menu_hebergement",
						'form'							=> $form->createView(),
						'infoid'						=> $id,
						'infonom'						=> $modifService->getNomFr(),
						'infoimg'						=> $modifService->getImage(),
						'role'							=> $role,
				));
	}
	
	/**
	 * Suppréssion d'un service
	 */
	public function deleteServiceAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupére le service à supprimer
		$service = $em->find('MyAppGlobalBundle:Hebergements_services', $id);
		$em->remove($service);
		$em->flush();
		//On redirige vers la liste des services
		return $this->redirect($this->generateUrl('_Dashboard_serviceshebergement'));
	}

/*####################################################################################*/
/*############### SECTION STYLES #####################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les styles des hebergements
	 */
	public function styleAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Affiche la liste des styles
		$style = $em->getRepository('MyAppGlobalBundle:Styles_hebergements')->getListStyleHebergement();
		//Préparation de la view dashboard_style_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_style.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'styheb' 						=> "menu_hebergement",
						'style' 						=> $style,
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter un style
	 */
	public function addStyleAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Création du formulaire .
		$style = new Styles_hebergements();
		$form = $this->container->get('form.factory')->create(new AddStyleForm(), $style);
		$request = $this->get('request');
		// On vérifie qu'elle est de type «  POST  ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On enregistre notre objet $style dans la base de données.
				$em->persist($style);
				$em->flush();
				echo 'Style ajouté avec succés !';
				//On redirige vers la liste des styles
				return $this->redirect($this->generateUrl('_Dashboard_styleshebergement'));
			}
		}
		//Préparation de la view dashboard_addservice_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addstyle.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'styheb' 						=> "menu_hebergement",
						'form'							=> $form->createView(),
						'exist'							=> "true",
						'role'							=> $role,
				));

	}
	
	/**
	 * Page du tableau de bord pour modifier un style
	 */
	public function updateStyleAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Création du formulaire .
		$modifStyle = $em->find('MyAppGlobalBundle:Styles_hebergements', $id);
		$form = $this->container->get('form.factory')->create(new AddStyleForm(), $modifStyle);
		$request = $this->get('request');
		// On vérifie qu'elle est de type «  POST  ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On enregistre notre objet $modifStyle dans la base de données.
				$em->persist($modifStyle);
				$em->flush();
				echo 'Service modifié avec succés !';
				//On redirige vers la liste des styles
				return $this->redirect($this->generateUrl('_Dashboard_styleshebergement'));
			}
		}
		//Préparation de la view dashboard_addstyle_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addstyle.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'styheb' 						=> "menu_hebergement",
						'form'							=> $form->createView(),
						'infoid'						=> $id,
						'infonom'						=> $modifStyle->getNomFr(),
						'role'							=> $role,
				));
	}
	
	/**
	 * Suppréssion d'un style
	 */
	public function deleteStyleAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le style à supprimer
		$style = $em->find("MyAppGlobalBundle:Styles_hebergements", $id);
		$em->remove($style);
		$em->flush();
		//On redirige vers la liste des styles.
		return $this->redirect($this->generateUrl("_Dashboard_styleshebergement"));
	}
/*####################################################################################*/
/*############### SECTION TYPES DE CHAMBRES ##########################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les types de chambres
	 */
	public function typeChambreAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Affiche la liste des types de chambres
		$typechambre = $em->getRepository('MyAppGlobalBundle:Chambres')->getTypesChambres();
		//Préparation de la view dashboard_typechambre_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_typechambre.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'chamheb' 						=> "menu_hebergement",
						'typechambre'					=> $typechambre,
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter un type de chambre
	 */
	public function addTypeChambreAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Création du formulaire .
		$typeChambre = new Types_chambres();
		$form = $this->container->get('form.factory')->create(new AddTypeChambreForm(), $typeChambre);
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $typeChambre dans la base de données.
				$em->persist($typeChambre);
				$em->flush();
				echo 'Type de chambre ajouté avec succés !';
				//On redirige vers la liste des services
				return $this->redirect($this->generateUrl('_Dashboard_typechambreshebergement'));
			}
		}
		//Préparation de la view dashboard_addtypechambre_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addtypechambre.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'chamheb' 						=> "menu_hebergement",
						'form'							=> $form->createView(),
						'exist'							=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier un type de chambre
	 */
	public function updateTypeChambreAction($id)
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Création du formulaire .
		$modifTypeChambre = $em->find('MyAppGlobalBundle:Types_chambres', $id);
		$form = $this->container->get('form.factory')->create(new AddTypeChambreForm(), $modifTypeChambre);
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $modifTypeChambre dans la base de données.
				$em->persist($modifTypeChambre);
				$em->flush();
				echo 'Type de chambre modifié avec succés !';
				//On redirige vers la liste des types de chambres
				return $this->redirect($this->generateUrl('_Dashboard_typechambreshebergement'));
			}
		}
		//Préparation de la view dashboard_addtypechambre_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addtypechambre.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'chamheb' 						=> "menu_hebergement",
						'form'							=> $form->createView(),
						'infoid'						=> $id,
						'infonom'						=> $modifTypeChambre->getNomFr(),
						'role'							=> $role,
				));
	}
	
	/**
	 * Suppréssion d'un type de chambre
	 */
	public function deleteTypeChambreAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le type de chambre à supprimer
		$typechambre = $em->find('MyAppGlobalBundle:Types_chambres', $id);
		$em->remove($typechambre);
		$em->flush();
		//On redirige vers la liste des types de chambres
		return $this->redirect($this->generateUrl('_Dashboard_typechambreshebergement'));
	}
/*####################################################################################*/
/*############### SECTION CHAMBRES ###################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les chambres des hebergements
	 */
	public function chambreAction($page, $letter)
	{
		$numberPaginate = 30;
		$number = 0;
		$lettre = $result = "";
		
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des chambres pour l'autocompletion.
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAutocompletionHebergement();
		//Affiche le nombre maximum de chambre dans la table.
		$nbchambre = $em->getRepository('MyAppGlobalBundle:Chambres')->getCompteChambre();
		$total = $nbchambre[0]['nbchambre'];
		//On divise le nombre total de zone  par le nombre que l'on souhaite afficher de zone sur la page et on le transforme en entier.
		$displaypage = ceil($total / $numberPaginate);
		//Si il n'existe pas de numéro de page dans l'url alors on prend la valeur 1 par défaut.
		$page = $validRole->getValideEntierPagination($page, $displaypage);
		//Récupère la liste des chambres pour la pagination.
		$chambre = $em->getRepository('MyAppGlobalBundle:Chambres')->getChambres($page, $numberPaginate);
		$number = 1;
		//Création du formulaire pour le moteur de recherche.
		$form = $this->container->get('form.factory')->create(new Moteur_recherche_chambreForm());
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			foreach($form->getData() as $word)
			{	
				//On nettoie la recherche
				 $word = $validRole->getSearchEngineAdmin($word);
			}
			//On récupère l'id du client par son nom  d'établissement.
			$resultId = $em->getRepository('MyAppGlobalBundle:Hebergements')->getRechercheNomHebergement($word);
			//On contrôle si l'établissement à plusieurs chambres.
			$result = $em->getRepository('MyAppGlobalBundle:Chambres')->getChambreDeLEtablissement($resultId[0]->getId());
			$number = 2;
		}
		//On contrôle que le paramètre envoyer est bien de type string, qu'il contient bien une lettre.
		if(is_string($letter) == 1 and $letter !== 'letter' and strlen($letter) === 1)
		{
			$lettre = $em->getRepository('MyAppGlobalBundle:Chambres')->getChambreByFirstLetter($letter);
			$number = 3;
		}
		(isset($word))? $number = 2 : $number ;
		//Préparation de la view dashboard_chambre_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_chambre.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur'						=> 'pointeur',
						'chamheb' 						=> "menu_hebergement",
						'chamhebUnder'					=> "menu_hebergement",
						'chambre'						=> $chambre,
						'autocompletion'				=> $autocompletion,
						'result'						=> $result,
						'number'						=> $number,
						'form'							=> $form->createView(),
						'page'							=> $page,
						'firstpage'						=> 1,
						'displaypage'					=> $displaypage,
						'lettre'						=> $lettre,	
						'role'							=> $role,		
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter une chambre
	 */
	public function addChambreAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Création du formulaire pour le moteur de recherche.
		$chambre = new Chambres();
		$form = $this->container->get('form.factory')->create(new AddChambresForm(), $chambre);
		//On récupère la requête
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On n'enregistre notre objet $chambre dans la base de données.
				$em->persist($chambre);
				$em->flush();
				echo 'Chambre ajoutée avec succés !';
				//On redirige vers la liste des types de chambre.
				return $this->redirect($this->generateUrl('_Dashboard_chambreshebergement'));
			}
		}
		//Préparation de la view dashboard_addchambre_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addchambre.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur'						=> 'pointeur',
						'chamheb' 						=> "menu_hebergement",
						'chamhebUnder'					=> "menu_hebergement",
						'form'							=> $form->createView(),
						'exist'							=> "false",
						'role'							=> $role,
		
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier une chambre
	 */
	public function updateChambreAction($id)
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//On recherche la chambre à modifier
		$modifChambre = $em->find("MyAppGlobalBundle:Chambres", $id);
		//Création du formulaire pour le moteur de recherche.
		$form = $this->container->get('form.factory')->create(new AddChambresForm(), $modifChambre);
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
				$imgPresentation = $form->getData()->getPhoto1Doctrine();
				if($imgPresentation != null){
					$modifChambre->setPhoto1($imgPresentation);
				}
				// On n'enregistre notre objet $modifChambre dans la base de données.
				$em->persist($modifChambre);
				$em->flush();
				echo 'Chambre modifiée avec succés !';
				//On redirige vers la liste des types de chambre.
				return $this->redirect($this->generateUrl('_Dashboard_chambreshebergement'));
			}
		}
		//Préparation de la view dashboard_addchambre_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addchambre.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur'						=> 'pointeur',
						'chamheb' 						=> "menu_hebergement",
						'chamhebUnder'					=> "menu_hebergement",
						'form'							=> $form->createView(),
						'infoid'						=> $id,
						'infonom'						=> $modifChambre->getNomFr(),
						'role'							=> $role,
						'imgPresentation'				=> $modifChambre->getPhoto1(),
						'listeTypeChambre'				=> $modifChambre->getTypeChambreId(),
						'listeLit'						=> $modifChambre->getLitId(),
						'listeEquipement'				=> $modifChambre->getEquipementId(),
				));
	}
	
	/**
	 * Suppréssion d'une chambre
	 */
	public function deleteChambreAction($id)
	{
	 $em = $this->getDoctrine()->getEntityManager();
	 //On récupère le type de chambre à supprimer
	 $chambre = $em->find('MyAppGlobalBundle:Chambres', $id);
	 $em->remove($chambre);
	 $em->flush();
	 //On redirige vers la page d'accueil des type de chambre
	 return $this->redirect($this->generateUrl('_Dashboard_chambreshebergement'));
	}

/*####################################################################################*/
/*############### SECTION LITS #######################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les lits des hebergements
	 */
	public function litAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupére la liste des lits pour les afficher.
		$lit = $em->getRepository('MyAppGlobalBundle:Lits')->getListeLits();
		//Préparation de la view dashboard_categorie_hebergement_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_lit.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur'						=> 'pointeur',
						'chamheb' 						=> "menu_hebergement",
						'chamLitUnder'					=> "menu_hebergement",
						'lits'							=> $lit,
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter un lit
	 */
	public function addLitAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'un type de lit
		$lit = new Lits();
		$form = $this->container->get('form.factory')->create(new AddLitsForm(), $lit);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type «  POST  ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $lit dans la base de données.
				$em->persist($lit);
				$em->flush();
				echo 'Lit ajouté avec succés !';
				//On redirige vers la liste des lits.
				return $this->redirect($this->generateUrl('_Dashboard_litshebergement'));
			}
		}		
		//Préparation de la view dashboard_addlit.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addlit.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'chamheb' 						=> "menu_hebergement",
						'chamLitUnder'					=> "menu_hebergement",
						'exist' 						=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier un lit
	 */
	public function updateLitAction($id)
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupére le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire de modification du type de lit 
		$modifLit = $em->find('MyAppGlobalBundle:Lits', $id);
                
               // $modifLit = $em->getRepository('MyAppGlobalBundle:Lits')->getChercheLit($id);
                
		$form = $this->container->get('form.factory')->create(new AddLitsForm(), $modifLit);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type «  POST  ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $lit dans la base de données.
				$em->persist($modifLit);
				$em->flush();
				echo 'Lit modifié avec succés !';
				//On redirige vers la liste des lits.
				return $this->redirect($this->generateUrl('_Dashboard_litshebergement'));
			}
		}
		//Préparation de la view dashboard_addlit.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addlit.html.twig',
                    array(
                            'annee' 			=> date('Y'),
                            'name_admin'                => $user->getUsername(),
                            'pointeur' 			=> 'pointeur',
                            'form' 			=> $form->createView(),
                            'chamheb' 			=> "menu_hebergement",
                            'chamLitUnder'		=> "menu_hebergement",
                            'infoid'			=> $id,
                            'infonom'			=> $modifLit->getNomFr(),
                            'role'			=> $role,
                    ));
	}
	
	/**
	 * Suppréssion d'un lit
	 */
	public function deleteLitAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le type de lit à supprimer
		$lit = $em->find('MyAppGlobalBundle:Lits',$id);
		$em->remove($lit);
		$em->flush();
		//On redirige vers la page d'accueil des lits
		return $this->redirect($this->generateUrl('_Dashboard_litshebergement'));
	}

/*####################################################################################*/
/*############### SECTION OCCUPATIONS ################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les occupations des hebergements
	 */
	public function occupationAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des occupations pour les afficher.
		$occupation = $em->getRepository('MyAppGlobalBundle:Types_occupations')->getListTypeOccupation();
		//Préparation de la view dashboard_typeoccupation_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_typeoccupation.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur'						=> 'pointeur',
						'occuheb' 						=> "menu_hebergement",
						'occupation'					=> $occupation,
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter une occupation
	 */
	public function addOccupationAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'une occupation
		$occupation = new Types_occupations();
		$form = $this->container->get('form.factory')->create(new AddTypeOccupationForm(), $occupation);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type «  POST  ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On enregistre notre objet $occupation dans la base de données.
				$em->persist($occupation);
				$em->flush();
				echo 'Occupation ajouté avec succés !';
				//On redirige vers la liste des occupations.
				return $this->redirect($this->generateUrl('_Dashboard_occupationshebergement'));
			}
		}
		//Préparation de la view dashboard_addoccupation.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addoccupation.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'occuheb' 						=> "menu_hebergement",
						'exist' 						=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier une occupation
	 */
	public function updateOccupationAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire de modification d'une occupation
		$modifOccupation = $em->find('MyAppGlobalBundle:Types_occupations', $id);
		$form = $this->container->get('form.factory')->create(new AddTypeOccupationForm(), $modifOccupation);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type «  POST  ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On enregistre notre objet $modifOccupation dans la base de données.
				$em->persist($modifOccupation);
				$em->flush();
				echo 'Occupation modifiée avec succés !';
				//On redirige vers la liste des occupations.
				return $this->redirect($this->generateUrl('_Dashboard_occupationshebergement'));
			}
		}
		//Préparation de la view dashboard_addoccupation.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addoccupation.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'occuheb' 						=> "menu_hebergement",
						'infoid'						=> $id,
						'infonom'						=> $modifOccupation->getNomFr(),
						'role'							=> $role
				));
	}
	
	/**
	 * Suppréssion d'une occupation
	 */
	public function deleteOccupationAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère l'occupation à supprimer.
		$occupation = $em->find('MyAppGlobalBundle:Types_occupations', $id);
		$em->remove($occupation);
		$em->flush();
		//On redirige vers la liste des occupations.
		return $this->redirect($this->generateUrl('_Dashboard_occupationshebergement'));
	}
/*####################################################################################*/
/*############### SECTION ÉQUIPEMENTS ################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les équipements des hebergements
	 */
	public function equipementAction()
	{
		//Gestionnaire d'entité
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des équipements pour les afficher.
		$equipement = $em->getRepository('MyAppGlobalBundle:Equipements')->getListEquipements();
		//Préparation de la view dashboard_equipement_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_equipement.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur'						=> 'pointeur',
						'equiheb' 						=> "menu_hebergement",
						'equipement'					=> $equipement,
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter un équipement
	 */
	public function addEquipementAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'un équipement
		$equipement = new Equipements();
		$form = $this->container->get('form.factory')->create(new AddEquipementsForm(), $equipement);
		// On récupêre la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $equipement dans la base de données.
				$em->persist($equipement);
				$em->flush();
				echo 'équipement ajouté avec succés !';
				//On redirige vers la liste des équipements.
				return $this->redirect($this->generateUrl('_Dashboard_equipementshebergement'));
			}
		}
		//Préparation de la view dashboard_addequipementt.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addequipement.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'equiheb' 						=> "menu_hebergement",
						'exist' 						=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier un équipement
	 */
	public function updateEquipementAction($id)
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'un équipement
		$modifEquipement = $em->find('MyAppGlobalBundle:Equipements',$id);
		$form = $this->container->get('form.factory')->create(new AddEquipementsForm(), $modifEquipement);
		// On récupère la requéte.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $modifEquipement dans la base de données.
				$em->persist($modifEquipement);
				$em->flush();
				echo 'équipement modifié avec succés !';
				//On redirige vers la liste des équipements.
				return $this->redirect($this->generateUrl('_Dashboard_equipementshebergement'));
			}
		}
		//Préparation de la view dashboard_addequipementt.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addequipement.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'equiheb' 						=> "menu_hebergement",
						'infoid'						=> $id,
						'infonom'						=> $modifEquipement->getNomFr(),
						'infoimg'						=> $modifEquipement->getImage(),
						'role'							=> $role,
				));
	}
	
	/**
	 * Suppréssion d'un équipement
	 */
	public function deleteEquipementAction($id)
	{
		$em = $this->getDoctrine()->getEntitymanager();
		//On récupère l'équipement à supprimer
		$equipement = $em->find('MyAppGlobalBundle:Equipements',$id);
		$em->remove($equipement);
		$em->flush();
		//On redirige vers la page d'accueil des équipements
		return $this->redirect($this->generateUrl('_Dashboard_equipementshebergement'));
	}
/*####################################################################################*/
/*############### SECTION AFFILIATION ################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les affiliations des hebergements
	 */
	public function affiliationAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupére la liste des affiliations pour les afficher.
		$affiliation = $em->getRepository('MyAppGlobalBundle:Affiliations')->getListAffiliation();
		//Préparation de la view dashboard_affiliation_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_affiliation.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur'						=> 'pointeur',
						'affiheb' 						=> "menu_hebergement",
						'affiliation'					=> $affiliation,
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter une affiliation
	 */
	public function addAffiliationAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'une affiliation
		$affiliation = new Affiliations();
		$form = $this->container->get('form.factory')->create(new AddAffiliationsForm(), $affiliation);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type «  POST  ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $affiliation dans la base de données.
				$em->persist($affiliation);
				$em->flush();
				echo 'Affiliation ajoutée avec succés !';
				//On redirige vers la liste des affiliations.
				return $this->redirect($this->generateUrl('_Dashboard_affiliationshebergement'));
			}
		}	
		//Préparation de la view dashboard_addhebergement.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addaffiliation.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'affiheb' 						=> "menu_hebergement",
						'exist' 						=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier une affiliation
	 */
	public function updateAffiliationAction($id)
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire de modification des affiliations
		$modifAffiliation = $em->find('MyAppGlobalBundle:Affiliations', $id);
		$form = $this->container->get('form.factory')->create(new AddAffiliationsForm(), $modifAffiliation);
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
				// On l'enregistre notre objet $modifAffiliation dans la base de données.
				$logoAffil = $form->getData()->getImageDoctrine();
				if($logoAffil != null){
                                    //regarde si une image existe déjà pour supprimer l'ancienne qui evitera un bug lors de la suppression cette affiliation
                                    if($modifAffiliation->getImage() != null){         
                                        //Récupère le chemin
                                        $dir = $modifAffiliation->getAccessRepertoire();
                                        $repertoire = setType($dir, "string" );
                                        //On regarde si le dossier existe
                                        if(is_dir( $repertoire ) === true){
                                            try {
                                                unlink($modifAffiliation->getAccessRepertoire().$modifAffiliation->getId()."/".$modifAffiliation->getImage());  
                                            } catch (E_WARNING $ex) {
                                                trigger_error("Erreur pour l'enregistrement de l'image.". $ex);
                                            }
                                        }
                                    }
                                    $modifAffiliation->setImage($logoAffil);
				}
				$em->persist($modifAffiliation);
				$em->flush();
				echo 'Affiliation modifiée avec succés !';
				//On redirige vers la liste des affiliations.
				return $this->redirect($this->generateUrl('_Dashboard_affiliationshebergement'));
			}
		}
		//Préparation de la view dashboard_addaffiliation.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addaffiliation.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'                                            => $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'affiheb' 						=> "menu_hebergement",
						'infoid'						=> $id,
						'infonom'						=> $modifAffiliation->getNomFr(),
						'infoimg'						=> $modifAffiliation->getImage(),	
						'role'							=> $role,					
				));
	}
	
	/**
	 * Suppréssion d'une affiliation
	 */
	public function deleteAffiliationAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupére l'affiliation à supprimer
		$affiliation = $em->find('MyAppGlobalBundle:Affiliations', $id);
		$em->remove($affiliation);
		$em->flush();
		//On redirige vers la page d'accueil des affiliations
		return $this->redirect($this->generateUrl('_Dashboard_affiliationshebergement'));
	}
/*####################################################################################*/
/*############### SECTION SERVICES CORPORATIFS #######################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les services corporatifs des hebergements
	 */
	public function serviceCorporatifAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupére la liste des services corporatifs pour les afficher.
		$serviceCorporatif = $em->getRepository('MyAppGlobalBundle:Corporatifs_services')->getListCorporatifService();
		//Préparation de la view dashboard_servicecorporatif.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_servicecorporatif.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur'						=> 'pointeur',
						'corpheb' 						=> "menu_hebergement",
						'serviceCorporatif'				=> $serviceCorporatif,
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter un service corporatif
	 */
	public function addServiceCorporatifAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'un type événement corporatif
		$corporatif = new Corporatifs_services();
		$form = $this->container->get('form.factory')->create(new AddCorporatifServiceForm(), $corporatif);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type «  POST  ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $evenement dans la base de données.
				$em->persist($corporatif);
				$em->flush();
				echo 'Service corporatif ajouté avec succés !';
				//On redirige vers la liste des événements corporatifs.
				return $this->redirect($this->generateUrl('_Dashboard_evenementscoporatifshebergement'));
			}
		}
		//Préparation de la view dashboard_addservicecorporatif.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addservicecorporatif.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'corpheb' 						=> "menu_hebergement",
						'exist' 						=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier un service corporatif
	 */
	public function updateServiceCorporatifAction($id)
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'un type service corporatif
		$modifServiceCorpo = $em->find('MyAppGlobalBundle:Corporatifs_services', $id);
		$form = $this->container->get('form.factory')->create(new AddCorporatifServiceForm(), $modifServiceCorpo);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type «  POST  ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On l'enregistre notre objet $evenement dans la base de données.
				$em->persist($modifServiceCorpo);
				$em->flush();
				echo 'Service corporatif ajouté avec succés !';
				//On redirige vers la liste des services corporatifs.
				return $this->redirect($this->generateUrl('_Dashboard_servicecorporatifhebergement'));
			}
		}
		//Préparation de la view dashboard_addservicecorporatif.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addservicecorporatif.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'corpheb' 						=> "menu_hebergement",
						'infoid'						=> $id,
						'infonom'						=> $modifServiceCorpo->getNomFr(),
						'infoimg'						=> $modifServiceCorpo->getImage(),
						'role'							=> $role,
				));
	}
	
	/**
	 * Suppréssion d'un service corporatif
	 */
	public function deleteServiceCorporatifAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupére le service corporatif à supprimer
		$evenementCorpo = $em->find('MyAppGlobalBundle:Corporatifs_services', $id);
		$em->remove($evenementCorpo);
		$em->flush();
		//On redirige vers la page d'accueil des services corporatifs
		return $this->redirect($this->generateUrl('_Dashboard_servicecorporatifhebergement'));
	}
/*####################################################################################*/
/*############### SECTION SALLES CORPORATIVES ########################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les salles corporatives des hebergements
	 */
	public function salleCorporativeAction()
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des services corporatifs pour les afficher.
		$salleCorporative = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListSalleCorporative();
		//Préparation de la view dashboard_sallecorporative.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_sallecorporative.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur'						=> 'pointeur',
						'dispoheb' 						=> "menu_hebergement",
						'salleCorporative'				=> $salleCorporative,
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter une salle corporative
	 */
	public function addSalleCorporativeAction()
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'un type événement corporatif
		$salle = new Hebergements_salles_corporatives();
		$form = $this->container->get('form.factory')->create(new AddSalles_corporativesForm(), $salle);
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
				// On l'enregistre notre objet $salle dans la base de données.
				$datasecure = new ControleDataSecureController();
				$txtfr = $datasecure->getSecureData($_POST['editor1'], 'editor1');
				$txten = $datasecure->getSecureData($_POST['editor2'], 'editor2');
				$salle->setTexteSalleCorporativeFr(strip_tags($txtfr));
				$salle->setTexteSalleCorporativeEn(strip_tags($txten));
				$em->persist($salle);
				$em->flush();
				echo 'Salle corporative ajoutée avec succés !';
				//On redirige vers la liste des salles corporatives.
				return $this->redirect($this->generateUrl('_Dashboard_sallescorporativeshebergement'));
			}
		}
		//Préparation de la view dashboard_addsallecorporative.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addsallecorporative.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'dispoheb' 						=> "menu_hebergement",
						'exist' 						=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier une salle corporative
	 */
	public function updateSalleCorporativeAction($id)
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire Modification d'une salle corporative
		$modifSalle = $em->find('MyAppGlobalBundle:Hebergements_salles_corporatives', $id);
		$form = $this->container->get('form.factory')->create(new AddSalles_corporativesForm(), $modifSalle);
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
				// On l'enregistre notre objet $modifSalle dans la base de données.
				$datasecure = new ControleDataSecureController();
				$txtfr = $datesecure->getSecureData($_POST['editor1'], 'editor1');
				$txten = $datasecure->getSecureData($_POST['editor2'], 'editor2');
				$salle->setTexteSalleCorporativeFr(strip_tags($txtfr));
				$salle->setTexteSalleCorporativeEn(strip_tags($txten));
				$em->persist($modifSalle);
				$em->flush();
				echo 'Salle corporative modifiée avec succés !';
				//On redirige vers la liste des salles corporatives.
				return $this->redirect($this->generateUrl('_Dashboard_sallescorporativeshebergement'));
			}
		}
		//Préparation de la view dashboard_addsallecorporative.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addsallecorporative.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'dispoheb' 						=> "menu_hebergement",
						'infoid'						=> $id,
						'infoname'						=> $modifSalle->getNomFr(),
						'txthomefr'						=> trim($modifSalle->getTexteSalleCorporativeFr()),
						'txthomeen'						=> trim($modifSalle->getTexteSalleCorporativeEn()),
						'role'							=> $role,
				));
	}
	
	/**
	 * Suppréssion d'une salle corporative
	 */
	public function deleteSalleCorporativeAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le type d'événement corporatif à supprimer
		$salleCorpo = $em->find('MyAppGlobalBundle:Hebergements_salles_corporatives', $id);
		$em->remove($salleCorpo);
		$em->flush();
		//On redirige vers la page d'accueil des salles corporatives
		return $this->redirect($this->generateUrl('_Dashboard_sallescorporativeshebergement'));
	}
	
/*####################################################################################*/
/*############### SECTION ÉVÉNEMENTS CORPORATIFS #####################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les événements coporatifs des hébergements
	 */
	public function evenementCorporatifAction()
	{
		//Gestionnaire d'entité
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des services corporatifs pour les afficher.
		$typeEvenementCorpo = $em->getRepository('MyAppGlobalBundle:Types_evenements')->getListTypeEvenement();
		//Préparation de la view dashboard_evenementcorporatif_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_evenementcorporatif.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur'						=> 'pointeur',
						'evenheb' 						=> "menu_hebergement",
						'evenementCorporatif'			=> $typeEvenementCorpo,
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter un événement corporatif
	 */
	public function addEvenementCorporatifAction()
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'un type événement corporatif
		$evenement = new Types_evenements();
		$form = $this->container->get('form.factory')->create(new AddTypesEvenementForm(), $evenement);
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
				// On l'enregistre notre objet $evenement dans la base de données.
				$em->persist($evenement);
				$em->flush();
				echo 'évenement corporatif ajouté avec succés !';
				//On redirige vers la liste des événements corporatifs.
				return $this->redirect($this->generateUrl('_Dashboard_evenementscoporatifshebergement'));
			}
		}
		//Préparation de la view dashboard_addevenementcorporatif.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addevenementcorporatif.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'evenheb' 						=> "menu_hebergement",
						'exist' 						=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier un événement corporatif
	 */
	public function updateEvenementCorporatifAction($id)
	{
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'une affiliation
		$modifEvenement = $em->find('MyAppGlobalBundle:Types_evenements', $id);
		$form = $this->container->get('form.factory')->create(new AddTypesEvenementForm(), $modifEvenement);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type «  POST  ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On enregistre notre objet $modifEvenement dans la base de données.
				$em->persist($affiliation);
				$em->flush();
				echo 'Événement corporatif modifié avec succés !';
				//On redirige vers la liste des événements corporatifs.
				return $this->redirect($this->generateUrl('_Dashboard_evenementscoporatifshebergement'));
			}
		}
		//Préparation de la view dashboard_addevenementcorporatif.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addevenementcorporatif.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'evenheb' 						=> "menu_hebergement",
						'infoid'						=> $id,
						'infonom'						=> $modifEvenement->getNomFr(),
						'role'							=> $role,
				));
	}
	
	/**
	 * Suppréssion d'une événement corporatif
	 */
	public function deleteEvenementCorporatifAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le type d'événement corporatif à supprimer
		$evenementCorpo = $em->find('MyAppGlobalBundle:Types_evenements', $id);
		$em->remove($evenementCorpo);
		$em->flush();
		//On redirige vers la page d'accueil des événements corporatifs
		return $this->redirect($this->generateUrl('_Dashboard_evenementscoporatifshebergement'));
	}
	
/*####################################################################################*/
/*############### SECTION PHOTOS HÉBERGEMENTS ########################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les photos des hebergements
	 */
	public function photoHebergementAction($page, $letter )
	{
		$numberPaginate = 30;
		$number = "";
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Auto-complétion pour le moteur de recherche par hébergement
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAutocompletionHebergement();
		//Récupère le nombre d'hébergement dans la table
		$nbPhoto = $em->getRepository('MyAppGlobalBundle:hebergement_photo')->getCompteIdphoto();
		foreach($nbPhoto as $result){
			$total = $result['nbPhoto'];
		}
		//On divise le nombre total de photo par le nombre que l'on souhaite afficher.
		$displaypage = ceil($total/$numberPaginate);
		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas supérieure au nombre max de page
		$page = $validRole->getValideEntierPagination($page, $displaypage);
		//Récupère la liste des photos avec la pagination.
		$listPhoto = $em->getRepository('MyAppGlobalBundle:Hebergement_photo')->getAdminHebergementPhoto($page, $numberPaginate);
		$number = 1;
		//Moteur de recherche.
		$form = $this->container->get('form.factory')->create(new Moteur_recherche_hebergementForm());
		//On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			foreach($form->getData() as $word)
			{
				$word = $validRole->getSearchEngineAdmin($word);
			}
			//On recherche l'hébergement par le nom entré avec l'auto-completion
			$result = $em->getRepository('MyAppGlobalBundle:Hebergements')->getSearchHebergement($word);
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
			$lettre = $em->getRepository('MyAppGlobalBundle:Hebergements')->getHebergementByFirstLetter($letter);
			$number = 3;
		}
		//on force la variable number à garder 2 si besoin
		(isset($word))? $number = 2 : $number ;
		//Préparation de la view dashboard_photo_html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_photo.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin' 					=> $user->getUsername(),
						'pointeur'						=> 'pointeur',
						'photoheb' 						=> "menu_hebergement",
						'listPhoto'						=> $listPhoto,
						'role'							=> $role,
						'autocompletion'				=> $autocompletion,
						'number'						=> $number,
						'page'							=> $page,
						'lettre'						=> $lettre,
						'form'							=> $form->createView(),
						'total'							=> $total,
						'displayPage'					=> 1,
						'result'						=> $result,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter une photo d'un hébergement.
	 */
	public function addPhotoHebergementAction()
	{
	
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'une photo pour les hébergement
		$photo = new Hebergement_photo();
		$form = $this->container->get('form.factory')->create(new AddPhotoHebergementForm(), $photo);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($photo);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				// On enregistre notre objet $photo dans la base de données.
				$em->persist($photo);
				$em->flush();
				echo 'Photo ajoutée avec succés !';
				//On redirige vers la liste des photos.
				return $this->redirect($this->generateUrl('_Dashboard_photohebergement'));
			}
		}
		//Préparation de la view dashboard_addphoto.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addphoto.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'photoheb' 						=> "menu_photo_hebergement",
						'exist' 						=> "false",
						'role'							=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier une photo pour un hébergement
	 */
	public function updatePhotoHebergementAction($id)
	{
	
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Formulaire d'ajout d'une affiliation
		$modifPhoto = $em->find('MyAppGlobalBundle:Hebergement_photo', $id);
		$form = $this->container->get('form.factory')->create(new AddPhotoHebergementForm(), $modifPhoto);
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
				// On enregistre notre objet $modifPhoto dans la base de données.
				$em->persist($modifPhoto);
				$em->flush();
				echo 'Photo modifiée avec succés !';
				//On redirige vers la liste des photos.
				return $this->redirect($this->generateUrl('_Dashboard_photohebergement'));
			}
		}
		//Préparation de la view dashboard_addphoto.html.twig
		return $this->render('MyAppAdminBundle:Hebergement:dashboard_addphoto.html.twig',
				array(
						'annee' 						=> date('Y'),
						'name_admin'		 			=> $user->getUsername(),
						'pointeur' 						=> 'pointeur',
						'form' 							=> $form->createView(),
						'photoheb' 						=> "menu_photo_hebergement",
						'infoid'						=> $id,
						//'infonom'						=> $modifPhoto->getLegende1Fr(),
						'role'							=> $role,
				));
	}
	
	/**
	 * Suppréssion d'une photo pour un hébergement
	 */
	public function deletePhotoHebergementAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère la photo à supprimer
		$photoHeb = $em->find('MyAppGlobalBundle:Hebergement_photo', $id);
		$em->remove($photoHeb);
		$em->flush();
		//On redirige vers la liste des photos pour les hébergements
		return $this->redirect($this->generateUrl('_Dashboard_photohebergement'));
	}
	

}