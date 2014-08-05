<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\VillesRepository")
 * @ORM\Table(name = "villes", indexes={@ORM\index(name="ville_idx", columns={"id", "nom_fr"})})
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\ManyToOne(targetEntity = "Zones", inversedBy = "Villes")
     * @ORM\JoinColumn(name = "zone_id" , referencedColumnName = "id")
     * 
     * @var integer $zone_id
     */
    private $zone_id;

    /**
     * @ORM\ManyToOne(targetEntity = "Regions", inversedBy = "Villes")
     * @ORM\JoinColumn(name = "region_id", referencedColumnName = "id")
     *
     * @var integer $region_id
     */
    private $region_id;

    /**
     * @ORM\Column(type = "string",  length = 255)
     *
     * @var string $nom_fr
     */
    private $nom_fr;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $nom_en
     */
    private $nom_en;
    
    /**
     * @ORM\Column(type = "string",  nullable = true)
     *
     * @var string $repertoire_fr
     */
    private $repertoire_fr;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * 
     * @var string $repertoire_en
     */
    private $repertoire_en;
    
    /**
     * @ORM\Column(type = "string",  length = 255, nullable = true)
     *
     * @var string $page_titre_fr
     */
    private $page_titre_fr;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = true)
     * 
     * @var string $page_titre_en
     */
    private $page_titre_en;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_fr
     */
    private $texte_fr;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_en
     */
    private $texte_en;

    /**
     * @ORM\Column(type = "float", nullable = true)
     * 
     * @var float $latitude
     */
    private $latitude;

    /**
     * @ORM\Column(type = "float", nullable = true)
     * 
     * @var float $longitude
     */
    private $longitude;

    /**
     * @ORM\Column(type = "string" , length = 255, nullable = true)
     * 
     * @var string $page_metakeyword_fr
     */
    private $page_metakeyword_fr;

    /**
     * @ORM\Column(type = "string" , length = 255, nullable = true)
     * 
     * @var string $page_metakeyword_en
     */
    private $page_metakeyword_en;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * 
     * @var text $page_metadescription_fr
     */
    private $page_metadescription_fr;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * 
     * @var text $page_metadescription_en
     */
    private $page_metadescription_en;
    
    /**
     * @ORM\Column(type = "string", length = 60, nullable = true)
     * 
     * @var string $nom_reservit
     */
    private $nom_reservit;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * 
     * @var text $texte_accueil_fr
     */
    private $texte_accueil_fr;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * 
     * @var text $texte_accueil_en
     */
    private $texte_accueil_en;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $default_hebergement
     */
    private $default_hebergement;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $default_attrait
     */
    private $default_attrait;

    /**
     * @ORM\Column(type = "integer", nullable = true)
     * 
     * @var integer $reservit_id
     */
    private $reservit_id;

    /**
     * @ORM\Column(type = "boolean", nullable = true)
     *
     * @var boolean $affiche
     */
    private $affiche;

    /**
     * @ORM\OneToMany(targetEntity = "Hebergements", mappedBy = "Villes", fetch="EXTRA_LAZY")
     * 
     * @var integer $hebergement_id
     */
    private $hebergement_id;

    /**
     * @ORM\OneToMany(targetEntity = "Attraits", mappedBy = "Villes", fetch="EXTRA_LAZY")
     *
     * @var integer $attrait_id
     */
    private $attrait_id;

    /**
     * @ORM\OneToMany(targetEntity = "Utilisateur", mappedBy = "Villes")
     *
     * @var integer $utilisateur
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity = "Videos", mappedBy = "Villes")
     *
     * @var integer $video
     */
    private $video;

    /**
     * @ORM\Column(type = "string", length = 10, nullable = true)
     *
     * @var string $code_meteo_media
     */
    private $code_meteo_media;

    public function __toString()
    {
            return $this->nom_fr;
    }
	
        
    public function __construct()
    {
        $this->hebergement_id = new \Doctrine\Common\Collections\ArrayCollection();
        $this->attrait_id = new \Doctrine\Common\Collections\ArrayCollection();
        $this->utilisateur = new \Doctrine\Common\Collections\ArrayCollection();
        $this->video = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param text $pageMetadescriptionFr
     */
    public function setPageMetadescriptionFr($pageMetadescriptionFr)
    {
        $this->page_metadescription_fr = $pageMetadescriptionFr;
    }

    /**
     * Get page_metadescription_fr
     *
     * @return text 
     */
    public function getPageMetadescriptionFr()
    {
        return $this->page_metadescription_fr;
    }

    /**
     * Set page_metadescription_en
     *
     * @param text $pageMetadescriptionEn
     */
    public function setPageMetadescriptionEn($pageMetadescriptionEn)
    {
        $this->page_metadescription_en = $pageMetadescriptionEn;
    }

    /**
     * Get page_metadescription_en
     *
     * @return text 
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
     * Set affiche
     *
     * @param boolean $affiche
     */
    public function setAffiche($affiche)
    {
        $this->affiche = $affiche;
    }

    /**
     * Get affiche
     *
     * @return boolean 
     */
    public function getAffiche()
    {
        return $this->affiche;
    }

    /**
     * Set code_meteo_media
     *
     * @param string $codeMeteoMedia
     */
    public function setCodeMeteoMedia($codeMeteoMedia)
    {
        $this->code_meteo_media = $codeMeteoMedia;
    }

    /**
     * Get code_meteo_media
     *
     * @return string 
     */
    public function getCodeMeteoMedia()
    {
        return $this->code_meteo_media;
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
     * Add hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementId
     */
    public function addHebergements(\MyApp\GlobalBundle\Entity\Hebergements $hebergementId)
    {
        $this->hebergement_id[] = $hebergementId;
    }

    /**
     * Get hebergement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementId()
    {
        return $this->hebergement_id;
    }

    /**
     * Add attrait_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits $attraitId
     */
    public function addAttraits(\MyApp\GlobalBundle\Entity\Attraits $attraitId)
    {
        $this->attrait_id[] = $attraitId;
    }

    /**
     * Get attrait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitId()
    {
        return $this->attrait_id;
    }

    /**
     * Add utilisateur
     *
     * @param MyApp\GlobalBundle\Entity\Utilisateur $utilisateur
     */
    public function addUtilisateur(\MyApp\GlobalBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur[] = $utilisateur;
    }

    /**
     * Get utilisateur
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Add video
     *
     * @param MyApp\GlobalBundle\Entity\Videos $video
     */
    public function addVideos(\MyApp\GlobalBundle\Entity\Videos $video)
    {
        $this->video[] = $video;
    }

    /**
     * Get video
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVideo()
    {
        return $this->video;
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

    /**
     * Set nom_reservit
     *
     * @param string $nomReservit
     */
    public function setNomReservit($nomReservit)
    {
        $this->nom_reservit = $nomReservit;
    }

    /**
     * Get nom_reservit
     *
     * @return string 
     */
    public function getNomReservit()
    {
        return $this->nom_reservit;
    }
}