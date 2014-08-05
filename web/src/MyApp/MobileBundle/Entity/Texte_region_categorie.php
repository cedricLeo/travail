<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\Texte_region_categorieRepository")
 * @ORM\Table(name = "texte_region_categorie")
 */
class Texte_region_categorie {
	
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type = "string", nullable = "true")
     * 
     * @var string $page_titre_fr
     */
    private $page_titre_fr;

     /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $page_metadescription_fr
     */
    private $page_metadescription_fr;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_fr
     */
    private $texte_fr;
    
    /**
     * @ORM\Column(type = "string", nullable = "true")
     * 
     * @var string $page_titre_en
     */
    private $page_titre_en;

     /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $page_metadescription_en
     */
    private $page_metadescription_en;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_en
     */
    private $texte_en;

    /**
     * @ORM\ManyToOne(targetEntity = "Regions", inversedBy = "Texte_region_categorie")
     * 
     * @var integer $region
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity = "Categories_hebergements", inversedBy = "Texte_region_categorie", cascade={"persist"} )
     * 
     * @var integer $categorie_hebergement
     */
    private $categorie_hebergement;
   
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
     * Set region
     *
     * @param MyApp\MobileBundle\Entity\Regions $region
     */
    public function setRegion(\MyApp\MobileBundle\Entity\Regions $region)
    {
        $this->region = $region;
    }

    /**
     * Get region
     *
     * @return MyApp\MobileBundle\Entity\Regions 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set categorie_hebergement
     *
     * @param MyApp\MobileBundle\Entity\Categories_hebergements $categorieHebergement
     */
    public function setCategorieHebergement(\MyApp\MobileBundle\Entity\Categories_hebergements $categorieHebergement)
    {
        $this->categorie_hebergement = $categorieHebergement;
    }

    /**
     * Get categorie_hebergement
     *
     * @return MyApp\MobileBundle\Entity\Categories_hebergements 
     */
    public function getCategorieHebergement()
    {
        return $this->categorie_hebergement;
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