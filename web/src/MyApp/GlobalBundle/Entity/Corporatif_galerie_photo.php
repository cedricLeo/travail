<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormError;

/**
 * @ORM\Entity
 * @ORM\Table(name = "corporatif_galerie_photo")
 * @ORM\HasLifecycleCallbacks
 */
class Corporatif_galerie_photo{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type = "string", length = 100, nullable = "true")
	 * 
	 * @var string $image
	 */
	private $image;
	
	/**
	 * @ORM\Column(type = "string", length = 100, nullable ="true")
	 * 
	 * @var string $image_doctrine
	 */
	private $image_doctrine;
	
	/**
	 * @ORM\Column(type = "string", length = 150, nullable = "true")
	 *
	 * @var string $legende_fr
	 */
	private $legende_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 150, nullable = "true")
	 *
	 * @var integer $legende_en
	 */
	private $legende_en;
	
	
	public function getFullPicturePath() {
		return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
	}
	
	protected function getUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDir().$this->getId()."/";
	}
	
	protected function getTmpUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/galerie_corporative/';
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
	

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setId()
    {
    	return;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
    	if($image !== null and !empty($image))
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
     * Set legende_fr
     *
     * @param string $legendeFr
     */
    public function setLegendeFr($legendeFr)
    {
        $this->legende_fr = $legendeFr;
    }

    /**
     * Get legende_fr
     *
     * @return string 
     */
    public function getLegendeFr()
    {
        return $this->legende_fr;
    }

    /**
     * Set legende_en
     *
     * @param string $legendeEn
     */
    public function setLegendeEn($legendeEn)
    {
        $this->legende_en = $legendeEn;
    }

    /**
     * Get legende_en
     *
     * @return string 
     */
    public function getLegendeEn()
    {
        return $this->legende_en;
    }
 


    /**
     * Set hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementId
     */
    public function setHebergementId(\MyApp\GlobalBundle\Entity\Hebergements $hebergementId)
    {
        $this->hebergement_id = $hebergementId;
    }

    /**
     * Get hebergement_id
     *
     * @return MyApp\GlobalBundle\Entity\Hebergements 
     */
    public function getHebergementId()
    {
        return $this->hebergement_id;
    }
}