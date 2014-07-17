<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "villes_videos")
 */
class Villes_videos{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\OneToOne(targetEntity="Villes")
	 * @ORM\JoinColumn(name="ville_id", referencedColumnName="id")           
	 *
	 * @var integer $ville
	 */
	private $ville;
	
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
     * Set ville
     *
     * @param MyApp\GlobalBundle\Entity\Villes $ville
     */
    public function setVille(\MyApp\GlobalBundle\Entity\Villes $ville)
    {
        $this->ville = $ville;
    }

    /**
     * Get ville
     *
     * @return MyApp\GlobalBundle\Entity\Villes 
     */
    public function getVille()
    {
        return $this->ville;
    }
}