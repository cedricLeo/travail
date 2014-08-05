<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\VideosRepository")
 * @ORM\Table(name = "videos")
 * @ORM\HasLifecycleCallbacks
 */
class Videos{
	
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type="string", length = 255, nullable = "true")
     * 
     * @var string $titre_fr
     */
    private $titre_fr;

    /**
     * @ORM\Column(type="string", length = 255, nullable = "true")
     * 
     * @var string $titre_en
     */
    private $titre_en;
    
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
     * @ORM\Column(type="string", length = 255, nullable = "true")
     *
     * @var string $url_fr
     */
    private $url_fr;

    /**
     * @ORM\Column(type="string", length = 255, nullable = "true")
     *
     * @var string $url_en
     */
    private $url_en;

    /**
     * @ORM\ManyToOne(targetEntity="Hebergements", inversedBy ="Videos")
     *
     * @var integer $hebergement
     */
    private $hebergement;

    /**
     * @ORM\ManyToOne(targetEntity="Attraits", inversedBy ="Videos")
     *
     * @var integer $attrait
     */
    private $attrait;

    /**
     * @ORM\ManyToOne(targetEntity="Villes", inversedBy ="Videos")
     *
     * @var integer $ville
     */
    private $ville;
	 

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
     * @param MyApp\MobileBundle\Entity\Hebergements $hebergement
     */
    public function setHebergement(\MyApp\MobileBundle\Entity\Hebergements $hebergement)
    {
        $this->hebergement = $hebergement;
    }

    /**
     * Get hebergement
     *
     * @return MyApp\MobileBundle\Entity\Hebergements 
     */
    public function getHebergement()
    {
        return $this->hebergement;
    }

    /**
     * Set attrait
     *
     * @param MyApp\MobileBundle\Entity\Attraits $attrait
     */
    public function setAttrait(\MyApp\MobileBundle\Entity\Attraits $attrait)
    {
        $this->attrait = $attrait;
    }

    /**
     * Get attrait
     *
     * @return MyApp\MobileBundle\Entity\Attraits 
     */
    public function getAttrait()
    {
        return $this->attrait;
    }

    /**
     * Set ville
     *
     * @param MyApp\MobileBundle\Entity\Villes $ville
     */
    public function setVille(\MyApp\MobileBundle\Entity\Villes $ville)
    {
        $this->ville = $ville;
    }

    /**
     * Get ville
     *
     * @return MyApp\MobileBundle\Entity\Villes 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set repertoire_fr
     *
     * @param string $repertoireFr
     */
    public function setRepertoireFr($repertoireFr)
    {
        $this->repertoire_fr = $repertoireFr;
    }

    /**
     * Get repertoire_fr
     *
     * @return string 
     */
    public function getRepertoireFr()
    {
        return $this->repertoire_fr;
    }

    /**
     * Set repertoire_en
     *
     * @param string $repertoireEn
     */
    public function setRepertoireEn($repertoireEn)
    {
        $this->repertoire_en = $repertoireEn;
    }

    /**
     * Get repertoire_en
     *
     * @return string 
     */
    public function getRepertoireEn()
    {
        return $this->repertoire_en;
    }
}