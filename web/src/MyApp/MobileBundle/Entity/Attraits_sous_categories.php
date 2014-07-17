<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\Attraits_sous_categorieRepository")
 * @ORM\Table(name = "attraits_sous_categories" )
 * @ORM\HasLifecycleCallbacks
 */
class Attraits_sous_categories{
	
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     * 
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Attraits_categories", inversedBy = "Attraits_sous_categories")
     * 
     * @var integer $categorie_id
     */
    private $categorie_id;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $nom_fr
     */
    private $nom_fr;

    /**
     * @ORM\Column(type = "string", length = 255)
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
     * @var string $image_doctrine
     */
    private $image_doctrine;
	
    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
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
            return __DIR__ . '/../../../../web/uploads/attrait_sous_categorie/';
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
     * Set categorie_id
     *
     * @param MyApp\MobileBundle\Entity\Attraits_categories $categorieId
     */
    public function setCategorieId(\MyApp\MobileBundle\Entity\Attraits_categories $categorieId)
    {
        $this->categorie_id = $categorieId;
    }

    /**
     * Get categorie_id
     *
     * @return MyApp\MobileBundle\Entity\Attraits_categories 
     */
    public function getCategorieId()
    {
        return $this->categorie_id;
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