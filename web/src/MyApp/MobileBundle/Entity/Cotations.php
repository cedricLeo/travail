<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\CotationsRepository")
 * @ORM\Table(name="cotations")
 * @ORM\HasLifecycleCallbacks
 */
class Cotations {
	
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy= "AUTO")
     * 
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type = "string", length = 100, nullable = true)
     * 
     * @var string $file
     */
    private $file;

    /**
     * @ORM\Column(type = "string", length = 100,  nullable = true)
     * 
     * @var string $valeur
     */
    private $valeur;

    /**
     * @ORM\Column(type = "string", length = 100, nullable = true)
     *
     * @var string $image
     */
    private $image;

    public function getFullPicturePath() {
            return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
    }

    protected function getUploadRootDir() {
            // the absolute directory path where uploaded documents should be saved
            return $this->getTmpUploadRootDir().$this->getId()."/";
    }

    protected function getTmpUploadRootDir() {
            // the absolute directory path where uploaded documents should be saved
            return __DIR__ . '/../../../../web/uploads/cotations/';
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
            if (null === $this->file) {
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
        if($this->getFullPicturePath()){
            unlink($this->getFullPicturePath());
            rmdir($this->getUploadRootDir());
        }
    }

    /**
     * @ORM\OneToMany(targetEntity="Hebergements", mappedBy="Cotations", cascade={"refresh"})
     * 
     * @var integer $hebegement_id
     */
    private $hebergement_id;
    
    public function __toString()
    {
    	return $this->valeur;
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
     * Set valeur
     *
     * @param string $valeur
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
    }

    /**
     * Get valeur
     *
     * @return string 
     */
    public function getValeur()
    {
        return $this->valeur;
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
     * Add hebergement_id
     *
     * @param MyApp\MobileBundle\Entity\Hebergements $hebergementId
     */
    public function addHebergements(\MyApp\MobileBundle\Entity\Hebergements $hebergementId)
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
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }
}