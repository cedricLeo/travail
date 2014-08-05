<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\CouponsRepository")
 * @ORM\Table(name = "coupons")
 * @ORM\HasLifecycleCallbacks
 */
class Coupons{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "false")
	 * 
	 * @var string $titre_fr
	 */
	private $titre_fr;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "false")
	 * 
	 * @var string $titre_en
	 */
	private $titre_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "false")
	 *
	 * @var text $description_fr
	 */
	private $description_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "false")
	 *
	 * @var text $description_en
	 */
	private $description_en;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "true")
	 *
	 * @var string $specification_fr
	 */
	private $specification_fr;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "true")
	 *
	 * @var string $specification_en
	 */
	private $specification_en;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "true")
	 *
	 * @var string $image_fr
	 */
	private $image_fr;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "true")
	 *
	 * @var string $image_en
	 */
	private $image_en;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "true")
	 *
	 * @var string $image_doctrine_fr
	 */
	private $image_doctrine_fr;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "true")
	 *
	 * @var string $image_doctrine_en
	 */
	private $image_doctrine_en;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "true")
	 *
	 * @var string $expiration_fr
	 */
	private $expiration_fr;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "true")
	 *
	 * @var string $expiration_en
	 */
	private $expiration_en;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "true")
	 *
	 * @var string $repertoire_fr
	 */
	private $repertoire_fr;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "true")
	 *
	 * @var string $repertoire_en
	 */
	private $repertoire_en;
	
	/**
	 * @ORM\Column(type="date", nullable = "true")
	 *
	 * @var date $date_expiration
	 */
	private $date_expiration;
	
	/**
	 * @ORM\Column(type="string", length = 100, nullable = "true")
	 *
	 * @var string $credit_photo
	 */
	private $credit_photo;
	
	/**
	 * @ORM\Column(type="integer", length = 6, nullable = "false")
	 *
	 * @var integer $coupon_id
	 */
	private $coupon_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Attraits",inversedBy="Coupons", fetch="EXTRA_LAZY")
	 *
	 */
	private $attrait_coupon_id;
	
	public function getFullPicturePath() {
		return null === $this->image_fr ? null : $this->getUploadRootDir(). $this->image_fr;
	}
	public function getFullPicturePath2() {	
		return null === $this->image_en ? null : $this->getUploadRootDir(). $this->image_en;
	}
	
	protected function getUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDir().$this->getId()."/";
	}
	
	protected function getTmpUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/coupons-rabais/';
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function uploadPicture() {
		// the file property can be empty if the field is not required
		if (null === $this->image_fr) {
			return;
		}
		if (null === $this->image_doctrine_fr) {
			return;
		}

		if(!$this->id){
			$this->image_fr->move($this->getTmpUploadRootDir(), $this->image_fr->getClientOriginalName());
		}else{
			$this->image_fr->move($this->getUploadRootDir(), $this->image_fr->getClientOriginalName());
		}
		$this->setImageFr($this->image_fr->getClientOriginalName());
		
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function uploadPicture2() {
		// the file property can be empty if the field is not required
		if (null === $this->image_en) {
			return;
		}
		if (null === $this->image_doctrine_en) {
			return;
		}
		
		if(!$this->id){
			$this->image_en->move($this->getTmpUploadRootDir(), $this->image_en->getClientOriginalName());
		}else{
			$this->image_en->move($this->getUploadRootDir(), $this->image_en->getClientOriginalName());
		}
		$this->setImageEn($this->image_en->getClientOriginalName());
	}
	
	/**
	 * @ORM\PostPersist()
	 */
	public function movePicture()
	{
		if (null === $this->image_fr) {
			return;
		}
		if (null === $this->image_en){
			return;
		}
		if(!is_dir($this->getUploadRootDir())){
			mkdir($this->getUploadRootDir());
		}
		copy($this->getTmpUploadRootDir().$this->image_fr, $this->getFullPicturePath());
		unlink($this->getTmpUploadRootDir().$this->image_fr);
		
		copy($this->getTmpUploadRootDir().$this->image_en, $this->getFullPicturePath2());
		unlink($this->getTmpUploadRootDir().$this->image_en);
	}
	
	/**
	 * @ORM\PreRemove()
	 */
	public function remove()
	{
		unlink($this->getFullPicturePath());
		unlink($this->getFullPicturePath2());
		rmdir($this->getUploadRootDir());
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
     * Set description_fr
     *
     * @param text $descriptionFr
     */
    public function setDescriptionFr($descriptionFr)
    {
        $this->description_fr = $descriptionFr;
    }

    /**
     * Get description_fr
     *
     * @return text 
     */
    public function getDescriptionFr()
    {
        return $this->description_fr;
    }

    /**
     * Set description_en
     *
     * @param text $descriptionEn
     */
    public function setDescriptionEn($descriptionEn)
    {
        $this->description_en = $descriptionEn;
    }

    /**
     * Get description_en
     *
     * @return text 
     */
    public function getDescriptionEn()
    {
        return $this->description_en;
    }

    /**
     * Set specification_fr
     *
     * @param string $specificationFr
     */
    public function setSpecificationFr($specificationFr)
    {
        $this->specification_fr = $specificationFr;
    }

    /**
     * Get specification_fr
     *
     * @return string 
     */
    public function getSpecificationFr()
    {
        return $this->specification_fr;
    }

    /**
     * Set specification_en
     *
     * @param string $specificationEn
     */
    public function setSpecificationEn($specificationEn)
    {
        $this->specification_en = $specificationEn;
    }

    /**
     * Get specification_en
     *
     * @return string 
     */
    public function getSpecificationEn()
    {
        return $this->specification_en;
    }

    /**
     * Set image_fr
     *
     * @param string $imageFr
     */
    public function setImageFr($imageFr)
    {
        $this->image_fr = $imageFr;
    }

    /**
     * Get image_fr
     *
     * @return string 
     */
    public function getImageFr()
    {
        return $this->image_fr;
    }

    /**
     * Set image_en
     *
     * @param string $imageEn
     */
    public function setImageEn($imageEn)
    {
        $this->image_en = $imageEn;
    }

    /**
     * Get image_en
     *
     * @return string 
     */
    public function getImageEn()
    {
        return $this->image_en;
    }

    /**
     * Set image_doctrine_fr
     *
     * @param string $imageDoctrineFr
     */
    public function setImageDoctrineFr($imageDoctrineFr)
    {
        $this->image_doctrine_fr = $imageDoctrineFr;
    }

    /**
     * Get image_doctrine_fr
     *
     * @return string 
     */
    public function getImageDoctrineFr()
    {
        return $this->image_doctrine_fr;
    }

    /**
     * Set image_doctrine_en
     *
     * @param string $imageDoctrineEn
     */
    public function setImageDoctrineEn($imageDoctrineEn)
    {
        $this->image_doctrine_en = $imageDoctrineEn;
    }

    /**
     * Get image_doctrine_en
     *
     * @return string 
     */
    public function getImageDoctrineEn()
    {
        return $this->image_doctrine_en;
    }

    /**
     * Set expiration_fr
     *
     * @param string $expirationFr
     */
    public function setExpirationFr($expirationFr)
    {
        $this->expiration_fr = $expirationFr;
    }

    /**
     * Get expiration_fr
     *
     * @return string 
     */
    public function getExpirationFr()
    {
        return $this->expiration_fr;
    }

    /**
     * Set expiration_en
     *
     * @param string $expirationEn
     */
    public function setExpirationEn($expirationEn)
    {
        $this->expiration_en = $expirationEn;
    }

    /**
     * Get expiration_en
     *
     * @return string 
     */
    public function getExpirationEn()
    {
        return $this->expiration_en;
    }

    /**
     * Set date_expiration
     *
     * @param date $dateExpiration
     */
    public function setDateExpiration($dateExpiration)
    {
        $this->date_expiration = $dateExpiration;
    }

    /**
     * Get date_expiration
     *
     * @return date 
     */
    public function getDateExpiration()
    {
        return $this->date_expiration;
    }

    /**
     * Set credit_photo
     *
     * @param string $creditPhoto
     */
    public function setCreditPhoto($creditPhoto)
    {
        $this->credit_photo = $creditPhoto;
    }

    /**
     * Get credit_photo
     *
     * @return string 
     */
    public function getCreditPhoto()
    {
        return $this->credit_photo;
    }

    /**
     * Set attrait_coupon_id
     *
     * @param MyApp\MobileBundle\Entity\Attraits $attraitCouponId
     */
    public function setAttraitCouponId(\MyApp\MobileBundle\Entity\Attraits $attraitCouponId)
    {
        $this->attrait_coupon_id = $attraitCouponId;
    }

    /**
     * Get attrait_coupon_id
     *
     * @return MyApp\MobileBundle\Entity\Attraits 
     */
    public function getAttraitCouponId()
    {
        return $this->attrait_coupon_id;
    }

    /**
     * Set coupon_id
     *
     * @param integer $couponId
     */
    public function setCouponId($couponId)
    {
        $this->coupon_id = $couponId;
    }

    /**
     * Get coupon_id
     *
     * @return integer 
     */
    public function getCouponId()
    {
        return $this->coupon_id;
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