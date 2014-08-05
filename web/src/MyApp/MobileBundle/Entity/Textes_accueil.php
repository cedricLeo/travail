<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\Textes_accueilRepository")
 * @ORM\Table(name = "textes_accueil")
 */
class Textes_accueil {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 * 
	 * @var text $texte_accueil_fr
	 */
	private $texte_accueil_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_hebergement_fr
	 */
	private $texte_accueil_hebergement_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_forfait_fr
	 */
	private $texte_accueil_forfait_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_corporatif_fr
	 */
	private $texte_accueil_corporatif_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_sante_fr
	 */
	private $texte_accueil_sante_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_attrait_fr
	 */
	private $texte_accueil_attrait_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_promotion_fr
	 */
	private $texte_accueil_promotion_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_restaurant_fr
	 */
	private $texte_accueil_restaurant_fr;
		
        /**
	 * @ORM\ManyToOne(targetEntity="MyApp\MobileBundle\Entity\Texte_complementaire_section_principale", cascade={"persist"})
	 * 
	 * @var integer $texte_complementaire
	 */
	private $texte_complementaire;
        

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
     * Set texte_accueil_fr
     *
     * @param text $texteAccueilFr
     */
    public function setTexteAccueilFr($texteAccueilFr)
    {
        $this->texte_accueil_fr = htmlentities( $texteAccueilFr);
    }

    /**
     * Get texte_accueil_fr
     *
     * @return text 
     */
    public function getTexteAccueilFr()
    {
        return html_entity_decode( $this->texte_accueil_fr);
    }

    /**
     * Set texte_accueil_hebergement_fr
     *
     * @param text $texteAccueilHebergementFr
     */
    public function setTexteAccueilHebergementFr($texteAccueilHebergementFr)
    {
        $this->texte_accueil_hebergement_fr = htmlentities( $texteAccueilHebergementFr);
    }

    /**
     * Get texte_accueil_hebergement_fr
     *
     * @return text 
     */
    public function getTexteAccueilHebergementFr()
    {
        return html_entity_decode( $this->texte_accueil_hebergement_fr);
    }

    /**
     * Set texte_accueil_forfait_fr
     *
     * @param text $texteAccueilForfaitFr
     */
    public function setTexteAccueilForfaitFr($texteAccueilForfaitFr)
    {
        $this->texte_accueil_forfait_fr = htmlentities( $texteAccueilForfaitFr);
    }

    /**
     * Get texte_accueil_forfait_fr
     *
     * @return text 
     */
    public function getTexteAccueilForfaitFr()
    {
        return html_entity_decode( $this->texte_accueil_forfait_fr);
    }

    /**
     * Set texte_accueil_corporatif_fr
     *
     * @param text $texteAccueilCorporatifFr
     */
    public function setTexteAccueilCorporatifFr($texteAccueilCorporatifFr)
    {
        $this->texte_accueil_corporatif_fr = htmlentities( $texteAccueilCorporatifFr);
    }

    /**
     * Get texte_accueil_corporatif_fr
     *
     * @return text 
     */
    public function getTexteAccueilCorporatifFr()
    {
        return html_entity_decode( $this->texte_accueil_corporatif_fr);
    }

    /**
     * Set texte_accueil_sante_fr
     *
     * @param text $texteAccueilSanteFr
     */
    public function setTexteAccueilSanteFr($texteAccueilSanteFr)
    {
        $this->texte_accueil_sante_fr = htmlentities( $texteAccueilSanteFr);
    }

    /**
     * Get texte_accueil_sante_fr
     *
     * @return text 
     */
    public function getTexteAccueilSanteFr()
    {
        return html_entity_decode( $this->texte_accueil_sante_fr);
    }

    /**
     * Set texte_accueil_attrait_fr
     *
     * @param text $texteAccueilAttraitFr
     */
    public function setTexteAccueilAttraitFr($texteAccueilAttraitFr)
    {
        $this->texte_accueil_attrait_fr = htmlentities( $texteAccueilAttraitFr);
    }

    /**
     * Get texte_accueil_attrait_fr
     *
     * @return text 
     */
    public function getTexteAccueilAttraitFr()
    {
        return html_entity_decode( $this->texte_accueil_attrait_fr);
    }

    /**
     * Set texte_accueil_promotion_fr
     *
     * @param text $texteAccueilPromotionFr
     */
    public function setTexteAccueilPromotionFr($texteAccueilPromotionFr)
    {
        $this->texte_accueil_promotion_fr = htmlentities( $texteAccueilPromotionFr);
    }

    /**
     * Get texte_accueil_promotion_fr
     *
     * @return text 
     */
    public function getTexteAccueilPromotionFr()
    {
        return html_entity_decode( $this->texte_accueil_promotion_fr);
    }

    /**
     * Set texte_accueil_restaurant_fr
     *
     * @param text $texteAccueilRestaurantFr
     */
    public function setTexteAccueilRestaurantFr($texteAccueilRestaurantFr)
    {
        $this->texte_accueil_restaurant_fr = htmlentities( $texteAccueilRestaurantFr);
    }

    /**
     * Get texte_accueil_restaurant_fr
     *
     * @return text 
     */
    public function getTexteAccueilRestaurantFr()
    {
        return html_entity_decode( $this->texte_accueil_restaurant_fr);
    }

    /**
     * Set texte_complementaire
     *
     * @param MyApp\MobileBundle\Entity\Texte_complementaire_section_principale $texteComplementaire
     */
    public function setTexteComplementaire(\MyApp\MobileBundle\Entity\Texte_complementaire_section_principale $texteComplementaire)
    {
        $this->texte_complementaire = $texteComplementaire;
    }

    /**
     * Get texte_complementaire
     *
     * @return MyApp\MobileBundle\Entity\Texte_complementaire_section_principale 
     */
    public function getTexteComplementaire()
    {
        return $this->texte_complementaire;
    }
}