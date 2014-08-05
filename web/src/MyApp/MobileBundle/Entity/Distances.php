<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\DistancesRepository")
 * @ORM\Table(name="distances", indexes={@ORM\index(name="distance_idx", columns={ "hebergement"})})
 */
class Distances {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy= "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Hebergements", inversedBy = "Distances")
	 *
	 * @var integer $hebergement_id
	 */
	private $hebergement_id;
	
	/**
	 * @ORM\Column(type = "string", length = 20, nullable = "false")
	 *
	 * @var string $distance
	 */
	private $distance;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "false")
	 *
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "false")
	 *
	 * @var string $nom_en
	 */
	private $nom_en;
	
	/**
	 * @ORM\Column(type = "integer", nullable = "false")
	 *
	 * @var integer $activite_id
	 */
	private $activite_id;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "true")
	 *
	 * @var string $hebergement
	 */
	private $hebergement;

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
     * Set distance
     *
     * @param string $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * Get distance
     *
     * @return string 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set activite_id
     *
     * @param integer $activiteId
     */
    public function setActiviteId($activiteId)
    {
        $this->activite_id = $activiteId;
    }

    /**
     * Get activite_id
     *
     * @return integer 
     */
    public function getActiviteId()
    {
        return $this->activite_id;
    }


    /**
     * Set hebergement_id
     *
     * @param MyApp\MobileBundle\Entity\Hebergements $hebergementId
     */
    public function setHebergementId(\MyApp\MobileBundle\Entity\Hebergements $hebergementId)
    {
        $this->hebergement_id = $hebergementId;
    }

    /**
     * Get hebergement_id
     *
     * @return MyApp\MobileBundle\Entity\Hebergements 
     */
    public function getHebergementId()
    {
        return $this->hebergement_id;
    }

    /**
     * Set hebergement
     *
     * @param string $hebergement
     */
    public function setHebergement($hebergement)
    {
        $this->hebergement = $hebergement;
    }

    /**
     * Get hebergement
     *
     * @return string 
     */
    public function getHebergement()
    {
        return $this->hebergement;
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
}