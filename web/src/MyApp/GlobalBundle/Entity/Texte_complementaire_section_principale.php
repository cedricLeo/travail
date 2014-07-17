<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "texte_complementaire_section_principale")
 */
class Texte_complementaire_section_principale {
    
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
	 * @var text $texte_accueil_meta_description_fr
	 */
	private $texte_accueil_meta_fr;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_hebergement_meta_fr
	 */
	private $texte_accueil_hebergement_meta_fr;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_forfait_meta_fr
	 */
	private $texte_accueil_forfait_meta_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_corporatif_meta_fr
	 */
	private $texte_accueil_corporatif_meta_fr;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_sante_meta_fr
	 */
	private $texte_accueil_sante_meta_fr; 
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_attrait_meta_fr
	 */
	private $texte_accueil_attrait_meta_fr;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_promotion_meta_fr
	 */
	private $texte_accueil_promotion_meta_fr;
        
        /**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_accueil_restaurant_meta_fr
	 */
	private $texte_accueil_restaurant_meta_fr;
        
       /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_accueil_fr
	 */
	private $titre_accueil_fr;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_hebergement_fr
	 */
	private $titre_hebergement_fr;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_forfait_fr
	 */
	private $titre_forfait_fr;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_corporatif_fr
	 */
	private $titre_corporatif_fr;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_promotion_fr
	 */
	private $titre_promotion_fr;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_sante_fr
	 */
	private $titre_sante_fr;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_sattrait_fr
	 */
	private $titre_attrait_fr;
        
        /**
	 * @ORM\Column(type="string",  nullable = "true")
	 *
	 * @var string $titre_restaurant_fr
	 */
	private $titre_restaurant_fr;

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
     * Set texte_accueil_meta_fr
     *
     * @param text $texteAccueilMetaFr
     */
    public function setTexteAccueilMetaFr($texteAccueilMetaFr)
    {
        $this->texte_accueil_meta_fr = $texteAccueilMetaFr;
    }

    /**
     * Get texte_accueil_meta_fr
     *
     * @return text 
     */
    public function getTexteAccueilMetaFr()
    {
        return $this->texte_accueil_meta_fr;
    }

    /**
     * Set texte_accueil_hebergement_meta_fr
     *
     * @param text $texteAccueilHebergementMetaFr
     */
    public function setTexteAccueilHebergementMetaFr($texteAccueilHebergementMetaFr)
    {
        $this->texte_accueil_hebergement_meta_fr = $texteAccueilHebergementMetaFr;
    }

    /**
     * Get texte_accueil_hebergement_meta_fr
     *
     * @return text 
     */
    public function getTexteAccueilHebergementMetaFr()
    {
        return $this->texte_accueil_hebergement_meta_fr;
    }

    /**
     * Set texte_accueil_forfait_meta_fr
     *
     * @param text $texteAccueilForfaitMetaFr
     */
    public function setTexteAccueilForfaitMetaFr($texteAccueilForfaitMetaFr)
    {
        $this->texte_accueil_forfait_meta_fr = $texteAccueilForfaitMetaFr;
    }

    /**
     * Get texte_accueil_forfait_meta_fr
     *
     * @return text 
     */
    public function getTexteAccueilForfaitMetaFr()
    {
        return $this->texte_accueil_forfait_meta_fr;
    }

    /**
     * Set texte_accueil_corporatif_meta_fr
     *
     * @param text $texteAccueilCorporatifMetaFr
     */
    public function setTexteAccueilCorporatifMetaFr($texteAccueilCorporatifMetaFr)
    {
        $this->texte_accueil_corporatif_meta_fr = $texteAccueilCorporatifMetaFr;
    }

    /**
     * Get texte_accueil_corporatif_meta_fr
     *
     * @return text 
     */
    public function getTexteAccueilCorporatifMetaFr()
    {
        return $this->texte_accueil_corporatif_meta_fr;
    }

    /**
     * Set texte_accueil_sante_meta_fr
     *
     * @param text $texteAccueilSanteMetaFr
     */
    public function setTexteAccueilSanteMetaFr($texteAccueilSanteMetaFr)
    {
        $this->texte_accueil_sante_meta_fr = $texteAccueilSanteMetaFr;
    }

    /**
     * Get texte_accueil_sante_meta_fr
     *
     * @return text 
     */
    public function getTexteAccueilSanteMetaFr()
    {
        return $this->texte_accueil_sante_meta_fr;
    }

    /**
     * Set texte_accueil_attrait_meta_fr
     *
     * @param text $texteAccueilAttraitMetaFr
     */
    public function setTexteAccueilAttraitMetaFr($texteAccueilAttraitMetaFr)
    {
        $this->texte_accueil_attrait_meta_fr = $texteAccueilAttraitMetaFr;
    }

    /**
     * Get texte_accueil_attrait_meta_fr
     *
     * @return text 
     */
    public function getTexteAccueilAttraitMetaFr()
    {
        return $this->texte_accueil_attrait_meta_fr;
    }

    /**
     * Set texte_accueil_promotion_meta_fr
     *
     * @param text $texteAccueilPromotionMetaFr
     */
    public function setTexteAccueilPromotionMetaFr($texteAccueilPromotionMetaFr)
    {
        $this->texte_accueil_promotion_meta_fr = $texteAccueilPromotionMetaFr;
    }

    /**
     * Get texte_accueil_promotion_meta_fr
     *
     * @return text 
     */
    public function getTexteAccueilPromotionMetaFr()
    {
        return $this->texte_accueil_promotion_meta_fr;
    }

    /**
     * Set texte_accueil_restaurant_meta_fr
     *
     * @param text $texteAccueilRestaurantMetaFr
     */
    public function setTexteAccueilRestaurantMetaFr($texteAccueilRestaurantMetaFr)
    {
        $this->texte_accueil_restaurant_meta_fr = $texteAccueilRestaurantMetaFr;
    }

    /**
     * Get texte_accueil_restaurant_meta_fr
     *
     * @return text 
     */
    public function getTexteAccueilRestaurantMetaFr()
    {
        return $this->texte_accueil_restaurant_meta_fr;
    }

    /**
     * Set titre_accueil_fr
     *
     * @param string $titreAccueilFr
     */
    public function setTitreAccueilFr($titreAccueilFr)
    {
        $this->titre_accueil_fr = $titreAccueilFr;
    }

    /**
     * Get titre_accueil_fr
     *
     * @return string 
     */
    public function getTitreAccueilFr()
    {
        return $this->titre_accueil_fr;
    }

    /**
     * Set titre_hebergement_fr
     *
     * @param string $titreHebergementFr
     */
    public function setTitreHebergementFr($titreHebergementFr)
    {
        $this->titre_hebergement_fr = $titreHebergementFr;
    }

    /**
     * Get titre_hebergement_fr
     *
     * @return string 
     */
    public function getTitreHebergementFr()
    {
        return $this->titre_hebergement_fr;
    }

    /**
     * Set titre_forfait_fr
     *
     * @param string $titreForfaitFr
     */
    public function setTitreForfaitFr($titreForfaitFr)
    {
        $this->titre_forfait_fr = $titreForfaitFr;
    }

    /**
     * Get titre_forfait_fr
     *
     * @return string 
     */
    public function getTitreForfaitFr()
    {
        return $this->titre_forfait_fr;
    }

    /**
     * Set titre_corporatif_fr
     *
     * @param string $titreCorporatifFr
     */
    public function setTitreCorporatifFr($titreCorporatifFr)
    {
        $this->titre_corporatif_fr = $titreCorporatifFr;
    }

    /**
     * Get titre_corporatif_fr
     *
     * @return string 
     */
    public function getTitreCorporatifFr()
    {
        return $this->titre_corporatif_fr;
    }

    /**
     * Set titre_promotion_fr
     *
     * @param string $titrePromotionFr
     */
    public function setTitrePromotionFr($titrePromotionFr)
    {
        $this->titre_promotion_fr = $titrePromotionFr;
    }

    /**
     * Get titre_promotion_fr
     *
     * @return string 
     */
    public function getTitrePromotionFr()
    {
        return $this->titre_promotion_fr;
    }

    /**
     * Set titre_sante_fr
     *
     * @param string $titreSanteFr
     */
    public function setTitreSanteFr($titreSanteFr)
    {
        $this->titre_sante_fr = $titreSanteFr;
    }

    /**
     * Get titre_sante_fr
     *
     * @return string 
     */
    public function getTitreSanteFr()
    {
        return $this->titre_sante_fr;
    }

    /**
     * Set titre_attrait_fr
     *
     * @param string $titreAttraitFr
     */
    public function setTitreAttraitFr($titreAttraitFr)
    {
        $this->titre_attrait_fr = $titreAttraitFr;
    }

    /**
     * Get titre_attrait_fr
     *
     * @return string 
     */
    public function getTitreAttraitFr()
    {
        return $this->titre_attrait_fr;
    }

    /**
     * Set titre_restaurant_fr
     *
     * @param string $titreRestaurantFr
     */
    public function setTitreRestaurantFr($titreRestaurantFr)
    {
        $this->titre_restaurant_fr = $titreRestaurantFr;
    }

    /**
     * Get titre_restaurant_fr
     *
     * @return string 
     */
    public function getTitreRestaurantFr()
    {
        return $this->titre_restaurant_fr;
    }
}