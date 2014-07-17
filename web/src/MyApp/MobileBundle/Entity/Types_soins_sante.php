<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\Types_soins_santeRepository")
 * @ORM\Table(name = "types_soins_sante" )
 * @ORM\HasLifecycleCallbacks
 */
class Types_soins_sante{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type = "string", length = "100", nullable = true)
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length = "100", nullable = true)
	 *
	 * @var string $nom_en
	 */
	private $nom_en;
        
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
	 * @ORM\Column(type = "string", length = "255", nullable = true)
	 *
	 * @var string $metakeyword_fr
	 */
	private $metakeyword_fr;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable = true)
	 *
	 * @var string $metakeyword_en
	 */
	private $metakeyword_en;
	
	/**
	 * @ORM\Column(type = "text", nullable = true)
	 *
	 * @var text $metadescription_fr
	 */
	private $metadescription_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = true)
	 *
	 * @var text $metadescription_en
	 */
	private $metadescription_en;
	
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
	 * @ORM\Column(type = "text", nullable = "true")
	 *
	 * @var text $resume_fr
	 */
	private $resume_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 *
	 * @var text $resume_en
	 */
	private $resume_en;
	
	/**
	 * @ORM\Column(type = "string", length = "50", nullable = "true")
	 *
	 * @var string $image
	 */
	private $image;
	
	/**
	 * @ORM\Column(type = "string", length = "50", nullable = "true")
	 *
	 * @var string $image_doctrine
	 */
	private $image_doctrine;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Attraits", mappedBy = "Types_soins_sante")
	 *
	 * @var ArrayCollection $attrait_id
	 */
	private $attrait_id;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Soins_sante", mappedBy = "Types_soins_sante", fetch="EXTRA_LAZY")
	 *
	 * @var integer $soins_sante_id
	 */
	private $soins_sante_id;
        
        /**
	 * @ORM\OneToMany(targetEntity = "Texte_region_sante", mappedBy = "Types_soins_sante", cascade={"remove"})
	 *
	 * @var integer $texte_region_sante
	 */
	private $texte_region_sante;
        
        /**
	 * @ORM\OneToMany(targetEntity = "Texte_province_sante", mappedBy = "Types_soins_sante", cascade={"remove"})
	 *
	 * @var integer $texte_province_sante
	 */
	private $texte_province_sante;
	
	public function getFullPicturePath() {
		return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
	}
	
	protected function getUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDir().$this->getId()."/";
	}
	
	protected function getTmpUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/type_soin/';
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function uploadPicture() {
		// the file property can be empty if the field is not required
		if (null === $this->image) {
			return;
		}
		if (null === $this->image_doctrine) {
			return;
		}
		if(!$this->id){
			$this->image->move($this->getTmpUploadRootDir(), $this->image->getClientOriginalName());
		}else{
			$this->image->move($this->getUploadRootDir(), $this->image->getClientOriginalName());
		}
		$this->setImage($this->image->getClientOriginalName());
	}
	
	/**
	 * @ORM\PostPersist()
	 */
	public function movePicture()
	{
		if (null === $this->image) {
			return;
		}
		if(!is_dir($this->getUploadRootDir())){
			mkdir($this->getUploadRootDir());
		}
		copy($this->getTmpUploadRootDir().$this->image, $this->getFullPicturePath());
		unlink($this->getTmpUploadRootDir().$this->image);
	}
	
	/**
	 * @ORM\PreRemove()
	 */
	public function removePicture()
	{
		if($this->getFullPicturePath()){
			unlink($this->getFullPicturePath());
			rmdir($this->getUploadRootDir());
		}
	}
	
	/**
	 * @ORM\ManyToMany(targetEntity="Provinces_etats", mappedBy="Soins_sante")
	 *
	 * @var ArrayCollection $province_etat_id
	 */
	private $province_etat_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Soins_client", mappedBy = "Types_soins_sante")
	 *
	 * @var ArrayCollection $soins_client
	 */
	private $soins_client;
	
	public function __construct()
	{
		$this->attrait_id 			= new ArrayCollection();
		$this->soins_sante_id 		= new ArrayCollection();
		$this->province_etat_id		= new ArrayCollection();
		$this->soins_client 		= new ArrayCollection();
	}
	
	public function __toString()
	{
		return $this->nom_fr;
		return $this->nom_en;
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
     * Set metakeyword_fr
     *
     * @param string $metakeywordFr
     */
    public function setMetakeywordFr($metakeywordFr)
    {
        $this->metakeyword_fr = $metakeywordFr;
    }

    /**
     * Get metakeyword_fr
     *
     * @return string 
     */
    public function getMetakeywordFr()
    {
        return $this->metakeyword_fr;
    }

    /**
     * Set metakeyword_en
     *
     * @param string $metakeywordEn
     */
    public function setMetakeywordEn($metakeywordEn)
    {
        $this->metakeyword_en = $metakeywordEn;
    }

    /**
     * Get metakeyword_en
     *
     * @return string 
     */
    public function getMetakeywordEn()
    {
        return $this->metakeyword_en;
    }

    /**
     * Set metadescription_fr
     *
     * @param text $metadescriptionFr
     */
    public function setMetadescriptionFr($metadescriptionFr)
    {
        $this->metadescription_fr = $metadescriptionFr;
    }

    /**
     * Get metadescription_fr
     *
     * @return text 
     */
    public function getMetadescriptionFr()
    {
        return $this->metadescription_fr;
    }

    /**
     * Set metadescription_en
     *
     * @param text $metadescriptionEn
     */
    public function setMetadescriptionEn($metadescriptionEn)
    {
        $this->metadescription_en = $metadescriptionEn;
    }

    /**
     * Get metadescription_en
     *
     * @return text 
     */
    public function getMetadescriptionEn()
    {
        return $this->metadescription_en;
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
     * Set resume_fr
     *
     * @param text $resumeFr
     */
    public function setResumeFr($resumeFr)
    {
        $this->resume_fr = $resumeFr;
    }

    /**
     * Get resume_fr
     *
     * @return text 
     */
    public function getResumeFr()
    {
        return $this->resume_fr;
    }

    /**
     * Set resume_en
     *
     * @param text $resumeEn
     */
    public function setResumeEn($resumeEn)
    {
        $this->resume_en = $resumeEn;
    }

    /**
     * Get resume_en
     *
     * @return text 
     */
    public function getResumeEn()
    {
        return $this->resume_en;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add attrait_id
     *
     * @param MyApp\MobileBundle\Entity\Attraits $attraitId
     */
    public function addAttraits(\MyApp\MobileBundle\Entity\Attraits $attraitId)
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
     * Set image_doctrine
     *
     * @param string $imageDoctrine
     */
    public function setImageDoctrine($imageDoctrine)
    {
        $this->image_doctrine = $imageDoctrine;
    }

    /**
     * Get image_doctrine
     *
     * @return string 
     */
    public function getImageDoctrine()
    {
        return $this->image_doctrine;
    }

    /**
     * Add soins_sante_id
     *
     * @param MyApp\MobileBundle\Entity\Soins_sante $soinsSanteId
     */
    public function addSoins_sante(\MyApp\MobileBundle\Entity\Soins_sante $soinsSanteId)
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
     * Add province_etat_id
     *
     * @param MyApp\MobileBundle\Entity\Provinces_etats $provinceEtatId
     */
    public function addProvinces_etats(\MyApp\MobileBundle\Entity\Provinces_etats $provinceEtatId)
    {
        $this->province_etat_id[] = $provinceEtatId;
    }

    /**
     * Get province_etat_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProvinceEtatId()
    {
        return $this->province_etat_id;
    }

    /**
     * Add soins_client
     *
     * @param MyApp\MobileBundle\Entity\Soins_client $soinsClient
     */
    public function addSoins_client(\MyApp\MobileBundle\Entity\Soins_client $soinsClient)
    {
        $this->soins_client[] = $soinsClient;
    }

    /**
     * Get soins_client
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSoinsClient()
    {
        return $this->soins_client;
    }

    /**
     * Add texte_region_sante
     *
     * @param MyApp\MobileBundle\Entity\Texte_region_sante $texteRegionSante
     */
    public function addTexte_region_sante(\MyApp\MobileBundle\Entity\Texte_region_sante $texteRegionSante)
    {
        $this->texte_region_sante[] = $texteRegionSante;
    }

    /**
     * Get texte_region_sante
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionSante()
    {
        return $this->texte_region_sante;
    }

    /**
     * Add texte_province_sante
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_sante $texteProvinceSante
     */
    public function addTexte_province_sante(\MyApp\MobileBundle\Entity\Texte_province_sante $texteProvinceSante)
    {
        $this->texte_province_sante[] = $texteProvinceSante;
    }

    /**
     * Get texte_province_sante
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceSante()
    {
        return $this->texte_province_sante;
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