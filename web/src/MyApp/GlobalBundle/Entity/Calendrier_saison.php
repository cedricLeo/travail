<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Calendrier_saisonRepository")
 * @ORM\Table(name = "calendrier_saison")
 */
class Calendrier_saison{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
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
	 * @ORM\ManyToMany(targetEntity="Hebergements", mappedBy="Calendrier_saison", cascade={"persist"})
	 *
	 * @var ArrayCollection $hebergement_id
	 */
	private $hebergement_id;

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
     * Set id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Set hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementId
     */
    public function setHebergementId(\MyApp\GlobalBundle\Entity\Hebergements $hebergementId)
    {
        $this->hebergement_id = $hebergementId;
    }

    /**
     * Get hebergement_id
     *
     * @return MyApp\GlobalBundle\Entity\Hebergements 
     */
    public function getHebergementId()
    {
        return $this->hebergement_id;
    }
}