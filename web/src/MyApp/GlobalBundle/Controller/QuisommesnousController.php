<?php
namespace MyApp\GlobalBundle\Controller;
use Doctrine\ORM\Query\AST\Functions\SubstringFunction;
use MyApp\AdminBundle\Forms\SearchMoteurEnginePortailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use Berriart\Bundle\SitemapBundle\Entity\ImageUrl;
use Symfony\Component\Locale\Stub\DateFormat\SecondTransformer;
use MyApp\GlobalBundle\Controller\DefaultController;
use MyApp\GlobalBundle\Entity\Utilisateur;

/**
 * 
 * @author leonardc
 *
 */
class QuisommesnousController extends Controller{	       
        	
	
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
	 * Page qui sommes nous
	 */
	public function indexAction()
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/qui_sommes_nous.html', '/about_us.html'));
                //Titre lien QUébec en saison
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
                $texteFr = "Global Réservation est une compagnie québécoise qui a été créée en 2001. Notre mission étant de faciliter la recherche d'un établissement d'hébergement au Québec et au Canada pour les voyageurs.";
		$texteEn = "Global Réservation is a company from Quebec which was created in 2001. Our mission is to help travellers who are looking for accommodation in Quebec and Canada.";
                //traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		return $this->container->get('templating')->renderResponse('MyAppGlobalBundle:Qui_sommes_nous:quisommesnous.html.twig', 
                    array(  'pageStatic' 		=> true,	
                            'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                            'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                            'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                            'quisommesnous'	 	=> true,
                            'googledfp1'		=> "GR_HEBERGEMENT_01",
                            'googledfp2'		=> "GR_HEBERGEMENT_02",
                            'googledfp3'		=> "GR_HEBERGEMENT_03",
                            'saison'			=> $saison,
                            'reservationRegionAjax'   	=> $reservationRegionAjax,
                            'reservationVilleAjax'	=> $reservationVilleAjax,
                            'reservationPays'		=> $reservationEnLignePays[0],
                            'reservationProvince'	=> $reservationEnLignePays[1],
                            'titlefr'                   => "Qui sommes-nous",
                            'titleen'                   => $texteFr,
                            'metafr'                    => "Conditions d'utilisation du site",
                            'metaen'                    => $texteEn,
                    ));
	}
	
	/**
	 * Page FAQ
	 */
	public function faqAction()
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/faq.html'));
                //Titre du Québec en saison
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		return $this->container->get('templating')->renderResponse('MyAppGlobalBundle:Qui_sommes_nous:faq.html.twig', 
                    array(	'pageStatic' 	 		=> true,	
                                'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                'faq'				=> true,
                                'googledfp1'			=> "GR_HEBERGEMENT_01",
                                'googledfp2'			=> "GR_HEBERGEMENT_02",
                                'googledfp3'			=> "GR_HEBERGEMENT_03",
                                'saison'			=> $saison,
                                'reservationRegionAjax'   	=> $reservationRegionAjax,
                                'reservationVilleAjax'		=> $reservationVilleAjax,
                                'reservationPays'		=> $reservationEnLignePays[0],
                                'reservationProvince'		=> $reservationEnLignePays[1],
                                'titlefr'                       => "FAQ",
                                'titleen'                       => "FAQ",
                                'metafr'                        => "FAQ",
                                'metaen'                        => "FAQ",
                    ));
	}
	
	/**
	 * Page contactez nous
	 */
	public function contacteznousAction()
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/contactez_nous.html', '/contact_us.html'));
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
		//Préparation de la view Qui_sommes_nous:contacteznous.html.twig
		return $this->container->get('templating')->renderResponse('MyAppGlobalBundle:Qui_sommes_nous:contacteznous.html.twig',
                        array(	'pageStatic' 	 		=> true,
                                'regionQcFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                'regionOnFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                'regionNbFooter'		=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                'contacteznous'	 		=> true,
                                'emailAdministration'		=> 'ventes@global-reservation.com',
                                'emailInfo'			=> 'info@global-reservation.com',
                                'emailReservation'	    	=> 'reservation@global-reservation.com',
                                'googledfp1'			=> "GR_HEBERGEMENT_01",
                                'googledfp2'			=> "GR_HEBERGEMENT_02",
                                'googledfp3'			=> "GR_HEBERGEMENT_03",
                                'saison'			=> $saison,
                                'reservationRegionAjax'   	=> $reservationRegionAjax,
                                'reservationVilleAjax'		=> $reservationVilleAjax,
                                'reservationPays'		=> $reservationEnLignePays[0],
                                'reservationProvince'		=> $reservationEnLignePays[1],
                                'titlefr'                       => "Contactez-nous",
                                'titleen'                       => "Contact us",
                                'metafr'                        => "Contactez-nous",
                                'metaen'                        => "Contact us",
                        ));
	}
	
	/**
	 * Page du plan du site pour un humain
	 */
	public function plandusiteAction()
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Récupère la langue 
		$lang = $this->container->get('session')->getLocale();
		$accueilProvince = $accueilRegion = $hebergementProvince = $hebergementRegion = $forfaitProvince = $forfaitRegion = $corporatifProvince = $corporatifRegion = $centreSanteProvince = $centreSanteRegion = $attraitProvince = $attraitRegion = $promotionProvince = $promotionRegion = $restaurantProvince = $restaurantRegion = "";
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//######### ACCUEIL #########
		//On récupère la liste des urls de l'accueil pour monter le plan du site
		$tab = [['accueil_province'],['home_province']];
		$tab2 = [['accueil_region'], ['home_region']];
		//On regarde si on a bien des provinces pour la section accueil
		$accueil = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab);
		//On regarde si on a bien des régions pour la section accueil
		$accueil2 = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab2);
		$tab = $tab2 = "";
		if($accueil != null)
		{
			$accueilProvince = [];
			foreach($accueil as $tx)
			{
				foreach($tx as $tw)
				{
					if( $lang == "fr"){
						$firstCoupure = substr($tw['loc'], 18, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 15, -1);
					}
					$strlength = strlen($firstCoupure);
					$province = ['loc' => $tw['loc'], 'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($accueilProvince, $province);
				}
			}
		}
		if($accueil2 != null)
		{
			$accueilRegion = [];
			foreach($accueil2 as $tx)
			{
				foreach($tx as $tw)
				{
					if( $lang == "fr"){
						$firstCoupure = substr($tw['loc'], 16, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 13, -1);
					}
					$strlength = strlen($firstCoupure);
					$region = ['loc' => $tw['loc'],'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($accueilRegion, $region);
				}
			}
		}
		//######### HÉBERGEMENTS ##########
		//On récupère la liste des urls de l'hébergement pour monter le plan du site
		$tab = [['hebergements_province'],['accommodation_province']];
		$tab2 = [['hebergements_region'], ['accommodation_region']];
		//$tab = [['hebergements_province', 'hebergements_region'], ['accommodation_province', 'accommodation_region']];
		//On regarde si on a des provinces pour les hébergements
		$hebergement = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab);
		//On regarde si on a des régions pour les hébergements
		$hebergement2 = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab2);
		$tab = $tab2 = "";
		//On regarde si on a bien des provinces et des régions
		if($hebergement != null)
		{
			$hebergementProvince = [];
			foreach($hebergement as $tx)
			{
				foreach($tx as $tw)
				{
					if($lang == "fr"){
						$firstCoupure = substr($tw['loc'], 23, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 24, -1);
					}
					$strlength = strlen($firstCoupure);
					$province = ['loc' => $tw['loc'], 'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($hebergementProvince, $province);
				}
			}
		}
		if($hebergement2 != null)
		{
			$hebergementRegion = [];
			foreach($hebergement2 as $tx)
			{
				foreach($tx as $tw)
				{
					if($lang == "fr"){
						$firstCoupure = substr($tw['loc'], 21, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 22, -1);
					}
					$strlength = strlen($firstCoupure);
					$region = ['loc' => $tw['loc'],'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($hebergementRegion, $region);
				}
			}
		}
		//######### FORFAITS ##########
		//On récupère la liste des urls de forfait pour monter le plan du site
		$tab = [['forfaits_province'], ['packages_province']];
		$tab2 = [['forfaits_region'], ['packages_region']];
		//On regarde si on des provinces pour les forfaits
		$forfait = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab);
		//On regarde si on a des régions pour les forfaits
		$forfait2 = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab2);
		$tab = $tab2 = "";
		if($forfait != null)
		{
			$forfaitProvince = [];
			foreach($forfait as $tx)
			{
				foreach($tx as $tw)
				{
					$firstCoupure = substr($tw['loc'], 19, -1);
					$strlength = strlen($firstCoupure);
					$province = ['loc' => $tw['loc'], 'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($forfaitProvince, $province);
				}
			}
		}
		if($forfait2 != null)
		{
			$forfaitRegion = [];
			foreach($forfait2 as $tx)
			{
				foreach($tx as $tw)
				{
					$firstCoupure = substr($tw['loc'], 17, -1);
					$strlength = strlen($firstCoupure);
					$region = ['loc' => $tw['loc'],'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($forfaitRegion, $region);
				}
			}
		}
		//######### CORPORATIF ##########
		//On récupère la liste des urls de corporatif pour monter le plan du site
		$tab = [['corporatif_evenements_province'], ['corporate_events_province']];
		$tab2 = [['corporatif_evenements_region'], ['corporate_events_region']];
		//On regarde si on a des provinces pour les corporatifs
		$corporatif = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab);
		//on regarde si on a des régions pour les corporatifs
		$corporatif2 = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab2);
		$tab = $tab2 = "";
		if($corporatif != null)
		{
			$corporatifProvince = [];
			foreach($corporatif as $tx)
			{
				foreach($tx as $tw)
				{
					if($lang == "fr"){
						$firstCoupure = substr($tw['loc'], 32, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 27, -1);
					}
					$strlength = strlen($firstCoupure);
					$province = ['loc' => $tw['loc'], 'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($corporatifProvince, $province);
				}
			}
		}
		if($corporatif2 != null)
		{
			$corporatifRegion = [];
			foreach($corporatif2 as $tx)
			{
				foreach($tx as $tw)
				{
					if($lang == "fr"){
						$firstCoupure = substr($tw['loc'], 30, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 25, -1);
					}
					$strlength = strlen($firstCoupure);
					$region = ['loc' => $tw['loc'],'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($corporatifRegion, $region);
				}
			}
		}
		//######### CENTRES DE SANTÉ #########
		//On récupère la liste des urls de centre de santé pour monter le plan du site
		$tab = [['centres_sante_spas_province'], ['health_centers_spas_province']];
		$tab2 = [['centres_sante_spas_region'], ['health_centers_spas_region']];
		//On regarde si on des provinces pour les centres de santé
		$centreSante = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab);
		//On regarde si on des régions pour les centres de santé
		$centreSante2 = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab2);
		$tab = $tab2 = "";
		if($centreSante != null)
		{
			$centreSanteProvince = [];
			foreach($centreSante as $tx)
			{
				foreach($tx as $tw)
				{
					if($lang == "fr"){
						$firstCoupure = substr($tw['loc'], 29, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 30, -1);
					}
					$strlength = strlen($firstCoupure);
					$province = ['loc' => $tw['loc'], 'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($centreSanteProvince, $province);
				}
			}
		}
		if($centreSante2 != null)
		{
			$centreSanteRegion = [];
			foreach($centreSante2 as $tx)
			{
				foreach($tx as $tw)
				{
					if($lang == "fr"){
						$firstCoupure = substr($tw['loc'], 27, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 28, -1);
					}
					$strlength = strlen($firstCoupure);
					$region = ['loc' => $tw['loc'],'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($centreSanteRegion, $region);
				}
			}
		}
		//######### ATTRAITS #########
		//On récupère la liste des urls d'attrait pour monter le plan du site
		$tab = [['attraits_activites_province'], ['activities_attractions_province']];
		$tab2 = [['attraits_activites_region'], ['activities_attractions_region']];
		//On regarde sin on des provinces pour les attraits
		$attrait = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab);
		//On regarde si on des régions pour les attraits
		$attrait2 = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab2);
		$tab = $tab2 = "";
		if($attrait != null)
		{
			$attraitProvince = [];
			foreach($attrait as $tx)
			{
				foreach($tx as $tw)
				{
					if($lang == "fr"){
						$firstCoupure = substr($tw['loc'], 29, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 33, -1);
					}
					$strlength = strlen($firstCoupure);
					$province = ['loc' => $tw['loc'], 'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($attraitProvince, $province);
				}
			}
		}
		if($attrait2 != null)
		{
			$attraitRegion = [];
			foreach($attrait2 as $tx)
			{
				foreach($tx as $tw)
				{
					if($lang == "fr"){
						$firstCoupure = substr($tw['loc'], 27, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 27, -1);
					}
					$strlength = strlen($firstCoupure);
					$region = ['loc' => $tw['loc'],'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($attraitRegion, $region);
				}
			}
		}
		//######### PROMOTIONS ##########
		//On récupère la liste des urls de promotion pour monter le plan du site
		$tab = [['tarifs_derniere_minute_et_promotions_province'], ['last_minute_rates_and_promotions_province']];
		$tab2 = [['tarifs_derniere_minute_et_promotions_region'], [ 'last_minute_rates_and_promotions_region']];
		//On regarde si on des provinces pour les promotions
		$promotion = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab);
		//On regarde si on des régions pour les promotions
		$promotion2 = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab2);
		$tab = $tab2 = "";
		if($promotion != null)
		{
			$promotionProvince = [];
			foreach($promotion as $tx)
			{
				foreach($tx as $tw)
				{
					if($lang == "fr"){
						$firstCoupure = substr($tw['loc'], 47, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 43, -1);
					}
					$strlength = strlen($firstCoupure);
					$province = ['loc' => $tw['loc'], 'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($promotionProvince, $province);
				}
			}
		}
		if($promotion2 != null)
		{
			$promotionRegion = [];
			foreach($promotion2 as $tx)
			{
				foreach($tx as $tw)
				{
					if($lang == "fr"){
						$firstCoupure = substr($tw['loc'], 45, -1);
					}else{
						$firstCoupure = substr($tw['loc'], 41, -1);
					}
					$strlength = strlen($firstCoupure);
					$region = ['loc' => $tw['loc'],'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($promotionRegion, $region);
				}
			}
		}
		//######### RESTAURANTS #########
		//On récupère la liste des urls de restaurant pour monter le plan du site
		$tab = [['restaurants_province'], ['restaurants_province']];
		$tab2 = [['restaurants_region'], ['restaurants_region']];
		//On regarde si on des provinces pour les restaurants
		$restaurant = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab);
		//On regarde si on des régions pour les restaurants
		$restaurant2 = $em->getRepository('MyAppGlobalBundle:Acomptes')->triUrlPourLaLangue($lang, $tab2);
		if($lang  == "en"){
			//Liste des nom des régions en FR
			$regionLang = $em->getRepository('MyAppGlobalBundle:Regions')->getListeNomUneSeuleLangue("fr");
		}else{
			//Liste des nom des régions en EN
			$regionLang = $em->getRepository('MyAppGlobalBundle:Regions')->getListeNomUneSeuleLangue("en");
		}
		$tab = $tab2 = "";
		if($restaurant != null)
		{
			$restaurantProvince = [];
			foreach($restaurant as $tx)
			{
				foreach($tx as $tw)
				{
					$firstCoupure = substr($tw['loc'], 22, -1);
					$strlength = strlen($firstCoupure);
					$province = ['loc' => $tw['loc'], 'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($restaurantProvince, $province);
				}
			}
		}
		if($restaurant2 != null)
		{
			$restaurantRegion = [];
			foreach($restaurant2 as $tx)
			{
				foreach($tx as $tw)
				{
					//if(substr($tw['loc'], 20, -5) );
					$firstCoupure = substr($tw['loc'], 20, -1);
					$strlength = strlen($firstCoupure);
					$region = ['loc' => $tw['loc'],'coupure' => substr($firstCoupure, 0, $strlength - 4)];
					array_push($restaurantRegion, $region);
				}
			}
		}
		//Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/plan.html'));
                //Titre du lien QUébec en saison
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                //Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
		return $this->container->get('templating')->renderResponse('MyAppGlobalBundle:Qui_sommes_nous:plandusite.html.twig',
				array(	'pageStatic' 	 			=> true,
                                        'regionQcFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                                        'regionOnFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                                        'regionNbFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                                        'plandusite'	 			=> true,
                                        'accueilProvince'			=> $accueilProvince,	
                                        'accueilRegion'				=> $accueilRegion,
                                        'hebergementProvince'                   => $hebergementProvince,
                                        'hebergementRegion'			=> $hebergementRegion,
                                        'forfaitProvince'			=> $forfaitProvince,
                                        'forfaitRegion'				=> $forfaitRegion,
                                        'corporatifProvince'                    => $corporatifProvince,
                                        'corporatifRegion'			=> $corporatifRegion,
                                        'centreSanteProvince'                   => $centreSanteProvince,
                                        'centreSanteRegion'			=> $centreSanteRegion,
                                        'attraitProvince'			=> $attraitProvince,
                                        'attraitRegion'				=> $attraitRegion,
                                        'restaurantProvince'                    => $restaurantProvince,
                                        'restaurantRegion'			=> $restaurantRegion,
                                        'promotionProvince'			=> $promotionProvince,
                                        'promotionRegion'			=> $promotionRegion,
                                        'googledfp1'				=> "GR_HEBERGEMENT_01",
                                        'googledfp2'				=> "GR_HEBERGEMENT_02",
                                        'googledfp3'				=> "GR_HEBERGEMENT_03",
                                        'saison'				=> $saison,
                                        'reservationRegionAjax'                 => $reservationRegionAjax,
                                        'reservationVilleAjax'                  => $reservationVilleAjax,
                                        'reservationPays'			=> $reservationEnLignePays[0],
                                        'reservationProvince'                   => $reservationEnLignePays[1],
                                        'titlefr'                               => "Plan du site",
                                        'titleen'                               => "Site map",
                                        'metafr'                                => "Plan du site",
                                        'metaen'                                => "Site map",
				));
	}
	/**
	 * Affiche le schema xml du sitemap (référencement moteur de recherche)
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function getReturnSchemaSitemapAction()
	{
		return $this->redirect($this->generateUrl("berriart_sitemap"));
	}
	
	/**
	 * Page condition d'utilisation
	 */
	public function conditionutilisationAction()
	{
		$reservationRegionAjax = $reservationVilleAjax = "";
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Moteur de recherche
		$listClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutocompletionPortail();
		$client = new Utilisateur();
		$formEngine = $this->container->get('form.factory')->create(new SearchMoteurEnginePortailType(), $client);
		$request = $this->get('request');
		if( $request->getMethod() == 'POST' ){
			// On fait le lien Requête <-> Formulaire.
			$formEngine->bindRequest($request);
			$word = $formEngine->getData()->getNom();
			if($word != null)
			{
				$rep = (new DefaultController)->getMoteurRechercheAction($word, $em);
				if($rep != null)
					return $this->redirect($this->generateUrl('_hebergementinfoclient', array( 'name' => $rep[0]->getRepertoireFr())));
				if (!$rep) {
					// throw $this->createNotFoundException('The product does not exist');
					throw new \Exception("Aucun résultat trouvé");
				}
			}
			//return $this->redirect($this->generateUrl('homepage'), 404);
		}
		//Site map		
                (new HebergementController)->getValideUrlSiteMap($em, array('/condition_utilisation.html', '/terms_of_use.html'));
                //Titre du lien Québec en saison
		$controDefault = new DefaultController();
		$saison = $controDefault->getSaisonQuebec();
		//traitement formulaire reservation en ligne
		$reservationEnLignePays = $controDefault->getReservationEnLignePays($em);
                $texteFr = "Global Réservation est un portail qui vous propose plusieurs services et informations touristiques comme la réservation dans divers établissements d'hébergement, les coordonnées de festivals, événements et activités ainsi que des nouvelles dans le milieu touristique.";
                $texteEn = "Global Reservation is a portal that offers you many services and tourism information such as accommodation reservation, all the details concerning festivals, events and activities, as well as news in the world of tourism. ";
		//Liste des régiond pour la réservation
                $fullListReservation = new DestinationController;
                $reservationRegionAjax = $fullListReservation->hydrateDropDownListRegionReservation($em);
                //Liste des villes pour la réservation
                $reservationVilleAjax = $fullListReservation->hydrateDropDownListVilleReservation($em);
                return $this->container->get('templating')->renderResponse('MyAppGlobalBundle:Qui_sommes_nous:conditionutilisation.html.twig',
                    array(  'pageStatic' 	 		=> true,
                            'regionQcFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[0],
                            'regionOnFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[1],
                            'regionNbFooter'			=> (new AttraitsactivityController)->getListeFooterRegion($em)[2],
                            'conditionutilisation'		=> true,
                            'formEngine'	 		=> $formEngine->createView(),
                            'listeClient'	 		=> $listClient,
                            'conditionutilisation'              => true,
                            'googledfp1'			=> "GR_HEBERGEMENT_01",
                            'googledfp2'			=> "GR_HEBERGEMENT_02",
                            'googledfp3'			=> "GR_HEBERGEMENT_03",
                            'saison'				=> $saison,
                            'reservationRegionAjax'             => $reservationRegionAjax,
                            'reservationVilleAjax'		=> $reservationVilleAjax,
                            'reservationPays'			=> $reservationEnLignePays[0],
                            'reservationProvince'		=> $reservationEnLignePays[1],
                            'titlefr'                           => "Conditions d'utilisation du site",
                            'titleen'                           => "Terms of use",
                            'metafr'                            => $texteFr,
                            'metaen'                            => $texteEn,
                    ));
	}
}