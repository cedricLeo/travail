<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "types_occupations")
 */
class Types_occupations
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type ="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
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
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $nom_en
	 */
	private $nom_en;
	
	/**
	 * @ORM\Column(type = "integer", length = 2)
	 *
	 * @var integer $valeur
	 */
	private $valeur;
	
	/**
	 * @ORM\Column(type = "integer", length = 2)
	 * 
	 * @var integer $default_chambre
	 */
	private $default_chambre;
	
	/**
	 * @ORM\Column(type = "integer", length = 2)
	 *
	 * @var integer $default_forfait
	 */
	private $default_forfait;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Chambres", inversedBy = "Types_occupations")
	 * @ORM\JoinTable(name = "relations_chambres_types_occupations")
	 * 
	 * @var ArrayCollection $chambre_id
	 */
	private $chambre_id;
	
	public function __construct()
	{
		$this->chambre_id = new ArrayCollection();
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
     * Set valeur
     *
     * @param integer $valeur
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
    }

    /**
     * Get valeur
     *
     * @return integer 
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set default_chambre
     *
     * @param integer $defaultChambre
     */
    public function setDefaultChambre($defaultChambre)
    {
        $this->default_chambre = $defaultChambre;
    }

    /**
     * Get default_chambre
     *
     * @return integer 
     */
    public function getDefaultChambre()
    {
        return $this->default_chambre;
    }

    /**
     * Set default_forfait
     *
     * @param integer $defaultForfait
     */
    public function setDefaultForfait($defaultForfait)
    {
        $this->default_forfait = $defaultForfait;
    }

    /**
     * Get default_forfait
     *
     * @return integer 
     */
    public function getDefaultForfait()
    {
        return $this->default_forfait;
    }

    /**
     * Add chambre_id
     *
     * @param MyApp\GlobalBundle\Entity\Chambres $chambreId
     */
    public function addChambres(\MyApp\GlobalBundle\Entity\Chambres $chambreId)
    {
        $this->chambre_id[] = $chambreId;
    }

    /**
     * Get chambre_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChambreId()
    {
        return $this->chambre_id;
    }
}