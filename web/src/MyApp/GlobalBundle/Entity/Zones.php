<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\ZonesRepository")
 * @ORM\Table(name = "zones")
 * @ORM\HasLifecycleCallbacks
 */
class Zones{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Regions", inversedBy = "Zones")
	 * @ORM\JoinColumn(name="region_id", referencedColumnName="id", onDelete="CASCADE")
	 * 
	 * @var integer $region_id
	 */
	private $region_id;
	
	/**
	 * @ORM\Column(type = "string", length = "255")
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length = "255")
	 * 
	 * @var string nom_en
	 */
	private $nom_en;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable = "true")
	 * 
	 * @var string $titre_fr
	 */
	private $titre_fr;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable = "true")
	 * 
	 * @var string $titre_en
	 */
	private $titre_en;
	
	/**
	 * @ORM\Column(type = "text", nullable="true")
	 * 
	 * @var text $texte_fr
	 */
	private $texte_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable="true")
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
	 * @ORM\Column(type = "string", length = "255", nullable = "true")
	 * 
	 * @var string $image_haut_fr
	 */
	private $image_haut_fr;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable = "true")
	 * 
	 * @var string $image_haut_en
	 */
	private $image_haut_en;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable = "true")
	 * 
	 * @var string $image_gauche
	 */
	private $image_gauche;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable = "true")
	 * 
	 * @var string $image_centre
	 */
	private $image_centre;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable = "true")
	 *
	 * @var string $image_suggestion
	 */
	private $image_suggestion;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable = "true")
	 *
	 * @var string $image_suggestion_doctrine
	 */
	private $image_suggestion_doctrine;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable = true)
	 * 
	 * @var string $page_metakeyword_fr
	 */
	private $page_metakeyword_fr;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable = true)
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
	 * @ORM\Column(type = "text")
	 *
	 * @var text $texte_resume_fr
	 */
	private $texte_resume_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $texte_resume_en
	 */
	private $texte_resume_en;
	
	/**
	 * @ORM\Column(type = "string", nullable = true)
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
	 * @ORM\OneToMany(targetEntity = "Villes", mappedBy = "Zones", fetch="EXTRA_LAZY")
	 * 
	 * @var integer $ville_id
	 */
	private $ville_id;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Attraits", mappedBy = "Zones", fetch="EXTRA_LAZY")
	 *
	 * @var integer $attrait_id
	 */
	private $attrait_id;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Hebergements", mappedBy = "Zones", fetch="EXTRA_LAZY")
	 *
	 * @var integer $hebergement_id
	 */
	private $hebergement_id;
	
	public function __toString()
	{
		return $this->nom_fr;
	}
	
	public function getFullPicturePath() {
		return null === $this->image_suggestion ? null : $this->getUploadRootDir(). $this->image_suggestion;
	}
	
	protected function getUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDir().$this->getId()."/";
	}
	
	protected function getTmpUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/zones/';
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function uploadPicture() {
		// the file property can be empty if the field is not required
		if (null === $this->image_suggestion) {
			return;
		}
		if (null === $this->image_suggestion_doctrine) {
			return;
		}
		if(!$this->id){
			$this->image_suggestion->move($this->getTmpUploadRootDir(), $this->image_suggestion->getClientOriginalName());
		}else{
			$this->image_suggestion->move($this->getUploadRootDir(), $this->image_suggestion->getClientOriginalName());
		}
		$this->setImageSuggestion($this->image_suggestion->getClientOriginalName());
	}
	
	
	/**
	 * @ORM\PostPersist()
	 */
	public function movePicture()
	{
		if (null === $this->image_suggestion) {
			return;
		}
	
		if(!is_dir($this->getUploadRootDir())){
			mkdir($this->getUploadRootDir());
		}
		copy($this->getTmpUploadRootDir().$this->image_suggestion, $this->getFullPicturePath());
		unlink($this->getTmpUploadRootDir().$this->image_suggestion);
	}
	
	/**
	 * @ORM\PreRemove()
	 */
	public function removePicture()
	{
		unlink($this->getFullPicturePath());
		rmdir($this->getUploadRootDir());
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
    
    public function __construct()
    {
        $this->ville_id = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add ville_id
     *
     * @param MyApp\GlobalBundle\Entity\Villes $villeId
     */
    public function addVilles(\MyApp\GlobalBundle\Entity\Villes $villeId)
    {
        $this->ville_id[] = $villeId;
    }

    /**
     * Get ville_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVilleId()
    {
        return $this->ville_id;
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
     * Set texte_resume_fr
     *
     * @param text $texteResumeFr
     */
    public function setTexteResumeFr($texteResumeFr)
    {
        $this->texte_resume_fr = $texteResumeFr;
    }

    /**
     * Get texte_resume_fr
     *
     * @return text 
     */
    public function getTexteResumeFr()
    {
        return $this->texte_resume_fr;
    }

    /**
     * Set texte_resume_en
     *
     * @param text $texteResumeEn
     */
    public function setTexteResumeEn($texteResumeEn)
    {
        $this->texte_resume_en = $texteResumeEn;
    }

    /**
     * Get texte_resume_en
     *
     * @return text 
     */
    public function getTexteResumeEn()
    {
        return $this->texte_resume_en;
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
     * Set image_suggestion_doctrine
     *
     * @param string $imageSuggestionDoctrine
     */
    public function setImageSuggestionDoctrine($imageSuggestionDoctrine)
    {
        $this->image_suggestion_doctrine = $imageSuggestionDoctrine;
    }

    /**
     * Get image_suggestion_doctrine
     *
     * @return string 
     */
    public function getImageSuggestionDoctrine()
    {
        return $this->image_suggestion_doctrine;
    }
}