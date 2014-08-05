<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Hebergements_activitesRepository")
 * @ORM\Table(name = "hebergements_activites" )
 * @ORM\HasLifecycleCallbacks
 */
class Hebergements_activites{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO" )
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column( type = "string", length = 100)
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column( type = "string", length = 100)
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
	 * @ORM\Column( type = "string", length = 100)
	 * 
	 * @var string $image
	 */
	private $image;
	
	/**
	 * @ORM\Column( type = "string", length = 100)
	 *
	 * @var string $image_doctrine
	 */
	private $image_doctrine;
	
	/**
	 * @ORM\Column( type = "string", length = 20)
	 *
	 * @var string $distance
	 */
	private $distance;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Hebergements", inversedBy="Hebergements_activites")
	 * 
	 * @var ArrayCollection $activite_hebergement
	 */
	private $activite_hebergement;
	
	
	public function __construct()
	{
		$this->activite_hebergement = new ArrayCollection();
	}
	
	public function __toString()
	{
		return $this->nom_fr;
		return $this->nom_en;
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
		return __DIR__ . '/../../../../web/uploads/activite/';
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
	public function remove()
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
        return $this->nom_fr ;
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
     * Add activite_hebergement
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $activiteHebergement
     */
    public function addHebergements(\MyApp\GlobalBundle\Entity\Hebergements $activiteHebergement)
    {
        $this->activite_hebergement[] = $activiteHebergement;
    }

    /**
     * Get activite_hebergement
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActiviteHebergement()
    {
        return $this->activite_hebergement;
    }


    /**
     * Add distance_hebergement_activite
     *
     * @param MyApp\GlobalBundle\Entity\Distances $distanceHebergementActivite
     */
    public function addDistances(\MyApp\GlobalBundle\Entity\Distances $distanceHebergementActivite)
    {
        $this->distance_hebergement_activite[] = $distanceHebergementActivite;
    }

    /**
     * Get distance_hebergement_activite
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDistanceHebergementActivite()
    {
        return $this->distance_hebergement_activite;
    }

    /**
     * Set distance
     *
     * @param string $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * Get distance
     *
     * @return string 
     */
    public function getDistance()
    {
        return $this->distance;
    }

}