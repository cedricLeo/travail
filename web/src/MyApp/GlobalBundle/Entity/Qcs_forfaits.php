<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "qcs_forfaits")
 */
class Qcs_forfaits{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue( strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\OneToOne(targetEntity="Hebergements", mappedBy="Qcs_forfaits")
	 * 
	 * @var integer $hebergement_id
	 */
	private $hebergement_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Forfaits", inversedBy="Qcs_forfaits")
	 * 
	 * @var ArrayCollection $forfait_id
	 */
	private $forfait_id;

	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $titre_fr
	 */
	private $titre_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $titre_en
	 */
	private $titre_en;
        
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
	 * @ORM\Column(type = "text")
	 *
	 * @var text $conditions_fr
	 */
	private $conditions_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $conditions_en
	 */
	private $conditions_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $validite_fr
	 */
	private $validite_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $validite_en
	 */
	private $validite_en;
	
	/**
	 * @ORM\Column(type = "float")
	 * 
	 * @var float $tarif_depart
	 */
	private $tarif_depart;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $description_fr
	 */
	private $description_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $description_en
	 */
	private $description_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $image
	 */
	private $image;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $image_article
	 */
	private $image_article;

	public function __construct()
	{
		$this->forfait_id = new ArrayCollection();
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
     * Set conditions_fr
     *
     * @param text $conditionsFr
     */
    public function setConditionsFr($conditionsFr)
    {
        $this->conditions_fr = $conditionsFr;
    }

    /**
     * Get conditions_fr
     *
     * @return text 
     */
    public function getConditionsFr()
    {
        return $this->conditions_fr;
    }

    /**
     * Set conditions_en
     *
     * @param text $conditionsEn
     */
    public function setConditionsEn($conditionsEn)
    {
        $this->conditions_en = $conditionsEn;
    }

    /**
     * Get conditions_en
     *
     * @return text 
     */
    public function getConditionsEn()
    {
        return $this->conditions_en;
    }

    /**
     * Set validite_fr
     *
     * @param string $validiteFr
     */
    public function setValiditeFr($validiteFr)
    {
        $this->validite_fr = $validiteFr;
    }

    /**
     * Get validite_fr
     *
     * @return string 
     */
    public function getValiditeFr()
    {
        return $this->validite_fr;
    }

    /**
     * Set validite_en
     *
     * @param string $validiteEn
     */
    public function setValiditeEn($validiteEn)
    {
        $this->validite_en = $validiteEn;
    }

    /**
     * Get validite_en
     *
     * @return string 
     */
    public function getValiditeEn()
    {
        return $this->validite_en;
    }

    /**
     * Set tarif_depart
     *
     * @param float $tarifDepart
     */
    public function setTarifDepart($tarifDepart)
    {
        $this->tarif_depart = $tarifDepart;
    }

    /**
     * Get tarif_depart
     *
     * @return float 
     */
    public function getTarifDepart()
    {
        return $this->tarif_depart;
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
     * Set image_article
     *
     * @param string $imageArticle
     */
    public function setImageArticle($imageArticle)
    {
        $this->image_article = $imageArticle;
    }

    /**
     * Get image_article
     *
     * @return string 
     */
    public function getImageArticle()
    {
        return $this->image_article;
    }

    /**
     * Set hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementId
     */
    public function setHebergementId(\MyApp\GlobalBundle\Entity\Hebergements $hebergementId)
    {
        $this->hebergement_id = $hebergementId;
    }

    /**
     * Get hebergement_id
     *
     * @return MyApp\GlobalBundle\Entity\Hebergements 
     */
    public function getHebergementId()
    {
        return $this->hebergement_id;
    }

    /**
     * Add forfait_id
     *
     * @param MyApp\GlobalBundle\Entity\Forfaits $forfaitId
     */
    public function addForfaits(\MyApp\GlobalBundle\Entity\Forfaits $forfaitId)
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