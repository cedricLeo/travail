<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "periodes_tarifications")
 */
class Periodes_tarifications{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Chambres", inversedBy = "Periodes_tarifications")
	 * @ORM\JoinColumn(name="chambre_id", referencedColumnName = "id")
	 *
	 * @var integer $chambre_id
	 */
	private $chambre_id;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $titre_fr
	 */
	private $titre_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var integer $titre_en
	 */
	private $titre_en;
	
	/**
	 * @ORM\Column(type = "decimal", length = 5)
	 *
	 * @var decimal $tarif_min
	 */
	private $tarif_min;
	
	/**
	 * @ORM\Column(type = "decimal", length = 5)
	 *
	 * @var decimal $tarif_max
	 */
	private $tarif_max;
	
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
     * Set tarif_min
     *
     * @param decimal $tarifMin
     */
    public function setTarifMin($tarifMin)
    {
        $this->tarif_min = $tarifMin;
    }

    /**
     * Get tarif_min
     *
     * @return decimal 
     */
    public function getTarifMin()
    {
        return $this->tarif_min;
    }

    /**
     * Set tarif_max
     *
     * @param decimal $tarifMax
     */
    public function setTarifMax($tarifMax)
    {
        $this->tarif_max = $tarifMax;
    }

    /**
     * Get tarif_max
     *
     * @return decimal 
     */
    public function getTarifMax()
    {
        return $this->tarif_max;
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
     * Set chambre_id
     *
     * @param MyApp\GlobalBundle\Entity\Chambres $chambreId
     */
    public function setChambreId(\MyApp\GlobalBundle\Entity\Chambres $chambreId)
    {
        $this->chambre_id = $chambreId;
    }

    /**
     * Get chambre_id
     *
     * @return MyApp\GlobalBundle\Entity\Chambres 
     */
    public function getChambreId()
    {
        return $this->chambre_id;
    }
}