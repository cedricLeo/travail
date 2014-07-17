<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping\PostLoad;
//use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\RegionRepository")
 * @ORM\Table(name = "regions", indexes={@ORM\index(name="region_idx", columns={"id", "nom_fr"})})
 * @ORM\HasLifecycleCallbacks
 */
class Regions{
	
   /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy = "AUTO")
    * @ORM\Column(type = "integer")
    * 
    * @var integer $id
    */
   private $id;

   /**
    * @ORM\ManyToOne(targetEntity="Provinces_etats", inversedBy="Regions")
    * @ORM\JoinColumn(name ="province_etat_id", referencedColumnName="id")
    * 
    * @var integer $province_etat_id
    */
   private $province_etat_id;

   /**
    * @ORM\ManyToMany(targetEntity = "Qcs_saisons", inversedBy = "Regions")
    * @ORM\JoinTable(name = "relations_regions_qcs_saisons")
    * 
    * @var ArrayCollection $qcs_saison_id
    */
   private $qcs_saison_id;

   /**
    * @ORM\OneToMany(targetEntity = "Appel_Offre", mappedBy = "Regions")
    *
    * @var integer $region_appel_offre
    */
   private $region_appel_offre;

   /**
    * @ORM\OneToMany(targetEntity = "Texte_region_categorie", mappedBy = "Regions", cascade={"remove"})
    * 
    * @var integer $texte_region_categorie
    */
   private $texte_region_categorie;
   
    /**
     * @ORM\OneToMany(targetEntity="Texte_region_corporatif", mappedBy="Regions", cascade={"remove"})
     *
     * @var integer $texte_region_corporatif
     */
    private $texte_region_corporatif;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_region_appel_offre", mappedBy="Regions", cascade={"remove"})
     *
     * @var integer $texte_region_appel_offre
     */
    private $texte_region_appel_offre;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_region_chambre_affaire", mappedBy="Regions", cascade={"remove"})
     *
     * @var integer $texte_region_chambre_affaire
     */
    private $texte_region_chambre_affaire;
    
   /**
     * @ORM\OneToMany(targetEntity="Texte_region_forfait_affaire", mappedBy="Regions", cascade={"remove"})
     *
     * @var integer $texte_region_forfait_affaire
     */
    private $texte_region_forfait_affaire;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_region_location_salle", mappedBy="Regions", cascade={"remove"})
     *
     * @var integer $texte_region_location_salle
     */
    private $texte_region_location_salle;
    
    /**
     * @ORM\OneToMany(targetEntity="Texte_region_activite_corporative", mappedBy="Regions", cascade={"remove"})
     *
     * @var integer $texte_region_activite_corporative
     */
    private $texte_region_activite_corporative;

   /**
    * @ORM\OneToMany(targetEntity = "Texte_region_attrait", mappedBy = "Regions", cascade={"remove"})
    * 
    * @var integer $texte_region_attrait
    */
   private $texte_region_attrait;

   /**
    * @ORM\OneToMany(targetEntity = "Texte_region_sante", mappedBy = "Regions", cascade={"remove"})
    * 
    * @var integer $texte_region_sante
    */
   private $texte_region_sante;

   /**
    * @ORM\OneToMany(targetEntity = "Texte_region_restaurant", mappedBy = "Regions", cascade={"remove"})
    * 
    * @var integer $texte_region_restaurant
    */
   private $texte_region_restaurant;
   
    /**
     * @ORM\Column(type = "string", length = 60, nullable = true)
     * 
     * @var string $nom_reservit
     */
    private $nom_reservit;

   /**
    * 
    * @ORM\Column(type = "string", length = 50)
    * 
    * @var string $nom_fr
    */
   private $nom_fr;

   /**
    * @ORM\Column(type = "string" , length = 50)
    * 
    * @var string $nom_en
    */
   private $nom_en;

   /**
    * @ORM\Column(type = "string", length = 255, nullable = "true")
    * 
    * @var string $url_fr
    */
   private $url_fr;

   /**
    * @ORM\Column(type = "string" , length = 255, nullable = "true")
    * 
    * @var string $url_en
    */
   private $url_en;

   /**
    * @ORM\Column(type = "string", length = 100, nullable = "true")
    * 
    * @var string $titre_fr
    */
   private $titre_fr;

   /**
    * @ORM\Column(type = "string" , length = 100, nullable = "true")
    * 
    * @var string $titre_en
    */
   private $titre_en;
   
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
    * @ORM\Column(type = "text", nullable = "true")
    * 
    * @var text $texte_fr
    */
   private $texte_fr;

   /**
    * @ORM\Column(type = "text", nullable = "true")
    * 
    * @var text $texte_en
    */
   private $texte_en;

   /**
    * @ORM\Column(type = "float")
    * 
    * @var float $latitude
    */
   private $latitude;

   /**
    * @ORM\Column(type = "float")
    * 
    * @var float $longitude
    */
   private $longitude;

   /**
    * @ORM\Column(type = "string", length = 50, nullable = "true")
    * 
    * @var string $image_haut_fr
    */
   private $image_haut_fr;

   /**
    * @ORM\Column(type = "string" , length = 50, nullable = "true")
    * 
    * @var string $image_haut_en
    */
   private $image_haut_en;

   /**
    * @ORM\Column(type = "string", length = 50, nullable = "true")
    * 
    * @var string $image_gauche
    */
   private $image_gauche;

   /**
    * @ORM\Column(type = "string", length = 50, nullable = "true")
    * 
    * @var string $image_centre
    */
   private $image_centre;

   /**
    * @ORM\Column(type = "text", nullable = "true")
    * 
    * @var text $texte_fr_bas_page
    */
   private $texte_fr_bas_page;

   /**
    * @ORM\Column(type = "text", nullable = "true")
    * 
    * @var text $texte_en_bas_page
    */
   private $texte_en_bas_page;

   /**
    * @ORM\Column(type = "string", length = 50, nullable = "true")
    * 
    * @var string $image_travel
    */
   private $image_travel;

   /**
    * @ORM\Column(type = "string", length = 50, nullable = "true")
    *
    * @var string $image_travel_doctrine
    */
   private $image_travel_doctrine;

   /**
    * @ORM\Column(type = "text", nullable = "true")
    * 
    * @var text $resume_fr_travel
    */
   private $resume_fr_travel;

   /**
    * @ORM\Column(type = "text", nullable = "true")
    * 
    * @var text $resume_en_travel
    */
   private $resume_en_travel;

   /**
    * @ORM\Column(type = "string" )
    * 
    * @var string $page_metakeyword_fr
    */
   private $page_metakeyword_fr;

   /**
    * @ORM\Column(type = "string")
    * 
    * @var string $page_metakeyword_en
    */
   private $page_metakeyword_en;

   /**
    * @ORM\Column(type = "text")
    * 
    * @var text $page_metadescription_fr
    */
   private $page_metadescription_fr;

   /**
    * @ORM\Column(type = "text")
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
    * @ORM\Column(type = "string" , length = 50, nullable = "true")
    * 
    * @var string $image_suggestion
    */
   private $image_suggestion;

   /**
    * @ORM\Column(type = "string" , length = 50, nullable = "true")
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
    * @ORM\OneToMany(targetEntity = "Zones", mappedBy = "Regions", fetch="EXTRA_LAZY")
    * 
    * @var integer $zone_id
    */
   private $zone_id;

   /**
    * @ORM\OneToMany(targetEntity = "Texte_region_forfait", mappedBy = "Regions", cascade={"remove"})
    * 
    * @var integer $texte_region_forfait
    */
   private $texte_region_forfait;

   /**
    * @ORM\OneToMany(targetEntity = "Qcs_regions_vedettes", mappedBy = "Regions")
    * 
    * @var integer $qcs_region_vedette_id
    */
   private $qcs_region_vedette_id;

   /**
    * @ORM\OneToMany(targetEntity = "Hebergements", mappedBy = "Regions", fetch="EXTRA_LAZY")
    * 
    * @var integer $hebergement_id
    */
   private $hebergement_id;

   /**
    * @ORM\OneToMany(targetEntity = "Attraits", mappedBy = "Regions", fetch="EXTRA_LAZY")
    *
    * @var integer $attrait_id
    */
   private $attrait_id;

   /**
    * @ORM\OneToMany(targetEntity = "Villes", mappedBy = "Regions", fetch="EXTRA_LAZY")
    *
    * @var integer $ville_id
    */
   private $ville_id;

   public function getFullPicturePath() {
           return null === $this->image_suggestion ? null : $this->getUploadRootDir(). $this->image_suggestion;
   }

   public function getFullPicturePath2() {
           return null === $this->image_travel ? null : $this->getUploadRootDir(). $this->image_travel;
   }

   protected function getUploadRootDir() {
           // the absolute directory path where uploaded documents should be saved
           return $this->getTmpUploadRootDir().$this->getId()."/";
   }

   protected function getTmpUploadRootDir() {
           // the absolute directory path where uploaded documents should be saved
           return __DIR__ . '/../../../../web/uploads/regions/';
   }

   /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
   public function uploadPicture() {
           // the file property can be empty if the field is not required
           if (null === $this->image_suggestion) {
                   return;
           }
           if (null === $this->image_doctrine) {
                   return;
           }
           if(!$this->id){
                   $this->image_suggestion->move($this->getTmpUploadRootDir(), $this->image_suggestion->getClientOriginalName());
           }else{
                   $this->image_suggestion->move($this->getUploadRootDir(), $this->image_suggestion->getClientOriginalName());
           }
           $this->setImageSuggestion($this->image_suggestion->getClientOriginalName());
   }

   /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
   public function uploadPicture2() {
           // the file property can be empty if the field is not required
           if (null === $this->image_travel){
                   return;
           }
           if (null === $this->image_travel_doctrine) {
                   return;
           }
           if(!$this->id){
                   $this->image_travel_->move($this->getTmpUploadRootDir(), $this->image_travel->getClientOriginalName());
           }else{
                   $this->image_travel->move($this->getUploadRootDir(), $this->image_travel->getClientOriginalName());
           }
           $this->setImageTravel($this->image_travel->getClientOriginalName());
   }


   /**
    * @ORM\PostPersist()
    */
   public function movePicture()
   {
           if (null === $this->image_suggestion) {
                   return;
           }
           if (null === $this->image_travel) {
                   return;
           }
           if(!is_dir($this->getUploadRootDir())){
                   mkdir($this->getUploadRootDir());
           }
           copy($this->getTmpUploadRootDir().$this->image_suggestion, $this->getFullPicturePath());
           unlink($this->getTmpUploadRootDir().$this->image_suggestion);

           copy($this->getTmpUploadRootDir().$this->image_travel, $this->getFullPicturePath2());
           unlink($this->getTmpUploadRootDir().$this->image_travel);
   }

   /**
    * @ORM\PreRemove()
    */
   public function removePicture()
   {
           if($this->getFullPicturePath() or $this->getFullPicturePath2()){
                   unlink($this->getFullPicturePath());
                   unlink($this->getFullPicturePath2());
                   rmdir($this->getUploadRootDir());
           }
   }


   public function __construct()
   {
           $this->attrait_categorie_id = new ArrayCollection();
           $this->qcs_saison_id = new ArrayCollection();
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
     * Set url_fr
     *
     * @param string $urlFr
     */
    public function setUrlFr($urlFr)
    {
        $this->url_fr = $urlFr;
    }

    /**
     * Get url_fr
     *
     * @return string 
     */
    public function getUrlFr()
    {
        return $this->url_fr;
    }

    /**
     * Set url_en
     *
     * @param string $urlEn
     */
    public function setUrlEn($urlEn)
    {
        $this->url_en = $urlEn;
    }

    /**
     * Get url_en
     *
     * @return string 
     */
    public function getUrlEn()
    {
        return $this->url_en;
    }

    /**
     * Set titre_fr
     *
     * @param string $titreFr
     */
    public function setTitreFr($titreFr)
    {
        $this->titre_fr = $titreFr;
    }

    /**
     * Get titre_fr
     *
     * @return string 
     */
    public function getTitreFr()
    {
        return $this->titre_fr;
    }

    /**
     * Set titre_en
     *
     * @param string $titreEn
     */
    public function setTitreEn($titreEn)
    {
        $this->titre_en = $titreEn;
    }

    /**
     * Get titre_en
     *
     * @return string 
     */
    public function getTitreEn()
    {
        return $this->titre_en;
    }

    /**
     * Set texte_fr
     *
     * @param text $texteFr
     */
    public function setTexteFr($texteFr)
    {
        $this->texte_fr = $texteFr;
    }

    /**
     * Get texte_fr
     *
     * @return text 
     */
    public function getTexteFr()
    {
        return $this->texte_fr;
    }

    /**
     * Set texte_en
     *
     * @param text $texteEn
     */
    public function setTexteEn($texteEn)
    {
        $this->texte_en = $texteEn;
    }

    /**
     * Get texte_en
     *
     * @return text 
     */
    public function getTexteEn()
    {
        return $this->texte_en;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set image_haut_fr
     *
     * @param string $imageHautFr
     */
    public function setImageHautFr($imageHautFr)
    {
        $this->image_haut_fr = $imageHautFr;
    }

    /**
     * Get image_haut_fr
     *
     * @return string 
     */
    public function getImageHautFr()
    {
        return $this->image_haut_fr;
    }

    /**
     * Set image_haut_en
     *
     * @param string $imageHautEn
     */
    public function setImageHautEn($imageHautEn)
    {
        $this->image_haut_en = $imageHautEn;
    }

    /**
     * Get image_haut_en
     *
     * @return string 
     */
    public function getImageHautEn()
    {
        return $this->image_haut_en;
    }

    /**
     * Set image_gauche
     *
     * @param string $imageGauche
     */
    public function setImageGauche($imageGauche)
    {
        $this->image_gauche = $imageGauche;
    }

    /**
     * Get image_gauche
     *
     * @return string 
     */
    public function getImageGauche()
    {
        return $this->image_gauche;
    }

    /**
     * Set image_centre
     *
     * @param string $imageCentre
     */
    public function setImageCentre($imageCentre)
    {
        $this->image_centre = $imageCentre;
    }

    /**
     * Get image_centre
     *
     * @return string 
     */
    public function getImageCentre()
    {
        return $this->image_centre;
    }

    /**
     * Set texte_fr_bas_page
     *
     * @param text $texteFrBasPage
     */
    public function setTexteFrBasPage($texteFrBasPage)
    {
        $this->texte_fr_bas_page = $texteFrBasPage;
    }

    /**
     * Get texte_fr_bas_page
     *
     * @return text 
     */
    public function getTexteFrBasPage()
    {
        return $this->texte_fr_bas_page;
    }

    /**
     * Set texte_en_bas_page
     *
     * @param text $texteEnBasPage
     */
    public function setTexteEnBasPage($texteEnBasPage)
    {
        $this->texte_en_bas_page = $texteEnBasPage;
    }

    /**
     * Get texte_en_bas_page
     *
     * @return text 
     */
    public function getTexteEnBasPage()
    {
        return $this->texte_en_bas_page;
    }

    /**
     * Set image_travel
     *
     * @param string $imageTravel
     */
    public function setImageTravel($imageTravel)
    {
        $this->image_travel = $imageTravel;
    }

    /**
     * Get image_travel
     *
     * @return string 
     */
    public function getImageTravel()
    {
        return $this->image_travel;
    }

    /**
     * Set image_travel_doctrine
     *
     * @param string $imageTravelDoctrine
     */
    public function setImageTravelDoctrine($imageTravelDoctrine)
    {
        $this->image_travel_doctrine = $imageTravelDoctrine;
    }

    /**
     * Get image_travel_doctrine
     *
     * @return string 
     */
    public function getImageTravelDoctrine()
    {
        return $this->image_travel_doctrine;
    }

    /**
     * Set resume_fr_travel
     *
     * @param text $resumeFrTravel
     */
    public function setResumeFrTravel($resumeFrTravel)
    {
        $this->resume_fr_travel = $resumeFrTravel;
    }

    /**
     * Get resume_fr_travel
     *
     * @return text 
     */
    public function getResumeFrTravel()
    {
        return $this->resume_fr_travel;
    }

    /**
     * Set resume_en_travel
     *
     * @param text $resumeEnTravel
     */
    public function setResumeEnTravel($resumeEnTravel)
    {
        $this->resume_en_travel = $resumeEnTravel;
    }

    /**
     * Get resume_en_travel
     *
     * @return text 
     */
    public function getResumeEnTravel()
    {
        return $this->resume_en_travel;
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
     * Set image_suggestion
     *
     * @param string $imageSuggestion
     */
    public function setImageSuggestion($imageSuggestion)
    {
        $this->image_suggestion = $imageSuggestion;
    }

    /**
     * Get image_suggestion
     *
     * @return string 
     */
    public function getImageSuggestion()
    {
        return $this->image_suggestion;
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
     * Set province_etat_id
     *
     * @param MyApp\GlobalBundle\Entity\Provinces_etats $provinceEtatId
     */
    public function setProvinceEtatId(\MyApp\GlobalBundle\Entity\Provinces_etats $provinceEtatId)
    {
        $this->province_etat_id = $provinceEtatId;
    }

    /**
     * Get province_etat_id
     *
     * @return MyApp\GlobalBundle\Entity\Provinces_etats 
     */
    public function getProvinceEtatId()
    {
        return $this->province_etat_id;
    }

    /**
     * Add qcs_saison_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_saisons $qcsSaisonId
     */
    public function addQcs_saisons(\MyApp\GlobalBundle\Entity\Qcs_saisons $qcsSaisonId)
    {
        $this->qcs_saison_id[] = $qcsSaisonId;
    }

    /**
     * Get qcs_saison_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsSaisonId()
    {
        return $this->qcs_saison_id;
    }

    /**
     * Add region_appel_offre
     *
     * @param MyApp\GlobalBundle\Entity\Appel_Offre $regionAppelOffre
     */
    public function addAppel_Offre(\MyApp\GlobalBundle\Entity\Appel_Offre $regionAppelOffre)
    {
        $this->region_appel_offre[] = $regionAppelOffre;
    }

    /**
     * Get region_appel_offre
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRegionAppelOffre()
    {
        return $this->region_appel_offre;
    }

    /**
     * Add texte_region_categorie
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_categorie $texteRegionCategorie
     */
    public function addTexte_region_categorie(\MyApp\GlobalBundle\Entity\Texte_region_categorie $texteRegionCategorie)
    {
        $this->texte_region_categorie[] = $texteRegionCategorie;
    }

    /**
     * Get texte_region_categorie
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionCategorie()
    {
        return $this->texte_region_categorie;
    }

    /**
     * Add texte_region_attrait
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_attrait $texteRegionAttrait
     */
    public function addTexte_region_attrait(\MyApp\GlobalBundle\Entity\Texte_region_attrait $texteRegionAttrait)
    {
        $this->texte_region_attrait[] = $texteRegionAttrait;
    }

    /**
     * Get texte_region_attrait
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionAttrait()
    {
        return $this->texte_region_attrait;
    }

    /**
     * Add texte_region_sante
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_sante $texteRegionSante
     */
    public function addTexte_region_sante(\MyApp\GlobalBundle\Entity\Texte_region_sante $texteRegionSante)
    {
        $this->texte_region_sante[] = $texteRegionSante;
    }

    /**
     * Get texte_region_sante
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionSante()
    {
        return $this->texte_region_sante;
    }

    /**
     * Add texte_region_restaurant
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_restaurant $texteRegionRestaurant
     */
    public function addTexte_region_restaurant(\MyApp\GlobalBundle\Entity\Texte_region_restaurant $texteRegionRestaurant)
    {
        $this->texte_region_restaurant[] = $texteRegionRestaurant;
    }

    /**
     * Get texte_region_restaurant
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionRestaurant()
    {
        return $this->texte_region_restaurant;
    }

    /**
     * Add zone_id
     *
     * @param MyApp\GlobalBundle\Entity\Zones $zoneId
     */
    public function addZones(\MyApp\GlobalBundle\Entity\Zones $zoneId)
    {
        $this->zone_id[] = $zoneId;
    }

    /**
     * Get zone_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getZoneId()
    {
        return $this->zone_id;
    }

    /**
     * Add texte_region_forfait
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_forfait $texteRegionForfait
     */
    public function addTexte_region_forfait(\MyApp\GlobalBundle\Entity\Texte_region_forfait $texteRegionForfait)
    {
        $this->texte_region_forfait[] = $texteRegionForfait;
    }

    /**
     * Get texte_region_forfait
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionForfait()
    {
        return $this->texte_region_forfait;
    }

    /**
     * Add qcs_region_vedette_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_regions_vedettes $qcsRegionVedetteId
     */
    public function addQcs_regions_vedettes(\MyApp\GlobalBundle\Entity\Qcs_regions_vedettes $qcsRegionVedetteId)
    {
        $this->qcs_region_vedette_id[] = $qcsRegionVedetteId;
    }

    /**
     * Get qcs_region_vedette_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsRegionVedetteId()
    {
        return $this->qcs_region_vedette_id;
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
     * Add attrait_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits $attraitId
     */
    public function addAttraits(\MyApp\GlobalBundle\Entity\Attraits $attraitId)
    {
        $this->attrait_id[] = $attraitId;
    }

    /**
     * Get attrait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitId()
    {
        return $this->attrait_id;
    }

    /**
     * Add ville_id
     *
     * @param MyApp\GlobalBundle\Entity\Villes $villeId
     */
    public function addVilles(\MyApp\GlobalBundle\Entity\Villes $villeId)
    {
        $this->ville_id[] = $villeId;
    }

    /**
     * Get ville_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVilleId()
    {
        return $this->ville_id;
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
     * Set nom_reservit
     *
     * @param string $nomReservit
     */
    public function setNomReservit($nomReservit)
    {
        $this->nom_reservit = $nomReservit;
    }

    /**
     * Get nom_reservit
     *
     * @return string 
     */
    public function getNomReservit()
    {
        return $this->nom_reservit;
    }

    /**
     * Add texte_region_corporatif
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_corporatif $texteRegionCorporatif
     */
    public function addTexte_region_corporatif(\MyApp\GlobalBundle\Entity\Texte_region_corporatif $texteRegionCorporatif)
    {
        $this->texte_region_corporatif[] = $texteRegionCorporatif;
    }

    /**
     * Get texte_region_corporatif
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionCorporatif()
    {
        return $this->texte_region_corporatif;
    }

    /**
     * Add texte_region_appel_offre
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_appel_offre $texteRegionAppelOffre
     */
    public function addTexte_region_appel_offre(\MyApp\GlobalBundle\Entity\Texte_region_appel_offre $texteRegionAppelOffre)
    {
        $this->texte_region_appel_offre[] = $texteRegionAppelOffre;
    }

    /**
     * Get texte_region_appel_offre
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionAppelOffre()
    {
        return $this->texte_region_appel_offre;
    }

    /**
     * Add texte_region_chambre_affaire
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_chambre_affaire $texteRegionChambreAffaire
     */
    public function addTexte_region_chambre_affaire(\MyApp\GlobalBundle\Entity\Texte_region_chambre_affaire $texteRegionChambreAffaire)
    {
        $this->texte_region_chambre_affaire[] = $texteRegionChambreAffaire;
    }

    /**
     * Get texte_region_chambre_affaire
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionChambreAffaire()
    {
        return $this->texte_region_chambre_affaire;
    }

    /**
     * Add texte_region_forfait_affaire
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_forfait_affaire $texteRegionForfaitAffaire
     */
    public function addTexte_region_forfait_affaire(\MyApp\GlobalBundle\Entity\Texte_region_forfait_affaire $texteRegionForfaitAffaire)
    {
        $this->texte_region_forfait_affaire[] = $texteRegionForfaitAffaire;
    }

    /**
     * Get texte_region_forfait_affaire
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionForfaitAffaire()
    {
        return $this->texte_region_forfait_affaire;
    }

    /**
     * Add texte_region_location_salle
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_location_salle $texteRegionLocationSalle
     */
    public function addTexte_region_location_salle(\MyApp\GlobalBundle\Entity\Texte_region_location_salle $texteRegionLocationSalle)
    {
        $this->texte_region_location_salle[] = $texteRegionLocationSalle;
    }

    /**
     * Get texte_region_location_salle
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionLocationSalle()
    {
        return $this->texte_region_location_salle;
    }

    /**
     * Add texte_region_activite_corporative
     *
     * @param MyApp\GlobalBundle\Entity\Texte_region_activite_corporative $texteRegionActiviteCorporative
     */
    public function addTexte_region_activite_corporative(\MyApp\GlobalBundle\Entity\Texte_region_activite_corporative $texteRegionActiviteCorporative)
    {
        $this->texte_region_activite_corporative[] = $texteRegionActiviteCorporative;
    }

    /**
     * Get texte_region_activite_corporative
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTexteRegionActiviteCorporative()
    {
        return $this->texte_region_activite_corporative;
    }
}