<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\DeviseRepository")
 * @ORM\Table(name = "devises")
 */
class Devises
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	* @ORM\Column(type = "string", length = 3, nullable = true)
	*
	* @var string $abreviation
	*/
	private $abreviation;
	
	/**
	 * @ORM\Column(type = "string", length = 1, nullable = true)
	 * 
	 * @var string $symbole
	 */
	private $symbole;
	
	/**
	 * @ORM\Column(type = "string", length = 8, nullable = "true")
	 * 
	 * @var string $taux_change
	 */
	private $taux_change;
	
	/**
	 * @ORM\Column(type="datetime", nullable = "true")
	 * 
	 * @var datetime $date_update
	 */
	private $date_update;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Hebergements", mappedBy="Devises")
	 * 
	 * @var ArrayCollection $hebergement_id
	 */
	private $hebergement_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Attraits", mappedBy="Devises")
	 * 
	 * @var ArrayCollection $attrait_id
	 */
	private $attrait_id;
	
	public function __construct()
	{
		$this->hebergement_id = new ArrayCollection();
		$this->attrait_id = new ArrayCollection();
	}
	
	public function __toString()
	{
		return $this->abreviationfr;
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
     * Set abreviation
     *
     * @param string $abreviation
     */
    public function setAbreviation($abreviation)
    {
        $this->abreviation = $abreviation;
    }

    /**
     * Get abreviation
     *
     * @return string 
     */
    public function getAbreviation()
    {
        return $this->abreviation;
    }

    /**
     * Set symbole
     *
     * @param string $symbole
     */
    public function setSymbole($symbole)
    {
        $this->symbole = $symbole;
    }

    /**
     * Get symbole
     *
     * @return string 
     */
    public function getSymbole()
    {
        return $this->symbole;
    }

    /**
     * Set taux_change
     *
     * @param float $tauxChange
     */
    public function setTauxChange($tauxChange)
    {
        $this->taux_change = $tauxChange;
    }

    /**
     * Get taux_change
     *
     * @return float 
     */
    public function getTauxChange()
    {
        return $this->taux_change;
    }

    /**
     * Set date_update
     *
     * @param datetime $dateUpdate
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->date_update = $dateUpdate;
    }

    /**
     * Get date_update
     *
     * @return datetime 
     */
    public function getDateUpdate()
    {
        return $this->date_update;
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
     * Add attrait_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits $attraitId
     */
    public function addAttraits(\MyApp\GlobalBundle\Entity\Attraits $attraitId)
    {
        $this->attrait_id[] = $attraitId;
    }

    /**
     * Get attrait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitId()
    {
        return $this->attrait_id;
    }
}