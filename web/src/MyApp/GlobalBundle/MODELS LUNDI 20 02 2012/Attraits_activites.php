<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "attraits_activites")
 */
class Attraits_activites{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue( strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Attraits", inversedBy="Attraits_activites")
	 * @ORM\JoinTable(name = "relations_attraits_activites_attraits")
	 * 
	 * @var ArrayCollection $attrait_activite_id
	 */
	private $attrait_activite_id;
	
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
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $image
	 */
	private $image;
	
	public function __construct()
	{
		$this->attrait_activite_id = new ArrayCollection();
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
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add attrait_activite_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits $attraitActiviteId
     */
    public function addAttraits(\MyApp\GlobalBundle\Entity\Attraits $attraitActiviteId)
    {
        $this->attrait_activite_id[] = $attraitActiviteId;
    }

    /**
     * Get attrait_activite_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitActiviteId()
    {
        return $this->attrait_activite_id;
    }
}