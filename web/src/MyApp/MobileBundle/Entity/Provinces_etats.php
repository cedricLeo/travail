<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Cache\ArrayCache;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\Provinces_etatsRepository")
 * @ORM\Table(name = "provinces_etats", indexes={@ORM\index(name="provinces_etats_idx", columns={"id", "pays_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class Provinces_etats
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer", nullable="false")
     * @ORM\GeneratedValue(strategy = "AUTO")
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
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     *  
     * @var string $titre_fr_travel_attraits
     */
    private $titre_fr_travel_attraits;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     * 
     * @var string $titre_en_travel_attraits
     */
    private $titre_en_travel_attraits;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_fr_travel_attraits
     */
    private $texte_fr_travel_attraits;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_en_travel_attraits
     */
    private $texte_en_travel_attraits;
    
    /**
     * @ORM\Column(type = "string", nullable = true)
     * 
     * @var string $page_titre_fr
     */
    private $page_titre_fr;
    
    /**
     * @ORM\Column(type = "string", nullable = true)
     * 
     * @var string $page_titre_en
     */
    private $page_titre_en;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * 
     * @var string $page_metakeyword_fr
     */
    private $page_metakeyword_fr;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * 
     * @var string $page_metakeyword_en
     */
    private $page_metakeyword_en;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $page_metadescription_fr
     */
    private $page_metadescription_fr;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $page_metadescription_en
     */
    private $page_metadescription_en;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_accueil_fr
     */
    private $texte_accueil_fr;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_accueil_en
     */
    private $texte_accueil_en;
    
   /**
    * @ORM\Column(type = "string", nullable = true)
    *
    * @var string $repertoire_fr
    */
   private $repertoire_fr;

   /**
    * @ORM\Column(type = "string", nullable = true)
    *
    * @var string $repertoire_en
    */
   private $repertoire_en;

    /**
     * @ORM\Column(type = "string", length = 255, nullable ="true")
     *  
     * @var string $image
     */
    private $image;

    /**
     * @ORM\Column(type = "string", length = 255, nullable ="true")
     * 
     * @var string $image_doctrine
     */
    private $image_doctrine;

    /**
     * @ORM\Column(type = "integer")
     * 
     * @var integer $reservit_id
     */
    private $reservit_id;
    
    /**
     * @ORM\Column(type = "boolean")
     *
     * @var boolean $affiche
     */
    private $affiche;
    
    /**
     * @ORM\OneToMany(targetEntity="Appel_Offre", mappedBy="Provinces_etats")
     *
     * @var integer $appel_offre
     */
    private $appel_offre;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_province_categorie", mappedBy="Provinces_etats", cascade={"remove"})
     *
     * @var integer $texte_province_categorie
     */
    private $texte_province_categorie;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_province_corporatif", mappedBy="Provinces_etats", cascade={"remove"})
     *
     * @var integer $texte_province_corporatif
     */
    private $texte_province_corporatif;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_province_appel_offre", mappedBy="Provinces_etats", cascade={"remove"})
     *
     * @var integer $texte_province_appel_offre
     */
    private $texte_province_appel_offre;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_province_location_salle", mappedBy="Provinces_etats", cascade={"remove"})
     *
     * @var integer $texte_province_location_salle
     */
    private $texte_province_location_salle;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_province_activite_corporative", mappedBy="Provinces_etats", cascade={"remove"})
     *
     * @var integer $texte_province_activite_corporative
     */
    private $texte_province_activite_corporative;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_province_chambre_affaire", mappedBy="Provinces_etats", cascade={"remove"})
     *
     * @var integer $texte_province_chambre_affaire
     */
    private $texte_province_chambre_affaire;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_province_forfait_affaire", mappedBy="Provinces_etats", cascade={"remove"})
     *
     * @var integer $texte_province_forfait_affaire
     */
    private $texte_province_forfait_affaire;

    /**
     * @ORM\ManyToOne(targetEntity="Pays", inversedBy="Provinces_etats")
     * @ORM\JoinColumn(name="pays_id", referencedColumnName="id", onDelete="CASCADE")
     * 
     * @var integer $pays_id
     */
    private $pays_id;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_province_forfait", mappedBy="Provinces_etats", cascade={"remove"})
     * 
     * @var integer $texte_province_forfait
     */
    private $texte_province_forfait;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_province_sante", mappedBy="Provinces_etats", cascade={"remove"})
     * 
     * @var integer $texte_province_sante
     */
    private $texte_province_sante;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_province_restaurant", mappedBy="Provinces_etats", cascade={"remove"})
     * 
     * @var integer $texte_province_restaurant
     */
    private $texte_province_restaurant;
    
    /**
     * @ORM\OneToMany(targetEntity = "Attraits", mappedBy = "Provinces_etats", fetch="EXTRA_LAZY")
     *
     * @var integer $attraits_id
     */
     private $attraits_id;
    
    /**
     * @ORM\OneToMany(targetEntity = "Hebergements", mappedBy = "Provinces_etats", fetch="EXTRA_LAZY")
     *
     * @var integer $hebergement_id
     */
     private $hebergement_id;
     
     /**
      * @ORM\OneToMany(targetEntity = "Regions", mappedBy = "Provinces_etats", fetch="EXTRA_LAZY")
      *
      * @var integer $region_id
      */
     private $region_id;
     
     
    public function getFullPicturePath() {
            return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
    }

    protected function getUploadRootDir() {
            // the absolute directory path where uploaded documents should be saved
            return $this->getTmpUploadRootDir().$this->getId()."/";
    }

    protected function getTmpUploadRootDir() {
            // the absolute directory path where uploaded documents should be saved
            return __DIR__ . '/../../../../web/uploads/provinces/';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadPicture() {
            // the file property can be empty if the field is not required
            if (null === $this->image) {
                    return;
            }
            if (null === $this->image_doctrine) {
                    return;
            }
            if(!$this->id){
                    $this->image->move($this->getTmpUploadRootDir(), $this->image->getClientOriginalName());
            }else{
                    $this->image->move($this->getUploadRootDir(), $this->image->getClientOriginalName());
            }
            $this->setImage($this->image->getClientOriginalName());
    }

    /**
     * @ORM\PostPersist()
     */
    public function movePicture()
    {
            if (null === $this->image) {
                    return;
            }
            if(!is_dir($this->getUploadRootDir())){
                    mkdir($this->getUploadRootDir());
            }
            copy($this->getTmpUploadRootDir().$this->image, $this->getFullPicturePath());
            unlink($this->getTmpUploadRootDir().$this->image);
    }

    /**
     * @ORM\PreRemove()
     */
    public function removePicture()
    {
            unlink($this->getFullPicturePath());
            rmdir($this->getUploadRootDir());
    }
    
    public function __toString()
    {
    	return $this->nom_fr;
    }


   
    public function __construct()
    {
        $this->appel_offre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->attraits_id = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hebergement_id = new \Doctrine\Common\Collections\ArrayCollection();
        $this->region_id = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set titre_fr_travel_attraits
     *
     * @param string $titreFrTravelAttraits
     */
    public function setTitreFrTravelAttraits($titreFrTravelAttraits)
    {
        $this->titre_fr_travel_attraits = $titreFrTravelAttraits;
    }

    /**
     * Get titre_fr_travel_attraits
     *
     * @return string 
     */
    public function getTitreFrTravelAttraits()
    {
        return $this->titre_fr_travel_attraits;
    }

    /**
     * Set titre_en_travel_attraits
     *
     * @param string $titreEnTravelAttraits
     */
    public function setTitreEnTravelAttraits($titreEnTravelAttraits)
    {
        $this->titre_en_travel_attraits = $titreEnTravelAttraits;
    }

    /**
     * Get titre_en_travel_attraits
     *
     * @return string 
     */
    public function getTitreEnTravelAttraits()
    {
        return $this->titre_en_travel_attraits;
    }

    /**
     * Set texte_fr_travel_attraits
     *
     * @param text $texteFrTravelAttraits
     */
    public function setTexteFrTravelAttraits($texteFrTravelAttraits)
    {
        $this->texte_fr_travel_attraits = $texteFrTravelAttraits;
    }

    /**
     * Get texte_fr_travel_attraits
     *
     * @return text 
     */
    public function getTexteFrTravelAttraits()
    {
        return $this->texte_fr_travel_attraits;
    }

    /**
     * Set texte_en_travel_attraits
     *
     * @param text $texteEnTravelAttraits
     */
    public function setTexteEnTravelAttraits($texteEnTravelAttraits)
    {
        $this->texte_en_travel_attraits = $texteEnTravelAttraits;
    }

    /**
     * Get texte_en_travel_attraits
     *
     * @return text 
     */
    public function getTexteEnTravelAttraits()
    {
        return $this->texte_en_travel_attraits;
    }

    /**
     * Set page_titre_fr
     *
     * @param string $pageTitreFr
     */
    public function setPageTitreFr($pageTitreFr)
    {
        $this->page_titre_fr = $pageTitreFr;
    }

    /**
     * Get page_titre_fr
     *
     * @return string 
     */
    public function getPageTitreFr()
    {
        return $this->page_titre_fr;
    }

    /**
     * Set page_titre_en
     *
     * @param string $pageTitreEn
     */
    public function setPageTitreEn($pageTitreEn)
    {
        $this->page_titre_en = $pageTitreEn;
    }

    /**
     * Get page_titre_en
     *
     * @return string 
     */
    public function getPageTitreEn()
    {
        return $this->page_titre_en;
    }

    /**
     * Set page_metakeyword_fr
     *
     * @param string $pageMetakeywordFr
     */
    public function setPageMetakeywordFr($pageMetakeywordFr)
    {
        $this->page_metakeyword_fr = $pageMetakeywordFr;
    }

    /**
     * Get page_metakeyword_fr
     *
     * @return string 
     */
    public function getPageMetakeywordFr()
    {
        return $this->page_metakeyword_fr;
    }

    /**
     * Set page_metakeyword_en
     *
     * @param string $pageMetakeywordEn
     */
    public function setPageMetakeywordEn($pageMetakeywordEn)
    {
        $this->page_metakeyword_en = $pageMetakeywordEn;
    }

    /**
     * Get page_metakeyword_en
     *
     * @return string 
     */
    public function getPageMetakeywordEn()
    {
        return $this->page_metakeyword_en;
    }

    /**
     * Set page_metadescription_fr
     *
     * @param text $pageMetadescriptionFr
     */
    public function setPageMetadescriptionFr($pageMetadescriptionFr)
    {
        $this->page_metadescription_fr = $pageMetadescriptionFr;
    }

    /**
     * Get page_metadescription_fr
     *
     * @return text 
     */
    public function getPageMetadescriptionFr()
    {
        return $this->page_metadescription_fr;
    }

    /**
     * Set page_metadescription_en
     *
     * @param text $pageMetadescriptionEn
     */
    public function setPageMetadescriptionEn($pageMetadescriptionEn)
    {
        $this->page_metadescription_en = $pageMetadescriptionEn;
    }

    /**
     * Get page_metadescription_en
     *
     * @return text 
     */
    public function getPageMetadescriptionEn()
    {
        return $this->page_metadescription_en;
    }

    /**
     * Set texte_accueil_fr
     *
     * @param text $texteAccueilFr
     */
    public function setTexteAccueilFr($texteAccueilFr)
    {
        $this->texte_accueil_fr = $texteAccueilFr;
    }

    /**
     * Get texte_accueil_fr
     *
     * @return text 
     */
    public function getTexteAccueilFr()
    {
        return $this->texte_accueil_fr;
    }

    /**
     * Set texte_accueil_en
     *
     * @param text $texteAccueilEn
     */
    public function setTexteAccueilEn($texteAccueilEn)
    {
        $this->texte_accueil_en = $texteAccueilEn;
    }

    /**
     * Get texte_accueil_en
     *
     * @return text 
     */
    public function getTexteAccueilEn()
    {
        return $this->texte_accueil_en;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image_doctrine
     *
     * @param string $imageDoctrine
     */
    public function setImageDoctrine($imageDoctrine)
    {
        $this->image_doctrine = $imageDoctrine;
    }

    /**
     * Get image_doctrine
     *
     * @return string 
     */
    public function getImageDoctrine()
    {
        return $this->image_doctrine;
    }

    /**
     * Set reservit_id
     *
     * @param integer $reservitId
     */
    public function setReservitId($reservitId)
    {
        $this->reservit_id = $reservitId;
    }

    /**
     * Get reservit_id
     *
     * @return integer 
     */
    public function getReservitId()
    {
        return $this->reservit_id;
    }

    /**
     * Set affiche
     *
     * @param boolean $affiche
     */
    public function setAffiche($affiche)
    {
        $this->affiche = $affiche;
    }

    /**
     * Get affiche
     *
     * @return boolean 
     */
    public function getAffiche()
    {
        return $this->affiche;
    }

    /**
     * Add appel_offre
     *
     * @param MyApp\MobileBundle\Entity\Appel_Offre $appelOffre
     */
    public function addAppel_Offre(\MyApp\MobileBundle\Entity\Appel_Offre $appelOffre)
    {
        $this->appel_offre[] = $appelOffre;
    }

    /**
     * Get appel_offre
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAppelOffre()
    {
        return $this->appel_offre;
    }

    /**
     * Set pays_id
     *
     * @param MyApp\MobileBundle\Entity\Pays $paysId
     */
    public function setPaysId(\MyApp\MobileBundle\Entity\Pays $paysId)
    {
        $this->pays_id = $paysId;
    }

    /**
     * Get pays_id
     *
     * @return MyApp\MobileBundle\Entity\Pays 
     */
    public function getPaysId()
    {
        return $this->pays_id;
    }

    /**
     * Add attraits_id
     *
     * @param MyApp\MobileBundle\Entity\Attraits $attraitsId
     */
    public function addAttraits(\MyApp\MobileBundle\Entity\Attraits $attraitsId)
    {
        $this->attraits_id[] = $attraitsId;
    }

    /**
     * Get attraits_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitsId()
    {
        return $this->attraits_id;
    }

    /**
     * Add hebergement_id
     *
     * @param MyApp\MobileBundle\Entity\Hebergements $hebergementId
     */
    public function addHebergements(\MyApp\MobileBundle\Entity\Hebergements $hebergementId)
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
     * Add region_id
     *
     * @param MyApp\MobileBundle\Entity\Regions $regionId
     */
    public function addRegions(\MyApp\MobileBundle\Entity\Regions $regionId)
    {
        $this->region_id[] = $regionId;
    }

    /**
     * Get region_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRegionId()
    {
        return $this->region_id;
    }

    /**
     * Add texte_province_categorie
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_categorie $texteProvinceCategorie
     */
    public function addTexte_province_categorie(\MyApp\MobileBundle\Entity\Texte_province_categorie $texteProvinceCategorie)
    {
        $this->texte_province_categorie[] = $texteProvinceCategorie;
    }

    /**
     * Get texte_province_categorie
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceCategorie()
    {
        return $this->texte_province_categorie;
    }

    /**
     * Add texte_province_forfait
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_forfait $texteProvinceForfait
     */
    public function addTexte_province_forfait(\MyApp\MobileBundle\Entity\Texte_province_forfait $texteProvinceForfait)
    {
        $this->texte_province_forfait[] = $texteProvinceForfait;
    }

    /**
     * Get texte_province_forfait
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceForfait()
    {
        return $this->texte_province_forfait;
    }

    /**
     * Add texte_province_sante
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_sante $texteProvinceSante
     */
    public function addTexte_province_sante(\MyApp\MobileBundle\Entity\Texte_province_sante $texteProvinceSante)
    {
        $this->texte_province_sante[] = $texteProvinceSante;
    }

    /**
     * Get texte_province_sante
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceSante()
    {
        return $this->texte_province_sante;
    }

    /**
     * Add texte_province_restaurant
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_restaurant $texteProvinceRestaurant
     */
    public function addTexte_province_restaurant(\MyApp\MobileBundle\Entity\Texte_province_restaurant $texteProvinceRestaurant)
    {
        $this->texte_province_restaurant[] = $texteProvinceRestaurant;
    }

    /**
     * Get texte_province_restaurant
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceRestaurant()
    {
        return $this->texte_province_restaurant;
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
     * Add texte_province_corporatif
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_corporatif $texteProvinceCorporatif
     */
    public function addTexte_province_corporatif(\MyApp\MobileBundle\Entity\Texte_province_corporatif $texteProvinceCorporatif)
    {
        $this->texte_province_corporatif[] = $texteProvinceCorporatif;
    }

    /**
     * Get texte_province_corporatif
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceCorporatif()
    {
        return $this->texte_province_corporatif;
    }

    /**
     * Add texte_province_appel_offre
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_appel_offre $texteProvinceAppelOffre
     */
    public function addTexte_province_appel_offre(\MyApp\MobileBundle\Entity\Texte_province_appel_offre $texteProvinceAppelOffre)
    {
        $this->texte_province_appel_offre[] = $texteProvinceAppelOffre;
    }

    /**
     * Get texte_province_appel_offre
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceAppelOffre()
    {
        return $this->texte_province_appel_offre;
    }

    /**
     * Add texte_province_location_salle
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_location_salle $texteProvinceLocationSalle
     */
    public function addTexte_province_location_salle(\MyApp\MobileBundle\Entity\Texte_province_location_salle $texteProvinceLocationSalle)
    {
        $this->texte_province_location_salle[] = $texteProvinceLocationSalle;
    }

    /**
     * Get texte_province_location_salle
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceLocationSalle()
    {
        return $this->texte_province_location_salle;
    }

    /**
     * Add texte_province_activite_corporative
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_activite_corporative $texteProvinceActiviteCorporative
     */
    public function addTexte_province_activite_corporative(\MyApp\MobileBundle\Entity\Texte_province_activite_corporative $texteProvinceActiviteCorporative)
    {
        $this->texte_province_activite_corporative[] = $texteProvinceActiviteCorporative;
    }

    /**
     * Get texte_province_activite_corporative
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceActiviteCorporative()
    {
        return $this->texte_province_activite_corporative;
    }

    /**
     * Add texte_province_chambre_affaire
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_chambre_affaire $texteProvinceChambreAffaire
     */
    public function addTexte_province_chambre_affaire(\MyApp\MobileBundle\Entity\Texte_province_chambre_affaire $texteProvinceChambreAffaire)
    {
        $this->texte_province_chambre_affaire[] = $texteProvinceChambreAffaire;
    }

    /**
     * Get texte_province_chambre_affaire
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceChambreAffaire()
    {
        return $this->texte_province_chambre_affaire;
    }

    /**
     * Add texte_province_forfait_affaire
     *
     * @param MyApp\MobileBundle\Entity\Texte_province_forfait_affaire $texteProvinceForfaitAffaire
     */
    public function addTexte_province_forfait_affaire(\MyApp\MobileBundle\Entity\Texte_province_forfait_affaire $texteProvinceForfaitAffaire)
    {
        $this->texte_province_forfait_affaire[] = $texteProvinceForfaitAffaire;
    }

    /**
     * Get texte_province_forfait_affaire
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteProvinceForfaitAffaire()
    {
        return $this->texte_province_forfait_affaire;
    }
}