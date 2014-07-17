<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "hebergements_salles_corporatives")
 */
class Hebergements_salles_corporatives
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
	 * @ORM\ManyToMany(targetEntity = "Hebergements", inversedBy = "Hebergements_salles_corporatives")
	 * @ORM\JoinTable(name = "relations_hebergement_hebergement_salle_corporative")
	 *
	 * @var ArrayCollection $hebergement_id
	 */
	private $hebergement_id;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_salle_corporative_fr
	 */
	private $texte_salle_corporative_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_salle_corporative_en
	 */
	private $texte_salle_corporative_en;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $texte_capacite_salle_corporative_fr
	 */
	private $texte_capacite_salle_corporative_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_capacite_salle_corporative_en
	 */
	private $texte_capacite_salle_corporative_en;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Corporatifs_services", mappedBy = "Hebergements_salles_corporatives")
	 *
	 * @var ArrayCollection $corporatifs_services_id
	 */
	private $corporatifs_services_id;
	
	public function __construct()
	{
		$this->hebergement_id = new ArrayCollection();
		$this->corporatifs_services_id = new ArrayCollection();
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
     * Set texte_salle_corporative_fr
     *
     * @param text $texteSalleCorporativeFr
     */
    public function setTexteSalleCorporativeFr($texteSalleCorporativeFr)
    {
        $this->texte_salle_corporative_fr = $texteSalleCorporativeFr;
    }

    /**
     * Get texte_salle_corporative_fr
     *
     * @return text 
     */
    public function getTexteSalleCorporativeFr()
    {
        return $this->texte_salle_corporative_fr;
    }

    /**
     * Set texte_salle_corporative_en
     *
     * @param text $texteSalleCorporativeEn
     */
    public function setTexteSalleCorporativeEn($texteSalleCorporativeEn)
    {
        $this->texte_salle_corporative_en = $texteSalleCorporativeEn;
    }

    /**
     * Get texte_salle_corporative_en
     *
     * @return text 
     */
    public function getTexteSalleCorporativeEn()
    {
        return $this->texte_salle_corporative_en;
    }

    /**
     * Set texte_capacite_salle_corporative_fr
     *
     * @param text $texteCapaciteSalleCorporativeFr
     */
    public function setTexteCapaciteSalleCorporativeFr($texteCapaciteSalleCorporativeFr)
    {
        $this->texte_capacite_salle_corporative_fr = $texteCapaciteSalleCorporativeFr;
    }

    /**
     * Get texte_capacite_salle_corporative_fr
     *
     * @return text 
     */
    public function getTexteCapaciteSalleCorporativeFr()
    {
        return $this->texte_capacite_salle_corporative_fr;
    }

    /**
     * Set texte_capacite_salle_corporative_en
     *
     * @param text $texteCapaciteSalleCorporativeEn
     */
    public function setTexteCapaciteSalleCorporativeEn($texteCapaciteSalleCorporativeEn)
    {
        $this->texte_capacite_salle_corporative_en = $texteCapaciteSalleCorporativeEn;
    }

    /**
     * Get texte_capacite_salle_corporative_en
     *
     * @return text 
     */
    public function getTexteCapaciteSalleCorporativeEn()
    {
        return $this->texte_capacite_salle_corporative_en;
    }

    /**
     * Add hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementId
     */
    public function addHebergements(\MyApp\GlobalBundle\Entity\Hebergements $hebergementId)
    {
        $this->hebergement_id[] = $hebergementId;
    }

    /**
     * Get hebergement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementId()
    {
        return $this->hebergement_id;
    }

    /**
     * Add corporatifs_services_id
     *
     * @param MyApp\GlobalBundle\Entity\Corporatifs_services $corporatifsServicesId
     */
    public function addCorporatifs_services(\MyApp\GlobalBundle\Entity\Corporatifs_services $corporatifsServicesId)
    {
        $this->corporatifs_services_id[] = $corporatifsServicesId;
    }

    /**
     * Get corporatifs_services_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCorporatifsServicesId()
    {
        return $this->corporatifs_services_id;
    }
}