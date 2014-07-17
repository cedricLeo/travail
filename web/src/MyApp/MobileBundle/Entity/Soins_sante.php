<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\Soins_SanteRepository")
 * @ORM\Table(name = "soins_sante")
 * @ORM\HasLifecycleCallbacks
 */
class Soins_sante{
	
	/**
	 * @ORM\Id
	 * @ORM\Column( type = "integer")
	 * @ORM\Generatedvalue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Attraits", mappedBy="Soins_sante")
	 * 
	 * @var ArrayCollection $attrait_id
	 */
	private $attrait_id;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "true")
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "true")
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
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 * 
	 * @var string $page_metakeyword_fr
	 */
	private $page_metakeyword_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 * 
	 * @var string $page_metakeyword_en
	 */
	private $page_metakeyword_en;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $page_metadescription_fr
	 */
	private $page_metadescription_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $page_metadescription_en
	 */
	private $page_metadescription_en;
	
	/**
	 * @ORM\Column(type = "text", nullable ="true")
	 * 
	 * @var text $texte_fr
	 */
	private $texte_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable ="true")
	 * 
	 * @var text $texte_en
	 */
	private $texte_en;
	
	/**
	 * @ORM\Column(type = "text", nullable ="true")
	 * 
	 * @var text $resume_fr
	 */
	private $resume_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable ="true")
	 * 
	 * @var text $resume_en
	 */
	private $resume_en;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable ="true")
	 * 
	 * @var string $image
	 */
	private $image;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable ="true")
	 *
	 * @var string $image_doctrine
	 */
	private $image_doctrine;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Periode_soins_sante", mappedBy = "Soins_sante")
	 * 
	 * @var ArrayCollection $periode_soins_sante_id
	 */
	private $periode_soins_sante_id;	
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Types_soins_sante", inversedBy = "Soins_sante" )
	 * @ORM\JoinColumn(name = "types_soins_sante_id", referencedColumnName="id")
	 *
	 * @var integer $types_soins_sante_id
	 */
	private $types_soins_sante_id;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Categorie_soins_sante", mappedBy = "Soins_sante", fetch="EXTRA_LAZY")
	 * 
	 * @var integer $categorie_soins_sante_id
	 */
	private $categorie_soins_sante_id;
	
	public function getFullPicturePath() {
		return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
	}
	
	public function getFullPicturePath2() {
		return null === $this->image_doctrine ? null : $this->getUploadRootDir(). $this->image_doctrine;
	}
	
	protected function getUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDir().$this->getId()."/";
	}
	
	protected function getTmpUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/soin_sante/';
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
	
	
    public function __construct()
    {
        $this->attrait_id 					= new ArrayCollection();
        $this->periode_soins_sante_id 		= new ArrayCollection();
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
     * Add periode_soins_sante_id
     *
     * @param MyApp\MobileBundle\Entity\Periode_soins_sante $periodeSoinsSanteId
     */
    public function addPeriode_soins_sante(\MyApp\MobileBundle\Entity\Periode_soins_sante $periodeSoinsSanteId)
    {
        $this->periode_soins_sante_id[] = $periodeSoinsSanteId;
    }

    /**
     * Get periode_soins_sante_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPeriodeSoinsSanteId()
    {
        return $this->periode_soins_sante_id;
    }

    /**
     * Set types_soins_sante_id
     *
     * @param MyApp\MobileBundle\Entity\Types_soins_sante $typesSoinsSanteId
     */
    public function setTypesSoinsSanteId(\MyApp\MobileBundle\Entity\Types_soins_sante $typesSoinsSanteId)
    {
        $this->types_soins_sante_id = $typesSoinsSanteId;
    }

    /**
     * Get types_soins_sante_id
     *
     * @return MyApp\MobileBundle\Entity\Types_soins_sante 
     */
    public function getTypesSoinsSanteId()
    {
        return $this->types_soins_sante_id;
    }

    /**
     * Add categorie_soins_sante_id
     *
     * @param MyApp\MobileBundle\Entity\Categorie_soins_sante $categorieSoinsSanteId
     */
    public function addCategorie_soins_sante(\MyApp\MobileBundle\Entity\Categorie_soins_sante $categorieSoinsSanteId)
    {
        $this->categorie_soins_sante_id[] = $categorieSoinsSanteId;
    }

    /**
     * Get categorie_soins_sante_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategorieSoinsSanteId()
    {
        return $this->categorie_soins_sante_id;
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