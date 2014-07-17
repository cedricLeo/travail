<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "attraits_categories" )
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
	 * @ORM\ManyToMany(targetEntity = "Sous_categories_attraits", mappedBy = "Attraits_categories")
	 * 
	 * @var ArrayCollection $sous_categorie_attrait_id
	 */
	private $sous_categorie_attrait_id;
	
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
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_fr
	 */
	private $page_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_en
	 */
	private $page_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_titre_fr
	 */
	private $page_titre_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_titre_en
	 */
	private $page_titre_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_metakeyword_fr
	 */
	private $page_metakeyword_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
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
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $repertoire_fr
	 */
	private $repertoire_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string  $repertoire_en
	 */
	private $repertoire_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $image
	 */
	private $image;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $type_festival_evenement
	 */
	private $type_festival_evenement;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $type_restaurant
	 */
	private $type_restaurant;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $type_camping
	 */
	private $type_camping;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $type_centre_sante_spa
	 */
	private $type_centre_sante_spa;
	
	public function __construct()
	{
		$this->sous_categorie_attrait_id = new ArrayCollection();
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
     * @param MyApp\GlobalBundle\Entity\Sous_categories_attraits $sousCategorieAttraitId
     */
    public function addSous_categories_attraits(\MyApp\GlobalBundle\Entity\Sous_categories_attraits $sousCategorieAttraitId)
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
}