<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "chambres")
 */
class Chambres{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Hebergements", inversedBy="Chambres")
	 * @ORM\JoinTable(name = "relations_hebergements_chambres")
	 * 
	 * @var ArrayCollection $hebergement_id
	 */
	private $hebergement_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Types_chambres", inversedBy="Chambres")
	 * @ORM\JoinTable(name = "relations_chambres_types_chambres")
	 *
	 * @var ArrayCollection $type_chambre_id
	 */
	private $type_chambre_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Types_occupations", inversedBy="Chambres")
	 * @ORM\JoinTable(name = "relations_types_occupations_chambres")
	 *
	 * @var ArrayCollection $type_occupation_id
	 */
	private $type_occupation_id;
	
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
	 * @ORM\Column(type = "integer", length = 4)
	 * 
	 * @var integer $quantite
	 */
	private $quantite;
	
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
	 * @ORM\Column(type = "integer", length = 2)
	 * 
	 * @var integer $nb_occupants
	 */
	private $nb_occupants;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $actif
	 */
	private $actif;
	
	/**
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $photo_id
	 */
	private $photo_id;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Periodes_tarifications", mappedBy = "Chambres")
	 * 
	 * @var integer $periode_tarif_id
	 */
	private $periode_tarif_id;
	
	public function __construct()
	{
		$this->type_chambre_id = new ArrayCollection();
		$this->hebergement_id = new ArrayCollection();
		$this->$type_occupation_id = new ArrayCollection();
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
     * Set quantite
     *
     * @param integer $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
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
     * Set nb_occupants
     *
     * @param integer $nbOccupants
     */
    public function setNbOccupants($nbOccupants)
    {
        $this->nb_occupants = $nbOccupants;
    }

    /**
     * Get nb_occupants
     *
     * @return integer 
     */
    public function getNbOccupants()
    {
        return $this->nb_occupants;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set photo_id
     *
     * @param integer $photoId
     */
    public function setPhotoId($photoId)
    {
        $this->photo_id = $photoId;
    }

    /**
     * Get photo_id
     *
     * @return integer 
     */
    public function getPhotoId()
    {
        return $this->photo_id;
    }

    /**
     * Add hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementId
     */
    public function addHebergements(\MyApp\GlobalBundle\Entity\Hebergements $hebergementId)
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
     * Add type_chambre_id
     *
     * @param MyApp\GlobalBundle\Entity\Types_chambres $typeChambreId
     */
    public function addTypes_chambres(\MyApp\GlobalBundle\Entity\Types_chambres $typeChambreId)
    {
        $this->type_chambre_id[] = $typeChambreId;
    }

    /**
     * Get type_chambre_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTypeChambreId()
    {
        return $this->type_chambre_id;
    }

    /**
     * Add type_occupation_id
     *
     * @param MyApp\GlobalBundle\Entity\Type_occupation $typeOccupationId
     */
    public function addType_occupation(\MyApp\GlobalBundle\Entity\Type_occupation $typeOccupationId)
    {
        $this->type_occupation_id[] = $typeOccupationId;
    }

    /**
     * Get type_occupation_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTypeOccupationId()
    {
        return $this->type_occupation_id;
    }

    /**
     * Add type_occupation_id
     *
     * @param MyApp\GlobalBundle\Entity\Types_occupations $typeOccupationId
     */
    public function addTypes_occupations(\MyApp\GlobalBundle\Entity\Types_occupations $typeOccupationId)
    {
        $this->type_occupation_id[] = $typeOccupationId;
    }

    /**
     * Add periode_tarif_id
     *
     * @param MyApp\GlobalBundle\Entity\Periodes_tarifications $periodeTarifId
     */
    public function addPeriodes_tarifications(\MyApp\GlobalBundle\Entity\Periodes_tarifications $periodeTarifId)
    {
        $this->periode_tarif_id[] = $periodeTarifId;
    }

    /**
     * Get periode_tarif_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPeriodeTarifId()
    {
        return $this->periode_tarif_id;
    }
}