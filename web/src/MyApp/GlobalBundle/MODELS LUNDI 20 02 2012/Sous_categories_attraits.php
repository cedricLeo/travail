<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sous_categories_attraits")
 */
class Sous_categories_attraits{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Attraits_categories", inversedBy = "Sous_categories_attraits")
	 * @ORM\JoinTable(name = "attrait_categorie_id")
	 * 
	 * @var ArrayCollection $attrait_categorie_id
	 */
	private $attrait_categorie_id;
	
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
	* @ORM\Column(type = "string", length = 255)
	* 
	* @var string $repertoire_fr
	*/
	private $repertoire_fr;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	* 
	* @var string $repertoire_en
	*/
	private $repertoire_en;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	* 
	* @var $titre_fr
	*/
	private $titre_fr;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	* 
	* @var string $titre_en
	*/
	private $titre_en;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	* 
	* @var string $image
	*/
	private $image;
	
	public function __construct()
	{
		$this->attrait_categorie_id = new ArrayCollection();
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
     * Set attrait_categorie_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits_categories $attraitCategorieId
     */
    public function setAttraitCategorieId(\MyApp\GlobalBundle\Entity\Attraits_categories $attraitCategorieId)
    {
        $this->attrait_categorie_id = $attraitCategorieId;
    }

    /**
     * Get attrait_categorie_id
     *
     * @return MyApp\GlobalBundle\Entity\Attraits_categories 
     */
    public function getAttraitCategorieId()
    {
        return $this->attrait_categorie_id;
    }
}