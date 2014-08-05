<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\PaysRepository")
 * @ORM\Table(name = "pays", indexes={@ORM\index(name="pays_idx", columns={"id", "nom_fr"})})
 * @ORM\HasLifecycleCallbacks
 */
class Pays{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer" )
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type = "string", length = 50)
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 50)
	 * 
	 * @var string $nom_en
	 */
	private $nom_en;
	
	/**
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $reservit_id
	 */
	private $reservit_id;
	
	/**
	 * @ORM\Column(type = "boolean")
	 *
	 * @var boolean $affiche
	 */
	private $affiche;
	
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "true")
	 *
	 * @var string $flag
	 */
	private $flag;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "true")
	 *
	 * @var string $image_doctrine
	 */
	private $image_doctrine;
	
	public function getFullPicturePath() {
		return null === $this->flag ? null : $this->getUploadRootDir(). $this->flag;
	}
	
	protected function getUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDir().$this->getId()."/";
	}
	
	protected function getTmpUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/pays/';
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function uploadPicture() {
		// the file property can be empty if the field is not required
		if (null === $this->flag) {
			return;
		}
		if (null === $this->image_doctrine) {
			return;
		}
		if(!$this->id){
			$this->flag->move($this->getTmpUploadRootDir(), $this->flag->getClientOriginalName());
		}else{
			$this->flag->move($this->getUploadRootDir(), $this->flag->getClientOriginalName());
		}
		$this->setFlag($this->flag->getClientOriginalName());
	}
	
	/**
	 * @ORM\PostPersist()
	 */
	public function movePicture()
	{
		if (null === $this->flag) {
			return;
		}
		if(!is_dir($this->getUploadRootDir())){
			mkdir($this->getUploadRootDir());
		}
		copy($this->getTmpUploadRootDir().$this->flag, $this->getFullPicturePath());
		unlink($this->getTmpUploadRootDir().$this->flag);
	}
	
	/**
	 * @ORM\PreRemove()
	 */
	public function removePicture()
	{
		unlink($this->getFullPicturePath());
		rmdir($this->getUploadRootDir());
	}
	
	public function __construct()
	{
		$this->soins_sante_id = new ArrayCollection();
		$this->categorie_attrait_id = new ArrayCollection();
		$this->provinces_id = new \Doctrine\Common\Collections\ArrayCollection();
		$this->client_id = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * @ORM\PostRemove()
	 * @ORM\OneToMany(targetEntity="Provinces_etats", mappedBy="Pays", fetch="EXTRA_LAZY")
	 * 
	 * @var integer $provinces_id
	 */
	private $provinces_id;

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
     * Add provinces_id
     *
     * @param MyApp\MobileBundle\Entity\Provinces_etats $provincesId
     */
    public function addProvinces_etats(\MyApp\MobileBundle\Entity\Provinces_etats $provincesId)
    {
        $this->provinces_id[] = $provincesId;
    }

    /**
     * Get provinces_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProvincesId()
    {
        return $this->provinces_id;
    }

    /**
     * Set flag
     *
     * @param string $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    /**
     * Get flag
     *
     * @return string 
     */
    public function getFlag()
    {
        return $this->flag;
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
}