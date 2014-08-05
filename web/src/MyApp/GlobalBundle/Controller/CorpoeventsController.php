<?php
namespace MyApp\GlobalBundle\Controller;
use MyApp\GlobalBundle\Controller\ControleDataSecureController;
use MyApp\GlobalBundle\MyAppGlobalBundle;
use MyApp\GlobalBundle\Controller\HebergementController;
use MyApp\AdminBundle\Forms\SearchMoteurEnginePortailType;
use MyApp\AdminBundle\Forms\AddAppelOffreType;
use MyApp\GlobalBundle\Entity\Appel_Offre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyApp\GlobalBundle\Form\GoogleForm;
use MyApp\GlobalBundle\Entity\Formu_province_region;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use Berriart\Bundle\SitemapBundle\Entity\ImageUrl;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use MyApp\GlobalBundle\Controller\DefaultController;
use MyApp\GlobalBundle\Entity\Utilisateur;
 
 /**
  * 
  * @author leonardc
  * 
  * Controller pour la section CORPORATIF et ÉVÉNEMENT coté client 
  */
class CorpoeventsController extends Controller{
	
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
				$url->setChangeFreq(Url::CHANGEFREQ_WEEKLY);
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
			$url->setChangeFreq(Url::CHANGEFREQ_WEEKLY);
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
 	 * Page d'accueil pour la section « CORPORATIF » 
 	 */
 	public function indexAction()
 	{
 		$reservationRegionAjax = $reservationVilleAjax = $listeForfaitAffaire = $chambreAleatoire = "";
 		$saison = (new DefaultController)->getSaisonQuebec();
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Liste les régions qui ont des salles
		$regionqc = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveRegion(9);
		$regionon = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveRegion(8);
		$regionnb = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveRegion(5);
		//Client aleatoire 
		$clientAleatoire = [$regionqc, $regionon, $regionnb];
		$clientAleatoire = array_values(array_filter($clientAleatoire));
		//Si on a pas de type de soin disponible on redirige vers une autre page
		if($clientAleatoire == null){
			return $this->redirect($this->generateUrl("_demandesansitem", array("section" => "corporatif")));
		}
		if($clientAleatoire != null){
			if(count($clientAleatoire[0]) > 1){
				$index = array_rand($clientAleatoire[0], 1);
				$clientAleatoire = $clientAleatoire[0][$index];
			}else{
				$clientAleatoire = $clientAleatoire[0][0];
			}
		}
		//Liste des forfaits affaires
		$listeForfaitAffaire = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsAffairesMultiProvince();
		if(count($listeForfaitAffaire) > 1){
			unset($index);
			$index = array_rand($listeForfaitAffaire);
			$listeForfaitAffaire = $listeForfaitAffaire[$index];
		}else{
			if(count($listeForfaitAffaire) == 1){
				$listeForfaitAffaire = $listeForfaitAffaire[0];
			}
		}
		//On stocke dans un tableau les résultats pour en sortir un aléatoirement
		$tabAleatoire = [];
		if($regionqc != null){
			array_push($tabAleatoire,$regionqc);
		}
		if($regionon != null){
			array_push($tabAleatoire,$regionon);
		}
		if($regionnb != null){
			array_push($tabAleatoire,$regionnb);
		}
		//On brasse le tableau
		shuffle($tabAleatoire);
		//On filtre les valeurs
		$tab = [];
		foreach($tabAleatoire as $key => $value){
			foreach($value as $ts){
				array_push($tab, $ts);
			}
		}
		unset($value);		
		//Retourne la liste des salles corporatives
		$salleCorporatif = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporative();
		//Liste des chambres affaire
		$listeChambreAffaire = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaire();
		//Récupère une chambre affaire aléatoire
		if($listeChambreAffaire != null){
			if(count($listeChambreAffaire) > 1){
				$indexChambre = array_rand($listeChambreAffaire, 1);
				$chambreAleatoire = $listeChambreAffaire[$indexChambre];
			}else{
				$chambreAleatoire = $listeChambreAffaire[0];
			}
		}
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);              
		//On récupère le texte d'accueil            
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/corporatif_evenements.html', '/corporate_events.html'));	
 		//Pays et provinces
 		$reservationEnLignePays = (new DefaultController)->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view Corpo_&_events:corpo.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:corpo.html.twig', 
                        array(	
                                'regionqc'			=> $regionqc,
                                'regionon'			=> $regionon,
                                'regionnb'			=> $regionnb,
                                'corporatif' 			=> 'valid', 
                                'insection' 			=> "inSection",
                                'form' 				=> $form->createView(),
                                'urlcorpo'			=> "index",
                                'clientAleatoire'		=> $clientAleatoire,
                                'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']),
                                'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']),
                                'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                'formEngine'			=> $formEngine->createView(),
                                'listeClient'			=> $listClient,
                                'googledfp1'			=> "GR_CORPORATIF_01",
                                'googledfp2'			=> "GR_CORPORATIF_02",
                                'googledfp3'			=> "GR_CORPORATIF_03",
                                'listeForfaitAffaire'           => $listeForfaitAffaire,
                                'salleCorporative'		=> $salleCorporatif,
                                'chambreAleatoire'		=> $chambreAleatoire,
                                'saison'			=> $saison,
                                'reservationRegionAjax'         => $reservationRegionAjax,
                                'reservationVilleAjax'          => $reservationVilleAjax,
                                'reservationPays'		=> $reservationEnLignePays[0],
                                'reservationProvince'           => $reservationEnLignePays[1],
                                'urlcorpoindexfr'		=> true,
                                'urlcorpoindexen'		=> true,
                                'metacorpofr'                   => $texte_accueil[0],
                                'metacorpoen'                   => $texte_accueil_en[0],
                                'main'                          => true,
                               
                        ));
 	}
 	
 	/**
 	 * Affiche les corporatifs une fois que la province est choisie
 	 */
 	public function listerProvinceAction($name)
 	{
 		$specific = $texte_accueil = $texte_accueil_en = $reservationRegionAjax = $reservationVilleAjax = "";
 		$name = (new ControleDataSecureController)->getCleanNameGeography($name, "province");
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//Retourne l'id de la province
 		$idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);
 		//Affiche les régions de la province
 		$region = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveRegion($idProvince[0]->getId());
 		//On récupère un corpo aléatoire
 		$listeCorpoDeLaProvince = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveRegion($idProvince[0]->getId());
 		//On brasse la tableau
 		shuffle($listeCorpoDeLaProvince);
 		//Client aléatoire
 		if(count($listeCorpoDeLaProvince) > 1){
 			$index = array_rand($listeCorpoDeLaProvince, 1);
 			$clientAleatoire = $listeCorpoDeLaProvince[$index];
 		}else{
 			$clientAleatoire = $listeCorpoDeLaProvince[0];
 		}
 		//Liste des forfaits affaire de la province
 		$listeForfaitAffaire = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsAffairesProvince($idProvince[0]->getId());
 		if($listeForfaitAffaire != null){
 			if(count($listeForfaitAffaire) > 1){
 				$indexForfait = array_rand($listeForfaitAffaire, 1);
 				$listeForfaitAffaire = $listeForfaitAffaire[$indexForfait];
 			}else{
 				$listeForfaitAffaire = $listeForfaitAffaire[0];
 			}
 		}
 		//Retourne la liste des salles corporatives
 		$salleCorporatif = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActive($idProvince[0]->getId());
 		//Liste des chambres affaire
 		$listeChambreAffaire = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireProvince($idProvince[0]->getId());
 		//Récupère une chambre affaire aléatoire
 		if(count($listeChambreAffaire) > 1){
                    $indexChambre = array_rand($listeChambreAffaire, 1);
                    $chambreAleatoire = $listeChambreAffaire[$indexChambre];
 		}elseif(count($listeChambreAffaire) == 1){
                    $chambreAleatoire = $listeChambreAffaire[0];
 		}else{
                    $chambreAleatoire = "";
                }
 		//Formulaire de recherche map intéractive
 		$search = new Formu_province_region();
 		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
 		//On récupère le texte d'accueil
                $texteSection = $em->getRepository("MyAppGlobalBundle:Texte_province_corporatif")->getRechercheTexteAccueil($idProvince[0]->getId());
                if($texteSection != null)
                {                    
                     $texte_accueil = html_entity_decode($texteSection[0]->getTexteFr());
                     $texte_accueil_en = html_entity_decode($texteSection[0]->getTexteEn());
                     $titleMetaEn = $titleMetaFr = $texteSection[0];                     
                     $specific = true;
                }
                else
                {
                    $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
                    $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();             
                    $titleMetaFr = $texte_accueil[0];
                    $titleMetaEn = $texte_accueil_en[0];
                    $texte_accueil = html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']);
                    $texte_accueil_en = html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']);
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
                (new HebergementController)->generePersistSiteMap2('/corporatif_evenements_province_', '/corporate_events_province_', $idProvince[0], $em);
                //Titre lien Québec en saison
 		$saison = (new DefaultController)->getSaisonQuebec();
 		//Reservation en ligne
 		$reservationEnLigne = new DefaultController();
 		//Pays et provinces
 		$reservationEnLignePays = $reservationEnLigne->getReservationEnLignePays($em); 	
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view Corpo_&_events:corpo.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:corpo_province.html.twig',
                    array(
                            'province'                      => $name,
                            'region'                        => $region,
                            'corporatif'                    => 'valid',
                            'insection'                     => "inSection",
                            'form'                          => $form->createView(),
                            'urlcorpo'                      => "corpo",
                            'texte_accueilfr'               => $texte_accueil,
                            'texte_accueilen'               => $texte_accueil_en,
                            'clientAleatoire'               => $clientAleatoire,
                            'views'                         => ucfirst($name),
                            'regionQcFooter'                => (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                            'regionOnFooter'                => (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                            'regionNbFooter'                => (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                            'formEngine'                    => $formEngine->createView(),
                            'listeClient'                   => $listClient,
                            'googledfp1'                    => "GR_CORPORATIF_01",
                            'googledfp2'                    => "GR_CORPORATIF_02",
                            'googledfp3'                    => "GR_CORPORATIF_03",
                            'noeudcorpoprovince'            => true,
                            'listeForfaitAffaire'           => $listeForfaitAffaire,
                            'chambreAleatoire'              => $chambreAleatoire,
                            'salleCorporative'              => $salleCorporatif,
                            'saison'                        => $saison,
                            'reservationRegionAjax'         => $reservationRegionAjax,
                            'reservationVilleAjax'          => $reservationVilleAjax,
                            'reservationPays'               => $reservationEnLignePays[0],
                            'reservationProvince'           => $reservationEnLignePays[1],
                            'metacorpogeneriquefr'          => $titleMetaFr,
                            'metacorpogeneriqueen'          => $titleMetaEn,
                            'specific'                      => $specific,
                    ));
 	}
        
 	
 	public function reservationFormulaireAction()
 	{
 		$request = $this->container->get('request');
 		if($request->isXmlHttpRequest())
 		{
                        $tab = [];
 			$reservationRegion = $reservationVille = '';
 			$reservationRegion = $request->request->get('reservationregion');
 			$reservationVille = $request->request->get('reservationville');
 			(is_numeric($reservationRegion))? $reservationRegion : $reservationRegion = "";
 			(is_numeric($reservationVille))? $reservationVille : $reservationVille = "";
 			$em = $this->getDoctrine()->getEntityManager();
 			if($reservationRegion != '' and is_numeric($reservationRegion) == true){
                            //retourne la liste des régions filtrée
                            $reservitRegion = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByReservitId($reservationRegion);
                            $reservationRegionAjax = $em->getRepository('MyAppGlobalBundle:Regions')->getRetourneListeRegionReservit($reservitRegion[0]->getId());
                            //Retourne la liste des villes pour cette province
                            foreach($reservationRegionAjax as $key){
                                array_push($tab, $key['id']);
                            }
                            $reservationVilleAjax = $em->getRepository('MyAppGlobalBundle:Villes')->getListeVilleParTableauRegion($tab);
                            return $this->render('MyAppGlobalBundle:Corpo_&_events:reservationregion.xml.twig', array( 
                                'reservationRegionAjax'	=> $reservationRegionAjax,
                                'reservationVilleAjax'  => $reservationVilleAjax,       
                            ));
 			}elseif($reservationVille != '' and is_numeric($reservationVille) == true){
                            //retourne la liste des villes filtrée
                            $reservitVille = $em->getRepository('MyAppGlobalBundle:Regions')->getSearchIdByReservitId($reservationVille);
                            $reservationVilleAjax = $em->getRepository('MyAppGlobalBundle:Villes')->getRetourneListeVilleReservit($reservitVille[0]->getId());
                            return $this->render('MyAppGlobalBundle:Corpo_&_events:reservationville.xml.twig', array( 'reservationVilleAjax'	=> $reservationVilleAjax));
 			}elseif($reservationRegion == ''){
                            //retourne rien
                            return $this->render('MyAppGlobalBundle:Corpo_&_events:reservationregion.xml.twig', array( 'reservationRegionAjax'	=> null));
                        }
 		}
 	}
 	
 	
 	/**
 	 * Affiche la région pour les corporatifs
 	 */
 	public function listerRegionAction($name)
 	{
 		$specific = $reservationRegionAjax = $reservationVilleAjax = $forfaitAffaireAleatoire = $chambreAleatoire = "";
 		//On néttoie l'argument
 		$name = (new ControleDataSecureController)->getCleanNameGeography($name, "name");
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager(); 	
 		//Retourne l'id de la région
 		$idRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion($name);
 		//Affiche les villes de la région
 		$ville = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheListeSalleCorporativeActiveVille($idRegion[0]->getId());
 		//Liste tous les clients de cette région qui ont des forfaits affaires
 		$listeForfaitAffaire = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getCompteForfaitAffaireRegion($idRegion[0]->getId());
 		//Si on trouve des clients dans cette région qui ont des forfaits affaires.
                if($listeForfaitAffaire != null){
 			if(count($listeForfaitAffaire) > 1){
	 			$indexforfait = array_rand($listeForfaitAffaire, 1);
	 			$forfaitAffaireAleatoire = $listeForfaitAffaire[$indexforfait];
 			}else{
 				$forfaitAffaireAleatoire = $listeForfaitAffaire[0];
 			}
 		}  
                //On récupère le texte d'accueil
                $texteSection = $em->getRepository("MyAppGlobalBundle:Texte_region_corporatif")->getRechercheTexteAccueil($idRegion[0]->getId());
                if($texteSection != null)
                {                    
                     $texte_accueil = html_entity_decode($texteSection[0]->getTexteFr());
                     $texte_accueil_en = html_entity_decode($texteSection[0]->getTexteEn());
                     $titleMetaEn = $titleMetaFr = $texteSection[0];                     
                     $specific = true;
                }
                else
                {
                    $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
                    $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();               
                    $titleMetaFr = $texte_accueil[0];
                    $titleMetaEn = $texte_accueil_en[0];
                    $texte_accueil = html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']);
                    $texte_accueil_en = html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']);
                }
 		//Corpo aleatoire
 		$tabAleatoire = [];
 		foreach($ville as $ts){
 			array_push($tabAleatoire, $ts);
 		}
 		//On brasse la tableau
 		shuffle($tabAleatoire);
 		//Client aleatoire
 		if(count($tabAleatoire) > 1)
 		{
 			$index = array_rand($tabAleatoire, 1);
 			$clientAleatoire = $tabAleatoire[$index];
 		}else{
 			$clientAleatoire = $tabAleatoire[0];
 		}
 		//Retourne la liste des salles corporatives
 		$salleCorporatif = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveRegion($idRegion[0]->getProvinceEtatId()->getId());
 		//Liste des chambres affaire
 		$listeChambreAffaire = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireRegion($idRegion[0]->getId());
 		//Récupère une chambre affaire aléatoire
 		if($listeChambreAffaire != null){
	 		if(count($listeChambreAffaire) > 1){
	 			$indexChambre = array_rand($listeChambreAffaire, 1);
	 			$chambreAleatoire = $listeChambreAffaire[$indexChambre];
	 		}else{
	 			$chambreAleatoire = $listeChambreAffaire[0];
	 		}
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
                (new HebergementController)->generePersistSiteMap2('/corporatif_evenements_region_', '/corporate_events_region_', $idRegion[0], $em);
 		$saison = (new DefaultController)->getSaisonQuebec();
 		//Reservation en ligne
 		$reservationEnLigne = new DefaultController();
 		//Pays et provinces
 		$reservationEnLignePays = $reservationEnLigne->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view corpoIndex.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:corpo_region.html.twig', 
                    array(	 
                            'form' 				=> $form->createView(),
                            'region'				=> $name,
                            'ville'				=> $ville,
                            'corporatif' 			=> 'valid',
                            'insection' 			=> "inSection",
                            'urlcorpo'				=> "corpo",
                            'texte_accueilfr'			=> $texte_accueil,
                            'texte_accueilen'			=> $texte_accueil_en,
                            'clientAleatoire'			=> $clientAleatoire,
                            'views'				=> $name,
                            'regionQcFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                            'regionOnFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                            'regionNbFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                            'formEngine'			=> $formEngine->createView(),
                            'listeClient'			=> $listClient,
                            'listeForfaitAffaire'               => $listeForfaitAffaire,
                            'aleatoireForfaitAffaire'           => $forfaitAffaireAleatoire,
                            'googledfp1'			=> "GR_CORPORATIF_01",
                            'googledfp2'			=> "GR_CORPORATIF_02",
                            'googledfp3'                        => "GR_CORPORATIF_03",
                            'noeudcorporegion'			=> true,
                            'chambreAleatoire'			=> $chambreAleatoire,
                            'salleCorporative'			=> $salleCorporatif,
                            'saison'				=> $saison,
                            'reservationRegionAjax'             => $reservationRegionAjax,
                            'reservationVilleAjax'              => $reservationVilleAjax,
                            'reservationPays'			=> $reservationEnLignePays[0],
                            'reservationProvince'               => $reservationEnLignePays[1],
                            'metacorpogeneriquefr'              => $titleMetaFr,
                            'metacorpogeneriqueen'              => $titleMetaEn,
                            'specific'                          => $specific,
                    ));
 	}
 	
 	/**
 	 * Affiche les villes pour les corporatifs
 	 */
 	public function listerVilleAction($name)
 	{
 		$reservationRegionAjax = $reservationVilleAjax = $forfaitAffaireVille =  $chambreAleatoire = "";
 		//On néttoie l'argument.
 		$name = (new ControleDataSecureController)->getCleanNameGeography($name, "name");
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On récupère le texte d'accueil
 		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();
 		//Retourne l'id de la ville
 		$idVille = $em->getRepository('MyAppGlobalBundle:Villes')->getSearchTown($name); 
 		//Retourne tous les forfaits affaires dans cette ville
 		$forfaitAffaire = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheForfaitAffaireVille($idVille[0]->getId());
 		if($forfaitAffaire != null)
 		{
	 		//Retourne un forfait affaire aléatoire
	 		$tab = [];
	 		foreach($forfaitAffaire as $tx){
	 			array_push($tab, $tx);
	 		}
		 	shuffle($tab);
		 	if(count($tab) > 1){
			 	$indexForfait = @array_rand($tab, 1);
			 	$forfaitAffaireVille = $tab[$indexForfait];
		 	}else{
		 		$forfaitAffaireVille = $tab[0];
		 	}
 		}
 		//Affiche les salles corporatives de la ville
 		$salleCorporatif = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getCompteListeSalleCorporativeActiveVille($idVille[0]->getId());
 		$tabAleatoire = [];
 		foreach($salleCorporatif as $ts){
 			array_push($tabAleatoire, $ts);
 		}
 		//On brasse la tableau
 		shuffle($tabAleatoire);
 		//Client aléatoire
 		if(count($tabAleatoire) > 1){
 			$index = @array_rand($tabAleatoire, 1);
 			$clientAleatoire = $tabAleatoire[$index];
 		}else{
 			$clientAleatoire = $tabAleatoire[0];
 		} 
 		//Liste des chambres affaire
 		$listeChambreAffaire = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireVille($idVille[0]->getId());
 		//Récupère une chambre affaire aléatoire
 		if($listeChambreAffaire != null){
 			if(count($listeChambreAffaire) > 1){
 				$indexChambre = array_rand($listeChambreAffaire, 1);
 				$chambreAleatoire = $listeChambreAffaire[$indexChambre];
 			}else{
 				$chambreAleatoire = $listeChambreAffaire[0];
 			}
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
                (new HebergementController)->generePersistSiteMap2('/corporatif_evenements_ville_', '/corporate_events_city_', $idVille[0], $em);
 		$saison = (new DefaultController)->getSaisonQuebec();
 		//Reservation en ligne
 		$reservationEnLigne = new DefaultController();
 		//Pays et provinces
 		$reservationEnLignePays = $reservationEnLigne->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view corpoIndex.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:corpo_ville.html.twig',
                    array(
                            'form'                          => $form->createView(),
                            'corporatif'                    => 'valid',
                            'insection'                     => "inSection",
                            'urlcorpo'                      => "corpo",
                            'texte_accueilfr'               => html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']),
                            'texte_accueilen'               => html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']),
                            'clientAleatoire'               => $clientAleatoire,
                            'views'                         => $name,
                            'forfait'                       => $forfaitAffaireVille,
                            'regionQcFooter'                => (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                            'regionOnFooter'                => (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                            'regionNbFooter'                => (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                            'formEngine'                    => $formEngine->createView(),
                            'listeClient'                   => $listClient,
                            'googledfp1'                    => "GR_CORPORATIF_01",
                            'googledfp2'                    => "GR_CORPORATIF_02",
                            'googledfp3'                    => "GR_CORPORATIF_03",
                            'noeudcorpoville'               => true,               
                            'chambreAleatoire'              => $chambreAleatoire,
                            'salleCorporative'              => $salleCorporatif,
                            'saison'                        => $saison,
                            'reservationRegionAjax'         => $reservationRegionAjax,
                            'reservationVilleAjax'          => $reservationVilleAjax,
                            'reservationPays'               => $reservationEnLignePays[0],
                            'reservationProvince'           => $reservationEnLignePays[1],
                            'metacorpoville'                => true,
                            'metacorpoen'                   => $texte_accueil_en[0],
                            'metacorpofr'                   => $texte_accueil[0],
                    ));
 	}
 	
        /**
         * 
         * Sélectionne par ajax les régions pour l'appel d'offre
         */
        public function appelOffreProvinceAjaxAction()
        {
               $request = $this->container->get('request');
 		if($request->isXmlHttpRequest())
 		{
 			$provinceappel = '';
 			$provinceappel = $request->request->get('provinceappel');
 			if($provinceappel != '' and is_numeric($provinceappel) == true)
 			{
                            $em = $this->getDoctrine()->getEntityManager();
                            $regionAjax = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActive($provinceappel);
                            return $this->render('MyAppGlobalBundle:Corpo_&_events:province.xml.twig', array( 'regionAjax'	=> $regionAjax));
                        }
                }
        }
        
        /**
         * 
         * Sélectionne par ajax les villes pour l'appel d'offre
         */
        public function appelOffreRegionAjaxAction()
        {
               $request = $this->container->get('request');
 		if($request->isXmlHttpRequest())
 		{
 			$region = '';
 			$region = $request->request->get('region');
 			if($region != '' and is_numeric($region) == true)
                        {
                            $em = $this->getDoctrine()->getEntityManager();
                            $villeAjax = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveVille($region);
                            return $this->render('MyAppGlobalBundle:Corpo_&_events:region.xml.twig', array( 'villeAjax'	=> $villeAjax));
 			}
                }
        }
        
         /**
         * 
         * Sélectionne par ajax les hébergements de la liste du formulaire pour l'appel d'offre
         */
        public function appelOffreVilleAjaxAction()
        {
               $request = $this->container->get('request');
 		if($request->isXmlHttpRequest())
 		{
 			$ville = '';
 			$ville = $request->request->get('ville');
 			if($ville != '' and is_numeric($ville) == true)
                        {
                            $em = $this->getDoctrine()->getEntityManager();
                            $clientAjax = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getCompteListeSalleCorporativeActiveVille($ville);
                            return $this->render('MyAppGlobalBundle:Corpo_&_events:etablissement.xml.twig', array( 'clientAjax'	=> $clientAjax));
 			}
                }
        }
 	
 	/**
 	 * Affiche le formulaire pour l'appel d'offre
 	 */
 	public function appelOffreAction()
 	{
 		$specific = $regionAjax = $villeAjax = $clientAjax = $reservationRegionAjax = $reservationVilleAjax ="";
 		$saison = (new DefaultController)->getSaisonQuebec();
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On récupère le texte d'accueil
 		$texteSection = $em->getRepository("MyAppGlobalBundle:Texte_province_appel_offre")->getRechercheTexteAccueil(9);
                if($texteSection != null)
                {                    
                     $texte_accueil = html_entity_decode($texteSection[0]->getTexteFr());
                     $texte_accueil_en = html_entity_decode($texteSection[0]->getTexteEn());
                     $titleMetaEn = $titleMetaFr = $texteSection[0];                     
                     $specific = true;
                }
                else
                {
                    $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
                    $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();                 
                    $titleMetaFr = $texte_accueil[0];
                    $titleMetaEn = $texte_accueil_en[0];
                    $texte_accueil = html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']);
                    $texte_accueil_en = html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']);
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
 		//Reservation en ligne
 		$reservationEnLignePays = (new DefaultController)->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Formulaire pour l'appel d'offre
 		$appelOffre = new Appel_Offre();
 		$formAppelOffre = $this->createForm(new AddAppelOffreType(), $appelOffre);
 		//Liste des provinces qui ont des salles corporatives disponibles
 		$listeProvince = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveToutesProvinces(); 		
 		//Client aléatoire
 		if(count($listeProvince) > 1){
 			$index = array_rand($listeProvince, 1);
 			$clientAleatoire = $listeProvince[$index];
 		}else{
 			$clientAleatoire = $listeProvince[0];
 		}
 		//Traitement via requête de type ajax
 		$request = $this->container->get('request');
                if(!$request->isXmlHttpRequest()){
 		//traitement du formulaire d'appel d'offre
 		//$request = $this->get('request');
	 		// On vérifie qu'elle est de type « POST ».
	 		if( $request->getMethod() == 'POST' )
	 		{
	 			// On fait le lien Requête <-> Formulaire.
	 			$formAppelOffre->bindRequest($request);
	 			if (ctype_digit(isset($_POST['idville']))) {
	 				$listeEmailCorpo = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getCompteListeSalleCorporativeActiveVille($_POST['idville']);
		 			//Transmet le formulaire à la méthode d'envoie du courriel
		 			$sender = $formAppelOffre->getData();
		 			$message = self::getEnvoyerAppleOffre($sender, $listeEmailCorpo);
		 			if($message == "confirmation")
		 			{
		 				return $this->render('MyAppGlobalBundle:Corpo_&_events:appel_offre_corpo.html.twig',
		 						array(
		 								'form' 				=> $form->createView(),
		 								'corporatif' 			=> 'valid',
		 								'insection' 			=> "inSection",
		 								'urlcorpo'			=> "corpo",
		 								'appeloffre'			=> true,
		 								'texte_accueilfr'		=> $texte_accueil,
										'texte_accueilen'		=> $texte_accueil_en,
		 								'formAppel'			=> $formAppelOffre->createView(),
		 								'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
										'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
										'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
		 								'formEngine'			=> $formEngine->createView(),
		 								'listeClient'			=> $listClient,
		 								'googledfp1'			=> "GR_CORPORATIF_01",
		 								'googledfp2'			=> "GR_CORPORATIF_02",
                                                                                'googledfp3'			=> "GR_CORPORATIF_03",
		 								'nodeappeloffre'		=> true,
		 								'listeProvince'			=> $listeProvince,
		 								'regionAjax'			=> $regionAjax,
		 								'villeAjax'			=> $villeAjax,
		 								'clientAleatoire'		=> $clientAleatoire,
		 								'clientAjax'			=> $clientAjax,
		 								'saison'			=> $saison,
		 								'reservationRegionAjax'         => $reservationRegionAjax,
		 								'reservationVilleAjax'          => $reservationVilleAjax,
		 								'reservationPays'		=> $reservationEnLignePays[0],
		 								'reservationProvince'           => $reservationEnLignePays[1],
                                                                                'metacorpogeneriqueen'          => $titleMetaEn,
                                                                                'metacorpogeneriquefr'          => $titleMetaFr,
                                                                                'specific'                      => $specific,
		 						));
		 			}
	 			}
	 		}
 		} 		
                //Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/corporatif_appel_offre.html', '/corporate_call_offers.html')); 
 		//Préparation de la view appel_offre_corpo.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:appel_offre_corpo.html.twig',
 				array(	
 						'form' 					=> $form->createView(),
 						'corporatif' 				=> 'valid',
 						'insection' 				=> "inSection",
 						'urlcorpo'				=> "corpo",
 						'appeloffre'				=> true,
 						'texte_accueilfr'			=> $texte_accueil,
						'texte_accueilen'			=> $texte_accueil_en,
 						'formAppel'				=> $formAppelOffre->createView(),
 						'regionQcFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'				=> $formEngine->createView(),
 						'listeClient'				=> $listClient,
 						'googledfp1'				=> "GR_CORPORATIF_01",
 						'googledfp2'				=> "GR_CORPORATIF_02",
                                                'googledfp3'                            => "GR_CORPORATIF_03",
 						'nodeappeloffre'			=> true,
 						'listeProvince'				=> $listeProvince,
 						'regionAjax'				=> $regionAjax,
 						'villeAjax'				=> $villeAjax,
 						'clientAleatoire'			=> $clientAleatoire,
 						'clientAjax'				=> $clientAjax,
 						'reservationPays'			=> $reservationEnLignePays[0],
 						'reservationProvince'                   => $reservationEnLignePays[1],
 						'reservationRegionAjax'                 => $reservationRegionAjax,
 						'reservationVilleAjax'                  => $reservationVilleAjax,
 						'saison'				=> $saison,
                                                'metacorpogeneriqueen'                  => $titleMetaEn,
                                                'metacorpogeneriquefr'                  => $titleMetaFr,
                                                'specific'                              => $specific,
 				));
 	}
 	
 	
 	/**
 	 * Envoie des emails appel d'offre
 	 */
 	private function getEnvoyerAppleOffre($name, $client)
 	{
 		//Variable du formulaire de soumission pour la demande d'information.
 		$prenom = $name->getPrenom();
 		$nom = $name->getNom();
 		$email = $name->getEmail();
 		$telephone = $name->getTelephone();
 		$datebegin = $name->getDateArrivee();
 		$dateend = $name->getDateDepart();
 		$flexibleDate = $name->getDateFlexible();
 		$entreprise = $name->getNomEntreprise();
 		$adresse = $name->getAdresse();
 		$ville = $name->getVille();
 		$province = $name->getProvinceEtat();
 		$codePostal = $name->getCodePostal();
 		$pays = $name->getPaysOffre();
 		$telecopieur = $name->getTelecopieur();
 		$chambre = $name->getTypeChambre();
 		$nbChambre = $name->getNbChambre();
 		$demandeSpecifique = $name->getDemandeSpecifiqueHebergement();
 		$nomReunion = $name->getNomReunion();
 		$nbPersonne = $name->getNbPersonne();
 		$typeEvent = $name->getTypeEventId();
 		$dispositionSalle = $name->getDispositionSalle();
 		$descriptionEquipement = $name->getDescriptionEquipement();
 		
 		//Tableau pour les email corporatifs des clients
 		$tabEmailCorpo = [];
 		foreach($client as $tw){
 			array_push($tabEmailCorpo, $tw->getEmailCorporatif());
 		}
 		$message = \Swift_Message::newInstance()
                    ->setSubject("Demande d'information pour une appel d'offre / Information request for tender")
                    ->setContentType('text/html')
                    ->setFrom($email)
                    ->setTo( array($tabEmailCorpo , "marketing@global-reservation.com"))
                    ->setBody(
                    $this->renderView(
                        'MyAppGlobalBundle:Hebergement:body_email.html.twig',
                            array(	'nom'    			=> ucfirst($nom),
                                        'prenom' 			=> ucfirst($prenom),
                                        'email'				=> $email,
                                        'telephone' 			=> $telephone,
                                        'datebegin' 			=> $datebegin,
                                        'dateend'   			=> $dateend,
                                        'flexibledate'			=> $flexibleDate,
                                        //'salle'  	    		=> $salleHebergement,
                                        'entreprise'    		=> $entreprise,
                                        'adresse'       		=> $adresse,
                                        'ville'				=> $ville,
                                        'province' 			=> $province,
                                        'codepostal'			=> $codePostal,
                                        'pays'				=> $pays,
                                        'telecopieur'   		=> $telecopieur,
                                        'chambre'			=> $chambre,
                                        'demandespecifique'             => $demandeSpecifique,
                                        'nbChambre'			=> $nbChambre,
                                        'reunion'			=> $nomReunion,
                                        'nbPersonne'			=> $nbPersonne,
                                        'typeEvent'			=> $typeEvent,
                                        'dispositionSalle' 		=> $dispositionSalle,
                                        'descriptionEquipement'         => $descriptionEquipement,
                                        'dateYear'			=> date("Y"),
                            )
                        )
                    );
 		//var_dump($this->get('mailer')->send($message));
 		//Envoie du message
 		$this->get('mailer')->send($message);
 		return "confirmation";
 	}
 	
 	
 	/**
 	 * Affiche la liste des chambres d'affaires
 	 */
 	public function chambreAffaireAction()
 	{
 		$reservationRegionAjax = $reservationVilleAjax = "";
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On récupère le texte d'accueil
 		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();
 		//Affiche la liste des provinces avec leurs régions qui ont des chambres d'affaires
 		$regionqc = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireProvince(9);
 		$regionon = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireProvince(8);
 		$regionnb = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireProvince(5);
 		//On filtre les valeurs vides
 		$tab = [$regionqc, $regionon, $regionnb];
 		$tab = array_values(array_filter($tab));
 		shuffle($tab);
 		if(count($tab[0]) > 1){
	 		//Retourne maximum 4 id de région aléatoire
	 		$regionAleatoire = self::getSuggestions4($tab);
	 		//Retourne maximum 5 id de client pour la liste des suggestions
	 		$clientAleatoire = self::getListe5ChambreAffaire($tab);
 		}else{
 			if(count($tab[0]) >=  4){
 				shuffle($tab[0]);
 				$tabloRegion = [];
 				foreach($tab[0] as $tw){
 					array_push($tabloRegion, $tw->getHebergement()->getRegionId()->getId());
 				}
 				$clientAleatoire = array_rand($tabloRegion, 4);
 			}else{
 				$regionAleatoire = [];
 				foreach($tab[0] as $tw){
 					array_push($regionAleatoire, $tw->getHebergement()->getRegionId()->getId());
 				}
 				$clientAleatoire = $regionAleatoire;
 			}
 		}
 		//Retourne 5 clients
 		$listeClientSuggestion = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireRegionLimit5($clientAleatoire);
 		//Client aléatoire
		if(count($tab) > 1){
			$numb = count($tab);
			$index = array_rand($tab, $numb);
	 		$aleatoire = array_rand($tab[$index], 1);
	 		$clientAleatoire = $tab[$index][$aleatoire];
		}else{
			$clientAleatoire = $tab[0][0];
		}
		//On récupère le tarif le moins chère pour chaque client
		$tablo = [];
		foreach($listeClientSuggestion as $tw)
		{
			array_push($tablo, $tw->getHebergement()->getId());
		}
		$tarifApartir = $em->getRepository('MyAppGlobalBundle:Chambres')->getRetourneChambreAffaireLaMoinsChere($tablo);
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/corporatif_chambres_affaires.html', '/corporate_business_rooms.html')); 
 		$saison = (new DefaultController)->getSaisonQuebec();
 		//Reservation en ligne
 		$reservationEnLigne = new DefaultController();
 		//Pays et provinces
 		$reservationEnLignePays = $reservationEnLigne->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view chambre_affaire.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:chambre_affaire.html.twig',
 				array(	
 						'form' 				=> $form->createView(),
 						'corporatif' 			=> 'valid',
 						'insection' 			=> "inSection",
 						'urlcorpo'			=> "corpo",
 						'regionqc'			=> $regionqc,
 						'regionon'			=> $regionon,
 						'regionnb'			=> $regionnb,
 						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']),
 						//'suggestions'			=> $listeRegionSuggestion,	
 						'listeclients'			=> $listeClientSuggestion,	
 						'clientAleatoire'		=> $clientAleatoire,	
 						'views' 			=> true,
 						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'			=> $formEngine->createView(),
 						'listeClient'			=> $listClient,
 						'googledfp1'			=> "GR_CORPORATIF_01",
 						'googledfp2'			=> "GR_CORPORATIF_02",
                                                'googledfp3'			=> "GR_CORPORATIF_03",
 						'nodeChambreCorpo'		=> true,
 						'tarifSuggestion'		=> $tarifApartir[0],
 						'metachambreAffaire'            => true,
 						'saison'			=> $saison,
 						'reservationPays'		=> $reservationEnLignePays[0],
 						'reservationProvince'           => $reservationEnLignePays[1],
 						'reservationRegionAjax'         => $reservationRegionAjax,
 						'reservationVilleAjax'          => $reservationVilleAjax,
                                                'metacorpoen'                   => $texte_accueil_en[0],
                                                'metacorpofr'                   => $texte_accueil[0],
 				));
 	}
 	
 	/**
 	 * Affiche la province avec ses régions qui ont des chambres d'affaires
 	 */
 	public function chambreAffaireProvinceAction($name)
 	{
 		$reservationRegionAjax = $reservationVilleAjax = "";
 		$name = (new ControleDataSecureController)->getCleanNameGeography($name, 'province');
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On valide le nom de la province
 		$idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);
 		//On récupère le texte d'accueil
 		$texteSection = $em->getRepository("MyAppGlobalBundle:Texte_province_chambre_affaire")->getRechercheTexteAccueil($idProvince[0]->getId());
                if($texteSection != null)
                {                    
                     $texte_accueil = html_entity_decode($texteSection[0]->getTexteFr());
                     $texte_accueil_en = html_entity_decode($texteSection[0]->getTexteEn());
                     $titleMetaEn = $titleMetaFr = $texteSection[0];                     
                     $specific = true;
                }
                else
                {
                    $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
                    $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();                
                    $titleMetaFr = $texte_accueil[0];
                    $titleMetaEn = $texte_accueil_en[0];
                    $texte_accueil = html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']);
                    $texte_accueil_en = html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']);
                }
 		//Affiche la liste des chambres d'affaires pour la province avec ses régions
 		$region = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireProvince($idProvince[0]->getId());
 		//Client aléatoire
 		if(count($region) > 1){
 			$index = array_rand($region, 1);
 			$clientAleatoire = $region[$index];
 		}else{
 			$clientAleatoire = $region[0];
 		}
 		$regionAleatoire = [];
 		foreach($region as $tw){
 			array_push($regionAleatoire, $tw->getHebergement()->getRegionId()->getId());
 		}
 		if(count($regionAleatoire) > 4){
 			$regionAleatoire = array_rand($regionAleatoire, 4);
 		}
 		//Retourne 5 clients
 		$listeClientSuggestion = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireRegionLimit5($regionAleatoire);
 		//On récupère le tarif le moins chère pour chaque client
		$tablo = [];
		foreach($listeClientSuggestion as $tw)
		{
			array_push($tablo, $tw->getHebergement()->getId());
		}
		$tarifApartir = $em->getRepository('MyAppGlobalBundle:Chambres')->getRetourneChambreAffaireLaMoinsChere($tablo);
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
                (new HebergementController)->generePersistSiteMap2('/corporatif_chambres_affaires_province_', '/corporate_business_rooms_province_', $idProvince[0], $em);
 		//Reservation en ligne
 		$reservationEnLigne = new DefaultController();
 		//Pays et provinces
 		$reservationEnLignePays = $reservationEnLigne->getReservationEnLignePays($em);
                $saison = $reservationEnLigne->getSaisonQuebec();
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view chambre_affaire_province.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:chambre_affaire_province.html.twig',
 				array(
 						'form'                                          => $form->createView(),
 						'corporatif' 					=> 'valid',
 						'insection' 					=> "inSection",
 						'urlcorpo'					=> "corpo",
 						'region'					=> $region,
 						'texte_accueilfr'				=> $texte_accueil,
						'texte_accueilen'				=> $texte_accueil_en,
 						//'suggestions'					=> $listeRegionSuggestion,
 						'listeclients'					=> $listeClientSuggestion,
 						'clientAleatoire'				=> $clientAleatoire,
 						'views'				    		=> $name,
 						'regionOrthographe'				=> true,
 						'regionQcFooter'				=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'				=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'				=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'					=> $formEngine->createView(),
 						'listeClient'					=> $listClient,
 						'googledfp1'					=> "GR_CORPORATIF_01",
 						'googledfp2'					=> "GR_CORPORATIF_02",
                                                'googledfp3'                                    => "GR_CORPORATIF_03",
 						'metachambreAffaireProvince'                    => true,
 						'tarifSuggestion'				=> $tarifApartir[0],
 						'nodeChambreCorpo'				=> true,
 						'saison'					=> $saison,
 						'reservationPays'				=> $reservationEnLignePays[0],
 						'reservationProvince'                           => $reservationEnLignePays[1],
 						'reservationRegionAjax'                         => $reservationRegionAjax,
 						'reservationVilleAjax'                          => $reservationVilleAjax,
                                                'metacorpogeneriqueen'                          => $titleMetaEn,
                                                'metacorpogeneriquefr'                          => $titleMetaFr,
 		));
 	}
 	
 	/**
 	 * Affiche la région avec les chambres d'affaires
 	 */
 	public function chambreAffaireRegionAction($name, $page)
 	{
 		$reservationRegionAjax = $reservationVilleAjax = "";
 		$numberPaginate = 10;
 		$controller = new ControleDataSecureController();
 		$name = $controller->getCleanNameGeography($name, 'region');
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On valide le nom de la province
 		$idRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion($name);
 		//On récupère le texte d'accueil
 		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();
 		//Compte le nombre dechambre d'affaire dans la région 
 		$listeclientChambre = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireRegion($idRegion[0]->getId());
 		//Pagination
 		$total = sizeof($listeclientChambre);
 		//On divise le nombre total de client par le nombre que l'on souhaite afficher.
 		$displaypage = ceil($total/$numberPaginate);
 		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
 		$page = $controller->getValideEntierPagination($page, $displaypage);
 		//Affiche la liste des chambres de la région choisi avec la pagination
 		$listePaginate = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireRegion($idRegion[0]->getId(), $page, $numberPaginate);
 		//Client aléatoire
 		if(count($listePaginate) > 1){
 			$index = array_rand($listePaginate, 1);
 			$clientAleatoire = $listePaginate[$index];
 		}else{
 			$clientAleatoire = $listePaginate[0];
 		}
 		$tablo = [];
 		foreach($listePaginate as $tw){
 			array_push($tablo, $tw->getHebergement()->getId());
 		}
 		if(count($tablo) > 4){
 			$regionAleatoire = array_rand($regionAleatoire, 4);
 		}
		$tarifApartir = $em->getRepository('MyAppGlobalBundle:Chambres')->getRetourneChambreAffaireLaMoinsChere($tablo);
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
                (new HebergementController)->generePersistSiteMap2('/corporatif_chambres_affaires_region_', '/corporate_business_rooms_region_', $idRegion[0], $em);
 		//Reservation en ligne
 		$reservationEnLigne = new DefaultController();
 		//Pays et provinces
 		$reservationEnLignePays = $reservationEnLigne->getReservationEnLignePays($em);
                $saison = $reservationEnLigne->getSaisonQuebec();
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view chambre_affaire_region.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:chambre_affaire_region.html.twig',
 				array(
 						'form' 						=> $form->createView(),
 						'corporatif' 					=> 'valid',
 						'insection' 					=> "inSection",
 						'urlcorpo'					=> "corpo",
 						'texte_accueilfr'				=> html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']),
						'texte_accueilen'				=> html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']),
 						'listeVille'					=> $listeclientChambre,
 						'clientAleatoire'				=> $clientAleatoire,
 						'views'				    		=> $name,
 						'regionQcFooter'				=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'				=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'				=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'					=> $formEngine->createView(),
 						'listeClient'					=> $listClient,
 						'googledfp1'					=> "GR_CORPORATIF_01",
 						'googledfp2'					=> "GR_CORPORATIF_02",
                                                'googledfp3'                                    => "GR_CORPORATIF_03",
 						'metachambreAffaireRegion'                      => true,
 						'tarifSuggestion'				=> $tarifApartir[0],
 						'nodeChambreCorpo'				=> true,
 						'displaypage'					=> $displaypage,
 						'page'						=> $page,
 						'total'						=> $total,
 						'listePaginate'					=> $listePaginate,
 						'saison'					=> $saison,
 						'reservationPays'				=> $reservationEnLignePays[0],
 						'reservationProvince'                           => $reservationEnLignePays[1],
 						'reservationRegionAjax'                         => $reservationRegionAjax,
 						'reservationVilleAjax'                          => $reservationVilleAjax,
                                                'metacorpoen'                                   => $texte_accueil_en[0],
                                                'metacorpofr'                                   => $texte_accueil[0],
 		));
 	}
 	
 	public function chambreAffaireVilleAction($name, $page)
 	{
 		$reservationRegionAjax = $reservationVilleAjax = "";
 		$numberPaginate = 10;
 		$controller = new ControleDataSecureController();
 		$name = $controller->getCleanNameGeography($name, 'region');
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On valide le nom de la ville
 		$idVille = $em->getRepository('MyAppGlobalBundle:Villes')->getSearchTown($name);
 		//On récupère le texte d'accueil
 		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();
 		//Compte le nombre dechambre d'affaire dans la ville
 		$listeclientChambre = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireVille($idVille[0]->getId());
 		//Pagination
 		$total = sizeof($listeclientChambre);
 		//On divise le nombre total de client par le nombre que l'on souhaite afficher.
 		$displaypage = ceil($total/$numberPaginate);
 		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
 		$page = $controller->getValideEntierPagination($page, $displaypage);
 		//Affiche la liste des chambres de la ville choisi avec la pagination
 		$listePaginate = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreAffaireVilleAvecPagination($idVille[0]->getId(), $page, $numberPaginate);
 		//Client aléatoire
 		if(count($listePaginate) > 1){
 			$index = array_rand($listePaginate, 1);
 			$clientAleatoire = $listePaginate[$index];
 		}else{
 			$clientAleatoire = $listePaginate[0];
 		}
 		$tablo = [];
 		foreach($listePaginate as $tw){
 			array_push($tablo, $tw->getHebergement()->getId());
 		}
 		if(count($tablo) > 4){
 			$regionAleatoire = array_rand($regionAleatoire, 4);
 		}
		$tarifApartir = $em->getRepository('MyAppGlobalBundle:Chambres')->getRetourneChambreAffaireLaMoinsChere($tablo);
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
                (new HebergementController)->generePersistSiteMap2('/corporatif_chambres_affaires_ville_', '/corporate_business_rooms_city_', $idVille[0], $em);
 		//Reservation en ligne
 		$reservationEnLigne = new DefaultController();
 		//Pays et provinces
 		$reservationEnLignePays = $reservationEnLigne->getReservationEnLignePays($em);
                $saison = $reservationEnLigne->getSaisonQuebec();
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view chambre_affaire_ville.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:chambre_affaire_ville.html.twig',
 				array(
 						'form'                                          => $form->createView(),
 						'corporatif' 					=> 'valid',
 						'insection' 					=> "inSection",
 						'urlcorpo'					=> "corpo",
 						'texte_accueilfr'				=> html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']),
						'texte_accueilen'				=> html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']),
 						'clientAleatoire'				=> $clientAleatoire,
 						'views'				    		=> $name,
 						'regionQcFooter'				=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'				=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'				=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'					=> $formEngine->createView(),
 						'listeClient'					=> $listClient,
 						'googledfp1'					=> "GR_CORPORATIF_01",
 						'googledfp2'					=> "GR_CORPORATIF_02",
                                                'googledfp3'                                    => "GR_CORPORATIF_03",
 						'metachambreAffaireVille'                       => true,
 						'tarifSuggestion'				=> $tarifApartir[0],
 						'nodeChambreCorpo'				=> true,
 						'displaypage'					=> $displaypage,
 						'page'						=> $page,
 						'total'						=> $total,
 						'listePaginate'					=> $listePaginate,
 						'saison'					=> $saison,
 						'reservationPays'				=> $reservationEnLignePays[0],
 						'reservationProvince'                           => $reservationEnLignePays[1],
 						'reservationRegionAjax'                         => $reservationRegionAjax,
 						'reservationVilleAjax'                          => $reservationVilleAjax,
                                                'metacorpoen'                                   => $texte_accueil_en[0],
                                                'metacorpofr'                                   => $texte_accueil[0],
 		));
 	}
 	
 	
 	/**
 	 * Retourne les résultats pour les 4 suggestions
 	 */
 	public function getSuggestions4($tablo)
 	{
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On déclare un tabeau pour stocker les id des régions disponibles
 		$tab = [];
 		foreach($tablo as $ts){
 			foreach($ts as $tx){
 				array_push($tab, $tx->getHebergement()->getRegionId()->getId());
 			}
 		}

 		$container = [];
 		if(sizeof($tab) >= 4)
 		{
 			$regionAleatoire = array_rand($tab, 4);
 			foreach($regionAleatoire as $th){
 				array_push($container, $tab[$th]);
 			}
 		}
 		if(sizeof($tab) == 3)
 		{
 			$regionAleatoire = array_rand($tab, 3);
 			foreach($regionAleatoire as $th){
 				array_push($container, $tab[$th]);
 			}
 		}
 		if(sizeof($tab) == 2)
 		{
 			$regionAleatoire = array_rand($tab, 2);
 			foreach($regionAleatoire as $th){
 				array_push($container, $tab[$th]);
 			}
 		}
 		if(sizeof($tab) == 1)
 		{
 			/*$regionAleatoire = array_rand($tab, 1);
 			foreach($regionAleatoire as $th){
 				array_push($container, $tab[$th]);
 			}*/
 			$container = $tab;
 		}
 		return $container;
 	}
 	
 	/**
 	 * Retourne une liste de 5 établissements qui ont des chambres affaires pour les 4 suggestions
 	 */
 	public function getListe5ChambreAffaire($tablo)
 	{
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On déclare un tabeau pour stocker les id des régions disponibles
 		$tab = [];

 		foreach($tablo as $ts){
 			foreach($ts as $tx){
 				array_push($tab, $tx->getHebergement()->getId());
 			}
 		}
 		$container = [];
 		if(sizeof($tab) == 5)
 		{
 			$clientAleatoire = array_rand($tab, 5);
 			foreach($clientAleatoire as $th){
 				array_push($container, $tab[$th]);
 			}
 		}
 		if(sizeof($tab) == 4)
 		{
 			$clientAleatoire = array_rand($tab, 4);
 			foreach($clientAleatoire as $th){
 				array_push($container, $tab[$th]);
 			}
 		}
 		if(sizeof($tab) == 3)
 		{
 			$clientAleatoire = array_rand($tab, 3);
 			foreach($clientAleatoire as $th){
 				array_push($container, $tab[$th]);
 			}
 		}
 		if(sizeof($tab) == 2)
 		{
 			$clientAleatoire = array_rand($tab, 2);
 			foreach($clientAleatoire as $th){
 				array_push($container, $tab[$th]);
 			}
 		}
 		if(sizeof($tab) == 1)
 		{
 			/*$clientAleatoire = array_rand($tab, 1);
 			foreach($clientAleatoire as $th){
 				array_push($container, $tab[$th]);
 			}*/
 			$container = $tab;
 		}
 		return $container;
 	}
 	
 	/**
 	 * Affiche la liste des locations de salle de réunion
 	 */
 	public function locationSalleReunionAction()
 	{
 		$reservationRegionAjax = $reservationVilleAjax = $regionSugg1 = $regionSugg2 = $regionSugg3 = $regionSugg4 = $listeClient1 = $listeClient2 = $listeClient3 = $listeClient4 = "";
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//Affiche les provinces avec leurs régions
 		$regionqc = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveRegion(9);
 		$regionon = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveRegion(8);
 		$regionnb = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveRegion(5);
 		$tab = [$regionqc, $regionon, $regionnb];
 		$tab = array_values(array_filter($tab));
 		if(count($tab) > 1)//Si on plus que une province
 		{
 			$index = array_rand($tab[0] , 1);
 			if(count($tab[0][$index]) > 1){
 				$indexRegion = array_rand($tab[0][$index], 1);
 				$clientAleatoire = $tab[$index][$indexRegion];
 			}else{
 				$clientAleatoire = $tab[$index][0];
 			}
 		}else{//Sinon on regarde dans la seule province si on a plusieurs régions
                    if($tab != null){
 			if(count($tab[0]) > 1){
                            shuffle($tab[0]);
                            $index = array_rand($tab[0], 1);
                            $clientAleatoire = $tab[0][$index];
 			}else{
                            $clientAleatoire = $tab[0][0];
 			}
                    }
 		}
 		//On récupère le texte d'accueil
 		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/location_salle_reunion.html', '/meeting_room_rental.html')); 
 		$tabChoix = [1, 2, 3];
 		//$reponse = array_rand($tabChoix, 1);
 		$reponse = 1;
 		//Listes nos suggestions bas de page
 		if($reponse == 1){
 			if($regionqc != null){
 				shuffle($regionqc);
 				if(isset($regionqc[0])){
 					$regionSugg1 = $regionqc[0];
 					$listeClient1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionqc[0]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					$tabClient = [];
 					foreach($listeClient1 as $tw){
 						array_push($tabClient, $tw->getSalleCorporativehebergement()->getId());
 					}
 					$listeClient1 = "";
 					if(count($tabClient) > 5){
 						$tabClient = array_rand($tabClient, 5);
 						$listeClient1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}else{
 						$listeClient1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}
 				}if(isset($regionqc[1])){
 					$regionSugg2 = $regionqc[1];
 					$listeClient2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionqc[1]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					$tabClient = [];
 					foreach($listeClient2 as $tw){
 						array_push($tabClient, $tw->getSalleCorporativehebergement()->getId());
 					}
 					$listeClient2 = "";
 					if(count($tabClient) > 5){
 						$tabClient = array_rand($tabClient, 5);
 						$listeClient2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}else{
 						$listeClient2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}
 				}if(isset($regionqc[2])){
 					$regionSugg3 = $regionqc[2];
 					$listeClient3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionqc[2]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					$tabClient = [];
 					foreach($listeClient3 as $tw){
 						array_push($tabClient, $tw->getSalleCorporativehebergement()->getId());
 					}
 					$listeClient3 = "";
 					if(count($tabClient) > 5){
 						$tabClient = array_rand($tabClient, 5);
 						$listeClient3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}else{
 						$listeClient3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}
 				}if(isset($regionqc[3])){
 					$regionSugg4 = $regionqc[3];
 					$listeClient4 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionqc[3]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					$tabClient = [];
 					foreach($listeClient4 as $tw){
 						array_push($tabClient, $tw->getSalleCorporativehebergement()->getId());
 					}
 					$listeClient4 = "";
 					if(count($tabClient) > 5){
 						$tabClient = array_rand($tabClient, 5);
 						$listeClient4 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}else{
 						$listeClient4 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}
 				}
 			}
 		}elseif($reponse == 2){
 			if($regionon != null){			
 				shuffle($regionon);
 				if(isset($regionon[0])){
 					$regionSugg1 = $regionon[0];
 					$listeClient1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionon[0]->getSalleCorporativeHebergement()->getRegionId()->getId());
 				}if(isset($regionon[1])){
 					$regionSugg2 = $regionon[1];
 					$listeClient2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionon[1]->getSalleCorporativeHebergement()->getRegionId()->getId());
 				}if(isset($regionon[2])){
 					$regionSugg3 = $regionon[2];
 					$listeClient3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionon[2]->getSalleCorporativeHebergement()->getRegionId()->getId());
 				}if(isset($regionon[3])){
 					$regionSugg4 = $regionon[3];
 					$listeClient4 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionon[3]->getSalleCorporativeHebergement()->getRegionId()->getId());
 				}
 			}
 		}elseif($reponse == 3){
 			if($regionnb != null){	
 				shuffle($regionnb);
 				if(isset($regionon[0])){
 					$regionSugg1 = $regionon[0];
 					$listeClient1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionnb[0]->getSalleCorporativeHebergement()->getRegionId()->getId());
 				}if(isset($regionon[1])){
 					$regionSugg2 = $regionon[1];
 					$listeClient2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionnb[1]->getSalleCorporativeHebergement()->getRegionId()->getId());
 				}if(isset($regionon[2])){
 					$regionSugg3 = $regionon[2];
 					$listeClient3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionnb[2]->getSalleCorporativeHebergement()->getRegionId()->getId());
 				}if(isset($regionon[3])){
 					$regionSugg4 = $regionon[3];
 					$listeClient4 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($regionnb[3]->getSalleCorporativeHebergement()->getRegionId()->getId());
 				}
 			}	
 		}else{//Sinon on regarde dans la seule province si on a plusieurs régions
 			shuffle($tab[0]);
 			if(isset($tab[0][0])){
 				$regionSugg1 = $tab[0][0];
 				$listeClient1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($tab[0][0]->getSalleCorporativeHebergement()->getRegionId()->getId());
 			}if(isset($tab[0][1])){
 				$regionSugg2 = $tab[0][1];
 				$listeClient2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($tab[0][1]->getSalleCorporativeHebergement()->getRegionId()->getId());
 			}if(isset($tab[0][2])){
 				$regionSugg3 = $tab[0][2];
 				$listeClient3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($tab[0][2]->getSalleCorporativeHebergement()->getRegionId()->getId());
 			}if(isset($tab[0][3])){
 				$regionSugg4 = $tab[0][3];
 				$listeClient4 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($tab[0][3]->getSalleCorporativeHebergement()->getRegionId()->getId());
 			}
 		}
 		//Reservation en ligne
 		$reservationEnLigne = new DefaultController();
 		//Pays et provinces
 		$reservationEnLignePays = $reservationEnLigne->getReservationEnLignePays($em);
                $saison = $reservationEnLigne->getSaisonQuebec();
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view location_salle_reunion.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:location_salle_reunion.html.twig',
 				array(	
 						'form' 				=> $form->createView(),
 						'corporatif' 			=> 'valid',
 						'insection' 			=> "inSection",
 						'regionqc'			=> $regionqc,
 						'regionon'			=> $regionon,
 						'regionnb'			=> $regionnb,
 						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'			=> $formEngine->createView(),
 						'listeClient'			=> $listClient,
 						'googledfp1'			=> "GR_CORPORATIF_01",
 						'googledfp2'			=> "GR_CORPORATIF_02",
                                                'googledfp3'			=> "GR_CORPORATIF_03",
 						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']),
 						'clientAleatoire'		=> $clientAleatoire,
 						'corposalle'			=> true,
 						'urlcorpo'                      => 'corpo',
 						'views'                         => true,
 						'regionSugg1'                   => $regionSugg1,
 						'regionSugg2'                   => $regionSugg2,
 						'regionSugg3'                   => $regionSugg3,
 						'regionSugg4'                   => $regionSugg4,
 						'listeClient1'			=> $listeClient1,
 						'listeClient2'			=> $listeClient2,
 						'listeClient3'			=> $listeClient3,
 						'listeClient4'			=> $listeClient4,
 						'saison'			=> $saison,
 						'reservationPays'		=> $reservationEnLignePays[0],
 						'reservationProvince'           => $reservationEnLignePays[1],
 						'reservationRegionAjax'         => $reservationRegionAjax,
 						'reservationVilleAjax'          => $reservationVilleAjax,
                                                'metacorpoen'                   => $texte_accueil_en[0],
                                                'metacorpofr'                   => $texte_accueil[0],
 				)
 		);
 	}
 	
 	/**
 	 * Affiche la liste des locations de salle de réunion pour la province
 	 */
 	public function locationSalleReunionProvinceAction($name)
 	{
 		$specific = $reservationRegionAjax = $reservationVilleAjax = $regionSugg1 = $regionSugg2 = $regionSugg3 = $regionSugg4 = $listeClient1 = $listeClient2 = $listeClient3 = $listeClient4 = "";
 		//On valide le nom de la province
 		$name = (new ControleDataSecureController)->getCleanNameGeography($name, 'province');
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On recherche l'id de la province
 		$idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);
 		//Affiche la province avec ses régions
 		$region = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeActiveRegion($idProvince[0]->getId());
		//Recherche un client aléatoire
		if(count($region) > 1){
			$index = array_rand($region, 1);
			$clientAleatoire = $region[$index];
		}else{
			$clientAleatoire = $region[0];
		}
 		//On récupère le texte d'accueil
 		$texteSection = $em->getRepository("MyAppGlobalBundle:Texte_province_location_salle")->getRechercheTexteAccueil($idProvince[0]->getId());
                if($texteSection != null)
                {                    
                     $texte_accueil = html_entity_decode($texteSection[0]->getTexteFr());
                     $texte_accueil_en = html_entity_decode($texteSection[0]->getTexteEn());
                     $titleMetaEn = $titleMetaFr = $texteSection[0];                     
                     $specific = true;
                }
                else
                {
                    $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
                    $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();                 
                    $titleMetaFr = $texte_accueil[0];
                    $titleMetaEn = $texte_accueil_en[0];
                    $texte_accueil = html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']);
                    $texte_accueil_en = html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']);
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
                (new HebergementController)->generePersistSiteMap2('/location_salle_reunion_province_', '/meeting_room_rental_province_', $idProvince[0], $em);
 		//Nos suggestions
 			if($region != null){
 				shuffle($region);
 				if(isset($region[0])){
 					$regionSugg1 = $region[0];
 					$listeClient1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($region[0]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					$tabClient = [];
 					foreach($listeClient1 as $tw){
 						array_push($tabClient, $tw->getSalleCorporativehebergement()->getId());
 					}
 					$listeClient1 = "";
 					if(count($tabClient) > 5){
 						$tabClient = array_rand($tabClient, 5);
 						$listeClient1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}else{
 						$listeClient1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}
 				}if(isset($region[1])){
 					$regionSugg2 = $region[1];
 					$listeClient2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($region[1]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					$tabClient = null;
 					$tabClient = [];
 					foreach($listeClient2 as $tw){
 						array_push($tabClient, $tw->getSalleCorporativehebergement()->getId());
 					}
 					$listeClient2 = "";
 					if(count($tabClient) > 5){
 						$tabClient = array_rand($tabClient, 5);
 						$listeClient2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}else{
 						$listeClient2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}
 				}if(isset($region[2])){
 					$regionSugg3 = $region[2];
 					$listeClient3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($region[2]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					$listClient = null;
 					$tabClient = [];
 					foreach($listeClient3 as $tw){
 						array_push($tabClient, $tw->getSalleCorporativehebergement()->getId());
 					}
 					$listeClient3 = "";
 					if(count($tabClient) > 5){
 						$tabClient = array_rand($tabClient, 5);
 						$listeClient3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}else{
 						$listeClient3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}
 				}if(isset($region[3])){
 					$regionSugg4 = $region[3];
 					$listeClient4 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($region[3]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					$tabClient = null;
 					$tabClient = [];
 					foreach($listeClient4 as $tw){
 						array_push($tabClient, $tw->getSalleCorporativehebergement()->getId());
 					}
 					$listeClient4 = "";
 					if(count($tabClient) > 5){
 						$tabClient = array_rand($tabClient, 5);
 						$listeClient4 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}else{
 						$listeClient4 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListeSalleCorporativeDuGroupeClient($tabClient);
 					}
 				}
 			}
 		//Reservation en ligne
 		$reservationEnLigne = new DefaultController();
 		//Pays et provinces
 		$reservationEnLignePays = $reservationEnLigne->getReservationEnLignePays($em);
                $saison = $reservationEnLigne->getSaisonQuebec();
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view location_salle_reunion_province.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:location_salle_reunion_province.html.twig',
 				array(
 						'form' 				=> $form->createView(),
 						'corporatif' 			=> 'valid',
 						'insection' 			=> "inSection",
 						'region'			=> $region,
 						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'			=> $formEngine->createView(),
 						'listeClient'			=> $listClient,
 						'googledfp1'			=> "GR_CORPORATIF_01",
 						'googledfp2'			=> "GR_CORPORATIF_02",
                                                'googledfp3'			=> "GR_CORPORATIF_03",
 						'texte_accueilfr'		=> $texte_accueil,
						'texte_accueilen'		=> $texte_accueil_en,
 						'clientAleatoire'		=> $clientAleatoire,
 						'corposalleprovince'            => true,
 						'urlcorpo'			=> 'corpo',
 						'views'				=> true,
 						'regionSugg1'                   => $regionSugg1,
 						'regionSugg2'                   => $regionSugg2,
 						'regionSugg3'                   => $regionSugg3,
 						'regionSugg4'                   => $regionSugg4,
 						'listeClient1'			=> $listeClient1,
 						'listeClient2'			=> $listeClient2,
 						'listeClient3'			=> $listeClient3,
 						'listeClient4'			=> $listeClient4,
 						'saison'			=> $saison,
 						'reservationPays'		=> $reservationEnLignePays[0],
 						'reservationProvince'           => $reservationEnLignePays[1],
 						'reservationRegionAjax'         => $reservationRegionAjax,
 						'reservationVilleAjax'          => $reservationVilleAjax,
                                                'metacorpogeneriqueen'          => $titleMetaEn,
                                                'metacorpogeneriquefr'          => $titleMetaFr,
                                                'specific'                      => $specific,
 		));
 	}
 	
 	/**
 	 * Affiche la liste des locations de salle de réunion pour la région
 	 */
 	public function locationSalleReunionRegionAction($name, $page)
 	{
 		$numberPaginate = 10;
 		$specific = $reservationRegionAjax = $reservationVilleAjax = $forfaitAffaire1 = $forfaitAffaire2 = $forfaitAffaire3 = $forfaitAffaire4 = $salleCorpo1 = $salleCorpo2 = $salleCorpo3 = $salleCorpo4 = $regionSugg1 = $regionSugg2 = $regionSugg3 = $regionSugg4 = $listeClient1 = $listeClient2 = $listeClient3 = $listeClient4 = "";
 		//On valide le nom de la province
 		$controller = new ControleDataSecureController();
 		$name = $controller->getCleanNameGeography($name, 'region');
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On recherche l'id de la région
 		$idRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion($name);	
 		//Compte le nombre d'hébergement dans la région qui ont des salles corporatives
 		$listeclientSalle = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheListeSalleCorporativeActiveVille($idRegion[0]->getId());
 		//Pagination
 		$total = sizeof($listeclientSalle);
 		//On divise le nombre total de client par le nombre que l'on souhaite afficher.
 		$displaypage = ceil($total/$numberPaginate);
 		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
 		$page = $controller->getValideEntierPagination($page, $displaypage);
 		//Affiche la liste des salles corporatives de la région choisi avec la pagination
 		$listePaginate = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheListeSalleCorporativeActivePagination($idRegion[0]->getId(), $page, $numberPaginate);
 		//Affiche la région avec ses villes
 		//$region = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheListeSalleCorporativeActiveVille($idRegion[0]->getId());
 		//Recherche un client aléatoire
 		if(count($listePaginate) > 1){
 			$index = array_rand($listePaginate, 1);
 			$clientAleatoire = $listePaginate[$index];
 		}else{
 			$clientAleatoire = $listePaginate[0];
 		}
 		//On récupère le texte d'accueil
 		$texteSection = $em->getRepository("MyAppGlobalBundle:Texte_region_location_salle")->getRechercheTexteAccueil($idRegion[0]->getId());
                if($texteSection != null)
                {                    
                     $texte_accueil = html_entity_decode($texteSection[0]->getTexteFr());
                     $texte_accueil_en = html_entity_decode($texteSection[0]->getTexteEn());
                     $titleMetaEn = $titleMetaFr = $texteSection[0];                     
                     $specific = true;
                }
                else
                {
                    $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
                    $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();                 
                    $titleMetaFr = $texte_accueil[0];
                    $titleMetaEn = $texte_accueil_en[0];
                    $texte_accueil = html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']);
                    $texte_accueil_en = html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']);
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
                (new HebergementController)->generePersistSiteMap2('/location_salle_reunion_region_', '/meeting_room_rental_region_', $idRegion[0], $em);
 		//Listes nos suggestions 
 			if($listeclientSalle != null){
 				shuffle($listeclientSalle);
 				if(isset($listeclientSalle[0])){
 					$regionSugg1 = $listeclientSalle[0];
 					$tempClientSugg1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($listeclientSalle[0]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					//Retourne les chambres affaires et les salles corporatives
 					if(count($tempClientSugg1) > 1)
 					{
 						$clientSugg1 = array_rand($tempClientSugg1, 1);
 						$listeClient1 = $em->getRepository('MyAppGlobalBundle:Chambres')->getChambreEtTypeDeEtablissement($tempClientSugg1[$clientSugg1]->getSalleCorporativeHebergement()->getId());
 						$salleCorpo1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListSalleCorporative($tempClientSugg1[$clientSugg1]->getSalleCorporativeHebergement()->getId());
 						$forfaitAffaire1 = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsAffairesDuClient($tempClientSugg1[$clientSugg1]->getSalleCorporativeHebergement()->getId());
 						$regionSugg1 = "";
 						$regionSugg1 = $tempClientSugg1[$clientSugg1];
 					}else{
 						$listeClient1 = $em->getRepository('MyAppGlobalBundle:Chambres')->getChambreEtTypeDeEtablissement($tempClientSugg1[0]->getSalleCorporativeHebergement()->getId());
 						$salleCorpo1 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListSalleCorporative($tempClientSugg1[0]->getSalleCorporativeHebergement()->getId());
 						$forfaitAffaire1 = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsAffairesDuClient($tempClientSugg1[0]->getSalleCorporativeHebergement()->getId());
 						$regionSugg1 = "";
 						$regionSugg1 = $tempClientSugg1[0];
 					}
 				}if(isset($listeclientSalle[1])){
 					$regionSugg2 = $listeclientSalle[1];
 					$tempClientSugg2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($listeclientSalle[1]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					//Retourne les chambres affaires et les salles corporatives
 					if(count($tempClientSugg2) > 1)
 					{
 						$clientSugg2 = array_rand($tempClientSugg2, 1);
 						$listeClient2 = $em->getRepository('MyAppGlobalBundle:Chambres')->getChambreEtTypeDeEtablissement($tempClientSugg2[$clientSugg2]->getSalleCorporativeHebergement()->getId());
 						$salleCorpo2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListSalleCorporative($tempClientSugg2[$clientSugg2]->getSalleCorporativeHebergement()->getId());
 						$forfaitAffaire2 = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsAffairesDuClient($tempClientSugg2[$clientSugg2]->getSalleCorporativeHebergement()->getId());
 						$regionSugg2 = "";
 						$regionSugg2 = $tempClientSugg2[$clientSugg2];
 					}else{
 						$listeClient2 = $em->getRepository('MyAppGlobalBundle:Chambres')->getChambreEtTypeDeEtablissement($tempClientSugg2[0]->getSalleCorporativeHebergement()->getId());
 						$salleCorpo2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListSalleCorporative($tempClientSugg2[0]->getSalleCorporativeHebergement()->getId());
 						$forfaitAffaire2 = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsAffairesDuClient($tempClientSugg2[0]->getSalleCorporativeHebergement()->getId());
 						$regionSugg2 = "";
 						$regionSugg2 = $tempClientSugg2[0];
 					}
 				}if(isset($listeclientSalle[2])){
 					$regionSugg3 = $listeclientSalle[2];
 					$tempClientSugg3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($listeclientSalle[2]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					//Retourne les chambres affaires et les salles corporatives
 					if(count($tempClientSugg3) > 1)
 					{
 						$clientSugg3 = array_rand($tempClientSugg3, 1);
 						$listeClient3 = $em->getRepository('MyAppGlobalBundle:Chambres')->getChambreEtTypeDeEtablissement($tempClientSugg3[$clientSugg3]->getSalleCorporativeHebergement()->getId());
 						$salleCorpo3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListSalleCorporative($tempClientSugg3[$clientSugg3]->getSalleCorporativeHebergement()->getId());
 						$forfaitAffaire3 = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsAffairesDuClient($tempClientSugg3[$clientSugg3]->getSalleCorporativeHebergement()->getId());
 						$regionSugg3 = "";
 						$regionSugg3 = $tempClientSugg3[$clientSugg3];
 					}else{
 						$listeClient3 = $em->getRepository('MyAppGlobalBundle:Chambres')->getChambreEtTypeDeEtablissement($tempClientSugg3[0]->getSalleCorporativeHebergement()->getId());
 						$salleCorpo3 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListSalleCorporative($tempClientSugg3[0]->getSalleCorporativeHebergement()->getId());
 						$forfaitAffaire3 = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsAffairesDuClient($tempClientSugg3[0]->getSalleCorporativeHebergement()->getId());
 						$regionSugg3 = "";
 						$regionSugg3 = $tempClientSugg3[0];
 					}
 				}if(isset($listeclientSalle[3])){
 					$regionSugg4 = $listeclientSalle[3];
 					$tempClientSugg4 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAffiche5clientsSalleCorporativeMemeRegion($listeclientSalle[3]->getSalleCorporativeHebergement()->getRegionId()->getId());
 					//Retourne les chambres affaires et les salles corporatives
 					if(count($tempClientSugg4) > 1)
 					{
 						$clientSugg4 = array_rand($tempClientSugg4, 1);
 						$listeClient4 = $em->getRepository('MyAppGlobalBundle:Chambres')->getChambreEtTypeDeEtablissement($tempClientSugg4[$clientSugg4]->getSalleCorporativeHebergement()->getId());
 						$salleCorpo4 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListSalleCorporative($tempClientSugg4[$clientSugg4]->getSalleCorporativeHebergement()->getId());
 						$forfaitAffaire4 = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsAffairesDuClient($tempClientSugg4[$clientSugg4]->getSalleCorporativeHebergement()->getId());
 						$regionSugg4 = "";
 						$regionSugg4 = $tempClientSugg4[$clientSugg4];
 					}else{
 						$listeClient2 = $em->getRepository('MyAppGlobalBundle:Chambres')->getChambreEtTypeDeEtablissement($tempClientSugg4[0]->getSalleCorporativeHebergement()->getId());
 						$salleCorpo2 = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListSalleCorporative($tempClientSugg4[0]->getSalleCorporativeHebergement()->getId());
 						$forfaitAffaire2 = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsAffairesDuClient($tempClientSugg4[0]->getSalleCorporativeHebergement()->getId());
 						$regionSugg2 = "";
 						$regionSugg2 = $tempClientSugg2[0];
 					}
 				}
 			}
 		//Reservation en ligne
 		$reservationEnLigne = new DefaultController();
 		//Pays et provinces
 		$reservationEnLignePays = $reservationEnLigne->getReservationEnLignePays($em);
                $saison = $reservationEnLigne->getSaisonQuebec();
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view location_salle_reunion_region.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:location_salle_reunion_region.html.twig',
 				array(
 						'form' 				=> $form->createView(),
 						'corporatif' 			=> 'valid',
 						'insection' 			=> "inSection",
 						'listeclientSalle'		=> $listeclientSalle,
 						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'			=> $formEngine->createView(),
 						'listeClient'			=> $listClient,
 						'googledfp1'			=> "GR_CORPORATIF_01",
 						'googledfp2'			=> "GR_CORPORATIF_02",
                                                'googledfp3'			=> "GR_CORPORATIF_03",
 						'texte_accueilfr'		=> $texte_accueil,
						'texte_accueilen'		=> $texte_accueil_en,
 						'clientAleatoire'		=> $clientAleatoire,
 						'corposalleregion'              => true,
 						'urlcorpo'			=> 'corpo',
 						'views'				=> true,
 						'regionSugg1'                   => $regionSugg1,
 						'regionSugg2'                   => $regionSugg2,
 						'regionSugg3'                   => $regionSugg3,
 						'regionSugg4'                   => $regionSugg4,
 						'listeClient1'			=> $listeClient1,
 						'listeClient2'			=> $listeClient2,
 						'listeClient3'			=> $listeClient3,
 						'listeClient4'			=> $listeClient4,
 						'salleCorpo1'			=> $salleCorpo1,
 						'salleCorpo2'			=> $salleCorpo2,
 						'salleCorpo3'			=> $salleCorpo3,
 						'salleCorpo4'			=> $salleCorpo4,
 						'forfaitAffaire1'		=> $forfaitAffaire1,
 						'forfaitAffaire2'		=> $forfaitAffaire2,
 						'forfaitAffaire3'		=> $forfaitAffaire3,
 						'forfaitAffaire4'		=> $forfaitAffaire4,
 						'displaypage'			=> $displaypage,
 						'page'				=> $page,
 						'total'				=> $total,
 						'saison'			=> $saison,
 						'reservationPays'		=> $reservationEnLignePays[0],
 						'reservationProvince'           => $reservationEnLignePays[1],
 						'reservationRegionAjax'         => $reservationRegionAjax,
 						'reservationVilleAjax'          => $reservationVilleAjax,
                                                'metacorpogeneriqueen'          => $titleMetaEn,
                                                'metacorpogeneriquefr'          => $titleMetaFr,
                                                'specific'                      => $specific,
 		));
 	}
 	
 	/**
 	 * Affiche la liste des locations de salle de réunion pour la ville
 	 */
 	public function locationSalleReunionVilleAction($name, $page)
 	{
 		$numberPaginate = 10;
 		$reservationRegionAjax = $reservationVilleAjax = $forfaitAffaire1 = $forfaitAffaire2 = $forfaitAffaire3 = $forfaitAffaire4 = $salleCorpo1 = $salleCorpo2 = $salleCorpo3 = $salleCorpo4 = $regionSugg1 = $regionSugg2 = $regionSugg3 = $regionSugg4 = $listeClient1 = $listeClient2 = $listeClient3 = $listeClient4 = "";
 		//On valide le nom de la province
 		$controller = new ControleDataSecureController();
 		$name = $controller->getCleanNameGeography($name, 'name');
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On recherche l'id de la ville
 		$idVille = $em->getRepository('MyAppGlobalBundle:Villes')->getSearchTown($name);
 		//Compte le nombre d'hébergement dans la ville qui ont des salles corporatives
 		$listeclientSalle = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getCompteListeSalleCorporativeActiveVille($idVille[0]->getId());
 		//Pagination
 		$total = sizeof($listeclientSalle);
 		//On divise le nombre total de client par le nombre que l'on souhaite afficher.
 		$displaypage = ceil($total/$numberPaginate);
 		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
 		$page = $controller->getValideEntierPagination($page, $displaypage);
 		//Affiche la liste des salles corporatives de la région choisi avec la pagination
 		$listePaginate = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheListeSalleCorporativeActiveVillePagination($idVille[0]->getId(), $page, $numberPaginate);
 		//Recherche un client aléatoire
 		if(count($listePaginate) > 1){
 			$index = array_rand($listePaginate, 1);
 			$clientAleatoire = $listePaginate[$index];
 		}else{
 			$clientAleatoire = $listePaginate[0];
 		}
 		//On récupère le texte d'accueil
 		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();
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
                (new HebergementController)->generePersistSiteMap2('/location_salle_reunion_ville_', '/meeting_room_rental_city_', $idVille[0], $em);
 		//Reservation en ligne
 		$reservationEnLigne = new DefaultController();
 		//Pays et provinces
 		$reservationEnLignePays = $reservationEnLigne->getReservationEnLignePays($em);
                $saison = $reservationEnLigne->getSaisonQuebec();
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view location_salle_reunion_ville.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:location_salle_reunion_ville.html.twig',
 				array(
 						'form' 				=> $form->createView(),
 						'corporatif' 			=> 'valid',
 						'insection' 			=> "inSection",
 						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'			=> $formEngine->createView(),
 						'listeClient'			=> $listClient,
 						'googledfp1'			=> "GR_CORPORATIF_01",
 						'googledfp2'			=> "GR_CORPORATIF_02",
                                                'googledfp3'			=> "GR_CORPORATIF_03",
 						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']),
 						'clientAleatoire'		=> $clientAleatoire,
 						'corposalleville'               => true,
 						'urlcorpo'			=> 'corpo',
 						'views'				=> true,
 						'displaypage'			=> $displaypage,
 						'page'				=> $page,
 						'total'				=> $total,
 						'listeclientSalle'		=> $listeclientSalle,
 						'saison'			=> $saison,
 						'reservationPays'		=> $reservationEnLignePays[0],
 						'reservationProvince'           => $reservationEnLignePays[1],
 						'reservationRegionAjax'         => $reservationRegionAjax,
 						'reservationVilleAjax'          => $reservationVilleAjax,
                                                'metacorpoen'                   => $texte_accueil_en[0],
                                                'metacorpofr'                   => $texte_accueil[0],
 		));
 	}
 	
 	/**
 	 * Méthode pour les activités corporatives 
 	 */
 	public function corpoActiviteAction()
 	{
 		$reservationRegionAjax = $reservationVilleAjax = "";
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//On récupère le texte d'accueil
 		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();
 		//Affiche les régions qui ont des activités corporatives
 		$regionqc = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementProvince(9);
 		$regionon = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementProvince(8);
 		$regionnb = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementProvince(5);
 		//Stocke dans un tableau les résultats et nettoie les valeurs vides
 		$tab = [$regionqc, $regionon, $regionnb];
 		$tab = array_values(array_filter($tab));
 		shuffle($tab);
 		//Affiche un client aléatoire.
 		if(count($tab) > 1){
 			$aleatoire = array_rand($tab[0], 1);
 			$clientAleatoire = $tab[0][$aleatoire];
 		}else{
 			$clientAleatoire = $tab[0][0];
 		}
 		//Traitement pour afficher que seulement 4 suggestions 
 		//Régions
 		$tabContainer = $tabtemp = [];
 		if(sizeof($tab[0]) > 4)
 		{	
 			foreach($tab[0] as $tx){
 				array_push($tabtemp, $tx->getRegionId()->getId());
 			}
 			$tabContainer = array_rand($tabtemp, 4);
 		}else{  //Si on à pas plusieurs provinces on s'assure de prendre la province QC
 			if(sizeof($regionqc) > 4){
 				foreach($regionqc as $tw){
 					array_push($tabtemp, $tw->getRegionId()->getId());
 				}
 				$tabContainer = array_rand($tabtemp, 4);
 			}
 			else
 				foreach($regionqc as $tw){
 					array_push($tabtemp, $tw->getRegionId()->getId());
 				}
 				$tabContainer = $tabtemp;
 		}
 		//Recherche des clients pour les régions sélectionnées
 		$suggestionactivite1 = $suggestionactivite2 = $suggestionactivite3 = $suggestionactivite4 = "";
 		if(count($tabContainer) == 4){
 			$suggestionactivite1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[0]);
 			$suggestionactivite2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[1]);
 			$suggestionactivite3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[2]);
 			$suggestionactivite4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[3]);
 		}elseif(count($tabContainer) == 3){
 			$suggestionactivite1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[0]);
 			$suggestionactivite2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[1]);
 			$suggestionactivite3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[2]);
 		}elseif(count($tabContainer) == 2){
 			$suggestionactivite1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[0]);
 			$suggestionactivite2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[1]);
 		}else{
 			$suggestionactivite1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[0]);
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/activite_corporative.html', '/corporate_activities.html')); 
                //Titre lien Québec en saison
 		$controleDefault = new DefaultController();
 		$saison = $controleDefault->getSaisonQuebec();
 		//Pays et provinces réservation en ligne
 		$reservationEnLignePays = $controleDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view forfait_affaire.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:activite_corpo_groupe.html.twig',
 				array(
 						'form' 				=> $form->createView(),
 						'corporatif' 			=> 'valid',
 						'insection' 			=> "inSection",
 						'urlcorpo'			=> "corpo",
 						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']),
 						'regionqc'			=> $regionqc,
 						'regionon'			=> $regionon,
 						'regionnb'			=> $regionnb,
 						'views'				=> "activite_corpo",
 						'clientAleatoire'		=> $clientAleatoire,
 						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'			=> $formEngine->createView(),
 						'listeClient'			=> $listClient,
 						'googledfp1'			=> "GR_CORPORATIF_01",
 						'googledfp2'			=> "GR_CORPORATIF_02",
                                                'googledfp3'			=> "GR_CORPORATIF_03",
 						'saison'			=> $saison,
 						'reservationPays'		=> $reservationEnLignePays[0],
 						'reservationProvince'           => $reservationEnLignePays[1],
 						'reservationRegionAjax'         => $reservationRegionAjax,
 						'reservationVilleAjax'          => $reservationVilleAjax,
 						'activitecorpo'			=> true,
 						'suggestionactivite1'           => $suggestionactivite1,
 						'suggestionactivite2'           => $suggestionactivite2,
 						'suggestionactivite3'           => $suggestionactivite3,
 						'suggestionactivite4'           => $suggestionactivite4,
                                                'metacorpoen'                   => $texte_accueil_en[0],
                                                'metacorpofr'                   => $texte_accueil[0],
 		));
 	}
 	
 	/**
 	 * Méthode pour les activités corporatives avec une province
 	 */
 	public function corpoActiviteProvinceAction($name)
 	{
 		$specific = $reservationRegionAjax = $reservationVilleAjax = "";
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		$name = (new ControleDataSecureController)->getCleanNameGeography($name, 'province');
 		//On recherche l'id de la province avec son nom
 		$provinceId =  $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);
 		//On récupère le texte d'accueil
 		$texteSection = $em->getRepository("MyAppGlobalBundle:Texte_province_activite_corporative")->getRechercheTexteAccueil($provinceId[0]->getId());
                if($texteSection != null)
                {                    
                     $texte_accueil = html_entity_decode($texteSection[0]->getTexteFr());
                     $texte_accueil_en = html_entity_decode($texteSection[0]->getTexteEn());
                     $titleMetaEn = $titleMetaFr = $texteSection[0];                     
                     $specific = true;
                }
                else
                {
                    $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
                    $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();                
                    $titleMetaFr = $texte_accueil[0];
                    $titleMetaEn = $texte_accueil_en[0];
                    $texte_accueil = html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']);
                    $texte_accueil_en = html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']);
                }       
 		//Affiche les régions qui ont des activités corporatives
 		$region = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementProvince($provinceId[0]->getId());
 		//Affiche un client aléatoire.
 		if(count($region) > 1){
 			$aleatoire = array_rand($region, 1);
 			$clientAleatoire = $region[$aleatoire];
 		}else{
 			$clientAleatoire = $region[0];
 		}
 		//Traitement pour afficher que seulement 4 suggestions
 		//Régions
 		$tabContainer = $tabtemp = [];
 			if(sizeof($region) > 4){
 				foreach($region as $tw){
 					array_push($tabtemp, $tw->getRegionId()->getId());
 				}
 				$tabContainer = array_rand($tabtemp, 4);
 			}
 			else
 			foreach($region as $tw){
 				array_push($tabtemp, $tw->getRegionId()->getId());
 			}
 			$tabContainer = $tabtemp;
 		//Recherche des clients pour les régions sélectionnées
 		$suggestionactivite1 = $suggestionactivite2 = $suggestionactivite3 = $suggestionactivite4 = "";
 		if(count($tabContainer) == 4){
 			$suggestionactivite1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[0]);
 			$suggestionactivite2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[1]);
 			$suggestionactivite3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[2]);
 			$suggestionactivite4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[3]);
 		}elseif(count($tabContainer) == 3){
 			$suggestionactivite1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[0]);
 			$suggestionactivite2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[1]);
 			$suggestionactivite3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[2]);
 		}elseif(count($tabContainer) == 2){
 			$suggestionactivite1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[0]);
 			$suggestionactivite2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[1]);
 		}else{
 			$suggestionactivite1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionLimit4($tabContainer[0]);
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
                (new HebergementController)->generePersistSiteMap2('/activite_corporative_province_', '/corporate_activities_province_', $provinceId[0], $em);
 		$controleDefault = new DefaultController();
 		$saison = $controleDefault->getSaisonQuebec();
 		//Pays et provinces réservation en ligne
 		$reservationEnLignePays = $controleDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view forfait_affaire.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:activite_corpo_groupe_province.html.twig',
 				array(
 						'form' 				=> $form->createView(),
 						'corporatif' 			=> 'valid',
 						'insection' 			=> "inSection",
 						'urlcorpo'			=> "corpo",
 						'texte_accueilfr'		=> $texte_accueil,
						'texte_accueilen'		=> $texte_accueil_en,
 						'region'			=> $region,
 						'views'				=> "activite_corpo",
 						'clientAleatoire'		=> $clientAleatoire,
 						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'			=> $formEngine->createView(),
 						'listeClient'			=> $listClient,
 						'googledfp1'			=> "GR_CORPORATIF_01",
 						'googledfp2'			=> "GR_CORPORATIF_02",
                                                'googledfp3'			=> "GR_CORPORATIF_03",
 						'saison'			=> $saison,
 						'reservationPays'		=> $reservationEnLignePays[0],
 						'reservationProvince'           => $reservationEnLignePays[1],
 						'reservationRegionAjax'         => $reservationRegionAjax,
 						'reservationVilleAjax'          => $reservationVilleAjax,
 						'activitecorpoprovince'         => true,
 						'suggestionactivite1'           => $suggestionactivite1,
 						'suggestionactivite2'           => $suggestionactivite2,
 						'suggestionactivite3'           => $suggestionactivite3,
 						'suggestionactivite4'           => $suggestionactivite4,
                                                'metacorpogeneriqueen'          => $titleMetaEn,
                                                'metacorpogeneriquefr'          => $titleMetaFr,
                                                'specific'                      => $specific,
 		));
 	}
 	
 	/**
 	 * Méthode pour les activités corporatives avec une région
 	 */
 	public function corpoActiviteRegionAction($name, $page)
 	{
 		$numberPaginate = 10; //Nombre d'activité affiché
 		$specific = $reservationRegionAjax = $reservationVilleAjax = "";
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//Appel du controller pour la validation des données
 		$controller = new ControleDataSecureController();
 		$name = $controller->getCleanNameGeography($name, 'region');             
 		//On recherche l'id de la région avec son nom
 		$regionId =  $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion($name);
 		//On récupère le texte d'accueil
 		$texteSection = $em->getRepository("MyAppGlobalBundle:Texte_region_activite_corporative")->getRechercheTexteAccueil($regionId[0]->getId());
                if($texteSection != null)
                {                    
                     $texte_accueil = html_entity_decode($texteSection[0]->getTexteFr());
                     $texte_accueil_en = html_entity_decode($texteSection[0]->getTexteEn());
                     $titleMetaEn = $titleMetaFr = $texteSection[0];                     
                     $specific = true;
                }
                else
                {
                    $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
                    $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();                 
                    $titleMetaFr = $texte_accueil[0];
                    $titleMetaEn = $texte_accueil_en[0];
                    $texte_accueil = html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']);
                    $texte_accueil_en = html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']);
                }     
 		//Affiche la liste des activités corporatives pour la région
 		$region = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegion($regionId[0]->getId());
 		//Pagination
 		$total = sizeof($region);
 		//On divise le nombre total de client par le nombre que l'on souhaite afficher.
 		$displaypage = ceil($total/$numberPaginate);
 		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
 		$page = $controller->getValideEntierPagination($page, $displaypage);
 		//Retourne la liste des activitées corporatives avec la pagination
 		$listePaginate = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionPaginate($regionId[0]->getId(), $page, $numberPaginate);
 		//Affiche un client aléatoire.
 		if(count($region) > 1){
 			$aleatoire = array_rand($region, 1);
 			$clientAleatoire = $region[$aleatoire];
 		}else{
 			$clientAleatoire = $region[0];
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
                (new HebergementController)->generePersistSiteMap2('/activite_corporative_region_', '/corporate_activities_region_', $region[0], $em);
 		$controleDefault = new DefaultController();
 		$saison = $controleDefault->getSaisonQuebec();
 		//Pays et provinces réservation en ligne
 		$reservationEnLignePays = $controleDefault->getReservationEnLignePays($em);
 		//Liste des villes pour la région
 		$listeVille = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementRegionGroupByVille($regionId[0]->getId());
 		//Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
                //Préparation de la view forfait_affaire.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:activite_corpo_groupe_region.html.twig',
 				array(
 						'form' 				=> $form->createView(),
 						'corporatif' 			=> 'valid',
 						'insection' 			=> "inSection",
 						'urlcorpo'			=> "corpo",
 						'texte_accueilfr'		=> $texte_accueil,
						'texte_accueilen'		=> $texte_accueil_en, 						
 						'views'				=> "activite_corpo",
 						'clientAleatoire'		=> $clientAleatoire,
 						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'			=> $formEngine->createView(),
 						'listeClient'			=> $listClient,
 						'googledfp1'			=> "GR_CORPORATIF_01",
 						'googledfp2'			=> "GR_CORPORATIF_02",
                                                'googledfp3'			=> "GR_CORPORATIF_03",
 						'saison'			=> $saison,
 						'reservationPays'		=> $reservationEnLignePays[0],
 						'reservationProvince'           => $reservationEnLignePays[1],
 						'reservationRegionAjax'         => $reservationRegionAjax,
 						'reservationVilleAjax'          => $reservationVilleAjax,
 						'activitecorporegion'           => true,
 						'displaypage'			=> $displaypage,
 						'page'				=> $page,
 						'total'				=> $total,
 						'listePaginate'			=> $listePaginate,
 						'listeVille'			=> $listeVille,
                                                'metacorpogeneriqueen'          => $titleMetaEn,
                                                'metacorpogeneriquefr'          => $titleMetaFr,
                                                'specific'                      => $specific,
 		));
 	}
 	
 	/**
 	 * Méthode pour les activités corporatives avec une ville
 	 */
 	public function corpoActiviteVilleAction($name, $page)
 	{
 		$numberPaginate = 10; //Nombre d'activité affiché
 		$reservationRegionAjax = $reservationVilleAjax = "";
 		//Gestionnaire des entités
 		$em = $this->getDoctrine()->getEntityManager();
 		//Appel du controller pour la validation des données
 		$controller = new ControleDataSecureController();
 		$name = $controller->getCleanNameGeography($name, 'name');
 		//On recherche l'id de la ville avec son nom
 		$villeId =  $em->getRepository('MyAppGlobalBundle:Villes')->getSearchTown($name);
 		//On récupère le texte d'accueil
 		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatif();
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilCorporatifen();
 		//Affiche la liste des activités corporatives pour la ville
 		$ville = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementVille($villeId[0]->getId());
 		//Pagination
 		$total = sizeof($ville);
 		//On divise le nombre total de client par le nombre que l'on souhaite afficher.
 		$displaypage = ceil($total/$numberPaginate);
 		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
 		$page = $controller->getValideEntierPagination($page, $displaypage);
 		//Retourne la liste des activitées corporatives avec la pagination
 		$listePaginate = $em->getRepository('MyAppGlobalBundle:Hebergements')->getActivitesHebergementVillePaginate($villeId[0]->getId(), $page, $numberPaginate);
 		//Affiche un client aléatoire.
 		if(count($ville) > 1){
 			$aleatoire = array_rand($ville, 1);
 			$clientAleatoire = $ville[$aleatoire];
 		}else{
 			$clientAleatoire = $ville[0];
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
                (new HebergementController)->generePersistSiteMap2('/activite_corporative_ville_', '/corporate_activities_city_', $ville[0], $em);
 		$controleDefault = new DefaultController();
 		$saison = $controleDefault->getSaisonQuebec();
 		//Pays et provinces réservation en ligne
 		$reservationEnLignePays = $controleDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
 		//Préparation de la view forfait_affaire.html.twig
 		return $this->render('MyAppGlobalBundle:Corpo_&_events:activite_corpo_groupe_ville.html.twig',
 				array(
 						'form' 				=> $form->createView(),
 						'corporatif' 			=> 'valid',
 						'insection' 			=> "inSection",
 						'urlcorpo'			=> "corpo",
 						'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_corporatif_fr']),
						'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_corporatif_en']),
 						//'region'			=> $region,
 						'views'				=> "activite_corpo",
 						'clientAleatoire'		=> $clientAleatoire,
 						'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
						'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
						'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
 						'formEngine'			=> $formEngine->createView(),
 						'listeClient'			=> $listClient,
 						'googledfp1'			=> "GR_CORPORATIF_01",
 						'googledfp2'			=> "GR_CORPORATIF_02",
                                                'googledfp3'			=> "GR_CORPORATIF_03",
 						'saison'			=> $saison,
 						'reservationPays'		=> $reservationEnLignePays[0],
 						'reservationProvince'           => $reservationEnLignePays[1],
 						'reservationRegionAjax'         => $reservationRegionAjax,
 						'reservationVilleAjax'          => $reservationVilleAjax,
 						'activitecorpoville'            => true,
 						'displaypage'			=> $displaypage,
 						'page'				=> $page,
 						'total'				=> $total,
 						'listePaginate'			=> $listePaginate,
                                                'metacorpoen'                   => $texte_accueil_en[0],
                                                'metacorpofr'                   => $texte_accueil[0],
 		));
 	}
                	 	
 }