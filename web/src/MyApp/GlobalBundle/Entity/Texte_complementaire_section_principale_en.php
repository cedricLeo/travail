<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "texte_complementaire_section_principale_en")
 */
class Texte_complementaire_section_principale_en {
    
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
	 * @var text $texte_accueil_meta_description_en
	 */
	private $texte_accueil_meta_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_hebergement_meta_en
	 */
	private $texte_accueil_hebergement_meta_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_forfait_meta_en
	 */
	private $texte_accueil_forfait_meta_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_corporatif_meta_en
	 */
	private $texte_accueil_corporatif_meta_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_sante_meta_en
	 */
	private $texte_accueil_sante_meta_en; 
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_attrait_meta_en
	 */
	private $texte_accueil_attrait_meta_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_promotion_meta_en
	 */
	private $texte_accueil_promotion_meta_en;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_restaurant_meta_en
	 */
	private $texte_accueil_restaurant_meta_en;
        
             /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_accueil_en
	 */
	private $titre_accueil_en;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_hebergement_en
	 */
	private $titre_hebergement_en;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_forfait_en
	 */
	private $titre_forfait_en;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_corporatif_en
	 */
	private $titre_corporatif_en;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_promotion_en
	 */
	private $titre_promotion_en;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_sante_en
	 */
	private $titre_sante_en;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_sattrait_en
	 */
	private $titre_attrait_en;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_restaurant_en
	 */
	private $titre_restaurant_en;

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
     * Set texte_accueil_meta_en
     *
     * @param text $texteAccueilMetaEn
     */
    public function setTexteAccueilMetaEn($texteAccueilMetaEn)
    {
        $this->texte_accueil_meta_en = $texteAccueilMetaEn;
    }

    /**
     * Get texte_accueil_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilMetaEn()
    {
        return $this->texte_accueil_meta_en;
    }

    /**
     * Set texte_accueil_hebergement_meta_en
     *
     * @param text $texteAccueilHebergementMetaEn
     */
    public function setTexteAccueilHebergementMetaEn($texteAccueilHebergementMetaEn)
    {
        $this->texte_accueil_hebergement_meta_en = $texteAccueilHebergementMetaEn;
    }

    /**
     * Get texte_accueil_hebergement_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilHebergementMetaEn()
    {
        return $this->texte_accueil_hebergement_meta_en;
    }

    /**
     * Set texte_accueil_forfait_meta_en
     *
     * @param text $texteAccueilForfaitMetaEn
     */
    public function setTexteAccueilForfaitMetaEn($texteAccueilForfaitMetaEn)
    {
        $this->texte_accueil_forfait_meta_en = $texteAccueilForfaitMetaEn;
    }

    /**
     * Get texte_accueil_forfait_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilForfaitMetaEn()
    {
        return $this->texte_accueil_forfait_meta_en;
    }

    /**
     * Set texte_accueil_corporatif_meta_en
     *
     * @param text $texteAccueilCorporatifMetaEn
     */
    public function setTexteAccueilCorporatifMetaEn($texteAccueilCorporatifMetaEn)
    {
        $this->texte_accueil_corporatif_meta_en = $texteAccueilCorporatifMetaEn;
    }

    /**
     * Get texte_accueil_corporatif_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilCorporatifMetaEn()
    {
        return $this->texte_accueil_corporatif_meta_en;
    }

    /**
     * Set texte_accueil_sante_meta_en
     *
     * @param text $texteAccueilSanteMetaEn
     */
    public function setTexteAccueilSanteMetaEn($texteAccueilSanteMetaEn)
    {
        $this->texte_accueil_sante_meta_en = $texteAccueilSanteMetaEn;
    }

    /**
     * Get texte_accueil_sante_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilSanteMetaEn()
    {
        return $this->texte_accueil_sante_meta_en;
    }

    /**
     * Set texte_accueil_attrait_meta_en
     *
     * @param text $texteAccueilAttraitMetaEn
     */
    public function setTexteAccueilAttraitMetaEn($texteAccueilAttraitMetaEn)
    {
        $this->texte_accueil_attrait_meta_en = $texteAccueilAttraitMetaEn;
    }

    /**
     * Get texte_accueil_attrait_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilAttraitMetaEn()
    {
        return $this->texte_accueil_attrait_meta_en;
    }

    /**
     * Set texte_accueil_promotion_meta_en
     *
     * @param text $texteAccueilPromotionMetaEn
     */
    public function setTexteAccueilPromotionMetaEn($texteAccueilPromotionMetaEn)
    {
        $this->texte_accueil_promotion_meta_en = $texteAccueilPromotionMetaEn;
    }

    /**
     * Get texte_accueil_promotion_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilPromotionMetaEn()
    {
        return $this->texte_accueil_promotion_meta_en;
    }

    /**
     * Set texte_accueil_restaurant_meta_en
     *
     * @param text $texteAccueilRestaurantMetaEn
     */
    public function setTexteAccueilRestaurantMetaEn($texteAccueilRestaurantMetaEn)
    {
        $this->texte_accueil_restaurant_meta_en = $texteAccueilRestaurantMetaEn;
    }

    /**
     * Get texte_accueil_restaurant_meta_en
     *
     * @return text 
     */
    public function getTexteAccueilRestaurantMetaEn()
    {
        return $this->texte_accueil_restaurant_meta_en;
    }

    /**
     * Set titre_accueil_en
     *
     * @param string $titreAccueilEn
     */
    public function setTitreAccueilEn($titreAccueilEn)
    {
        $this->titre_accueil_en = $titreAccueilEn;
    }

    /**
     * Get titre_accueil_en
     *
     * @return string 
     */
    public function getTitreAccueilEn()
    {
        return $this->titre_accueil_en;
    }

    /**
     * Set titre_hebergement_en
     *
     * @param string $titreHebergementEn
     */
    public function setTitreHebergementEn($titreHebergementEn)
    {
        $this->titre_hebergement_en = $titreHebergementEn;
    }

    /**
     * Get titre_hebergement_en
     *
     * @return string 
     */
    public function getTitreHebergementEn()
    {
        return $this->titre_hebergement_en;
    }

    /**
     * Set titre_forfait_en
     *
     * @param string $titreForfaitEn
     */
    public function setTitreForfaitEn($titreForfaitEn)
    {
        $this->titre_forfait_en = $titreForfaitEn;
    }

    /**
     * Get titre_forfait_en
     *
     * @return string 
     */
    public function getTitreForfaitEn()
    {
        return $this->titre_forfait_en;
    }

    /**
     * Set titre_corporatif_en
     *
     * @param string $titreCorporatifEn
     */
    public function setTitreCorporatifEn($titreCorporatifEn)
    {
        $this->titre_corporatif_en = $titreCorporatifEn;
    }

    /**
     * Get titre_corporatif_en
     *
     * @return string 
     */
    public function getTitreCorporatifEn()
    {
        return $this->titre_corporatif_en;
    }

    /**
     * Set titre_promotion_en
     *
     * @param string $titrePromotionEn
     */
    public function setTitrePromotionEn($titrePromotionEn)
    {
        $this->titre_promotion_en = $titrePromotionEn;
    }

    /**
     * Get titre_promotion_en
     *
     * @return string 
     */
    public function getTitrePromotionEn()
    {
        return $this->titre_promotion_en;
    }

    /**
     * Set titre_sante_en
     *
     * @param string $titreSanteEn
     */
    public function setTitreSanteEn($titreSanteEn)
    {
        $this->titre_sante_en = $titreSanteEn;
    }

    /**
     * Get titre_sante_en
     *
     * @return string 
     */
    public function getTitreSanteEn()
    {
        return $this->titre_sante_en;
    }

    /**
     * Set titre_attrait_en
     *
     * @param string $titreAttraitEn
     */
    public function setTitreAttraitEn($titreAttraitEn)
    {
        $this->titre_attrait_en = $titreAttraitEn;
    }

    /**
     * Get titre_attrait_en
     *
     * @return string 
     */
    public function getTitreAttraitEn()
    {
        return $this->titre_attrait_en;
    }

    /**
     * Set titre_restaurant_en
     *
     * @param string $titreRestaurantEn
     */
    public function setTitreRestaurantEn($titreRestaurantEn)
    {
        $this->titre_restaurant_en = $titreRestaurantEn;
    }

    /**
     * Get titre_restaurant_en
     *
     * @return string 
     */
    public function getTitreRestaurantEn()
    {
        return $this->titre_restaurant_en;
    }
}