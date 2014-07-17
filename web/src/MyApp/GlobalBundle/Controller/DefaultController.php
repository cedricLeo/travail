<?php
namespace MyApp\GlobalBundle\Controller;
use MyApp\AdminBundle\Forms\SearchMoteurEnginePortailType;
use MyApp\GlobalBundle\Entity\Formu_province_region;
use MyApp\GlobalBundle\Form\GoogleForm;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use Berriart\Bundle\SitemapBundle\Entity\ImageUrl;
use MyApp\GlobalBundle\Entity\Utilisateur;
use Symfony\Component\Form\FormFactory;
use MyApp\GlobalBundle\Form\NewLetterForm;
use MyApp\GlobalBundle\Entity\Inscription_newletter;


/**
 * 
 * @author leonardc
 * 
 * Classe pour la section accueil coté client
 */
class DefaultController extends Controller{
	
	/**
	 * Méthode pour remplacer les indexs des tableaux qui ne sont pas correctes
	 */
	private function orderKeyByAsc($tablo)
	{
		if(count($tablo) == 1)
		{
			if(!isset($tablo[0]))
			{
				if(isset($tablo[1]))
				{
					$tablo[0] = $tablo[1];
					unset($tablo[1]);
				}
				if(isset($tablo[2]))
				{
					$tablo[0] = $tablo[2];
					unset($tablo[2]);
				}
			}
		}
		if(count($tablo) == 2)
		{
			if(!isset($tablo[0]))
			{
				$tablo[0] = $tablo[1];
				$tablo[1] = $tablo[2];
				unset($tablo[2]);
			}
			if(!isset($tablo[1]))
			{
				$tablo[1] = $tablo[2];
				unset($tablo[2]);
			}
		}
		return $tablo;
	}
	
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
	public function getMoteurRechercheAction($word, $em)
	{
                $tab = ["<?php>", "<php", "<?", "?>", "<script>", "</script>", "select", "SELECT", "INSERT", "insert", "UPDATE", "update", "DELETE", "delete", "root", "*", "%", ";", "{", "}", "[", "]", "$", ">", "<"];
		$word = str_replace($tab, "", $word);  
		if($word != null){
                    echo $word;
                    //Hébergement
                    $rep = $em->getRepository('MyAppGlobalBundle:Hebergements')->getRechercheNomHebergement($word);        
                    if($rep != null)
                    {
                        $tab = [$rep, "hebergement"];
                        return $tab;
                    }                   
                    //Si c'est pas un hébergement on regarde dans les attraits
                    /*if($rep == null)
                    {
                            $rep = $em->getRepository('MyAppGlobalBundle:Attraits')->getRechercheAttrait($word);
                            if($rep != null){
                                $tab = [$rep, "attrait"];
                                return $tab;
                            }
                    }*/
                }else{
                    //Sinon on retourne un valeur null
                    return $word;
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
        
        public function getSearcheCaractereSpeciauxSiteMap()
        {
            return ["é", "è", "ô", "î", "ç", "û", "ê", "â", "ï", "à", "(", ")", "l'", "À", "È", "L'"];
        }
        
        public function getReplaceCaractereSpeciauxSiteMap()
        {
            return ["e", "e", "o", "i", "c", "u", "e", "a", "i", "a", "", "", "l_", "a", "e", "l_"];
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
            //Retourne la liste des critères pour la recherche
           // $listeCritere = $this->afficheRechercheAffineeAction();
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
                    //'critereRecherche'          => $listeCritere,
                   // 'nbCritere'                 => sizeof($listeCritere),
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
                  //  'critereRecherche'          => $listeCritere,
                  //  'nbCritere'                 => sizeof($listeCritere),
                ));
            }
        }
        
        /**
         * Affiche la recherche plus affinée        
         */
        public function afficheRechercheAffineeAction()
        {
            //Gestionnaire d'entity
            $em = $this->getDoctrine()->getEntityManager();
            //Retourne la liste des options
            return $em->getRepository("MyAppGlobalBundle:Styles_hebergements")->getListStyleHebergement();
            
        }
	
	/**
	 * Méthode pour la gestion de la page d'accueil du portail
	 */
	public function indexAction()
	{
		$courrielExiste = $reservationRegionAjax = $reservationVilleAjax = $listeSuggestion = $regionlisteqc = $regionlisteon = $regionlistenb = $liste1Suggestion = $liste2Suggestion= $liste3Suggestion = $regionSugg1 = $regionSugg2 = $regionSugg3 = "";
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	               
		//On récupère les textes d'accueil
                $texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilPortail();
                $texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueilPortailen();
		//Affiche les informations pour les provinces	
		$provinceqc = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheProvinceAccueil(9);
		$provinceon = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheProvinceAccueil(8);
		$provincenb = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheProvinceAccueil(5);
		//Affiche les informations pour les régions		
                $regionlisteqc = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheRegionAccueil($provinceqc[0]->getProvinceId()->getId());
                $regionlisteon = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheRegionAccueil($provinceon[0]->getProvinceId()->getId());
                $regionlistenb = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheRegionAccueil($provincenb[0]->getProvinceId()->getId());		
		//Récupère la liste des id qui sont de categorie_hebergement = hôtels et de la province QC
		$listHebergementQc = $em->getRepository('MyAppGlobalBundle:Hebergements')->getSelectAllHebergementProvince(9, 7);
		$tabloRegion = array();
		//On stocke les id des regions dans un tableau que l'on brasse
		foreach($listHebergementQc as $tri)
		{
                    array_push($tabloRegion, $tri->getRegionId()->getId());
		}
		shuffle($tabloRegion);
		//On retourne 4 id de region
		$controleNumber = new ControleDataSecureController();
		$idRegion = $controleNumber->getGenere4ClientsPourNosSuggestions($tabloRegion);	
		shuffle($idRegion);		
		//Affiches les 4 régions pour les suggestions hébergements (colonne de gauche)
		$displayRegionLeft1 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[0]);
		$displayRegionLeft2 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[1]);
		$displayRegionLeft3 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[2]);
		$displayRegionLeft4 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[3]);
		//Retourne une liste de client pour les suggestions hébergements
		$listClientLeft1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[0]);
		$listClientLeft2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[1]);
		$listClientLeft3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[2]);
		$listClientLeft4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[3]);
		//Retourne 4 id uniques de région
		$idRegion = $controleNumber->getGenere4ClientsPourNosSuggestions($tabloRegion);
		shuffle($idRegion);
		//Affiche les 4 régions (bas de page)
		$displaySuggestionBottom1 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[0]);
		$displaySuggestionBottom2 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[1]);
		$displaySuggestionBottom3 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[2]);
		$displaySuggestionBottom4 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[3]);
		//Retourne la liste des clients dans les suggestions dans le bas de la page
		$listClientBottom1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[0]);
		$listClientBottom2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[1]);
		$listClientBottom3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[2]);
		$listClientBottom4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[3]);
		//Retourne le nombre d'hébergement qui ont la catégorie hôtel (id = 7) pour cette région
		$searchCatHeb1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[0]);		
		$searchCatHeb2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[1]);
		$searchCatHeb3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[2]);
		$searchCatHeb4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[3]);
		($searchCatHeb1[0]["nbhr"] != null)? $nombreHotelRegion1 = $searchCatHeb1[0]["nbhr"]: $nombreHotelRegion1 = null;
		($searchCatHeb2[0]["nbhr"] != null)? $nombreHotelRegion2 = $searchCatHeb2[0]["nbhr"]: $nombreHotelRegion2 = null;
		($searchCatHeb3[0]["nbhr"] != null)? $nombreHotelRegion3 = $searchCatHeb3[0]["nbhr"]: $nombreHotelRegion3 = null;
		($searchCatHeb4[0]["nbhr"] != null)? $nombreHotelRegion4 = $searchCatHeb4[0]["nbhr"]: $nombreHotelRegion4 = null;
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//Liste tous les forfaits valides 
		$listforfait = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValide();	
		//Génère les liste de suggestions
		if(count($listforfait) >= 3){
			$retourSuggestion = (new ForfaitsController)->genereSuggestionForfaits($listforfait, $em);
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
                (new HebergementController)->getValideUrlSiteMap($em, array('/accueil.html', '/home.html'));   
                //Titre lien Québec eb saisons
		$saison = $this->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $this->getReservationEnLignePays($em);
		//Formulaire pour la new letter
		$listeNewLetter = new Inscription_newletter();
		$formNewLetter = $this->container->get('form.factory')->create(new NewLetterForm(), $listeNewLetter);
		$request = $this->get('request');
		if( $request->getMethod() == 'POST' ){
			// On fait le lien Requête <-> Formulaire.
			$formNewLetter->bindRequest($request);
			$emailNewLetter = $formNewLetter->getData()->getCourriel();
			if($emailNewLetter != null)
			{
                            htmlentities($emailNewLetter);
                            htmlspecialchars($emailNewLetter);
                            //Recherche l'adresse si elle existe déjà dans la table
                            $emailExiste = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRechercheAdresseCourriel($emailNewLetter);
                            if($emailExiste == null){
                                $em->persist($listeNewLetter);
                                $listeNewLetter->setDateCreated(new \DateTime('now'));
                                $em->flush();
                                $courrielExiste = true;
                            }
			}
		}
                //Liste des régions pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);                
                //
                $categorieHebergement = $em->getRepository("MyAppGlobalBundle:Categories_hebergements")->getRechercheCategorieHebergementParId(7);
                //Retourne la langue
                $lang = $this->container->get("session")->getLocale();    
                if($lang == "fr"){
                    //Préparation de la view index-fr.html.twig
                    return $this->render('MyAppGlobalBundle:Default:index-fr.html.twig', 
                        array(	'provinceqc' 				=> $provinceqc, 
                                'provinceon' 				=> $provinceon, 
                                'provincenb' 				=> $provincenb, 
                                'regionqc' 				=> $regionlisteqc, 
                                'regionon' 				=> $regionlisteon, 
                                'regionnb' 				=> $regionlistenb, 
                                'insection' 				=> "inSection", 
                                'accueil' 				=> 'valid',
                                'home'                                  => 'Accueil',
                                'suggestion1' 				=> $displaySuggestionBottom1,
                                'suggestion2'                           => $displaySuggestionBottom2,		// Nos suggestions bas de page
                                'suggestion3' 				=> $displaySuggestionBottom3,
                                'suggestion4' 				=> $displaySuggestionBottom4,
                                'displayregionLeft1'                    => $displayRegionLeft1,
                                'displayregionLeft2'                    => $displayRegionLeft2,				// Suggestions hébergements colonne de gauche
                                'displayregionLeft3'                    => $displayRegionLeft3,
                                'displayregionLeft4'                    => $displayRegionLeft4,
                                'listClientGauche1'			=> $listClientLeft1,
                                'listClientGauche2'			=> $listClientLeft2,
                                'listClientGauche3'			=> $listClientLeft3,
                                'listClientGauche4'			=> $listClientLeft4,
                                'form'					=> $form->createView(),
                                'nbHebergement1'			=> $nombreHotelRegion1,			    // Nombre d'hôtel par région
                                'nbHebergement2'			=> $nombreHotelRegion2,
                                'nbHebergement3'			=> $nombreHotelRegion3,
                                'nbHebergement4'			=> $nombreHotelRegion4,
                                'listClientBottom1'                     => $listClientBottom1,				// Liste de client pour les suggestion en bas de la  page
                                'listClientBottom2'                     => $listClientBottom2,
                                'listClientBottom3'                     => $listClientBottom3,
                                'listClientBottom4'                     => $listClientBottom4,             
                                'texte_accueilfr'			=> html_entity_decode($texte_accueil[0]['texte_accueil_fr']),
                                'formEngine'				=> $formEngine->createView(),
                                'listeClient'				=> $listClient,                                       
                                'listeClient1'				=> $liste1Suggestion, 				// Liste des clients suggestions de forfaits colonne de gauche
                                'listeClient2'				=> $liste2Suggestion,
                                'listeClient3'				=> $liste3Suggestion,
                                'googledfp1'				=> "GR_ACCUEIL_01",
                                'googledfp2'				=> "GR_ACCUEIL_02",
                                'googledfp3'				=> "GR_ACCUEIL_03",
                                'saison'				=> $saison,
                                'reservationRegionAjax'                 => $reservationRegionAjax,
                                'reservationVilleAjax'                  => $reservationVilleAjax,
                                'reservationPays'			=> $reservationEnLignePays[0],
                                'reservationProvince'                   => $reservationEnLignePays[1],
                                'formNewLetter'				=> $formNewLetter->createView(),
                                'courrielExiste'			=> $courrielExiste,
                                'metaaccueilfr'                         => $texte_accueil[0],
                                'metaaccueilen'                         => $texte_accueil_en[0],
                                'categorie'                             => $categorieHebergement[0],
                                'main'                                  => true,                               
                        ));
                }else{
                    //Préparation de la view index-en.html.twig
                    return $this->render('MyAppGlobalBundle:Default:index-en.html.twig', 
                        array(	'provinceqc' 				=> $provinceqc, 
                                'provinceon' 				=> $provinceon, 
                                'provincenb' 				=> $provincenb, 
                                'regionqc' 				=> $regionlisteqc, 
                                'regionon' 				=> $regionlisteon, 
                                'regionnb' 				=> $regionlistenb, 
                                'insection' 				=> "inSection", 
                                'accueil' 				=> 'valid',
                                'home'                                  => 'Accueil',
                                'suggestion1' 				=> $displaySuggestionBottom1,
                                'suggestion2'                           => $displaySuggestionBottom2,		// Nos suggestions bas de page
                                'suggestion3' 				=> $displaySuggestionBottom3,
                                'suggestion4' 				=> $displaySuggestionBottom4,
                                'displayregionLeft1'                    => $displayRegionLeft1,
                                'displayregionLeft2'                    => $displayRegionLeft2,				// Suggestions hébergements colonne de gauche
                                'displayregionLeft3'                    => $displayRegionLeft3,
                                'displayregionLeft4'                    => $displayRegionLeft4,
                                'listClientGauche1'			=> $listClientLeft1,
                                'listClientGauche2'			=> $listClientLeft2,
                                'listClientGauche3'			=> $listClientLeft3,
                                'listClientGauche4'			=> $listClientLeft4,
                                'form'					=> $form->createView(),
                                'nbHebergement1'			=> $nombreHotelRegion1,			    // Nombre d'hôtel par région
                                'nbHebergement2'			=> $nombreHotelRegion2,
                                'nbHebergement3'			=> $nombreHotelRegion3,
                                'nbHebergement4'			=> $nombreHotelRegion4,
                                'listClientBottom1'                     => $listClientBottom1,				// Liste de client pour les suggestion en bas de la  page
                                'listClientBottom2'                     => $listClientBottom2,
                                'listClientBottom3'                     => $listClientBottom3,
                                'listClientBottom4'                     => $listClientBottom4,                                            
                                'texte_accueilen'			=> html_entity_decode($texte_accueil_en[0]['texte_accueil_en']),
                                'formEngine'				=> $formEngine->createView(),
                                'listeClient'				=> $listClient,                                       
                                'listeClient1'				=> $liste1Suggestion, 				// Liste des clients suggestions de forfaits colonne de gauche
                                'listeClient2'				=> $liste2Suggestion,
                                'listeClient3'				=> $liste3Suggestion,
                                'googledfp1'				=> "GR_ACCUEIL_01",
                                'googledfp2'				=> "GR_ACCUEIL_02",
                                'googledfp3'				=> "GR_ACCUEIL_03",
                                'saison'				=> $saison,
                                'reservationRegionAjax'                 => $reservationRegionAjax,
                                'reservationVilleAjax'                  => $reservationVilleAjax,
                                'reservationPays'			=> $reservationEnLignePays[0],
                                'reservationProvince'                   => $reservationEnLignePays[1],
                                'formNewLetter'				=> $formNewLetter->createView(),
                                'courrielExiste'			=> $courrielExiste,
                                'metaaccueilfr'                         => $texte_accueil[0],
                                'metaaccueilen'                         => $texte_accueil_en[0],
                                'categorie'                             => $categorieHebergement[0],
                                'main'                                  => true,
                        ));
                }
	}               
	
	/**
	 * Affiche la page des provinces pour la section accueil
	 */
	public function showprovinceAction($name)
	{
		$listClientBottom2 = $listClientBottom3 = $listClientBottom4 = $searchCatHeb1 = $searchCatHeb2 = $searchCatHeb3 = $searchCatHeb4 = $listClientLeft2 = $listClientLeft3 = $listClientLeft4 = $displayRegionLeft2 = $displayRegionLeft3 = $displayRegionLeft4 = $displaySuggestionBottom2 = $displaySuggestionBottom3 = $displaySuggestionBottom4 = $courrielExiste = $reservationRegionAjax = $reservationVilleAjax = $listeSuggestion = $regionlisteqc = $regionlisteon = $regionlistenb = $liste1Suggestion = $liste2Suggestion= $liste3Suggestion = $regionSugg1 = $regionSugg2 = $regionSugg3 = "";
		//On néttoie l'argument
                $controleNumber = new ControleDataSecureController();
		$name = $controleNumber->getCleanNameGeography($name, "province");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On recherche l'id de la province par son nom
		$idProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getSearchIdByName($name);      
		//Affiche les informations pour les régions
		$regionliste = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheRegionAccueil($idProvince[0]->getId());
		//Récupère la liste des id qui sont de categorie_hebergement = hôtels et de la province 
		$listHebergementQc = $em->getRepository('MyAppGlobalBundle:Hebergements')->getSelectAllHebergementProvince($idProvince[0]->getId(), 7);
                $tabloRegion = array();
		//On stocke les id des regions dans un tableau que l'on brasse
		foreach($listHebergementQc as $tri)
		{
			array_push($tabloRegion, $tri->getRegionId()->getId());
		}
		shuffle($tabloRegion);
		//On retourne 4 id de region
		$idRegion = $controleNumber->getGenere4ClientsPourNosSuggestions($tabloRegion);
		shuffle($idRegion);
		//Affiches les 4 régions pour les suggestions hébergements (colonne de gauche)
		$displayRegionLeft1 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[0]);
                if(count($idRegion) >= 2)
                    $displayRegionLeft2 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[1]);
                if(count($idRegion) >= 3)
                    $displayRegionLeft3 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[2]);
                if(count($idRegion) >= 4)
                    $displayRegionLeft4 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[3]);
		//Retourne une liste de client pour les suggestions hébergements
		$listClientLeft1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[0]);
                if(count($idRegion) >= 2)
                    $listClientLeft2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[1]);
                if(count($idRegion) >= 3)
                    $listClientLeft3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[2]);
                if(count($idRegion) >= 4)
                    $listClientLeft4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[3]);
		//Retourne 4 id uniques de région
		$idRegion = $controleNumber->getGenere4ClientsPourNosSuggestions($tabloRegion);
		shuffle($idRegion);
		//Affiche les 4 régions (bas de page)
		$displaySuggestionBottom1 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[0]);
                if(count($idRegion) >= 2){
                    $displaySuggestionBottom2 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[1]);
                }if(count($idRegion) >= 3){
                    $displaySuggestionBottom3 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[2]);
                }if(count($idRegion) >= 4){
                    $displaySuggestionBottom4 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[3]);
                }
		//Retourne la liste des clients dans les suggestions dans le bas de la page
		$listClientBottom1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[0]);
                if(count($idRegion) >= 2)
                    $listClientBottom2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[1]);
                if(count($idRegion) >= 3)
                    $listClientBottom3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[2]);
                if(count($idRegion) >= 4)
                    $listClientBottom4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[3]);
		//Retourne le nombre d'hébergement qui ont la catégorie hôtel (id = 7) pour cette région
		$searchCatHeb1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[0]);
                ($searchCatHeb1 != null)? $searchCatHeb1 = $searchCatHeb1[0]['nbhr'] : $searchCatHeb1 ;
                if(count($idRegion) >= 2){
                    $searchCatHeb2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[1]);
                    ($searchCatHeb2 != null)? $searchCatHeb2 = $searchCatHeb2[0]['nbhr'] : $searchCatHeb2 ;
                }if(count($idRegion) >= 3){
                    $searchCatHeb3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[2]);
                    ($searchCatHeb3 != null)? $searchCatHeb3 = $searchCatHeb3[0]['nbhr'] : $searchCatHeb3 ;
                }if(count($idRegion) >= 4){
                    $searchCatHeb4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[3]);	
                    ($searchCatHeb4 != null)? $searchCatHeb4 = $searchCatHeb4[0]['nbhr'] : $searchCatHeb4 ;
                }
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//Liste tous les forfaits valides
		$listforfait = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValide();
		//Génère les liste de suggestions
		if(count($listforfait) > 3){
			$retourSuggestion = (new ForfaitsController)->genereSuggestionForfaits($listforfait, $em);
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
                    return (new HebergementController)->getSimuleGoogleSearch($retourEngine);
                }
		//Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/accueil_province_'.strtolower($idProvince[0]->getRepertoireFr()).'.html', '/home_province_'.strtolower($idProvince[0]->getRepertoireEn()).'.html'));  
                //Titre lien Québec en saisons
		$saison = $this->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $this->getReservationEnLignePays($em);
		//Formulaire pour la new letter
		$listeNewLetter = new Inscription_newletter();
		$formNewLetter = $this->container->get('form.factory')->create(new NewLetterForm(), $listeNewLetter);
		//On récupère la requête.
		$request = $this->get('request');
		//On regarde si elle est de type post
		if( $request->getMethod() == 'POST' ){
			// On fait le lien Requête <-> Formulaire.
			$formNewLetter->bindRequest($request);
			$emailNewLetter = $formNewLetter->getData()->getCourriel();
			if($emailNewLetter != null)
			{
				$emailNewLetter = filter_input(INPUT_POST, 'courriel', FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
				htmlentities($emailNewLetter);
				//Recherche l'adresse si elle existe déjà dans la table
				$emailExiste = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRechercheAdresseCourriel($emailNewLetter);
				if($emailExiste == null){
					$em->persist($listeNewLetter);
					$listeNewLetter->setDateCreated(new \DateTime('now'));
					$em->flush();
					$courrielExiste = true;
				}else{
					$courrielExiste = $emailExiste;
				}
			}
		}
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
                //
                $categorieHebergement = $em->getRepository("MyAppGlobalBundle:Categories_hebergements")->getRechercheCategorieHebergementParId(7);
		//Retourne la langue
                $lang = $this->container->get("session")->getLocale();
                if($lang == "fr"){
                    //Préparation de la view indexProvince-fr.html.twig
                    return $this->render('MyAppGlobalBundle:Default:indexProvince-fr.html.twig',
			  array(    'province' 				=> $idProvince[0],
                                    'region' 				=> $regionliste,
                                    'insection' 			=> "inSection",
                                    'accueil' 				=> 'valid',
                                    'home' 				=> 'Accueil',
                                    'provinceHome'			=> true,
                                    'suggestion1' 			=> $displaySuggestionBottom1,
                                    'suggestion2'                       => $displaySuggestionBottom2,		// Nos suggestions bas de page
                                    'suggestion3' 			=> $displaySuggestionBottom3,
                                    'suggestion4' 			=> $displaySuggestionBottom4,
                                    'displayregionLeft1'                => $displayRegionLeft1,
                                    'displayregionLeft2'                => $displayRegionLeft2,				// Suggestions hébergements colonne de gauche
                                    'displayregionLeft3'                => $displayRegionLeft3,
                                    'displayregionLeft4'                => $displayRegionLeft4,
                                    'listClientGauche1'			=> $listClientLeft1,
                                    'listClientGauche2'			=> $listClientLeft2,
                                    'listClientGauche3'			=> $listClientLeft3,
                                    'listClientGauche4'			=> $listClientLeft4,
                                    'form'				=> $form->createView(),
                                    'nbHebergement1'			=> $searchCatHeb1,		// Nombre d'hôtel par région
                                    'nbHebergement2'			=> $searchCatHeb2,
                                    'nbHebergement3'			=> $searchCatHeb3,
                                    'nbHebergement4'			=> $searchCatHeb4,
                                    'listClientBottom1'                 => $listClientBottom1,				// Liste de client pour les suggestion en bas de la  page
                                    'listClientBottom2'                 => $listClientBottom2,
                                    'listClientBottom3'                 => $listClientBottom3,
                                    'listClientBottom4'                 => $listClientBottom4,
                                    'texte_accueilfr'			=> html_entity_decode($idProvince[0]->getTexteAccueilFr()),                
                                    'formEngine'			=> $formEngine->createView(),
                                    'listeClient'			=> $listClient,
                                    'regionSuggestion1'			=> $regionSugg1,					// Titre de régions pour les suggestions de forfaits colonne de gauche
                                    'regionSuggestion2'			=> $regionSugg2,
                                    'regionSuggestion3'			=> $regionSugg3,
                                    'listeClient1'			=> $liste1Suggestion, 				// Liste des clients suggestions de forfaits colonne de gauche
                                    'listeClient2'			=> $liste2Suggestion,
                                    'listeClient3'                      => $liste3Suggestion,
                                    'provinceOrthographe'               => true,
                                    'views'				=> $name,
                                    'urlaccueil'			=> true,
                                    'titleProvince'                     => true,
                                    'googledfp1'			=> "GR_ACCUEIL_01",
                                    'googledfp2'			=> "GR_ACCUEIL_02",
                                    'googledfp3'			=> "GR_ACCUEIL_03",
                                    'listeSuggestion'			=> $listeSuggestion,
                                    'saison'                            => $saison,
                                    'reservationRegionAjax'             => $reservationRegionAjax,
                                    'reservationVilleAjax'              => $reservationVilleAjax,
                                    'reservationPays'			=> $reservationEnLignePays[0],
                                    'reservationProvince'               => $reservationEnLignePays[1],
                                    'formNewLetter'                     => $formNewLetter->createView(),
                                    'courrielExiste'			=> $courrielExiste,
                                    'metaaccueilprov'                   => $idProvince[0],
                                    'categorie'                         => $categorieHebergement[0],
                    ));
                }else{
                    //Préparation de la view indexProvince-en.html.twig
                    return $this->render('MyAppGlobalBundle:Default:indexProvince-en.html.twig',
			  array(    'province' 				=> $idProvince[0],
                                    'region' 				=> $regionliste,
                                    'insection' 			=> "inSection",
                                    'accueil' 				=> 'valid',
                                    'home' 				=> 'Accueil',
                                    'provinceHome'			=> true,
                                    'suggestion1' 			=> $displaySuggestionBottom1,
                                    'suggestion2'                       => $displaySuggestionBottom2,		// Nos suggestions bas de page
                                    'suggestion3' 			=> $displaySuggestionBottom3,
                                    'suggestion4' 			=> $displaySuggestionBottom4,
                                    'displayregionLeft1'                => $displayRegionLeft1,
                                    'displayregionLeft2'                => $displayRegionLeft2,				// Suggestions hébergements colonne de gauche
                                    'displayregionLeft3'                => $displayRegionLeft3,
                                    'displayregionLeft4'                => $displayRegionLeft4,
                                    'listClientGauche1'			=> $listClientLeft1,
                                    'listClientGauche2'			=> $listClientLeft2,
                                    'listClientGauche3'			=> $listClientLeft3,
                                    'listClientGauche4'			=> $listClientLeft4,
                                    'form'				=> $form->createView(),
                                    'nbHebergement1'			=> $searchCatHeb1,		// Nombre d'hôtel par région
                                    'nbHebergement2'			=> $searchCatHeb2,
                                    'nbHebergement3'			=> $searchCatHeb3,
                                    'nbHebergement4'			=> $searchCatHeb4,
                                    'listClientBottom1'                 => $listClientBottom1,				// Liste de client pour les suggestion en bas de la  page
                                    'listClientBottom2'                 => $listClientBottom2,
                                    'listClientBottom3'                 => $listClientBottom3,
                                    'listClientBottom4'                 => $listClientBottom4,
                                    'texte_accueilen'			=> html_entity_decode($idProvince[0]->getTexteAccueilEn()),
                                    'formEngine'			=> $formEngine->createView(),
                                    'listeClient'			=> $listClient,
                                    'regionSuggestion1'			=> $regionSugg1,					// Titre de régions pour les suggestions de forfaits colonne de gauche
                                    'regionSuggestion2'			=> $regionSugg2,
                                    'regionSuggestion3'			=> $regionSugg3,
                                    'listeClient1'			=> $liste1Suggestion, 				// Liste des clients suggestions de forfaits colonne de gauche
                                    'listeClient2'			=> $liste2Suggestion,
                                    'listeClient3'                      => $liste3Suggestion,
                                    'provinceOrthographe'               => true,
                                    'views'				=> $name,
                                    'urlaccueil'			=> true,
                                    'titleProvince'                     => true,
                                    'googledfp1'			=> "GR_ACCUEIL_01",
                                    'googledfp2'			=> "GR_ACCUEIL_02",
                                    'googledfp3'			=> "GR_ACCUEIL_03",
                                    'listeSuggestion'			=> $listeSuggestion,
                                    'saison'                            => $saison,
                                    'reservationRegionAjax'             => $reservationRegionAjax,
                                    'reservationVilleAjax'              => $reservationVilleAjax,
                                    'reservationPays'			=> $reservationEnLignePays[0],
                                    'reservationProvince'               => $reservationEnLignePays[1],
                                    'formNewLetter'                     => $formNewLetter->createView(),
                                    'courrielExiste'			=> $courrielExiste,
                                    'metaaccueilprov'                   => $idProvince[0],
                                    'categorie'                         => $categorieHebergement[0],
                    ));
                }
	}
	
	
	/**
	 * Affiche la page des régions pour la section accueil
	 */
	public function showregionAction($name)
	{
		$listClientBottom2 = $listClientBottom3 = $listClientBottom4 = $listClientLeft2 = $listClientLeft3 = $listClientLeft4 = $displayRegionLeft2 = $displayRegionLeft3 = $displayRegionLeft4 = $displaySuggestionBottom2 = $displaySuggestionBottom3 = $displaySuggestionBottom4 = $searchCatHeb1 = $searchCatHeb2 = $searchCatHeb3 = $searchCatHeb4 = $courrielExiste = $reservationRegionAjax = $reservationVilleAjax = $listeSuggestion = $regionlisteqc = $regionlisteon = $regionlistenb = $liste1Suggestion = $liste2Suggestion= $liste3Suggestion = $regionSugg1 = $regionSugg2 = $regionSugg3 = "";
		//On néttoie l'argument
                $controleNumber = new ControleDataSecureController();
		$name = $controleNumber->getCleanNameGeography($name, "region");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On recherche l'id de la région par son nom
		$idRegionHome = $em->getRepository('MyAppGlobalBundle:Regions')->getNameSearchRegion($name);
		//Récupère la liste des id qui sont de categorie_hebergement = hôtels et de la province QC
		$listHebergementQc = $em->getRepository('MyAppGlobalBundle:Hebergements')->getSelectAllHebergementProvince($idRegionHome[0]->getProvinceEtatId()->getId(), 7);
		$tabloRegion = array();
		//On stocke les id des regions dans un tableau que l'on brasse
		foreach($listHebergementQc as $tri)
		{
			array_push($tabloRegion, $tri->getRegionId()->getId());
		}
		shuffle($tabloRegion);
		//On retourne 4 id de region
		$idRegion = $controleNumber->getGenere4ClientsPourNosSuggestions($tabloRegion);
		shuffle($idRegion);
		//Affiches les 4 régions pour les suggestions hébergements (colonne de gauche)
		$displayRegionLeft1 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[0]);
                if(count($idRegion) >= 2)
                    $displayRegionLeft2 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[1]);
                if(count($idRegion) >= 3)
                    $displayRegionLeft3 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[2]);
                if(count($idRegion) >= 4)
                    $displayRegionLeft4 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[3]);
		//Retourne une liste de client pour les suggestions hébergements
		$listClientLeft1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[0]);
                if(count($idRegion) >= 2)
                    $listClientLeft2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[1]);
                if(count($idRegion) >= 3)
                    $listClientLeft3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[2]);
                if(count($idRegion) >= 4)
                    $listClientLeft4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[3]);
		//Retourne 4 id uniques de région
		$idRegion = $controleNumber->getGenere4ClientsPourNosSuggestions($tabloRegion);
		shuffle($idRegion);
		//Affiche les 4 régions (bas de page)
		$displaySuggestionBottom1 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[0]);
                if(count($idRegion) >= 2)
                    $displaySuggestionBottom2 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[1]);
                if(count($idRegion) >= 3)
                    $displaySuggestionBottom3 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[2]);
                if(count($idRegion) >= 4)
                    $displaySuggestionBottom4 = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionAleatoire($idRegion[3]);
		//Retourne la liste des clients dans les suggestions dans le bas de la page
		$listClientBottom1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[0]);
                if(count($idRegion) >= 2)
                    $listClientBottom2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[1]);
                if(count($idRegion) >= 3)
                    $listClientBottom3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[2]);
                if(count($idRegion) >= 4)
                    $listClientBottom4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheListeClient($idRegion[3]);
		//Retourne le nombre d'hébergement qui ont la catégorie hôtel (id = 7) pour cette région
		$searchCatHeb1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[0]);
                ($searchCatHeb1 != null)? $searchCatHeb1 = $searchCatHeb1[0]['nbhr'] : $searchCatHeb1 ;
                if(count($idRegion) >= 2){
                    $searchCatHeb2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[1]);
                    ($searchCatHeb2 != null)? $searchCatHeb2 = $searchCatHeb2[0]['nbhr'] : $searchCatHeb2 ;
                }
                if(count($idRegion) >= 3){
                    $searchCatHeb3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[2]);
                    ($searchCatHeb3 != null)? $searchCatHeb3 = $searchCatHeb3[0]['nbhr'] : $searchCatHeb3 ;
                }
                if(count($idRegion) >= 4){
                    $searchCatHeb4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCountNbIdHebergementByRegion(7, $idRegion[3]);
                    ($searchCatHeb4 != null)? $searchCatHeb4 = $searchCatHeb4[0]['nbhr'] : $searchCatHeb4 ;
                }
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//Liste tous les forfaits valides
		$listforfait = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValide();	
		//Génère les liste de suggestions
		if(count($listforfait) > 3){
			$retourSuggestion = (new ForfaitsController)->genereSuggestionForfaits($listforfait, $em);
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
                    return (new HebergementController)->getSimuleGoogleSearch($retourEngine);
                }
		//Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/accueil_region_'.strtolower($idRegionHome[0]->getRepertoireFr()).'.html', '/home_region_'.strtolower($idRegionHome[0]->getRepertoireEn()).'.html'));  
                //Titre lien Québec en saisons
		$saison = $this->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $this->getReservationEnLignePays($em);
		//Formulaire pour la new letter
		$listeNewLetter = new Inscription_newletter();
		$formNewLetter = $this->container->get('form.factory')->create(new NewLetterForm(), $listeNewLetter);
		//On récupère la requête.
		$request = $this->get('request');
		//On regarde si elle est de type post
		if( $request->getMethod() == 'POST' ){
			// On fait le lien Requête <-> Formulaire.
			$formNewLetter->bindRequest($request);
			$emailNewLetter = $formNewLetter->getData()->getCourriel();
			if($emailNewLetter != null)
			{
				$emailNewLetter = filter_input(INPUT_POST, 'courriel', FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
				htmlentities($emailNewLetter);
				//Recherche l'adresse si elle existe déjà dans la table
				$emailExiste = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRechercheAdresseCourriel($emailNewLetter);
				if($emailExiste == null){
					$em->persist($listeNewLetter);
					$listeNewLetter->setDateCreated(new \DateTime('now'));
					$em->flush();
					$courrielExiste = true;
				}else{
					$courrielExiste = $emailExiste;
				}
			}
		}
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
                //
                $categorieHebergement = $em->getRepository("MyAppGlobalBundle:Categories_hebergements")->getRechercheCategorieHebergementParId(7);
		//Préparation de la view indexRegion.html.twig
		return $this->render('MyAppGlobalBundle:Default:indexRegion.html.twig',
				array(	
                                        'region' 				=> $idRegionHome[0],
                                        'insection' 				=> "inSection",
                                        'accueil' 				=> 'valid',
                                        'home' 					=> 'Accueil',
                                        'suggestion1' 				=> $displaySuggestionBottom1,
                                        'suggestion2'                           => $displaySuggestionBottom2,	// Nos suggestions bas de page
                                        'suggestion3' 				=> $displaySuggestionBottom3,
                                        'suggestion4' 				=> $displaySuggestionBottom4,
                                        'displayregionLeft1'                    => $displayRegionLeft1,
                                        'displayregionLeft2'                    => $displayRegionLeft2,	// Suggestions hébergements colonne de gauche
                                        'displayregionLeft3'                    => $displayRegionLeft3,
                                        'displayregionLeft4'                    => $displayRegionLeft4,
                                        'listClientGauche1'			=> $listClientLeft1,
                                        'listClientGauche2'			=> $listClientLeft2,
                                        'listClientGauche3'			=> $listClientLeft3,
                                        'listClientGauche4'			=> $listClientLeft4,
                                        'form'                                  => $form->createView(),
                                        'nbHebergement1'			=> $searchCatHeb1,  // Nombre d'hôtel par région
                                        'nbHebergement2'			=> $searchCatHeb2,
                                        'nbHebergement3'			=> $searchCatHeb3,
                                        'nbHebergement4'			=> $searchCatHeb4,
                                        'listClientBottom1'                     => $listClientBottom1,	// Liste de client pour les suggestion en bas de la  page
                                        'listClientBottom2'                     => $listClientBottom2,
                                        'listClientBottom3'                     => $listClientBottom3,
                                        'listClientBottom4'                     => $listClientBottom4,
                                        'texte_accueilfr'			=> html_entity_decode($idRegionHome[0]->getResumeFrTravel()),
                                        'texte_accueilen'			=> html_entity_decode($idRegionHome[0]->getResumeEnTravel()),
                                        'formEngine'				=> $formEngine->createView(),
                                        'listeClient'				=> $listClient,
                                        'regionSuggestion1'			=> $regionSugg1,    //Titre de régions pour les suggestions de forfaits colonne de gauche
                                        'regionSuggestion2'			=> $regionSugg2,
                                        'regionSuggestion3'			=> $regionSugg3,
                                        'listeClient1'				=> $liste1Suggestion, 	// liste des clients suggestions de forfaits colonne de gauche
                                        'listeClient2'				=> $liste2Suggestion,
                                        'listeClient3'				=> $liste3Suggestion,
                                        'regionOrthographe'			=> true,
                                        'views'					=> $name,
                                        'arborecense'				=> true,
                                        'urlaccueil'				=> true,
                                        'titleRegion'                           => true,
                                        'googledfp1'				=> "GR_ACCUEIL_01",
                                        'googledfp2'				=> "GR_ACCUEIL_02",
                                        'googledfp3'				=> "GR_ACCUEIL_03",
                                        'listeSuggestion'			=> $listeSuggestion,
                                        'saison'				=> $saison,
                                        'reservationRegionAjax'                 => $reservationRegionAjax,
                                        'reservationVilleAjax'                  => $reservationVilleAjax,
                                        'reservationPays'			=> $reservationEnLignePays[0],
                                        'reservationProvince'                   => $reservationEnLignePays[1],
                                        'formNewLetter'				=> $formNewLetter->createView(),
                                        'courrielExiste'			=> $courrielExiste,
                                        'metaaccueilprov'                       => $idRegionHome[0],
                                        'categorie'                             => $categorieHebergement[0],
		));
	}
	
	/**
	 * Méthode pour ignitialiser la variable pour la langue
	 */
	public function choisirLangueClientAction($langue )
	{
		if($langue != null)
		{
			// On enregistre la langue en session
			$this->container->get('session')->setLocale($langue);
		}
		//On redirige vers la même page mais traduite dans la langue choisie.
		$url = $this->container->get('request')->headers->get('referer');
		//$url = $this->container->get('request')->server->get("PATH_TRANSLATED");
		if(empty($url))
		{
			$url = $this->container->get('router')->generate("_accueil");
		}
		return new RedirectResponse($url);
	}
	
	/**
	 * Méthode pour le formulaire de reservation en ligne liste les pays
	 */
	public function getReservationEnLignePays($em){
		//Liste des pays reservit
		$reservationPays = $em->getRepository('MyAppGlobalBundle:Pays')->getRetourneListePaysReservit();
		//Liste des provinces
		$reservationProvince = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getRetourneListeProvinceReservit($reservationPays[0]['id']);
		return $tab = [$reservationPays, $reservationProvince];
	}
	
	/**
	 * Méthode pour déterminer la saison du quebecensaison
	 */
	public function getSaisonQuebec()
	{
		//saison pour le Québec en saison
		if(date('m') == 02 and date('d') > 20 or date('m') <= 04 and date('d') <= 30 or date('m') <= 05 and date('d') <= 19 ){
				$saison = ["printemps ".date('Y'), "spring ".date('Y')];
		}elseif(date('m') == 05 and date('d') > 20 or date('m') <= 07 and date('d') <= 31 or date('m') <= 08 and date('d') <= 19){
				$saison = ["été ".date('Y'), "summer ".date('Y')];
		}elseif(date('m') == 08 and date('d') > 20 or date('m') <= 10 and date('d') <= 31 or date('m') <= 11 and date('d') <= 19){
				$saison = ["automne ".date('Y'), "fall ".date('Y')];
		}elseif(date('m') == 11 and date('d') > 20 or date('m') <= 12 and date('d') <= 31 or date('m') == 01 and date('d') <= 31 or date('m') <= 02 and date('d') <= 19){
				$saison = ["hiver ".date('Y'), "winter ".date('Y')];
		}
		return $saison;
	}
	
	/**
	 * Méthode pour le traitement ajax du formulaire de reservation en ligne du portail (région)
	 */
	public function getReservationEnLigneAjaxPortailRegion($em, $request)
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$reservationRegion = '';
			$reservationRegion = $request->request->get('reservationregion');
			if($reservationRegion != ''){
				$reservationRegionAjax = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheRegionsCoteClient($reservationRegion);
				return $this->render('MyAppGlobalBundle:Corpo_&_events:reservationregion.xml.twig', array( 'reservationRegionAjax'	=> $reservationRegionAjax));
			}
		}
	}
	
	
	public function getReservationEnLigneAjaxPortailVille($em, $request)
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$reservationVille = '';
			$reservationVille = $request->request->get('reservationville');
			if($reservationVille != ''){
				$reservationVilleAjax = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheRegionsCoteClientGroupByRegion($reservationVille);
				return $this->render('MyAppGlobalBundle:Corpo_&_events:reservationville.xml.twig', array( 'reservationVilleAjax'	=> $reservationVilleAjax));
			}
		}
	}
	
	/**
	 * Affichera la page pour si on pas aucun item dans cette section (exemple aucuns forfait présentement)
	 */
	public function demandeSansItemAction($section)
	{
		$centre = $attraits = $forfaits = $corporatif = $destination = $restaurant = $reservationRegionAjax = $reservationVilleAjax = "";
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//On récupère le texte d'accueil
		switch($section){		
			case "sante":
				$txtfr = "sante";
				$txten = "sante_en";
				$menuIsValid = "centre";
                                $centre = true;
				break;
			case "attrait":
				$txtfr = "attrait";
				$txten = "attrait_en";
                                $attraits = true;
				break;
			case "forfait":
				$txtfr = "forfait";
				$txten = "forfait_en";
                                $forfaits = true;
				break;
			case "promotion":
				$txtfr = "promotion";
				$txten = "promotion_en";
                                $destination = true;
				break;
			case "restaurant":
				$txtfr = "restaurant";
				$txten = "restaurant_en";
                                $restaurant = true;
				break;
			case "corporatif":
				$txtfr = "corporatif";
				$txten = "corporatif_en";
                                $corporatif = true;
				break;
		}
		$texte_accueil = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil($txtfr);
		$texte_accueil_en = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getListTexteAccueil($txten);
		//Formulaire de recherche map intéractive
		$search = new Formu_province_region();
		$form = $this->container->get('form.factory')->create(new GoogleForm(), $search);
		//Autocompletion pour le moteur de recherche
		$listClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutocompletionPortail();
		//Moteur de reecherche
		$retourEngine = $this->getRechercheMoteurDeRecherche();
		if($retourEngine[0] == "form")
		{
			$formEngine = $retourEngine[1];
		}
		$saison = $this->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $this->getReservationEnLignePays($em);
		//View du rendu
		return $this->render("MyAppGlobalBundle:Centre_sante_&_spas:Template_vide.html.twig", array(
				'googledfp1'			=> "GR_SANTE_01",
				'googledfp2'			=> "GR_SANTE_02",
                                'googledfp3'			=> "GR_SANTE_03",
				'saison'			=> $saison,
				'reservationRegionAjax'         => $reservationRegionAjax,
				'reservationVilleAjax'          => $reservationVilleAjax,
				'reservationPays'		=> $reservationEnLignePays[0],
				'reservationProvince'           => $reservationEnLignePays[1],
				'formEngine'			=> $formEngine->createView(),
				'listeClient'			=> $listClient,
				'texte_accueilfr'		=> html_entity_decode($texte_accueil[0]['texte_accueil_'.$txtfr.'_fr']),
				'texte_accueilen'		=> html_entity_decode($texte_accueil_en[0]['texte_accueil_'.$txten]),
				'form' 				=> $form->createView(),
				'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
				'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
				'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
				'insection' 			=> "inSection",
                                'sansItem'                      => true,
                                'titrefrsansitem'               => $texte_accueil[0]['titre_'.$section.'_fr'],
				'titreensansitem'               => $texte_accueil_en[0]['titre_'.$section.'_en'],
                                'metadescriptionfr'             => $texte_accueil[0]['texte_accueil_'.$section.'_meta_fr'],
                                'metadescriptionen'             => $texte_accueil_en[0]['texte_accueil_'.$section.'_meta_en'],
                                'centre'                        => $centre,
                                'attraits'                      => $attraits,
                                'forfaits'                      => $forfaits,
                                'destination'                   => $destination,
                                'restaurant'                    => $restaurant,
                                'corporatif'                    => $corporatif,
		));
	}
	
}
