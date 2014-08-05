<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MyApp\MobileBundle\Entity\Attraits_sous_categories;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\Attraits_categoriesRepository")
 * @ORM\Table(name = "attraits_categories" )
 * @ORM\HasLifecycleCallbacks
 */
class Attraits_categories{
	
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     * 
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity = "Attraits_sous_categories", mappedBy = "Attraits_categories", cascade={"remove", "persist"})
     * 
     * @var integer $sous_categorie_attrait_id
     */
    private $sous_categorie_attrait_id;

    /**
     * @ORM\ManyToMany(targetEntity = "Attraits", mappedBy = "Attraits_categories")
     *
     * @var ArrayCollection $attrait
     */
    private $attrait;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $nom_fr
     */
    private $nom_fr;

    /**
     * @ORM\Column(type = "string", length = 255)
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
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     * 
     * @var string $page_titre_fr
     */
    private $page_titre_fr;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     * 
     * @var string $page_titre_en
     */
    private $page_titre_en;

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
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_fr
     */
    private $texte_fr;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_en
     */
    private $texte_en;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     * 
     * @var string $image
     */
    private $image;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     *
     * @var string $image_doctrine
     */
    private $image_doctrine;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $type_festival_evenement
     */
    private $type_festival_evenement;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $type_restaurant
     */
    private $type_restaurant;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $type_camping
     */
    private $type_camping;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $type_centre_sante_spa
     */
    private $type_centre_sante_spa;

    /**
     * @ORM\OneToMany(targetEntity="Texte_region_attrait", mappedBy="Attraits_categories", cascade={"remove"})
     *
     * @var integer $texte_region_attrait
     */
    private $texte_region_attrait;

    /**
     * @ORM\OneToMany(targetEntity="Texte_province_attrait", mappedBy="Attraits_categories", cascade={"remove"})
     *
     * @var integer $texte_province_attrait
     */
    private $texte_province_attrait;


    public function getFullImagePath() {
            return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
    }

    public function getFullImagePath2() {
            return null === $this->image_doctrine ? null : $this->getUploadRootDir(). $this->image_doctrine;
    }

    protected function getUploadRootDir() {
            // the absolute directory path where uploaded documents should be saved
            return $this->getTmpUploadRootDir().$this->getId()."/";
    }

    protected function getTmpUploadRootDir() {
            // the absolute directory path where uploaded documents should be saved
            return __DIR__ . '/../../../../web/uploads/attrait_categorie/';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadImage() {
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
    public function moveImage()
    {
            if (null === $this->image) {
                    return;
            }
            if(!is_dir($this->getUploadRootDir())){
                    mkdir($this->getUploadRootDir());
            }
            copy($this->getTmpUploadRootDir().$this->image, $this->getFullImagePath());
            unlink($this->getTmpUploadRootDir().$this->image);
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeImage()
    {
        if($this->getFullImagePath()){
            unlink($this->getFullImagePath());
            rmdir($this->getUploadRootDir());
        }
    }
    
    public function __construct()
    {
        $this->attrait = new \Doctrine\Common\Collections\ArrayCollection();
        $this->texte_region_attrait = new \Doctrine\Common\Collections\ArrayCollection();
        $this->texte_province_attrait = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set type_festival_evenement
     *
     * @param boolean $typeFestivalEvenement
     */
    public function setTypeFestivalEvenement($typeFestivalEvenement)
    {
        $this->type_festival_evenement = $typeFestivalEvenement;
    }

    /**
     * Get type_festival_evenement
     *
     * @return boolean 
     */
    public function getTypeFestivalEvenement()
    {
        return $this->type_festival_evenement;
    }

    /**
     * Set type_restaurant
     *
     * @param boolean $typeRestaurant
     */
    public function setTypeRestaurant($typeRestaurant)
    {
        $this->type_restaurant = $typeRestaurant;
    }

    /**
     * Get type_restaurant
     *
     * @return boolean 
     */
    public function getTypeRestaurant()
    {
        return $this->type_restaurant;
    }

    /**
     * Set type_camping
     *
     * @param boolean $typeCamping
     */
    public function setTypeCamping($typeCamping)
    {
        $this->type_camping = $typeCamping;
    }

    /**
     * Get type_camping
     *
     * @return boolean 
     */
    public function getTypeCamping()
    {
        return $this->type_camping;
    }

    /**
     * Set type_centre_sante_spa
     *
     * @param boolean $typeCentreSanteSpa
     */
    public function setTypeCentreSanteSpa($typeCentreSanteSpa)
    {
        $this->type_centre_sante_spa = $typeCentreSanteSpa;
    }

    /**
     * Get type_centre_sante_spa
     *
     * @return boolean 
     */
    public function getTypeCentreSanteSpa()
    {
        return $this->type_centre_sante_spa;
    }

    /**
     * Add sous_categorie_attrait_id
     *
     * @param MyApp\MobileBundle\Entity\Attraits_sous_categories $sousCategorieAttraitId
     */
    public function addAttraits_sous_categories(\MyApp\MobileBundle\Entity\Attraits_sous_categories $sousCategorieAttraitId)
    {
        $this->sous_categorie_attrait_id[] = $sousCategorieAttraitId;
    }

    /**
     * Get sous_categorie_attrait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSousCategorieAttraitId()
    {
        return $this->sous_categorie_attrait_id;
    }

    /**
     * Add attrait
     *
     * @param MyApp\MobileBundle\Entity\Attraits $attrait
     */
    public function addAttraits(\MyApp\MobileBundle\Entity\Attraits $attrait)
    {
        $this->attrait[] = $attrait;
    }

    /**
     * Get attrait
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttrait()
    {
        return $this->attrait;
    }

    /**
     * Add texte_region_attrait
     *
     * @param MyApp\MobileBundle\Entity\Texte_region_attrait $texteRegionAttrait
     */
    public function addTexte_region_attrait(\MyApp\MobileBundle\Entity\Texte_region_attrait $texteRegionAttrait)
    {
        $this->texte_region_attrait[] = $texteRegionAttrait;
    }

    /**
     * Get texte_region_attrait
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionAttrait()
    {
        return $this->texte_region_attrait;
    }

    /**
     * Add texte_province_attrait
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_attrait $texteProvinceAttrait
     */
    public function addTexte_province_attrait(\MyApp\MobileBundle\Entity\Texte_province_attrait $texteProvinceAttrait)
    {
        $this->texte_province_attrait[] = $texteProvinceAttrait;
    }

    /**
     * Get texte_province_attrait
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceAttrait()
    {
        return $this->texte_province_attrait;
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