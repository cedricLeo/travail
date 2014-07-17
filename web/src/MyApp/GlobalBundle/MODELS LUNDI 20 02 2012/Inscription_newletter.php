<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "inscription_newletter")
 */
class Inscription_newletter{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length = 100)
	 * 
	 * @var string $courriel
	 */
	private $courriel;
	
	/**
	 * @ORM\Column(type="date")
	 * 
	 * @var date $date_created
	 */
	private $date_created;
	

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
     * Set courriel
     *
     * @param string $courriel
     */
    public function setCourriel($courriel)
    {
        $this->courriel = $courriel;
    }

    /**
     * Get courriel
     *
     * @return string 
     */
    public function getCourriel()
    {
        return $this->courriel;
    }

    /**
     * Set date_created
     *
     * @param date $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;
    }

    /**
     * Get date_created
     *
     * @return date 
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }
}