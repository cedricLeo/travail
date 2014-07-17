<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Cuisine_Repository")
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
	 * @ORM\ManyToMany(targetEntity = "Regions", mappedBy = "Cuisines")
	 * 
	 * @var ArrayCollection $region_id
	 */
	private $region_id;
	
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
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_fr
	 */
	private $page_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_en
	 */
	private $page_en;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_titre_fr
	 */
	private $page_titre_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_titre_en
	 */
	private $page_titre_en;
	
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
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_metadescription_fr
	 */
	private $page_metadescription_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $page_metadescription_en
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
	 * @ORM\ManyToMany(targetEntity="Attraits", inversedBy="Cuisines")
	 * @ORM\JoinTable(name="relations_attrait_cuisine")
	 * 
	 * @var ArraayCollection $attrait_id
	 */
	private $attrait_id;
	
	
	public function __construct()
	{
		$this->region_id = new ArrayCollection();
		$this->attrait_id = new ArrayCollection();
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
     * @param string $pageMetadescriptionFr
     */
    public function setPageMetadescriptionFr($pageMetadescriptionFr)
    {
        $this->page_metadescription_fr = $pageMetadescriptionFr;
    }

    /**
     * Get page_metadescription_fr
     *
     * @return string 
     */
    public function getPageMetadescriptionFr()
    {
        return $this->page_metadescription_fr;
    }

    /**
     * Set page_metadescription_en
     *
     * @param string $pageMetadescriptionEn
     */
    public function setPageMetadescriptionEn($pageMetadescriptionEn)
    {
        $this->page_metadescription_en = $pageMetadescriptionEn;
    }

    /**
     * Get page_metadescription_en
     *
     * @return string 
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
     * Add region_id
     *
     * @param MyApp\GlobalBundle\Entity\Regions $regionId
     */
    public function addRegions(\MyApp\GlobalBundle\Entity\Regions $regionId)
    {
        $this->region_id[] = $regionId;
    }

    /**
     * Get region_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRegionId()
    {
        return $this->region_id;
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
}