<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "hebergements_textessallescorporatif")
 */
class Hebergements_textessallescorporatif{ 
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="integer")
	 * 
	 * @var integer $idhebergement
	 */
	private $idhebergement;
	
	/**
	 * @ORM\Column(type="text")
	 * 
	 * @var text $textesallescorporativesfr
	 */
	private $textesallescorporativesfr;
	
	/**
	 * @ORM\Column(type="text")
	 * 
	 * @var text $textesallescorporativesen
	 */
	private $textesallescorporativesen;
	
	/**
	 * @ORM\Column(type="text")
	 *
	 * @var text $textecapacitecorporativefr
	 */
	private $textecapacitecorporativefr;
    
	/**
	 * @ORM\Column(type="text")
	 *
	 * @var text $textecapacitecorporativeen
	 */
	private $textecapacitecorporativeen;

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
     * Set idhebergement
     *
     * @param integer $idhebergement
     */
    public function setIdhebergement($idhebergement)
    {
        $this->idhebergement = $idhebergement;
    }

    /**
     * Get idhebergement
     *
     * @return integer 
     */
    public function getIdhebergement()
    {
        return $this->idhebergement;
    }

    /**
     * Set textesallescorporativesfr
     *
     * @param text $textesallescorporativesfr
     */
    public function setTextesallescorporativesfr($textesallescorporativesfr)
    {
        $this->textesallescorporativesfr = $textesallescorporativesfr;
    }

    /**
     * Get textesallescorporativesfr
     *
     * @return text 
     */
    public function getTextesallescorporativesfr()
    {
        return $this->textesallescorporativesfr;
    }

    /**
     * Set textesallescorporativesen
     *
     * @param text $textesallescorporativesen
     */
    public function setTextesallescorporativesen($textesallescorporativesen)
    {
        $this->textesallescorporativesen = $textesallescorporativesen;
    }

    /**
     * Get textesallescorporativesen
     *
     * @return text 
     */
    public function getTextesallescorporativesen()
    {
        return $this->textesallescorporativesen;
    }

    /**
     * Set textecapacitecorporativefr
     *
     * @param text $textecapacitecorporativefr
     */
    public function setTextecapacitecorporativefr($textecapacitecorporativefr)
    {
        $this->textecapacitecorporativefr = $textecapacitecorporativefr;
    }

    /**
     * Get textecapacitecorporativefr
     *
     * @return text 
     */
    public function getTextecapacitecorporativefr()
    {
        return $this->textecapacitecorporativefr;
    }

    /**
     * Set textecapacitecorporativeen
     *
     * @param text $textecapacitecorporativeen
     */
    public function setTextecapacitecorporativeen($textecapacitecorporativeen)
    {
        $this->textecapacitecorporativeen = $textecapacitecorporativeen;
    }

    /**
     * Get textecapacitecorporativeen
     *
     * @return text 
     */
    public function getTextecapacitecorporativeen()
    {
        return $this->textecapacitecorporativeen;
    }
}