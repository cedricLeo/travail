<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "types_prix")
 */
class Types_prix{
	
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue( strategy = "AUTO")
     * 
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type = "float", length = 6, nullable = "true")
     *
     * @var float $prix_min
     */
    private $prix_min;

    /**
     * @ORM\Column(type = "float", length = 6, nullable = "true")
     *
     * @var float $prix_max
     */
    private $prix_max;

    /**
     * @ORM\Column(type = "integer", nullable = "true")
     *
     * @var integer $calendrier_id
     */
    private $calendrier_id;

    /**
     * @ORM\Column(type = "integer", nullable = "false")
     *
     * @var integer $index_chambre
     */
    private $index_chambre;

    /**
     * @ORM\Column(type = "string", length = 150, nullable = "false")
     *
     * @var string $titre_haute_saison_fr
     */
    private $titre_haute_saison_fr;

    /**
     * @ORM\Column(type = "string", length = 150, nullable = "false")
     *
     * @var string $titre_haute_saison_en
     */
    private $titre_haute_saison_en;

    /**
     * @ORM\ManyToMany(targetEntity="Chambres", mappedBy="Types_prix", cascade={"remove"})
     * 
     * @var ArrayCollection $chambreprix_id
     */
    private $chambreprix_id;

    /**
     * @ORM\Column(type = "string", length = 20, nullable = "true")
     *
     * @var string $date_debut_basse_saison
     */
    private $date_debut_saison;

    /**
     * @ORM\Column(type = "string", length = 20, nullable = "true")
     *
     * @var string $date_fin_basse_saison
     */
    private $date_fin_saison;
    
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

    public function __construct() 
    {
            $this->chambreprix_id = new ArrayCollection();
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
     * Set prix_min
     *
     * @param float $prixMin
     */
    public function setPrixMin($prixMin)
    {
        $this->prix_min = $prixMin;
    }

    /**
     * Get prix_min
     *
     * @return float 
     */
    public function getPrixMin()
    {
        return $this->prix_min;
    }

    /**
     * Set prix_max
     *
     * @param float $prixMax
     */
    public function setPrixMax($prixMax)
    {
        $this->prix_max = $prixMax;
    }

    /**
     * Get prix_max
     *
     * @return float 
     */
    public function getPrixMax()
    {
        return $this->prix_max;
    }

    /**
     * Set calendrier_id
     *
     * @param integer $calendrierId
     */
    public function setCalendrierId($calendrierId)
    {
        $this->calendrier_id = $calendrierId;
    }

    /**
     * Get calendrier_id
     *
     * @return integer 
     */
    public function getCalendrierId()
    {
        return $this->calendrier_id;
    }

    /**
     * Set titre_haute_saison_fr
     *
     * @param string $titreHauteSaisonFr
     */
    public function setTitreHauteSaisonFr($titreHauteSaisonFr)
    {
        $this->titre_haute_saison_fr = $titreHauteSaisonFr;
    }

    /**
     * Get titre_haute_saison_fr
     *
     * @return string 
     */
    public function getTitreHauteSaisonFr()
    {
        return $this->titre_haute_saison_fr;
    }

    /**
     * Set titre_haute_saison_en
     *
     * @param string $titreHauteSaisonEn
     */
    public function setTitreHauteSaisonEn($titreHauteSaisonEn)
    {
        $this->titre_haute_saison_en = $titreHauteSaisonEn;
    }

    /**
     * Get titre_haute_saison_en
     *
     * @return string 
     */
    public function getTitreHauteSaisonEn()
    {
        return $this->titre_haute_saison_en;
    }

    /**
     * Add chambreprix_id
     *
     * @param MyApp\GlobalBundle\Entity\Chambres $chambreprixId
     */
    public function addChambres(\MyApp\GlobalBundle\Entity\Chambres $chambreprixId)
    {
    	if($chambreprixId != null)
        	$this->chambreprix_id[] = $chambreprixId;
    }

    /**
     * Get chambreprix_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChambreprixId()
    {
        return $this->chambreprix_id;
    }

    /**
     * Set index_chambre
     *
     * @param integer $indexChambre
     */
    public function setIndexChambre($indexChambre)
    {
        $this->index_chambre = $indexChambre;
    }

    /**
     * Get index_chambre
     *
     * @return integer 
     */
    public function getIndexChambre()
    {
        return $this->index_chambre;
    }

    /**
     * Set date_debut_saison
     *
     * @param string $dateDebutSaison
     */
    public function setDateDebutSaison($dateDebutSaison)
    {
        $this->date_debut_saison = $dateDebutSaison;
    }

    /**
     * Get date_debut_saison
     *
     * @return string 
     */
    public function getDateDebutSaison()
    {
        return $this->date_debut_saison;
    }

    /**
     * Set date_fin_saison
     *
     * @param string $dateFinSaison
     */
    public function setDateFinSaison($dateFinSaison)
    {
        $this->date_fin_saison = $dateFinSaison;
    }

    /**
     * Get date_fin_saison
     *
     * @return string 
     */
    public function getDateFinSaison()
    {
        return $this->date_fin_saison;
    }
}