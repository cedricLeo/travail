<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\GlobalBundle\Entity\Galerie_hebergement;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\HebergementsRepository")
 * @ORM\Table(name = "description_fr")
 * @ORM\HasLifecycleCallbacks
 */
class Description_fr{
	
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable = "true")
     *
     * @var text $texte_generale_chambre_fr
     */
    private $texte_generale_chambre_fr;

    /**
     * @ORM\Column(type="text", nullable = "true")
     *
     * @var text $texte_direction_routiere_perso_fr
     */
    private $texte_direction_routiere_perso_fr;

    /**
     * @ORM\Column(type="text", nullable = "true")
     *
     * @var text $description_promotion_fr
     */
    private $description_promotion_fr;

    /**
     * @ORM\OneToMany(targetEntity="MyApp\GlobalBundle\Entity\Hebergements", mappedBy="Description_fr")
     */
    private $hebergement_description_fr;

    public $politique;

    public function __construct()
    {
            $this->hebergement_description_fr = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set texte_generale_chambre_fr
     *
     * @param text $texteGeneraleChambreFr
     */
    public function setTexteGeneraleChambreFr($texteGeneraleChambreFr)
    {
        $this->texte_generale_chambre_fr = htmlentities( $texteGeneraleChambreFr);
    }

    /**
     * Get texte_generale_chambre_fr
     *
     * @return text 
     */
    public function getTexteGeneraleChambreFr()
    {
        return html_entity_decode( $this->texte_generale_chambre_fr);
    }

    /**
     * Set texte_direction_routiere_perso_fr
     *
     * @param text $texteDirectionRoutierePersoFr
     */
    public function setTexteDirectionRoutierePersoFr($texteDirectionRoutierePersoFr)
    {
        $this->texte_direction_routiere_perso_fr = htmlentities( $texteDirectionRoutierePersoFr);
    }

    /**
     * Get texte_direction_routiere_perso_fr
     *
     * @return text 
     */
    public function getTexteDirectionRoutierePersoFr()
    {
        return html_entity_decode($this->texte_direction_routiere_perso_fr);
    }
    
    /**
     * Add hebergement_description_fr
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementDescriptionFr
     */
    public function addHebergements(\MyApp\GlobalBundle\Entity\Hebergements $hebergementDescriptionFr)
    {
        $this->hebergement_description_fr[] = htmlentities($hebergementDescriptionFr);
    }

    /**
     * Get hebergement_description_fr
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementDescriptionFr()
    {
        return html_entity_decode($this->hebergement_description_fr);
    }

    /**
     * Set description_promotion_fr
     *
     * @param text $descriptionPromotionFr
     */
    public function setDescriptionPromotionFr($descriptionPromotionFr)
    {
        $this->description_promotion_fr = htmlentities($descriptionPromotionFr);
    }

    /**
     * Get description_promotion_fr
     *
     * @return text 
     */
    public function getDescriptionPromotionFr()
    {
        return html_entity_decode($this->description_promotion_fr);
    }
}