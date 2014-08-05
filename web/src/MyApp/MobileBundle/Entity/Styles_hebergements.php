<?php

namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\Styles_hebergementsRepository")
 * @ORM\Table(name = "styles_hebergements")
 * @ORM\HasLifecycleCallbacks
 */
class Styles_hebergements{
	
	/**
	 * @ORM\Id
	 * @ORM\Column( type = "integer")
	 * @ORM\Generatedvalue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Hebergements", mappedBy = "Styles_hebergements")
	 * 
	 * @var ArrayCollection $style_hebergement
	 */
	private $style_hebergement;
	
	/**
	 * @ORM\Column(type = "string", length = 100)
	 *
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 100)
	 * 
	 * @var string $nom_en
	 */
	private $nom_en;
	
	public function __construct()
	{
		$this->style_hebergement = new ArrayCollection();
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
     * Add style_hebergement
     *
     * @param MyApp\MobileBundle\Entity\Hebergements $styleHebergement
     */
    public function addHebergements(\MyApp\MobileBundle\Entity\Hebergements $styleHebergement)
    {
        $this->style_hebergement[] = $styleHebergement;
    }

    /**
     * Get style_hebergement
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getStyleHebergement()
    {
        return $this->style_hebergement;
    }
}