<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "corporatifs_services")
 */
class Corporatifs_services
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
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Hebergements_salles_corporatives", inversedBy = "Corporatifs_services")
	 * @ORM\JoinTable(name = "relations_corporatif_service_hebergement_salle_corporative")
	 *
	 * @var ArrayCollection $hebergement_salles_corporatives_id
	 */
	private $hebergement_salles_corporatives_id;
	
	public function __construct()
	{
		$this->$hebergement_salles_corporatives_id = new ArrayCollection();
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
     * Add hebergement_salles_corporatives_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives $hebergementSallesCorporativesId
     */
    public function addHebergements_salles_corporatives(\MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives $hebergementSallesCorporativesId)
    {
        $this->hebergement_salles_corporatives_id[] = $hebergementSallesCorporativesId;
    }

    /**
     * Get hebergement_salles_corporatives_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementSallesCorporativesId()
    {
        return $this->hebergement_salles_corporatives_id;
    }
}