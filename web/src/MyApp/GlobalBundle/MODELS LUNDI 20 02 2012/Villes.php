<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "villes")
 */
class Villes{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Zones")
	 * @ORM\JoinColumn(name = "zone_id" , referencedColumnName = "id")
	 * 
	 * @var ArrayCollection $zone_id
	 */
	private $zone_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Regions")
	 * @ORM\JoinColumn(name = "region_id", referencedColumnName="id")
	 * 
	 * @var ArrayCollection $region_id
	 */
	private $region_id;

	/**
	* @ORM\ManyToMany(targetEntity="Soins_sante", mappedBy = "Villes")
	*
	* @var ArrayCollection $soins_sante_id
	*/
	private $soins_sante_id;	
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
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
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $titre_fr
	 */
	private $titre_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $titre_en
	 */
	private $titre_en;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_fr
	 */
	private $texte_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_en
	 */
	private $texte_en;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $latitude
	 */
	private $latitude;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $longitude
	 */
	private $longitude;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_fr
	 */
	private $page_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
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
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_titre_en
	 */
	private $page_titre_en;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_metakeyword_fr
	 */
	private $page_metakeyword_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
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
	 * @ORM\Column(type = "string" , length = 255)
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
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $default_hebergement
	 */
	private $default_hebergement;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $default_attrait
	 */
	private $default_attrait;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $reservit_id
	 */
	private $reservit_id;	
	
	public function __construct()
	{
		$this->zone_id = new ArrayCollection();
		$this->region_id = new ArrayCollection();
		$this->soins_sante_id = new ArrayCollection();
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
     * Set titre_fr
     *
     * @param text $titreFr
     */
    public function setTitreFr($titreFr)
    {
        $this->titre_fr = $titreFr;
    }

    /**
     * Get titre_fr
     *
     * @return text 
     */
    public function getTitreFr()
    {
        return $this->titre_fr;
    }

    /**
     * Set titre_en
     *
     * @param text $titreEn
     */
    public function setTitreEn($titreEn)
    {
        $this->titre_en = $titreEn;
    }

    /**
     * Get titre_en
     *
     * @return text 
     */
    public function getTitreEn()
    {
        return $this->titre_en;
    }

    /**
     * Set texte_fr
     *
     * @param text $texteFr
     */
    public function setTexteFr($texteFr)
    {
        $this->texte_fr = $texteFr;
    }

    /**
     * Get texte_fr
     *
     * @return text 
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
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
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
     * Set default_hebergement
     *
     * @param boolean $defaultHebergement
     */
    public function setDefaultHebergement($defaultHebergement)
    {
        $this->default_hebergement = $defaultHebergement;
    }

    /**
     * Get default_hebergement
     *
     * @return boolean 
     */
    public function getDefaultHebergement()
    {
        return $this->default_hebergement;
    }

    /**
     * Set default_attrait
     *
     * @param boolean $defaultAttrait
     */
    public function setDefaultAttrait($defaultAttrait)
    {
        $this->default_attrait = $defaultAttrait;
    }

    /**
     * Get default_attrait
     *
     * @return boolean 
     */
    public function getDefaultAttrait()
    {
        return $this->default_attrait;
    }

    /**
     * Set reservit_id
     *
     * @param string $reservitId
     */
    public function setReservitId($reservitId)
    {
        $this->reservit_id = $reservitId;
    }

    /**
     * Get reservit_id
     *
     * @return string 
     */
    public function getReservitId()
    {
        return $this->reservit_id;
    }

    /**
     * Set zone_id
     *
     * @param MyApp\GlobalBundle\Entity\Zones $zoneId
     */
    public function setZoneId(\MyApp\GlobalBundle\Entity\Zones $zoneId)
    {
        $this->zone_id = $zoneId;
    }

    /**
     * Get zone_id
     *
     * @return MyApp\GlobalBundle\Entity\Zones 
     */
    public function getZoneId()
    {
        return $this->zone_id;
    }

    /**
     * Set region_id
     *
     * @param MyApp\GlobalBundle\Entity\Regions $regionId
     */
    public function setRegionId(\MyApp\GlobalBundle\Entity\Regions $regionId)
    {
        $this->region_id = $regionId;
    }

    /**
     * Get region_id
     *
     * @return MyApp\GlobalBundle\Entity\Regions 
     */
    public function getRegionId()
    {
        return $this->region_id;
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
}