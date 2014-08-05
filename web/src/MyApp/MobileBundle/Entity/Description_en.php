<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\MobileBundle\Entity\Galerie_hebergement;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\HebergementsRepository")
 * @ORM\Table(name = "description_en")
 * @ORM\HasLifecycleCallbacks
 */
class Description_en{
	
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
     * @var text $texte_generale_chambre_en
     */
    private $texte_generale_chambre_en;

    /**
     * @ORM\Column(type="text", nullable = "true")
     *
     * @var text $texte_direction_routiere_perso_en
     */
    private $texte_direction_routiere_perso_en;

    /**
     * @ORM\Column(type="text", nullable = "true")
     *
     * @var text $description_promotion_en
     */
    private $description_promotion_en;

    /**
     * @ORM\OneToMany(targetEntity="MyApp\MobileBundle\Entity\Hebergements", mappedBy="Description_en")
     */
    private $hebergement_description_en;

    public $politique;

    public function __construct()
    {
            $this->hebergement_description_en = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set texte_generale_chambre_en
     *
     * @param text $texteGeneraleChambreEn
     */
    public function setTexteGeneraleChambreEn($texteGeneraleChambreEn)
    {
        $this->texte_generale_chambre_en = htmlentities( $texteGeneraleChambreEn);
    }

    /**
     * Get texte_generale_chambre_en
     *
     * @return text 
     */
    public function getTexteGeneraleChambreEn()
    {
        return html_entity_decode( $this->texte_generale_chambre_en);
    }

    /**
     * Set texte_direction_routiere_perso_en
     *
     * @param text $texteDirectionRoutierePersoEn
     */
    public function setTexteDirectionRoutierePersoEn($texteDirectionRoutierePersoEn)
    {
        $this->texte_direction_routiere_perso_en = htmlentities( $texteDirectionRoutierePersoEn);
    }

    /**
     * Get texte_direction_routiere_perso_en
     *
     * @return text 
     */
    public function getTexteDirectionRoutierePersoEn()
    {
        return html_entity_decode( $this->texte_direction_routiere_perso_en );
    }
    
    /**
     * Add hebergement_description_en
     *
     * @param MyApp\MobileBundle\Entity\Hebergements $hebergementDescriptionEn
     */
    public function addHebergements(\MyApp\MobileBundle\Entity\Hebergements $hebergementDescriptionEn)
    {
        $this->hebergement_description_en[] = htmlentities( $hebergementDescriptionEn );
    }

    /**
     * Get hebergement_description_en
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementDescriptionEn()
    {
        return html_entity_decode( $this->hebergement_description_en);
    }

    /**
     * Set description_promotion_en
     *
     * @param text $descriptionPromotionEn
     */
    public function setDescriptionPromotionEn($descriptionPromotionEn)
    {
        $this->description_promotion_en = htmlentities( $descriptionPromotionEn);
    }

    /**
     * Get description_promotion_en
     *
     * @return text 
     */
    public function getDescriptionPromotionEn()
    {
        return html_entity_decode( $this->description_promotion_en );
    }
}