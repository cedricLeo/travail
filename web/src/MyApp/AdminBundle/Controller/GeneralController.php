<?php
namespace MyApp\AdminBundle\Controller;
use MyApp\AdminBundle\Forms\AddUserSystemForm;
use MyApp\AdminBundle\Forms\AddClientUtilisateurType;
use MyApp\GlobalBundle\Entity\Utilisateur;
use MyApp\AdminBundle\Forms\AddClassificationsForm;
use MyApp\GlobalBundle\Entity\Classifications;
use MyApp\AdminBundle\Forms\AddTextesAccueilForm;
use MyApp\GlobalBundle\Entity\Textes_accueil;
use MyApp\CustomerBundle\MyAppCustomerBundle;
use MyApp\GlobalBundle\Entity\Acomptes;
use MyApp\GlobalBundle\Form\DeviseForm;
use Symfony\Component\Form\FormFactory;
use MyApp\AdminBundle\Forms\AddVideoForm;
use MyApp\GlobalBundle\Entity\Attraits_villes;
use MyApp\GlobalBundle\Entity\Texte_region_categorie;
use MyApp\GlobalBundle\Entity\Texte_province_categorie;
use MyApp\GlobalBundle\Entity\Categories_hebergements;
use MyApp\GlobalBundle\MyAppGlobalBundle;
use MyApp\AdminBundle\MyAppAdminBundle;
use Symfony\Component\BrowserKit\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\GlobalBundle\Entity\Anomalies;
use MyApp\GlobalBundle\Entity\Pays;
use MyApp\GlobalBundle\Entity\Provinces_etats;
use MyApp\GlobalBundle\Entity\Regions;
use MyApp\GlobalBundle\Entity\Texte_region_attrait;
use MyApp\GlobalBundle\Entity\Texte_province_attrait;
use MyApp\GlobalBundle\Entity\Texte_region_sante;
use MyApp\GlobalBundle\Entity\Texte_province_sante;
use MyApp\GlobalBundle\Entity\Texte_region_restaurant;
use MyApp\GlobalBundle\Entity\Texte_province_restaurant;
use MyApp\GlobalBundle\Entity\Zones;
use MyApp\GlobalBundle\Entity\Texte_province_forfait;
use MyApp\GlobalBundle\Entity\Villes;
use MyApp\GlobalBundle\Entity\Texte_region_forfait;
use MyApp\GlobalBundle\Entity\Videos;
use MyApp\GlobalBundle\Entity\Modes_paiements;
use MyApp\GlobalBundle\Entity\Devises;
use MyApp\GlobalBundle\Entity\Cotations;
use MyApp\GlobalBundle\Entity\Accomptes;
use MyApp\GlobalBundle\Entity\Forfaits;
use MyApp\AdminBundle\Forms\AddProvinceForm;
use MyApp\AdminBundle\Forms\TexteRegionCategorieType;
use MyApp\AdminBundle\Forms\TexteProvinceCategorieType;
use MyApp\AdminBundle\Forms\AddRegionForm;
use MyApp\AdminBundle\Forms\AddZoneForm;
use MyApp\AdminBundle\Forms\AddPaysForm;
use MyApp\AdminBundle\Forms\AddVilleForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_villesForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_regionsForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_zonesForm;
use MyApp\AdminBundle\Forms\Moteur_recherche_clientForm;
use MyApp\AdminBundle\Forms\AddClientForm;
use MyApp\AdminBundle\Forms\TriClientValidationForm;
use MyApp\AdminBundle\Forms\AddPaiementForm;
use MyApp\AdminBundle\Forms\AddDeviseForm;
use MyApp\AdminBundle\Forms\AddAccomptesForm;
use MyApp\AdminBundle\Forms\AddForfaitForm;
use MyApp\AdminBundle\Forms\TexteProvinceCorporatifType;
use MyApp\AdminBundle\Forms\AddCotationForm;
use MyApp\GlobalBundle\Controller\ControleDataSecureController;
use MyApp\AdminBundle\Forms\AddPolitiquesForm;
use MyApp\GlobalBundle\Entity\Hebergements_politiques;
use MyApp\GlobalBundle\Entity\Attraits;
use JMS\SecurityExtraBundle\Annotation\Secure;
use MyApp\AdminBundle\Forms\AddTextesAccueilEnForm;
use MyApp\GlobalBundle\Entity\Textes_accueil_en;
use MyApp\GlobalBundle\Entity\Texte_province_corporatif;
use MyApp\GlobalBundle\Entity\Texte_region_corporatif;
use MyApp\AdminBundle\Forms\ModificationClientType;
use MyApp\GlobalBundle\Entity\Texte_province_appel_offre;
use MyApp\GlobalBundle\Entity\Texte_province_activite_corporative;
use MyApp\GlobalBundle\Entity\Texte_province_location_salle;
use MyApp\GlobalBundle\Entity\Texte_province_chambre_affaire;
use MyApp\GlobalBundle\Entity\Texte_region_appel_offre;
use MyApp\GlobalBundle\Entity\Texte_region_activite_corporative;
use MyApp\GlobalBundle\Entity\Texte_region_location_salle;
use MyApp\GlobalBundle\Entity\Texte_region_chambre_affaire;

/**
 * 
 * @author leonardc
 * 
 * Classe pour la gestion du menu général qui va afficher, ajouter, mêttre à jour et supprimer pour les sections suivantes:
 * 
 * Pays,
 * Provinces et états,
 * Régions,
 * Zones,
 * Villes,
 * Modes de paiements,
 * Devises,
 * Acomptes,
 * Forfaits,
 * Cotations,
 * Classifications,
 * Clients,
 * Textes d'accueil pour les sections du site
 * 
 * @Secure(roles="ROLE_SUPER_ADMIN")
 * 
 */
class GeneralController extends Controller
{
	
/*####################################################################################*/
/*############### SECTION PAYS #######################################################*/
/*####################################################################################*/
	
	/**
	 * Page du tableau de bord pour afficher et gérer les pays dans la section administration.
	 */
	public function paysAction($province, $region, $zone)
	{
		$listRegion = $listZone = $listVille = "";
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des pays pour les afficher.
		$state = $em->getRepository('MyAppGlobalBundle:Pays')->getListStates();
		//Récupère la liste des provinces pour le treeView.
		$listProvinceCanada = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getAdminProvincesByIdPays(1); //Canada
		$listProvinceUsa = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getAdminProvincesByIdPays(2); //Usa
		$listProvinceMexique = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getAdminProvincesByIdPays(3); //Mexique
		//Récupère la liste des régions.
		$listRegion = $em->getRepository("MyAppGlobalBundle:Regions")->getRegions($province);
		//Récupère la liste des zones.
		$listZone = $em->getRepository("MyAppGlobalBundle:Zones")->getZonesbyRegion($region);
		//Récupère la liste des villes.
		$listVille = $em->getRepository("MyAppGlobalBundle:Villes")->getSelectTownByArea($zone);
		//Préparation de la view dashboard_pays_html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_pays.html.twig',
                    array(
                        'annee'                 => date('Y'),
                        'name_admin' 		=> $user->getUsername(),
                        'pays' 			=> $state,
                        'pointeur'              => 'pointeur',
                        'mp' 			=> "menu_pays",
                        'listProvinceCanada'	=> $listProvinceCanada,
                        'listRegion'		=> $listRegion,
                        'motcleprovince'	=> $province,
                        'motcleregion'		=> $region,
                        'motclezone'		=> $zone,
                        'listZone'		=> $listZone,
                        'listVille'		=> $listVille,
                        'role'			=> $role,
                    ));
	}
	
	/**
	 * Page du tableau de bord pour ajouter un pays ou pour en modifier un.
	 */
	public function addPaysAction($id)
	{
		$nomPays = null;
		$idPays = null;
		$nomImage = null;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//AJOUT
		if($id == "id"){
		//Formulaire d'ajout de pays.
		$state = new Pays;
		//Hydratation du formulaire avec l'entity
		$form = $this->container->get('form.factory')->create(new AddPaysForm(), $state);
		$reponse = "false"; // VAR qui sert pour la condition add ou update dans le template
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
		            // On enregistre notre objet $state dans la base de données.
		            $em->persist($state);
		            $em->flush();
					echo 'Pays ajouté avec succés !';
					//On redirige vers la liste des pays.
		            return $this->redirect($this->generateUrl('_Dashboard_pays'));
		        }
		    }
		}
		//UPDATE
		if($id != "id"){
			//Récupère le pays à modifier.
			$paysmodif = $em->find('MyAppGlobalBundle:Pays', $id);
			//Formulaire d'ajout d'un pays.
			$form = $this->container->get('form.factory')->create(new AddPaysForm(), $paysmodif);
			//Nom du pays et id du pays
			$nomPays = $paysmodif->getId();
			$idPays = $paysmodif->getNomFr();
			$nomImage = $paysmodif->getFlag();
			$reponse = "true";
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
					//On récupère la valeur du champ file
					$thumbnail = $form->getData()->getImageDoctrine();
					//Si elle est pas vide on la transmet aux méthodes pour enregistrer l'image.
					//Cela empêche doctrine de reécrire une valeur null pour le champ file
					if($thumbnail != null)
					{
						$paysmodif->setFlag($thumbnail);
					}
					// On enregistre notre objet $modifstate dans la base de données.
					$em->persist($paysmodif);
					$em->flush();
					echo 'Pays modifier avec succés !';
					//On redirige vers la liste des pays.
					return $this->redirect($this->generateUrl('_Dashboard_pays'));
				}
			}
		}
		//Préparation de la view dashboard_pays_html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addpays.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin'                            => $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'form' 					=> $form->createView(),
						'mp' 					=> "menu_pays",
						'exist' 				=> $reponse,
						'role'					=> $role,
						'infoid'				=> $nomPays,
						'infonom' 				=> $idPays,
						'infoimg'				=> $nomImage,
				));
	}
	
	/**
	 * Page du tableau de bord pour supprimer un pays.
	 */
	public function deletePaysAction($id)
	{	
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le pays à supprimer.
		$state = $em->find('MyAppGlobalBundle:Pays', $id);	
		$em->remove($state);
		$em->flush();
		//On redirige vers la liste des pays.
		return $this->redirect($this->generateUrl('_Dashboard_pays'));
	}

/*####################################################################################*/
/*############### SECTION PROVINCES ET ÉTATS #########################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher et gérer les provinces.
	 */
	public function provincesAction($province, $region, $zone)
	{
		$listRegion = "";
		$listZone = "";
		$listVille = "";
		
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Liste les provinces
		$listProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getAdminProvinces();	
		//Récupère la liste des régions.
		$listRegion = $em->getRepository("MyAppGlobalBundle:Regions")->getRegions($province);
		//Récupère la liste des zones.
		$listZone = $em->getRepository("MyAppGlobalBundle:Zones")->getZonesbyRegion($region);
		//Récupère la liste des villes.
		$listVille = $em->getRepository("MyAppGlobalBundle:Villes")->getSelectTownByArea($zone);
		//Préparation de la view dashboard_provinces_html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_provinces.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'mpe' 					=> "menu_provinces",
						'listProvince' 			=> $listProvince,
						'listRegion'			=> $listRegion,
						'listZone'				=> $listZone,
						'listVille'				=> $listVille,
						'motcleprovince'	    => $province,
						'motcleregion'			=> $region,
						'motclezone'			=> $zone,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les provinces et les modifier.
	 */
	public function addProvincesAction($id)
	{
		$infoid = $infonom = $infoimg = $txtHomeEn = $txtHomeFr = null;
		//Gestionnaire des entities
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//AJOUT
		if($id == "id")
		{	
			$reponse = "false";
			//Formulaire d'ajout d'une province.
			$province = new Provinces_etats;
			$form = $this->container->get('form.factory')->create(new AddProvinceForm(), $province);
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
					$post1 = $validRole->getSecureData($_POST['editor1']);
					$post2 = $validRole->getSecureData($_POST['editor2']);
					$province->setTexteAccueilFr($post1);
					$province->setTexteAccueilEn($post2);
					// On enregistre notre objet $province dans la base de données.
					$em->persist($province);
					$em->flush();
					echo 'Province ajoutée avec succés !';
					//On redirige vers la liste des provinces.
					return $this->redirect($this->generateUrl('_Dashboard_provinces'));
				}
			}
		}
		//UPDATE
		if($id != "id")
		{
			$reponse = "true";
                         $id = (is_numeric($id) == true)?$id = $id : $id = 9;
			//Récupère la province à modifier.
			$provincemodif = $em->find('MyAppGlobalBundle:Provinces_etats', $id);
			// Génération du formulaire pour modifier la province.
			$form = $this->container->get('form.factory')->create(new AddProvinceForm(), $provincemodif);
			//Informations de la province a passer à la vue
			$infoid = $provincemodif->getId();
			$infonom = $provincemodif->getNomFr();
			$infoimg = $provincemodif->getImage();
			$txtHomeFr = str_replace(array("\r\n"), " ", html_entity_decode( $provincemodif->getTexteAccueilFr()));
			$txtHomeEn = str_replace(array("\r\n"), " ", html_entity_decode( $provincemodif->getTexteAccueilEn()));
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
					$post1 = $validRole->getSecureData($_POST['editor1']);
					$post2 = $validRole->getSecureData($_POST['editor2']);
					$provincemodif->setTexteAccueilFr($post1);
					$provincemodif->setTexteAccueilEn($post2);
					//On récupère la valeur du champ file
					$thumbnail = $form->getData()->getImageDoctrine();
					//Si le champ est != de vide on transmet la valeur aux méthodes d'enregistrements de l'image dans l'entity
					//cela empêche que doctrine ne reécrive une valeur null dans le cahmp image de la bd
					if($thumbnail != null){
						$provincemodif->setImage($thumbnail);
					}
					$em->persist($provincemodif);
					$em->flush();
					echo 'Province modifiée avec succés !';
					//On redirige vers la liste des provinces.
					return $this->redirect($this->generateUrl('_Dashboard_provinces'));
				}
			}
		}
		//Préparation de la view dashboard_addprovinces_html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addprovinces.html.twig',
                    array(
                            'annee' 			=> date('Y'),
                            'name_admin' 		=> $user->getUsername(),
                            'pointeur' 			=> 'pointeur',
                            'mpe' 			=> "menu_provinces",
                            'form' 			=> $form->createView(),
                            'exist'	 		=> $reponse,
                            'role'			=> $role,
                            'infoid' 			=> $infoid,
                            'infonom' 			=> $infonom,
                            'infoimg'			=> $infoimg,
                            'txthomefr' 		=> $txtHomeFr,
                            'txthomeen' 		=> $txtHomeEn,
                    ));
	}
        
        /**
         * Ajoute les textes pour les catégories d'hébergement des provinces
         */
        public function addTexteProvinceCategorieHebergementAction($id, $categorie)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                 $id = (is_numeric($id) == true)?$id = $id : $id = 9;
                //Retourne la catégorie d'hébergement
                $categoryName = $em->find("MyAppGlobalBundle:Categories_hebergements", $categorie);
                //Liste des catégories
                $listeCategorie = $em->getRepository("MyAppGlobalBundle:Categories_hebergements")->getChoiceCategoryHebergement();
                //Récupère la province
                $provincemodif = $em->find("MyAppGlobalBundle:Provinces_etats", $id);
                //On regarde si on a déjà des textes pour cette province
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_province_categorie")->getRechercheTexteAccueil($provincemodif->getId(), $categorie);
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_province_categorie", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_province_categorie();
                }
                //Formulaire d'ajout des textes pour la province.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCategorieType(), $textes);
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
                                $entityCategorieHeb = $em->find("MyAppGlobalBundle:Categories_hebergements", $categoryName->getId());   
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setProvince($provincemodif);
                                $textes->setCategorieHebergement($entityCategorieHeb);
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_province_categorie")->getRechercheTexteAccueil($provincemodif->getId(), $categoryName->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                }
                //Préparation de la view dashboard_addTexteProvincenCategorieHebergement.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteProvinceCategorieHebergement.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpe' 				=> "menu_provinces",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $provincemodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $provincemodif->getId(),
                                                'listeCat'                      => $listeCategorie,
                                                'categoryName'                  => $categoryName,
				));
        }
        
        /**
         * Ajoute les textes pour le corporatif des provinces
         */
        public function addTexteProvinceCorporatifAction($id)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                $id = (is_numeric($id) == true)?$id = $id : $id = 9;              
                //Récupère la province
                $provincemodif = $em->find("MyAppGlobalBundle:Provinces_etats", $id);
                //On regarde si on a déjà des textes pour cette province
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_province_corporatif")->getRechercheTexteAccueil($provincemodif->getId());
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_province_corporatif", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_province_corporatif();
                }
                //Formulaire d'ajout des textes pour la province.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCorporatifType(), $textes);
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
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setProvince($provincemodif);                                
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_province_corporatif")->getRechercheTexteAccueil($provincemodif->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                      //  return $this->redirect($this->generateUrl('_Dashboard_updateprovinces', array("id" => $id) ));
                }
                //Préparation de la view dashboard_addTexteProvinceCorporatifHebergement.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteProvinceCorporatif.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpe' 				=> "menu_provinces",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $provincemodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $provincemodif->getId(),
				));
        }
        
        /**
         * Ajoute les textes pour l'appel d'offre des provinces
         */
        public function addTexteProvinceAppelOffreAction($id)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                $id = (is_numeric($id) == true)?$id = $id : $id = 9;              
                //Récupère la province
                $provincemodif = $em->find("MyAppGlobalBundle:Provinces_etats", $id);
                //On regarde si on a déjà des textes pour cette province
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_province_appel_offre")->getRechercheTexteAccueil($provincemodif->getId());
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_province_appel_offre", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_province_appel_offre();
                }
                //Formulaire d'ajout des textes pour la province.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCorporatifType(), $textes);
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
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setProvince($provincemodif);                                
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_province_appel_offre")->getRechercheTexteAccueil($provincemodif->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                        return $this->redirect($this->generateUrl('_Dashboard_addtexteprovincecorporatif', array("id" => $id) ));
                }
                //Préparation de la view dashboard_addTexteProvinceAppelOffreHebergement.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteProvinceAppelOffre.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpe' 				=> "menu_provinces",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $provincemodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $provincemodif->getId(),
				));
        }
        
        /**
         * Ajoute les textes pour la location des salles des provinces
         */
        public function addTexteProvinceLocationSalleAction($id)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                $id = (is_numeric($id) == true)?$id = $id : $id = 9;              
                //Récupère la province
                $provincemodif = $em->find("MyAppGlobalBundle:Provinces_etats", $id);
                //On regarde si on a déjà des textes pour cette province
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_province_location_salle")->getRechercheTexteAccueil($provincemodif->getId());
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_province_location_salle", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_province_location_salle();
                }
                //Formulaire d'ajout des textes pour la province.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCorporatifType(), $textes);
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
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setProvince($provincemodif);                                
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_province_location_salle")->getRechercheTexteAccueil($provincemodif->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                         return $this->redirect($this->generateUrl('_Dashboard_addtexteprovincecorporatif', array("id" => $id) ));
                }
                //Préparation de la view dashboard_addTexteProvinceLocationSalle.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteProvinceLocationSalle.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpe' 				=> "menu_provinces",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $provincemodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $provincemodif->getId(),
				));
        }
        
        /**
         * Ajoute les textes pour les activités corporatives des provinces
         */
        public function addTexteProvinceActiviteCorpoAction($id)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                $id = (is_numeric($id) == true)?$id = $id : $id = 9;              
                //Récupère la province
                $provincemodif = $em->find("MyAppGlobalBundle:Provinces_etats", $id);
                //On regarde si on a déjà des textes pour cette province
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_province_activite_corporative")->getRechercheTexteAccueil($provincemodif->getId());
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_province_activite_corporative", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_province_activite_corporative();
                }
                //Formulaire d'ajout des textes pour la province.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCorporatifType(), $textes);
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
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setProvince($provincemodif);                                
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_province_activite_corporative")->getRechercheTexteAccueil($provincemodif->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                         return $this->redirect($this->generateUrl('_Dashboard_addtexteprovincecorporatif', array("id" => $id) ));
                }
                //Préparation de la view dashboard_addTexteProvinceActiviteCorpo.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteProvinceActiviteCorpo.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpe' 				=> "menu_provinces",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $provincemodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $provincemodif->getId(),
				));
        }
        
        /**
         * Ajoute les textes pour les chambres affaires des provinces
         */
        public function addTexteProvincechambreaffaireAction($id)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                $id = (is_numeric($id) == true)?$id = $id : $id = 9;              
                //Récupère la province
                $provincemodif = $em->find("MyAppGlobalBundle:Provinces_etats", $id);
                //On regarde si on a déjà des textes pour cette province
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_province_chambre_affaire")->getRechercheTexteAccueil($provincemodif->getId());
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_province_chambre_affaire", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_province_chambre_affaire();
                }
                //Formulaire d'ajout des textes pour la province.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCorporatifType(), $textes);
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
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setProvince($provincemodif);                                
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_province_chambre_affaire")->getRechercheTexteAccueil($provincemodif->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                         return $this->redirect($this->generateUrl('_Dashboard_updateprovinces', array("id" => $id) ));
                }
                //Préparation de la view dashboard_addTexteProvinceChambreAffaire.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteProvinceChambreAffaire.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpe' 				=> "menu_provinces",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $provincemodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $provincemodif->getId(),
				));
        }
               
        
        /**
         * Ajoute les textes pour les forfaits des provinces
         */
        public function texteForfaitProvinceAction($id, $forfait)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                 $id = (is_numeric($id) == true)?$id = $id : $id = 9;
                //Retourne le type de forfait
                $categoryName = $em->find("MyAppGlobalBundle:Forfaits", $forfait);
                //Liste des forfaits
                $listeForfait = $em->getRepository("MyAppGlobalBundle:Forfaits")->getForfaitAlphabetiqueFR();
                //Récupère la province
                $provincemodif = $em->find("MyAppGlobalBundle:Provinces_etats", $id);
                //On regarde si on a déjà des textes pour cette province
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_province_forfait")->getRechercheTexteAccueil($provincemodif->getId(), $forfait);
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_province_forfait", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_province_forfait();
                }
                //Formulaire d'ajout des textes pour la province.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCategorieType(), $textes);
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
                                $entityForfait = $em->find("MyAppGlobalBundle:Forfaits", $categoryName->getId());   
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setProvince($provincemodif);
                                $textes->setForfait($entityForfait);
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_province_forfait")->getRechercheTexteAccueil($provincemodif->getId(), $categoryName->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                }
                //Préparation de la view dashboard_texte_province_forfait.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_texte_province_forfait.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpe' 				=> "menu_provinces",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $provincemodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $provincemodif->getId(),
                                                'listeCat'                      => $listeForfait,
                                                'categoryName'                  => $categoryName,
				));
        }
        
        /**
         * Ajoute les textes pour les attraits des provinces
         */
        public function texteAttraitProvinceAction($id, $attrait)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                 $id = (is_numeric($id) == true)?$id = $id : $id = 9;
                //Retourne le type de catégorie d'attrait
                $categoryName = $em->find("MyAppGlobalBundle:Attraits_categories", $attrait);
                //Liste des catégories d'attrait
                $listeCatAttr = $em->getRepository("MyAppGlobalBundle:Attraits_categories")->getListAttraitCategorie();
                //Récupère la province
                $provincemodif = $em->find("MyAppGlobalBundle:Provinces_etats", $id);
                //On regarde si on a déjà des textes pour cette province
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_province_attrait")->getRechercheTexteAccueil($provincemodif->getId(), $attrait);
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_province_attrait", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_province_attrait();
                }
                //Formulaire d'ajout des textes pour la province.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCategorieType(), $textes);
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
                                $entityCatAttr = $em->find("MyAppGlobalBundle:Attraits_categories", $categoryName->getId());   
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setProvince($provincemodif);
                                $textes->setCategorieAttrait($entityCatAttr);
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_province_attrait")->getRechercheTexteAccueil($provincemodif->getId(), $categoryName->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                }
                //Préparation de la view dashboard_texte_province_attrait.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_texte_province_attrait.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpe' 				=> "menu_provinces",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $provincemodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $provincemodif->getId(),
                                                'listeCat'                      => $listeCatAttr,
                                                'categoryName'                  => $categoryName,
				));
        }
        
        /**
         * Ajoute les textes pour les types de soins des provinces
         */
        public function texteSanteProvinceAction($id, $sante)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                 $id = (is_numeric($id) == true)?$id = $id : $id = 9;
                //Retourne le type de catégorie de soin
                $categoryName = $em->find("MyAppGlobalBundle:Types_soins_sante", $sante);
                //Liste des types de soins
                $listeCatSoin = $em->getRepository("MyAppGlobalBundle:Types_soins_sante")->getListTypeSoin();
                //Récupère la province
                $provincemodif = $em->find("MyAppGlobalBundle:Provinces_etats", $id);
                //On regarde si on a déjà des textes pour cette province
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_province_sante")->getRechercheTexteAccueil($provincemodif->getId(), $sante);
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_province_sante", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_province_sante();
                }
                //Formulaire d'ajout des textes pour la province.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCategorieType(), $textes);
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
                                $entityCatSoin = $em->find("MyAppGlobalBundle:Types_soins_sante", $categoryName->getId());   
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setProvince($provincemodif);
                                $textes->setSante($entityCatSoin);
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_province_sante")->getRechercheTexteAccueil($provincemodif->getId(), $categoryName->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                }
                //Préparation de la view dashboard_texte_province_sante.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_texte_province_sante.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpe' 				=> "menu_provinces",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $provincemodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $provincemodif->getId(),
                                                'listeCat'                      => $listeCatSoin,
                                                'categoryName'                  => $categoryName,
				));
        }
	
        /**
         * Ajoute les textes pour les types de restaurants des provinces
         */
        public function texteRestaurantProvinceAction($id, $resto)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                 $id = (is_numeric($id) == true)?$id = $id : $id = 9;
                //Retourne le type de restaurant
                $categoryName = $em->find("MyAppGlobalBundle:Cuisines", $resto);
                //Liste des types de restaurants
                $listeCatResto = $em->getRepository("MyAppGlobalBundle:Cuisines")->getListCuisine();
                //Récupère la province
                $provincemodif = $em->find("MyAppGlobalBundle:Provinces_etats", $id);
                //On regarde si on a déjà des textes pour cette province
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_province_restaurant")->getRechercheTexteAccueil($provincemodif->getId(), $resto);
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_province_restaurant", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_province_restaurant();
                }
                //Formulaire d'ajout des textes pour la province.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCategorieType(), $textes);
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
                                $entityCatResto = $em->find("MyAppGlobalBundle:Cuisines", $categoryName->getId());   
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setProvince($provincemodif);
                                $textes->setCuisine($entityCatResto);
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_province_restaurant")->getRechercheTexteAccueil($provincemodif->getId(), $categoryName->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                }
                //Préparation de la view dashboard_texte_province_sante.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_texte_province_restaurant.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpe' 				=> "menu_provinces",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $provincemodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $provincemodif->getId(),
                                                'listeCat'                      => $listeCatResto,
                                                'categoryName'                  => $categoryName,
				));
        }
        
	/**
	 * Page du tableau de bord pour supprimer les provinces.
	 */
	public function deleteProvincesAction($id)
	{	
		$em = $this->getDoctrine()->getEntityManager();
		//On recherche la province à supprimer.
		$province = $em->find('MyAppGlobalBundle:Provinces_etats', $id);
		$em->remove($province);
		$em->flush();	
		//On redirige vers la liste des provinces.
		return $this->redirect($this->generateUrl('_Dashboard_provinces'));
	}

/*####################################################################################*/
/*############### SECTION RÉGIONS ####################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher et gérer les régions.
	 */
	public function regionsAction($page, $letter)
	{
		$numberPage = 30;
		$number = 0;
		$lettre = $result = "";
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Affiche le nombre maximum de région dans la table.
		$nbregions = $em->getRepository('MyAppGlobalBundle:Regions')->getCompteRegions();
		foreach($nbregions as $nbr){
			$nbregion = $nbr['nbregions'];
		}
		//On divise le nombre total de région par le nombre que l'on souhaite afficher de zone sur la page et on le transforme en entier.
		$displaypage = ceil($nbregion / $numberPage);
		//Si il n'existe pas de numéro de page dans l'url alors on prend la valeur 1 par defaut.
		$page = $validRole->getValideEntierPagination($page, $displaypage);
		//Récupère la liste des régions.
		$listRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getAdminRegions($page, $numberPage);
		$number = 1;
		//Création du formulaire pour le moteur de recherche.
		$form = $this->container->get('form.factory')->create(new Moteur_recherche_regionsForm());
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
			$result = $em->getRepository('MyAppGlobalBundle:Regions')->getWordSearchRegion($word);
			$number = 2;
		}
		//Vérifie s'il existe une lettre alphabétique dans l'url
		if(is_string($letter) == 1 and $letter !== 'letter' and strlen($letter) === 1)
		{
			$lettre = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionByFirstLetter($letter);
			$number = 3;
		}
		//On force number à garder la valeur 2 s'il existe un mot rechercher dans le moteur de recherche.
		(isset($word))? $number = 2 : $number;
		//Affiche l'auto-complétion se n'est pas supporter par tous les navigateurs pour le moment
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Regions')->getAutoCompletionRegion();
		//Préparation de la view  dashboard_regions.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_regions.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'listRegion' 			=> $listRegion,
						'page' 				=> $page,
						'nbregion' 			=> $nbregion,
						'firstpage' 			=> 1,
						'displaypage' 			=> $displaypage,
						'lettre' 			=> $lettre,
						'number' 			=> $number,
						'form' 				=> $form->createView(),
						'result' 			=> $result,
						'autocompletion' 		=> $autocompletion,
						'role'				=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les régions et les modifier.
	 */
	public function addRegionsAction($id, $page)
	{
		$infonom = $infoid = $infoimg = $imgDestination = $textEn = $textFr = null;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//AJOUT
		if($id == "id")
		{
			$reponse = "false";
			//Formulaire d'ajout d'une région.
			$region = new Regions;
			$form = $this->container->get('form.factory')->create(new AddRegionForm(), $region);
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
					//On valide les textes de l'éditeur
					$post1 = $validRole->getSecureData($_POST['editor1']);
					$post2 = $validRole->getSecureData($_POST['editor2']);
					$region->setTexteFr($post1);
					$region->setTexteEn($post2);
					//Remplace la virgule par un point pour la latitude et longitude
					$latitude = $form->getData()->getLatitude();
					$longitude = $form->getData()->getLongitude();
					$region->setLatitude($validRole->getFormatValueGps($latitude));
					$region->setLongitude($validRole->getFormatValueGps($longitude));
					// On enregistre notre objet $region dans la base de données.
					$em->persist($region);
					$em->flush();
					echo 'Région ajoutée avec succés !';
					//On redirige vers la liste des régions.
					return $this->redirect($this->generateUrl('_Dashboard_regions'));
				}
			}
		}
		//UPDATE
		if($id != "id")
		{
			$reponse = "true";
			//Récupère la région à modifier.
			$regionmodif = $em->find("MyAppGlobalBundle:Regions", $id);
			//Formulaire de modification d'une région.
			$form = $this->container->get('form.factory')->create(new AddRegionForm(), $regionmodif);
			$infoid = $regionmodif->getId(); // id
			$infonom = $regionmodif->getNomFr(); //Nom
			$infoimg = $regionmodif->getImageSuggestion(); //image nos suggestions
                        $imgDestination = $regionmodif->getImageTravel(); //image destination pour la région
			$textFr = str_replace(array("\r\n"), " ", html_entity_decode( $regionmodif->getTexteFr())); // texte FR
			$textEn = str_replace(array("\r\n"), " ", html_entity_decode( $regionmodif->getTexteEn())); //texte EN
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
					$post1 = $validRole->getSecureData($_POST['editor1']);
					$post2 = $validRole->getSecureData($_POST['editor2']);
					$regionmodif->setTexteFr($post1);
					$regionmodif->setTexteEn($post2);
					//Remplace la virgule par un point pour la latitude et longitude
					$latitude = $form->getData()->getLatitude();
					$longitude = $form->getData()->getLongitude();
					$regionmodif->setLatitude($validRole->getFormatValueGps($latitude));
					$regionmodif->setLongitude($validRole->getFormatValueGps($longitude));
					//On récupère la valeur du champ file
					$thumbnail = $form->getData()->getImageDoctrine();
					$imgRegion = $form->getData()->getImageTravelDoctrine();
					//Si la valeur est pas null on passe la valeur aux methodes pour enregistrer l'image (cela empêche doctrine de reécrire le champ file dans la BD)
					if($thumbnail != null)
					{
						$regionmodif->setImageSuggestion($thumbnail);
					}
					if($imgRegion != null)
					{
						$regionmodif->setImageTravel($imgRegion);
					}
					// On enregistre notre objet $regions dans la base de données.
					$em->persist($regionmodif);
					$em->flush();
					echo 'Région modifiée avec succés !';
					//On redirige vers la liste des régions.
					if(is_numeric($page))
					{
						return $this->redirect($this->generateUrl('_Dashboard_regions', array('page' => $page)));
					}
					else
					{
						return $this->redirect($this->generateUrl('_Dashboard_regions'));
					}
				}
			}
		}
		//Préparation de la view dashboard_addregions.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addregions.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'form' 				=> $form->createView(),
						'exist' 			=> $reponse,
						'role'				=> $role,
						'infoid' 			=> $infoid,
						'infonom' 			=> $infonom,
						'infoimg'			=> $infoimg,
						'txthomefr' 			=> $textFr,
						'txthomeen' 			=> $textEn,
						'imgDestination'		=> $imgDestination,                               
				));
	}
        
        /**
         * Page d'ajout des textes pour les catégories corporatives
         */
        public function addTexteRegionCorporatifAction($id)
        {              
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                $id = (is_numeric($id) == true)?$id = $id : $id = 20;              
                //Récupère la région
                $regionmodif = $em->find("MyAppGlobalBundle:Regions", $id);
                //On regarde si on a déjà des textes pour cette région
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_region_corporatif")->getRechercheTexteAccueil($regionmodif->getId());
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_region_corporatif", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_region_corporatif();
                }
                //Formulaire d'ajout des textes pour la région.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCorporatifType(), $textes);
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
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setRegion($regionmodif);                                
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_region_corporatif")->getRechercheTexteAccueil($regionmodif->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                      //  return $this->redirect($this->generateUrl('_Dashboard_updateprovinces', array("id" => $id) ));
                }
                //Préparation de la view dashboard_addTexteRegionCorporatifHebergement.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteRegionCorporatif.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $regionmodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $regionmodif->getId(),
				));
        }
        
        /**
         * Ajoute les textes pour l'appel d'offre des régions
         */
        public function addTexteRegionAppelOffreAction($id)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                $id = (is_numeric($id) == true)?$id = $id : $id = 20;              
                //Récupère la région
                $regionmodif = $em->find("MyAppGlobalBundle:Regions", $id);
                //On regarde si on a déjà des textes pour cette région
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_region_appel_offre")->getRechercheTexteAccueil($regionmodif->getId());
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_region_appel_offre", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_region_appel_offre();
                }
                //Formulaire d'ajout des textes pour la région.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCorporatifType(), $textes);
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
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setRegion($provincemodif);                                
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_region_appel_offre")->getRechercheTexteAccueil($regionmodif->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                        return $this->redirect($this->generateUrl('_Dashboard_addtexteregioncorporatif', array("id" => $id) ));
                }
                //Préparation de la view dashboard_addTexteRegionAppelOffreHebergement.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteRegionAppelOffre.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $regionmodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $regionmodif->getId(),
				));
        }
        
        /**
         * Ajoute les textes pour la location des salles des régions
         */
        public function addTexteRegionLocationSalleAction($id)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                $id = (is_numeric($id) == true)?$id = $id : $id = 20;              
                //Récupère la province
                $regionmodif = $em->find("MyAppGlobalBundle:Regions", $id);
                //On regarde si on a déjà des textes pour cette région
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_region_location_salle")->getRechercheTexteAccueil($regionmodif->getId());
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_region_location_salle", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_region_location_salle();
                }
                //Formulaire d'ajout des textes pour la région.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCorporatifType(), $textes);
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
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setRegion($regionmodif);                                
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_region_location_salle")->getRechercheTexteAccueil($regionmodif->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                         return $this->redirect($this->generateUrl('_Dashboard_addtexteregionactivitecorpo', array("id" => $id) ));
                }
                //Préparation de la view dashboard_addTexteRegionLocationSalle.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteRegionLocationSalle.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $regionmodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $regionmodif->getId(),
				));
        }
        
        /**
         * Ajoute les textes pour les activités corporatives des régions
         */
        public function addTexteRegionActiviteCorpoAction($id)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                $id = (is_numeric($id) == true)?$id = $id : $id = 20;              
                //Récupère la région
                $regionmodif = $em->find("MyAppGlobalBundle:Regions", $id);
                //On regarde si on a déjà des textes pour cette région
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_region_activite_corporative")->getRechercheTexteAccueil($regionmodif->getId());
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_region_activite_corporative", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_region_activite_corporative();
                }
                //Formulaire d'ajout des textes pour la région.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCorporatifType(), $textes);
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
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setRegion($regionmodif);                                
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_region_activite_corporative")->getRechercheTexteAccueil($regionmodif->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                         return $this->redirect($this->generateUrl('_Dashboard_addtexteregionchambreaffaire', array("id" => $id) ));
                }
                //Préparation de la view dashboard_addTexteRegionActiviteCorpo.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteRegionActiviteCorpo.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $regionmodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $regionmodif->getId(),
				));
        }
        
        /**
         * Ajoute les textes pour les chambres affaires des région
         */
        public function addTexteRegionchambreaffaireAction($id)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                $id = (is_numeric($id) == true)?$id = $id : $id = 20;              
                //Récupère la région
                $regionmodif = $em->find("MyAppGlobalBundle:Regions", $id);
                //On regarde si on a déjà des textes pour cette région
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_region_chambre_affaire")->getRechercheTexteAccueil($regionmodif->getId());
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_region_chambre_affaire", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_Region_chambre_affaire();
                }
                //Formulaire d'ajout des textes pour la région.
                $form = $this->container->get('form.factory')->create(new TexteProvinceCorporatifType(), $textes);
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
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setRegion($regionmodif);                                
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_region_chambre_affaire")->getRechercheTexteAccueil($regionmodif->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                         return $this->redirect($this->generateUrl('_Dashboard_updateregions', array("id" => $id) ));
                }
                //Préparation de la view dashboard_addTexteRegionChambreAffaire.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteRegionChambreAffaire.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $regionmodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $regionmodif->getId(),
				));
        }
        
         
        /**
         * Page d'ajout des textes pour les catégories d'hébergement de la région
         */
        public function addTexteRegionCategorieHebergementAction($id, $categorie)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                //Retourne la catégorie d'hébergement
                $categoryName = $em->find("MyAppGlobalBundle:Categories_hebergements", $categorie);
                //Liste des catégories
                $listeCategorie = $em->getRepository("MyAppGlobalBundle:Categories_hebergements")->getChoiceCategoryHebergement();
                //Récupère la région
                $regionmodif = $em->find("MyAppGlobalBundle:Regions", $id);
                //On regarde si on a déjà des textes pour cette région
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_region_categorie")->getRechercheTexteAccueil($regionmodif->getId(), $categorie);
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_region_categorie", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_region_categorie();
                }
                //Formulaire d'ajout des textes pour la région.
                $form = $this->container->get('form.factory')->create(new TexteRegionCategorieType(), $textes);
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
                                $entityCategorieHeb = $em->find("MyAppGlobalBundle:Categories_hebergements", $categoryName->getId());   
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setRegion($regionmodif);
                                $textes->setCategorieHebergement($entityCategorieHeb);
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_region_categorie")->getRechercheTexteAccueil($regionmodif->getId(), $categoryName->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                }
                //Préparation de la view dashboard_addTexteRegionCategorieHebergement.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addTexteRegionCategorieHebergement.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $regionmodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $regionmodif->getId(),
                                                'listeCat'                      => $listeCategorie,
                                                'categoryName'                  => $categoryName,
				));
        }
        
        /**
         * Page d'ajout des textes pour les forfaits de la région
         */
        public function texteForfaitRegionAction($id, $forfait)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                //Retourne le type de forfait
                $categoryName = $em->find("MyAppGlobalBundle:Forfaits", $forfait);
                //Liste des forfaits
                $listeForfait = $em->getRepository("MyAppGlobalBundle:Forfaits")->getForfaitAlphabetiqueFR();
                //Récupère la région
                $regionmodif = $em->find("MyAppGlobalBundle:Regions", $id);
                //On regarde si on a déjà des textes pour cette région
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_region_forfait")->getRechercheTexteAccueil($regionmodif->getId(), $forfait);
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_region_forfait", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_region_forfait();
                }
                //Formulaire d'ajout des textes pour la région.
                $form = $this->container->get('form.factory')->create(new TexteRegionCategorieType(), $textes);
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
                                $entityCategorieHeb = $em->find("MyAppGlobalBundle:Forfaits", $categoryName->getId());   
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setRegion($regionmodif);
                                $textes->setForfait($entityCategorieHeb);
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_region_forfait")->getRechercheTexteAccueil($regionmodif->getId(), $categoryName->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                }
                //Préparation de la view dashboard_addTexteRegionCategorieHebergement.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_texte_region_forfait.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $regionmodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $regionmodif->getId(),
                                                'listeCat'                      => $listeForfait,
                                                'categoryName'                  => $categoryName,
                                                         
				));
        }
       
        /**
         * Page d'ajout des textes pour les catégories d'attraits de la région
         */
        public function texteAttraitRegionAction($id, $attrait)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                //Retourne le type de catégorie d'attrait
                $categoryName = $em->find("MyAppGlobalBundle:Attraits_categories", $attrait);
                //Liste des catégories d'attraits
                $listeCatAttr = $em->getRepository("MyAppGlobalBundle:Attraits_categories")->getListAttraitCategorie();
                //Récupère la région
                $regionmodif = $em->find("MyAppGlobalBundle:Regions", $id);
                //On regarde si on a déjà des textes pour cette région
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_region_attrait")->getRechercheTexteAccueil($regionmodif->getId(), $attrait);
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_region_attrait", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_region_attrait();
                }
                //Formulaire d'ajout des textes pour la région.
                $form = $this->container->get('form.factory')->create(new TexteRegionCategorieType(), $textes);
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
                                $entityCategorieAttr = $em->find("MyAppGlobalBundle:Attraits_categories", $categoryName->getId());   
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setRegion($regionmodif);
                                $textes->setCategorieAttrait($entityCategorieAttr);
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_region_attrait")->getRechercheTexteAccueil($regionmodif->getId(), $categoryName->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                }
                //Préparation de la view dashboard_texte_region_attrait.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_texte_region_attrait.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $regionmodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $regionmodif->getId(),
                                                'listeCat'                      => $listeCatAttr,
                                                'categoryName'                  => $categoryName,
                                                         
				));
        }
        
        /**
         * Page d'ajout des textes pour les catégories de soins de la région
         */
        public function texteSanteRegionAction($id, $sante)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                //Retourne le type de soin
                $categoryName = $em->find("MyAppGlobalBundle:Types_soins_sante", $sante);
                //Liste des catégories de soins
                $listeCatSoin = $em->getRepository("MyAppGlobalBundle:Types_soins_sante")->getListTypeSoin();
                //Récupère la région
                $regionmodif = $em->find("MyAppGlobalBundle:Regions", $id);
                //On regarde si on a déjà des textes pour cette région
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_region_sante")->getRechercheTexteAccueil($regionmodif->getId(), $sante);
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_region_sante", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_region_sante();
                }
                //Formulaire d'ajout des textes pour la région.
                $form = $this->container->get('form.factory')->create(new TexteRegionCategorieType(), $textes);
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
                                $entityCategorieSoin = $em->find("MyAppGlobalBundle:TYpes_soins_sante", $categoryName->getId());   
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setRegion($regionmodif);
                                $textes->setSante($entityCategorieSoin);
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_region_attrait")->getRechercheTexteAccueil($regionmodif->getId(), $categoryName->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                }
                //Préparation de la view dashboard_texte_region_sante.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_texte_region_sante.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $regionmodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $regionmodif->getId(),
                                                'listeCat'                      => $listeCatSoin,
                                                'categoryName'                  => $categoryName,
                                                         
				));
        }
        
        /**
         * Page d'ajout des textes pour les catégories de restaurants de la région
         */
        public function texteRestaurantRegionAction($id, $resto)
        {
                $txtaccueilfr = $txtaccueilen = "";
                //Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
                //Retourne le type de restaurant
                $categoryName = $em->find("MyAppGlobalBundle:Cuisines", $resto);
                //Liste des catégories de restaurants
                $listeCatResto = $em->getRepository("MyAppGlobalBundle:Cuisines")->getListCuisine();
                //Récupère la région
                $regionmodif = $em->find("MyAppGlobalBundle:Regions", $id);
                //On regarde si on a déjà des textes pour cette région
                $texteExiste = $em->getRepository("MyAppGlobalBundle:Texte_region_restaurant")->getRechercheTexteAccueil($regionmodif->getId(), $resto);
                if($texteExiste != null){
                    $textes = $em->find("MyAppGlobalBundle:Texte_region_restaurant", $texteExiste[0]->getId());
                    $txtaccueilfr = $textes->getTexteFr();
                    $txtaccueilen = $textes->getTexteEn();
                }else{
                     $textes = new Texte_region_restaurant();
                }
                //Formulaire d'ajout des textes pour la région.
                $form = $this->container->get('form.factory')->create(new TexteRegionCategorieType(), $textes);
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
                                $entityCategorieSoin = $em->find("MyAppGlobalBundle:Cuisines", $categoryName->getId());   
                                $textes->setTexteFr($validRole->getSecureData($form->getData()->getTexteFr()));
                                $textes->setTexteEn($validRole->getSecureData($form->getData()->getTexteEn()));
                                $textes->setRegion($regionmodif);
                                $textes->setCuisine($entityCategorieSoin);
                                $em->persist($textes);
                                $em->flush();              
                        }
                        if($form->getData()->getTexteFr() != "" or $form->getData()->getTexteEn() != ""){
                            $textesRecup = $em->getRepository("MyAppGlobalBundle:Texte_region_attrait")->getRechercheTexteAccueil($regionmodif->getId(), $categoryName->getId());
                            $txtaccueilfr = $textesRecup[0]->getTexteFr();
                            $txtaccueilen = $textesRecup[0]->getTexteEn();
                        }
                }
                //Préparation de la view dashboard_texte_region_restaurant.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_texte_region_restaurant.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mpr' 				=> "menu_regions",
						'form' 				=> $form->createView(),
						'role'				=> $role,
						'infonom' 			=> $regionmodif->getNomFr(),
                                                'txtaccueilfr'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilfr)),
                                                'txtaccueilen'                  => str_replace(array("\r\n"), " ", html_entity_decode($txtaccueilen)),
                                                'infoid'                        => $regionmodif->getId(),
                                                'listeCat'                      => $listeCatResto,
                                                'categoryName'                  => $categoryName,
                                                         
				));
        }
	
	/**
	 * Page du tableau de bord pour supprimer les régions.
	 */
	public function deleteRegionsAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On recherche la région à supprimer
		$region = $em->find('MyAppGlobalBundle:Regions', $id);
		$em->remove($region);
		$em->flush();
		//On redirige vers la liste des régions
		return $this->redirect($this->generateUrl('_Dashboard_regions'));
	}
	
/*####################################################################################*/
/*############### SECTION ZONES ######################################################*/
/*####################################################################################*/
	
	/**
	 * Page du tableau de bord pour afficher et gérer les zones géographiques.
	 */
	public function zonesAction($page, $letter)
	{
		$numberPaginate = 30;
		$number = 0;
		$lettre = $result = "";
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Affiche le nombre maximum de zone dans la table.
		$nbzones = $em->getRepository('MyAppGlobalBundle:Zones')->getCompteZones();
		foreach($nbzones as $nbz){
			$nbzone = $nbz['nbzones'];
		}
		//On divise le nombre total de zone  par le nombre que l'on souhaite afficher de zone sur la page et on le transforme en entier.
		$displaypage = ceil($nbzone / $numberPaginate);
		//Si il n'existe pas de numéro de page dans l'url alors on prend la valeur 1 par defaut.
		if(isset($page) and is_numeric($page) == 1)
			if($page > $displaypage)
				$page = $displaypage;
			elseif($page <= 0)
				$page = 1;
			else
				$page;
		else
			$page = 1;
		//Récupère la liste des zones.
		$zones = $em->getRepository('MyAppGlobalBundle:Zones')->getZones($page, $numberPaginate);
		$number = 1;
		//Création du formulaire pour le moteur de recherche.
		$form = $this->container->get('form.factory')->create(new Moteur_recherche_zonesForm());
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			foreach($form->getData() as $word)
			{
				$word;
			}
			$result = $em->getRepository('MyAppGlobalBundle:Zones')->getWordSearchZone($word);
			$number = 2;
		}
		//On contrôle que le paramètre envoyer est bien de type string, qu'il contient bien une lettre 
		if(is_string($letter) == 1 and $letter !== 'letter' and strlen($letter) === 1)
		{
			$lettre = $em->getRepository('MyAppGlobalBundle:Zones')->getZoneByFirstLetter($letter);
			$number = 3;
		}
		(isset($word))? $number = 2 : $number;
		//Autocomplétion pour le moteur de recherche ne fonctionne pas avec tous les navigateurs pour le moment
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Zones')->getAutoCompletionZone();
		//Préparation de la view dashboard_zones.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_zones.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin'	 		=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'mz' 					=> "menu_zones",
						'zones' 				=> $zones,
						'page' 					=> $page,
						'nbzone' 				=> $nbzone,
						'firstpage' 			=> 1,
						'displaypage' 			=> $displaypage,
						'lettre' 				=> $lettre,
						'number' 				=> $number,
						'form' 					=> $form->createView(),
						'result' 				=> $result,
						'autocompletion' 		=> $autocompletion,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les zones géographiques et les modifier.
	 */
	public function addZonesAction($id)
	{	
		$infoid = $infonom = $textEn = $textFr = $imgSuggestion = null;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//AJOUT
		if($id == "id")
		{	
			$reponse = "false";
			//Formulaire ajout d'une zone.
			$zone = new Zones();
			$form = $this->container->get('form.factory')->create(new AddZoneForm(), $zone);
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
					//On valide les textes de l'éditeur
					$post1 = $validRole->getSecureData($_POST['editor1']);
					$post2 = $validRole->getSecureData($_POST['editor2']);
					$zone->setTexteFr($post1);
					$zone->setTexteEn($post2);
					//Remplace la virgule par un point pour la latitude et longitude
					$latitude = $form->getData()->getLatitude();
					$longitude = $form->getData()->getLongitude();
					$zone->setLatitude($validRole->getFormatValueGps($latitude));
					$zone->setLongitude($validRole->getFormatValueGps($longitude));
					// On enregistre notre objet $zone dans la base de données.
					$em->persist($zone);
					$em->flush();
					echo 'Zone ajoutée avec succés !';
					//On redirige vers la liste des zones.
					return $this->redirect($this->generateUrl('_Dashboard_zones'));
				}
			}	
		}
		//UPDATE
		if($id != "id")
		{
			$reponse = "true";
			//Récupère la zone à  modifier.
			$zonemodif = $em->find("MyAppGlobalBundle:Zones", $id);
			//Formulaire modification de la zone.
			$form = $this->container->get('form.factory')->create(new AddZoneForm(), $zonemodif);
			$infoid = $zonemodif->getId(); //id
			$infonom = $zonemodif->getNomfr();	//nom
			$textFr = str_replace(array("\r\n"), " ", html_entity_decode( $zonemodif->getTexteFr())); //texte FR
			$textEn = str_replace(array("\r\n"), " ", html_entity_decode( $zonemodif->getTexteEn())); //texte EN
			$imgSuggestion = $zonemodif->getImageSuggestion(); //image pour nos suggestions
			//On récupère la requête
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
			//	if( $form->isValid() )
			//	{		
					//On valide les textes de l'éditeur
					$post1 = $validRole->getSecureData($_POST['editor1']);
					$post2 = $validRole->getSecureData($_POST['editor2']);
					$zonemodif->setTexteFr($post1);
					$zonemodif->setTexteEn($post2);
					//Remplace la virgule par un point pour la latitude et longitude
					$latitude = $form->getData()->getLatitude();
					$longitude = $form->getData()->getLongitude();
					$zonemodif->setLatitude($validRole->getFormatValueGps($latitude));
					$zonemodif->setLongitude($validRole->getFormatValueGps($longitude));
					//On récupère la valeur du champ file
					$thumbnail = $form->getData()->getImageSuggestionDoctrine();
					//Si la valeur est pas vide on la transmet aux methodes pour enregistrer la valeur de l'image dans la BD
					if($thumbnail != null)
					{
						$zonemodif->setImageSuggestion($thumbnail);
					}
					// On enregistre notre objet $zonemodif dans la base de données.
					$em->persist($zonemodif);
					$em->flush();
					echo 'Zone modifiée avec succés !';
					//On redirige vers la liste des zones.
					return $this->redirect($this->generateUrl('_Dashboard_zones'));
			//	}
			}
		}
		//Préparation de la view dashboard_zones.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addzones.html.twig',
				array(
						'annee' 			=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 			=> 'pointeur',
						'mz' 				=> "menu_zones",
						'form' 				=> $form->createView(),
						'exist' 			=> $reponse,
						'role'				=> $role,
						'infoid' 			=> $infoid,
						'infonom' 			=> $infonom,
						'txthomefr' 			=> $textFr,
						'txthomeen' 			=> $textEn,
						'imgSuggestion'			=> $imgSuggestion,
				));
	}
	
	/**
	 * Page du tableau de bord pour supprimer les zones géographiques.
	 */
	public function deleteZonesAction($id, $name)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On recherche la zone à supprimer.
		$zone = $em->find('MyAppGlobalBundle:Zones', $id);	
		$em->remove($zone);
		$em->flush();
		//On redirige vers la liste des zones.
		return $this->redirect($this->generateUrl('_Dashboard_zones'));
	}
/*####################################################################################*/
/*############### SECTION VILLES #####################################################*/
/*####################################################################################*/
	
	/**
	 * Page du tableau de bord pour afficher et gérer les villes.
	 */
	public function villesAction($page, $letter)
	{
		$number = 0;
		$numberPaginate = 30;
		$result = $lettre = "";
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Affiche le nombre maximum de ville dans la table.
		$nbvilles = $em->getRepository('MyAppGlobalBundle:Villes')->getCompteVilles();
		foreach($nbvilles as $nbz){
			$nbville = $nbz['nbville'];
		}      
		//On récupère le nombre total des villes dans la table on le divise par le nombre que l'on souhaite afficher de ville par page et on le transforme pour en faire un entier.
		$displaypage = ceil($nbville / $numberPaginate);
		// S'il y a pas de numéro de page passé en paramètre alors on prend la valeur 1 par defaut.
		$page = $validRole->getValideEntierPagination($page, $displaypage);
		//Récupère la liste des villes.
		$listville = $em->getRepository('MyAppGlobalBundle:Villes')->getListTown($page, $numberPaginate);
		$number = 1;
		//Création du formulaire pour le moteur de recherche.
		$form = $this->container->get('form.factory')->create(new Moteur_recherche_villesForm());
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			foreach($form->getData() as $word)
			{
				$word = $validRole->getSearchEngineAdmin($word);
                                $tabSearchCaract = ["\(", "\)", "\\'", "\'"];
                                $tabReplaceCaract = ["(", ")", "'", "'"];
                                $word = str_replace($tabSearchCaract, $tabReplaceCaract, $word);
			}
			$result = $em->getRepository('MyAppGlobalBundle:Villes')->getWordSearchTown($word);
			$number = 2;
		}
		//On contrôle si il est passer en param�tre dans l'url une lettre pour la recherche par lettre des zones.
		if(is_string($letter) == 1 and $letter !== 'letter' and strlen($letter) === 1)
		{
			$lettre = $em->getRepository('MyAppGlobalBundle:Villes')->getTownByFirstLetter($letter);
			$number = 3;
		}
		(isset($word))? $number = 2 : $number ;
		//Affiche l'autocomplétion ce n'est pas supporter par tous les navigateurs pour le moment
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Villes')->getAutoCompletionVille();			
		//Préparation de la view dashboard_zones.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_villes.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin'                            => $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'mv' 					=> "menu_villes",
						'ville' 				=> $listville,
						'page' 					=> $page,
						'nbville' 				=> $nbville,
						'firstpage'                             => 1,
						'displaypage'                           => $displaypage,
						'lettre' 				=> $lettre,
						'number' 				=> $number,
						'form' 					=> $form->createView(),
						'result' 				=> $result,
						'autocompletion'                        => $autocompletion,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les villes et les modifier.
	 */
	public function addVillesAction($id)
	{
		$infoid = $infonom = $textEn = $textFr = null;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//AJOUT
		if($id == "id")
		{	
			$reponse = false;
			//Récupération des l'entités Villes et villes_videos.
			$ville = new Villes();
			//$video = new Videos();
			//Création des formulaires avec hydratation des champs des formulaires avec les entités.
			$form = $this->container->get('form.factory')->create(new AddVilleForm(), $ville);
			//$form_movie_town = $this->container->get('form.factory')->create(new AddVideoForm(), $video);
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				//if( $form->isValid() )
				//{
					//On valide les textes de l'éditeur
					$post1 = $validRole->getSecureData($_POST['editor1']);
					$post2 = $validRole->getSecureData($_POST['editor2']);
					$ville->setTexteFr($post1);
					$ville->setTexteEn($post2);
					//Remplace la virgule par un point pour la latitude et longitude
					$latitude = $form->getData()->getLatitude();
					$longitude = $form->getData()->getLongitude();
					$ville->setLatitude($validRole->getFormatValueGps($latitude));
					$ville->setLongitude($validRole->getFormatValueGps($longitude));
					// On l'enregistre nos objets $ville et $movie_town dans la base de données.
					$em->persist($ville);
					$em->flush();
					//Récupération du dernier id dans la table des villes on l'incrémentera de + 1 lors de l'enregistrement dans la table ville_video
					/*$searchLastIdVille = $em->getRepository('MyAppGlobalBundle:Villes')->getLastIdVille();
					foreach($searchLastIdVille as $lastid){
						$newIdTownMovie = $lastid['lastid'];
					}
					$video->setVilleId($newIdTownMovie);
					$em->persist($video);
					$em->flush();*/
					echo 'Ville ajouté avec succés !';
					//On redirige vers la liste des villes.
					return $this->redirect($this->generateUrl('_Dashboard_villes'));
				//}
			}	
		}	
		//UPDATE
		if($id != "id")
		{
			$reponse = true;
			//Récupère la ville à modifier.
			$villemodif = $em->find('MyAppGlobalBundle:Villes', $id);
			//Récupère les infos pour la vidéo de la ville
			//$video_modif = $em->getRepository('MyAppGlobalBundle:Villes')->getMovie($id);
			//Formulaire modification de la ville.
			$form = $this->container->get('form.factory')->create(new AddVilleForm(), $villemodif);
			//$form_movie_town = $this->container->get('form.factory')->create(new AddVideoForm(), $video_modif);
			$infoid = $villemodif->getId(); //id
			$infonom = $villemodif->getNomFr(); //nom
			$textFr = str_replace(array("\r\n"), " ", html_entity_decode( $villemodif->getTexteFr())); //texte FR
			$textEn = str_replace(array("\r\n"), " ", html_entity_decode( $villemodif->getTexteEn())); //texte EN
			//On récupère la requête
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				//$form_movie_town->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				//if( $form->isValid() )
				//{
					//On valide les textes de l'éditeur
					$post1 = $validRole->getSecureData($_POST['editor1']);
					$post2 = $validRole->getSecureData($_POST['editor2']);             
					$villemodif->setTexteFr($post1);
					$villemodif->setTexteEn($post2);
					//Remplace la virgule par un point pour la latitude et longitude
					$latitude = $form->getData()->getLatitude();
					$longitude = $form->getData()->getLongitude();
					$villemodif->setLatitude($validRole->getFormatValueGps($latitude));
					$villemodif->setLongitude($validRole->getFormatValueGps($longitude));
					// On enregistre les objets $villemodif et $video_ville_modif dans la base de données.
					$em->persist($villemodif);
					$em->flush();
					//$em->persist($video_modif);
					//$em->flush($video_modif);
					echo 'Ville modifiée avec succés !';
					//On redirige vers la liste des villes.
					//return $this->redirect($this->generateUrl('_Dashboard_villes'));
                                        
                                        return $this->redirect($this->generateUrl('_Dashboard_updatevilles', array("id" => $villemodif->getId()+1)));
				//}
			}
		}
		//Préparation de la view dashboard_villes.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addvilles.html.twig',
                        array(
                                'annee' 			=> date('Y'),
                                'name_admin' 			=> $user->getUsername(),
                                'pointeur' 			=> 'pointeur',
                                'mv' 				=> "menu_villes",
                                'form' 				=> $form->createView(),
                                //'form_movie_town' 		=> $form_movie_town->createView(),
                                'exist' 			=> $reponse,
                                'role'				=> $role,
                                'infoid' 			=> $infoid,
                                'infonom' 			=> $infonom,
                                'txthomefr' 			=> $textFr,
                                'txthomeen' 			=> $textEn,
                        ));
	}
	
	/**
	 * Page du tableau de bord pour supprimer les villes.
	 */
	public function deleteVillesAction($id, $name)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère la ville à supprimer. 
		$ville = $em->find('MyAppGlobalBundle:Villes', $id);
		$em->remove($ville);
		$em->flush();
		//On redirige vers la liste des villes
		return $this->redirect($this->generateUrl('_Dashboard_villes'));
	}
/*####################################################################################*/
/*############### SECTION PAIEMENTS ##################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher et gérer les modes de paiements.
	 */
	public function paiementsAction()
	{
		//$menu = 'selection';
		//$menu_general_actif = "true";

		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);		
		//On affiche la liste des modes de paiements
		$listpaiement = $em->getRepository('MyAppGlobalBundle:Modes_paiements')->getListmodePaiement();
		//Préparation de la view dashborad_paiement.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_paiements.html.twig',
				array(
						'annee' 				=> date("Y"),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'mpa' 					=> "menu_paiements",
						'paiement' 				=> $listpaiement,
						'role'					=> $role,
						//'menu'					=> 'selection',
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les modes de paiements et les modifier.
	 */
	public function addPaiementsAction($id)
	{
		$infoid = null;
		$infonom = null;
		$img = null;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//AJOUT
		if($id == "id")
		{
			$reponse = "false";
			//Récupération de l'entity pour hydrater le formulaire
			$paiement = new Modes_paiements();
			//Création du formulaire avec hydratation.
			$form = $this->container->get('form.factory')->create(new AddPaiementForm(), $paiement);
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{
                                        $thumbnail = $form->getData()->getImageDoctrine();
                                        if($thumbnail != null)
					{
                                            $paiement->setImage($thumbnail);
                                            $paiement->setImageDoctrine(null);
					}
					$em->persist($paiement);
					$em->flush();
					echo 'Mode de paiement ajouté avec succés !';
					//On redirige vers la liste des modes de paiements.
					return $this->redirect($this->generateUrl('_Dashboard_modes_paiements'));
				}
			}
		}
		//UPDATE
		if($id != "id")
		{
			$reponse = "true";
			//Récupère les infos du paiement à modifier.
			$modifpaiement = $em->find('MyAppGlobalBundle:Modes_paiements', $id);
			//Création du formulaire de mise à jour et hydratation avec l'entity
			$form = $this->container->get('form.factory')->create(new AddPaiementForm(), $modifpaiement);
			$infoid = $modifpaiement->getId();
			$infonom = $modifpaiement->getNomFr();
			$img = $modifpaiement->getImage();
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
					$thumbnail = $form->getData()->getImageDoctrine();
					if($thumbnail != null)
					{
						$modifpaiement->setImage($thumbnail);
                                                $modifpaiement->setImageDoctrine(null);
					}
					$em->persist($modifpaiement);
					$em->flush();
					echo 'Mode paiement modifié avec succés !';
					//On redirige vers la liste des modes de paiements.
					return $this->redirect($this->generateUrl('_Dashboard_modes_paiements'));
				}
			}
		}
		//Préparation de la view dashborad_addpaiement.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addpaiements.html.twig',
				array(
						'annee' 				=> date("Y"),
						'name_admin'                            => $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'mpa' 					=> "menu_paiements",
						'form' 					=> $form->createView(),
						'exist' 				=> $reponse,
						'role'					=> $role,
						'infonom' 				=> $infonom,
						'infoid' 				=> $infoid,
						'infoimg' 				=> $img,
				));
	}
	
	/**
	 * Page du tableau de bord pour supprimer les modes de paiements.
	 */
	public function deletePaiementsAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Recherche le mode de paiement à supprimer 
		$paiement = $em->find('MyAppGlobalBundle:Modes_paiements', $id);
		$em->remove($paiement);
		$em->flush();
		//Redirige vers la page accueil des modes de paiements.
		return $this->redirect($this->generateUrl('_Dashboard_modes_paiements'));
	}
/*####################################################################################*/
/*############### SECTION DEVISES ####################################################*/
/*####################################################################################*/	
	/**
	 * Page du tableau de bord pour afficher et g�rer les devises.
	 */
	public function devisesAction()
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//On récupère la monnaie américaine
		$dollarUSA = $em->find("MyAppGlobalBundle:Devises", 2);
		//On récupère la monnaie européenne
		$euro = $em->find("MyAppGlobalBundle:Devises", 3);
		//mise à jour du taux usa
		$dollarUSA->setTauxChange($this->getTauxChangeUsa());
		$dollarUSA->setDateUpdate(new \DateTime("now"));
		//mise à jour du taux euro
		$euro->setTauxChange($this->getTauxChangeEuro());
		$euro->setDateUpdate(new \DateTime("now"));
		//Persistance
		$em->persist($dollarUSA);
		$em->persist($euro);
		$em->flush();
		//Liste toutes les devises monétaires
		$argent = $em->getRepository('MyAppGlobalBundle:Devises')->getDevise();
		//Préparation de la view dashboard_devises.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_devises.html.twig',
				array(
						'annee' 				=> date("Y"),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'md' 					=> "menu_devises",
						'devise' 				=> $argent,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les devises.
	 */
	public function addDevisesAction($id)
	{
		$infoid = $infonom = $money = $value = null;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//AJOUT
		if($id == "id")
		{
			$reponse = "false";
			//Récupération de l'entity devises
			$devise = new Devises();
			//Création du formulaire et hydratation avec l'entity
			$form = $this->container->get('form.factory')->create(new AddDeviseForm(), $devise);
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{
					$devise->setDateUpdate(new \DateTime());
					$em->persist($devise);
					$em->flush();
					echo 'Devise ajoutée avec succés !';
					//On redirige vers la liste des modes de paiements.
					return $this->redirect($this->generateUrl('_Dashboard_devises'));
				}
			}
		}
		//UPDATE
		if($id != "id")
		{
			$reponse = "true";
			//On récupère la devise à modifiée
			$modifdevise = $em->find('MyAppGlobalBundle:Devises', $id);
			//Création du formulaire et hydratation avec l'entity.
			$form = $this->container->get('form.factory')->create(new AddDeviseForm(), $modifdevise);
			$infoid = $modifdevise->getAbreviation(); //id
			$infonom = $modifdevise->getAbreviation(); //nom
			$money = $modifdevise->getAbreviation(); //symbole
			$value = $modifdevise->getTauxChange(); //value
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
					$em->persist($modifdevise);
					$em->flush();
					echo 'Devise modifiée avec succés !';
					//On redirige vers la liste des devises.
					return $this->redirect($this->generateUrl('_Dashboard_devises'));
				}
			}
		}
		//Préparation de la view dashboard_devises.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_adddevises.html.twig',
				array(
						'annee' 				=> date("Y"),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'md' 					=> "menu_devises",
						'form' 					=> $form->createView(),
						'exist' 				=> $reponse,
						'role'					=> $role,
						'infonom' 				=> $infonom,
						'infoid' 				=> $infoid,
						'money' 				=> $money,
						'value' 				=> $value,
				));
	}
	
	/**
	 * Page du tableau de bord pour supprimer les devises.
	 */
	public function deleteDevisesAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Recherche de la devise à supprimer
		$deletedevise = $em->find('MyAppGlobalBundle:Devises', $id);
		$em->remove($deletedevise);
		$em->flush();
		//Redirige vers la page accueil des devises.
		return $this->redirect($this->generateUrl('_Dashboard_devises'));
	}
/*####################################################################################*/
/*############### SECTION ACOMPTES ###################################################*/
/*####################################################################################*/	
	/**
	 * Page du tableau de bord pour afficher et gérer les acomptes.
	 */
	public function acomptesAction()
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des acomptes
		$acomptes = $em->getRepository('MyAppGlobalBundle:Acomptes')->getListAcomptes();
		//Préparation de la view dashboard_acompte.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_acomptes.html.twig',
				array(
						'annee' 				=> date("Y"),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'ma' 					=> "menu_acomptes",
						'acompte'				=> $acomptes,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les acomptes et les modifier.
	 */
	public function addAcomptesAction($id)
	{
		$infonom = null;
		$infoid = null;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//AJOUT
		if($id == "id")
		{
			$reponse = "false";
			//Formulaire de création des acomptes
			$acompte = new Acomptes();
			$form = $this->container->get('form.factory')->create(new AddAccomptesForm(), $acompte);
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{
					$em->persist($acompte);
					$em->flush();
					echo 'Acompte ajouté avec succés !';
					//On redirige vers la liste des acomptes.
					return $this->redirect($this->generateUrl('_Dashboard_acompte'));
				}
			}
		}
		//UPDATE
		if($id != "id")
		{
			$reponse = "true";
			//On récupère l'acompte à modifier
			$modifAcompte = $em->find('MyAppGlobalBundle:Acomptes', $id);
			$form = $this->container->get('form.factory')->create(new AddAccomptesForm(), $modifAcompte);
			$infonom = $modifAcompte->getNomFr(); //nom
			$infoid	= $modifAcompte->getId(); //id
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
					$em->persist($modifAcompte);
					$em->flush();
					echo 'Acompte modifié avec succés !';
					//On redirige vers la liste des acomptes.
					return $this->redirect($this->generateUrl('_Dashboard_acompte'));
				}
			}
		}
		//Préparation de la view dashboard_acompte.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addacomptes.html.twig',
				array(
						'annee' 				=> date("Y"),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'ma' 					=> "menu_acomptes",
						'form'					=> $form->createview(),
						'exist'					=> $reponse,
						'role'					=> $role,
						'infonom'				=> $infonom,
						'infoid'				=> $id,
				));
	}
	
	/**
	 * Page du tableau de bord pour afficher et gérer les acomptes.
	 */
	public function deleteAcomptesAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère l'acompte que l'on va supprimer
		$acompte = $em->find('MyAppGlobalBundle:Acomptes', $id);
		$em->remove($acompte);
		$em->flush();
		//Préparation de la view dashboard_acompte.html.twig
		return $this->redirect($this->generateUrl('_Dashboard_acompte'));
	}
/*####################################################################################*/
/*############### SECTION FORFAITS ###################################################*/
/*####################################################################################*/	
	/**
	 * Page du tableau de bord pour afficher et gérer les forfaits.
	 */
	public function forfaitsAction()
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des forfaits
		$forfaits = $em->getRepository('MyAppGlobalBundle:Forfaits')->getForfaitAlphabetiqueFR();
		//Préparation de la view dashboard_forfaits.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_forfaits.html.twig',
				array(
						'annee' 				=> date("Y"),
						'name_admin' 			=> $user->getUsername(),
						'pointeur'	 			=> 'pointeur',
						'mf' 					=> "menu_forfaits",
						'forfaits' 				=> $forfaits,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les forfaits et les modifier.
	 */
	public function addForfaitsAction($id)
	{
		$infoid = $infonom = $textFr = $textEn = $infoimg = null;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//AJOUT
		if($id == "id")
		{
			$reponse = "false";
			//Récupération de l'entity Forfaits
			$forfait = new Forfaits();
			//Création du formulaire d'ajout de forfait.
			$form = $this->container->get('form.factory')->create(new AddForfaitForm(), $forfait);
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
                                        //On récupère la valeur du champ file
					$thumbnail = $form->getData()->getImageDoctrine();
					//Si le champ est pas vide on passe la valeur aux methodes pour enregistrer l'image dans la BD
					if($thumbnail != null){
						$forfait->setImage($thumbnail);
					}
					//On valide les textes de l'éditeur
					$post1 = $validRole->getSecureData($_POST['editor1']);
					$post2 = $validRole->getSecureData($_POST['editor2']);
					$forfait->setTexteFr($post1);
					$forfait->setTexteEn($post2);
					//On enregistre dans la BD notre objet.
					$em->persist($forfait);
					$em->flush();
					echo 'Forfait ajouté avec succés !';
					//On redirige vers la liste des forfaits.
					return $this->redirect($this->generateUrl('_Dashboard_forfaits'));
				}
			}
		}
		//UPDATE
		if($id != "id")
		{
			$reponse = "true";
			//Récupération du forfait à modifier.
			$modifForfait = $em->find('MyAppGlobalBundle:Forfaits', $id);
			//Création du formulaire de modification du forfait.
			$form = $this->container->get('form.factory')->create(new AddForfaitForm(), $modifForfait);
			$infoid = $modifForfait->getId(); //id
			$infonom = $modifForfait->getNomFr(); //nom
			$textFr = str_replace(array("\r\n"), " ", html_entity_decode($modifForfait->getTexteFr())); //texte Fr
			$textEn = str_replace(array("\r\n"), " ", html_entity_decode($modifForfait->getTexteEn())); //texte EN
			$infoimg = $modifForfait->getImage(); //image
			//On récupère la requête
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vêrifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{
					//On récupère la valeur du champ file
					$thumbnail = $form->getData()->getImageDoctrine();
					//Si le champ est pas vide on passe la valeur aux methodes pour enregistrer l'image dans la BD
					if($thumbnail != null){
						$modifForfait->setImage($thumbnail);
					}
					//On valide les textes des éditeurs
					$post1 = $validRole->getSecureData($_POST['editor1']);
					$post2 = $validRole->getSecureData($_POST['editor2']);
					$modifForfait->setTexteFr($post1);
					$modifForfait->setTexteEn($post2);
					//On enregistre notre objet dans la BD.
					$em->persist($modifForfait);
					$em->flush();
					echo 'Forfait modifié avec succés !';
					//On redirige vers la liste des forfaits.
					return $this->redirect($this->generateUrl('_Dashboard_forfaits'));
				}
			}
		}
		//Préparation de la view dashboard_forfaits.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addforfaits.html.twig',
				array(
						'annee'					=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'mf' 					=> "menu_forfaits",
						'form' 					=> $form->createView(),
						'exist' 				=> $reponse,
						'jour' 					=> date('d'),
						'mois' 					=> date('n'),
						'annee' 				=> date('Y'),
						'role'					=> $role,
						'infoid' 				=> $infoid,
						'infonom' 				=> $infonom,
						'txt_fr' 				=> $textFr,
						'txt_en' 				=> $textEn,
						'infoimg' 				=> $infoimg,
				));
	}
	
	/**
	 * Page du tableau de bord pour supprimer les forfaits.
	 */
	public function deleteForfaitsAction($id)
	{	
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le forfait à supprimer.
		$forfait = $em->find('MyAppGlobalBundle:Forfaits', $id);
		$em->remove($forfait);
		$em->flush();
		//Redirection vers la liste des forfaits
		return $this->redirect($this->generateUrl('_Dashboard_forfaits'));
	}
/*####################################################################################*/
/*############### SECTION COTATIONS ##################################################*/
/*####################################################################################*/	
	/**
	 * Page du tableau de bord pour afficher et gérer les cotations.
	 */
	public function cotationsAction()
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des cotations.
		$cotation = $em->getRepository('MyAppGlobalBundle:Cotations')->getListCotation();
		//Préparation de la view dashboard_cotations.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_cotations.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'mco' 					=> "menu_cotations",
						'cotation' 				=> $cotation,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les cotations et les modifier.
	 */
	public function addCotationsAction($id)
	{
		$infoid = null;
		$infonom = null;
		$infoimg = null;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//AJOUT
		if($id == "id")
		{
			$reponse = "false";
			//Récupère l'entity cotation pour hydrater le formulaire.
			$cotation = new Cotations();
			//Création du formulaire avec hydratation des champs des formulaires avec les entités.
			$form = $this->container->get('form.factory')->create(new AddCotationForm(), $cotation);
			//Accés à la requête sousmise
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{
					//On valide l'image
					$img = $form->getData()->getFile();
					if($img != null)
					{
						$cotation->setImage($img);
					}
					// On l'enregistre notre objet $cotation dans la base de données.
					$em->persist($cotation);
					$em->flush();
					echo 'Cotation ajoutée avec succés !';
					//On redirige vers la liste des cotations.
					return $this->redirect($this->generateUrl('_Dashboard_cotations'));
				}
			}
		}
		//UPDATE 
		if($id != "id")
		{
			$reponse = "true";
			//Récupère la cotation à modifier
			$modifcotation = $em->find('MyAppGlobalBundle:Cotations', $id);
			//Création du formulaire de modification de la cotation
			$form = $this->container->get('form.factory')->create(new AddCotationForm(), $modifcotation);
			$infoid = $modifcotation->getId(); //id
			$infonom = $modifcotation->getValeur(); //nom
			$infoimg = $modifcotation->getImage(); //image
			//Accés à la requête sousmise
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{
					//On récupère la valeur du champ file
					$testFieldFile = $form->getData()->getFile();
					//Si le champ est pas vide on passe la valeur aux methodes pour enregistrer l'image dans la BD (empêche doctrine de reécrire le champ file à chaque mise à jour)
					if($testFieldFile != null){
						//On supprime la photo dans le repertoire avant de copier la nouvelle pour éviter un bug
						if($testFieldFile != $modifcotation->getImage())
						{
							$modifcotation->setImage("");
							/*$cotation = $em->find('MyAppGlobalBundle:Cotations', $id);
							$em->remove($cotation);
							$em->flush();*/
						}
						$modifcotation->setImage($testFieldFile);
					}
					// On enregistre notre objet $modifcotation dans la base de données.
					$em->persist($modifcotation);
					$em->flush();
					echo 'Cotation modifiée avec succés !';
					//On redirige vers la liste des cotations.
					return $this->redirect($this->generateUrl('_Dashboard_cotations'));
				}
			}
		}
		//Préparation de la view dashboard_addcotations.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addcotations.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur'			 	=> 'pointeur',
						'mco' 					=> "menu_cotations",
						'exist' 				=> $reponse,
						'form' 					=> $form->createView(),
						'role'					=> $role,
						'infoid' 				=> $infoid,
						'infonom' 				=> $infonom,
						'infoimg' 				=> $infoimg,
				));
	}
	
	/**
	 * Page du tableau de bord pour afficher et gérer les cotations.
	 */
	public function deleteCotationsAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();	
		//On récupère la cotation à supprimer
		$cotation = $em->find('MyAppGlobalBundle:Cotations', $id);
		$em->remove($cotation);
		$em->flush();
		//Redirection vers la page d'accueil des cotations
		return $this->redirect($this->generateUrl('_Dashboard_cotations'));
	}

/*####################################################################################*/
/*############### SECTION CLASSIFICATIONS ##################################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher et gérer les classifications.
	 */
	public function classificationsAction()
	{
		/*$placeDisque = disk_free_space("C:")/1024/1024/1024;
		$value = '.';
		$result = strpos($placeDisque, $value);
		echo 'Capacité restante du disque '.substr($placeDisque, 0, $result+2).' Go';*/
		
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des classifications.
		$classification = $em->getRepository('MyAppGlobalBundle:Classifications')->getListClassifications();
		//Préparation de la view dashboard_cotations.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_classifications.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'mcla' 					=> "menu_classification",
						'classification' 		=> $classification,
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour ajouter les classifications et les modifier.
	 */
	public function addClassificationsAction($id)
	{
		$infoid = null;
		$infonom = null;
		$infoimg = null;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//AJOUT
		if($id == "id")
		{
			$reponse = "false";
			//Récupère l'entity classifications pour hydrater le formulaire.
			$classification = new Classifications();
			//Création du formulaire avec hydratation des champs des formulaires avec les entités.
			$form = $this->container->get('form.factory')->create(new AddClassificationsForm(), $classification);
			//Accés à la requête sousmise
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{
					//On valide l'image
					$img = $form->getData()->getFile();
					if($img != null)
					{
						$classification->setImage($img);
					}
					// On l'enregistre notre objet $classification dans la base de données.
					$em->persist($classification);
					$em->flush();
					echo 'Classification ajoutée avec succés !';
					//On redirige vers la liste des classification.
					return $this->redirect($this->generateUrl('_Dashboard_classifications'));
				}
			}
		}
		//UPDATE
		if($id != "id")
		{
			$reponse = "true";
			//Récupère la classification à modifier
			$modifclassification = $em->find('MyAppGlobalBundle:Classifications', $id);
			//Création du formulaire de modification de la classification
			$form = $this->container->get('form.factory')->create(new AddClassificationsForm(), $modifclassification);
			$infoid = $modifclassification->getId();      //id
			$infonom = $modifclassification->getValeur(); //nom
			$infoimg = $modifclassification->getImage();  //image
			//Accés à la requête sousmise
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{
					//On récupère la valeur du champ file
					$testFieldFile = $form->getData()->getFile();
					//Si le champ est pas vide on passe la valeur aux methodes pour enregistrer l'image dans la BD (empêche doctrine de reécrire le champ file à chaque mise à jour)
					if($testFieldFile != null){
						$modifclassification->setImage($testFieldFile);
					}
					// On enregistre notre objet $modifclassification dans la base de données.
					$em->persist($modifclassification);
					$em->flush();
					echo 'Classification avec succés !';
					//On redirige vers la liste des classifications.
					return $this->redirect($this->generateUrl('_Dashboard_classifications'));
				}
			}
		}
		//Préparation de la view dashboard_addclassifications.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addclassifications.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur'			 	=> 'pointeur',
						'mcla' 					=> "menu_classification",
						'exist' 				=> $reponse,
						'form' 					=> $form->createView(),
						'role'					=> $role,
						'infoid' 				=> $infoid,
						'infonom' 				=> $infonom,
						'infoimg' 				=> $infoimg,
				));
	}
	
	/**
	 * Page du tableau de bord pour afficher et gérer les classifications.
	 */
	public function deleteClassificationsAction($id)
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère la classification à supprimer
		$classification = $em->find('MyAppGlobalBundle:Classifications', $id);
		$em->remove($classification);
		$em->flush();
		//Redirection vers la page d'accueil des classifications
		return $this->redirect($this->generateUrl('_Dashboard_classifications'));
	}
	
/*####################################################################################*/
/*############### SECTION CLIENTS ####################################################*/
/*####################################################################################*/	
	/**
	 * Page du tableau de bord pour afficher et gérer les clients.
	 */
	public function clientsAction($page, $letter, $statut, $item)
	{
		gc_enable();  //Appele du GC
		//VARIABLES
		$displayMax = 30;
		$word = $result = $number = $statutRegion = $statutClient = $statutVille = $statutZone = $region = $zone = $ville = $category = $lettre = "";
		( $item == "item")?  : $item = $item;		
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//VALEUR D'AFFICHAGE PAR DÉFAUT.
		if($page == "page" and $letter == "letter" and $statut == "statut" or $page != "page" )
		{
			$nbClient = $em->getRepository("MyAppGlobalBundle:Utilisateur")->getCompteNombreClient();
			$total = $nbClient[0]["nbuser"];
			//Détermine le nombre de page
			$displaypage = ceil( $total/$displayMax);
			($displaypage == 0)? $displaypage = 1 : $displaypage ;
			//S'il n'existe pas de numéro de page dans l'url alors on prend la valeur 1 par defaut.
			$page = $validRole->getValideEntierPagination($page, $displayMax);
			$listeClient = $em->getRepository("MyAppGlobalBundle:Utilisateur")->getRetourneListeClient($page, $displayMax);
			$number = 1;
			
			
			/*$test = $em->getRepository("MyAppGlobalBundle:Utilisateur")->testUser();			
			foreach($test as $tw){		
				$testHebergement = $em->getRepository("MyAppGlobalBundle:Hebergements")->getCompareUtilisateur($tw->getId());
				//if($testHebergement != null){
					$testUser = $em->find("MyAppGlobalBundle:Utilisateur", $tw->getId());
					
					$testVille = $em->find("MyAppGlobalBundle:Villes", $testHebergement[0]->getVilleId()->getId());
					$testUser->getVilles($testVille);
					$em->persist($testUser);
					$em->flush();
					$testHebergement = $testVille = "";
				//}
			}*/
			
			
			
		}
		//VALEUR D'AFFICHAGE POUR LA RECHERCHE PAR LETTRE ALPHABÉTIQUE
		if($letter != "letter" and $statut == "statut" )
		{
			$letter = htmlentities($letter);
			//On recherche la liste des clients qui ont ont leur nom qui commencent par cette lettre
			$lettre = $em->getRepository("MyAppGlobalBundle:Utilisateur")->getRetourneClientParLettre($letter);
			$total = $lettre[0]['nblettre'];
			//Détermine le nombre de page
			$displaypage = ceil( $total/$displayMax);
			//S'il n'existe pas de numéro de page dans l'url alors on prend la valeur 1 par defaut.
			if($total > 0){
				$page = $validRole->getValideEntierPagination($page, $displayMax);
			}else{ $page = 0; }
			//Pagination
			if($total > 30){
				$lettre = "";
				$lettre = $em->getRepository("MyAppGlobalBundle:Utilisateur")->getRetourneClientParLettrePagination($letter, $page, $displayMax);
			}else{
				$lettre = $em->getRepository("MyAppGlobalBundle:Utilisateur")->getRetourneListeClientParLettre($letter);
			}
			$item = $letter;
		}
		//MOTEUR DE RECHERCHE EN HAUT À DROITE DU TEMPLATE (nom où n°interne)
		$form = $this->createForm(new Moteur_recherche_clientForm());
		//On accède à la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			foreach($form->getData() as $word)
			{
				//On valide la valeur du moteur de recherche
			 	$word = $validRole->getSearchEngineAdmin($word);
			}
			$result = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getInfoUserEngine($word);
			$category = "construction_fiche";
		}	
		//CODE POUR LE MOTEUR DE RECHERCHE EN HAUT À GAUCHE AVEC ACTIF, INACTIF ET VILLE.
		$form_validation = $this->createForm(new TriClientValidationForm());
		//On accède à la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».	
		if( $request->getMethod() == 'POST')
		{
			// On fait le lien Requête <-> Formulaire.
			$form_validation->bindRequest($request);
			//On récupère le statut.
			foreach($form_validation->getData() as $statut)
			{
			    $statut;
			    //On remet à 1 la valeur de la pagination.
			    $page = 1;
			}
		}
		//Recherche les clients qui ont le statut actif.
		if($statut == 1)
		{			
			//Retourne les clients actifs
			$statutClient = $em->getRepository("MyAppGlobalBundle:Utilisateur")->getRetourneClientActifs();
			//compte le nombre de client
			$total = count($statutClient);
			//Détermine le nombre de page
			$displaypage = ceil( $total/$displayMax);
			//S'il n'existe pas de numéro de page dans l'url alors on prend la valeur 1 par defaut.
			$page = $validRole->getValideEntierPagination($page, $displayMax);
		}
		//Recherche les clients qui ont le statut inactif.
		elseif($statut == "0")
		{	
			//Retourne les clients inactifs
			$statutClient = $em->getRepository("MyAppGlobalBundle:Utilisateur")->getRetourneClientNonActifs();
			//Compte le nombre de client
			$total = count($statutClient);
			//Détermine le nombre de page
			$displaypage = ceil( $total/$displayMax);
			//S'il n'existe pas de numéro de page dans l'url alors on prend la valeur 1 par defaut.
			$page = $validRole->getValideEntierPagination($page, $displayMax);
		}
		//Recherche et affiche les clients qui sont dans la ville sélectionnée.
		elseif($statut == 2)	
		{
			if(isset($_POST['ville']) and !empty($_POST['ville']) or $item != "item")
			{	
				if(isset($_POST["ville"])){
					$item = $ville = $_POST["ville"];
				}
				//Recherche l'id de la ville
				$rechercheId = $em->getRepository('MyAppGlobalBundle:Villes')->getVilleByNomFr($item);
				//On fusionne les deux tableaux en un
				$statutVille = $em->getRepository("MyAppGlobalBundle:Utilisateur")->getRetourneClientVille($rechercheId[0]["id"]);
				//Compte les client de cette ville
				$total = count($statutVille);
				//Détermine le nombre de page
				$displaypage = ceil( $total/$displayMax);
			}
		}
		//On vérifie la présence d'un statut.
		if(isset($statut))
		{
			$statut == "statut" ? $statut = null : $statut ;
		}
		if(!empty($word))//S'il existe un nom de client ou un numéro interne dans la recherche
		{
			$number = 3;
		}
		elseif(isset($statut) and $statut == 0 or $statut == 1)	//Si on recherche le statut des clients actifs ou non-actifs
		{
			$number = 4;
		}
		elseif($letter !== 'letter' and !$statut ) // Si une lettre est transmise pour la recherche alphabétique
		{
			$number = 2;
		}
		elseif(isset($statut) and $statut == 2) // Si on lance le tri par ville
		{
			$number = 7;
		}
		elseif(!isset($page) or isset($page) and $letter == "item") // Valeur par défault
		{
			$number = 1;
		}	
		//Auto-complétion pour le moteur de recherche ne fonctionne pas avec tous les navigateurs pour le moment.
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getListClientGlobal(); // liste tous les clients
		//Auto-complétion pour afficher les villes dans le moteur de recherche
		$autoCompletionVille = $em->getRepository('MyAppGlobalBundle:Villes')->getAutoCompletionVille(); //Liste toutes les villes	
		//Préparation de la view dashboard_clients.html.twig.
		return $this->render('MyAppAdminBundle:General:dashboard_clients.html.twig',
				array(
						'annee'	 				=> date('Y'),
						'name_admin' 			=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'mcl' 					=> "menu_clients",
						'displaypage' 			=> $displaypage,
						'firstpage' 			=> 1,
						'lettre' 				=> $lettre,
						'page' 					=> $page,
						'result' 				=> $result,
						'autocompletion' 		=> $autocompletion,
						'form' 					=> $form->createView(),
						'nbclient'	 			=> $total,
						'form_validation' 		=> $form_validation->createView(),
						'statut' 				=> $statut,
						'number'				=> $number,
						'ville_autocompletion'          => $autoCompletionVille,
						'role'					=> $role,
						'statutVille'			=> $statutVille ,
						'statutClient'			=> $statutClient,
						'recherche'				=> $word,
						'listeClient'			=> $listeClient,
						'category'				=> $category,
						'item'					=> $item,
						
				));
		//On détruit les objets 
		unset($client);
		unset($afficheLesAttraits);
		unset($afficheLesHebergements);
		unset($autocompletion);
		unset($autoCompletionRegion);
		unset($autoCompletionVille);
		unset($autoCompletionZone);
		gc_collect_cycles();	
		gc_disable();
	}
	
	/**
	 * Page du tableau de bord pour ajouter les clients.
	 */
	public function addClientsAction()
	{
	
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);	
		//Récupération de l'entité Utilisateur.
		$client = new Utilisateur();
		//Création du formulaire.
		$form = $this->container->get('form.factory')->create(new AddClientForm(), $client);	
		//Accés à la requête sousmise
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{ 
				$pw = $form->getData()->getPassword(); //on récupère le mot de passe dans le champ du formulaire
				$factory = $this->get('security.encoder_factory');
				$encoder = $factory->getEncoder($client);
				$password = $encoder->encodePassword($pw, $client->getSalt()); //on le hash
				$client->setPassword($password);
				$client->setRoles('ROLE_ADMIN');
				$client->setDateCreation(new \DateTime('now'));
				$client->setValiderPar($user->getUsername());
				$em->persist($client);
				$em->flush();
				echo 'Client ajouté avec succés !';
				//On redirige vers la liste des clients.
				return $this->redirect($this->generateUrl('_Dashboard_clients'));
			}
		}
		//Préparation de la view dashboard_clients.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addclients.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin'                            => $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'mcl' 					=> "menu_clients",
						'form' 					=> $form->createView(),
						'infonom' 				=> $client->getUsername(),
						'infoid' 				=> $client->getId(),
						'exist' 				=> 'true',
						'mois' 					=> date('n'),
						'jour' 					=> date('d'),
						'annee' 				=> date('Y'),
						'role'					=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour modifié et supprimer les clients.
	 */
	public function updateClientsAction($id, $number)
	{
		$pwExist = "";
		//Appelle du garbage collector
		gc_enable();
		$validRole = new ControleDataSecureController();
		//On valide les arguments
		$id = $validRole->getValidInteger($id);
		$index = $id;
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$role = $validRole->getValidRoles($user);
		//Récupération du client à modifier	dans la table utilisateur
		$clientModif = $em->find('MyAppGlobalBundle:Utilisateur', $id);
		DEFINE("PASSWD", $clientModif->getPassword());
		//Création du formulaire de modification du client.
		$form = $this->container->get('form.factory')->create(new AddClientForm(), $clientModif);
		//Accés à la requête soumise
		$request = $this->get('request');
		//On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			//On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			//if( $form->isValid() )
			//{
                                //On regarde si la checkbox pour modifier le mot de passe est cochée.
                                $checkbox = $form->getData()->getResetPassword();
                                if($checkbox === true)
                                {
                                        $pw = $form->getData()->getPassword(); //on récupère le mot de passe dans le champ du formulaire
                                        $factory = $this->get('security.encoder_factory');					
                                        $encoder = $factory->getEncoder($clientModif);
                                        $password = $encoder->encodePassword($pw, $clientModif->getSalt()); //on le hash
                                        $clientModif->setPassword($password);
                                }
                                else{ 
                                        $clientModif->setPassword(PASSWD);
                                }
				// On enregistre notre objet $clientModif dans la base de données.
				$clientModif->setRoles('ROLE_ADMIN');
				$clientModif->setValiderPar($user->getUsername());		
				$em->persist($clientModif);
				$em->flush();
				echo 'Client modifié avec succés !';
				//On redirige vers la liste des clients du système.
				gc_collect_cycles();
				gc_disable();
				/*if($number != 1){
					return $this->redirect($this->generateUrl('_Dashboard_clientSysteme'));
				}else{ */
					return $this->redirect($this->generateUrl('_Dashboard_clients'));
				//}
                                
			//}
		}	
		//Préparation de la view dashboard_clients.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_addclients.html.twig',
				array(
                                        'annee' 				=> date('Y'),
                                        'name_admin'                            => $user->getUsername(),
                                        'pointeur'			 	=> 'pointeur',
                                        'mcl' 					=> "menu_clients",
                                        'form' 					=> $form->createView(),
                                        'infoid' 				=> $id,
                                        'infonom'				=> $clientModif->getNom(),
                                        'role'					=> $role,
                                        'displayPw'                             => $clientModif->getPassword(),
				));
		
	}
	
	/**
	 * Page du tableau de bord pour supprimer les clients.
	 */
	/*public function deleteClientsAction($id)
	{
		//Vérification des arguments dans l'url
		$id = (new ControleDataSecureController)->getValidInteger($id);
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Recherche du client à supprimer
		$clients = $em->find('MyAppGlobalBundle:Clients', $id);		
		$em->remove($clients);
		$em->flush();
		//Redirection à la page d'accueil des clients
		return $this->redirect($this->generateUrl('_Dashboard_clients'));
	}*/
	
/*####################################################################################*/
/*############### SECTION TEXTES D'ACCUEIL POUR LES SECTION DU SITE ##################*/
/*####################################################################################*/
	
	/**
	 * Méthode pour la gestion du texte de la section accueil
	 */
	public function gestionTexteAccueilAction($id = 1)
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//On récupère les textes à modifier
		$texte = $em->find('MyAppGlobalBundle:Textes_accueil', $id);
		//Création du formulaire avec hydratation des champs des formulaires avec son entité.
		$form = $this->container->get('form.factory')->create(new AddTextesAccueilForm(), $texte);
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
				//Txt accueil fr
				$txtaccueilfr = $validRole->getSecureData($form->getData()->getTexteAccueilFr());
				$texte->setTexteAccueilFr( $txtaccueilfr );
				//Txt hébergement fr
				$txthebergementfr = $validRole->getSecureData($form->getData()->getTexteAccueilHebergementFr());
				$texte->setTexteAccueilHebergementFr( $txthebergementfr );
				//Txt forfait fr
				$txtforfaitfr = $validRole->getSecureData($form->getData()->getTexteAccueilForfaitFr());
				$texte->setTexteAccueilForfaitFr( $txtforfaitfr );
				//Txt corporatif fr
				$txtcorporatiffr = $validRole->getSecureData($form->getData()->getTexteAccueilCorporatifFr());
				$texte->setTexteAccueilCorporatifFr( $txtcorporatiffr );
				//Txt centre de santé fr
				$txtsantefr = $validRole->getSecureData($form->getData()->getTexteAccueilSanteFr());
				$texte->setTexteAccueilSanteFr( $txtsantefr );
				//Txt attrait fr
				$txtattraitfr = $validRole->getSecureData($form->getData()->getTexteAccueilAttraitFr());
				$texte->setTexteAccueilAttraitFr( $txtattraitfr );
				//Txt promotion fr
				$txtpromotionfr = $validRole->getSecureData($form->getData()->getTexteAccueilPromotionFr());
				$texte->setTexteAccueilPromotionFr( $txtpromotionfr );
				//Txt restaurant fr
				$txtrestaurantfr = $validRole->getSecureData($form->getData()->getTexteAccueilRestaurantFr());
				$texte->setTexteAccueilRestaurantFr( $txtrestaurantfr );
				$em->persist($texte);
				$em->flush();
				echo 'Textes ajoutés avec succés !';
				return $this->redirect($this->generateUrl('_Dashboard_general'));
			}
		}
		//Préparation de la view dashboard_texte_accueil.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_texte_accueil.html.twig',
                        array(
                                        'annee'                 => date('Y'),
                                        'name_admin' 		=> $user->getUsername(),
                                        'pointeur' 		=> 'pointeur',
                                        'mtx' 			=> "menu_texte",
                                        'role'			=> $role,
                                        'form'			=> $form->createView(),
                                        'txtaccueilfr'		=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilFr())),
                                        'txthebergementfr'	=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilHebergementFr())),
                                        'txtforfaitfr'		=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilForfaitFr())),
                                        'txtcorporatiffr'	=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilCorporatifFr())),
                                        'txtsantefr'		=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilSanteFr())),
                                        'txtattraitfr'		=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilAttraitFr())),
                                        'txtpromotionfr'	=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilPromotionFr())),
                                        'txtrestaurantfr'	=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilRestaurantFr())),
		));
	}
	
	/**
	 * Méthode pour la gestion du texte de la section accueil version anglaise
	 */
	public function gestionTexteAccueilEnAction($id = 1)
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//On récupère les textes à modifier
		$texte = $em->find('MyAppGlobalBundle:Textes_accueil_en', $id);
		//Création du formulaire avec hydratation des champs des formulaires avec son entité.
		$form = $this->container->get('form.factory')->create(new AddTextesAccueilEnForm(), $texte);
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
				//Txt accueil en
				$txtaccueilen = $validRole->getSecureData($form->getData()->getTexteAccueilEn());
				$texte->setTexteAccueilEn($txtaccueilen) ;
				//Txt hébergement en
				$txthebergementen = $validRole->getSecureData($form->getData()->getTexteAccueilHebergementEn());
				$texte->setTexteAccueilHebergementEn( $txthebergementen );
				//Txt forfait en
				$txtforfaiten = $validRole->getSecureData($form->getData()->getTexteAccueilForfaitEn());
				$texte->setTexteAccueilForfaitEn( $txtforfaiten );
				//Txt corporatif en
				$txtcorporatifen = $validRole->getSecureData($form->getData()->getTexteAccueilCorporatifEn());
				$texte->setTexteAccueilCorporatifEn( $txtcorporatifen );
				//Txt centre de santé en
				$txtsanteen = $validRole->getSecureData($form->getData()->getTexteAccueilSanteEn());
				$texte->setTexteAccueilSanteEn( $txtsanteen );
				//Txt attrait en
				$txtattraiten = $validRole->getSecureData($form->getData()->getTexteAccueilAttraitEn());
				$texte->setTexteAccueilAttraitEn( $txtattraiten );
				//Txt promotion en
				$txtpromotionen = $validRole->getSecureData($form->getData()->getTexteAccueilPromotionEn());
				$texte->setTexteAccueilPromotionEn( $txtpromotionen );
				//Txt restaurant en
				$txtrestauranten = $validRole->getSecureData($form->getData()->getTexteAccueilRestaurantEn());
				$texte->setTexteAccueilRestaurantEN( $txtrestauranten );
				$em->persist($texte);
				$em->flush();
				echo 'Textes ajoutés avec succés !';
				return $this->redirect($this->generateUrl('_Dashboard_general'));
			}
		}
		//Préparation de la view dashboard_texte_accueil.html.twig
		return $this->render('MyAppAdminBundle:General:dashboard_texte_accueil_en.html.twig',
				array(
						'annee' 			    => date('Y'),
						'name_admin' 		    => $user->getUsername(),
						'pointeur' 			 	=> 'pointeur',
						'mtx' 				 	=> "menu_texte",
						'role'					=> $role,
						'form'					=> $form->createView(),
						'txtaccueilen'			=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilEn())),
						'txthebergementen'		=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilHebergementEn())),
						'txtforfaiten'			=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilForfaitEn())),
						'txtcorporatifen'		=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilCorporatifEn())),
						'txtsanteen'			=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilSanteEn())),
						'txtattraiten'			=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilAttraitEn())),
						'txtpromotionen'		=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilPromotionEn())),
						'txtrestauranten'		=> str_replace(array("\r\n"), " ", html_entity_decode($texte->getTexteAccueilRestaurantEn())),
		));
	}
        
/*####################################################################################*/
/*############### MÉTHODES DIVERSES (COURS DE CHANGE ET TRADUCTION) ##################*/
/*####################################################################################*/	
	
	
	/**
	 * Récupère le taux de change dollar Américain par flux xml connecter à la banque du Canada
	 */
	private function getTauxChangeUsa(){
		//On récupère le flux  des taux de change de la banque du Canada
		$fichier = "http://www.banqueducanada.ca/stats/assets/rates_rss/noon/fr_all.xml";
		//On vérifie que le flux est pas défaillant.
		if(isset($fichier))
		{
			$xml = simplexml_load_file($fichier);
			//On tri pour récupèrer les valeurs dans les titles qui nous intéresses.
			foreach($xml->item as $info)
			{	//On stoque les valeurs dans un tableau est le trier pour s'assurer que les valeurs correspondent bien aux monnaies que l'on d�sire avoir
				$tab = array(substr($info->title, 4,11).'<br />');
				sort($tab);
				foreach($tab as $key => $val)
				{
					if(strstr($val, 'USD')){
						//On contrôle que c'est bien le taux de pour dollar américain.
						$taux_usa = $val ;
						$taux_usa = substr($taux_usa, 0,6);//On enlève les ignitiales des monnaies exemple USD pour juste garder la valeur				
					}
				}
			}
			return $taux_usa ;
		}
		else
			exit("Impossible d'accéder au taux de changes de la banque du Canada");//Affiche le message si le flux est inaccessible.
	}

	/**
	 * Récupère le taux de change Euro par flux xml connecter à la banque du Canada
	 */
	private function getTauxChangeEuro(){
		//On récupère le flux  des taux de change de la banque du Canada
		$fichier = "http://www.banqueducanada.ca/stats/assets/rates_rss/noon/fr_all.xml";
		//On vérifie que le flux est pas défaillant.
		if(isset($fichier))
		{
			$xml = simplexml_load_file($fichier);
			//On tri pour récupèrer les valeurs dans les titles qui nous intéresses.
			foreach($xml->item as $info)
			{	//On stocke les valeurs dans un tableau est le trier pour s'assurer que les valeurs correspondent bien aux monnaies que l'on désire avoir
				$tab = array(substr($info->title, 4,11).'<br />');
				sort($tab);
				foreach($tab as $key => $val)
				{
					if(strstr($val, 'EUR')){
						//On contrôle que c'est bien le taux de change pour l'euro.
						$taux_eur = $val ;
						$taux_eur = substr($taux_eur, 0,6);//On enlève les ignitiales des monnaies exemple EUR pour juste garder la valeur
					}
				}
			}
			return $taux_eur;

		}
		else
			exit("Impossible d'accéder au taux de changes de la banque du Canada");//Affiche le message si le flux est inaccessible.
	}
}