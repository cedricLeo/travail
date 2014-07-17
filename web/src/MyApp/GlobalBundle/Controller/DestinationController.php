<?php
namespace MyApp\GlobalBundle\Controller;
use MyApp\AdminBundle\Forms\SearchMoteurEnginePortailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyApp\GlobalBundle\Form\GoogleForm;
use MyApp\GlobalBundle\Entity\Formu_province_region;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use Berriart\Bundle\SitemapBundle\Entity\ImageUrl;
use MyApp\GlobalBundle\Controller\DefaultController;
use MyApp\GlobalBundle\Entity\Utilisateur;

/**
 * 
 * @author leonardc
 * 
 * Classe pour la section promotions coté portail
 */
class DestinationController extends Controller{
	
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
         * Liste toutes les régions pour la réservation en ligne
         */
        public function hydrateDropDownListRegionReservation($em)
        {
            $reservationRegionAjax = $em->getRepository("MyAppGlobalBundle:Regions")->getListAllRegion();
            return $reservationRegionAjax;
        }
        
        /**
         * Liste toutes les villes pour la réservation en ligne
         */
        public function hydrateDropDownListVilleReservation($em)
        {
            $reservationVilleAjax = $em->getRepository("MyAppGlobalBundle:Villes")->getListAllVille();
            return $reservationVilleAjax;
        }
	
	/**
	 * Page d'accueil pour la section « PROMOTIONS »
	 */
	public function indexAction($page)
	{	
		$reservationRegionAjax = $reservationVilleAjax = "";
		$numberPaginate = 10;			
		//Affiche les provinces
		$em = $this->getDoctrine()->getEntityManager();
		//tableau des avec les id des provinces pour les promotions
		$tabIdProvince = [9,8,5];
                //Retourne le nombre total de promotion en cours valide
                $totalPromotion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getComptabiliseNombrePromotion($tabIdProvince);
		//Si on n'a pas de promotion disponible on redirige vers une autre page
		if($totalPromotion["nbPromotion"] == 0){
			return $this->redirect($this->generateUrl("_demandesansitem", array("section" => "promotion")));
		}                   
                if($page <= 0 or $page == "page" or is_numeric($page) != true){
                    $page = 1;
                }                            
                //Liste les promotions avec la pagination
		$listeProvince = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getPaginationProvinceDerniereMinute($page, $numberPaginate, $tabIdProvince);
		shuffle($listeProvince);  
                if($totalPromotion["nbPromotion"] > 10 ){
                    $total = $totalPromotion["nbPromotion"];                
                }elseif($totalPromotion["nbPromotion"] <= 10){
                    $total = count($listeProvince);
                }   
                //Arrondit à l'entier supérieur
		$displaypage = ceil($total/$numberPaginate);    
                //On regarde les provinces qui ont des promotions
		$provinceqc = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheProvinceDerniereMinute(9);
		$provinceon = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheProvinceDerniereMinute(8);
		$provincenb = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheProvinceDerniereMinute(5);
                //Client aléatoire pour la grande image		
		$tab = [$provinceqc, $provinceon, $provincenb];
                $tab = array_values(array_filter($tab));
		if(sizeof($tab[0]) > 1){
			$index = array_rand($tab[0], 1);             
			$aleatoire = array($tab[0][$index]);
		}else{
			$aleatoire = $tab[0];
		}  
                //On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilPromotion();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilPromotionen();
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/tarifs_derniere_minute_et_promotions.html', '/last_minute_deals_and_promotions.html'));   
                //Titre lien Québec eb saisons
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Affiche une image principale aléatoire                            
                $tabActivite = [["id" => $aleatoire[0]->getForfaitClientId()->getId()]];
                $tabImages = (new ForfaitsController)->getEviteDoublonImageDestination($tabActivite);
                $imgIndex = rand(0, (count($tabImages)-1)); 
                $imgRandom = $tabImages[$imgIndex];   
                //Liste des régiond pour la réservation
                $reservationRegionAjax = $this->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $this->hydrateDropDownListVilleReservation($em);
                //Retourne la langue
                $lang = $this->container->get("session")->getLocale();
                if($lang == "fr"){
                    //Préparation de la view destination-fr.html.twig	
                    return $this->render('MyAppGlobalBundle:Destination:destination-fr.html.twig', 
				array(	
                                                'provinceqc' 				=> $provinceqc, 
                                                'provinceon' 				=> $provinceon, 
                                                'provincenb' 				=> $provincenb,
                                                'insection' 				=> "inSection", 
                                                'destination' 				=> 'valid',
                                                'form' 					=> $form->createView(),
                                                'texte_accueilfr'			=> html_entity_decode($texte_accueil[0]['texte_accueil_promotion_fr']),						
						'formEngine'				=> $formEngine->createView(),
						'listeClient'				=> $listClient,
						'regionQcFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'googledfp1'				=> "GR_MINUTE_01",
						'googledfp2'				=> "GR_MINUTE_02",
                                                'googledfp3'				=> "GR_MINUTE_03",
						'urldestination'			=> true,
						'clientAleatoire'			=> $aleatoire,
						'page'					=> $page,
						'displaypage'				=> $displaypage,
						'total'					=> $total,
						'listePromotion'			=> $listeProvince,
						'saison'				=> $saison,
						'reservationRegionAjax'                 => $reservationRegionAjax,
						'reservationVilleAjax'                  => $reservationVilleAjax,
						'reservationPays'			=> $reservationEnLignePays[0],
						'reservationProvince'                   => $reservationEnLignePays[1],
                                                'metapromofr'                           => $texte_accueil[0],
                                                'metapromoen'                           => $texte_accueil_en[0],
                                                'dateToday'                             => date('m/d/Y'),
                                                'main'                                  => true,
                                                'imgRandom'                             => $imgRandom,
                                                'idActivite'                            => $aleatoire[0]->getForfaitClientId()->getId(),
				));
                }else{
                    //Préparation de la view destination-en.html.twig	
                    return $this->render('MyAppGlobalBundle:Destination:destination-en.html.twig', 
				array(	
                                                'provinceqc' 				=> $provinceqc, 
                                                'provinceon' 				=> $provinceon, 
                                                'provincenb' 				=> $provincenb,
                                                'insection' 				=> "inSection", 
                                                'destination' 				=> 'valid',
                                                'form' 					=> $form->createView(),                                               
						'texte_accueilen'			=> html_entity_decode($texte_accueil_en[0]['texte_accueil_promotion_en']),
						'formEngine'				=> $formEngine->createView(),
						'listeClient'				=> $listClient,
						'regionQcFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'googledfp1'				=> "GR_MINUTE_01",
						'googledfp2'				=> "GR_MINUTE_02",
                                                'googledfp3'				=> "GR_MINUTE_03",
						'urldestination'			=> true,
						'clientAleatoire'			=> $aleatoire,
						'page'					=> $page,
						'displaypage'				=> $displaypage,
						'total'					=> $total,
						'listePromotion'			=> $listeProvince,
						'saison'				=> $saison,
						'reservationRegionAjax'                 => $reservationRegionAjax,
						'reservationVilleAjax'                  => $reservationVilleAjax,
						'reservationPays'			=> $reservationEnLignePays[0],
						'reservationProvince'                   => $reservationEnLignePays[1],
                                                'metapromofr'                           => $texte_accueil[0],
                                                'metapromoen'                           => $texte_accueil_en[0],
                                                'dateToday'                             => date('m/d/Y'),
                                                'main'                                  => true,
                                                'imgRandom'                             => $imgRandom,
                                                'idActivite'                            => $aleatoire[0]->getForfaitClientId()->getId(),
				));
                }
	}
        
        /**
         * Flux RSS générale
         */
        public function fluxRSSAction()
        {
            $em = $this->getDoctrine()->getEntityManager();
            $tabIdProvince = [9,8,5];
            $listeRss = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getFluxRssDestination($tabIdProvince);
            return $this->render('MyAppGlobalBundle:Destination:fluxRss.xml.twig',            
                array(
                        'rss' => $listeRss,                   
		));
        }
        
        /**
         * Flux RSS générale version anglaise temporaire pour le Québec en saison vieille version
         */
        public function fluxRSSEnglishAction()
        {
            $em = $this->getDoctrine()->getEntityManager();
            $tabIdProvince = [9,8,5];
            $listeRss = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getFluxRssDestination($tabIdProvince);
            return $this->render('MyAppGlobalBundle:Destination:fluxRssEnglishTemp.xml.twig',
                array(
                        'rss' => $listeRss,                   
		));
        }
        
	
	/**
	 * Affiche la province sélectionnée avec ses régions qui ont des promotions en cours
	 */
	public function provincePromotionAction($name, $page)
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		$numberPaginate = 10;
		//Valide le nom  de la province
		$validateur = new ControleDataSecureController();
		$name = $validateur->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère l'id de la province par son nom
		$idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);
		//Compte les promotions de cette province
		$countPromotionProvince = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getCompteProvinceDerniereMinute($idProvince[0]->getId());
		 //Si on n'a pas de promotion disponible on redirige vers une autre page
		if($countPromotionProvince[0]['numb'] == 0){
			return $this->redirect($this->generateUrl("_demandesansitem", array("section" => "promotion")));
		}
                if($page <= 0 or $page == "page" or is_numeric($page) != true){
                    $page = 1;
                }
		//Liste des promotiuons pour la pagination
		$listeProvince = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getPaginationProvinceDerniereMinute($page, $numberPaginate, $idProvince[0]->getId());	
		//Compte le nombre de résultat trouvé
                if($countPromotionProvince[0]['numb'] > 10 ){
                    $total = $countPromotionProvince[0]['numb'];                
                }elseif($countPromotionProvince[0]['numb'] <= 10){
                    $total = count($listeProvince);
                }    
                //Arrondit à l'entier supérieur
		$displaypage = ceil($total/$numberPaginate);                  
                //Recherche les promotitions de cette province
		$province = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheProvinceDerniereMinute($idProvince[0]->getId());
		//Client aléatoire pour la grande image
		if($countPromotionProvince[0]['numb'] > 1){
			$index = array_rand($province, 1);
			$aleatoire = $province[$index];
		}else{
			$aleatoire = $province[0];
		}
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilPromotion();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilPromotionen();
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
                (new HebergementController)->generePersistSiteMap2('/tarifs_derniere_minute_et_promotions_province_', '/last_minute_deals_and_promotions_province_', $idProvince[0], $em);
		//Titre du Québec en saison
                $controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);   
                //Affiche une image principale aléatoire                   
                $tabActivite = [["id" => $aleatoire->getForfaitClientId()->getId()]];                
                $tabImages = (new ForfaitsController)->getEviteDoublonImageDestination($tabActivite);
                $imgIndex = rand(0, (count($tabImages)-1)); 
                $imgRandom = $tabImages[$imgIndex];
                //Liste des régiond pour la réservation
                $reservationRegionAjax = $this->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $this->hydrateDropDownListVilleReservation($em);
		//Préparation de la view destinationProvinces.html.twig
		return $this->render('MyAppGlobalBundle:Destination:destinationProvinces.html.twig',
				array(  
                                        'insection'         		=> "inSection",
                                        'destination'       		=> 'valid',
                                        'form'              		=> $form->createView(),
                                        'province'         		=> $province,
                                        'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_promotion_fr']),
                                        'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_promotion_en']),
                                        'formEngine'			=> $formEngine->createView(),
                                        'listeClient'			=> $listClient,
                                        'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                        'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                        'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                        'googledfp1'			=> "GR_MINUTE_01",
                                        'googledfp2'			=> "GR_MINUTE_02",
                                        'googledfp3'			=> "GR_MINUTE_03",
                                        'urldestination'		=> true,
                                        'clientAleatoire'		=> $aleatoire,
                                        'destinationprovince'		=> true,
                                        'page'				=> $page,
                                        'displaypage'			=> $displaypage,
                                        'total'				=> $total,
                                        'listePromotion'		=> $listeProvince,
                                        'saison'			=> $saison,
                                        'reservationRegionAjax' 	=> $reservationRegionAjax,
                                        'reservationVilleAjax'		=> $reservationVilleAjax,
                                        'reservationPays'		=> $reservationEnLignePays[0],
                                        'reservationProvince'		=> $reservationEnLignePays[1],                
                                        'metapromofr'                   => $texte_accueil[0],
                                        'metapromoen'                   => $texte_accueil_en[0],
                                        'dateToday'                     => date('m/d/Y'),
                                        'imgRandom'                     => $imgRandom,
                                        'idActivite'                    => $tabActivite[0]['id'],
				));
	}
	
	/**
	 * Affiche la région sélectionnée avec ses villes qui ont des promotions en cours
	 */
	public function regionPromotionAction( $name, $page)
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		$numberPaginate = 10;
		//Valide le nom  de la région
		$name = (new ControleDataSecureController)->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère l'id de la province par son nom
		$idRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion($name);
		//Compte les promotions de cette région
		$countPromotionRegion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getCompteRegionDerniereMinute($idRegion[0]->getId());
                //Si on n'a pas de promotion disponible on redirige vers une autre page
		if($countPromotionRegion[0]['numb'] == 0){
			return $this->redirect($this->generateUrl("_demandesansitem", array("section" => "promotion")));
		}
                if($page <= 0 or $page == "page" or is_numeric($page) != true){
                    $page = 1;
                }
		//Recherche les promotions de cette région
		$region = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheRegionDerniereMinute($page, $numberPaginate, $idRegion[0]->getId());		
                //Compte le nombre de résultat trouvé
                if($countPromotionRegion[0]['numb'] > 10 ){
                    $total = $countPromotionRegion[0]['numb'];                
                }elseif($countPromotionRegion[0]['numb'] <= 10){
                    $total = count($region);
                }   
                //Arrondit à l'entier supérieur
		$displaypage = ceil($total/$numberPaginate);                  
                //Client aléatoire pour la grande image
		if(sizeof($region) > 1){
			$index = array_rand($region, 1);
			$aleatoire = $region[$index];
		}else{
			$aleatoire = $region[0];
		}
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilPromotion();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilPromotionen();
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
                (new HebergementController)->generePersistSiteMap2('/tarifs_derniere_minute_et_promotions_region_', '/last_minute_deals_and_promotions_region_', $idRegion[0], $em);
		//Titre du Québec en saisons
                $controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Affiche une image principale aléatoire  
                $tabActivite = [["id" => $aleatoire->getForfaitClientId()->getId()]];
                $tabImages = (new ForfaitsController)->getEviteDoublonImageDestination($tabActivite);
                $imgIndex = rand(0, (count($tabImages)-1)); 
                $imgRandom = $tabImages[$imgIndex];
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view destinationRegion.html.twig
		return $this->render('MyAppGlobalBundle:Destination:destinationRegion.html.twig', 
				array(	
					  	'insection'                             => "inSection",
						'destination'                           => 'valid',
						'form'                                  => $form->createView(),
						'texte_accueilfr'			=> html_entity_decode($texte_accueil[0]['texte_accueil_promotion_fr']),
						'texte_accueilen'			=> html_entity_decode($texte_accueil_en[0]['texte_accueil_promotion_en']),
						'formEngine'				=> $formEngine->createView(),
						'listeClient'				=> $listClient,
						'regionQcFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'googledfp1'				=> "GR_MINUTE_01",
						'googledfp2'				=> "GR_MINUTE_02",
                                                'googledfp3'				=> "GR_MINUTE_03",
						'urldestination'			=> true,
						'clientAleatoire'			=> $aleatoire,
						'destinationregion'			=> true,
						'listePromotion'			=> $region,
						'page'					=> $page,
						'displaypage'				=> $displaypage,
						'total'					=> $total,
						'saison'				=> $saison,
						'reservationRegionAjax'                 => $reservationRegionAjax,
						'reservationVilleAjax'                  => $reservationVilleAjax,
						'reservationPays'			=> $reservationEnLignePays[0],
						'reservationProvince'                   => $reservationEnLignePays[1],
                                                'metapromofr'                           => $texte_accueil[0],
                                                'metapromoen'                           => $texte_accueil_en[0],
                                                'dateToday'                             => date('m/d/Y'),
                                                'imgRandom'                             => $imgRandom,
                                                'idActivite'                            => $tabActivite[0]['id'],
				));
	}        
	
	
}