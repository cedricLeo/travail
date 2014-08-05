<?php
namespace MyApp\MobileBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyApp\MobileBundle\Forms\Formulaire_information_reservation_global_type;
use MyApp\MobileBundle\Forms\DemandeInformationEnType;
use MyApp\MobileBundle\Forms\DemandeInformationType;
use MyApp\GlobalBundle\Entity\Distances;

/**
 * Description of HebergementController
 *
 * @author leonardc
 */
class HebergementController extends Controller 
{
    
    private static $emailGlobalReservation = "reservation@global-reservation.com";
    
    /**
     * Affiche les titre choisissez une province etc pour les listes déroulantes
     */
    public static function getTitleDropDownList($lang)
    {        
        if($lang == "fr"){
            $choixcategorie = "Choisissez une catégorie";
            $choixprovince = "Choisissez une province";
            $choixregion = "Choisissez une région";
            $choixville = "Choisissez une ville";           
        }else{
            $choixcategorie = "Choose a category";
            $choixprovince = "Choose a province";
            $choixregion = "Choose a region";
            $choixville = "Select a city";
        }
        return $tab = [$choixprovince, $choixregion, $choixville, $choixcategorie];
    }
    
    /**
     * 
     * Page d'accueil des hébergements
     */
    public function hebergementIndexAction()    
    {       
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager();    
        //Liste des provinces
        $listeProvince = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getAdminProvincesMobile();
        //Liste de régions
        $listeRegion = $em->getRepository("MyAppGlobalBundle:Regions")->getRegionsDeLaProvinceMobile();
        //Liste des villes
        $listeVille = $em->getRepository("MyAppGlobalBundle:Villes")->getSelectListTown();
        //langue
        $lang = $this->container->get("session")->getLocale();
        $titleDropDownList = self::getTitleDropDownList($lang);
        //Rendu de la vue
        return $this->render('MyAppMobileBundle:MobileHebergement:index.html.twig', array(
            "listeProvince"     => $listeProvince,
            "listeRegion"       => $listeRegion,
            "listeVille"        => $listeVille,   
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],
        ));
    }
    
    /**
     * 
     * Méthode pour la sélection de la liste des régions pour le dropdownlist en ajax
     */
    public function hebergementRegionAjaxAction()
    {
        $request = $this->container->get('request');
        if($request->isXmlHttpRequest())
        {
            $province = '';                
            $province = $request->request->get('paramprovince');                                        
            $em = $this->getDoctrine()->getEntityManager();                
            if($province != '' or $province != null){
                //On regarde la langue
                $lang = $this->container->get('session')->getLocale();
               //Recherche par ajax avec le critère de tri
                $listeRegion = $em->getRepository('MyAppGlobalBundle:Regions')->getRegionsMobile($province, $lang);    
                //Titres des listes déroulantes
                $titleDropDownList = self::getTitleDropDownList($lang);
                //View
                return $this->render('MyAppMobileBundle:MobileHebergement:region.js.twig', array(	
                    "listeRegion"       => $listeRegion,    
                    "choixprovince"     => $titleDropDownList[0],
                    "choixregion"       => $titleDropDownList[1],
                    "choixville"        => $titleDropDownList[2],
                ));
            }
        }
    }
    
    /**
     * 
     * Méthode pour la sélection de la liste des villes pour le dropdownlist en ajax
     */
    public function hebergementVilleAjaxAction()
    {
        $request = $this->container->get('request');
        if($request->isXmlHttpRequest())
        {
            $region = '';                
            $region = $request->request->get('paramregion');                                        
            $em = $this->getDoctrine()->getEntityManager();                
            if($region != '' or $region != null){
                //On regarde la langue
               $lang = $this->container->get('session')->getLocale();
               //Recherche par ajax avec le critère de tri
               $listeVille = $em->getRepository('MyAppGlobalBundle:Villes')->getVilles($region, $lang);    
               //Titres des listes déroulantes
               $titleDropDownList = self::getTitleDropDownList($lang);
               //View
               return $this->render('MyAppMobileBundle:MobileHebergement:ville.js.twig', array(	
                    "listeVille"        => $listeVille,     
                    "choixprovince"     => $titleDropDownList[0],
                    "choixregion"       => $titleDropDownList[1],
                    "choixville"        => $titleDropDownList[2],
               ));
            }
        }
    }
    
    /**
     * Méthode pour lister tous les hébergements au Canada
     * 
     */
    public function hebergementResultatCanadaAction()
    {
        $request = $this->container->get('request');
        if($request->isXmlHttpRequest())
        {                                      
            $em = $this->getDoctrine()->getEntityManager();                                
            //On regarde la langue
            $lang = $this->container->get('session')->getLocale();
             //Recherche de la totalité des hébergement
            $listeTotal = $em->getRepository('MyAppGlobalBundle:Provinces_etats')->getVilles($region, $lang);  
            //Titres des listes déroulantes
            $titleDropDownList = self::getTitleDropDownList($lang);
            //View
            return $this->render('MyAppMobileBundle:MobileHebergement:pays.html.twig', array(	
                "listeVille"        => $listeTotal, 
                "choixprovince"     => $titleDropDownList[0],
                "choixregion"       => $titleDropDownList[1],
                "choixville"        => $titleDropDownList[2],
            ));                
        }
    }
    
    /**
     * Méthode pour lister tous les hébergements de la province
     * 
     */
    public function hebergementResultatProvinceAjaxAction($id, $page)
    {
        $numberPaginate = 10;
        //Langue
        $lang = $this->container->get('session')->getLocale();
        if($lang == "fr"){
            (is_string($id) == true)? $id: $id = "quebec";
        }else{
            (is_string($id) == true)? $id: $id = "quebec-en";
        }
        (is_numeric($page) == true)? $page : $page = 1; 
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager(); 
        //Recherche l'id du repertoire
        $repertoireId = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getSearchIdByName($id);
        //Liste des proovinces
        $listeProvince = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getAdminProvincesMobile();
        //Liste de régions
        $listeRegion = $em->getRepository("MyAppGlobalBundle:Regions")->getRegionsDeLaProvinceMobile($listeProvince[0]["id"]);
        //Liste des villesgetSelectListTown
        $listeVille = $em->getRepository("MyAppGlobalBundle:Villes")->getSelectListTown($listeRegion[0]["id"]);  
        //Recherche de la totalité des hébergement
        //$listeTotal = $em->getRepository('MyAppMobileBundle:Hebergements')->getAllCustomerByProvincePagination($province, $page =1, $numberPaginate);    
        $numbId = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCompteHebergement($repertoireId[0]->getId());   
        //Compte le nombre d'hébergement
        $total = ceil($numbId['numbId']/$numberPaginate);
        if($page > $total or $page < 0){
            $page = 1;
        }
        //Liste avec pagination
        $listeTotal = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheProvince($repertoireId[0]->getId(), $page, $numberPaginate );  
        shuffle($listeTotal);
        //Titres des listes déroulantes
        $titleDropDownList = self::getTitleDropDownList($lang);
        //Rendu de la vue
        return $this->render('MyAppMobileBundle:MobileHebergement:province_default.html.twig', array(
            "listeProvince"     => $listeProvince,
            "listeRegion"       => $listeRegion,
            "listeVille"        => $listeVille,
            "listeResultat"     => $listeTotal,
            "page"              => $page,
            "total"             => $total,
            "repertoire"        => $id,
            "provinceListe"     => $repertoireId,
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],            
        ));                 
    }
    
    
     /**
     * Méthode pour lister tous les hébergements de la région
     * 
     */
    public function hebergementResultatRegionAjaxAction($id, $page)
    {
        $numberPaginate = 10;
        //Langue
        $lang = $this->container->get('session')->getLocale();
        if($lang == "fr"){
            (is_string($id) == true)? $id: $id = "quebec";
        }else{
            (is_string($id) == true)? $id: $id = "quebec-en";
        }
        (is_numeric($page) == true)? $page : $page = 1; 
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager(); 
        //Recherche l'id du repertoire
        $repertoireId = $em->getRepository("MyAppGlobalBundle:Regions")->getSearchIdByName($id);
        //Liste des proovinces
        $listeProvince = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getAdminProvincesMobile();
        //Liste de régions
        $listeRegion = $em->getRepository("MyAppGlobalBundle:Regions")->getRegionsDeLaProvinceMobile($listeProvince[0]["id"]);
        //Liste des villesgetSelectListTown
        $listeVille = $em->getRepository("MyAppGlobalBundle:Villes")->getSelectListTown($listeRegion[0]["id"]);   
        //Recherche de la totalité des hébergement
        //$listeTotal = $em->getRepository('MyAppMobileBundle:Hebergements')->getAllCustomerByProvincePagination($province, $page =1, $numberPaginate);    
        $numbId = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCompteHebergementRegion($repertoireId["id"]);   
        //Compte le nombre d'hébergement
        $total = ceil($numbId['numbId']/$numberPaginate);
        if($page > $total or $page < 0){
            $page = 1;
        }
        //Liste avec pagination
        $listeTotal = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheRegion($repertoireId["id"], $page, $numberPaginate ); 
        shuffle($listeTotal);
        //Titres des listes déroulantes
        $titleDropDownList = self::getTitleDropDownList($lang);
        //Rendu de la vue
        return $this->render('MyAppMobileBundle:MobileHebergement:region_default.html.twig', array(
            "listeProvince"     => $listeProvince,
            "listeRegion"       => $listeRegion,
            "listeVille"        => $listeVille,
            "listeResultat"     => $listeTotal,
            "page"              => $page,
            "total"             => $total,
            "repertoire"        => $id,
            "provinceListe"     => $repertoireId,
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],            
        ));                 
    }
    
    /**
     * Méthode pour lister tous les hébergements de la ville
     * 
     */
    public function hebergementResultatVilleAjaxAction($id, $page)
    {
         $numberPaginate = 10;
        //Langue
        $lang = $this->container->get('session')->getLocale();
        if($lang == "fr"){
            (is_string($id) == true)? $id: $id = "Quebec-Sainte-Foy";
        }else{
            (is_string($id) == true)? $id: $id = "Quebec-Sainte-Foy-en";
        }
        (is_numeric($page) == true)? $page : $page = 1; 
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager(); 
        //Recherche l'id du repertoire
        $repertoireId = $em->getRepository("MyAppGlobalBundle:Villes")->getSearchTownMobile($id);
        //Liste des proovinces
        $listeProvince = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getAdminProvincesMobile();
        //Liste de régions
        $listeRegion = $em->getRepository("MyAppGlobalBundle:Regions")->getRegionsDeLaProvinceMobile($listeProvince[0]["id"]);
        //Liste des villesgetSelectListTown
        $listeVille = $em->getRepository("MyAppGlobalBundle:Villes")->getSelectListTown($listeRegion[0]["id"]);  
        //Recherche de la totalité des hébergement
        //$listeTotal = $em->getRepository('MyAppMobileBundle:Hebergements')->getAllCustomerByProvincePagination($province, $page =1, $numberPaginate);    
        $numbId = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCompteHebergementVille($repertoireId['id']);   
        //Compte le nombre d'hébergement
        $total = ceil($numbId['numbId']/$numberPaginate);
        if($page > $total or $page < 0){
            $page = 1;
        }
        //Liste avec pagination
        $listeTotal = $em->getRepository('MyAppGlobalBundle:Hebergements')->getAfficheVille($repertoireId['id'], $lang, $page, $numberPaginate );   
       // shuffle($listeTotal);
        //Titres des listes déroulantes
        $titleDropDownList = self::getTitleDropDownList($lang);
        //Rendu de la vue
        return $this->render('MyAppMobileBundle:MobileHebergement:ville_default.html.twig', array(
            "listeProvince"     => $listeProvince,
            "listeRegion"       => $listeRegion,
            "listeVille"        => $listeVille,
            "listeResultat"     => $listeTotal,
            "page"              => $page,
            "total"             => $total,
            "repertoire"        => $id,
            "provinceListe"     => $repertoireId,
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],  
            "section"           => "accueil",
            "resultatVille"     => true,
        ));         
    }    
    
    
    /**
     * Méthode pour afficher les chambres de l'hébergement
     * 
     */
    public function genericCustomerAction($section, $id)
    {   
        switch($section){
            case "accueil":
                $section = "accueil";
                break;
            case "chambres-tarifs":
                $section = "chambres-tarifs";
                break;
            case "forfait-promotion":
                $section = "forfait-promotion";
                break;
            case "package-promotion":
                $section = "package-promotion";
                break;
            case "activites-services":
                $section = "activites-services";
                break;
            case "corporatif-evenement":
                $section = "corporatif-evenement";
                break;
            case "information-reservation":
                $section = "information-reservation";
                break;
            case "directions-routieres":
                $section = "directions-routieres";
                break;
            default:
                $section = "accueil";
                break;                            
        }
        $corpo = $formCorporatif = "";
        //Langue
        $lang = $this->container->get('session')->getLocale();        
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager(); 
        //Valide l'argument
        $id = (new DefaultController)->getSecureData($id);   
        //Recherche le client avec son repertoire
        $retourneResultat = $em->getRepository("MyAppGlobalBundle:Hebergements")->getNameHebergement($id); 
        //Liste des chambres 
        $chambre = $em->getRepository("MyAppGlobalBundle:Chambres")->getChambreEtTypeDeEtablissement($retourneResultat[0]->getId());     
        //Formulaire de demande d'information/réservation Global réservation
        $form = $this->createForm(new Formulaire_information_reservation_global_type());
        $request = $this->get('request');
        //request ajax
       /* if($request->isXmlHttpRequest())
        {
            $this->demandeReservationAction($request, $retourneResultat, $lang);
        }
        else
        {
            //Traitement et retour
            $this->getGestionnaireFormulaireEnvoieCourrielReservation($form, $retourneResultat, $lang, $request);
        }   */     
        //Retourne si le client à des forfaits affaires
        $forfaitAffaire = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsAffaires($retourneResultat[0]->getId());
        //Corporatif
        if($retourneResultat[0]->getEmailCorporatif() != null and $retourneResultat[0]->getCorporatif() != null){
            //On récupère les documents corporatifs
            $corpo = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListSalleCorporativeActiveDuClient($retourneResultat[0]->getId());
            if($lang == "fr"){
                    $formCorpo = $this->container->get('form.factory')->create(new DemandeInformationType());
                    $formCorporatif = $formCorpo->createView();
            }else{
                    $formCorpo = $this->container->get('form.factory')->create(new DemandeInformationEnType());
                    $formCorporatif = $formCorpo->createView();
            }
        }
        //Activités et services
        $services = $em->getRepository('MyAppGlobalBundle:Hebergements')->getServiceHebergement($retourneResultat[0]->getId());
        //Récupère les distances des activités de cet hébergement
        $distance = $em->getRepository('MyAppGlobalBundle:Distances')->getTriLesDistancesParNomFrASC($retourneResultat[0]->getId());
        //Retourne la liste des forfaits 
        $forfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getListeTousLesForfaits($retourneResultat[0]->getId());   
        //Récupère les id des style des hébergements
        $tabStyle = [];        
        foreach($retourneResultat[0]->getStyleHebergementId() as $ts)
        {
                array_push($tabStyle, $ts->getId());
        }
        //Récupère pour les critères semblables à cet établissement.
        $critere = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCritereEtablissement($retourneResultat[0]->getVilleId()->getId(), $tabStyle, $retourneResultat[0]->getId());//On brasse et on récupère 6 clients aléatoires.             
        shuffle($critere);                    
        $nbCritere = count($critere);                    
        if($nbCritere >= 2)
        {                       
            $quatreCritere = array_rand($critere, $nbCritere);          
            $tempCritere = [];
            foreach($quatreCritere as $val){
                array_push($tempCritere, $critere[$val]->getId());
            }
            $critere = null;
            $critere = $em->getRepository("MyAppGlobalBundle:Hebergements")->getListeClientPropositionMoteurRecherche($tempCritere);
        }   
        elseif($nbCritere == 1){
            $tempCritere = $critere;
            $critere = null;
            $critere = $em->getRepository("MyAppGlobalBundle:Hebergements")->getListeClientPropositionMoteurRecherche($tempCritere[0]->getId());
        }
        //On récupères les ids des hôtels
        $tabIdHotel = [];
        foreach($critere as $key){
            array_push($tabIdHotel, $key->getId());
        }
        //Retourne la liste des forfaits disponibles
        $forfaitDisponible = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideGroupeHebergement($tabIdHotel);
        shuffle($forfaitDisponible);
        //Rendu de la vue
        if($lang == "fr"){
            return $this->render('MyAppMobileBundle:MobileHebergement:detail_hebergement.html.twig', array(
                 "retourDetail"  => $retourneResultat,
                 "repertoire"    => $id,
                 "section"       => $section,
                 "typeAcompte"   => $retourneResultat[0]->getAcompteId()->getId(),
                 "corporatif"    => $retourneResultat[0]->getCorporatif(),
                 "chambre"       => $chambre,
                 "datetoday"     => new \DateTime('now'),
                 "emailGlobalReservation"   => self::$emailGlobalReservation,
                 "form"          => $form->createView(),
                 'forfaitAffaire'=> $forfaitAffaire,
                 'corpo'         => $corpo,
                 "formCorpo"     => $formCorporatif,
                 "forfait"       => $forfait,
                 "services"      => $services,
                 "distance"      => $distance,
                 "critere"       => $critere, 
                 "linkaccueil"   => "accueil",
                 "linkchambre"   => "chambres-tarifs",
                 "linkforfait"   => "forfait-promotion",
                 "linkcorporatif" => "corporatif-evenement",
                 "linkactivite"   => "activites-services",
                 "linkreservation" => "information-reservation",
                 "linkdirection"   => "directions-routieres",
                 "forfaitDisponible" => $forfaitDisponible,
            )); 
        }else{
             return $this->render('MyAppMobileBundle:MobileHebergement:detail_hebergement_en.html.twig', array(
                 "retourDetail"  => $retourneResultat,
                 "repertoire"    => $retourneResultat[0]->getRepertoireEn(),
                 "section"       => "menuhome",
                 "typeAcompte"   => $retourneResultat[0]->getAcompteId()->getId(),
                 "corporatif"    => $retourneResultat[0]->getCorporatif(),
                 "chambre"       => $chambre,
                 "datetoday"     => new \DateTime('now'),
                 "emailGlobalReservation"   => self::$emailGlobalReservation,
                 "form"          => $form->createView(),
                 'forfaitAffaire'=> $forfaitAffaire,
                 'corpo'         => $corpo,
                 "formCorpo"     => $formCorporatif,
                 "forfait"       => $forfait,
                 "services"      => $services,
                 "distance"      => $distance,
                 "critere"       => $critere,                  
                 "linkchambre"   => "chambres-tarif",
                 "linkforfait"   => "forfait-promotion",
                 "linkcorporatif" => "corporatif-evenement",
                 "linkactivite"   => "activites-services",
                 "linkreservation" => "information-reservation",
                 "linkdirection"   => "directions-routieres",
                 "forfaitDisponible" => $forfaitDisponible,
            )); 
        }
    }
    
    /**
     * méthode de traitement pour l'envoie d'un courriel de puis fiches client
     */
    private function getGestionnaireFormulaireEnvoieCourrielReservation($form, $client, $lang, $request)
    {               
        // On vérifie qu'elle est de type « POST ».
        if( $request->getMethod() == 'POST' )
        {
                // On fait le lien Requête <-> Formulaire.
                $form->bindRequest($request);
                //Transmet le formulaire à la méthode d'envoie du courriel
                $sender = $form->getData();
                $message = $this->container->get("SendEmailCustomer")->getEnvoyerEmailAGlobal($sender, $client, $lang);
                if($message == "confirmation")
                {
                        echo "ok";
                }

        }
    }
    
    /**
    * envoie de la demade réservation / informations
    */
    private function demandeReservationAction($request, $client, $lang)
    {    
        if($request != null){
            $prenom = $nom = $tel = $email = $date_arrivee = $date_depart = $nb_adulte = $nb_chambre = '';
            $prenom = $request->request->get('prenom');
            $nom = $request->request->get('nom');
            $tel = $request->request->get('tel');
            $email = $request->request->get('email');
            $date_arrive = $request->request->get('date_arrivee');
            $date_depart = $request->request->get('date_depart');  
            $nb_adulte = $request->request->get("nb_adulte");
            $nb_chambre = $request->request->get("nb_chambre");

            $sender = ["prenom" => $prenom, "nom" => $nom, "tel" => $tel, "email" => $email, "date_arrive" => $date_arrive, "date_depart" => $date_depart, ];
            //Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
           // $page = (new ControleDataSecureController)->getValideEntierPagination($page, $displaypage);
            if($prenom != '' and $nom != '' && $tel != '' and $email != '' and $date_arrive != '' and $date_depart != '' and $nb_adulte != '' and $nb_chambre != ''){                          
                 $this->container->get("SendEmailCustomer")->getEnvoyerEmailAGlobal($sender, $client, $lang);  
                 return true;
            }else{
                 return false;
            }
        }
    }     
  
}
