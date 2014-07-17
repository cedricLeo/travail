<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Provinces_etatsRepository")
 * @ORM\Table(name = "regions")
 */
class Regions{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Provinces_etats", inversedBy="Regions")
	 * 
	 * @var integer $province_etat_id
	 */
	private $province_etat_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Soins_sante", inversedBy = "Regions")
	 * @ORM\JoinTable(name="relations_regions_soins_sante")
	 *
	 * @var ArrayCollection $soins_sante_id
	 */
	private $soins_sante_id;
	
	/**
	* @ORM\ManyToMany(targetEntity = "Attraits_categories")
	* @ORM\JoinTable(name = "relations_regions_attraits_categories",
	* 		joinColumns={@ORM\JoinColumn(name = "region_id", referencedColumnName = "id")},
	* 		inverseJoinColumns={@ORM\JoinColumn(name = "attrait_categorie_id", referencedColumnName = "id")}
	* )
	*
	* @var ArrayCollection $attrait_categorie_id
	*/
	private $attrait_categorie_id;

	
	/**
	 * @ORM\ManyToMany(targetEntity = "Qcs_saisons", inversedBy = "Regions")
	 * @ORM\JoinTable(name = "relations_regions_qcs_saisons")
	 * 
	 * @var ArrayCollection $qcs_saison_id
	 */
	private $qcs_saison_id;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $nom_en
	 */
	private $nom_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $url_fr
	 */
	private $url_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $url_en
	 */
	private $url_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $titre_fr
	 */
	private $titre_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $titre_en
	 */
	private $titre_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $texte_fr
	 */
	private $texte_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_en
	 */
	private $texte_en;
	
	/**
	 * @ORM\Column(type = "float")
	 * 
	 * @var float $latitude
	 */
	private $latitude;
	
	/**
	 * @ORM\Column(type = "float")
	 * 
	 * @var float $longitude
	 */
	private $longitude;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $image_haut_fr
	 */
	private $image_haut_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $image_haut_en
	 */
	private $image_haut_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $image_gauche
	 */
	private $image_gauche;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $image_centre
	 */
	private $image_centre;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $texte_fr_bas_page
	 */
	private $texte_fr_bas_page;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $texte_en_bas_page
	 */
	private $texte_en_bas_page;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $image_travel
	 */
	private $image_travel;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var string $resume_fr_travel
	 */
	private $resume_fr_travel;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $resume_en_travel
	 */
	private $resume_en_travel;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_fr
	 */
	private $page_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_en
	 */
	private $page_en;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_titre_fr
	 */
	private $page_titre_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string page_titre_en
	 */
	private $page_titre_en;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_metakeyword_fr
	 */
	private $page_metakeyword_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_metakeyword_en
	 */
	private $page_metakeyword_en;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_metadescription_fr
	 */
	private $page_metadescription_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_metadescription_en
	 */
	private $page_metadescription_en;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_accueil_fr
	 */
	private $texte_accueil_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_accueil_en
	 */
	private $texte_accueil_en;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $image_suggestion
	 */
	private $image_suggestion;
	
	/**
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $reservit_id
	 */
	private $reservit_id;

	/**
	 * @ORM\OneToMany(targetEntity = "Zones", mappedBy = "Regions")
	 * 
	 * @var integer $zone_id
	 */
	private $zone_id;
	
	public function __construct()
	{
		$this->soins_sante_id = new ArrayCollection();
		$this->attrait_categorie_id = new ArrayCollection();
		$this->qcs_saison_id = new ArrayCollection();
	}
	
	public function __toString()
	{
		return $this->nomfr;
	}


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
     * Set nom_fr
     *
     * @param string $nomFr
     */
    public function setNomFr($nomFr)
    {
        $this->nom_fr = $nomFr;
    }

    /**
     * Get nom_fr
     *
     * @return string 
     */
    public function getNomFr()
    {
        return $this->nom_fr;
    }

    /**
     * Set nom_en
     *
     * @param string $nomEn
     */
    public function setNomEn($nomEn)
    {
        $this->nom_en = $nomEn;
    }

    /**
     * Get nom_en
     *
     * @return string 
     */
    public function getNomEn()
    {
        return $this->nom_en;
    }

    /**
     * Set url_fr
     *
     * @param string $urlFr
     */
    public function setUrlFr($urlFr)
    {
        $this->url_fr = $urlFr;
    }

    /**
     * Get url_fr
     *
     * @return string 
     */
    public function getUrlFr()
    {
        return $this->url_fr;
    }

    /**
     * Set url_en
     *
     * @param string $urlEn
     */
    public function setUrlEn($urlEn)
    {
        $this->url_en = $urlEn;
    }

    /**
     * Get url_en
     *
     * @return string 
     */
    public function getUrlEn()
    {
        return $this->url_en;
    }

    /**
     * Set titre_fr
     *
     * @param string $titreFr
     */
    public function setTitreFr($titreFr)
    {
        $this->titre_fr = $titreFr;
    }

    /**
     * Get titre_fr
     *
     * @return string 
     */
    public function getTitreFr()
    {
        return $this->titre_fr;
    }

    /**
     * Set titre_en
     *
     * @param string $titreEn
     */
    public function setTitreEn($titreEn)
    {
        $this->titre_en = $titreEn;
    }

    /**
     * Get titre_en
     *
     * @return string 
     */
    public function getTitreEn()
    {
        return $this->titre_en;
    }

    /**
     * Set texte_fr
     *
     * @param string $texteFr
     */
    public function setTexteFr($texteFr)
    {
        $this->texte_fr = $texteFr;
    }

    /**
     * Get texte_fr
     *
     * @return string 
     */
    public function getTexteFr()
    {
        return $this->texte_fr;
    }

    /**
     * Set texte_en
     *
     * @param text $texteEn
     */
    public function setTexteEn($texteEn)
    {
        $this->texte_en = $texteEn;
    }

    /**
     * Get texte_en
     *
     * @return text 
     */
    public function getTexteEn()
    {
        return $this->texte_en;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set image_haut_fr
     *
     * @param string $imageHautFr
     */
    public function setImageHautFr($imageHautFr)
    {
        $this->image_haut_fr = $imageHautFr;
    }

    /**
     * Get image_haut_fr
     *
     * @return string 
     */
    public function getImageHautFr()
    {
        return $this->image_haut_fr;
    }

    /**
     * Set image_haut_en
     *
     * @param string $imageHautEn
     */
    public function setImageHautEn($imageHautEn)
    {
        $this->image_haut_en = $imageHautEn;
    }

    /**
     * Get image_haut_en
     *
     * @return string 
     */
    public function getImageHautEn()
    {
        return $this->image_haut_en;
    }

    /**
     * Set image_gauche
     *
     * @param string $imageGauche
     */
    public function setImageGauche($imageGauche)
    {
        $this->image_gauche = $imageGauche;
    }

    /**
     * Get image_gauche
     *
     * @return string 
     */
    public function getImageGauche()
    {
        return $this->image_gauche;
    }

    /**
     * Set image_centre
     *
     * @param string $imageCentre
     */
    public function setImageCentre($imageCentre)
    {
        $this->image_centre = $imageCentre;
    }

    /**
     * Get image_centre
     *
     * @return string 
     */
    public function getImageCentre()
    {
        return $this->image_centre;
    }

    /**
     * Set texte_fr_bas_page
     *
     * @param string $texteFrBasPage
     */
    public function setTexteFrBasPage($texteFrBasPage)
    {
        $this->texte_fr_bas_page = $texteFrBasPage;
    }

    /**
     * Get texte_fr_bas_page
     *
     * @return string 
     */
    public function getTexteFrBasPage()
    {
        return $this->texte_fr_bas_page;
    }

    /**
     * Set texte_en_bas_page
     *
     * @param string $texteEnBasPage
     */
    public function setTexteEnBasPage($texteEnBasPage)
    {
        $this->texte_en_bas_page = $texteEnBasPage;
    }

    /**
     * Get texte_en_bas_page
     *
     * @return string 
     */
    public function getTexteEnBasPage()
    {
        return $this->texte_en_bas_page;
    }

    /**
     * Set image_travel
     *
     * @param string $imageTravel
     */
    public function setImageTravel($imageTravel)
    {
        $this->image_travel = $imageTravel;
    }

    /**
     * Get image_travel
     *
     * @return string 
     */
    public function getImageTravel()
    {
        return $this->image_travel;
    }

    /**
     * Set resume_fr_travel
     *
     * @param text $resumeFrTravel
     */
    public function setResumeFrTravel($resumeFrTravel)
    {
        $this->resume_fr_travel = $resumeFrTravel;
    }

    /**
     * Get resume_fr_travel
     *
     * @return text 
     */
    public function getResumeFrTravel()
    {
        return $this->resume_fr_travel;
    }

    /**
     * Set resume_en_travel
     *
     * @param text $resumeEnTravel
     */
    public function setResumeEnTravel($resumeEnTravel)
    {
        $this->resume_en_travel = $resumeEnTravel;
    }

    /**
     * Get resume_en_travel
     *
     * @return text 
     */
    public function getResumeEnTravel()
    {
        return $this->resume_en_travel;
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
     * Set page_titre_fr
     *
     * @param string $pageTitreFr
     */
    public function setPageTitreFr($pageTitreFr)
    {
        $this->page_titre_fr = $pageTitreFr;
    }

    /**
     * Get page_titre_fr
     *
     * @return string 
     */
    public function getPageTitreFr()
    {
        return $this->page_titre_fr;
    }

    /**
     * Set page_titre_en
     *
     * @param string $pageTitreEn
     */
    public function setPageTitreEn($pageTitreEn)
    {
        $this->page_titre_en = $pageTitreEn;
    }

    /**
     * Get page_titre_en
     *
     * @return string 
     */
    public function getPageTitreEn()
    {
        return $this->page_titre_en;
    }

    /**
     * Set page_metakeyword_fr
     *
     * @param string $pageMetakeywordFr
     */
    public function setPageMetakeywordFr($pageMetakeywordFr)
    {
        $this->page_metakeyword_fr = $pageMetakeywordFr;
    }

    /**
     * Get page_metakeyword_fr
     *
     * @return string 
     */
    public function getPageMetakeywordFr()
    {
        return $this->page_metakeyword_fr;
    }

    /**
     * Set page_metakeyword_en
     *
     * @param string $pageMetakeywordEn
     */
    public function setPageMetakeywordEn($pageMetakeywordEn)
    {
        $this->page_metakeyword_en = $pageMetakeywordEn;
    }

    /**
     * Get page_metakeyword_en
     *
     * @return string 
     */
    public function getPageMetakeywordEn()
    {
        return $this->page_metakeyword_en;
    }

    /**
     * Set page_metadescription_fr
     *
     * @param string $pageMetadescriptionFr
     */
    public function setPageMetadescriptionFr($pageMetadescriptionFr)
    {
        $this->page_metadescription_fr = $pageMetadescriptionFr;
    }

    /**
     * Get page_metadescription_fr
     *
     * @return string 
     */
    public function getPageMetadescriptionFr()
    {
        return $this->page_metadescription_fr;
    }

    /**
     * Set page_metadescription_en
     *
     * @param string $pageMetadescriptionEn
     */
    public function setPageMetadescriptionEn($pageMetadescriptionEn)
    {
        $this->page_metadescription_en = $pageMetadescriptionEn;
    }

    /**
     * Get page_metadescription_en
     *
     * @return string 
     */
    public function getPageMetadescriptionEn()
    {
        return $this->page_metadescription_en;
    }

    /**
     * Set texte_accueil_fr
     *
     * @param text $texteAccueilFr
     */
    public function setTexteAccueilFr($texteAccueilFr)
    {
        $this->texte_accueil_fr = $texteAccueilFr;
    }

    /**
     * Get texte_accueil_fr
     *
     * @return text 
     */
    public function getTexteAccueilFr()
    {
        return $this->texte_accueil_fr;
    }

    /**
     * Set texte_accueil_en
     *
     * @param text $texteAccueilEn
     */
    public function setTexteAccueilEn($texteAccueilEn)
    {
        $this->texte_accueil_en = $texteAccueilEn;
    }

    /**
     * Get texte_accueil_en
     *
     * @return text 
     */
    public function getTexteAccueilEn()
    {
        return $this->texte_accueil_en;
    }

    /**
     * Set image_suggestion
     *
     * @param string $imageSuggestion
     */
    public function setImageSuggestion($imageSuggestion)
    {
        $this->image_suggestion = $imageSuggestion;
    }

    /**
     * Get image_suggestion
     *
     * @return string 
     */
    public function getImageSuggestion()
    {
        return $this->image_suggestion;
    }

    /**
     * Set reservit_id
     *
     * @param integer $reservitId
     */
    public function setReservitId($reservitId)
    {
        $this->reservit_id = $reservitId;
    }

    /**
     * Get reservit_id
     *
     * @return integer 
     */
    public function getReservitId()
    {
        return $this->reservit_id;
    }

    /**
     * Set province_etat_id
     *
     * @param MyApp\GlobalBundle\Entity\Provinces_etats $provinceEtatId
     */
    public function setProvinceEtatId(\MyApp\GlobalBundle\Entity\Provinces_etats $provinceEtatId)
    {
        $this->province_etat_id = $provinceEtatId;
    }

    /**
     * Get province_etat_id
     *
     * @return MyApp\GlobalBundle\Entity\Provinces_etats 
     */
    public function getProvinceEtatId()
    {
        return $this->province_etat_id;
    }

    /**
     * Add soins_sante_id
     *
     * @param MyApp\GlobalBundle\Entity\Soins_sante $soinsSanteId
     */
    public function addSoins_sante(\MyApp\GlobalBundle\Entity\Soins_sante $soinsSanteId)
    {
        $this->soins_sante_id[] = $soinsSanteId;
    }

    /**
     * Get soins_sante_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSoinsSanteId()
    {
        return $this->soins_sante_id;
    }

    /**
     * Add attrait_categorie_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits_categories $attraitCategorieId
     */
    public function addAttraits_categories(\MyApp\GlobalBundle\Entity\Attraits_categories $attraitCategorieId)
    {
        $this->attrait_categorie_id[] = $attraitCategorieId;
    }

    /**
     * Get attrait_categorie_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitCategorieId()
    {
        return $this->attrait_categorie_id;
    }

    /**
     * Add qcs_type_saison_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_types_saisons $qcsTypeSaisonId
     */
    public function addQcs_types_saisons(\MyApp\GlobalBundle\Entity\Qcs_types_saisons $qcsTypeSaisonId)
    {
        $this->qcs_type_saison_id[] = $qcsTypeSaisonId;
    }

    /**
     * Get qcs_type_saison_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsTypeSaisonId()
    {
        return $this->qcs_type_saison_id;
    }

    /**
     * Add zone_id
     *
     * @param MyApp\GlobalBundle\Entity\Zones $zoneId
     */
    public function addZones(\MyApp\GlobalBundle\Entity\Zones $zoneId)
    {
        $this->zone_id[] = $zoneId;
    }

    /**
     * Get zone_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getZoneId()
    {
        return $this->zone_id;
    }

    /**
     * Add qcs_saison_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_saisons $qcsSaisonId
     */
    public function addQcs_saisons(\MyApp\GlobalBundle\Entity\Qcs_saisons $qcsSaisonId)
    {
        $this->qcs_saison_id[] = $qcsSaisonId;
    }

    /**
     * Get qcs_saison_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsSaisonId()
    {
        return $this->qcs_saison_id;
    }
}