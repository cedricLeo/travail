<?php
namespace MyApp\GlobalBundle\Controller;
use MyApp\AdminBundle\Forms\SearchMoteurEnginePortailType;
use MyApp\GlobalBundle\Entity\Hebergements;
use MyApp\GlobalBundle\Entity\Attraits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\GlobalBundle\Form\GoogleForm;
use MyApp\GlobalBundle\Entity\Formu_province_region;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use Berriart\Bundle\SitemapBundle\Entity\ImageUrl;
use MyApp\GlobalBundle\Controller\DefaultController;
use MyApp\GlobalBundle\Entity\Utilisateur;
use MyApp\AdminBundle\Controller\AttraitController;

/**
 * 
 * @author leonardc
 * 
 * Classe pour la section restaurant coté client
 */
class RestaurantController extends Controller
{
	
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
	public function getRechercheMoteurDeRecherche()
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
	
	/**
	 * Page index pour la section restaurants coté client
	 * 
	 * Méthode qui affiche les provinces avec leurs régions qui ont des restaurants
	 */
	public function indexAction()
	{	
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Gestionnaires des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilRestaurant();	
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilRestauranten();
		//Affiche les régions 
		$regionqc = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRegionsPourAttraitRestaurant(9); //Régions QC
		$regionon = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRegionsPourAttraitRestaurant(8); //Régions ON 
		$regionnb = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRegionsPourAttraitRestaurant(5); //Régions NB
		//On filtre le tableau pour enlevé les valeurs null
		$tablo = [$regionqc, $regionon, $regionnb];
		$tablo = array_values(array_filter($tablo));	
		//Si on a pas de type de soin disponible on redirige vers une autre page
		if($tablo == null){
			return $this->redirect($this->generateUrl("_demandesansitem", array("section" => "restaurant")));
		}
		$tablo2 = [];
		//On récupère les id des clients qui sont disponibles pour nous aider à afficher les catégories de cuisines
		foreach($tablo as $ts){
			foreach($ts as $tx){
				array_push($tablo2, $tx->getId());
			}
		}
		//Affiche la liste des catégories de restaurants
		$restoFR = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffichecategorieCuisineFRParProvince($tablo2); // FR
		$restoEN = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffichecategorieCuisineENParProvince($tablo2); // EN
                //Récupère un restaurant aléatoire  
                $tab = array_rand($tablo, 1);              
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//Autocompletion
		$hebergement = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAutocompletionHebergementPortail();
		$attrait = $em->getRepository('MyAppGlobalBundle:Attraits')->getAutocompletionAttraitPortail();
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/restaurants.html'));
                //Titre pour le lien Québec en saison
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view restaurant.html.twig
		return $this->render('MyAppGlobalBundle:Restaurant:restaurant.html.twig', 
				array( 
                                        'regionqc'	 			=> $regionqc, 
                                        'regionon' 				=> $regionon, 
                                        'regionnb' 				=> $regionnb, 
                                        'insection' 				=> "inSection", 
                                        'restaurant' 				=> 'valid', 
                                        'listrestoFR'                           => $restoFR,
                                        'listrestoEN'				=> $restoEN,
                                        'form' 					=> $form->createView(),
                                        'urlrestaurant' 			=> "true",
                                        'texte_accueilfr'			=> html_entity_decode($texte_accueil[0]['texte_accueil_restaurant_fr']),
                                        'texte_accueilen'			=> html_entity_decode($texte_accueil_en[0]['texte_accueil_restaurant_en']),    
                                        'clientAleatoire'                       => $tablo[$tab][0],
                                        'autocompletionH'                       => $hebergement,
                                        'autocompletionA'			=> $attrait,
                                        'regionQcFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                        'regionOnFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                        'regionNbFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                        'formEngine'				=> $formEngine->createView(),
                                        'listeClient'				=> $listClient,
                                        'googledfp1'                            => "GR_RESTAURANT_01",
                                        'googledfp2'                            => "GR_RESTAURANT_02",
                                        'googledfp3'                            => "GR_RESTAURANT_03",
                                        'saison'				=> $saison,
                                        'reservationRegionAjax'                 => $reservationRegionAjax,
                                        'reservationVilleAjax'                  => $reservationVilleAjax,
                                        'reservationPays'			=> $reservationEnLignePays[0],
                                        'reservationProvince'                   => $reservationEnLignePays[1],
                                        'metarestofr'                           => $texte_accueil[0],
                                        'metarestoen'                           => $texte_accueil_en[0],
                                        'main'                                  => true,
				));
	}
	
	public function displayProvinceNationaliteAction($nationalite, $name)
	{	
            $reservationRegionAjax = $reservationVilleAjax = "";
            //On valide les arguments de l'url
            $validateur = new ControleDataSecureController();
            $name = $validateur->getCleanNameGeography($name, 'province');
            $nationalite = $validateur->getCleanNameGeography($nationalite, 'name');
            //Gestionnaire des entités
	    $em = $this->getDoctrine()->getEntityManager();
	    //On récupère l'id de la province
	    $idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);
	    //On récupère l'id de la cuisine
	    $idCuisine = $em->getRepository('MyAppGlobalBundle:Cuisines')->getSearchIdByNameSpecialite($nationalite);
	    //On affiche la province
	    $province = $em->getRepository('MyAppGlobalBundle:Attraits')->getListeSpecialiteParProvince( $idCuisine[0]->getId(), $idProvince[0]->getId());
	    //On affiche les régions de la province
	    $region = $em->getRepository('MyAppGlobalBundle:Attraits')->getListeSpecialiteParRegion( $idCuisine[0]->getId(), $idProvince[0]->getId());
	    //Si on plus que 4 résultats pour les suggestions
	    if(sizeof($region) > 4)
	    {
	    	shuffle($region);
	    	$suggestion = array_rand($region, 4);
	    	$listeSuggestion = [];
	    	foreach($suggestion as $tx)
	    	{
	    		array_push($listeSuggestion, $region[$tx]);
	    	}
	    }
	    else //Si on a moins de 4 résultats pour les suggestions
	    {
	    	$number = sizeof($region);
	    	$suggestion = array_rand($region, $number);
	    	$listeSuggestion = [];
	    	if($number > 1)//Si on a plus de 1 client
	    	{
		    	foreach($suggestion as $tx)
		    	{
		    		array_push($listeSuggestion, $region[$tx]);
		    	}
	    	}
	    	else
	    	{
	    		$listeSuggestion = $region ;
	    	}
	    }  
	    //On récupère un client aléatoire
	    $index = array_rand($region, 1);
	    //On récupère le texte d'accueil
	    $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("restaurant");
	    $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("restaurant_en");
	    //Formulaire de recherche map intéractive
	    $search = new Formu_province_region();
	    $form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
	    //Autocompletion
	    $hebergement = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAutocompletionHebergementPortail();
	    $attrait = $em->getRepository('MyAppGlobalBundle:Attraits')->getAutocompletionAttraitPortail();
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
            (new HebergementController)->generePersistSiteMap('/restaurants_', '/restaurants_', $idCuisine[0], $em);
            $saison = (new DefaultController)->getSaisonQuebec();
            //traitement formulaire reservation en ligne
            $controDefault = new DefaultController();
            $reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
            //Liste des régiond pour la réservation
            $fullListReservation = new DestinationController;
            $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
            //Liste des villes pour la réservation
            $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
            //Préparation de la view restaurantProvinceNationalite.html.twig
            return $this->render('MyAppGlobalBundle:Restaurant:restaurantProvinceNationalite.html.twig', 
                            array(
                                    'insection' 		=> "inSection",
                                    'restaurant' 		=> 'valid',
                                    'form' 			=> $form->createView(),
                                    'urlrestaurant'             => true,
                                    'province'			=> $province,
                                    'region'			=> $region,
                                    'regionOrthographe'         => true,
                                    'provinceOrthographe'       => true,
                                    'noeudAriane'		=> true,
                                    'views'			=> ucfirst($name),
                                    'viewsfr'			=> $region[$index]->getRegionId()->getNomFr(),
                                    'viewsen'			=> $region[$index]->getRegionId()->getNomEn(),
                                    'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_restaurant_fr']),
                                    'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_restaurant_en']),
                                    'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                    'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                    'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                    'formEngine'		=> $formEngine->createView(),
                                    'listeClient'		=> $listClient,
                                    'listeRestaurant'		=> $listeSuggestion,
                                    'clientAleatoire'		=> $region[$index],
                                    'googledfp1'		=> "GR_RESTAURANT_01",
                                    'googledfp2'		=> "GR_RESTAURANT_02",
                                    'googledfp3'		=> "GR_RESTAURANT_03",
                                    'nodeSpecProvince'		=> true,
                                    'saison'			=> $saison,
                                    'reservationRegionAjax'     => $reservationRegionAjax,
                                    'reservationVilleAjax'      => $reservationVilleAjax,
                                    'reservationPays'		=> $reservationEnLignePays[0],
                                    'reservationProvince'       => $reservationEnLignePays[1],
                            ));	
	}
	
	/**
	 * Affiche la liste des restaurants qui sont de cette catégorie et de la même ville
	 */
        public function listeSpecialiteRegionAction($name, $region)
	{	
		$reservationRegionAjax = $reservationVilleAjax = "";
		//On valide les arguments de l'url
		$validateur = new ControleDataSecureController();
		$name = $validateur->getCleanNameGeography($name, 'name');
		$region = $validateur->getCleanNameGeography($region, 'name');
                //Gestionnaire des entités
                $em = $this->getDoctrine()->getEntityManager();
                //On récupère l'id de catégorie de cuisine
                $idCuisine = $em->getRepository('MyAppGlobalBundle:Cuisines')->getSearchIdByNameSpecialite($name);
                //On récupère l'id de la région
                $idRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion($region);
                //On récupère la liste des restaurants de la région en fonction de leur cuisine_id
                $listeResto = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRestoPourLaRegionAvecCategorie($idRegion[0]->getId(), $idCuisine[0]->getId(), 11 );
                    //On récupère un client aléatoire
                $tab = [];
                foreach($listeResto as $ts)
                {
                    array_push($tab, $ts->getId());
                }
                shuffle($tab);
                $index = array_rand($tab, 1);
                //On récupère le texte d'accueil
                $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("restaurant");
                $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("restaurant_en");
                //Formulaire de recherche map intéractive
                $search = new Formu_province_region();
                $form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
                //Autocompletion
                $hebergement = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAutocompletionHebergementPortail();
                $attrait = $em->getRepository('MyAppGlobalBundle:Attraits')->getAutocompletionAttraitPortail();
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
                (new HebergementController)->generePersistSiteMap('/restaurants_', '/restaurants_', $idCuisine[0], $em);
		$saison = (new DefaultController)->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$controDefault = new DefaultController();
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view restaurantQuebecNationalite.html.twig
		return $this->render('MyAppGlobalBundle:Restaurant:restaurantListeNationaliteRegion.html.twig', 
				array(
                                        'insection' 			=> "inSection",
                                        'restaurant' 			=> 'valid', 
                                        'form' 				=> $form->createView(),
                                        'urlrestaurant' 		=> true,
                                        'regionOrthographe'             => true,
                                        'noeudAriane'			=> true,
                                        'views'				=> true,
                                        'viewsfr'			=> $listeResto[$index]->getRegionId()->getNomFr(),
                                        'viewsen'			=> $listeResto[$index]->getRegionId()->getNomEn(),
                                        'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_restaurant_fr']),
                                        'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_restaurant_en']),
                                        'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                        'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                        'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                        'formEngine'			=> $formEngine->createView(),
                                        'listeClient'			=> $listClient,
                                        'listeRestaurant'		=> $listeResto,
                                        'clientAleatoire'		=> $listeResto[$index],
                                        'googledfp1'			=> "GR_RESTAURANT_01",
                                        'googledfp2'			=> "GR_RESTAURANT_02",
                                        'googledfp3'			=> "GR_RESTAURANT_03",
                                        'restoSpecRegion'		=> true,
                                        'saison'			=> $saison,
                                        'reservationRegionAjax'         => $reservationRegionAjax,
                                        'reservationVilleAjax'          => $reservationVilleAjax,
                                        'reservationPays'		=> $reservationEnLignePays[0],
                                        'reservationProvince'           => $reservationEnLignePays[1],
				));
		
	}
	
	/**
	 * Méthode qui affiche la province choisie avec sa liste des régions contenants les types de cuisines
	 */
	public function displayprovinceAction( $name)
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Valide le nom de la province
		$validateur = new ControleDataSecureController();
		$name = $validateur->getCleanNameGeography($name, "province");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("restaurant");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("restaurant_en");
		//Récupère l'id de la province par le nom
		$idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);
		//Affiche la province sélectionnée
		$province = $em->getRepository('MyAppGlobalBundle:Attraits')->getSortProvinceCuisine($idProvince[0]->getId());
		//Affiche la liste des régions de cette province qui ont des restaurants (11 = restaurant)
		$region = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheTousRestaurantPourLaProvince($idProvince[0]->getId(), 11); 
		//On récupère la liste de tous les types de restaurants de la province
		$listeAllResto = $em->getRepository('MyAppGlobalBundle:Attraits')->getListeTousRestaurantPourLaProvince($idProvince[0]->getId(), 11);
		//On récupère un client aléatoire
		$index = array_rand($listeAllResto, 1);
		//On stocke dans un tableau les id région pour nos suggestions de restaurants
		$tab = array();
		foreach($listeAllResto as $tri)
		{
			array_push($tab, $tri->getId());
		}
		shuffle($tab);
		//Appelle la fonction pour les 4 id différents
		$listSuggestion = $validateur->getGenere4ClientsPourNosSuggestions($tab);
		//Affiche 4 restaurants dans nos suggestions.
		$list4Restos = $em->getRepository('MyAppGlobalBundle:Attraits')->getDisplay4restaurant($listSuggestion);
		//Affiche la liste des catégories de restaurants
		$typeCuisine = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheTousLesRestaurantPourLaProvince($idProvince[0]->getId(), 11);
		$tablo2 = [];
		//On récupère les id des clients qui sont disponibles pour nous aider à afficher les catégories de cuisines
		foreach($listeAllResto as $ts)
		{
			array_push($tablo2, $ts->getId());
		}
		$restoFR = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffichecategorieCuisineFRParProvince($tablo2); // FR
		$restoEN = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffichecategorieCuisineENParProvince($tablo2); // EN
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
                (new HebergementController)->generePersistSiteMap('/restaurants_province_', '/restaurants_province_', $idProvince[0], $em);
		//traitement formulaire reservation en ligne
		$controDefault = new DefaultController();
                $saison = $controDefault->getSaisonQuebec();
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view restaurantprovince.html.twig
		return $this->render('MyAppGlobalBundle:Restaurant:restaurantprovince.html.twig',
                        array(	'insection' 			=> "inSection",
                                'restaurant' 			=> 'valid', 
                                'views' 			=> ucfirst($name),
                                'province' 			=> $province,
                                'region'			=> $region,
                                'restoFR' 			=> $restoFR,
                                'restoEN'			=> $restoEN,
                                'form' 				=> $form->createView(),
                                'urlrestaurant' 		=> true,
                                'provinceOrthographe'           => true,
                                'noeudAriane'			=> true,
                                'listSuggestion'		=> $list4Restos,
                                'nodeRestoProvinceFr'           => $idProvince[0]->getNomFr(),	//province pour le fil d'ariane
                                'nodeRestoProvinceEn'           => $idProvince[0]->getNomEn(),
                                'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_restaurant_fr']),
                                'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_restaurant_en']),
                                'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                'formEngine'			=> $formEngine->createView(),
                                'listeClient'			=> $listClient,
                                'clientAleatoire'		=> $listeAllResto[$index],
                                'googledfp1'			=> "GR_RESTAURANT_01",
                                'googledfp2'			=> "GR_RESTAURANT_02",
                                'googledfp3'			=> "GR_RESTAURANT_03",
                                'restoProvince'			=> true,
                                'saison'			=> $saison,
                                'reservationRegionAjax'         => $reservationRegionAjax,
                                'reservationVilleAjax'          => $reservationVilleAjax,
                                'reservationPays'		=> $reservationEnLignePays[0],
                                'reservationProvince'           => $reservationEnLignePays[1],
                                'metahebergementenfant'         => $idProvince[0],
                        ));
	}
	
	/**
	 * Méthode qui affiche la province avec sa liste de région qui possède la spécialité culinaire choisie
	 */
	public function displayspecialiteAction($name)
	{		
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Valide le nom de la province
		$validateur = new ControleDataSecureController();
		$name = $validateur->getCleanNameGeography($name, "cuisine");
		//gestionnaire des entitiés
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("restaurant");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("restaurant_en");
		//Recherche l'id de la spécialité par son nom
		$idSpecialite = $em->getRepository('MyAppGlobalBundle:Cuisines')->getSearchIdByNameSpecialite($name);
		//Affiche les provinces qui ont cette spécialité
		$provinceqc = $em->getRepository('MyAppGlobalBundle:Attraits')->getListeSpecialiteParProvince($idSpecialite[0]->getId(), 9); // Province QC
		$provinceon = $em->getRepository('MyAppGlobalBundle:Attraits')->getListeSpecialiteParProvince($idSpecialite[0]->getId(), 8); // Province ON
		$provincenb = $em->getRepository('MyAppGlobalBundle:Attraits')->getListeSpecialiteParProvince($idSpecialite[0]->getId(), 5); // Province NB
		//Affiche les régions qui ont des restaurants spécialisés
		$regionqc = $em->getRepository('MyAppGlobalBundle:Attraits')->getListeSpecialiteParRegion($idSpecialite[0]->getId(), 9); // Régions QC
		$regionon = $em->getRepository('MyAppGlobalBundle:Attraits')->getListeSpecialiteParRegion($idSpecialite[0]->getId(), 8); // Régions ON
		$regionnb = $em->getRepository('MyAppGlobalBundle:Attraits')->getListeSpecialiteParRegion($idSpecialite[0]->getId(), 5); // Régions NB
		//On filtre le tableau pour enlevé les valeurs null
		$tablo = [$regionqc, $regionon, $regionnb];
		$tablo = array_values(array_filter($tablo));
		$index = array_rand($tablo, 1);
		//Récupère tous les clients de la région qui ont des restaurants
		$region = $em->getRepository('MyAppGlobalBundle:Attraits')->getListeRestoPourLaProvince(9, 11);
		//On stocke dans un tableau les id_région pour nos suggestions de restaurants
		$tab = array();
		foreach($region as $tri)
		{
			array_push($tab, $tri->getId());
		}
		shuffle($tab);
		//Appelle la fonction pour obtenir 4 id différents
		$listSuggestion = $validateur->getGenere4ClientsPourNosSuggestions($tab);
		//Affiche 4 restaurants dans nos suggestions de la région choisie
		$list4Restos = $em->getRepository('MyAppGlobalBundle:Attraits')->getDisplay4restaurant($listSuggestion);
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
                (new HebergementController)->generePersistSiteMap('/restaurants_specialite_', '/restaurants_specialite_', $idSpecialite[0], $em);
		//traitement formulaire reservation en ligne
		$controDefault = new DefaultController();
                $saison = $controDefault->getSaisonQuebec();
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view restaurantspecialite.html.twig
		return $this->render('MyAppGlobalBundle:Restaurant:restaurantspecialite.html.twig',
                    array(          'insection' 			=> "inSection",
                                    'restaurant' 			=> 'valid', 
                                    'views' 				=> ucfirst($name),
                                    'urlrestaurant'                     => true,
                                    'provinceQC'			=> $provinceqc,
                                    'provinceON'			=> $provinceon,
                                    'provinceNB'			=> $provincenb,
                                    'listeQC'				=> $regionqc,
                                    'listeON'				=> $regionon,
                                    'listeNB'				=> $regionnb,
                                    'resto' 				=> $list4Restos,
                                    'form' 				=> $form->createView(),
                                    'texte_accueilfr'                   => html_entity_decode($texte_accueil[0]['texte_accueil_restaurant_fr']),
                                    'texte_accueilen'                   => html_entity_decode($texte_accueil_en[0]['texte_accueil_restaurant_en']),
                                    'regionQcFooter'                    => (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                    'regionOnFooter'                    => (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                    'regionNbFooter'                    => (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                    'formEngine'			=> $formEngine->createView(),
                                    'listeClient'			=> $listClient,
                                    'clientAleatoire'                   => $tablo[$index][0],
                                    'noeudAriane'			=> true,
                                    'googledfp1'			=> "GR_RESTAURANT_01",
                                    'googledfp2'			=> "GR_RESTAURANT_02",
                                    'googledfp3'			=> "GR_RESTAURANT_03",
                                    'restoSpecialite'                   => true,
                                    'saison'				=> $saison,
                                    'reservationRegionAjax'             => $reservationRegionAjax,
                                    'reservationVilleAjax'              => $reservationVilleAjax,
                                    'reservationPays'                   => $reservationEnLignePays[0],
                                    'reservationProvince'               => $reservationEnLignePays[1],
				));
	}

	
	/**
	 * Méthode qui affiche la région sélectionnée avec les catégories de restaurants
	 */
	public function restaurantregionAction($name)
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		//On contrôle le nom de la région
		$validateur = new ControleDataSecureController();
		$name = $validateur->getCleanNameGeography($name, "region");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("restaurant");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("restaurant_en");
		//Récupère l'id de la région avec son nom
		$idRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getSearchRegion($name);
		//Récupère tous les clients de la région qui ont des restaurants
		$region = $em->getRepository('MyAppGlobalBundle:Attraits')->getAfficheRestoPourLaRegion($idRegion[0]->getId(), 11);
		//On recherche un client aléatoire
		$index = array_rand($region, 1);
		//On stocke dans un tableau les id_région pour nos suggestions de restaurants
		$tab = array();
		foreach($region as $tri)
		{
			array_push($tab, $tri->getId());
		}
		shuffle($tab);
		//Appelle la fonction pour obtenir 4 id différents
		$listSuggestion = $validateur->getGenere4ClientsPourNosSuggestions($tab);
		//Affiche 4 restaurants dans nos suggestions de la région choisie
		$list4Restos = $em->getRepository('MyAppGlobalBundle:Attraits')->getDisplay4restaurant($listSuggestion);
		//Affiche 3 autres restaurants sous nos suggestions
		$tab2 = array();
		for($i = 0; $i < 3; $i++)
		{
			$last = array_pop($tab);
			array_push($tab2, $last);
		}
		//Appelle la fonction pour obtenir 4 id différents
		$listSuggestion2 = $validateur->getGenere4ClientsPourNosSuggestions($tab2);
		//Affiche 3 restaurants en dessous de nos suggestions
		$list3Restos = $em->getRepository('MyAppGlobalBundle:Attraits')->getDisplay3restaurant($listSuggestion2);
		//Affiche la liste des catégories de cuisines
		$tablo = [];
		foreach($region as $ts)
		{
			array_push($tablo, $ts->getId());	
		}
		$restoFR = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffichecategorieCuisineFRParProvince($tablo); // FR
		$restoEN = $em->getRepository('MyAppGlobalBundle:Attraits')->getAffichecategorieCuisineENParProvince($tablo); // EN
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
                (new HebergementController)->generePersistSiteMap('/restaurants_region_', '/restaurants_region_', $idRegion[0], $em);
		//Affiche l'image pour le Québec en saison
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view restaurantRegion.html.twig
		return $this->render('MyAppGlobalBundle:Restaurant:restaurantRegion.html.twig',
				array(	'insection' 			=> "inSection",
                                        'restaurant' 			=> 'valid', 
                                        'views' 			=> ucfirst($name),
                                        'form' 				=> $form->createView(),
                                        'regionOrthographe'             => true,
                                        'urlrestaurant'			=> true,
                                        'noeudAriane'			=> true,
                                        'listRestoFR'			=> $restoFR,
                                        'listRestoEN'			=> $restoEN,
                                        'list4Restos'			=> $list4Restos,
                                        'list3Restos'			=> $list3Restos,
                                        'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_restaurant_fr']),
                                        'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_restaurant_en']),	
                                        'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                        'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                        'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                        'formEngine'			=> $formEngine->createView(),
                                        'listeClient'			=> $listClient,
                                        'clientAleatoire'		=> $region[$index],
                                        'googledfp1'			=> "GR_RESTAURANT_01",
                                        'googledfp2'			=> "GR_RESTAURANT_02",
                                        'googledfp3'			=> "GR_RESTAURANT_03",
                                        'restoRegion'			=> true,
                                        'saison'			=> $saison,
                                        'reservationRegionAjax'         => $reservationRegionAjax,
                                        'reservationVilleAjax'          => $reservationVilleAjax,
                                        'reservationPays'		=> $reservationEnLignePays[0],
                                        'reservationProvince'           => $reservationEnLignePays[1],
				));
	}
               
}