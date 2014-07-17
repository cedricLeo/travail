<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\EquipementsRepository")
 * @ORM\Table(name = "equipements")
 * @ORM\HasLifecycleCallbacks
 */
class Equipements
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type ="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type = "string", length = 100)
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 100)
	 * 
	 * @var string nom_en
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
	 * @var integer $image
	 */
	private $image;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Hebergements", mappedBy = "Equipements")
	 * 
	 * @var ArrayCollection $hebergement_equipement
	 */
	private $hebergement_equipement;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Chambres", mappedBy = "Equipements")
	 *
	 * @var ArrayCollection $chambre_equipement
	 */
	private $chambre_equipement;
	
	
	public function getFullPicturePath() {
		return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
	}
	
	protected function getUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDir().$this->getId()."/";
	}
	
	protected function getTmpUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/equipement/';
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
	
	public function __construct()
	{
		$this->hebergement_id       = new ArrayCollection();
		$this->chambre_equipement   = new ArrayCollection();
	}
	
	public function __toString()
	{
		return $this->nom_fr;
		//return $this->nom_en;
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
    	if($image != null){
    		$this->image = $image;
    	}
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
     * Add hebergement_equipement
     *
     * @param MyApp\MobileBundle\Entity\Hebergements $hebergementEquipement
     */
    public function addHebergements(\MyApp\MobileBundle\Entity\Hebergements $hebergementEquipement)
    {
        $this->hebergement_equipement[] = $hebergementEquipement;
    }

    /**
     * Get hebergement_equipement
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementEquipement()
    {
        return $this->hebergement_equipement;
    }

    /**
     * Add chambre_equipement
     *
     * @param MyApp\MobileBundle\Entity\Chambres $chambreEquipement
     */
    public function addChambres(\MyApp\MobileBundle\Entity\Chambres $chambreEquipement)
    {
        $this->chambre_equipement[] = $chambreEquipement;
    }

    /**
     * Get chambre_equipement
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChambreEquipement()
    {
        return $this->chambre_equipement;
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