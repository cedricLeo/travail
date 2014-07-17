<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "qcs_types_pages")
 */
class Qcs_types_pages{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $nom
	 */
	private $nom;
	
	/**
	 * @ORM\Column(type="integer", length = 1)
	 * 
	 * @var integer $page_racine
	 */
	private $page_racine;
	
	/**
	 * @ORM\Column(type="integer", length = 1)
	 *
	 * @var integer $page_statique
	 */
	private $page_statique;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $page_fr
	 */
	private $page_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $page_en
	 */
	private $page_en;
        
       /**
        * @ORM\Column(type="string", length = 255, nullable = "true")
        * 
        * @var string $repertoire_fr
        */
       private $repertoire_fr;

       /**
        * @ORM\Column(type="string", length = 255, nullable = "true")
        * 
        * @var string $repertoire_en
        */
       private $repertoire_en;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $fichier_source_fr
	 */
	private $fichier_source_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $fichier_source_en
	 */
	private $fichier_source_en;
	
	/**
	 * @ORM\Column(type="text")
	 * 
	 * @var text $affiche_resume
	 */
	private $affiche_resume;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $affiche_image_entete
	 */
	private $affiche_image_entete;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $affiche_image_accueil
	 */
	private $affiche_image_accueil;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $affiche_image_article
	 */
	private $affiche_image_article;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $image_thematique
	 */
	private $image_thematique;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $image_bas_page
	 */
	private $image_bas_page;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $largeur_image_accueil
	 */
	private $largeur_image_accueil;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $largeur_apercu_image_home
	 */
	private $largeur_apercu_image_home;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $hauteur_image_home
	 */
	private $hauteur_image_home;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $hauteur_apercu_image_home
	 */
	private $hauteur_apercu_image_home;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set page_racine
     *
     * @param integer $pageRacine
     */
    public function setPageRacine($pageRacine)
    {
        $this->page_racine = $pageRacine;
    }

    /**
     * Get page_racine
     *
     * @return integer 
     */
    public function getPageRacine()
    {
        return $this->page_racine;
    }

    /**
     * Set page_statique
     *
     * @param integer $pageStatique
     */
    public function setPageStatique($pageStatique)
    {
        $this->page_statique = $pageStatique;
    }

    /**
     * Get page_statique
     *
     * @return integer 
     */
    public function getPageStatique()
    {
        return $this->page_statique;
    }

    /**
     * Set page_fr
     *
     * @param string $pageFr
     */
    public function setPageFr($pageFr)
    {
        $this->page_fr = $pageFr;
    }

    /**
     * Get page_fr
     *
     * @return string 
     */
    public function getPageFr()
    {
        return $this->page_fr;
    }

    /**
     * Set page_en
     *
     * @param string $pageEn
     */
    public function setPageEn($pageEn)
    {
        $this->page_en = $pageEn;
    }

    /**
     * Get page_en
     *
     * @return string 
     */
    public function getPageEn()
    {
        return $this->page_en;
    }

    /**
     * Set fichier_source_fr
     *
     * @param string $fichierSourceFr
     */
    public function setFichierSourceFr($fichierSourceFr)
    {
        $this->fichier_source_fr = $fichierSourceFr;
    }

    /**
     * Get fichier_source_fr
     *
     * @return string 
     */
    public function getFichierSourceFr()
    {
        return $this->fichier_source_fr;
    }

    /**
     * Set fichier_source_en
     *
     * @param string $fichierSourceEn
     */
    public function setFichierSourceEn($fichierSourceEn)
    {
        $this->fichier_source_en = $fichierSourceEn;
    }

    /**
     * Get fichier_source_en
     *
     * @return string 
     */
    public function getFichierSourceEn()
    {
        return $this->fichier_source_en;
    }

    /**
     * Set affiche_resume
     *
     * @param text $afficheResume
     */
    public function setAfficheResume($afficheResume)
    {
        $this->affiche_resume = $afficheResume;
    }

    /**
     * Get affiche_resume
     *
     * @return text 
     */
    public function getAfficheResume()
    {
        return $this->affiche_resume;
    }

    /**
     * Set affiche_image_entete
     *
     * @param string $afficheImageEntete
     */
    public function setAfficheImageEntete($afficheImageEntete)
    {
        $this->affiche_image_entete = $afficheImageEntete;
    }

    /**
     * Get affiche_image_entete
     *
     * @return string 
     */
    public function getAfficheImageEntete()
    {
        return $this->affiche_image_entete;
    }

    /**
     * Set affiche_image_accueil
     *
     * @param string $afficheImageAccueil
     */
    public function setAfficheImageAccueil($afficheImageAccueil)
    {
        $this->affiche_image_accueil = $afficheImageAccueil;
    }

    /**
     * Get affiche_image_accueil
     *
     * @return string 
     */
    public function getAfficheImageAccueil()
    {
        return $this->affiche_image_accueil;
    }

    /**
     * Set affiche_image_article
     *
     * @param string $afficheImageArticle
     */
    public function setAfficheImageArticle($afficheImageArticle)
    {
        $this->affiche_image_article = $afficheImageArticle;
    }

    /**
     * Get affiche_image_article
     *
     * @return string 
     */
    public function getAfficheImageArticle()
    {
        return $this->affiche_image_article;
    }

    /**
     * Set image_thematique
     *
     * @param string $imageThematique
     */
    public function setImageThematique($imageThematique)
    {
        $this->image_thematique = $imageThematique;
    }

    /**
     * Get image_thematique
     *
     * @return string 
     */
    public function getImageThematique()
    {
        return $this->image_thematique;
    }

    /**
     * Set image_bas_page
     *
     * @param string $imageBasPage
     */
    public function setImageBasPage($imageBasPage)
    {
        $this->image_bas_page = $imageBasPage;
    }

    /**
     * Get image_bas_page
     *
     * @return string 
     */
    public function getImageBasPage()
    {
        return $this->image_bas_page;
    }

    /**
     * Set largeur_image_accueil
     *
     * @param string $largeurImageAccueil
     */
    public function setLargeurImageAccueil($largeurImageAccueil)
    {
        $this->largeur_image_accueil = $largeurImageAccueil;
    }

    /**
     * Get largeur_image_accueil
     *
     * @return string 
     */
    public function getLargeurImageAccueil()
    {
        return $this->largeur_image_accueil;
    }

    /**
     * Set largeur_apercu_image_home
     *
     * @param string $largeurApercuImageHome
     */
    public function setLargeurApercuImageHome($largeurApercuImageHome)
    {
        $this->largeur_apercu_image_home = $largeurApercuImageHome;
    }

    /**
     * Get largeur_apercu_image_home
     *
     * @return string 
     */
    public function getLargeurApercuImageHome()
    {
        return $this->largeur_apercu_image_home;
    }

    /**
     * Set hauteur_image_home
     *
     * @param string $hauteurImageHome
     */
    public function setHauteurImageHome($hauteurImageHome)
    {
        $this->hauteur_image_home = $hauteurImageHome;
    }

    /**
     * Get hauteur_image_home
     *
     * @return string 
     */
    public function getHauteurImageHome()
    {
        return $this->hauteur_image_home;
    }

    /**
     * Set hauteur_apercu_image_home
     *
     * @param string $hauteurApercuImageHome
     */
    public function setHauteurApercuImageHome($hauteurApercuImageHome)
    {
        $this->hauteur_apercu_image_home = $hauteurApercuImageHome;
    }

    /**
     * Get hauteur_apercu_image_home
     *
     * @return string 
     */
    public function getHauteurApercuImageHome()
    {
        return $this->hauteur_apercu_image_home;
    }

    /**
     * Set repertoire_fr
     *
     * @param string $repertoireFr
     */
    public function setRepertoireFr($repertoireFr)
    {
        $this->repertoire_fr = $repertoireFr;
    }

    /**
     * Get repertoire_fr
     *
     * @return string 
     */
    public function getRepertoireFr()
    {
        return $this->repertoire_fr;
    }

    /**
     * Set repertoire_en
     *
     * @param string $repertoireEn
     */
    public function setRepertoireEn($repertoireEn)
    {
        $this->repertoire_en = $repertoireEn;
    }

    /**
     * Get repertoire_en
     *
     * @return string 
     */
    public function getRepertoireEn()
    {
        return $this->repertoire_en;
    }
}