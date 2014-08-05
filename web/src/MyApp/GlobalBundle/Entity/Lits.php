<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\LitsRepository")
 * @ORM\Table(name = "lits")
 */
class Lits{
	
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Column(type = "integer")
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
     * @ORM\Column(type="string", length = 255, nullable = "true")
     * 
     * @var string $repertoire_fr
     */
    private $repertoire_fr;
    
    /**
     * @ORM\Column(type="integer", length = 2, nullable = "true")
     * 
     * @var integer $quantite
     */
    private $quantite;

    /**
     * @ORM\Column(type="string", length = 255, nullable = "true")
     * 
     * @var string $repertoire_en
     */
    private $repertoire_en;

    /**
     * @ORM\ManyToMany(targetEntity="Chambres", mappedBy="Lits")
     * 
     * @var ArrayCollection $chambrelit_id
     */
    private $chambrelit_id;

    public function __construct()
    {
            $this->chambrelit_id = new ArrayCollection();
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
     * Add chambrelit_id
     *
     * @param MyApp\GlobalBundle\Entity\Chambres $chambrelitId
     */
    public function addChambres(\MyApp\GlobalBundle\Entity\Chambres $chambrelitId)
    {
        $this->chambrelit_id[] = $chambrelitId;
    }

    /**
     * Get chambrelit_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChambrelitId()
    {
        return $this->chambrelit_id;
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

    /**
     * Set quantite
     *
     * @param integer $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }
}