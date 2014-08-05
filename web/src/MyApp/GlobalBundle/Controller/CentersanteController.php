<?php
namespace MyApp\GlobalBundle\Controller;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use MyApp\AdminBundle\Forms\SearchMoteurEnginePortailType;
use MyApp\GlobalBundle\Entity\Hebergements;
use MyApp\GlobalBundle\Entity\Typessoinssante;
use MyApp\GlobalBundle\MyAppGlobalBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyApp\GlobalBundle\Form\GoogleForm;
use MyApp\GlobalBundle\Entity\Formu_province_region;
use MyApp\GlobalBundle\Entity\Textes_accueil;
use MyApp\GlobalBundle\Controller\SearchPortailController;
use MyApp\GlobalBundle\Controller\DefaultController;
use MyApp\GlobalBundle\Entity\Utilisateur;

/**
 * Classe pour la section centre de santé et spas coté portail
 * @author leonardc
 *
 */
class CentersanteController extends Controller {
	
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
		$formEngine = $this->createForm(new SearchMoteurEnginePortailType(), $client);
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
				return $this->redirect($this->generateUrl('homepage'), 404);
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
	
	/**
	 * Page index pour la section centres de santé et spas coté client.
	 */
	public function indexAction()
	{	
		$clientAleatoire = $reservationRegionAjax = $reservationVilleAjax = $suggestion2 = $suggestion3 = $suggestion4 = "";
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilSante();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilSanteen();
		//Affiche les provinces et les régions
		$regionqc = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheCategorieTypeSoinParRegion(9);
		$regionon = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheCategorieTypeSoinParRegion(8);
		$regionnb = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheCategorieTypeSoinParRegion(5);	
		//Recherche un client aléatoire
		$tab = [$regionqc, $regionon, $regionnb];
		$tab = array_values(array_filter($tab));
		//Si on a pas de type de soin disponible on redirige vers une autre page
		if($tab == null){
			return $this->redirect($this->generateUrl("_demandesansitem", array("section" => "sante")));
		}
		if($tab != null){
			$tabAleatoire = [];
			shuffle($tab);
			foreach($tab as $ts)
			{
				foreach($ts as $tx)
				{
					array_push($tabAleatoire, $tx->getId());
				}
			}
			shuffle($tabAleatoire);
			$index = array_rand($tabAleatoire, 1);
			if($index != null){
				if(count($tab) > 1){
					$clientAleatoire = $tab[0][$index];
				}else{
					$clientAleatoire = $tab[0][0];
				}
			}
		}
		//Affiche tous les types de soins disponibles
		//$listeTypeSoin = $em->getRepository('MyAppGlobalBundle:Soins_sante')->getAfficheAttraitTousTypeSoin();		
		$listeTypeSoin = $em->getRepository('MyAppGlobalBundle:Soins_sante')->getAfficheTypeSoinTabClient($tabAleatoire);		
		//Récupère la liste des id des régions qui ont des centres de santé
		$listCentreSante = $em->getRepository('MyAppGlobalBundle:Attraits')->getCompteIdRegionPourCentreSante();
		$tabloRegion = array();
		//On stocke les id des regions dans un tableau que l'on brasse
		foreach($listCentreSante as $tri)
		{
			array_push($tabloRegion, $tri->getRegionId()->getId());
		}
		shuffle($tabloRegion);
		//On retourne 4 id de region
		$controleNumber = new ControleDataSecureController();
		$idRegion = $controleNumber->getGenere4ClientsPourNosSuggestions($tabloRegion);
		shuffle($idRegion);
		$idRegion = array_unique($idRegion);
		//Retourne 4 régions pour nos suggestions
		$regionSuggestion = $em->getRepository('MyAppGlobalBundle:Regions')->get4RegionsSuggestion($idRegion);
		//Retourne 4 listes de clients pour nos suggestions
		$suggestion1 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[0]);
		if(count($idRegion) == 2){
			$suggestion2 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[1]);
		}if(count($idRegion) == 3){
			$suggestion3 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[2]);
		}if(count($idRegion) == 4){
			$suggestion4 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[3]);
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/centres_sante_spas.html', '/health_centers_spas.html'));
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
		//Préparation de la view centersante.html.twig		
		return $this->render('MyAppGlobalBundle:Centre_sante_&_spas:centersante.html.twig', 
				array(	
						'regionqc'			=> $regionqc,
						'regionon'			=> $regionon,
						'regionnb'			=> $regionnb,
					  	'insection' 			=> "inSection", 
                                                'centre' 			=> 'valid', 
					  	'form' 				=> $form->createView(),
					  	'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_sante_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_sante_en']),
						'listeTypeSoin'			=> $listeTypeSoin,
						'urlcentersante'		=> true,
						'suggestion1'			=> $suggestion1,
						'suggestion2'			=> $suggestion2,
						'suggestion3'			=> $suggestion3,
						'suggestion4'			=> $suggestion4,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $clientAleatoire,
						'googledfp1'			=> "GR_SANTE_01",
						'googledfp2'			=> "GR_SANTE_02",
                                                'googledfp3'			=> "GR_SANTE_03",
						'saison'                        => $saison,
						'reservationRegionAjax'         => $reservationRegionAjax,
						'reservationVilleAjax'          => $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'           => $reservationEnLignePays[1],
                                                'metasantefr'                   => $texte_accueil[0],
                                                'metasanteen'                   => $texte_accueil_en[0],
                                                'main'                          => true,
				));
	}
	
	/**
	 * Page pour afficher la région choisi pour les centres de santé et spas
	 */
	public function listerAction( $name)
	{		
		$clientAleatoire = $reservationRegionAjax = $reservationVilleAjax = $suggestion2 = $suggestion3 = $suggestion4 = "";
		//Valide le nom de la région
		$validateur = new ControleDataSecureController();
		$name = $validateur->getCleanNameGeography($name, "region");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Recherche l'id de la province par le nom
		$idRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion($name);
		//Recherche les villes de cette région qui ont des soins à offrir
		$ville = $em->getRepository('MyAppGlobalBundle:Attraits')->getSortVilleAttrait($idRegion[0]->getid());	
		$tabVille = [];
		foreach($ville as $tx)
		{
			array_push($tabVille, $tx->getId());
		}
		//Affiche tous les types de soins disponibles
		$listeTypeSoin = $em->getRepository('MyAppGlobalBundle:Soins_sante')->getAfficheTousTypeSoin();
		//Récupère la liste des id des régions qui ont des centres de santé
		$listCentreSante = $em->getRepository('MyAppGlobalBundle:Attraits')->getCompteIdRegionPourCentreSante();
		//Liste des soins de la région
		$listeSoin = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getListTypeSoinPourLaRegion($idRegion[0]->getId());
		//client aléatoire
		if($listeSoin != null){
			$tab = [];
			foreach($listeSoin as $tx)
			{
				array_push($tab, $tx->getId());
			}
			if(count($tab) > 1){
				$index = array_rand($tab, 1);
				$clientAleatoire = $listeSoin[$index];
			}else{
				$clientAleatoire = $listeSoin[0];
			}
		}
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante_en");
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
                (new HebergementController)->generePersistSiteMap2('/centres_sante_spas_region_', '/health_centers_spas_region_', $idRegion[0], $em);
		//Récupère la liste des id des régions qui ont des centres de santé
		$listCentreSante = $em->getRepository('MyAppGlobalBundle:Attraits')->getCompteIdRegionPourCentreSante();
		$tabloRegion = array();
		//On stocke les id des regions dans un tableau que l'on brasse
		foreach($listCentreSante as $tri)
		{
			array_push($tabloRegion, $tri->getRegionId()->getId());
		}
		shuffle($tabloRegion);
		//On retourne 4 id de region
		$controleNumber = new ControleDataSecureController();
		$idRegion = $controleNumber->getGenere4ClientsPourNosSuggestions($tabloRegion);
		shuffle($idRegion);
		$idRegion = array_unique($idRegion);
		//Retourne 4 régions pour nos suggestions
		$regionSuggestion = $em->getRepository('MyAppGlobalBundle:Regions')->get4RegionsSuggestion($idRegion);
		//Retourne 4 listes de clients pour nos suggestions
		$suggestion1 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[0]);
		if(count($idRegion) == 2){
			$suggestion2 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[1]);
		}if(count($idRegion) == 3){
			$suggestion3 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[2]);
		}if(count($idRegion) == 4){
			$suggestion4 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[3]);
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
		//Préparation de la views centersanteIndex.html.twig
		return $this->render('MyAppGlobalBundle:Centre_sante_&_spas:centersanteIndex.html.twig', 
				array(	
					  	'insection' 			=> "inSection", 
                                                'centre' 			=> 'valid', 
					  	'form' 				=> $form->createView(),
					  	'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_sante_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_sante_en']),
						'listeSoin'			=> $listeSoin,
						'urlcentersante'		=> true,
						'noeudsanteregion'		=> true,
						'suggestion1'			=> $suggestion1,
						'suggestion2'			=> $suggestion2,
						'suggestion3'			=> $suggestion3,
						'suggestion4'			=> $suggestion4,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $clientAleatoire,
						'ville'				=> $ville,
						'views'				=> $name,
						'regionOrthographe'		=> true,
						'googledfp1'			=> "GR_SANTE_01",
						'googledfp2'			=> "GR_SANTE_02",
                                                'googledfp3'			=> "GR_SANTE_03",
						'saison'			=> $saison,
						'reservationRegionAjax'         => $reservationRegionAjax,
						'reservationVilleAjax'          => $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'           => $reservationEnLignePays[1],
				));
	}
	
	/**
	 * Page pour afficher la ville sélectionnée pour la section centre de santé
	 */
	public function villesoinAction($name)
	{
		$reservationRegionAjax = $reservationVilleAjax = $suggestion2 = $suggestion3 = $suggestion4 = "";
		//Valide le nom de la région
		$validateur = new ControleDataSecureController();
		$name = $validateur->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Recherche l'id de la province par le nom
		$idVille = $em->getRepository('MyAppGlobalBundle:Villes')->getSearchTown($name);
		//Recherche les villes de cette région qui ont des soins à offrir
		$ville = $em->getRepository('MyAppGlobalBundle:Attraits')->getSortVilleAttrait($idVille[0]->getid());
		$tabVille = [];
		foreach($ville as $tx)
		{
			array_push($tabVille, $tx->getId());
		}
		//Affiche tous les types de soins disponibles
		$listeTypeSoin = $em->getRepository('MyAppGlobalBundle:Soins_sante')->getAfficheTousTypeSoin();
		//Récupère la liste des id des régions qui ont des centres de santé
		$listCentreSante = $em->getRepository('MyAppGlobalBundle:Attraits')->getCompteIdRegionPourCentreSante();
		//Liste des soins de la région
		$listeSoin = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getListTypeSoinPourLaVille($idVille[0]->getId());
		//client aléatoire
		$tab = [];
		foreach($listeSoin as $tx)
		{
			array_push($tab, $tx->getId());
		}
		if(count($tab) > 1){
			$index = array_rand($tab, 1);
			$clientAleatoire = $listeSoin[$index];
		}else{
			$clientAleatoire = $listeSoin[0];
		}
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante_en");
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
                (new HebergementController)->generePersistSiteMap2('/centres_sante_spas_ville_', '/health_centers_spas_city_', $idVille[0], $em);
		//Récupère la liste des id des régions qui ont des centres de santé
		$listCentreSante = $em->getRepository('MyAppGlobalBundle:Attraits')->getCompteIdRegionPourCentreSante();
		$tabloRegion = array();
		//On stocke les id des regions dans un tableau que l'on brasse
		foreach($listCentreSante as $tri)
		{
			array_push($tabloRegion, $tri->getRegionId()->getId());
		}
		shuffle($tabloRegion);
		//On retourne 4 id de region
		$controleNumber = new ControleDataSecureController();
		$idRegion = $controleNumber->getGenere4ClientsPourNosSuggestions($tabloRegion);
		shuffle($idRegion);
		$idRegion = array_unique($idRegion);
		//Retourne 4 régions pour nos suggestions
		$regionSuggestion = $em->getRepository('MyAppGlobalBundle:Regions')->get4RegionsSuggestion($idRegion);
		//Retourne 4 listes de clients pour nos suggestions
		$suggestion1 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[0]);
		if(count($idRegion) == 2){
			$suggestion2 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[1]);
		}if(count($idRegion) == 3){
			$suggestion3 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[2]);
		}if(count($idRegion) == 4){
			$suggestion4 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[3]);
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
		//Préparation de la views centersanteIndex.html.twig
		return $this->render('MyAppGlobalBundle:Centre_sante_&_spas:centresanteVille.html.twig',
				array(
						'insection' 			=> "inSection",
						'centre' 				=> 'valid',
						'form' 					=> $form->createView(),
						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_sante_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_sante_en']),
						'listeSoin'				=> $listeSoin,
						'urlcentersante'		=> true,
						'noeudsanteville'		=> true,
						'suggestion1'			=> $suggestion1,
						'suggestion2'			=> $suggestion2,
						'suggestion3'			=> $suggestion3,
						'suggestion4'			=> $suggestion4,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $clientAleatoire,
						'ville'					=> $ville,
						'views'					=> $name,
						'regionOrthographe'		=> true,
						'googledfp1'			=> "GR_SANTE_01",
						'googledfp2'			=> "GR_SANTE_02",
                                                'googledfp3'			=> "GR_SANTE_03",
						'saison'				=> $saison,
						'reservationRegionAjax' => $reservationRegionAjax,
						'reservationVilleAjax'	=> $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'	=> $reservationEnLignePays[1],
				));
	}
	

	/**
	 * Affiche toutes les provinces et leurs régions qui ont le type de soin choisi
	 */
	public function detailsoinAction($name)
	{
		$reservationRegionAjax = $reservationVilleAjax = $regionSuggestion = $suggestion2 = $suggestion3 = $suggestion4 = "";
		//On valide l'argument de l'url
		$name = (new ControleDataSecureController)->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On recherche l'id du type de soin par son nom
		$idTypeSoin = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getSearchIdByName($name); 
		//Affiche les provinces et les régions
		$regionqc = $em->getRepository('MyAppGlobalBundle:Attraits')->getTypeSoinRechercheParProvince(9, $idTypeSoin[0]->getId());
		$regionon = $em->getRepository('MyAppGlobalBundle:Attraits')->getTypeSoinRechercheParProvince(8, $idTypeSoin[0]->getId());
		$regionnb = $em->getRepository('MyAppGlobalBundle:Attraits')->getTypeSoinRechercheParProvince(5, $idTypeSoin[0]->getId());
		//Recherche par carte
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
                (new HebergementController)->generePersistSiteMap2('/centres_sante_spas_soin_', '/health_centers_spas_care_', $idTypeSoin[0], $em);
		//On récupère le texte d'accueil 
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante_en");
		//liste des clients qui offrent le soin recherché
		$soinRechercher = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getRechercheTypeSoinPourPartout($idTypeSoin);
		//Recherche un client aléatoire
		if(sizeof($soinRechercher) > 1){
			shuffle($soinRechercher);
			$index = array_rand($soinRechercher, 1);
			$clientAleatoire = $soinRechercher[$index];
		}else{
			$clientAleatoire = $soinRechercher[0];
		}
		$resultat = self::nosSuggestionsPousUnTypeDeSoinRechercher($soinRechercher, $idTypeSoin[0]->getId(), $em);
		if($resultat != null)
		{
			$regionSuggestion = $resultat[0];
			$suggestion1 = $resultat[1];
			isset($resultat[2])? $suggestion2 = $resultat[2]: $suggestion2;
			isset($resultat[3])? $suggestion3 = $resultat[3]: $suggestion3;
			isset($resultat[4])? $suggestion4 = $resultat[4]: $suggestion4;
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
		//Préparation de la view soinsIndex.html.twig
		return $this->render('MyAppGlobalBundle:Centre_sante_&_spas:soinsIndex.html.twig', 
				array( 
					    'views' 				=> $name, 
					    'insection' 			=> "inSection", 
					    'centre' 				=> 'valid', 
						'metatypesoin'			=> true,
					  	'form' 					=> $form->createView(),
					  	'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_sante_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_sante_en']),
						'regionSuggestion'		=> $regionSuggestion,
						'urlcentersante'		=> true,
						'regionqc'				=> $regionqc,
						'regionon'				=> $regionon,
						'regionnb'				=> $regionnb,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $clientAleatoire,
						'googledfp1'			=> "GR_SANTE_01",
						'googledfp2'			=> "GR_SANTE_02",
                                                'googledfp3'			=> "GR_SANTE_03",
						'suggestion1'			=> $suggestion1,
						'suggestion2'			=> $suggestion2,
						'suggestion3'			=> $suggestion3,
						'suggestion4'			=> $suggestion4,
						'saison'				=> $saison,
						'reservationRegionAjax' => $reservationRegionAjax,
						'reservationVilleAjax'	=> $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'	=> $reservationEnLignePays[1],
				));
	}	
	
	/**
	 * Affiche la province sélectionnée avec le type de soin recherché
	 */
	public function typedesoinprovinceAction($name, $province)
	{
		$reservationRegionAjax = $reservationVilleAjax = $regionSuggestion = $suggestion2 = $suggestion3 = $suggestion4 = "";
		//On valide l'argument de l'url
		$controller = new ControleDataSecureController();
		$name = $controller->getCleanNameGeography($name, "name");
		$province = $controller->getCleanNameGeography($province, "province");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On recherche l'id du type de soin par son nom
		$idTypeSoin = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getSearchIdByName($name); 
		//Recherche l'id de la province par son nom
		$idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($province);
		//Affiche la province avec ses régions
		$region = $em->getRepository('MyAppGlobalBundle:Attraits')->getTypeSoinRechercheParProvince($idProvince[0]->getId(), $idTypeSoin[0]->getId());
		//Recherche par carte
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/soin_'.strtolower($idTypeSoin[0]->getRepertoireFr()).'_province_'.strtolower($idProvince[0]->getRepertoireFr()).'.html', '/care_'.strtolower($idTypeSoin[0]->getRepertoireEn()).'_province_'.strtolower($idProvince[0]->getRepertoireEn()).'.html'));    
		//On récupère le texte d'accueil 
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante_en");
		//liste des clients qui offrent le soin recherché
		$soinRechercher = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getRechercheTypeSoinPourPartout($idTypeSoin);
		//Recherche un client aléatoire
		if(sizeof($soinRechercher) > 1){
			shuffle($soinRechercher);
			$index = array_rand($soinRechercher, 1);
			$clientAleatoire = $soinRechercher[$index];
		}else{
			$clientAleatoire = $soinRechercher[0];
		}
		$resultat = self::nosSuggestionsPousUnTypeDeSoinRechercher($soinRechercher, $idTypeSoin[0]->getId(), $em);
		if($resultat != null)
		{
			$regionSuggestion = $resultat[0];
			$suggestion1 = $resultat[1];
			isset($resultat[2])? $suggestion2 = $resultat[2]: $suggestion2;
			isset($resultat[3])? $suggestion3 = $resultat[3]: $suggestion3;
			isset($resultat[4])? $suggestion4 = $resultat[4]: $suggestion4;
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
		return $this->render('MyAppGlobalBundle:Centre_sante_&_spas:centresanteProvinceTypeSoin.html.twig',
			array( 
					    'views' 				=> $name, 
					    'insection' 			=> "inSection", 
					    'centre'    			=> 'valid', 
						'centresoinprovince'            => true,
					  	'form' 					=> $form->createView(),
					  	'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_sante_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_sante_en']),
						'regionSuggestion'		=> $regionSuggestion,
						'urlcentersante'		=> true,
						'region'				=> $region,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $clientAleatoire,
						'googledfp1'			=> "GR_SANTE_01",
						'googledfp2'			=> "GR_SANTE_02",
                                                'googledfp3'			=> "GR_SANTE_03",
						'suggestion1'			=> $suggestion1,
						'suggestion2'			=> $suggestion2,
						'suggestion3'			=> $suggestion3,
						'suggestion4'			=> $suggestion4,
						'saison'				=> $saison,
						'reservationRegionAjax'         => $reservationRegionAjax,
						'reservationVilleAjax'          => $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'           => $reservationEnLignePays[1],
				));
	}
	
	/**
	 * Affiche la région sélectionnée avec le type de soin recherché
	 */
	public function typedesoinregionAction($name, $region, $page)
	{
		$reservationRegionAjax = $reservationVilleAjax = $regionSuggestion = $suggestion2 = $suggestion3 = $suggestion4 = "";
		$numberPaginate = 10;
		//On valide l'argument de l'url
		$controller = new ControleDataSecureController();
		$name = $controller->getCleanNameGeography($name, "name");
		$region = $controller->getCleanNameGeography($region, "region");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On recherche l'id du type de soin par son nom
		$idTypeSoin = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getSearchIdByName($name); 
		//Recherche l'id de la région par son nom
		$idRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion($region);
		//Liste des client qui répondent aux critères de recherche
		$listeResultat = $em->getRepository('MyAppGlobalBundle:Attraits')->getTypeSoinRechercheParRegion($idRegion[0]->getId(), $idTypeSoin[0]->getId(), null, null);
		//Compte les clients
		$total = count($listeResultat[0]);
		//Arrondit à l'entier supérieur
		$displaypage = ceil($total/$numberPaginate);
		//Valide que la variable page est correcte.
		$page = (new ControleDataSecureController)->getValideEntierPagination($page, $displaypage);
		//Affiche la province avec ses régions
		$region = $em->getRepository('MyAppGlobalBundle:Attraits')->getTypeSoinRechercheParRegion($idRegion[0]->getId(), $idTypeSoin[0]->getId(), $page, $numberPaginate);
		//Recherche par carte
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/soin_'.strtolower($idTypeSoin[0]->getRepertoireFr()).'_region_'.strtolower($idRegion[0]->getRepertoireFr()).'.html', '/care_'.strtolower($idTypeSoin[0]->getRepertoireEn()).'_region_'.strtolower($idRegion[0]->getRepertoireEn()).'.html'));
		//On récupère le texte d'accueil 
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante_en");
		//liste des clients qui offrent le soin recherché
		$soinRechercher = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getRechercheTypeSoinPourPartout($idTypeSoin);
		//Recherche un client aléatoire
		if(sizeof($soinRechercher) > 1){
			shuffle($soinRechercher);
			$index = array_rand($soinRechercher, 1);
			$clientAleatoire = $soinRechercher[$index];
		}else{
			$clientAleatoire = $soinRechercher[0];
		}
		$resultat = self::nosSuggestionsPousUnTypeDeSoinRechercher($soinRechercher, $idTypeSoin[0]->getId(), $em);
		if($resultat != null)
		{
			$regionSuggestion = $resultat[0];
			$suggestion1 = $resultat[1];
			isset($resultat[2])? $suggestion2 = $resultat[2]: $suggestion2;
			isset($resultat[3])? $suggestion3 = $resultat[3]: $suggestion3;
			isset($resultat[4])? $suggestion4 = $resultat[4]: $suggestion4;
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
		return $this->render('MyAppGlobalBundle:Centre_sante_&_spas:centresanteRegionTypeSoin.html.twig',
				array(
						'views' 				=> $name,
						'insection' 			=> "inSection",
						'centre'    			=> 'valid',
						'centresoinregion'		=> true,
						'form' 					=> $form->createView(),
						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_sante_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_sante_en']),
						'regionSuggestion'		=> $regionSuggestion,
						'urlcentersante'		=> true,
						'region'				=> $region,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $clientAleatoire,
						'googledfp1'			=> "GR_SANTE_01",
						'googledfp2'			=> "GR_SANTE_02",
                                                'googledfp3'			=> "GR_SANTE_03",
						'suggestion1'			=> $suggestion1,
						'suggestion2'			=> $suggestion2,
						'suggestion3'			=> $suggestion3,
						'suggestion4'			=> $suggestion4,
						'listeResultat'			=> $listeResultat,
						'page'					=> $page,
						'displaypage'			=> $displaypage,
						'total'					=> $total,
						'saison'				=> $saison,
						'reservationRegionAjax'         => $reservationRegionAjax,
						'reservationVilleAjax'          => $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'           => $reservationEnLignePays[1],
				));
	}
	
	/**
	 * Affiche la ville sélectionnée avec le type de soin recherché
	 */
	public function typedesoinvilleAction($name, $ville, $page)
	{
		$reservationRegionAjax = $reservationVilleAjax = $regionSuggestion = $suggestion2 = $suggestion3 = $suggestion4 = "";
		$numberPaginate = 10;
		//On valide l'argument de l'url
		$controller = new ControleDataSecureController();
		$name = $controller->getCleanNameGeography($name, "name");
		$ville = $controller->getCleanNameGeography($ville, "name");        
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On recherche l'id du type de soin par son nom
		$idTypeSoin = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getSearchIdByName($name); 
		//Recherche l'id de la ville par son nom
		$idVille = $em->getRepository('MyAppGlobalBundle:Villes')->getSearchTown($ville);
		//Liste des client qui répondent aux critères de recherche
		$listeResultat = $em->getRepository('MyAppGlobalBundle:Attraits')->getTypeSoinRechercheParVille($idVille[0]->getId(), $idTypeSoin[0]->getId(), null, null);
		//Compte les clients
		$total = count($listeResultat[0]);
		//Arrondit à l'entier supérieur
		$displaypage = ceil($total/$numberPaginate);
		//Valide que la variable page est correcte.
		$page = (new ControleDataSecureController)->getValideEntierPagination($page, $displaypage);
		//Affiche la province avec ses régions
		$listeVille = $em->getRepository('MyAppGlobalBundle:Attraits')->getTypeSoinRechercheParVille($idVille[0]->getId(), $idTypeSoin[0]->getId(), $page, $numberPaginate);
		//Recherche par carte
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/soin_'.strtolower($idTypeSoin[0]->getRepertoireFr()).'_ville_'.strtolower($idVille[0]->getRepertoireFr()).'.html', '/care_'.strtolower($idTypeSoin[0]->getRepertoireEn()).'_city_'.strtolower($idVille[0]->getRepertoireEn()).'.html'));         
		//On récupère le texte d'accueil 
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante_en");
		//liste des clients qui offrent le soin recherché
		$soinRechercher = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getRechercheTypeSoinPourPartout($idTypeSoin);
		//Recherche un client aléatoire
		if(sizeof($soinRechercher) > 1){
			shuffle($soinRechercher);
			$index = array_rand($soinRechercher, 1);
			$clientAleatoire = $soinRechercher[$index];
		}else{
			$clientAleatoire = $soinRechercher[0];
		}
		$resultat = self::nosSuggestionsPousUnTypeDeSoinRechercher($soinRechercher, $idTypeSoin[0]->getId(), $em);
		if($resultat != null)
		{
			$regionSuggestion = $resultat[0];
			$suggestion1 = $resultat[1];
			isset($resultat[2])? $suggestion2 = $resultat[2]: $suggestion2;
			isset($resultat[3])? $suggestion3 = $resultat[3]: $suggestion3;
			isset($resultat[4])? $suggestion4 = $resultat[4]: $suggestion4;
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
		return $this->render('MyAppGlobalBundle:Centre_sante_&_spas:centresanteVilleTypeSoin.html.twig',
				array(
						'views' 				=> $name,
						'insection' 			=> "inSection",
						'centre'    			=> 'valid',
						'centresoinville'		=> true,
						'form' 					=> $form->createView(),
						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_sante_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_sante_en']),
						'regionSuggestion'		=> $regionSuggestion,
						'urlcentersante'		=> true,
						'listeVille'			=> $listeVille,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $clientAleatoire,
						'googledfp1'			=> "GR_SANTE_01",
						'googledfp2'			=> "GR_SANTE_02",
                                                'googledfp3'			=> "GR_SANTE_03",
						'suggestion1'			=> $suggestion1,
						'suggestion2'			=> $suggestion2,
						'suggestion3'			=> $suggestion3,
						'suggestion4'			=> $suggestion4,
						'listeResultat'			=> $listeResultat,
						'page'					=> $page,
						'displaypage'			=> $displaypage,
						'total'					=> $total,
						'saison'				=> $saison,
						'reservationRegionAjax' => $reservationRegionAjax,
						'reservationVilleAjax'	=> $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'	=> $reservationEnLignePays[1],
				));
	}
	
	/**
	 * Affiche la province sélectionnée avec ses régions qui ont des soins.
	 */
	public function provincesoinAction($name)
	{	
		$reservationRegionAjax = $reservationVilleAjax = $suggestion2 = $suggestion3 = $suggestion4 = "";
		//On valide l'argument de l'url
		$name = (new ControleDataSecureController)->getCleanNameGeography($name, "province");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère l'id de la province par son nom 
		$idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);
		//Affiche les régions
		$region = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheCategorieTypeSoinParRegion(9);
		//Client aléatoire
		$tab = [];
		foreach($region as $tx)
		{
			array_push($tab, $tx->getId());
		}
		if(count($tab) > 1){
			$index = array_rand($tab, 1);
			$clientAleatoire = $region[$index];
		}else{
			$clientAleatoire = $region[0];
		}
		//Recherche par carte
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
                (new HebergementController)->generePersistSiteMap2('/centres_sante_spas_province_', '/health_centers_spas_province_', $idProvince[0], $em);
		//On récupère le texte d'accueil 
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("sante_en");
		//Récupère la liste des id des régions qui ont des centres de santé
		$listCentreSante = $em->getRepository('MyAppGlobalBundle:Attraits')->getCompteIdRegionPourCentreSante();
		//Liste des soins de la région
		$listeSoin = $em->getRepository('MyAppGlobalBundle:Types_soins_sante')->getListTypeSoinPourLaProvince($idProvince[0]->getId());
		//client aléatoire
		$tab = [];
		foreach($listeSoin as $tx)
		{
			array_push($tab, $tx->getId());
		}
		if(count($tab) > 1){
			$index = array_rand($tab, 1);
			$clientAleatoire = $listeSoin[$index];
		}else{
			$clientAleatoire = $listeSoin[0];
		}	
		//Nos suggestions
		$tabloRegion = array();
		//On stocke les id des regions dans un tableau que l'on brasse
		foreach($listCentreSante as $tri)
		{
			array_push($tabloRegion, $tri->getRegionId()->getId());
		}
		shuffle($tabloRegion);
		//On retourne 4 id de region
		$controleNumber = new ControleDataSecureController();
		$idRegion = $controleNumber->getGenere4ClientsPourNosSuggestions($tabloRegion);
		shuffle($idRegion);
		$idRegion = array_unique($idRegion);
		//Retourne 4 régions pour nos suggestions
		$regionSuggestion = $em->getRepository('MyAppGlobalBundle:Regions')->get4RegionsSuggestion($idRegion);
		//Retourne 4 listes de clients pour nos suggestions
		$suggestion1 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[0]);
		if(count($idRegion) == 2){
			$suggestion2 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[1]);
		}if(count($idRegion) == 3){
			$suggestion3 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[2]);
		}if(count($idRegion) == 4){
			$suggestion4 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionSante($idRegion[3]);
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
		//Préparation de la views centresanteProvinceChoisie.html.twig
		return $this->render('MyAppGlobalBundle:Centre_sante_&_spas:centresanteProvinceChoisie.html.twig',
				array(
					  	'views' 				=> $name, 
					    'insection' 			=> "inSection", 
					    'centre' 				=> 'valid', 
					  	'form' 					=> $form->createView(),
					  	'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_sante_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_sante_en']),
						'urlcentersante'		=> true,
						'noeudsanteprovince'	=> true,
						'province'				=> $idProvince[0],
						'region'				=> $region,
						'provinceOrthographe'	=> true,
						'suggestion1'			=> $suggestion1,
						'suggestion2'			=> $suggestion2,
						'suggestion3'			=> $suggestion3,
						'suggestion4'			=> $suggestion4,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $clientAleatoire,
						'listeSoin'				=> $listeSoin,
						'googledfp1'			=> "GR_SANTE_01",
						'googledfp2'			=> "GR_SANTE_02",
                                                'googledfp3'			=> "GR_SANTE_03",
						'saison'				=> $saison,
						'reservationRegionAjax' => $reservationRegionAjax,
						'reservationVilleAjax'	=> $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'	=> $reservationEnLignePays[1],
				));
	}
	
	/**
	 * Méthode pour rechercher les suggestions pour un type de soin que l'on recherche
	 */
	private function nosSuggestionsPousUnTypeDeSoinRechercher($soinRechercher, $idTypeSoin, $em)
	{
		$suggestion1 = $suggestion2 = $suggestion3 = $suggestion4 = "";
		$tabloRegion = array();
		//On stocke les id des regions dans un tableau que l'on brasse
		foreach($soinRechercher as $tri)
		{
			array_push($tabloRegion, $tri->getRegionId()->getId());
		}
		shuffle($tabloRegion);
		//On retourne 4 id de region
		$controleNumber = new ControleDataSecureController();
		$idRegion = $controleNumber->getGenere4ClientsPourNosSuggestions($tabloRegion);
		shuffle($idRegion);
		$idRegion = array_unique($idRegion);
		//Retourne 4 régions pour nos suggestions
		$regionSuggestion = $em->getRepository('MyAppGlobalBundle:Regions')->get4RegionsSuggestion($idRegion);
		//Retourne 4 listes de clients pour nos suggestions
		$suggestion1 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionTypeSoin($idRegion[0], $idTypeSoin);
		if(count($idRegion) == 2){
			$suggestion2 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionTypeSoin($idRegion[1], $idTypeSoin);
		}if(count($idRegion) == 3){
			$suggestion3 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionTypeSoin($idRegion[2], $idTypeSoin);
		}if(count($idRegion) == 4){
			$suggestion4 = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffiche5ClientSuggestionTypeSoin($idRegion[3], $idTypeSoin);
		}
		$resultat = [$regionSuggestion, $suggestion1, $suggestion2, $suggestion3, $suggestion4];
		$resultat = array_values(array_filter($resultat));
		return $resultat;
	}
        
}