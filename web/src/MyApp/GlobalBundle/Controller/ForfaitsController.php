<?php
namespace MyApp\GlobalBundle\Controller;
use MyApp\AdminBundle\Forms\SearchMoteurEnginePortailType;
use Symfony\Component\HttpFoundation\Session;
use MyApp\GlobalBundle\Entity\Devises;
use MyApp\GlobalBundle\Entity\Texte_region_forfait;
use MyApp\GlobalBundle\Form\DeviseForm;
use MyApp\GlobalBundle\Entity\Formu_province_region;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyApp\GlobalBundle\Form\GoogleForm;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use Berriart\Bundle\SitemapBundle\Entity\ImageUrl;
use MyApp\GlobalBundle\Controller\DefaultController;
use MyApp\GlobalBundle\Entity\Utilisateur;
/**
 * 
 * @author leonardc
 * 
 * Controller pour les forfaits coté portail
 */
class ForfaitsController extends Controller{
		
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
				$url->setChangeFreq(Url::CHANGEFREQ_MONTHLY);
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
			$url->setChangeFreq(Url::CHANGEFREQ_MONTHLY);
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
	
	
	/**
	 * Page d'accueil pour la section forfait coté portail
	 */
	public function indexAction()
	{	
            $reservationRegionAjax = $reservationVilleAjax = $listeSuggestion = $liste1Suggestion = $liste2Suggestion = $liste3Suggestion = $regionSuggestion1 = $regionSuggestion2 = $regionSuggestion3 = "";
            //Gestionnaire d'entité
            $em = $this->getDoctrine()->getEntityManager();
            //Affiche les provinces et leurs régions qui ont forfaits            
            $tableauIdProvince = [9,8,5];            
            $region = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitRegion2($tableauIdProvince);
            //Valide si on a des forfaits disponibles sinon on affiche la page aucun résultats trouvé
            $tab = $region;
            $tab = array_filter(array_values($region));
            //Si on a pas de type de forfait disponible on redirige vers une autre page
            if($tab == null){
                    return $this->redirect($this->generateUrl("_demandesansitem", array("section" => "forfait")));
            }
            //Liste tous les forfaits groupées
	    $listforfaitGroupBy = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValideGroupBy();
	    //Liste tous les forfaits 
	    $listforfait = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValide();
	    //On récupère un client aléatoire
	    $index = array_rand($listforfait, 1);
	    //On récupère le texte d'accueil
	    $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilForfait();	
	    $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilForfaiten();
	    //Formulaire de recherche Google API
	    $search = new Formu_province_region(); 
	    $form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
            //Génère les liste de suggestions
            if(count($listforfait) > 3){
                    $retourSuggestion = $this->genereSuggestionForfaits($listforfait, $em);
                    if(isset($retourSuggestion[0])){
                            if(isset($retourSuggestion[0][0]))
                                    $regionSuggestion1 = $retourSuggestion[0][0];
                            if(isset($retourSuggestion[0][1]))
                                    $regionSuggestion2 = $retourSuggestion[0][1];
                            if(isset($retourSuggestion[0][2]))
                                    $regionSuggestion3 = $retourSuggestion[0][2];
                    }
                    if(isset($retourSuggestion[1])){
                            if(isset($retourSuggestion[1][0]))
                                    $liste1Suggestion = $retourSuggestion[1][0];
                            if(isset($retourSuggestion[1][1]))
                                    $liste2Suggestion = $retourSuggestion[1][1];
                            if(isset($retourSuggestion[1][2]))
                                    $liste3Suggestion = $retourSuggestion[1][2];
                    }
            }else{
                    $listeSuggestion = $listforfait;
            }
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
            (new HebergementController)->getValideUrlSiteMap($em, array('/forfaits.html', '/packages.html'));
            //affiche image du Québec en saison
            $controDefault = new DefaultController();
            $saison = $controDefault->getSaisonQuebec();
            //traitement formulaire reservation en ligne
            $reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
            //retourne le chemin pour aller chercher les images de la catégorie pour les 4 colonnes de suggestions
            $idActivite = [["id" => $listforfait[$index]->getForfaitClientId()->getId()]];
            $tabImages = $this->eviteDoublonImage($idActivite);               
            $imgIndex = rand(0, (count($tabImages)-1)); 
            $imgRandom = $tabImages[$imgIndex];
            //Liste des régiond pour la réservation
            $fullListReservation = new DestinationController;
            $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
            //Liste des villes pour la réservation
            $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
            //retourne la langue
            $lang = $this->container->get("session")->getLocale();
            if($lang == "fr"){
                //Préparation de la view forfaits-fr.html.twig
                return $this->render('MyAppGlobalBundle:Forfaits:forfaits-fr.html.twig', 
                        array(	
                                'regionqc' 		=> $region[0], 
                                'regionon' 		=> $region[1], 
                                'regionnb' 		=> $region[2], 
                                'insection' 		=> "inSection", 
                                'forfaits' 		=> 'valid', 
                                'listforfait' 		=> $listforfait, 
                                'listforfaitGroupBy' 	=> $listforfaitGroupBy,
                                'form' 			=> $form->createView(),
                                'texte_accueilfr'	=> html_entity_decode($texte_accueil[0]['texte_accueil_forfait_fr']),
                                'regionQcFooter'	=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                'regionOnFooter'	=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                'regionNbFooter'	=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                'urlforfaits'		=> true,
                                'formEngine'		=> $formEngine->createView(),
                                'listeClient'		=> $listClient,
                                'clientAleatoire'	=> $listforfait[$index],
                                'regionSuggestion1'	=> $regionSuggestion1,	//Titre de régions pour les suggestions de forfaits colonne de gauche
                                'regionSuggestion2'	=> $regionSuggestion2,
                                'regionSuggestion3'	=> $regionSuggestion3,
                                'listeClient1'		=> $liste1Suggestion, 	// liste des clients suggestions de forfaits colonne de gauche
                                'listeClient2'		=> $liste2Suggestion,
                                'listeClient3'		=> $liste3Suggestion,
                                'googledfp1'		=> "GR_FORFAIT_01",
                                'googledfp2'		=> "GR_FORFAIT_02",
                                'googledfp3'		=> "GR_FORFAIT_03",
                                'listeSuggestion'	=> $listeSuggestion,
                                'saison'		=> $saison,
                                'reservationRegionAjax' => $reservationRegionAjax,
                                'reservationVilleAjax'  => $reservationVilleAjax,
                                'reservationPays'	=> $reservationEnLignePays[0],
                                'reservationProvince'   => $reservationEnLignePays[1],
                                'metaforfaitfr'         => $texte_accueil[0],
                                'metaforfaiten'         => $texte_accueil_en[0],
                                'main'                  => true,
                                'imgRandom'             => $imgRandom,
                                'idActivite'            => $idActivite[0]["id"],
                        ));
            }else{
                //Préparation de la view forfaits-en.html.twig
                return $this->render('MyAppGlobalBundle:Forfaits:forfaits-en.html.twig', 
                        array(	
                                'regionqc' 		=> $region[0], 
                                'regionon' 		=> $region[1], 
                                'regionnb' 		=> $region[2], 
                                'insection' 		=> "inSection", 
                                'forfaits' 		=> 'valid', 
                                'listforfait' 		=> $listforfait, 
                                'listforfaitGroupBy' 	=> $listforfaitGroupBy,
                                'form' 			=> $form->createView(),              
                                'texte_accueilen'	=> html_entity_decode($texte_accueil_en[0]['texte_accueil_forfait_en']),
                                'regionQcFooter'	=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                'regionOnFooter'	=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                'regionNbFooter'	=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                'urlforfaits'		=> true,
                                'formEngine'		=> $formEngine->createView(),
                                'listeClient'		=> $listClient,
                                'clientAleatoire'	=> $listforfait[$index],
                                'regionSuggestion1'	=> $regionSuggestion1,	//Titre de régions pour les suggestions de forfaits colonne de gauche
                                'regionSuggestion2'	=> $regionSuggestion2,
                                'regionSuggestion3'	=> $regionSuggestion3,
                                'listeClient1'		=> $liste1Suggestion, 	// liste des clients suggestions de forfaits colonne de gauche
                                'listeClient2'		=> $liste2Suggestion,
                                'listeClient3'		=> $liste3Suggestion,
                                'googledfp1'		=> "GR_FORFAIT_01",
                                'googledfp2'		=> "GR_FORFAIT_02",
                                'googledfp3'		=> "GR_FORFAIT_03",
                                'listeSuggestion'	=> $listeSuggestion,
                                'saison'		=> $saison,
                                'reservationRegionAjax' => $reservationRegionAjax,
                                'reservationVilleAjax'  => $reservationVilleAjax,
                                'reservationPays'	=> $reservationEnLignePays[0],
                                'reservationProvince'   => $reservationEnLignePays[1],
                                'metaforfaitfr'         => $texte_accueil[0],
                                'metaforfaiten'         => $texte_accueil_en[0],
                                'main'                  => true,
                                'imgRandom'             => $imgRandom,
                                'idActivite'            => $idActivite[0]["id"],
                        ));
            }
	}
	
	/**
	 * Affiche la province sélectionnée avec ses régions qui ont des forfaits disponibles
	 */
	public function provinceforfaitAction($name)
	{	
		$reservationRegionAjax = $reservationVilleAjax = $listeSuggestion = $liste1Suggestion = $liste2Suggestion = $liste3Suggestion = $regionSuggestion1 = $regionSuggestion2 = $regionSuggestion3 = "";
		//Valide le nom de la province en paramètre
		$name = (new ControleDataSecureController)->getCleanNameGeography($name, "province");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On recherche les forfaits pour la province
		$province = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);
		//Affiche les régions de la province
		$region = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitRegion($province[0]->getId());
                //Liste tous les forfaits groupées
	        $listforfaitGroupBy = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValideGroupBy();
		//Liste tous les forfaits
		$listforfait = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValide();
		//On récupère un client aléatoire
		$index = array_rand($listforfait, 1);
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilForfait();	
                $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilForfaiten();
		//Génère les liste de suggestions
		$retourSuggestion = $this->genereSuggestionForfaits($listforfait, $em);
		if(isset($retourSuggestion[0])){
			if(isset($retourSuggestion[0][0]))
				$regionSuggestion1 = $retourSuggestion[0][0];
			if(isset($retourSuggestion[0][1]))
				$regionSuggestion2 = $retourSuggestion[0][1];
			if(isset($retourSuggestion[0][2]))
				$regionSuggestion3 = $retourSuggestion[0][2];
		}
		if(isset($retourSuggestion[1])){
			if(isset($retourSuggestion[1][0]))
				$liste1Suggestion = $retourSuggestion[1][0];
			if(isset($retourSuggestion[1][1]))
				$liste2Suggestion = $retourSuggestion[1][1];
			if(isset($retourSuggestion[1][2]))
				$liste3Suggestion = $retourSuggestion[1][2];
		}else{
			$listeSuggestion = $listforfait;
		}
                //Formulaire de recherche Google API
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
                (new HebergementController)->generePersistSiteMap2('/forfaits_province_', '/packages_province_', $province[0], $em);
                //
                $controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //retourne le chemin pour aller chercher les images de la catégorie pour les 4 colonnes de suggestions
                $idActivite = [["id" => $listforfait[$index]->getForfaitClientId()->getId()]];
                $tabImages = $this->eviteDoublonImage($idActivite);               
                $imgIndex = rand(0, (count($tabImages)-1)); 
                $imgRandom = $tabImages[$imgIndex];
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
                //Préparation de la view forfaitsProvince.html.twig
		return $this->render('MyAppGlobalBundle:Forfaits:forfaitsProvince.html.twig', 
				array(	
					  	'insection' 			=> "inSection", 
					  	'forfaits' 			=> 'valid', 
					  	'province' 			=> $province,
					  	'region' 			=> $region, 
					  	'form' 				=> $form->createView(),
						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_forfait_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_forfait_en']),
						'listforfait' 			=> $listforfait,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'urlforfaits'			=> true,
						'menuForfait'			=> "forfait",
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $listforfait[$index],
						'regionSuggestion1'		=> $regionSuggestion1,				//Titre de régions pour les suggestions de forfaits colonne de gauche
						'regionSuggestion2'		=> $regionSuggestion2,
						'regionSuggestion3'		=> $regionSuggestion3,
						'listeClient1'			=> $liste1Suggestion, 				// liste des clients suggestions de forfaits colonne de gauche
						'listeClient2'			=> $liste2Suggestion,
						'listeClient3'			=> $liste3Suggestion,
						'googledfp1'			=> "GR_FORFAIT_01",
						'googledfp2'			=> "GR_FORFAIT_02",
                                                'googledfp3'			=> "GR_FORFAIT_03",
						'titleProvince'			=> true,
						'listeSuggestion'		=> $listeSuggestion,
						'saison'                        => $saison,
                                                'titleProvince'                 => true,
						'reservationRegionAjax'         => $reservationRegionAjax,
						'reservationVilleAjax'          => $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'           => $reservationEnLignePays[1],
                                                'metaforfait'                   => $province[0],
                                                'listforfaitGroupBy'            => $listforfaitGroupBy,
                                                'imgRandom'                     => $imgRandom,
                                                'idActivite'                    => $idActivite[0]["id"],
				));
	}
                
	
	/**
	 * Affiche les régions qui ont des forfaits de disponibles
	 */
	public function regionforfaitAction($name)
	{
		$reservationRegionAjax = $reservationVilleAjax = $listeSuggestion = $liste1Suggestion = $liste2Suggestion = $liste3Suggestion = $regionSuggestion1 = $regionSuggestion2 = $regionSuggestion3 = "";
		//Valide le nom de la province en paramètre
		$name = (new ControleDataSecureController)->getCleanNameGeography($name, "region");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On recherche les forfaits pour la région
		$region = $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion($name);
		//Affiche les villes de la région
		$ville = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getTousLesForfaitsDesVillesDeLaRegion($region[0]->getId());		
                //Liste tous les forfaits disponibles
		$listforfait = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValideRegion($region[0]->GetId());
		//Récupère un client aléatoire
		$index = array_rand($listforfait, 1);
		//Génère les liste de suggestions
		$retourSuggestion = $this->genereSuggestionForfaits($listforfait, $em);
		if(isset($retourSuggestion[0])){
			if(isset($retourSuggestion[0][0]))
				$regionSuggestion1 = $retourSuggestion[0][0];
			if(isset($retourSuggestion[0][1]))
				$regionSuggestion2 = $retourSuggestion[0][1];
			if(isset($retourSuggestion[0][2]))
				$regionSuggestion3 = $retourSuggestion[0][2];
		}
		if(isset($retourSuggestion[1])){
			if(isset($retourSuggestion[1][0]))
				$liste1Suggestion = $retourSuggestion[1][0];
			if(isset($retourSuggestion[1][1]))
				$liste2Suggestion = $retourSuggestion[1][1];
			if(isset($retourSuggestion[1][2]))
				$liste3Suggestion = $retourSuggestion[1][2];
		}else{
			$listeSuggestion = $listforfait;
		}
                //Formulaire de recherche Google API
                $search = new Formu_province_region();
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
                (new HebergementController)->generePersistSiteMap2('/forfaits_region_', '/packages_region_', $region[0], $em);
                //
                $controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //retourne le chemin pour aller chercher les images de la catégorie pour les 4 colonnes de suggestions
                $idActivite = [["id" => $listforfait[$index]->getForfaitClientId()->getId()]];
                $tabImages = $this->eviteDoublonImage($idActivite);               
                $imgIndex = rand(0, (count($tabImages)-1)); 
                $imgRandom = $tabImages[$imgIndex];
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
                //Préparation de la view forfaitsProvince.html.twig
		return $this->render('MyAppGlobalBundle:Forfaits:forfaitsRegion.html.twig', 
				array(	
					  	'insection' 			=> "inSection", 
					  	'forfaits' 			=> 'valid', 
					  	'ville' 			=> $ville,
					  	'region' 			=> $region, 
					  	'form' 				=> $form->createView(),
						'texte_accueilfr'		=> html_entity_decode($region[0]->getTexteFr()),
						'texte_accueilen'		=> html_entity_decode($region[0]->getTexteEn()),
						'listforfait' 			=> $listforfait,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'urlforfaits'			=> true,
						'menuForfait'			=> "forfait",
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'regionOrthographe'		=> true,
						'viewsfr'			=> $region[0]->getNomFr(),
						'viewsen'			=> $region[0]->getNomEn(),
						'clientAleatoire'		=> $listforfait[$index],
						'regionSuggestion1'		=> $regionSuggestion1,				//Titre de régions pour les suggestions de forfaits colonne de gauche
						'regionSuggestion2'		=> $regionSuggestion2,
						'regionSuggestion3'		=> $regionSuggestion3,
						'listeClient1'			=> $liste1Suggestion, 				// liste des clients suggestions de forfaits colonne de gauche
						'listeClient2'			=> $liste2Suggestion,
						'listeClient3'			=> $liste3Suggestion,
						'googledfp1'			=> "GR_FORFAIT_01",
						'googledfp2'			=> "GR_FORFAIT_02",
                                                'googledfp3'			=> "GR_FORFAIT_03",
						'titleRegion'			=> true,
						'listeSuggestion'		=> $listeSuggestion,
						'saison'			=> $saison,
						'reservationRegionAjax'         => $reservationRegionAjax,
						'reservationVilleAjax'          => $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'           => $reservationEnLignePays[1],
                                                'metaforfait'                   => $region[0], 
                                                'imgRandom'                     => $imgRandom,
                                                'idActivite'                    => $idActivite[0]["id"],
				));
	}
	
	public function villeforfaitAction($name)
	{
		$reservationRegionAjax = $reservationVilleAjax = $listeSuggestion = $liste1Suggestion = $liste2Suggestion = $liste3Suggestion = $regionSuggestion1 = $regionSuggestion2 = $regionSuggestion3 = "";
		//Valide le nom de la province en paramètre
		$name = (new ControleDataSecureController)->getCleanNameGeography($name, "region");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Recherche la ville par son nom
		$idVille = $em->getRepository('MyAppGlobalBundle:Villes')->getSearchTown($name);
		//Liste tous les forfaits de la ville recherchée
		$listforfait = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValideVille($idVille[0]->getId());
		if(count($listforfait) > 1){
			//Affiche un client aléatoire dans la liste
			$index = array_rand($listforfait, 1);
			$clientAleatoire = $listforfait[$index];
		}else{
			$clientAleatoire = $listforfait[0];
		}
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("forfait");
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil("forfait_en");
                //Formulaire de recherche Google API
                $search = new Formu_province_region();
                $form = $this->container->get('form.factory')->create(new GoogleForm(), $search);  
                //Génère les liste de suggestions
                $retourSuggestion = $this->genereSuggestionForfaits($listforfait, $em);
                if(isset($retourSuggestion[0])){
                    if(isset($retourSuggestion[0][0]))
                            $regionSuggestion1 = $retourSuggestion[0][0];
                    if(isset($retourSuggestion[0][1]))
                            $regionSuggestion2 = $retourSuggestion[0][1];
                    if(isset($retourSuggestion[0][2]))
                            $regionSuggestion3 = $retourSuggestion[0][2];
                }
                if(isset($retourSuggestion[1])){
                    if(isset($retourSuggestion[1][0]))
                            $liste1Suggestion = $retourSuggestion[1][0];
                    if(isset($retourSuggestion[1][1]))
                            $liste2Suggestion = $retourSuggestion[1][1];
                    if(isset($retourSuggestion[1][2]))
                            $liste3Suggestion = $retourSuggestion[1][2];
                }else{
                            $listeSuggestion = $listforfait;
                    }
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
                (new HebergementController)->generePersistSiteMap2('/forfaits_ville_', '/packages_city_', $idVille[0], $em);
                $controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //retourne le chemin pour aller chercher les images de la catégorie pour les 4 colonnes de suggestions
                $idActivite = [["id" => $listforfait[$index]->getForfaitClientId()->getId()]];
                $tabImages = $this->eviteDoublonImage($idActivite);               
                $imgIndex = rand(0, (count($tabImages)-1)); 
                $imgRandom = $tabImages[$imgIndex];
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
                //Préparation de la view forfaitsProvince.html.twig
		return $this->render('MyAppGlobalBundle:Forfaits:forfaitsVilles.html.twig', 
				array(	
					  	'insection' 			=> "inSection", 
					  	'forfaits' 			=> 'valid',  
					  	'form' 				=> $form->createView(),
						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_forfait_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_forfait_en']),
						'listforfait' 			=> $listforfait,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'urlforfaits'			=> true,
						'menuForfait'			=> "forfait",
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $clientAleatoire,
						'regionSuggestion1'		=> $regionSuggestion1,				//Titre de régions pour les suggestions de forfaits colonne de gauche
						'regionSuggestion2'		=> $regionSuggestion2,
						'regionSuggestion3'		=> $regionSuggestion3,
						'listeClient1'			=> $liste1Suggestion, 				//Liste des clients suggestions de forfaits colonne de gauche
						'listeClient2'			=> $liste2Suggestion,
						'listeClient3'			=> $liste3Suggestion,
						'googledfp1'			=> "GR_FORFAIT_01",
						'googledfp2'			=> "GR_FORFAIT_02",
                                                'googledfp3'			=> "GR_FORFAIT_03",
						'titleVille'			=> true,
						'listeSuggestion'		=> $listeSuggestion,
						'saison'			=> $saison,
						'reservationRegionAjax'         => $reservationRegionAjax,
						'reservationVilleAjax'          => $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'           => $reservationEnLignePays[1],
                                                'metaforfait'                   => true,
                                                'imgRandom'                     => $imgRandom,
                                                'idActivite'                    => $idActivite[0]["id"],
				));
	}
	
	/**
	 * Affiche la liste détaillée des forfaits pour la ville
	 */
	public function displayActiviteVilleAction($activite, $name, $page)
	{	
		$reservationRegionAjax = $reservationVilleAjax = "";
		$numberPaginate = 10;	
		//Valide le nom de la province en paramètre
		$controller = new ControleDataSecureController();
		$name = $controller->getCleanNameGeography($name, "region");
		$activite = $controller->getCleanNameGeography($activite, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Recherche l'activité par son nom
		$idActivite = $em->getRepository('MyAppGlobalBundle:Forfaits')->getRechercheIdForfait($activite);
		//Recherche la ville par son nom
		$idVille = $em->getRepository('MyAppGlobalBundle:Villes')->getWordSearchTown($name);
		//Liste tous les forfaits de cette catégorie recherchée et qui sont de la ville recherchée aussi
		$listforfait = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getCompteFofaitCategorieDeLaVille($idVille[0]['id'], $idActivite[0]['id']);
		//Contrôle la pagination
		$total = $listforfait[0]['numb'] ;
		//Arrondit à l'entier supérieur
		$displaypage = ceil($total/$numberPaginate);
		//Valide que la variable page est valide.
		$page = $controller->getValideEntierPagination($page, $displaypage);
		//Liste tous les forfaits valides de la ville avec le type de forfait
		$listeTousForfait = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaVille($idVille[0]['id'], $idActivite[0]['id'], $page, $numberPaginate);
		//Si on a 4 ou plus, des régions
		if(sizeof($listeTousForfait) > 4 ){
			$tablo = $tabIndex = [];
			shuffle($listeTousForfait);
			$tabIndex = array_rand($listeTousForfait, 4);
			foreach($tabIndex as $tw){
				array_push($tablo, $listeTousForfait[$tw]);
			}
		}else{
			$tablo = [];
			shuffle($listeTousForfait);
			$tablo = $listeTousForfait;
		}
		//On recherche un client aléatoire
		if(count($listeTousForfait) > 1){
			$index = array_rand($listeTousForfait, 1);
			$clientAleatoire = $listeTousForfait[$index];
		}else{
			$clientAleatoire = $listeTousForfait[0];
		}
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilForfait();	
	        $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilForfaiten();
		//Formulaire de recherche Google API
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/forfaits_'.strtolower($idActivite[0]['repertoire_fr']).'_ville_'.$idVille[0]['repertoire_fr'].'.html', '/packages_'.strtolower($idActivite[0]['repertoire_en']).'_city_'.strtolower($idVille[0]['repertoire_en']).'.html')); 
                //Titre Québec en saisons
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
		//Liste des tarifs de dernière minute
		$tarifDerniereMinute = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheVilleForfaitsDerniereMinuteAvecCategorie($idActivite[0]['id'], $idVille[0]['id']);
		//retourne le chemin pour aller chercher les images de la catégorie pour les 4 colonnes de suggestions
                $tabImages = $this->eviteDoublonImage($idActivite);
                $imgIndex = rand(0, (count($tabImages)-1)); 
                $imgRandom = $tabImages[$imgIndex];
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
                //Préparation de la view forfaitsActivite.html.twig
		return $this->render('MyAppGlobalBundle:Forfaits:forfaitsActiviteVille.html.twig',
				array(
						'insection' 			=> "inSection",
						'forfaits' 			=> 'valid',
						'listeRegion' 			=> $tablo,
						'form' 				=> $form->createView(),
						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_forfait_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_forfait_en']),
						'listforfait' 			=> $listeTousForfait,
						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'urlforfaits'			=> true,
						'formEngine'			=> $formEngine->createView(),
						'listeClient'			=> $listClient,
						'clientAleatoire'		=> $clientAleatoire,
						'dateTodayPlusDeuxMois'         => date('m')+2,
						'jourToday'			=> date('d'),
						'menuForfait'			=> true,
						'activiteVille'			=> true,
						'googledfp1'			=> "GR_FORFAIT_01",
						'googledfp2'			=> "GR_FORFAIT_02",
                                                'googledfp3'			=> "GR_FORFAIT_03",
						'page'				=> $page,
						'displaypage'			=> $displaypage,
						'total'				=> $total,
						'tarifDerniereMinute'           => $tarifDerniereMinute,
						'saison'			=> $saison,
						'reservationRegionAjax'         => $reservationRegionAjax,
						'reservationVilleAjax'          => $reservationVilleAjax,
						'reservationPays'		=> $reservationEnLignePays[0],
						'reservationProvince'           => $reservationEnLignePays[1],
                                                'metaforfaitcategorieville'     => true,
                                                'imageColBas1'                  => $tabImages[0],
                                                'imageColBas2'                  => $tabImages[1],
                                                'imageColBas3'                  => $tabImages[2],
                                                'imageColBas4'                  => $tabImages[3],
                                                'style'                         => $idActivite[0]['id'],
                                                'imgRandom'                     => $imgRandom,
                                                'idActivite'                    => $idActivite[0]['id'],
				));
	}
	
	/**
	 * Affiche la liste détaillée des forfaits
	 */
	public function displayActiviteIndexAction($name)
	{
		$imgRandom = $reservationRegionAjax = $reservationVilleAjax = $regionSuggestion1 = $regionSuggestion2 = $regionSuggestion3 = $regionSuggestion4 = $liste1Suggestion  = $liste2Suggestion  = $liste3Suggestion  = $liste4Suggestion = "";
		//Valide le nom de la province en paramètre
		$name = (new ControleDataSecureController)->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Recherche l'activité par son nom                
		$idActivite = $em->getRepository('MyAppGlobalBundle:Forfaits')->getRechercheIdForfait($name);
		//Affiche les régions qui ont ce type de forfait
		$regionqc = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegionGroupByRegion(9, $idActivite[0]['id']);
		$regionon = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegionGroupByRegion(8, $idActivite[0]['id']);
		$regionnb = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegionGroupByRegion(5, $idActivite[0]['id']);
                //Liste tous les forfaits valides de cette catégorie 
		$listforfait = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieIndexGroupBy($idActivite[0]['id']);		
                //Si on a 4 ou plus, des régions
		if(sizeof($listforfait) >= 4)
		{
                        shuffle($listforfait);
			//On déclare un tableau pour stocker les id de région
			$tab = $tablo = [];
			foreach($listforfait as $ts)
			{
				array_push($tab, $ts->getHebergementId()->getRegionId()->GetId());	
				array_push($tablo, $ts);
			}
                        $tab = array_unique($tab);
			//On récupère aléatoirement 4 id de région
			$tabloIdRegion = array_rand($tab, 4);
                       // var_dump($tabloIdRegion);
			$tab = []; //On vide la tableau des id régions qui ne sert plus
			//stocke dans un tableau les régions
			foreach($tabloIdRegion as $tx){
				array_push($tab, $listforfait[$tx]);
			}
			//Liste 1 pour les suggestions
			$regionSuggestion1 = $tablo[0];
			$liste1Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[0]->getHebergementId()->getRegionId()->getId(), $idActivite[0]['id']);
			//Liste 2 pour les suggestions
			$regionSuggestion2 = $tablo[1];
			$liste2Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[1]->getHebergementId()->getRegionId()->getId(), $idActivite[0]['id']);
			//Liste 3 pour les suggestions
			$regionSuggestion3 = $tablo[2];
			$liste3Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[2]->getHebergementId()->getRegionId()->getId(), $idActivite[0]['id']);
			//Liste 4 pour les suggestions
			$regionSuggestion4 = $tablo[3];
			$liste4Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[3]->getHebergementId()->getRegionId()->getId(), $idActivite[0]['id']);
		}
		elseif(sizeof($listforfait) < 4)
		{
                       // shuffle($listforfait);
			$tab = $tablo = [];
			//stocke dans un tableau les régions
			foreach($listforfait as $tx){
				array_push($tab, $tx->getHebergementId()->getRegionId()->getId());
				array_push($tablo, $tx);
			}
                        $tab = array_unique($tab);
			if( isset($tab[0])){
				$liste1Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[0], $idActivite[0]['id']);
				$regionSuggestion1 = $tablo[0];
			}
			if( isset($tab[1])){
				$liste2Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[1], $idActivite[0]['id']);
				$regionSuggestion2 = $tablo[1];
			}
			if( isset($tab[2])){
				$liste3Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[2], $idActivite[0]['id']);
				$regionSuggestion3 = $tablo[2];
			}                        
		}
		if(count($listforfait) > 1){ 
			//Recherche un client aléatoire pour cette catégorie
			$index = array_rand($listforfait, 1);
			$clientAleatoire = $listforfait[$index];
		}else{
			$clientAleatoire = $listforfait[0];
		}
		//Formulaire de recherche Google API
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/forfaits_'.strtolower($idActivite[0]['repertoire_fr']).'.html', '/packages_'.strtolower($idActivite[0]['repertoire_en']).'.html')); 
                //Titre Québec en saisons
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //retourne le chemin pour aller chercher les images de la catégorie pour les 4 colonnes de suggestions
                $tabImages = $this->eviteDoublonImage($idActivite);               
                $imgIndex = rand(0, (count($tabImages)-1)); 
                $imgRandom = $tabImages[$imgIndex];
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view forfaitsActivite.html.twig
		return $this->render('MyAppGlobalBundle:Forfaits:forfaitsActiviteIndex.html.twig',
                    array(
                            'insection' 		=> "inSection",
                            'forfaits' 			=> 'valid',
                            'form' 			=> $form->createView(),
                            'texte_accueilfr'		=> html_entity_decode($idActivite[0]['texte_fr']),
                            'texte_accueilen'		=> html_entity_decode($idActivite[0]['texte_en']),
                            'listeClient'               => $listClient,
                            'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                            'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                            'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                            'urlforfaits'		=> true,
                            'formEngine'		=> $formEngine->createView(),
                            'menuForfait'		=> true,
                            'activite'			=> true,
                            'regionqc' 			=> $regionqc,
                            'regionon' 			=> $regionon,
                            'regionnb' 			=> $regionnb,
                            'filarianeforfaitindex'     => $idActivite[0],
                            'clientAleatoire'		=> $clientAleatoire,
                            'regionSuggestion1'		=> $regionSuggestion1,	//Titre de régions pour les suggestions
                            'regionSuggestion2'		=> $regionSuggestion2,
                            'regionSuggestion3'		=> $regionSuggestion3,
                            'regionSuggestion4'		=> $regionSuggestion4,
                            'listeClient1'		=> $liste1Suggestion,  //Liste des clients
                            'listeClient2'		=> $liste2Suggestion,
                            'listeClient3'		=> $liste3Suggestion,
                            'listeClient4'		=> $liste4Suggestion,
                            'googledfp1'		=> "GR_FORFAIT_01",
                            'googledfp2'		=> "GR_FORFAIT_02",
                            'googledfp3'		=> "GR_FORFAIT_03",
                            'activiteforfait'		=> true,
                            'saison'			=> $saison,
                            'reservationRegionAjax'     => $reservationRegionAjax,
                            'reservationVilleAjax'      => $reservationVilleAjax,
                            'reservationPays'		=> $reservationEnLignePays[0],
                            'reservationProvince'       => $reservationEnLignePays[1],
                            'metaforfaitenfant'         => $idActivite[0],
                            'imageColBas1'              => $tabImages[0],
                            'imageColBas2'              => $tabImages[1],
                            'imageColBas3'              => $tabImages[2],
                            'imageColBas4'              => $tabImages[3],
                            'imgRandom'                 => $imgRandom,
                            'idActivite'                => $idActivite[0]['id'],
                    ));
	}
        
        /**
         * Retourne les 4 images pour les colonnes du bas evitera les doublons dans les catégories
         */
        private function eviteDoublonImage($idActivite)
        {
            $path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']);
            $tabTemp = scandir($path_parts['dirname'].'/uploads/forfaits/images_'.$idActivite[0]['id']);
            $tabImages = [];
            for($i = 3; $i < count($tabTemp); $i++){
                array_push($tabImages, $tabTemp[$i]);
            }
            shuffle($tabImages);
            return $tabImages;
        }
        
        public function getEviteDoublonImageDestination($idActivite)
        {
            return $this->eviteDoublonImage($idActivite);
        }
	
	/**
	 * Affiche la province choisie avec la catégorie du forfait
	 */
	public function displayActiviteProvinceAction($activite, $name)
	{
		$txt_home_fr = $txt_home_en = $title_meta_en = $title_meta_fr = $reservationRegionAjax = $reservationVilleAjax = $regionSuggestion1 = $regionSuggestion2 = $regionSuggestion3 = $regionSuggestion4 = $liste1Suggestion  = $liste2Suggestion  = $liste3Suggestion  = $liste4Suggestion = "";
		//Valide le nom de la province en paramètre
		$controller = new ControleDataSecureController();
		$name = $controller->getCleanNameGeography($name, "name");
		$activite = $controller->getCleanNameGeography($activite, 'name');
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Recherche l'id de l'activité par son nom
		$idActivite = $em->getRepository('MyAppGlobalBundle:Forfaits')->getRechercheIdForfait($activite);
		//On recherche l'id de la province par son nom
		$idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);
		//Affiche les régions qui ont ce type de forfait
		$region = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegionGroupByRegion($idProvince[0]->getId(), $idActivite[0]['id']);
		//Liste tous les forfaits valides de cette catégorie
		$listforfait = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaProvince($idProvince[0]->getId() , $idActivite[0]['id']);
		//Si on a 4 ou plus, des régions
		if(sizeof($listforfait) >= 4)
		{
			//On déclare un tableau pour stocker les id de région
			$tab = $tablo = [];
			foreach($listforfait as $ts)
			{
				array_push($tab, $ts->getHebergementId()->getRegionId()->GetId());	
				array_push($tablo, $ts);
			}
			//On récupère aléatoirement 4 id de région
			$tabloIdRegion = array_rand($tab, 4);
			$tab = []; //On vide la tableau des id régions qui ne sert plus
			//stocke dans un tableau les régions
			foreach($tabloIdRegion as $tx){
				array_push($tab, $listforfait[$tx]);
			}
			//Liste 1 pour les suggestions
			$regionSuggestion1 = $tablo[0];
			$liste1Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[0]->getHebergementId()->getRegionId()->getId(), $idActivite[0]['id']);
			//Liste 2 pour les suggestions
			$regionSuggestion2 = $tablo[1];
			$liste2Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[1]->getHebergementId()->getRegionId()->getId(), $idActivite[0]['id']);
			//Liste 3 pour les suggestions
			$regionSuggestion3 = $tablo[2];
			$liste3Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[2]->getHebergementId()->getRegionId()->getId(), $idActivite[0]['id']);
			//Liste 4 pour les suggestions
			$regionSuggestion4 = $tablo[3];
			$liste4Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[3]->getHebergementId()->getRegionId()->getId(), $idActivite[0]['id']);
		}
		elseif(sizeof($listforfait) < 4)
		{
			$tab = $tablo = [];
			//stocke dans un tableau les régions
			foreach($listforfait as $tx){
				array_push($tab, $tx->getHebergementId()->getRegionId()->getId());
				array_push($tablo, $tx);
			}
			if( isset($tab[0]) ){
				$liste1Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[0], $idActivite[0]['id']);
				$regionSuggestion1 = $tablo[0];
			}
			if( isset($tab[1])){
				$liste2Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[1], $idActivite[0]['id']);
				$regionSuggestion2 = $tablo[1];
			}
			if( isset($tab[2]) ){
				$liste3Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegion($tab[2], $idActivite[0]['id']);
				$regionSuggestion3 = $tablo[2];
			}
		}
		if(count($listforfait) > 1){
			//Recherche un client aléatoire pour cette catégorie
			$index = array_rand($listforfait, 1);
			$clientAleatoire = $listforfait[$index];
		}else{
			$clientAleatoire = $listforfait[0];
		}
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Texte_province_forfait')->getRechercheTexteAccueil($idProvince[0]->getId(), $idActivite[0]['id']);
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Texte_province_forfait')->getRechercheTexteAccueil($idProvince[0]->getId(), $idActivite[0]['id']);
                if($texte_accueil != null and $texte_accueil_en != null){
                    $txt_home_fr = html_entity_decode($texte_accueil[0]->getTexteFr());
                    $txt_home_en = html_entity_decode($texte_accueil_en[0]->getTexteEn());
                    $title_meta_fr = $texte_accueil[0];
                    $title_meta_en = $texte_accueil_en[0];
                }
                //Formulaire de recherche Google API
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/forfaits_'.strtolower($idActivite[0]['repertoire_fr']).'_province_'.strtolower($idProvince[0]->getRepertoireFr()).'.html', '/packages_'.strtolower($idActivite[0]['repertoire_en']).'_province_'.strtolower($idProvince[0]->getRepertoireEn()).'.html'));   
                //Titre lien Québec eb saisons
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                 //retourne le chemin pour aller chercher les images de la catégorie pour les 4 colonnes de suggestions
                $tabImages = $this->eviteDoublonImage($idActivite);
                $imgIndex = rand(0, (count($tabImages)-1)); 
                $imgRandom = $tabImages[$imgIndex];
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view forfaitsActivite.html.twig
		return $this->render('MyAppGlobalBundle:Forfaits:forfaitsActiviteProvince.html.twig',
                    array(
                            'insection'                     => "inSection",
                            'forfaits'                      => 'valid',
                            'form'                          => $form->createView(),
                            'texte_accueilfr'               => $txt_home_fr,
                            'texte_accueilen'               => $txt_home_en,
                            'listeClient'                   => $listClient,
                            'regionQcFooter'                => (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                            'regionOnFooter'                => (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                            'regionNbFooter'                => (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                            'urlforfaits'                   => true,
                            'formEngine'                    => $formEngine->createView(),
                            'menuForfait'                   => true,
                            'regionactivite'                => $region,
                            'clientAleatoire'               => $clientAleatoire,
                            'regionSuggestion1'             => $regionSuggestion1,	//Titre de régions pour les suggestions
                            'regionSuggestion2'             => $regionSuggestion2,
                            'regionSuggestion3'             => $regionSuggestion3,
                            'regionSuggestion4'             => $regionSuggestion4,
                            'listeClient1'                  => $liste1Suggestion, // liste des clients
                            'listeClient2'                  => $liste2Suggestion,
                            'listeClient3'                  => $liste3Suggestion,
                            'listeClient4'                  => $liste4Suggestion,
                            'nbClient1'                     => count($liste1Suggestion),	//Nombre de client pour cette catégorie du forfait et de cette région
                            'nbClient2'                     => count($liste2Suggestion),
                            'nbClient3'                     => count($liste3Suggestion),
                            'nbClient4'                     => count($liste4Suggestion),
                            'googledfp1'                    => "GR_FORFAIT_01",
                            'googledfp2'                    => "GR_FORFAIT_02",
                            'googledfp3'                    => "GR_FORFAIT_03",
                            'activiteProvince'              => true,
                            'saison'                        => $saison,
                            'reservationRegionAjax'         => $reservationRegionAjax,
                            'reservationVilleAjax'          => $reservationVilleAjax,
                            'reservationPays'               => $reservationEnLignePays[0],
                            'reservationProvince'           => $reservationEnLignePays[1],
                            'metaforfaitcategorieregionfr'  => $title_meta_fr,
                            'metaforfaitcategorieregionen'  => $title_meta_en,
                            'imageColBas1'                  => $tabImages[0],
                            'imageColBas2'                  => $tabImages[1],
                            'imageColBas3'                  => $tabImages[2],
                            'imageColBas4'                  => $tabImages[3],
                            'imgRandom'                     => $imgRandom,
                            'idActivite'                    => $idActivite[0]['id'],
                    ));
	}
	
	/**
	 * Affiche la liste détaillée des forfaits pour la région
	 */
	public function displayActiviteRegionAction($activite, $name, $page)
	{
		$metaregionfr = $metaregionen = $textefr = $texteen = $reservationRegionAjax = $reservationVilleAjax = "";
		$numberPaginate = 10;
		//Valide le nom de la province en paramètre
		$controller = new ControleDataSecureController();
		$name = $controller->getCleanNameGeography($name, "name");
		$activite = $controller->getCleanNameGeography($activite, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Recherche l'activité par son nom
		$idActivite = $em->getRepository('MyAppGlobalBundle:Forfaits')->getRechercheIdForfait($activite);
                //Recherche l'id de la région par son nom
		$idRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion($name);
		//Compte le nombre de type de forfait de cette région
		$countTypeForfaitRegion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getCompteFofaitCategorieDeLaRegion($idRegion[0]->getId(), $idActivite[0]['id']);
		//Contrôle la pagination
		$total = $countTypeForfaitRegion[0]['nbTypeForfait'];
		//Arrondit à l'entier supérieur
		$displaypage = ceil($total/$numberPaginate);
		//Valide que la variable page est valide.
		$page = (new ControleDataSecureController)->getValideEntierPagination($page, $displaypage);
		//Liste des forfaits de cette catégorie de la région
		$listeRegion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieDeLaRegionAvecPagination($idRegion[0]->getId(), $idActivite[0]['id'], $page, $numberPaginate);
                //Si on a 4 ou plus, des régions
		if(sizeof($listeRegion) > 4 ){
			$tabTemp = $tablo = $tabIndex = [];
			shuffle($listeRegion);
                       // $tablo = $listeRegion;
			$tabIndex = array_rand($listeRegion, 4);
			foreach($tabIndex as $tw){
                            array_push($tablo, $listeRegion[$tw]);                          
			}                     
		}else{
			$tablo = [];
			shuffle($listeRegion);
			$tablo = $listeRegion;
		}
		//On recherche un client aléatoire
		if(count($listeRegion) > 1){
			$index = array_rand($listeRegion, 1);
			$clientAleatoire = $listeRegion[$index];
		}else{
			$clientAleatoire = $listeRegion[0];
		}        
		//On récupère le texte d'accueil
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Texte_region_forfait')->getRechercheTexteAccueil($idRegion[0]->getId(), $idActivite[0]['id']);
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Texte_region_forfait')->getRechercheTexteAccueil($idRegion[0]->getId(), $idActivite[0]['id']);		
                if($texte_accueil != null and $texte_accueil_en != null){
                    $txt_home_fr = html_entity_decode($texte_accueil[0]->getTexteFr());
                    $txt_home_en = html_entity_decode($texte_accueil_en[0]->getTexteEn());
                    $title_meta_fr = $texte_accueil[0];
                    $title_meta_en = $texte_accueil_en[0];
                }
                //Formulaire de recherche Google API
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/forfaits_'.strtolower($idActivite[0]['repertoire_fr']).'_region_'.strtolower($idRegion[0]->getRepertoireFr()).'.html', '/packages_'.strtolower($idActivite[0]['repertoire_en']).'_region_'.strtolower($idRegion[0]->getRepertoireEn()).'.html'));   
                //Titre lien Québec eb saisons
		//Liste des tarifs de dernière minute
		$tarifDerniereMinute = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheRegionForfaitsDerniereMinuteAvecCategorie($idActivite[0]['id'], $idRegion[0]->getId());
                //Liste les villes de cette région
		$listeVilleColonneGauche = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getCompteFofaitCategorieDeLaRegionGrouperParVille($idRegion[0]->getId(), $idActivite[0]['id']);
                //
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);                
                //retourne le chemin pour aller chercher les images de la catégorie pour les 4 colonnes de suggestions
                $tabImages = $this->eviteDoublonImage($idActivite);               
                $imgIndex = rand(0, (count($tabImages)-1)); 
                $imgRandom = $tabImages[$imgIndex];
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		//Préparation de la view forfaitsActivite.html.twig
		return $this->render('MyAppGlobalBundle:Forfaits:forfaitsActiviteRegion.html.twig',
				array(
						'insection' 				=> "inSection",
						'forfaits' 				=> 'valid',
						'form' 					=> $form->createView(),
						'texte_accueilfr'			=> $txt_home_fr,
						'texte_accueilen'			=> $txt_home_en,
						'listeClient' 				=> $listClient,
						'regionQcFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
						'urlforfaits'				=> true,
						'formEngine'				=> $formEngine->createView(),
						'menuForfait'				=> true,
						'clientAleatoire'			=> $clientAleatoire,
						'listeSuggestion'			=> $tablo,
						'googledfp1'				=> "GR_FORFAIT_01",
						'googledfp2'				=> "GR_FORFAIT_02",
                                                'googledfp3'                            => "GR_FORFAIT_03",
						'activiteRegion'			=> true,
						'listeRegion' 				=> $listeRegion,
						'page'					=> $page,
						'displaypage'				=> $displaypage,
						'total'					=> $total,
						'tarifDerniereMinute'                   => $tarifDerniereMinute,
						'listeVilleColonneGauche'               => $listeVilleColonneGauche,
						'saison'				=> $saison,
						'reservationRegionAjax'                 => $reservationRegionAjax,
						'reservationVilleAjax'                  => $reservationVilleAjax,
						'reservationPays'			=> $reservationEnLignePays[0],
						'reservationProvince'                   => $reservationEnLignePays[1],
                                                'metaforfaitcategorieregionfr'          => $title_meta_fr,
                                                'metaforfaitcategorieregionen'          => $title_meta_en,  
                                                'imageColBas1'                          => $tabImages[0],
                                                'imageColBas2'                          => $tabImages[1],
                                                'imageColBas3'                          => $tabImages[2],
                                                'imageColBas4'                          => $tabImages[3],
                                                'style'                                 => $idActivite[0]['id'],
                                                'imgRandom'                             => $imgRandom,                                                
				));
	}
	
	/**
	 * Sélectionne une liste de client pour les suggestions
	 */
	/*public function getCreerListeClient($tab)
	{
		(is_array($tab) == true)? $tab = $tab : $tab = "Failed";
		$nbItem = sizeof($tab);
		if($nbItem >= 5)
		{
			$index = array_rand($tab, 5);
			$resultat = [];
			foreach($index as $ts){
				array_push($resultat, $tab[$ts]);
			} 
		}
		elseif($nbItem == 4)
		{
			$index = array_rand($tab, 4);
			$resultat = [];
			foreach($index as $ts){
				array_push($resultat, $tab[$ts]);
			} 
		}
		elseif($nbItem == 3)
		{
			$index = array_rand($tab, 3);
			$resultat = [];
			foreach($index as $ts){
				array_push($resultat, $tab[$ts]);
			}
		}
		elseif($nbItem == 2)
		{
			$index = array_rand($tab, 2);
			$resultat = [];
			foreach($index as $ts){
				array_push($resultat, $tab[$ts]);
			}
		}
		elseif($nbItem == 1)
		{
			$index = array_rand($tab, 1);
			$resultat = $tab[$index];
		}
		return $resultat;
	}*/
	
	/**
	 * Méthode pour la génération des liste de clients pour les suggestions
	 */
	public function genereSuggestionForfaits($listeForfait, $em)
	{
		$liste1Suggestion = $liste2Suggestion = $liste3Suggestion = "";
		$tablo = $tableauRegion = $tableauClient = [];
		//Si on a 3 ou plus, des régions
		if(sizeof($listeForfait) > 3)
		{
			//On déclare un tableau pour stocker les id de région
			$tab = [];
			foreach($listeForfait as $ts)
			{
                            array_push($tab, $ts->getHebergementId()->getRegionId()->getId());
			}
			$tabUnique = array_unique($tab);
                        $tableauVal = [];
                        foreach($tabUnique as $val){
                            array_push($tableauVal, $val);
                        }
                        $tabUnique = [];
                        $tabUnique = $tableauVal;
			if(count($tabUnique) >= 4){ 
				//On récupère aléatoirement 3 id de région
				$tabloIdRegion = array_rand($tabUnique, 3);
				$regionSugg = $em->getRepository('MyAppGlobalBundle:Regions')->getTabIdRegion($tabloIdRegion);
				//Les régions des suggestions
                                if(count($regionSugg) >= 3){
                                    $regionSuggestion1 = $regionSugg[0];
                                    $regionSuggestion2 = $regionSugg[1];
                                    $regionSuggestion3 = $regionSugg[2];
                                    $tableauRegion = [ $regionSuggestion1, $regionSuggestion2, $regionSuggestion3];
                                }
                                elseif(count($regionSugg) == 2){
                                    $regionSuggestion1 = $regionSugg[0];
                                    $regionSuggestion2 = $regionSugg[1];
                                    $tableauRegion = [ $regionSuggestion1, $regionSuggestion2];
                                }
                                 elseif(count($regionSugg) == 1 ){
                                    $regionSuggestion1 = $regionSugg[0];
                                    $tableauRegion = [ $regionSuggestion1];
                                }
				array_push($tablo, $tableauRegion);
			}else{      
				$regionSugg = $em->getRepository('MyAppGlobalBundle:Regions')->getTabIdRegion($tabUnique);
              
				if(count($tabUnique) == 3){
                                        if(count($regionSugg) >= 3){
                                            $regionSuggestion1 = $regionSugg[0];
                                            $regionSuggestion2 = $regionSugg[1];
                                            $regionSuggestion3 = $regionSugg[2];
                                            $tableauRegion = [ $regionSuggestion1, $regionSuggestion2, $regionSuggestion3];
                                        }
                                        elseif(count($regionSugg) == 2){
                                            $regionSuggestion1 = $regionSugg[0];
                                            $regionSuggestion2 = $regionSugg[1];
                                            $tableauRegion = [ $regionSuggestion1, $regionSuggestion2];
                                        }
                                        elseif(count($regionSugg) == 1){
                                            $regionSuggestion1 = $regionSugg[0];
                                            $tableauRegion = [ $regionSuggestion1];
                                        }
                                        array_push($tablo, $tableauRegion);
				}elseif(count($tabUnique) == 2){
					$regionSuggestion1 = $regionSugg[0];
					$regionSuggestion2 = $regionSugg[1];
					$tableauRegion = [ $regionSuggestion1, $regionSuggestion2];
					array_push($tablo, $tableauRegion);
				}else{
					$regionSuggestion1 = $regionSugg[0];
					$tableauRegion = [ $regionSuggestion1 ];
					array_push($tablo, $tableauRegion);
				}
			}                       
			//Liste 1 pour les suggestions
			$liste1Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValideRegion($tabUnique[0]);
			array_push($tableauClient, $liste1Suggestion);
			//Liste 2 pour les suggestions
			if(isset($tabloIdRegion[1])){
				$liste2Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValideRegion($tabUnique[1]);
				array_push($tableauClient, $liste2Suggestion);
			}
			//Liste 3 pour les suggestions
			if(isset($tabloIdRegion[2])){
				$liste3Suggestion = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValideRegion($tabUnique[2]);
				array_push($tableauClient, $liste3Suggestion);
			}
			array_push($tablo, $tableauClient);
		}
		return $tablo;
	}
}