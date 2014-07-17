<?php
namespace MyApp\MobileBundle\Entity;
use MyApp\AdminBundle\Controller\AttraitController;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
//use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\Modes_paiementRepository")
 * @ORM\Table(name = "modes_paiements")
 * @ORM\HasLifecycleCallbacks
 */
class Modes_paiements{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Attraits", mappedBy="Modes_paiements")         
	 *
	 * @var ArrayCollection $attrait_id
	 */
	private $attrait_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Hebergements", mappedBy="Modes_paiements")
	 *
	 * @var ArrayCollection $hebergement_paiement
	 */
	private $hebergement_paiement;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
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
	 * @ORM\Column(type="string", length = 255, nullable="true")
	 * 
	 * @var string $image
	 */
	private $image;
	
	/**
	 * @ORM\Column(type="string", length = 255, nullable="true")
	 *
	 * @var string $image_doctrine
	 */
	private $image_doctrine;
	
	public function getFullPicturePath() {
        return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadRootDir().$this->getId()."/";
    }

 	protected function getTmpUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
         return __DIR__ . '/../../../../web/uploads/modes_paiements/';
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
    	/*if (null === $this->image_doctrine) {
            return;
        }*/
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
        if($this->getFullPicturePath()){
            unlink($this->getFullPicturePath());
            rmdir($this->getUploadRootDir());   
        }
    }
	
	public function __construct()
	{
		$this->attrait_id             = new ArrayCollection();
		$this->hebergement_paiement   = new ArrayCollection();
	}
	
	public function __toString()
	{
		return $this->nom_fr;
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
     * Add hebergement_paiement
     *
     * @param MyApp\MobileBundle\Entity\Hebergements $hebergementPaiement
     */
    public function addHebergements(\MyApp\MobileBundle\Entity\Hebergements $hebergementPaiement)
    {
        $this->hebergement_paiement[] = $hebergementPaiement;
    }

    /**
     * Get hebergement_paiement
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementPaiement()
    {
        return $this->hebergement_paiement;
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