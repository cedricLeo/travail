<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Cuisines_Repository")
 * @ORM\Table(name = "cuisines")
 */
class Cuisines{
	
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Column(type = "integer")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type = "string" , length = 255)
     * 
     * @var string $nom_fr
     */
    private $nom_fr;

    /**
     * @ORM\Column(type = "string" , length = 255)
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
     * @ORM\Column(type = "string" , length = 255)
     * 
     * @var string $page_metakeyword_fr
     */
    private $page_metakeyword_fr;

    /**
     * @ORM\Column(type = "string" , length = 255)
     * 
     * @var string $page_metakeyword_en
     */
    private $page_metakeyword_en;

    /**
     * @ORM\Column(type = "text")
     * 
     * @var text $page_metadescription_fr
     */
    private $page_metadescription_fr;

    /**
     * @ORM\Column(type = "text")
     * 
     * @var text $page_metadescription_en
     */
    private $page_metadescription_en;

    /**
     * @ORM\Column(type = "text")
     * 
     * @var text $texte_fr
     */
    private $texte_fr;

    /**
     * @ORM\Column(type = "text")
     * 
     * @var text $texte_en
     */
    private $texte_en;

    /**
     * @ORM\ManyToMany(targetEntity="Attraits", mappedBy="Cuisines")
     * 
     * @var ArrayCollection $attrait_id
     */
    private $attrait_id;
    
   /**
    * @ORM\OneToMany(targetEntity = "Texte_region_restaurant", mappedBy = "Cuisines", cascade={"remove"})
    *
    * @var integer $texte_region_sante
    */
   private $texte_region_sante;

   /**
    * @ORM\OneToMany(targetEntity = "Texte_province_restaurant", mappedBy = "Cuisines", cascade={"remove"})
    *
    * @var integer $texte_province_sante
    */
   private $texte_province_sante;


    public function __construct()
    {
            $this->attrait_id = new ArrayCollection();
    }

    public function __toString() {
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
     * Add texte_region_sante
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_restaurant $texteRegionSante
     */
    public function addTexte_region_restaurant(\MyApp\GlobalBundle\Entity\Texte_region_restaurant $texteRegionSante)
    {
        $this->texte_region_sante[] = $texteRegionSante;
    }

    /**
     * Get texte_region_sante
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionSante()
    {
        return $this->texte_region_sante;
    }

    /**
     * Add texte_province_sante
     *
     * @param MyApp\GlobalBundle\Entity\Texte_province_restaurant $texteProvinceSante
     */
    public function addTexte_province_restaurant(\MyApp\GlobalBundle\Entity\Texte_province_restaurant $texteProvinceSante)
    {
        $this->texte_province_sante[] = $texteProvinceSante;
    }

    /**
     * Get texte_province_sante
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceSante()
    {
        return $this->texte_province_sante;
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