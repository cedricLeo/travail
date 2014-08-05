<?php
namespace MyApp\MobileBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyApp\MobileBundle\Controller\HebergementController;
/**
 * Description of ForfaitController
 *
 * @author leonardc
 */
class ForfaitController extends Controller {
    
    /**
     * Recherche le répertoire de la catégorie par son id 
     */
    public function rechercheRepertoireCategorieParId($categorie)
    {
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager();  
        //Recherche le repertoire de la catégorie
        $listeCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits")->getSearchPackagetById($categorie);     
        $varCategorie = $listeCategorie[0]->getRepertoireFr();
        //langue
        $lang = $this->container->get("session")->getLocale();
        if($lang == "en"){
            $varCategorie = $listeCategorie[0]->getRepertoireEn();
        }
        return array($listeCategorie, $varCategorie);
    }
    
    /**
     * Recherche la liste des province pour les liste avec une catégorie de forfait
     */
    private function returnListeProvinceAvecCategorie($categorie)
    {
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager();   
        $tabProvince = [];
        //Recherche toutes les provinces qui ont des forfaits de cette catégorie 
        $listeProvince = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getRechercheFofaitCategorieGroupByProvinceMobile($categorie); 
        foreach($listeProvince as $key){
            array_push($tabProvince, $key->getHebergementId()->getProvinceId()->getId());
        }       
        return array($listeProvince, $tabProvince);
    }
    
    /**
     * Recherche la liste des province pour les liste sans catégorie de forfait
     */
    private function returnListeProvinceSansCategorie()
    {
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager();   
        $tabProvince = [];
        //Recherche toutes les provinces qui ont des forfaits de cette catégorie 
        $listeProvince = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getAfficheListeForfaitValideGrouperProvinceMobile(); 
        foreach($listeProvince as $key){
            array_push($tabProvince, $key->getHebergementId()->getProvinceId()->getId());
        }       
        return array($listeProvince, $tabProvince);
    }
    
    /**
     * Recherche la liste des régions pour les liste avec une catégorie de forfait
     */
    private function returnListeRegionAvecCategorie($categorie, $tabProvince)
    {
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager();   
        $tabRegion = [];
        //Recherche des région qui ont des forfaits de cette catégorie
        $listeRegion = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheFofaitCategorieProvinceGroupByRegionMobile( $tabProvince, $categorie);
        foreach($listeRegion as $key){
            array_push($tabRegion, $key->getHebergementId()->getRegionId()->getId());
        }        
        return array($listeRegion, $tabRegion);
    }
    
    /**
     * Recherche la liste des régions pour les liste sans catégorie de forfait
     */
    private function returnListeRegionSansCategorie($tabProvince)
    {
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager();   
        $tabRegion = [];
        //Recherche des région qui ont des forfaits de cette catégorie
        $listeRegion = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitRegionMobile( $tabProvince);
        foreach($listeRegion as $key){
            array_push($tabRegion, $key->getHebergementId()->getRegionId()->getId());
        }        
        return array($listeRegion, $tabRegion);
    }
    
    /**
     * Recherche la liste des villes pour les liste avec une catégorie de forfait
     */
    private function returnListeVilleAvecCategorie($categorie, $tabRegion)
    {
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager();        
        //Recherche toutes les villes qui ont des forfaits de cette catégorie         
        $listeVille = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getCompteFofaitCategorieRegionGroupByVilleMobile($tabRegion, $categorie);
        return $listeVille;
    }
    
    /**
     * Recherche la liste des villes pour les liste sans catégorie de forfait
     */
    private function returnListeVilleSansCategorie( $tabRegion)
    {
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager();        
        //Recherche toutes les villes qui ont des forfaits de cette catégorie         
        $listeVille = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitVilleMobile( $tabRegion);        
        return $listeVille;
    }
    
    /**
     * Page d'accueil pour les forfaits
     */
    public function forfaitIndexAction()
    {
        $page = 1;
        //Gestionnaire des entités
        $em = $this->getDoctrine()->getEntityManager();    
        //Catégorie des provinces
        $listeCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideCategorieMobile();       
        $tabProvince = $tabRegion = $tabVille = [];
        foreach($listeCategorie as $key){         
            array_push($tabProvince, $key->getHebergementId()->getProvinceId()->getId());            
        }       
        //Liste des forfaits pour les provinces
        $listeProvince = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitProvinceMobile($tabProvince);
        foreach($listeProvince as $key){
            array_push($tabRegion, $key->getHebergementId()->getProvinceId()->getId());
        }
        //Liste des forfaits pour les régions
        $listeRegion = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitRegionMobile($tabRegion);
        foreach($listeRegion as $key){
            array_push($tabVille, $key->getHebergementId()->getRegionId()->getId());
        }
        //Liste des forfaits pour les villes
        $listeVille = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitVilleMobile($tabVille);       
        //langue
        $lang = $this->container->get("session")->getLocale();
        $titleDropDownList = HebergementController::getTitleDropDownList($lang);
        //Rendu de la vue
        return $this->render('MyAppMobileBundle:MobileForfait:index.html.twig', array(
            "listeCategorie"    => $listeCategorie,
            "listeProvince"     => $listeProvince,
            "listeRegion"       => $listeRegion,
            "listeVille"        => $listeVille,   
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],
            "choixcategorie"    => $titleDropDownList[3],
            "page"              => $page,
            "categorie"         => false,
        ));       
    }
    
    /**
     * filtre des listes par ajax (Catégorie)
     */
    public function filtreListeForfaitAjaxAction()
    {
        $page = 1;
        $request = $this->container->get('request');
        if($request->isXmlHttpRequest())
        {
            $categorie = '';                
            $categorie = $request->request->get('paramcategorie'); 
            (ctype_digit($categorie) == true)? $categorie: $categorie = null;
            $em = $this->getDoctrine()->getEntityManager();                
            if($categorie != '' or $categorie != null){            
                //On regarde la langue
                $lang = $this->container->get('session')->getLocale();
                //Recherche le repertoire de la catégorie               
                $repertoireCategorie = $this->rechercheRepertoireCategorieParId($categorie);
                //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
                $returnSortProvince = $this->returnListeProvinceAvecCategorie($categorie);
                $returnSortRegion = $this->returnListeRegionAvecCategorie($categorie, $returnSortProvince[1]);
                $returnSortVille = $this->returnListeVilleAvecCategorie($categorie, $returnSortRegion[1]);
                //Titres des listes déroulantes
                $titleDropDownList = HebergementController::getTitleDropDownList($lang);               
                //View
                return $this->render('MyAppMobileBundle:MobileForfait:region.js.twig', array(	
                    "listeProvince"     => $returnSortProvince[0],   
                    "listeRegion"       => $returnSortRegion[0],
                    "listeVille"        => $returnSortVille,
                    "page"              => $page,
                    "categorie"         => $repertoireCategorie[1],
                    "choixprovince"     => $titleDropDownList[0],
                    "choixregion"       => $titleDropDownList[1],
                    "choixville"        => $titleDropDownList[2],
                    "choixcategorie"    => $titleDropDownList[3],
                ));
            } 
            return;
        }
    }
    
    /**
     * filtre de la liste province par ajax (Province)
     */
    public function filtreListeForfaitProvinceAjaxAction()
    {
        $page = 1;
        $request = $this->container->get('request');
        if($request->isXmlHttpRequest())
        {
            $categorie = $province = '';                
            $categorie = $request->request->get('paramcategorie'); 
            $province = $request->request->get('paramprovince');
            (ctype_digit($categorie) == true)? $categorie: $categorie = null;
            (ctype_digit($province) == true)? $province: $province = null;
            $em = $this->getDoctrine()->getEntityManager();          
            //On regarde la langue
            $lang = $this->container->get('session')->getLocale();
            if($categorie != '' and $categorie != null){                                
                //Recherche le repertoire de la catégorie
                $repertoireCategorie = $this->rechercheRepertoireCategorieParId($categorie);               
                //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
                $returnSortProvince = $this->returnListeProvinceAvecCategorie($categorie);
                $returnSortRegion = $this->returnListeRegionAvecCategorie($categorie, $returnSortProvince[1]);
                $returnSortVille = $this->returnListeVilleAvecCategorie($categorie, $returnSortRegion[1]);
                //Titres des listes déroulantes
                $titleDropDownList = HebergementController::getTitleDropDownList($lang);
                //View
                return $this->render('MyAppMobileBundle:MobileForfait:region.js.twig', array(	
                    "listeProvince"     => $returnSortProvince[0],   
                    "listeRegion"       => $returnSortRegion[0],
                    "listeVille"        => $returnSortVille,
                    "listeCategorie"    => $repertoireCategorie[0],
                    "categorie"         => $repertoireCategorie[1],
                    "choixprovince"     => $titleDropDownList[0],
                    "choixregion"       => $titleDropDownList[1],
                    "choixville"        => $titleDropDownList[2],
                    "choixcategorie"    => $titleDropDownList[3],
                    "page"              => $page,
                ));
            }elseif($province != '' and $province != null and $categorie == null){   
                //Affiche les catégories
                $categorie = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideGroupBy();
                //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
                $returnSortProvince = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getProvinces($province);               
                $returnSortRegion = $this->returnListeRegionSansCategorie($returnSortProvince[0]->getId());
                $returnSortVille = $this->returnListeVilleSansCategorie($returnSortRegion[1]);
                //Titres des listes déroulantes
                $titleDropDownList = HebergementController::getTitleDropDownList($lang);
                //View
                return $this->render('MyAppMobileBundle:MobileForfait:region.js.twig', array(	
                    "listeProvince"     => $returnSortProvince[0],   
                    "listeRegion"       => $returnSortRegion[0],
                    "listeVille"        => $returnSortVille,    
                    "choixprovince"     => $titleDropDownList[0],
                    "choixregion"       => $titleDropDownList[1],
                    "choixville"        => $titleDropDownList[2],
                    "choixcategorie"    => $titleDropDownList[3],
                    "listeCategorie"    => $categorie,
                    "page"              => $page,
                ));
            }    
        }
    }
    
    /**
     * filtre de la liste région par ajax (Région)
     */
    public function filtreListeForfaitRegionAjaxAction()
    {
        $page = 1;
        $request = $this->container->get('request');
        if($request->isXmlHttpRequest())
        {
            $categorie = $region = '';                
            $categorie = $request->request->get('paramcategorie'); 
            $region = $request->request->get('paramregion');
            (ctype_digit($categorie) == true)? $categorie: $categorie = null;
            (ctype_digit($region) == true)? $region: $region = null;
            $em = $this->getDoctrine()->getEntityManager();          
            //On regarde la langue
            $lang = $this->container->get('session')->getLocale();
            if($categorie != '' and $categorie != null){                                
                //Recherche le repertoire de la catégorie
                $repertoireCategorie = $this->rechercheRepertoireCategorieParId($categorie);               
                //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
                $returnSortProvince = $this->returnListeProvinceAvecCategorie($categorie);
                $returnSortRegion = $this->returnListeRegionAvecCategorie($categorie, $returnSortProvince[1]);
                $returnSortVille = $this->returnListeVilleAvecCategorie($categorie, $returnSortRegion[1]);
                //Titres des listes déroulantes
                $titleDropDownList = HebergementController::getTitleDropDownList($lang);
                //View
                return $this->render('MyAppMobileBundle:MobileForfait:region.js.twig', array(	
                    "listeProvince"     => $returnSortProvince[0],   
                    "listeRegion"       => $returnSortRegion[0],
                    "listeVille"        => $returnSortVille,
                    "listeCategorie"    => $repertoireCategorie[0],
                    "categorie"         => $repertoireCategorie[1],
                    "choixprovince"     => $titleDropDownList[0],
                    "choixregion"       => $titleDropDownList[1],
                    "choixville"        => $titleDropDownList[2],
                    "choixcategorie"    => $titleDropDownList[3],
                    "page"              => $page,
                ));
            }elseif($region != '' and $region != null and $categorie == null){                 
                //Recherche la province de la région
                $regionProvince = $em->getRepository("MyAppGlobalBundle:Regions")->getRegionAleatoire($region);
                //Recherche toutes les régions et les villes qui ont des forfaits de cette catégorie 
                $returnSortProvince = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getProvinces($regionProvince[0]->getProvinceEtatId()->getId());               
                $returnSortRegion = $this->returnListeRegionSansCategorie($returnSortProvince[0]->getId());
                $returnSortVille = $this->returnListeVilleSansCategorie($returnSortRegion[1]);
                //Titres des listes déroulantes
                $titleDropDownList = HebergementController::getTitleDropDownList($lang);
                //View
                return $this->render('MyAppMobileBundle:MobileForfait:region.js.twig', array(	
                    "listeProvince"     => $returnSortProvince[0],   
                    "listeRegion"       => $returnSortRegion[0],
                    "listeVille"        => $returnSortVille,    
                    "choixprovince"     => $titleDropDownList[0],
                    "choixregion"       => $titleDropDownList[1],
                    "choixville"        => $titleDropDownList[2],
                    "choixcategorie"    => $titleDropDownList[3],
                    "page"              => $page,
                ));
            }    
        }
    }
    
    /**
     * Retourne les forfaits sans catégorie pour le pays 
     */
    public function SansCategorieForfaitAction( $page)
    {       
        $numberPaginate = 10;        
        (ctype_digit($page) == true and $page >= 0)? $page : $page = 1;
        $em = $this->getDoctrine()->getEntityManager();                       
        //On regarde la langue
        $lang = $this->container->get('session')->getLocale();
        //Compte le nombre de forfait
        $nbForfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValide();   
        //Total 
        $total = ceil(count($nbForfait)/$numberPaginate);
        //Liste des resultats                                
        $listeResultat = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheForfaitSansCategoriePaginationMobile($page, $numberPaginate);     
        //Liste des catégories
        $listeCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideCategorieMobile();
        //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
        $returnSortProvince = $this->returnListeProvinceSansCategorie();
        $returnSortRegion = $this->returnListeRegionSansCategorie( $returnSortProvince[1]);
        $returnSortVille = $this->returnListeVilleSansCategorie( $returnSortRegion[1]);   
        //Titres des listes déroulantes
        $titleDropDownList = HebergementController::getTitleDropDownList($lang);
        //View
        return $this->render('MyAppMobileBundle:MobileForfait:index.html.twig', array(	
            "listeResultat"     => $listeResultat,    
            "page"              => $page,
            "total"             => $total,
            "listeCategorie"    => $listeCategorie,
            "listeProvince"     => $returnSortProvince[0],   
            "listeRegion"       => $returnSortRegion[0],
            "listeVille"        => $returnSortVille,    
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],
            "choixcategorie"    => $titleDropDownList[3],
        ));        
    }
    
    /**
     * Retourne les forfaits de cette catégorie pour le pays 
     */
    public function avecCategorieForfaitAction($categorie, $page)
    {   
        $numberPaginate = 10;
        (ctype_alpha($categorie) == true)? $categorie: $categorie = null;
        (ctype_digit($page) == true and $page >= 0)? $page : $page = 1;
        $em = $this->getDoctrine()->getEntityManager();                       
        //On regarde la langue
        $lang = $this->container->get('session')->getLocale();
        //recherche l'id de la catégorie par son repertoire
        $idCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits")->getRechercheIdForfait($categorie);  
        $repertoire = $idCategorie[0]["nom_fr"];
        if($lang == "en"){
            $repertoire = $idCategorie[0]["nom_en"];
        }
        //Compte le nombre de forfait
        $nbForfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheFofaitCategorieIndex($idCategorie[0]["id"]);   
        //Total 
        $total = ceil(count($nbForfait)/$numberPaginate);
        //Liste des resultats                                
        $listeResultat = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheForfaitCategoriePaginationMobile($page, $numberPaginate, $idCategorie[0]["id"]);          
        //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
        $returnSortProvince = $this->returnListeProvinceAvecCategorie($idCategorie[0]["id"]);
        $returnSortRegion = $this->returnListeRegionAvecCategorie($idCategorie[0]["id"], $returnSortProvince[1]);
        $returnSortVille = $this->returnListeVilleAvecCategorie($idCategorie[0]["id"], $returnSortRegion[1]);
        //Liste des catégories
        $listeCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideCategorieMobile();
        //Titres des listes déroulantes
        $titleDropDownList = HebergementController::getTitleDropDownList($lang);
        //View
        return $this->render('MyAppMobileBundle:MobileForfait:index.html.twig', array(	
            "listeResultat"     => $listeResultat,    
            "page"              => $page,
            "total"             => $total,
            "repertoire"        => $repertoire,
            "listeProvince"     => $returnSortProvince[0],   
            "listeRegion"       => $returnSortRegion[0],
            "listeVille"        => $returnSortVille,
            "listeCategorie"    => $listeCategorie,
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],
            "choixcategorie"    => $titleDropDownList[3],
            "forfait-promotion" => "forfait-promotion",
            "package-promotion" => "package-promotion",
        ));        
    }        
    
    /**
     * Retourne les forfaits de cette province 
     */
    public function rechercheListeForfaitProvinceAction($province, $page)
    {       
        $numberPaginate = 10;        
        (ctype_digit($page) == true and $page >= 0)? $page : $page = 1;
        (ctype_alpha($province) ==  true)? $province : $province = "Quebec";
        $em = $this->getDoctrine()->getEntityManager();                       
        //On regarde la langue
        $lang = $this->container->get('session')->getLocale();
        //Recherche la province par son repertoire
        $idProvince = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getSearchIdByName($province);
        //Compte le nombre de forfait
        $nbForfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitProvinceMobileNonGrouper($idProvince[0]->getId());  
        //Total 
        $total = ceil(count($nbForfait)/$numberPaginate);
        //Liste des resultats                                
        $listeResultat = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheFofaitProvinceAvecPaginationMobile($idProvince[0]->getId(), $page, $numberPaginate);     
        //Liste des catégories
        $listeCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideCategorieMobile();
        //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
        $returnSortProvince = $this->returnListeProvinceSansCategorie();
        $returnSortRegion = $this->returnListeRegionSansCategorie( $returnSortProvince[1]);
        $returnSortVille = $this->returnListeVilleSansCategorie( $returnSortRegion[1]);   
        //Titres des listes déroulantes
        $titleDropDownList = HebergementController::getTitleDropDownList($lang);
        //View
        return $this->render('MyAppMobileBundle:MobileForfait:index.html.twig', array(	
            "listeResultat"     => $listeResultat,    
            "page"              => $page,
            "total"             => $total,
            "listeCategorie"    => $listeCategorie,
            "listeProvince"     => $returnSortProvince[0],   
            "listeRegion"       => $returnSortRegion[0],
            "listeVille"        => $returnSortVille,    
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],
            "choixcategorie"    => $titleDropDownList[3],
            "province"          => $province,
            "linkProvinceSansCat" => true,
        ));        
    }
    
    /**
     * Retourne les forfaits de cette catégorie pour la province version mobile 
     */
    public function avecCategorieForfaitProvinceAction($categorie, $province, $page)
    {   
        $numberPaginate = 10;
        (ctype_alpha($categorie) == true)? $categorie: $categorie = null;
        (ctype_alpha($province) == true)? $province: $province = "Quebec";
        (ctype_digit($page) == true and $page >= 0)? $page : $page = 1;
        $em = $this->getDoctrine()->getEntityManager();                       
        //On regarde la langue
        $lang = $this->container->get('session')->getLocale();
        //recherche l'id de la catégorie par son repertoire
        $idCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits")->getRechercheIdForfait($categorie);  
        $repertoire = $idCategorie[0]["nom_fr"];
        if($lang == "en"){
            $repertoire = $idCategorie[0]["nom_en"];
        }
        //Recherche l'id de la province
        $idProvince = $em->getRepository("MyAppGlobalBundle:Provinces_etats")->getSearchIdByName($province);
        //Compte le nombre de forfait
        $nbForfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheFofaitCategorieDeLaProvinceNonGrouper($idProvince[0]->getId(), $idCategorie[0]["id"]);   
        //Total 
        $total = ceil(count($nbForfait)/$numberPaginate);
        //Liste des resultats                                
        $listeResultat = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheForfaitCategorieDeLaProvinceAvecPaginationMobile($idProvince[0]->getId(), $idCategorie[0]["id"], $page, $numberPaginate);          
        //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
        $returnSortProvince = $this->returnListeProvinceAvecCategorie($idCategorie[0]["id"]);
        $returnSortRegion = $this->returnListeRegionAvecCategorie($idCategorie[0]["id"], $returnSortProvince[1]);
        $returnSortVille = $this->returnListeVilleAvecCategorie($idCategorie[0]["id"], $returnSortRegion[1]);
        //Liste des catégories
        $listeCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideCategorieMobile();
        //Titres des listes déroulantes
        $titleDropDownList = HebergementController::getTitleDropDownList($lang);
        //View
        return $this->render('MyAppMobileBundle:MobileForfait:index.html.twig', array(	
            "listeResultat"     => $listeResultat,    
            "page"              => $page,
            "total"             => $total,
            "repertoire"        => $repertoire,
            "listeProvince"     => $returnSortProvince[0],   
            "listeRegion"       => $returnSortRegion[0],
            "listeVille"        => $returnSortVille,
            "listeCategorie"    => $listeCategorie,
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],
            "choixcategorie"    => $titleDropDownList[3],
            "forfait-promotion" => "forfait-promotion",
            "package-promotion" => "package-promotion",
        ));        
    }        
    
    /**
     * Retourne les forfaits de cette région 
     */
    public function rechercheListeForfaitRegionAction($region, $page)
    {       
        $numberPaginate = 10;        
        (ctype_digit($page) == true and $page >= 0)? $page : $page = 1;
        (ctype_alpha($region) ==  true)? $region : $region = "Quebec";
        $em = $this->getDoctrine()->getEntityManager();                       
        //On regarde la langue
        $lang = $this->container->get('session')->getLocale();
        //Recherche la région par son repertoire
        $idRegion = $em->getRepository("MyAppGlobalBundle:Regions")->getSearchIdByName($region);                
        //Compte le nombre de forfait
        $nbForfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideRegionNonGrouper($idRegion["id"]);  
        //Total 
        $total = ceil(count($nbForfait)/$numberPaginate);
        //Liste des resultats                                
        $listeResultat = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheFofaitRegionAvecPaginationMobile($idRegion["id"], $page, $numberPaginate);     
        //Liste des catégories
        $listeCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideCategorieMobile();
        //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
        $returnSortProvince = $this->returnListeProvinceSansCategorie();
        $returnSortRegion = $this->returnListeRegionSansCategorie( $returnSortProvince[1]);
        $returnSortVille = $this->returnListeVilleSansCategorie( $returnSortRegion[1]);   
        //Titres des listes déroulantes
        $titleDropDownList = HebergementController::getTitleDropDownList($lang);
        //View
        return $this->render('MyAppMobileBundle:MobileForfait:index.html.twig', array(	
            "listeResultat"     => $listeResultat,    
            "page"              => $page,
            "total"             => $total,
            "listeCategorie"    => $listeCategorie,
            "listeProvince"     => $returnSortProvince[0],   
            "listeRegion"       => $returnSortRegion[0],
            "listeVille"        => $returnSortVille,    
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],
            "choixcategorie"    => $titleDropDownList[3],
            "linkRegionSansCat" => true,
            "region"            => $region,
        ));        
    }
    
     /**
     * Retourne tous les forfaits de cette catégorie dans cette région 
     */
    public function rechercheListeForfaitCategorieRegionAction($region, $categorie, $page)
    {       
        $numberPaginate = 10;        
        (ctype_digit($page) == true and $page >= 0)? $page : $page = 1;
        (ctype_alpha($region) ==  true)? $region : $region = "Quebec";
        (ctype_alpha($categorie) == true)? $categorie: $categorie = "Culturel";
        $em = $this->getDoctrine()->getEntityManager();                       
        //On regarde la langue
        $lang = $this->container->get('session')->getLocale();
        //Recherche la région par son repertoire
        $idRegion = $em->getRepository("MyAppGlobalBundle:Regions")->getNameSearchRegion($region); 
        //Recherche l'id de la catégorie
        $idCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits")->getRechercheIdForfait($categorie);
        $repertoire = $idCategorie[0]["nom_fr"];
        if($lang == "en"){
            $repertoire = $idCategorie[0]["nom_en"];
        }
        //Compte le nombre de forfait
        $nbForfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideRegionNonGrouper($idRegion[0]->getId(), $idCategorie[0]["id"]);  
        //Total 
        $total = ceil(count($nbForfait)/$numberPaginate);
        //Liste des resultats                                
        $listeResultat = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheFofaitCategorieDeLaRegionAvecPagination($idRegion[0]->getId(), $idCategorie[0]["id"], $page, $numberPaginate);     
        var_dump($listeResultat);
        //Liste des catégories
        $listeCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideCategorieMobile();
        //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
        $returnSortProvince = $this->returnListeProvinceSansCategorie();
        $returnSortRegion = $this->returnListeRegionSansCategorie( $returnSortProvince[1]);
        $returnSortVille = $this->returnListeVilleSansCategorie( $returnSortRegion[1]);   
        //Titres des listes déroulantes
        $titleDropDownList = HebergementController::getTitleDropDownList($lang);
        //View
        return $this->render('MyAppMobileBundle:MobileForfait:index.html.twig', array(	
            "listeResultat"     => $listeResultat,    
            "page"              => $page,
            "total"             => $total,
            "listeCategorie"    => $listeCategorie,
            "listeProvince"     => $returnSortProvince[0],   
            "listeRegion"       => $returnSortRegion[0],
            "listeVille"        => $returnSortVille,    
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],
            "choixcategorie"    => $titleDropDownList[3],
            "linkRegionCat"     => true,
            "region"            => $region,
            "repertoire"        => $repertoire,
        ));        
    }
    
    /**
     * Retourne les forfaits de cette ville 
     */
    public function rechercheListeForfaitVilleAction($ville, $page)
    {       
        $numberPaginate = 10;        
        (ctype_digit($page) == true and $page >= 0)? $page : $page = 1;
        (ctype_alpha($ville) ==  true)? $ville : $ville = "Quebec-Sainte-Foy";
        $em = $this->getDoctrine()->getEntityManager();                       
        //On regarde la langue
        $lang = $this->container->get('session')->getLocale();
        //Recherche la ville par son repertoire
        $idVille = $em->getRepository("MyAppGlobalBundle:Villes")->getInfosVille($ville); 
        //Compte le nombre de forfait
        $nbForfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideVilleNonGrouper($idVille[0]->getId());  
        //Total 
        $total = ceil(count($nbForfait)/$numberPaginate);
        //Liste des resultats                                
        $listeResultat = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheFofaitVilleAvecPaginationMobile($idVille[0]->getId(), $page, $numberPaginate);     
        //Liste des catégories
        $listeCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideCategorieMobile();
        //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
        $returnSortProvince = $this->returnListeProvinceSansCategorie();
        $returnSortRegion = $this->returnListeRegionSansCategorie( $returnSortProvince[1]);
        $returnSortVille = $this->returnListeVilleSansCategorie( $returnSortRegion[1]);   
        //Titres des listes déroulantes
        $titleDropDownList = HebergementController::getTitleDropDownList($lang);
        //View
        return $this->render('MyAppMobileBundle:MobileForfait:index.html.twig', array(	
            "listeResultat"     => $listeResultat,    
            "page"              => $page,
            "total"             => $total,
            "listeCategorie"    => $listeCategorie,
            "listeProvince"     => $returnSortProvince[0],   
            "listeRegion"       => $returnSortRegion[0],
            "listeVille"        => $returnSortVille,    
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],
            "choixcategorie"    => $titleDropDownList[3],
            "linkVilleSansCat"  => true,
            "ville"             => $ville,
        ));        
    }
    
    /**
     * Retourne tous les forfaits de cette catégorie dans cette ville 
     */
    public function rechercheListeForfaitCategorieVilleAction($ville, $categorie, $page)
    {       
        $numberPaginate = 10;        
        (ctype_digit($page) == true and $page >= 0)? $page : $page = 1;
        (ctype_alpha($ville) ==  true)? $ville : $ville = "Quebec-Sainte-Foy";
        $em = $this->getDoctrine()->getEntityManager();                       
        //On regarde la langue
        $lang = $this->container->get('session')->getLocale();
        //Recherche la ville par son repertoire
        $idVille = $em->getRepository("MyAppGlobalBundle:Villes")->getInfosVille($ville); 
        //Compte le nombre de forfait
        $nbForfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideVilleNonGrouper($idVille[0]->getId());  
        //Total 
        $total = ceil(count($nbForfait)/$numberPaginate);
        //Liste des resultats                                
        $listeResultat = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheFofaitCategorieDeLaVille($idVille[0]->getId(), $categorie, $page, $numberPaginate);     
        //Liste des catégories
        $listeCategorie = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getAfficheListeForfaitValideCategorieMobile();
        //Recherche toutes les provinces, les régions et les villes qui ont des forfaits de cette catégorie 
        $returnSortProvince = $this->returnListeProvinceSansCategorie();
        $returnSortRegion = $this->returnListeRegionSansCategorie( $returnSortProvince[1]);
        $returnSortVille = $this->returnListeVilleSansCategorie( $returnSortRegion[1]);   
        //Titres des listes déroulantes
        $titleDropDownList = HebergementController::getTitleDropDownList($lang);
        //View
        return $this->render('MyAppMobileBundle:MobileForfait:index.html.twig', array(	
            "listeResultat"     => $listeResultat,    
            "page"              => $page,
            "total"             => $total,
            "listeCategorie"    => $listeCategorie,
            "listeProvince"     => $returnSortProvince[0],   
            "listeRegion"       => $returnSortRegion[0],
            "listeVille"        => $returnSortVille,    
            "choixprovince"     => $titleDropDownList[0],
            "choixregion"       => $titleDropDownList[1],
            "choixville"        => $titleDropDownList[2],
            "choixcategorie"    => $titleDropDownList[3],
            "linkVilleCat"      => true,
            "ville"             => $ville,
        ));        
    }
}
