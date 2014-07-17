<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Attraits_activitesRepository")
 * @ORM\Table(name = "attraits_activites")
 * @ORM\HasLifecycleCallbacks
 */
class Attraits_activites{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue( strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Attraits", mappedBy="Attraits_activites")
	 * 
	 * @var ArrayCollection $attrait_id
	 */
	private $attrait_id;
	
	/**
	 * @ORM\Column(type = "string", length = 100)
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 100)
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
	 * @ORM\Column(type = "string", length = 100, nullable = "true")
	 *
	 * @var string $image
	 */
	private $image;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Distances", mappedBy="Attraits_activites")
	 *
	 * @var ArrayCollection $distance_attrait_activite
	 */
	private $distance_attrait_activite;
	
	public function __construct()
	{
		$this->attrait_id = new ArrayCollection();
		$this->distance_attrait_activite = new ArrayCollection();
	}
	
	public function getFullPicturePath() {
		return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
	}
	
	protected function getUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDir().$this->getId()."/";
	}
	
	protected function getTmpUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/attrait_activite/';
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
     * Add attrait_activite_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits $attraitActiviteId
     */
    public function addAttraits(\MyApp\GlobalBundle\Entity\Attraits $attraitActiviteId)
    {
        $this->attrait_activite_id[] = $attraitActiviteId;
    }

    /**
     * Get attrait_activite_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitActiviteId()
    {
        return $this->attrait_activite_id;
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
     * Add distance_attrait_activite
     *
     * @param MyApp\GlobalBundle\Entity\Distances $distanceAttraitActivite
     */
    public function addDistances(\MyApp\GlobalBundle\Entity\Distances $distanceAttraitActivite)
    {
        $this->distance_attrait_activite[] = $distanceAttraitActivite;
    }

    /**
     * Get distance_attrait_activite
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDistanceAttraitActivite()
    {
        return $this->distance_attrait_activite;
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