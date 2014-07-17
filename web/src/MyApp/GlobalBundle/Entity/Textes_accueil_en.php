<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Textes_accueilRepository")
 * @ORM\Table(name = "textes_accueil_en")
 */
class Textes_accueil_en {
	
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
	 * @var text $texte_accueil_en
	 */
	private $texte_accueil_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_meta_description_en
	 */
	private $texte_accueil_meta_description_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_hebergement_en
	 */
	private $texte_accueil_hebergement_en;
        
        	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_hebergement_meta_en
	 */
	private $texte_accueil_hebergement_meta_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_forfait_en
	 */
	private $texte_accueil_forfait_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_forfait_meta_en
	 */
	private $texte_accueil_forfait_meta_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_corporatif_en
	 */
	private $texte_accueil_corporatif_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_corporatif_meta_en
	 */
	private $texte_accueil_corporatif_meta_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_sante_en
	 */
	private $texte_accueil_sante_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_sante_meta_en
	 */
	private $texte_accueil_sante_meta_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_attrait_en
	 */
	private $texte_accueil_attrait_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_attrait_meta_en
	 */
	private $texte_accueil_attrait_meta_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_promotion_en
	 */
	private $texte_accueil_promotion_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_promotion_meta_en
	 */
	private $texte_accueil_promotion_meta_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_restaurant_en
	 */
	private $texte_accueil_restaurant_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_restaurant_meta_en
	 */
	private $texte_accueil_restaurant_meta_en;
	
        /**
	 * @ORM\ManyToOne(targetEntity="MyApp\GlobalBundle\Entity\Texte_complementaire_section_principale_en", cascade={"persist"})
	 * 
	 * @var integer $texte_complementaire_en
	 */
	private $texte_complementaire_en;
        

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
     * Set texte_accueil_en
     *
     * @param text $texteAccueilEn
     */
    public function setTexteAccueilEn($texteAccueilEn)
    {
        $this->texte_accueil_en = htmlentities( $texteAccueilEn);
    }

    /**
     * Get texte_accueil_en
     *
     * @return text 
     */
    public function getTexteAccueilEn()
    {
        return html_entity_decode( $this->texte_accueil_en);
    }

    /**
     * Set texte_accueil_meta_description_en
     *
     * @param text $texteAccueilMetaDescriptionEn
     */
    public function setTexteAccueilMetaDescriptionEn($texteAccueilMetaDescriptionEn)
    {
        $this->texte_accueil_meta_description_en = htmlentities( $texteAccueilMetaDescriptionEn);
    }

    /**
     * Get texte_accueil_meta_description_en
     *
     * @return text 
     */
    public function getTexteAccueilMetaDescriptionEn()
    {
        return html_entity_decode( $this->texte_accueil_meta_description_en);
    }

    /**
     * Set texte_accueil_hebergement_en
     *
     * @param text $texteAccueilHebergementEn
     */
    public function setTexteAccueilHebergementEn($texteAccueilHebergementEn)
    {
        $this->texte_accueil_hebergement_en = htmlentities( $texteAccueilHebergementEn);
    }

    /**
     * Get texte_accueil_hebergement_en
     *
     * @return text 
     */
    public function getTexteAccueilHebergementEn()
    {
        return html_entity_decode( $this->texte_accueil_hebergement_en);
    }

    /**
     * Set texte_accueil_hebergement_meta_en
     *
     * @param text $texteAccueilHebergementMetaEn
     */
    public function setTexteAccueilHebergementMetaEn($texteAccueilHebergementMetaEn)
    {
        $this->texte_accueil_hebergement_meta_en = htmlentities( $texteAccueilHebergementMetaEn);
    }

    /**
     * Get texte_accueil_hebergement_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilHebergementMetaEn()
    {
        return html_entity_decode( $this->texte_accueil_hebergement_meta_en);
    }

    /**
     * Set texte_accueil_forfait_en
     *
     * @param text $texteAccueilForfaitEn
     */
    public function setTexteAccueilForfaitEn($texteAccueilForfaitEn)
    {
        $this->texte_accueil_forfait_en = htmlentities( $texteAccueilForfaitEn);
    }

    /**
     * Get texte_accueil_forfait_en
     *
     * @return text 
     */
    public function getTexteAccueilForfaitEn()
    {
        return html_entity_decode( $this->texte_accueil_forfait_en);
    }

    /**
     * Set texte_accueil_forfait_meta_en
     *
     * @param text $texteAccueilForfaitMetaEn
     */
    public function setTexteAccueilForfaitMetaEn($texteAccueilForfaitMetaEn)
    {
        $this->texte_accueil_forfait_meta_en = htmlentities( $texteAccueilForfaitMetaEn);
    }

    /**
     * Get texte_accueil_forfait_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilForfaitMetaEn()
    {
        return html_entity_decode( $this->texte_accueil_forfait_meta_en);
    }

    /**
     * Set texte_accueil_corporatif_en
     *
     * @param text $texteAccueilCorporatifEn
     */
    public function setTexteAccueilCorporatifEn($texteAccueilCorporatifEn)
    {
        $this->texte_accueil_corporatif_en = htmlentities( $texteAccueilCorporatifEn);
    }

    /**
     * Get texte_accueil_corporatif_en
     *
     * @return text 
     */
    public function getTexteAccueilCorporatifEn()
    {
        return html_entity_decode( $this->texte_accueil_corporatif_en);
    }

    /**
     * Set texte_accueil_corporatif_meta_en
     *
     * @param text $texteAccueilCorporatifMetaEn
     */
    public function setTexteAccueilCorporatifMetaEn($texteAccueilCorporatifMetaEn)
    {
        $this->texte_accueil_corporatif_meta_en = htmlentities( $texteAccueilCorporatifMetaEn);
    }

    /**
     * Get texte_accueil_corporatif_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilCorporatifMetaEn()
    {
        return html_entity_decode( $this->texte_accueil_corporatif_meta_en);
    }

    /**
     * Set texte_accueil_sante_en
     *
     * @param text $texteAccueilSanteEn
     */
    public function setTexteAccueilSanteEn($texteAccueilSanteEn)
    {
        $this->texte_accueil_sante_en = htmlentities( $texteAccueilSanteEn);
    }

    /**
     * Get texte_accueil_sante_en
     *
     * @return text 
     */
    public function getTexteAccueilSanteEn()
    {
        return html_entity_decode( $this->texte_accueil_sante_en);
    }

    /**
     * Set texte_accueil_sante_meta_en
     *
     * @param text $texteAccueilSanteMetaEn
     */
    public function setTexteAccueilSanteMetaEn($texteAccueilSanteMetaEn)
    {
        $this->texte_accueil_sante_meta_en = htmlentities( $texteAccueilSanteMetaEn);
    }

    /**
     * Get texte_accueil_sante_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilSanteMetaEn()
    {
        return html_entity_decode( $this->texte_accueil_sante_meta_en);
    }

    /**
     * Set texte_accueil_attrait_en
     *
     * @param text $texteAccueilAttraitEn
     */
    public function setTexteAccueilAttraitEn($texteAccueilAttraitEn)
    {
        $this->texte_accueil_attrait_en = htmlentities( $texteAccueilAttraitEn);
    }

    /**
     * Get texte_accueil_attrait_en
     *
     * @return text 
     */
    public function getTexteAccueilAttraitEn()
    {
        return html_entity_decode( $this->texte_accueil_attrait_en);
    }

    /**
     * Set texte_accueil_attrait_meta_en
     *
     * @param text $texteAccueilAttraitMetaEn
     */
    public function setTexteAccueilAttraitMetaEn($texteAccueilAttraitMetaEn)
    {
        $this->texte_accueil_attrait_meta_en = htmlentities( $texteAccueilAttraitMetaEn);
    }

    /**
     * Get texte_accueil_attrait_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilAttraitMetaEn()
    {
        return html_entity_decode( $this->texte_accueil_attrait_meta_en);
    }

    /**
     * Set texte_accueil_promotion_en
     *
     * @param text $texteAccueilPromotionEn
     */
    public function setTexteAccueilPromotionEn($texteAccueilPromotionEn)
    {
        $this->texte_accueil_promotion_en = htmlentities( $texteAccueilPromotionEn);
    }

    /**
     * Get texte_accueil_promotion_en
     *
     * @return text 
     */
    public function getTexteAccueilPromotionEn()
    {
        return html_entity_decode( $this->texte_accueil_promotion_en);
    }

    /**
     * Set texte_accueil_promotion_meta_en
     *
     * @param text $texteAccueilPromotionMetaEn
     */
    public function setTexteAccueilPromotionMetaEn($texteAccueilPromotionMetaEn)
    {
        $this->texte_accueil_promotion_meta_en = htmlentities( $texteAccueilPromotionMetaEn);
    }

    /**
     * Get texte_accueil_promotion_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilPromotionMetaEn()
    {
        return html_entity_decode( $this->texte_accueil_promotion_meta_en);
    }

    /**
     * Set texte_accueil_restaurant_en
     *
     * @param text $texteAccueilRestaurantEn
     */
    public function setTexteAccueilRestaurantEn($texteAccueilRestaurantEn)
    {
        $this->texte_accueil_restaurant_en = htmlentities( $texteAccueilRestaurantEn);
    }

    /**
     * Get texte_accueil_restaurant_en
     *
     * @return text 
     */
    public function getTexteAccueilRestaurantEn()
    {
        return html_entity_decode( $this->texte_accueil_restaurant_en);
    }

    /**
     * Set texte_accueil_restaurant_meta_en
     *
     * @param text $texteAccueilRestaurantMetaEn
     */
    public function setTexteAccueilRestaurantMetaEn($texteAccueilRestaurantMetaEn)
    {
        $this->texte_accueil_restaurant_meta_en = htmlentities( $texteAccueilRestaurantMetaEn);
    }

    /**
     * Get texte_accueil_restaurant_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilRestaurantMetaEn()
    {
        return html_entity_decode( $this->texte_accueil_restaurant_meta_en);
    }

    /**
     * Set texte_complementaire_en
     *
     * @param MyApp\GlobalBundle\Entity\Texte_complementaire_section_principale_en $texteComplementaireEn
     */
    public function setTexteComplementaireEn(\MyApp\GlobalBundle\Entity\Texte_complementaire_section_principale_en $texteComplementaireEn)
    {
        $this->texte_complementaire_en = $texteComplementaireEn;
    }

    /**
     * Get texte_complementaire_en
     *
     * @return MyApp\GlobalBundle\Entity\Texte_complementaire_section_principale_en 
     */
    public function getTexteComplementaireEn()
    {
        return $this->texte_complementaire_en;
    }
}