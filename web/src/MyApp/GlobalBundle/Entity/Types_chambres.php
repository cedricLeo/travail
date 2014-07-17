<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "types_chambres")
 */
class Types_chambres
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
	 * @ORM\Column(type = "string", length = 100)
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 100)
	 * 
	 * @var string nom_en
	 */
	private $nom_en;
        
       /**
        * @ORM\Column(type="string", length = 255, nullable = "true")
        * 
        * @var string $repertoire_fr
        */
       private $repertoire_fr;

       /**
        * @ORM\Column(type="string", length = 255, nullable = "true")
        * 
        * @var string $repertoire_en
        */
       private $repertoire_en;
	
	/**
	 * @ORM\Column(type = "integer", length = 2, nullable = "true")
	 * 
	 * @var integer $default_chambre
	 */
	private $default_chambre;
	
	/**
	 * @ORM\Column(type = "integer", length = 2, nullable = "true")
	 *
	 * @var integer $ordre_affichage
	 */
	private $ordre_affichage;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Chambres", mappedBy="Types_chambres")
	 * 
	 * @var ArrayCollection $chambretype_id
	 */
	private $chambretype_id;
	
	public function __construct()
	{
		$this->chambretype_id = new ArrayCollection();
	}
	
	public function __toString()
	{
		return $this->nom_fr;
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
     * Set ordre_affichage
     *
     * @param integer $ordreAffichage
     */
    public function setOrdreAffichage($ordreAffichage)
    {
        $this->ordre_affichage = $ordreAffichage;
    }

    /**
     * Get ordre_affichage
     *
     * @return integer 
     */
    public function getOrdreAffichage()
    {
        return $this->ordre_affichage;
    }

    /**
     * Add chambretype_id
     *
     * @param MyApp\GlobalBundle\Entity\Chambres $chambretypeId
     */
    public function addChambres(\MyApp\GlobalBundle\Entity\Chambres $chambretypeId)
    {
        $this->chambretype_id[] = $chambretypeId;
    }

    /**
     * Get chambretype_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChambretypeId()
    {
        return $this->chambretype_id;
    }
}