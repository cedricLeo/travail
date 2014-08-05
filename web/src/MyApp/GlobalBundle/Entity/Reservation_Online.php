<?php

namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name = "reservationonline")
 */
class Reservation_Online
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\generatedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type = "date")
	 * 
	 * @var date $date_debut
	 */
	private $date_debut;
	
	/**
	 * @ORM\Column(type = "date")
	 * 
	 * @var date $date_fin
	 */
	private $date_fin;
	
	/**
	 * @ORM\Column(type = "integer", length = 3)
	 * 
	 * @var integer $chambre
	 */
	private $chambre;
	
	/**
	 * @ORM\Column(type = "integer", length = 3)
	 * 
	 * @var integer $adulte
	 */
	private $adulte;
	
	/**
	 * @ORM\Column(type = "integer", length = 3)
	 * 
	 * @var integer $enfant
	 */
	private $enfant;

  

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
     * Set date_debut
     *
     * @param date $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->date_debut = $dateDebut;
    }

    /**
     * Get date_debut
     *
     * @return date 
     */
    public function getDateDebut()
    {
        return $this->date_debut;
    }

    /**
     * Set date_fin
     *
     * @param date $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->date_fin = $dateFin;
    }

    /**
     * Get date_fin
     *
     * @return date 
     */
    public function getDateFin()
    {
        return $this->date_fin;
    }

    /**
     * Set chambre
     *
     * @param integer $chambre
     */
    public function setChambre($chambre)
    {
        $this->chambre = $chambre;
    }

    /**
     * Get chambre
     *
     * @return integer 
     */
    public function getChambre()
    {
        return $this->chambre;
    }

    /**
     * Set adulte
     *
     * @param integer $adulte
     */
    public function setAdulte($adulte)
    {
        $this->adulte = $adulte;
    }

    /**
     * Get adulte
     *
     * @return integer 
     */
    public function getAdulte()
    {
        return $this->adulte;
    }

    /**
     * Set enfant
     *
     * @param integer $enfant
     */
    public function setEnfant($enfant)
    {
        $this->enfant = $enfant;
    }

    /**
     * Get enfant
     *
     * @return integer 
     */
    public function getEnfant()
    {
        return $this->enfant;
    }
}