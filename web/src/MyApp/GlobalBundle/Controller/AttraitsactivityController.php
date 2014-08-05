<?php
namespace MyApp\GlobalBundle\Controller;
use MyApp\AdminBundle\Forms\SelectAttraitType;
use Symfony\Component\BrowserKit\Request;
use MyApp\AdminBundle\Forms\SearchMoteurEnginePortailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyApp\GlobalBundle\Form\GoogleForm;
use MyApp\GlobalBundle\Entity\Formu_province_region;
use MyApp\GlobalBundle\Entity\Attraits;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use Berriart\Bundle\SitemapBundle\Entity\ImageUrl;
use MyApp\GlobalBundle\Controller\DefaultController;
use MyApp\GlobalBundle\Entity\Utilisateur;

/**
 * 
 * @author leonardc
 * 
 * Classe pour la section attraits et activité coté portail
 *
 */
class AttraitsactivityController extends Controller{
	
	
	/**
	 * Génère le site map
	 * @param $createUrl __url qui va être ajouter dans le site map
	 */
	private function populateSiteMapAction($createUrl)
	{
		if(is_array($createUrl))
		{
			for($i = 0; $i < count($createUrl); $i++ )
			{
				$sitemap = $this->get('sitemap');
				$url = new Url();
				$url->setLoc($createUrl[$i]);
				$url->setLastmod(new \DateTime());
				$url->setChangeFreq(Url::CHANGEFREQ_DAILY);
				$url->setPriority('0.4');
				$sitemap->add($url);
				$sitemap->save();
			}
		}
		else
		{
			$sitemap = $this->get('sitemap');
			$url = new Url();
			$url->setLoc($createUrl);
			$url->setLastmod(new \DateTime());
			$url->setChangeFreq(Url::CHANGEFREQ_DAILY);
			$url->setPriority('0.4');
			$sitemap->add($url);
			$sitemap->save();
		}
	}
	
	/**
	 * Traitement du moteur de recherche
	 */
	private function getRechercheMoteurDeRecherche()
	{
		//Gestionnaire des entités
		$em  = $this->getDoctrine()->getEntityManager();
		//Moteur de recherche
		$client = new Utilisateur();
		$formEngine = $this->container->get('form.factory')->create(new SearchMoteurEnginePortailType(), $client);
		$request = $this->get('request');
		if($request->getMethod() != "POST")
		{
			return array("form", $formEngine);
		}
		else
		{
			//$request = $this->get('request');
			if( $request->getMethod() == 'POST' ){
				// On fait le lien Requête <-> Formulaire.
				$formEngine->bindRequest($request);
				$word = $formEngine->getData()->getNom();
				if($word != null)
				{
					$solo = $multiple = "";
                                        $rep = (new DefaultController)->getMoteurRechercheAction($word, $em);                                                                          
                                        if($rep != null)
                                        {                                      
                                              if($rep[1] == "hebergement")
                                              {                
                                                  $tab = array("request", $this->redirect($this->generateUrl('_hebergementinfoclient', array( 'name' => strtolower($rep[0][0]->getRepertoireFr()) ))));
                                                  ($tab != null)? $solo = true: $solo = false;
                                                  $this->champRecherche = $word;
                                                  return $tab;
                                              }
                                           /* }else{
                                                //$listeProposition = $em->getRepository('MyAppGlobalBundle:Hebergements')->getListeClientPropositionMoteurRecherche($tab);
                                                return $this->redirect($this->generateUrl('_propositionmoteurrecherche'));
                                            }  */                                          
                                        }  
                                        else
                                        {                                         
                                            $tab = array("multiple", $em->getRepository('MyAppGlobalBundle:Hebergements')->getRechercheTout($word)); 
                                            ($tab != null)? $multiple = true: $multiple = false;
                                            $this->champRecherche = $word;
                                            return $tab;
                                        }                                        
					if($solo == false && $multiple == false) {						
						throw new \Exception("Aucun résultat trouvé");
					}
				}
				return $this->redirect($this->generateUrl($word), 404);
			}
		}
	}
        
        /**
         * Méthode pour retourner tous les résultats trouvés par la recherche avec le moteur
         */
        private function getSimuleGoogleSearch($rep)
        {          
            //Gestionnaire des entités
            $em = $this->getDoctrine()->getEntityManager();
            //Québec en saison
            $saison = (new DefaultController)->getSaisonQuebec();   
            //traitement formulaire reservation en ligne
            $reservationEnLignePays = (new DefaultController)->getReservationEnLignePays($em);
            //Moteur de recherche
            $listClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutocompletionPortail();
            //Moteur de reecherche
            $client = new Utilisateur();
            $formEngine = $this->container->get('form.factory')->create(new SearchMoteurEnginePortailType(), $client);           
            //Liste des régions pour la réservation
            $fullListReservation = new DestinationController;
            $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
            //Liste des villes pour la réservation
            $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
            $lang = $this->container->get("session")->getLocale();
            //rendu de la vue des résultats         
            if($lang == "fr"){
                return $this->render("MyAppGlobalBundle:Hebergement:ResultatsSearch.html.twig", array(
                    "resultat"                  => $rep[1],  
                    "champRecherche"            => $this->champRecherche,
                    'googledfp1'                => "GR_ACCUEIL_01",
                    'googledfp2'		=> "GR_ACCUEIL_02",
                    'googledfp3'		=> "GR_ACCUEIL_03",                       
                    'reservationRegionAjax'     => $reservationRegionAjax,
                    'reservationVilleAjax'      => $reservationVilleAjax,
                    'saison'			=> $saison,
                    'formEngine'		=> $formEngine->createView(),
                    'reservationPays'           => $reservationEnLignePays[0],
                    'reservationProvince'       => $reservationEnLignePays[1],
                    'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                    'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                    'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2], 
                    'multipleResultat'          => true,
                    'sansItem'                  => true,
                    'titrefrsansitem'           => "Résultat de la recherche $this->champRecherche",
                ));
            }
            else{
                return $this->render("MyAppGlobalBundle:Hebergement:ResultatsSearch-en.html.twig", array(
                    "resultat"                  => $rep[1],  
                    "champRecherche"            => $this->champRecherche,
                    'googledfp1'                => "GR_ACCUEIL_01",
                    'googledfp2'		=> "GR_ACCUEIL_02",
                    'googledfp3'		=> "GR_ACCUEIL_03",                       
                    'reservationRegionAjax'     => $reservationRegionAjax,
                    'reservationVilleAjax'      => $reservationVilleAjax,
                    'saison'			=> $saison,
                    'formEngine'		=> $formEngine->createView(),
                    'reservationPays'           => $reservationEnLignePays[0],
                    'reservationProvince'       => $reservationEnLignePays[1],
                    'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                    'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                    'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2], 
                    'multipleResultat'          => true,
                    'sansItem'                  => true,
                    'titrefrsansitem'           => "Search Result $this->champRecherche",
                ));
            }
        }
	
	public function getListeFooterRegion($em)
	{
		//On liste les regions de chaques provinces pour le menu du footer
		$regionQcFooter = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheProvincesFooterHotel(9);
		$regionOnFooter = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheProvincesFooterHotel(8);
		$regionNbFooter = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheProvincesFooterHotel(5);
		//On stocke les résultats dans un tableau
		$tab = [$regionQcFooter, $regionOnFooter, $regionNbFooter];
		return $tab;
	}
	

	/**
	 * Page index pour les attraits et activités
	 */
	public function indexAction()
	{
            $clientAleatoire = $reservationRegionAjax = $reservationVilleAjax = "";
	    //Gestionnaire pour les entités
	    $em = $this->getDoctrine()->getEntityManager();
	    //On récupère le texte d'accueil
	    $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilAttrait();
	    $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilAttraiten();
	    //Liste des régions qui ont des attraits et activités
	    $regionqc = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRegionsPourAttrait(9);
	    $regionon = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRegionsPourAttrait(8);
	    $regionnb = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRegionsPourAttrait(5);
	    //Liste les catégories d'attraits et activités des provinces
            $tab = array(9,8,5);	//(Québec, Ontario, Nouveau Brunswick)
	    $listattrait = $em->getRepository('MyAppGlobalBundle:Attraits')->getAllAttraitProvinces($tab);
            //Si on a pas d'attrait de disponible on redirige vers une autre page
            if($listattrait == null){
			return $this->redirect($this->generateUrl("_demandesansitem", array("section" => "attrait")));
            }
	    //Listes des suggestions attraits et activités 
	    $tabloSuggestion = $tabloBuild = $tabaleatoire = [];
	    if(count($listattrait) > 3){
	    	$tabloSuggestion = array_rand($listattrait, 3);
	    	//Id categorie attrait
	    	foreach($listattrait as $tw){
	    		$tabloListe = $em->getRepository('MyAppGlobalBundle:Attraits_categories')->getRechercheIdCategorie($tw->getCategorieAttrait()->getId());
	    		if(count($tabloListe) > 4){
	    			$tablo = array_rand($tabloListe, 4);
	    			$tabloListe = [];
	    			$tabloListe = $tablo;
	    			$tabaleatoire = array_push($tablo, 1);
	    			unset($tablo);
	    		}
	    		array_push($tabloBuild, $tabloListe[0]);
	    	}
	    }else{	
	    	$tabloSuggestion = $listattrait;
	    	//Id categorie attrait
	    	foreach($listattrait as $tw){
	    		$tabloListe = $em->getRepository('MyAppGlobalBundle:Attraits_categories')->getRechercheIdCategorie($tw->getCategorieAttrait()->getId());  	
	    		if(count($tabloListe) > 4){
	    			$tablo = array_rand($tabloListe, 4);
	    			$tabloListe = [];
	    			$tabloListe = $tablo;
	    			$tabaleatoire = array_push($tablo, 1);
	    			unset($tablo);
	    		}
	    		array_push($tabloBuild, $tabloListe[0]);
	    	}
	    }
	    //On récupère un client aléatoire
	   	$tabloId = [];
	   	foreach($listattrait as $index)
	   	{
	   		array_push($tabloId, $index->getId());
	   	}
                if($tabloId != null){
                    if(count($tabloId) > 1){
                        $attraitAleatoire = array_rand($tabloId, 1);
                    }else{
                        $attraitAleatoire = $tabloId;
                    }
                    $clientAleatoire = $listattrait[$attraitAleatoire];
                }
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//Moteur de recherche
		$listClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutocompletionPortail();		
		$retourEngine = $this->getRechercheMoteurDeRecherche();  
		if($retourEngine[0] == "form")
		{
                    $formEngine = $retourEngine[1];
		}
		if($retourEngine[0] == "request")
		{
                    //Retourne vers la fiche client
                    return $retourEngine[1];
		}
                elseif($retourEngine[0] == "multiple")
                {                       
                    //retourne vers la vue pour afficher tous les résultats de la recherche
                    return $this->getSimuleGoogleSearch($retourEngine);
                }	
		//Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/attraits_activites.html', '/activities_attractions.html'));
                //Titre du lien Québec en saison
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view attrait.html.twig
		return $this->render('MyAppGlobalBundle:Attraits_&_activites:attraits.html.twig', 
				array(	
					  	'regionqc' 			=> $regionqc, 
					  	'regionon' 			=> $regionon, 
					  	'regionnb' 			=> $regionnb,
					  	'insection' 			=> "inSection",
					  	'attraits' 			=> 'valid',
					  	'form' 				=> $form->createView(), 
						'urlattraitsactivity'           => "Attraits et activités",
						'classCssFirstNode'		=> "corrige",
						'regionQcFooter'		=> $this->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> $this->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> $this->getListeFooterRegion($em)[2],
						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_attrait_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_attrait_en']),
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $clientAleatoire,
						'googledfp1'			=> "GR_ATTRAIT_01",
						'googledfp2'			=> "GR_ATTRAIT_02",
                                                'googledfp3'			=> "GR_ATTRAIT_03",
						'listeSuggestion'		=> $tabloSuggestion,
						'listeClientAttrait'            => $tabloBuild,
						'tabAleatoire'			=> $tabaleatoire,
						'saison'			=> $saison,
						'reservationRegionAjax'         => $reservationRegionAjax,
						'reservationVilleAjax'          => $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'           => $reservationEnLignePays[1],
                                                'metaattraitfr'                 => $texte_accueil[0],
                                                'metaattraiten'                 => $texte_accueil_en[0],
                                                'main'                          => true,
				));		
	}
	
	/**
	 * Page qui affiche la liste des catégories d'attraits une fois la province choisit
	 */
	public function attraitprovinceAction($name)
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Contrôle le nom de la province
		$controle = new ControleDataSecureController();
		$name = $controle->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em  = $this->getDoctrine()->getEntityManager();
		//Recherche l'id de la province 
		$idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);
		//Affiche la province choisie
		$nomprovince = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheProvincesPOurAttrait($idProvince[0]->getId());
		//Liste des régions qui ont des attraits et activités
		$region = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRegionsPourAttrait($idProvince[0]->getId());
		//Liste les catégories d'attraits pour cette province
		$listattrait = $em->getRepository('MyAppGlobalBundle:Attraits')->getSortProvinceAttrait($idProvince[0]->getId());
		//Listes des suggestions attraits et activités
		$tabloSuggestion = $tabloBuild = $tabaleatoire = [];
		if(count($listattrait) > 3){
			$tabloSuggestion = array_rand($listattrait, 3);
			//Id categorie attrait
			foreach($listattrait as $tw){
				$tabloListe = $em->getRepository('MyAppGlobalBundle:Attraits_categories')->getRechercheIdCategorie($tw->getCategorieAttrait()->getId());
				if(count($tabloListe) > 4){
					$tablo = array_rand($tabloListe, 4);
					$tabloListe = [];
					$tabloListe = $tablo;
					$tabaleatoire = array_push($tablo, 1);
					unset($tablo);
				}
				array_push($tabloBuild, $tabloListe[0]);
			}
		}else{
			$tabloSuggestion = $listattrait;
			//Id categorie attrait
			foreach($listattrait as $tw){
				$tabloListe = $em->getRepository('MyAppGlobalBundle:Attraits_categories')->getRechercheIdCategorie($tw->getCategorieAttrait()->getId());
				if(count($tabloListe) > 4){
					$tablo = array_rand($tabloListe, 4);
					$tabloListe = [];
					$tabloListe = $tablo;
					$tabaleatoire = array_push($tablo, 1);
					unset($tablo);
				}
				array_push($tabloBuild, $tabloListe[0]);
			}
		}	
		//On récupère un client aléatoire
		$tab = [];
		foreach($listattrait as $ts)
		{
			array_push($tab, $ts->getId());
		}
		$index = array_rand($tab, 1);
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait_en");
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//Moteur de recherche
		$listClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutocompletionPortail();		
		$retourEngine = $this->getRechercheMoteurDeRecherche();  
		if($retourEngine[0] == "form")
		{
                    $formEngine = $retourEngine[1];
		}
		if($retourEngine[0] == "request")
		{
                    //Retourne vers la fiche client
                    return $retourEngine[1];
		}
                elseif($retourEngine[0] == "multiple")
                {                       
                    //retourne vers la vue pour afficher tous les résultats de la recherche
                    return $this->getSimuleGoogleSearch($retourEngine);
                }	
		//Site map
                (new HebergementController)->generePersistSiteMap2('/attraits_activites_province_', '/activities_attractions_province_', $idProvince[0], $em);
		//On recherche un client aléatoire pour chaque activité de la liste
		$categorieAleatoire = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheLaListeDesCategorieDAttraitsProvince($idProvince[0]->getId());
		$tablo = [];
		foreach($categorieAleatoire as $tx)
		{
			array_push($tablo, $tx->getCategorieAttrait());
		}	
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view attraitsProvince.html.twig
		return $this->render('MyAppGlobalBundle:Attraits_&_activites:attraitsProvince.html.twig',
				array(
						'views' 				=> $name,
						'nomprovince' 			=> $nomprovince,
						'insection' 			=> "inSection",
						'attraits' 				=> 'valid',
						'region' 				=> $region,
						'form'					=> $form->createView(),
						'urlattraitsactivity'	=> "Attraits et activités",
						'classCssProvinceNode'	=> 'corrige',
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'regionQcFooter'		=> $this->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> $this->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> $this->getListeFooterRegion($em)[2],
						'clientAleatoire'		=> $listattrait[$index],
						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_attrait_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_attrait_en']),
						'noeudArianeAttrait'	=> true,
						'nodeAttraitProvince'	=> true,
						'googledfp1'			=> "GR_ATTRAIT_01",
						'googledfp2'			=> "GR_ATTRAIT_02",
                                                'googledfp3'			=> "GR_ATTRAIT_03",
						'listeSuggestion'		=> $tabloSuggestion,
						'listeClientAttrait'	=> $tabloBuild,
						'tabAleatoire'			=> $tabaleatoire,
						'saison'				=> $saison,
						'reservationRegionAjax' => $reservationRegionAjax,
						'reservationVilleAjax'	=> $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'	=> $reservationEnLignePays[1],
				));
	}
	
	/**
	 * Page qui affiche les attraits quand on a choisi la région
	 */
	public function listerRegionAction($name)
	{	
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Contrôle le nom de la région
		$controle = new ControleDataSecureController();
		$name = $controle->getCleanNameGeography($name, "region");
		//Gestionnaire des entités
		$em  = $this->getDoctrine()->getEntityManager();
		//Recherche l'id de la région par son nom
		$idRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getSearchRegion($name);
		//Affiche la région avec ses villes
		$villes = $em->getRepository('MyAppGlobalBundle:Attraits')->getSortVilleAttrait($idRegion[0]->getId());
		//Liste les catégories d'attraits et d'activités
		$listattrait = $em->getRepository('MyAppGlobalBundle:Attraits')->getSortRegionAttrait($idRegion[0]->getId());
		//Listes des suggestions attraits et activités
		$tabloSuggestion = $tabloBuild = $tabaleatoire = [];
		if(count($listattrait) > 3){
			$tabloSuggestion = array_rand($listattrait, 3);
			//Id categorie attrait
			foreach($listattrait as $tw){
				$tabloListe = $em->getRepository('MyAppGlobalBundle:Attraits_categories')->getRechercheIdCategorie($tw->getCategorieAttrait()->getId());
				if(count($tabloListe) > 4){
					$tablo = array_rand($tabloListe, 4);
					$tabloListe = [];
					$tabloListe = $tablo;
					$tabaleatoire = array_push($tablo, 1);
					unset($tablo);
				}
				array_push($tabloBuild, $tabloListe[0]);
			}
		}else{
			$tabloSuggestion = $listattrait;
			//Id categorie attrait
			foreach($listattrait as $tw){
				$tabloListe = $em->getRepository('MyAppGlobalBundle:Attraits_categories')->getRechercheIdCategorie($tw->getCategorieAttrait()->getId());
				if(count($tabloListe) > 4){
					$tablo = array_rand($tabloListe, 4);
					$tabloListe = [];
					$tabloListe = $tablo;
					$tabaleatoire = array_push($tablo, 1);
					unset($tablo);
				}
				array_push($tabloBuild, $tabloListe[0]);
			}
		}
		//On chercher un client aléatoire
		$tab = [];
		foreach($listattrait as $ts)
		{
			array_push($tab, $ts->getId());
		}
		$index = array_rand($tab, 1);
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait_en");
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//Moteur de recherche
		$listClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutocompletionPortail();		
		$retourEngine = $this->getRechercheMoteurDeRecherche();  
		if($retourEngine[0] == "form")
		{
                    $formEngine = $retourEngine[1];
		}
		if($retourEngine[0] == "request")
		{
                    //Retourne vers la fiche client
                    return $retourEngine[1];
		}
                elseif($retourEngine[0] == "multiple")
                {                       
                    //retourne vers la vue pour afficher tous les résultats de la recherche
                    return $this->getSimuleGoogleSearch($retourEngine);
                }	
		//Site map
                (new HebergementController)->generePersistSiteMap2('/attraits_activites_region_', '/activities_attractions_region_', $idRegion[0], $em);
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view attraitsindex.html.twig
		return $this->render('MyAppGlobalBundle:Attraits_&_activites:attraitsRegion.html.twig', 
				array(	 
				  	  	'views' 				=> $name, 
				  	  	'villes' 				=> $villes, 
				  	  	'insection' 			=> "inSection", 
					  	'attraits' 				=> 'valid', 
						'form'					=> $form->createView(),
						'urlattraitsactivity'	=> "Attraits et activités",
						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_attrait_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_attrait_en']),
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'regionQcFooter'		=> $this->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> $this->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> $this->getListeFooterRegion($em)[2],
						'noeudArianeAttrait'	=> true,
						'clientAleatoire'		=> $listattrait[$index],
						'regionOrthographe'		=> true,
						'nodeAttraitRegion'		=> true,
						'googledfp1'			=> "GR_ATTRAIT_01",
						'googledfp2'			=> "GR_ATTRAIT_02",
                                                'googledfp3'			=> "GR_ATTRAIT_03",
						'listeSuggestion'		=> $tabloSuggestion,
						'listeClientAttrait'	=> $tabloBuild,
						'tabAleatoire'			=> $listattrait,
						'saison'				=> $saison,
						'reservationRegionAjax' => $reservationRegionAjax,
						'reservationVilleAjax'	=> $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'	=> $reservationEnLignePays[1],
				));
	}
	
	/**
	 * Page qui affiche la liste des catégories d'attraits une fois la ville choisi
	 */
	public function listerVilleAction($name)
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Contrôle le nom de la province
		$controle = new ControleDataSecureController();
		$name = $controle->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em  = $this->getDoctrine()->getEntityManager();
		//Recherche l'id de la ville
		$idVille = $em->getRepository('MyAppGlobalBundle:Villes')->getInfosVille($name);
		//Liste les catégories d'attraits pour cette ville
		$listattrait = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheListeAttraitPourVille($idVille[0]->getId());
		//On récupère un client aléatoire
		$tab = [];
		foreach($listattrait as $ts)
		{
			array_push($tab, $ts->getId());
		}
		if(count($tab) > 1)
		{
			$index = array_rand($tab, 1);
			$clientAleatoire = $listattrait[$index];
		}
		else 
		{
			$clientAleatoire = $listattrait[0];
		}
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait_en");
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//Moteur de recherche
		$listClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutocompletionPortail();		
		$retourEngine = $this->getRechercheMoteurDeRecherche();  
		if($retourEngine[0] == "form")
		{
                    $formEngine = $retourEngine[1];
		}
		if($retourEngine[0] == "request")
		{
                    //Retourne vers la fiche client
                    return $retourEngine[1];
		}
                elseif($retourEngine[0] == "multiple")
                {                       
                    //retourne vers la vue pour afficher tous les résultats de la recherche
                    return $this->getSimuleGoogleSearch($retourEngine);
                }	
		//Site map
                (new HebergementController)->generePersistSiteMap2('/attraits_activites_ville_', '/activities_attractions_city_', $idVille[0], $em);
		//Titre lien Québec en saison
                $controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view attraitsProvince.html.twig
		return $this->render('MyAppGlobalBundle:Attraits_&_activites:attraitsVille.html.twig',
				array(
						'views' 				=> $name,
						'insection' 			=> "inSection",
						'attraits' 				=> 'valid',
						'listattrait' 			=> $listattrait,
						'form'					=> $form->createView(),
						'urlattraitsactivity'	=> "Attraits et activités",
						'classCssProvinceNode'	=> 'corrige',
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'regionQcFooter'		=> $this->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> $this->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> $this->getListeFooterRegion($em)[2],
						'clientAleatoire'		=> $clientAleatoire,
						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_attrait_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_attrait_en']),
						'noeudArianeAttrait'	=> true,
						'nodeAttraitVille'		=> true,
						'googledfp1'			=> "GR_ATTRAIT_01",
						'googledfp2'			=> "GR_ATTRAIT_02",
                                                'googledfp3'			=> "GR_ATTRAIT_03",
						'saison'				=> $saison,
						'reservationRegionAjax' => $reservationRegionAjax,
						'reservationVilleAjax'	=> $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'	=> $reservationEnLignePays[1],
				));
	}
	
	/**
	 * Page qui affiche l'activité choisie
	 */
	public function attraitActiviteDefaultAction($name)
	{
            $reservationRegionAjax = $reservationVilleAjax = "";
            //Contrôle le nom de l'activité
            $controle = new ControleDataSecureController();
            $name = $controle->getCleanNameGeography($name, "name");
            //Gestionnaire des entités
            $em  = $this->getDoctrine()->getEntityManager();
            //On récupère l'id de l'activité par son nom
            $idActivite = $em->getRepository('MyAppGlobalBundle:Attraits_categories')->getRechercheIdCategorieParSonNom($name);
            //Liste des provinces qui ont des attraits et activités
	    $provinceqc = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheActiviteRechercherPourLaProvince(9, $idActivite[0]->getId());
	    if($provinceqc != null) {
	    	$provinceqc = $provinceqc[0];
	    }
	    $provinceon = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheActiviteRechercherPourLaProvince(8, $idActivite[0]->getId());
	    if($provinceon != null) {
	    	$provinceon = $provinceon[0];
	    }
	    $provincenb = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheActiviteRechercherPourLaProvince(5, $idActivite[0]->getId());
	    if($provincenb != null) {
	    	$provincenb = $provincenb[0];
	    }
	    //Liste des régions qui ont des attraits et activités
	    $regionqc = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRegionsPourAttraitActiviteRechercher(9, $idActivite[0]->getId());
	    $regionon = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRegionsPourAttraitActiviteRechercher(8, $idActivite[0]->getId());
	    $regionnb = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRegionsPourAttraitActiviteRechercher(5, $idActivite[0]->getId());
	    //Liste les catégories d'attraits et activités des provinces
	   	$tab = array(9,8,5);	//(Québec, Ontario, Nouveau Brunswick)
	    $listattrait = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheActiviteRechercherPourLesProvinces($tab, $idActivite[0]->getId());
	    //On récupère un client aléatoire
            $tabloId = [];
            foreach($listattrait as $index)
            {
                    array_push($tabloId, $index->getId());
            }
            $index = array_rand($tabloId, 1);	
            //On récupère le texte d'accueil
            $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait");
            $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait_en");
            //Moteur de recherche
            $listClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutocompletionPortail();		
            $retourEngine = $this->getRechercheMoteurDeRecherche();  
            if($retourEngine[0] == "form")
            {
                $formEngine = $retourEngine[1];
            }
            if($retourEngine[0] == "request")
            {
                //Retourne vers la fiche client
                return $retourEngine[1];
            }
            elseif($retourEngine[0] == "multiple")
            {                       
                //retourne vers la vue pour afficher tous les résultats de la recherche
                return $this->getSimuleGoogleSearch($retourEngine);
            }	
            //Site map   
            (new HebergementController)->getValideUrlSiteMap($em, array('/attraits_activites.html', '/activities_attractions.html'));
            //Formulaire de recherche map intéractive
            $search = new Formu_province_region();
            $form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
            //On prépare la liste des suggestions du bas de page
            $tabSuggestion = [$regionqc, $regionon, $regionnb];
            //On enlève les valeurs vides.
            $tabSuggestion = array_values(array_filter($tabSuggestion));
            shuffle($tabSuggestion);
            $tabClient = [];
            foreach($tabSuggestion as $ts)
            {
                    array_push($tabClient, $ts);
            }
            if(count($tabClient) > 4)// si on à plus que 4 régions
            {
                    $indexSuggestion = [];
                    $indexSuggestion = array_rand($indexSuggestion, 4);
            }
            else
            {
                    $indexSuggestion = [];
                    if(count($tabClient) > 1)
                    {
                            $indexSuggestion = array_rand($tabSuggestion, count($tabSuggestion));
                    }
                    else 
                    {
                            $indexSuggestion = $tabSuggestion[0];
                    }
            }
            $controDefault = new DefaultController();
            $saison = $controDefault->getSaisonQuebec();
            //traitement formulaire reservation en ligne
            $reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
            //Liste des régiond pour la réservation
            $fullListReservation = new DestinationController;
            $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
            //Liste des villes pour la réservation
            $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
            //Préparation de la view attraitsProvinceActivite.html.twig
            return $this->render('MyAppGlobalBundle:Attraits_&_activites:attraitActiviteDefault.html.twig',
				array(
						'insection' 					=> "inSection",
						'attraits' 						=> 'valid',
						'form'							=> $form->createView(),
						'views'							=> $name,
						'formEngine'					=> $formEngine->createView(),
						'listeClient'					=> $listClient,
						'regionQcFooter'				=> $this->getListeFooterRegion($em)[0],
						'regionOnFooter'				=> $this->getListeFooterRegion($em)[1],
						'regionNbFooter'				=> $this->getListeFooterRegion($em)[2],
						'texte_accueilfr'				=> html_entity_decode($texte_accueil[0]['texte_accueil_attrait_fr']),
						'texte_accueilen'				=> html_entity_decode($texte_accueil_en[0]['texte_accueil_attrait_en']),
						'provinceqc'					=> $provinceqc,
						'provinceon'					=> $provinceon,
						'provincenb'					=> $provincenb,
						'regionqc'						=> $regionqc,
						'regionon'						=> $regionon,
						'regionnb'						=> $regionnb,
						'urlattraitsactivity'			=> true,
						'noeudArianeAttrait'			=> true,
						'nodeAttraitActiviteDefault'            => true,
						'clientAleatoire'				=> $listattrait[$index],
						'activite'						=> $idActivite[0],
						'suggestions'					=> $indexSuggestion,
						'googledfp1'					=> "GR_ATTRAIT_01",
						'googledfp2'					=> "GR_ATTRAIT_02",
                                                'googledfp3'                                    => "GR_ATTRAIT_03",
						'saison'						=> $saison,
						'reservationRegionAjax' 		=> $reservationRegionAjax,
						'reservationVilleAjax'			=> $reservationVilleAjax,
						'reservationPays'				=> $reservationEnLignePays[0],
						'reservationProvince'			=> $reservationEnLignePays[1],
				));
	
	}
	
	
	/**
	 * Page qui affiche l'activité choisie partout dans la province
	 */
	public function attraitProvinceActiviteAction($province, $name)
	{	
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Contrôle le nom de l'activité
		$controle = new ControleDataSecureController();
		$name = $controle->getCleanNameGeography($name, "name");
		$province = $controle->getCleanNameGeography($province, "province");
		//Gestionnaire des entités
		$em  = $this->getDoctrine()->getEntityManager();
		//Recherche l'id province
		$idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($province);
		//Recherche l'id de la cateégorie des attraits
		$idCategorie = $em->getRepository('MyAppGlobalBundle:Attraits_categories')->getRechercheIdCategorieParSonNom($name);
		//On recherche la liste des région qui ont cette catégorie d'activité
		$region = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRegionsPourAttraitActiviteRechercher($idProvince[0]->getId(), $idCategorie[0]->getId());
		//On cherche un client aléatoire
		$tab = [];
		foreach($region as $ts)
		{
			array_push($tab, $ts->getId());
		}
		$index = array_rand($tab, 1);
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait_en");
		//Moteur de recherche
		$listClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutocompletionPortail();		
		$retourEngine = $this->getRechercheMoteurDeRecherche();  
		if($retourEngine[0] == "form")
		{
                    $formEngine = $retourEngine[1];
		}
		if($retourEngine[0] == "request")
		{
                    //Retourne vers la fiche client
                    return $retourEngine[1];
		}
                elseif($retourEngine[0] == "multiple")
                {                       
                    //retourne vers la vue pour afficher tous les résultats de la recherche
                    return $this->getSimuleGoogleSearch($retourEngine);
                }	
		//Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/province_'.strtolower($idProvince[0]->getRepertoireFr()).'_attraits_activites_'.strtolower($idCategorie[0]->getRepertoireFr()).'.html', '/province_'.strtolower($idProvince[0]->getRepertoireEn()).'_activities_attractions_'.strtolower($idCategorie[0]->getRepertoireEn()).'.html'));
                //
		$tabSuggestion = [$region];
		shuffle($tabSuggestion);
		$tabClient = [];
		foreach($tabSuggestion as $ts)
		{
			array_push($tabClient, $ts);
		}
		if(count($tabClient) > 4)// si on à plus que 4 régions
		{
			$indexSuggestion = [];
			$indexSuggestion = array_rand($indexSuggestion, 4);
		}
		else
		{
			$indexSuggestion = [];
			if(count($tabClient) > 1)
			{
				$indexSuggestion = array_rand($tabSuggestion, count($tabSuggestion));
			}
			else 
			{
				$indexSuggestion = $tabSuggestion[0];
			}
		}
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view attraitsProvinceActivite.html.twig
		return $this->render('MyAppGlobalBundle:Attraits_&_activites:attraitsProvinceActivite.html.twig', 
				array(
					  	'insection' 					=> "inSection", 
					  	'attraits' 						=> 'valid',
						'form'							=> $form->createView(),
						'views'							=> $name,
						'formEngine'					=> $formEngine->createView(),
						'listeClient'					=> $listClient,
						'regionQcFooter'				=> $this->getListeFooterRegion($em)[0],
						'regionOnFooter'				=> $this->getListeFooterRegion($em)[1],
						'regionNbFooter'				=> $this->getListeFooterRegion($em)[2],
						'texte_accueilfr'				=> html_entity_decode($texte_accueil[0]['texte_accueil_attrait_fr']),
						'texte_accueilen'				=> html_entity_decode($texte_accueil_en[0]['texte_accueil_attrait_en']),
						'urlattraitsactivity'			=> true,
						'noeudArianeAttrait'			=> true,
						'nodeAttraitActiviteProvince'           => true,
						'region'						=> $region,
						'province'						=> $idProvince,
						'clientAleatoire'				=> $region[$index],
						'activite'						=> $idCategorie[0],
						'suggestions'					=> $indexSuggestion,
						'googledfp1'					=> "GR_ATTRAIT_01",
						'googledfp2'					=> "GR_ATTRAIT_02",
                                                'googledfp3'                                    => "GR_ATTRAIT_03",
						'saison'						=> $saison,
						'reservationRegionAjax' 		=> $reservationRegionAjax,
						'reservationVilleAjax'			=> $reservationVilleAjax,
						'reservationPays'				=> $reservationEnLignePays[0],
						'reservationProvince'			=> $reservationEnLignePays[1],
					));
		
	}
	
	/**
	 * Page qui affiche une liste de l'activité choisie dans la région voulue
	 */
	public function attraitRegionActiviteAction($region, $name, $page )
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		$numberPaginate = 10;
		$limit = 4;
		//Contrôle les arguments
		$controle = new ControleDataSecureController();
		$name = $controle->getCleanNameGeography($name, "name");
		$region = $controle->getCleanNameGeography($region, "region");
		//Gestionnaire des entités
		$em  = $this->getDoctrine()->getEntityManager();
		//Récupère l'id de la région par le nom
		$region = $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion(ucfirst($region));
		//Récupère l'id de la catégorie par le nom
		$category = $em->getRepository('MyAppGlobalBundle:Attraits_categories')->getRechercheIdCategorieParSonNom($name);
		//Compte les Utilisateur de la région qui sont de cette catégorie
		$nbClient = $em->getRepository('MyAppGlobalBundle:Attraits')->getCompteClientCategorie($region[0]->getId(), $category[0]->getId());
		//Contrôle la pagination
		$total = $nbClient[0]['resultList'];
		//Arrondit à l'entier supérieur
		$displaypage = ceil($total/$numberPaginate);
		$page = (new ControleDataSecureController)->getValideEntierPagination($page, $displaypage);
		//Liste tous les Utilisateur pour cette activité dans la région
		$listActivite = $em->getRepository('MyAppGlobalBundle:Attraits')->getMemeRegionMemeCategory($region[0]->getId(), $category[0]->getId(), $page, $numberPaginate);
		//On recherche un client aléatoire
		$tab = [];
		foreach($listActivite as $ts)
		{
			array_push($tab, $ts->getId());
		}		
		$index = array_rand($tab, 1);
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait_en");
		//Moteur de recherche
		$listClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutocompletionPortail();		
		$retourEngine = $this->getRechercheMoteurDeRecherche();  
		if($retourEngine[0] == "form")
		{
                    $formEngine = $retourEngine[1];
		}
		if($retourEngine[0] == "request")
		{
                    //Retourne vers la fiche client
                    return $retourEngine[1];
		}
                elseif($retourEngine[0] == "multiple")
                {                       
                    //retourne vers la vue pour afficher tous les résultats de la recherche
                    return $this->getSimuleGoogleSearch($retourEngine);
                }	
		//Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/region_'.strtolower( $region[0]->getRepertoireFr()).'_attraits_activites_'.strtolower($category[0]->getRepertoireFr()).'.html', '/region_'.strtolower( $region[0]->getRepertoireEn()).'_activities_attractions_'.strtolower( $category[0]->getRepertoireEn()).'.html'));
		//Formulaire de recherche par choix
		$formRecherche = $this->createForm(new SelectAttraitType());
		//On récupère la requête.
		$request = $this->get('request');
		// On vérifie que c'est une requête de type ajax
		/*if($request->isXmlHttpRequest())
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			var_dump($form->getData());
			//On tri les attraits en fonction du choix pour l'affichage.
			//$result = $em->getRepository('MyAppGlobalBundle:Hebergements')->getSearchHebergement($word);
		}*/
		//Liste des hébergements à proximité pour les suggestions
		$listeSuggestion = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAllCustomerByRegionAndCategory(7, $region[0]->getId());
		$tablo = $tabSuggestion = [];
		if(count($listeSuggestion) > 4){
			shuffle($listeSuggestion);
			$tablo = array_rand($listeSuggestion, 4);
			foreach($tablo as $tw)
			{
				array_push($tabSuggestion, $listeSuggestion[$tw]);
			}
			$listeSuggestion = $tabSuggestion;
			unset($tabSuggestion);
			unset($tablo);
		}
		//Liste des villes pour la région qui sont de cette catégorie d'attraits
		$listeVille = $em->getRepository('MyAppGlobalBundle:Attraits')->getMemeRegionMemeCategoryGroupByVille($region[0]->getId(), $category[0]->getId());
		$saison = (new DefaultController)->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view listeActiviteRegion.html.twig
		return $this->render('MyAppGlobalBundle:Attraits_&_activites:listeActiviteRegion.html.twig',
				array(
						'insection' 					=> "inSection",
						'attraits' 						=> 'valid',
						'form'							=> $form->createView(),
						'listActivite'					=> $listActivite,
						'nbClient'						=> $nbClient[0]['resultList'],
						'views'							=> $regionWord,
						'region'						=> $region,
						'category'						=> $category,
						'nodeAttraitActiviteRegion'		=> true,
						'urlattraitsactivity'			=> true,
						'noeudArianeAttrait'			=> true,
						'formEngine'					=> $formEngine->createView(),
						'listeClient'					=> $listClient,
						'regionQcFooter'				=> $this->getListeFooterRegion($em)[0],
						'regionOnFooter'				=> $this->getListeFooterRegion($em)[1],
						'regionNbFooter'				=> $this->getListeFooterRegion($em)[2],
						'texte_accueilfr'				=> html_entity_decode($texte_accueil[0]['texte_accueil_attrait_fr']),
						'texte_accueilen'				=> html_entity_decode($texte_accueil_en[0]['texte_accueil_attrait_en']),
						'clientAleatoire'				=> $listActivite[$index],
						'regionOrthographe'				=> true,
						'suggestions'					=> $listeSuggestion,
						'provinceOrthographe'			=> true,
						'displaypage'					=> $displaypage,
						'page'							=> $page,
						'formRecherche'					=> $formRecherche->createView(),
						'googledfp1'					=> "GR_ATTRAIT_01",
						'googledfp2'					=> "GR_ATTRAIT_02",
                                                'googledfp3'                                    => "GR_ATTRAIT_03",
						'listeVille'					=> $listeVille,
						'saison'						=> $saison,
						'reservationRegionAjax' 		=> $reservationRegionAjax,
						'reservationVilleAjax'			=> $reservationVilleAjax,
						'reservationPays'				=> $reservationEnLignePays[0],
						'reservationProvince'			=> $reservationEnLignePays[1],
				));
	}
	
	/**
	 * Page qui affiche une liste de l'activité choisie dans la ville voulue
	 */
	public function attraitVilleActiviteAction($ville, $name, $page )
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		$numberPaginate = 10;
		$limit = 4;
		//Contrôle les arguments
		$controle = new ControleDataSecureController();
		$name = $controle->getCleanNameGeography($name, "name");
		$ville = $controle->getCleanNameGeography($ville, "name");
		//Gestionnaire des entités
		$em  = $this->getDoctrine()->getEntityManager();
		//Récupère l'id de la ville par le nom
		$idVille = $em->getRepository('MyAppGlobalBundle:Villes')->getInfosVille($ville);
		//Récupère l'id de la catégorie par le nom
		$category = $em->getRepository('MyAppGlobalBundle:Attraits_categories')->getRechercheIdCategorieParSonNom($name);
		//Compte le nombre de client 
		$nbClient = $em->getRepository('MyAppGlobalBundle:Attraits')->getCompteClientCategorieVille($idVille[0]->getId(), $category[0]->getId());
		//Contrôle la pagination
		$total = $nbClient[0]['resultList'];
		//Arrondit à l'entier supérieur
		$displaypage = ceil($total/$numberPaginate);
		$page = (new ControleDataSecureController)->getValideEntierPagination($page, $displaypage);
		//Liste tous les Utilisateur pour cette activité dans la ville
		$listActivite = $em->getRepository('MyAppGlobalBundle:Attraits')->getListeCategoriePourLaVilleRechercher($idVille[0]->getId(), $category[0]->getId(), $page, $numberPaginate);
		//On recherche un client aléatoire
		$tab = [];
		foreach($listActivite as $ts)
		{
			array_push($tab, $ts->getId());
		}
		if(count($listActivite) > 1)
		{
			$index = array_rand($tab, 1);
		}
		else 
		{
			$index = 0;
		}
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("attrait_en");
		//Moteur de recherche
		$listClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutocompletionPortail();		
		$retourEngine = $this->getRechercheMoteurDeRecherche();  
		if($retourEngine[0] == "form")
		{
                    $formEngine = $retourEngine[1];
		}
		if($retourEngine[0] == "request")
		{
                    //Retourne vers la fiche client
                    return $retourEngine[1];
		}
                elseif($retourEngine[0] == "multiple")
                {                       
                    //retourne vers la vue pour afficher tous les résultats de la recherche
                    return $this->getSimuleGoogleSearch($retourEngine);
                }	
		//Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/ville_'.strtolower($idVille[0]->getRepertoireFr()).'_attraits_activites_'.strtolower($category[0]->getRepertoireFr()).'.html', '/city_'.strtolower($idVille[0]->getRepertoireEn()).'_activities_attractions_'.strtolower($category[0]->getRepertoireEn()).'.html'));
		//Liste des hébergements à proximité pour les suggestions
		$listeSuggestion = $em->getRepository('MyAppGlobalBundle:Attraits')->getMemeRegionMemeCategoryRelationAvecHebergementAvecPagination($idVille[0]->getRegionId()->getId(), $category[0]->getId());
		$tablo = $tabresult = [];
		if(sizeof($listeSuggestion) > 4)
		{
			$tablo = array_rand($listeSuggestion, 4);
			foreach($tablo as $tw)
			{
				array_push($tabresult, $listeSuggestion[$tw]);
			}
			$listeSuggestion = $tabresult;
			unset($tablo);
			unset($tabresult);
		}
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view listeActiviteRegion.html.twig
		return $this->render('MyAppGlobalBundle:Attraits_&_activites:attraitActiviteVille.html.twig',
				array(
						'insection' 					=> "inSection",
						'attraits' 						=> 'valid',
						'form'							=> $form->createView(),
						'listActivite'					=> $listActivite,
						'nbClient'						=> $nbClient[0]['resultList'],
						'viewsfr'						=> $idVille[0]->getRegionId()->getNomFr(),
						'viewsen'						=> $idVille[0]->getRegionId()->getNomEn(),
						'category'						=> $category,
						'nodeAttraitActiviteVille'		=> true,
						'urlattraitsactivity'			=> true,
						'noeudArianeAttrait'			=> true,
						'formEngine'					=> $formEngine->createView(),
						'listeClient'					=> $listClient,
						'regionQcFooter'				=> $this->getListeFooterRegion($em)[0],
						'regionOnFooter'				=> $this->getListeFooterRegion($em)[1],
						'regionNbFooter'				=> $this->getListeFooterRegion($em)[2],
						'texte_accueilfr'				=> html_entity_decode($texte_accueil[0]['texte_accueil_attrait_fr']),
						'texte_accueilen'				=> html_entity_decode($texte_accueil_en[0]['texte_accueil_attrait_en']),
						'clientAleatoire'				=> $listActivite[$index],
						'regionOrthographe'				=> true,
						'suggestions'					=> $listeSuggestion,
						'displaypage'					=> $displaypage,
						'page'							=> $page,
						'googledfp1'					=> "GR_ATTRAIT_01",
						'googledfp2'					=> "GR_ATTRAIT_02",
                                                'googledfp3'                                    => "GR_ATTRAIT_03",
						'saison'						=> $saison,
						'reservationRegionAjax' 		=> $reservationRegionAjax,
						'reservationVilleAjax'			=> $reservationVilleAjax,
						'reservationPays'				=> $reservationEnLignePays[0],
						'reservationProvince'			=> $reservationEnLignePays[1],
				));
	}              
	
}