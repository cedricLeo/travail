<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "hebergements_videos")
 */
class Hebergements_videos{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\OneToOne(targetEntity="Hebergements")
	 * @ORM\JoinColumn(name="hebergement_id", referencedColumnName="id")           
	 *
	 * @var integer $hebergement
	 */
	private $hebergement;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $titre_fr
	 */
	private $titre_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $titre_en
	 */
	private $titre_en;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $url_fr
	 */
	private $url_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $url_en
	 */
	private $url_en;
	

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
     * Set titre_fr
     *
     * @param string $titreFr
     */
    public function setTitreFr($titreFr)
    {
        $this->titre_fr = $titreFr;
    }

    /**
     * Get titre_fr
     *
     * @return string 
     */
    public function getTitreFr()
    {
        return $this->titre_fr;
    }

    /**
     * Set titre_en
     *
     * @param string $titreEn
     */
    public function setTitreEn($titreEn)
    {
        $this->titre_en = $titreEn;
    }

    /**
     * Get titre_en
     *
     * @return string 
     */
    public function getTitreEn()
    {
        return $this->titre_en;
    }

    /**
     * Set url_fr
     *
     * @param string $urlFr
     */
    public function setUrlFr($urlFr)
    {
        $this->url_fr = $urlFr;
    }

    /**
     * Get url_fr
     *
     * @return string 
     */
    public function getUrlFr()
    {
        return $this->url_fr;
    }

    /**
     * Set url_en
     *
     * @param string $urlEn
     */
    public function setUrlEn($urlEn)
    {
        $this->url_en = $urlEn;
    }

    /**
     * Get url_en
     *
     * @return string 
     */
    public function getUrlEn()
    {
        return $this->url_en;
    }

    /**
     * Set hebergement
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergement
     */
    public function setHebergement(\MyApp\GlobalBundle\Entity\Hebergements $hebergement)
    {
        $this->hebergement = $hebergement;
    }

    /**
     * Get hebergement
     *
     * @return MyApp\GlobalBundle\Entity\Hebergements 
     */
    public function getHebergement()
    {
        return $this->hebergement;
    }
}