<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 *@ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\PaysRepository")
 *@ORM\Table(name = "pays")
 */
class Pays{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer" )
	 * 
	 * @var integer $id
	 */
	private $id;
	
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
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $reservit_id
	 */
	private $reservit_id;


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
     * Set reservit_id
     *
     * @param integer $reservitId
     */
    public function setReservitId($reservitId)
    {
        $this->reservit_id = $reservitId;
    }

    /**
     * Get reservit_id
     *
     * @return integer 
     */
    public function getReservitId()
    {
        return $this->reservit_id;
    }
}