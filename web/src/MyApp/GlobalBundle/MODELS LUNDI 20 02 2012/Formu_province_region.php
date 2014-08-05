<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "formu_province_region")
 */
class Formu_province_region{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Provinces_etats", inversedBy ="Formu_province_region")
	 * 
	 * @var integer $province
	 */
	private $province;

	
	/**
	 * @ORM\ManyToOne(targetEntity = "Regions", inversedBy = "Formu_province_region")
	 * 
	 * @var integer $region
	 */
	private $region;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $hebergement
	 */
	private $hebergement;
	
	/**
	* @ORM\Column(type = "boolean")
	*
	* @var boolean $forfait
	*/
	private $forfait;
	
	/**
	* @ORM\Column(type = "boolean")
	*
	* @var boolean $corporatif
	*/
	private $corporatif;
	
	/**
	* @ORM\Column(type = "boolean")
	*
	* @var boolean $centre
	*/
	private $centresante;
	
	/**
	* @ORM\Column(type = "boolean")
	*
	* @var boolean $attrait
	*/
	private $attrait;
	
	/**
	* @ORM\Column(type = "boolean")
	*
	* @var boolean $destination
	*/
	private $destination;
	
	/**
	* @ORM\Column(type = "boolean")
	*
	* @var boolean $restaurant
	*/
	private $restaurant;

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
     * Set hebergement
     *
     * @param boolean $hebergement
     */
    public function setHebergement($hebergement)
    {
        $this->hebergement = $hebergement;
    }

    /**
     * Get hebergement
     *
     * @return boolean 
     */
    public function getHebergement()
    {
        return $this->hebergement;
    }

    /**
     * Set forfait
     *
     * @param boolean $forfait
     */
    public function setForfait($forfait)
    {
        $this->forfait = $forfait;
    }

    /**
     * Get forfait
     *
     * @return boolean 
     */
    public function getForfait()
    {
        return $this->forfait;
    }

    /**
     * Set corporatif
     *
     * @param boolean $corporatif
     */
    public function setCorporatif($corporatif)
    {
        $this->corporatif = $corporatif;
    }

    /**
     * Get corporatif
     *
     * @return boolean 
     */
    public function getCorporatif()
    {
        return $this->corporatif;
    }

    /**
     * Set centresante
     *
     * @param boolean $centresante
     */
    public function setCentresante($centresante)
    {
        $this->centresante = $centresante;
    }

    /**
     * Get centresante
     *
     * @return boolean 
     */
    public function getCentresante()
    {
        return $this->centresante;
    }

    /**
     * Set attrait
     *
     * @param boolean $attrait
     */
    public function setAttrait($attrait)
    {
        $this->attrait = $attrait;
    }

    /**
     * Get attrait
     *
     * @return boolean 
     */
    public function getAttrait()
    {
        return $this->attrait;
    }

    /**
     * Set destination
     *
     * @param boolean $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * Get destination
     *
     * @return boolean 
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set restaurant
     *
     * @param boolean $restaurant
     */
    public function setRestaurant($restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * Get restaurant
     *
     * @return boolean 
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * Set province
     *
     * @param MyApp\GlobalBundle\Entity\Provinces_etats $province
     */
    public function setProvince(\MyApp\GlobalBundle\Entity\Provinces_etats $province)
    {
        $this->province = $province;
    }

    /**
     * Get province
     *
     * @return MyApp\GlobalBundle\Entity\Provinces_etats 
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set region
     *
     * @param MyApp\GlobalBundle\Entity\Regions $region
     */
    public function setRegion(\MyApp\GlobalBundle\Entity\Regions $region)
    {
        $this->region = $region;
    }

    /**
     * Get region
     *
     * @return MyApp\GlobalBundle\Entity\Regions 
     */
    public function getRegion()
    {
        return $this->region;
    }
}