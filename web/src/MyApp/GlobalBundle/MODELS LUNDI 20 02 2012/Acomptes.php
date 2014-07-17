<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "acomptes")
 */
class Acomptes{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $nom_en
	 */
	private $nom_en;
	
	/**
	 * @ORM\Column(type="boolean")
	 * 
	 * @var boolean $default_hebergement
	 */
	private $default_hebergement;


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
     * Set default_hebergement
     *
     * @param boolean $defaultHebergement
     */
    public function setDefaultHebergement($defaultHebergement)
    {
        $this->default_hebergement = $defaultHebergement;
    }

    /**
     * Get default_hebergement
     *
     * @return boolean 
     */
    public function getDefaultHebergement()
    {
        return $this->default_hebergement;
    }
}