<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\ForfaitRepository")
 * @ORM\Table(name = "forfaits")
 * @ORM\HasLifecycleCallbacks
 */
class Forfaits{
	
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Column(type = "integer")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity = "Hebergements", mappedBy = "Forfaits")
     * 
     * @var ArrayCollection $hebergement_forfait
     */
    private $hebergement_forfait;

    /**
     * @ORM\ManyToMany(targetEntity = "Attraits", mappedBy = "Forfaits")
     *
     * @var ArrayCollection $attrait_id
     */
    private $attrait_id;

    /**
     * @ORM\OneToMany(targetEntity = "Forfaits_clients", mappedBy = "Forfaits")
     *
     * @var integer $forfait_id
     */
    private $forfait_id;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $nom_fr
     */
    private $nom_fr;
    
   /**
    * @ORM\Column(type = "string", nullable = true)
    *
    * @var string $repertoire_fr
    */
    private $repertoire_fr;

   /**
    * @ORM\Column(type = "string", nullable = true)
    *
    * @var string $repertoire_en
    */
    private $repertoire_en;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $nom_en
     */
    private $nom_en;

    /**
     * @ORM\Column( type = "string", length = 255)
     * 
     * @var string $meta_titre_fr
     */
    private $meta_titre_fr;

    /**
     * @ORM\Column( type = "string", length = 255)
     * 
     * @var string $meta_titre_en
     */
    private $meta_titre_en;

    /**
     * @ORM\Column( type = "string" , length = 255)
     * 
     * @var string $page_metakeyword_fr
     */
    private $page_metakeyword_fr;

    /**
     * @ORM\Column( type = "string" , length = 255)
     * 
     * @var string $page_metakeyword_en
     */
    private $page_metakeyword_en;

    /**
     * @ORM\Column( type = "text")
     * 
     * @var text $page_metadescription_fr
     */
    private $page_metadescription_fr;

    /**
     * @ORM\Column( type = "text")
     * 
     * @var text $page_metadescription_en
     */
    private $page_metadescription_en;

    /**
     * @ORM\Column( type = "text", nullable="true")
     * 
     * @var text $texte_fr
     */
    private $texte_fr;

    /**
     * @ORM\Column( type = "text", nullable="true")
     * 
     * @var text $texte_en
     */
    private $texte_en;

    /**
     * @ORM\Column(type = "boolean", nullable="true")
     * 
     * @var boolean $default_forfait
     */
    private $default_forfait;

    /**
     * @ORM\Column(type = "string", nullable="true")
 *
     * @var string $image
     */
    private $image;

    /**
     * @ORM\Column(type = "string", nullable="true")
     *
     * @var string $image_doctrine
     */
    private $image_doctrine;
    
    /**
     * @ORM\OneToMany(targetEntity = "Texte_region_forfait", mappedBy = "Forfaits", cascade={"remove"})
     * 
     * @var integer $texte_region_forfait_id
     */
    private $texte_region_forfait_id;
    
    /**
     * @ORM\OneToMany(targetEntity = "Texte_province_forfait", mappedBy = "Forfaits", cascade={"remove"})
     * 
     * @var integer $texte_province_forfait_id
     */
    private $texte_province_forfait_id;

    /**
     * @ORM\ManyToMany(targetEntity = "Qcs_forfaits", mappedBy = "Forfaits", cascade={"remove"})
     *
     * @var ArrayCollection $qcs_forfaits_id
     */
    private $qcs_forfaits_id;

    /**
     * @ORM\OneToOne(targetEntity = "Qcs_saisons", inversedBy = "Forfaits")
     * @ORM\JoinColumn(name = "qcs_saison_id", referencedColumnName = "id")
     *
     * @var integer $qcs_saison_id
     */
    private $qcs_saison_id;

    public function getFullPicturePath() {
            return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
    }

    protected function getUploadRootDir() {
            // the absolute directory path where uploaded documents should be saved
            return $this->getTmpUploadRootDir().$this->getId()."/";
    }

    protected function getTmpUploadRootDir() {
            // the absolute directory path where uploaded documents should be saved
            return __DIR__ . '/../../../../web/uploads/forfaits/';
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
            $this->hebergement_forfait          = new ArrayCollection();
            $this->attrait_id 			= new ArrayCollection();
            $this->qcs_forfait_id		= new ArrayCollection();
            //$this->forfait_id 			= new ArrayCollection();
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
     * Set page_fr
     *
     * @param string $pageFr
     */
    public function setPageFr($pageFr)
    {
        $this->page_fr = $pageFr;
    }

    /**
     * Get page_fr
     *
     * @return string 
     */
    public function getPageFr()
    {
        return $this->page_fr;
    }

    /**
     * Set page_en
     *
     * @param string $pageEn
     */
    public function setPageEn($pageEn)
    {
        $this->page_en = $pageEn;
    }

    /**
     * Get page_en
     *
     * @return string 
     */
    public function getPageEn()
    {
        return $this->page_en;
    }

    /**
     * Set page_titre_fr
     *
     * @param string $pageTitreFr
     */
    public function setPageTitreFr($pageTitreFr)
    {
        $this->page_titre_fr = $pageTitreFr;
    }

    /**
     * Get page_titre_fr
     *
     * @return string 
     */
    public function getPageTitreFr()
    {
        return $this->page_titre_fr;
    }

    /**
     * Set page_titre_en
     *
     * @param string $pageTitreEn
     */
    public function setPageTitreEn($pageTitreEn)
    {
        $this->page_titre_en = $pageTitreEn;
    }

    /**
     * Get page_titre_en
     *
     * @return string 
     */
    public function getPageTitreEn()
    {
        return $this->page_titre_en;
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
     * Set default_forfait
     *
     * @param boolean $defaultForfait
     */
    public function setDefaultForfait($defaultForfait)
    {
        $this->default_forfait = $defaultForfait;
    }

    /**
     * Get default_forfait
     *
     * @return boolean 
     */
    public function getDefaultForfait()
    {
        return $this->default_forfait;
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
     * Add qcs_forfaits_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_forfaits $qcsForfaitsId
     */
    public function addQcs_forfaits(\MyApp\GlobalBundle\Entity\Qcs_forfaits $qcsForfaitsId)
    {
        $this->qcs_forfaits_id[] = $qcsForfaitsId;
    }

    /**
     * Get qcs_forfaits_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsForfaitsId()
    {
        return $this->qcs_forfaits_id;
    }

    /**
     * Set qcs_saison_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_saisons $qcsSaisonId
     */
    public function setQcsSaisonId(\MyApp\GlobalBundle\Entity\Qcs_saisons $qcsSaisonId)
    {
        $this->qcs_saison_id = $qcsSaisonId;
    }

    /**
     * Get qcs_saison_id
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_saisons 
     */
    public function getQcsSaisonId()
    {
        return $this->qcs_saison_id;
    }

    /**
     * Add attrait_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits $attraitId
     */
    public function addAttraits(\MyApp\GlobalBundle\Entity\Attraits $attraitId)
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
     * Add hebergement_forfait
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementForfait
     */
    public function addHebergements(\MyApp\GlobalBundle\Entity\Hebergements $hebergementForfait)
    {
        $this->hebergement_forfait[] = $hebergementForfait;
    }

    /**
     * Get hebergement_forfait
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementForfait()
    {
        return $this->hebergement_forfait;
    }


    /**
     * Add forfait_id
     *
     * @param MyApp\GlobalBundle\Entity\Forfaits_clients $forfaitId
     */
    public function addForfaits_clients(\MyApp\GlobalBundle\Entity\Forfaits_clients $forfaitId)
    {
        $this->forfait_id[] = $forfaitId;
    }

    /**
     * Get forfait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getForfaitId()
    {
        return $this->forfait_id;
    }

    /**
     * Set meta_titre_fr
     *
     * @param string $metaTitreFr
     */
    public function setMetaTitreFr($metaTitreFr)
    {
        $this->meta_titre_fr = $metaTitreFr;
    }

    /**
     * Get meta_titre_fr
     *
     * @return string 
     */
    public function getMetaTitreFr()
    {
        return $this->meta_titre_fr;
    }

    /**
     * Set meta_titre_en
     *
     * @param string $metaTitreEn
     */
    public function setMetaTitreEn($metaTitreEn)
    {
        $this->meta_titre_en = $metaTitreEn;
    }

    /**
     * Get meta_titre_en
     *
     * @return string 
     */
    public function getMetaTitreEn()
    {
        return $this->meta_titre_en;
    }

    /**
     * Add texte_region_forfait_id
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_forfait $texteRegionForfaitId
     */
    public function addTexte_region_forfait(\MyApp\GlobalBundle\Entity\Texte_region_forfait $texteRegionForfaitId)
    {
        $this->texte_region_forfait_id[] = $texteRegionForfaitId;
    }

    /**
     * Get texte_region_forfait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionForfaitId()
    {
        return $this->texte_region_forfait_id;
    }

    /**
     * Add texte_province_forfait_id
     *
     * @param MyApp\GlobalBundle\Entity\Texte_province_forfait $texteProvinceForfaitId
     */
    public function addTexte_province_forfait(\MyApp\GlobalBundle\Entity\Texte_province_forfait $texteProvinceForfaitId)
    {
        $this->texte_province_forfait_id[] = $texteProvinceForfaitId;
    }

    /**
     * Get texte_province_forfait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceForfaitId()
    {
        return $this->texte_province_forfait_id;
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