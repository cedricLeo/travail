<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\DBAL\Types\IntegerType;
use MyApp\MobileBundle\Entity\Galerie_attraits;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\AttraitsRepository")
 * @ORM\Table(name = "attraits", indexes={@ORM\index(name="attrait_idx", columns={"id", "hebergement_id", "province_id", "region_id", "zone_id", "ville_id", "nom_fr", "repertoire_fr", "repertoire_en", "approuve"})})
 * @ORM\HasLifecycleCallbacks
 */
class Attraits{
	
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue( strategy = "AUTO")
     * 
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Soins_sante", inversedBy="Attraits", cascade={"persist"})
     * 
     * @var ArrayCollection $soins_sante_id
     */
    private $soins_sante_id;

    /**
     * @ORM\ManyToMany(targetEntity="Devises", inversedBy="Attraits", cascade={"persist"})
     * 
     * @var ArrayCollection $devise_id
     */
    private $devise_id;

    /**
     * @ORM\Column(type = "string", length = 100, nullable = false)
     * 
     * @var string $nom_fr
     */
    private $nom_fr;

    /**
     * @ORM\Column(type = "string", length = 100, nullable = false)
     * 
     * @var string $nom_en
     */
    private $nom_en;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = false)
     *
     * @var string $adresse
     */
    private $adresse;

    /**
     * @ORM\Column(type = "string", length = 7, nullable = false)
     *
     * @var string $code_postal
     */
    private $code_postal;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     * 
     * @var string $page_facebook_fr
     */
    private $page_facebook_fr;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     * 
     * @var string $page_facebook_en
     */
    private $page_facebook_en;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_description_fr
     */
    private $texte_description_fr;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_description_en
     */
    private $texte_description_en;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_express_fr
     */
    private $texte_express_fr;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $texte_express_en
     */
    private $texte_express_en;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $date_debut
     */
    private $date_debut;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $date_fin
     */
    private $date_fin;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $emplacements_0_service_camping
     */
    private $emplacements_0_service_camping;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $emplacements_1_service_camping
     */
    private $emplacements_1_service_camping;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $emplacements_2_services_camping
     */
    private $emplacements_2_services_camping;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $emplacements_3_services_camping
     */
    private $emplacements_3_services_camping;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $approuve
     */
    private $approuve;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $actif
     */
    private $actif;

    /**
     * @ORM\Column(type = "string", length = "50", nullable = "false")
     *
     * @var string $valider_par
     */
    private $valider_par;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $express
     */
    private $express;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $payant
     */
    private $payant;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $adresse_web_cliquable
     */
    private $adresse_web_cliquable;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $nouveau_membre
     */
    private $nouveau_membre;

    /**
     * @ORM\Column(type = "date", nullable = "true")
     * 
     * @var date $date_creation
     */
    private $date_creation;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     * 
     * @var string $meta_titre_fr
     */
    private $meta_titre_fr;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     * 
     * @var string $meta_titre_en
     */
    private $meta_titre_en;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     * 
     * @var string $metakeywords_fr
     */
    private $metakeywords_fr;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     * 
     * @var string $metakeywords_en
     */
    private $metakeywords_en;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $metadescription_fr
     */
    private $metadescription_fr;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     * 
     * @var text $metadescription_en
     */
    private $metadescription_en;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $optvisibilite_grande_photo
     */
    private $optvisibilite_grande_photo;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $optvisibilite_photo_categorie
     */
    private $optvisibilite_photo_categorie;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $optvisibilite_nos_suggestions
     */
    private $optvisibilite_nos_suggestions;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $optvisibilite_proximite
     */
    private $optvisibilite_proximite;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $optvisibilite_lien_hebergement
     */
    private $optvisibilite_lien_hebergement;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $optvisibilite_incontournables
     */
    private $optvisibilite_incontournables;

    /**
     * @ORM\OneToMany(targetEntity="Coupons", mappedBy="Attraits", fetch="EXTRA_LAZY")
     *
     * @var integer $coupon_id
     */
    private $coupon_id;

    /**
     * @ORM\ManyToMany(targetEntity="Cuisines", inversedBy="Attraits" )
     * 
     * @var ArrayCollection $cuisine_id
     */
    private $cuisine_id;

    /**
     * @ORM\ManyToOne(targetEntity = "Hebergements", inversedBy = "Attraits")
     * @ORM\JoinColumn(name="hebergement_id", referencedColumnName="id")
     *
     * @var integer $hebergement_id
     */
    private $hebergement_id;

    /**
     * @ORM\ManyToMany(targetEntity="Attraits_services", inversedBy="Hebergements")
     * 
     * @var ArrayCollection $attrait_service_id
     */
    private $attrait_service_id;

    /**
     * @ORM\ManyToMany(targetEntity="Modes_paiements", inversedBy="Attraits")
     *
     * @var ArrayCollection $paiement_id
     */
    private $paiement_id;

    /**
     * @ORM\ManyToMany(targetEntity="Qcs_festival_attraits", inversedBy="Attraits")
     * 
     * @var arrayCollection $qcs_festival_attrait_id
     */
    private $qcs_festival_attrait_id;

    /**
     * @ORM\ManyToMany(targetEntity="Qcs_echos_attraits", inversedBy="Attraits")
     *
     * @var ArrayCollection $qcs_echo_attrait_id
     */
    private $qcs_echo_attrait_id;

    /**
     * @ORM\ManyToMany(targetEntity = "Attraits_activites", inversedBy = "Attraits")
     * 
     * @var ArrayCollection $attrait_activite_id
     */
    private $attrait_activite_id;

    /**
     * @ORM\ManyToMany(targetEntity = "Qcs_thematiques_attraits", inversedBy="Attraits")
     * 
     * @var ArrayCollection $qcs_thematique_attrait_id 
     */
    private $qcs_thematique_attrait_id;

    /**
     * @ORM\ManyToOne(targetEntity = "Provinces_etats", inversedBy = "Attraits")
     * @ORM\JoinColumn(name = "province_id", referencedColumnName = "id")
     * 
     * @var integer $province_id
     */
    private $province_id;

    /**
     * @ORM\ManyToOne(targetEntity = "Regions", inversedBy = "Attraits")
     * @ORM\JoinColumn(name = "region_id", referencedColumnName = "id")
     *
     * @var integer $region_id
     */
    private $region_id;

    /**
     * @ORM\ManyToOne(targetEntity = "Zones", inversedBy = "Attraits")
     * @ORM\JoinColumn(name = "zone_id", referencedColumnName = "id")
     *
     * @var integer $zone_id
     */
    private $zone_id;

    /**
     * @ORM\ManyToOne(targetEntity = "Villes", inversedBy = "Attraits")
     * @ORM\JoinColumn(name = "ville_id", referencedColumnName = "id")
     *
     * @var integer $ville_id
     */
    private $ville_id;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     * 
     * @var boolean $periode_pour_attrait
     */
    private $periode_pour_attrait;

    /**
     * @ORM\Column(type = "boolean", nullable = "true")
     *
     * @var boolean $afficher_restaurant
     */
    private $afficher_restaurant;

    /**
     * @ORM\Column(type = "float", length="6", nullable = "true")
     *
     * @var boolean $tarif_attrait
     */
    private $tarif_attrait;

    /**
     * @ORM\ManyToMany(targetEntity = "Types_soins_sante", inversedBy = "Attraits", cascade={"persist"})
     *
     * @var ArrayCollection $type_soins_id
     */
    private $type_soins_id;

    /**
     * @ORM\Column(type = "float", nullable = true)
     *
     * @var float $latitude
     */
    private $latitude;

    /**
     * @ORM\Column(type = "float", nullable = true)
     *
     * @var float $longitude
     */
    private $longitude;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     * 
     * @var string $twitter_fr
     */
    private $twitter_fr;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     *
     * @var string $twitter_en
     */
    private $twitter_en;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     *
     * @var string $google_plus_fr
     */
    private $google_plus_fr;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     *
     * @var string $google_plus_en
     */
    private $google_plus_en;

    /**
     * @ORM\Column(type = "string", length = 20, nullable = false)
     * 
     * @var string $telephone
     */
    private $telephone;

    /**
     * @ORM\Column(type = "string", length = 20, nullable = "true")
     *
     * @var string $telephone2
     */
    private $telephone2;

    /**
     * @ORM\Column(type = "string", length = 20, nullable = "true")
     *
     * @var string $telephone_poste
     */
    private $telephone_poste;

    /**
     * @ORM\Column(type = "string", length = 20, nullable = "true")
     *
     * @var string $sans_frais
     */
    private $sans_frais;

    /**
     * @ORM\Column(type = "string", length = 20, nullable = "true")
     *
     * @var string $telecopieur
     */
    private $telecopieur;

    /**
     * @ORM\Column(type = "string", length = 50, nullable = "true")
     *
     * @var string $courriel
     */
    private $courriel;

    /**
     * @ORM\Column(type = "string", length = 500, nullable = "true")
     *
     * @var string $siteweb
     */
    private $siteweb;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     *
     * @var string $titre_fr
     */
    private $titre_fr;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = "true")
     *
     * @var string $titre_en
     */
    private $titre_en;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = false)
     *
     * @var string $repertoire_fr
     */
    private $repertoire_fr;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = false)
     *
     * @var string $repertoire_en
     */
    private $repertoire_en;

    /**
     * @ORM\OneToMany(targetEntity = "Videos", mappedBy = "Attraits", fetch="EXTRA_LAZY")
     * 
     * @var integer $video_id
     */
    private $video_id;

    /**
     * @ORM\ManyToOne(targetEntity="MyApp\MobileBundle\Entity\Horaires")
     * 
     * @var integer $lundi_matin_ete
     */
    private $lundi_matin_ete;

    /**
     * @ORM\ManyToMany(targetEntity="Attraits_categories", inversedBy="Attraits")
     * 
     * @var ArrayCollection $categorie_attrait
     */
    private $categorie_attrait;

    /**
     * @ORM\Column(type = "string", length = 100, nullable = "true")
     *
     * @var string $image
     */
    private $image;

    /**
     * @ORM\Column(type = "string", length = 100, nullable = "true")
     *
     * @var string $image_doctrine
     */
    private $image_doctrine;

    /**
     * @ORM\Column(type = "string", length = 100, nullable = "true")
     *
     * @var string $logo
     */
    private $logo;

    /**
     * @ORM\Column(type = "string", length = 100, nullable = "true")
     *
     * @var string $logo_doctrine
     */
    private $logo_doctrine;

    /**
     * @ORM\Column(type = "integer", length = 5, nullable = false)
     *
     * @var string $capacite
     */
    private $capacite;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     *
     * @var text $texte_resume_fr
     */
    private $texte_resume_fr;

    /**
     * @ORM\Column(type = "text", nullable = "true")
     *
     * @var text $texte_resume_en
     */
    private $texte_resume_en;

    public function getFullPicturePath() {
            return null === $this->image ? null : $this->getUploadRootDir(). $this->image;
    }

    public function getFullPhotoPayantePath() {
             return null === $this->photo_payante ? null : $this->getUploadRootDir(). $this->photo_payante;
    }

    public function getFullLogoPath() {
            return null === $this->logo ? null : $this->getUploadRootDir(). $this->logo;
    }

    protected function getUploadRootDir() {
            // the absolute directory path where uploaded documents should be saved
            return $this->getTmpUploadRootDir().$this->getId()."/";
    }

    protected function getTmpUploadRootDir() {
            // the absolute directory path where uploaded documents should be saved
            return __DIR__ . '/../../../../web/uploads/attrait/';
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
            if(!$this->id){
                    $this->image->move($this->getTmpUploadRootDir(), $this->image->getClientOriginalName());
            }else{
                if(is_object($this->image)){
                    $this->image->move($this->getUploadRootDir(), $this->image->getClientOriginalName());
                }
                if(is_object($this->photo_payante)){
                    $this->photo_payante->move($this->getUploadRootDir(), $this->photo_payante->getClientOriginalName());
                }
                if(is_object($this->logo)){
                    $this->logo->move($this->getUploadRootDir(), $this->logo->getClientOriginalName());
                }
            }
            if(is_object($this->image)){
                $this->setImage($this->image->getClientOriginalName());
            }
            if(is_object($this->photo_payante)){
                $this->setPhotoPayante($this->photo_payante->getClientOriginalName());
            }
            if(is_object($this->logo)){
                $this->setLogo($this->logo->getClientOriginalName());
            }
    }

/**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadPhotoPayante() {
            // the file property can be empty if the field is not required
             if (null === $this->photo_payante) {
                    return;
            }
            if(!$this->id){
                    $this->photo_payante->move($this->getTmpUploadRootDir(), $this->photo_payante->getClientOriginalName());
            }else{
                    if(is_object($this->image)){
                        $this->image->move($this->getUploadRootDir(), $this->image->getClientOriginalName());
                    }
                    if(is_object($this->photo_payante)){
                        $this->photo_payante->move($this->getUploadRootDir(), $this->photo_payante->getClientOriginalName());
                    }
                    if(is_object($this->logo)){
                        $this->logo->move($this->getUploadRootDir(), $this->logo->getClientOriginalName());
                    }
            }
            if(is_object($this->image)){
                $this->setImage($this->image->getClientOriginalName());
            }
            if(is_object($this->photo_payante)){
                $this->setPhotoPayante($this->photo_payante->getClientOriginalName());
            }
            if(is_object($this->logo)){
                $this->setLogo($this->logo->getClientOriginalName());
            }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadLogo() {
            // the file property can be empty if the field is not required
            if (null === $this->logo) {
                    return;
            }
            if(!$this->id){
                    $this->logo->move($this->getTmpUploadRootDir(), $this->logo->getClientOriginalName());
            }else{
                    if(is_object($this->image)){
                        $this->image->move($this->getUploadRootDir(), $this->image->getClientOriginalName());
                    }
                    if(is_object($this->photo_payante)){
                        $this->photo_payante->move($this->getUploadRootDir(), $this->photo_payante->getClientOriginalName());
                    }
                    if(is_object($this->logo)){
                        $this->logo->move($this->getUploadRootDir(), $this->logo->getClientOriginalName());
                    }
            }
            if(is_object($this->image)){
                $this->setImage($this->image->getClientOriginalName());
            }
            if(is_object($this->photo_payante)){
                $this->setPhotoPayante($this->photo_payante->getClientOriginalName());
            }
            if(is_object($this->logo)){
                $this->setLogo($this->logo->getClientOriginalName());
            }

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
     * @ORM\PostPersist()
     */
    public function moveLogo()
    {
            if (null === $this->logo) {
                    return;
            }
            if(!is_dir($this->getUploadRootDir())){
                    mkdir($this->getUploadRootDir());
            }
            copy($this->getTmpUploadRootDir().$this->logo, $this->getFullLogoPath());
            unlink($this->getTmpUploadRootDir().$this->logo);
    }

    /**
     * @ORM\PostPersist()
     */
    public function movePhotoPayante()
    {
            if (null === $this->photo_payante) {
                    return;
            }
            if(!is_dir($this->getUploadRootDir())){
                    mkdir($this->getUploadRootDir());
            }
            copy($this->getTmpUploadRootDir().$this->photo_payante, $this->getFullPhotoPayantePath());
            unlink($this->getTmpUploadRootDir().$this->photo_payante);
    }

    /**
     * @ORM\PreRemove()
     */
    public function removePicture()
    {
            if($this->getFullPicturePath() or $this->getFullLogoPath() or $this->getFullPhotoPayantePath()){
                    unlink($this->getFullPicturePath());
                    unlink($this->getFullLogoPath());
                    unlink($this->getFullPhotoPayantePath());
                    rmdir($this->getUploadRootDir());
            }
    }

    /**
     * @ORM\Column(type = "string", length = "100", nullable = "true")
     *
     * @var string $photo_payante
     */
    private $photo_payante;

/**
     * @ORM\Column(type = "string", length = "100", nullable = "true")
     *
     * @var string $photo_payante_doctrine
     */
    private $photo_payante_doctrine;

    /**
     * @ORM\ManyToMany(targetEntity="Galerie_attraits", cascade={"persist", "remove"})
     *
     * @var ArrayCollection $galerie_attraits
     */
    private $galerie_attraits;

    /**
     * @ORM\ManyToOne(targetEntity="MyApp\MobileBundle\Entity\Politique_fr", cascade={"persist", "remove"})
     */
    private $politique_attrait_fr;

    /**
     * @ORM\ManyToOne(targetEntity="MyApp\MobileBundle\Entity\Politique_en", cascade={"persist", "remove"})
     */
    private $politique_attrait_en;

    /**
     * @ORM\ManyToOne(targetEntity="MyApp\MobileBundle\Entity\Textes_attrait_fr", cascade={"persist", "remove"})
     */
    private $description_attrait_fr;

    /**
     * @ORM\ManyToOne(targetEntity="MyApp\MobileBundle\Entity\Textes_attrait_en", cascade={"persist", "remove"})
     */
    private $description_attrait_en;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="Attraits")
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity="Distances_attraits", mappedBy = "Attraits", cascade={"persist"})
     *
     * @var integer $distance_id
     */
    private $distance_id;

    public function __construct()
    {
            $this->soins_sante_id 			= new ArrayCollection();
            $this->devise_id 			= new ArrayCollection();
            $this->cuisine_id 			= new ArrayCollection();
            $this->attrait_service_id 		= new ArrayCollection();
            $this->paiement_id 			= new ArrayCollection();
            $this->attrait_activite_id  		= new ArrayCollection();
            $this->type_soins_id 			= new ArrayCollection();
            $this->qcs_thematique_attrait_id	= new ArrayCollection();
            $this->qcs_festival_attrait_id		= new ArrayCollection();
            $this->qcs_echo_attrait_id		= new ArrayCollection();
            $this->galerie_attraits			= new ArrayCollection();
            $this->soins_client 			= new ArrayCollection();
            $this->categorie_attrait                = New ArrayCollection();
    }

    public function setPolitiqueAttraitFr(Politique_fr $politique = null)
    {
            $this->politique_attrait_fr = $politique;
    }

    public function getPolitiqueAttraitFr()
    {
            return $this->politique_attrait_fr;
    }

    public function setPolitiqueAttraitEn(Politique_en $politique = null)
    {
            $this->politique_attrait_en = $politique;
    }

    public function getPolitiqueAttraitEn()
    {
            return $this->politique_attrait_en;
    }

    public function setDescriptionAttraitFr(Textes_attrait_fr $description = null)
    {
            $this->description_attrait_fr = $description;
    }

    public function getDescriptionAttraitFr()
    {
            return $this->description_attrait_fr;
    }

    public function setDescriptionAttraitEn(Textes_attrait_en $description = null)
    {
            $this->description_attrait_en = $description;
    }

    public function getDescriptionAttraitEn()
    {
            return $this->description_attrait_en;
    }


    public function setGalerieAttraits(ArrayCollection $galerieAttraits)
    {
            foreach ($galerieAttraits as $tag) {
                    $tag->addGalerieAttraits($this);
            }	
            $this->galerie_attraits = $galerieAttraits;
    }

    /**
     * Add galerie_attraits
     *
     * @param MyApp\MobileBundle\Entity\Galerie_attraits $galerieAttraits
     */
    public function addGalerieAttraits(\MyApp\MobileBundle\Entity\Galerie_attraits $galerieAttraits)
    {
            //$this->galerie_attraits[] = $galerieAttraits;
            if (!$this->galerie_attraits->contains($galerieAttraits)) {
                    $this->galerie_attraits->add($galerieAttraits);
            }
    }

    /**
     * Get galerie_attrraits
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getGalerieAttraits()
    {
            return $this->galerie_attraits;
    }


    public function __toString()
    {
            return $this->nom_fr;
            return $this->nom_en;
    }
    
	public function setLundiMatinEte($lundiMatinEte)
    {
        $this->lundi_matin_ete = $lundiMatinEte;
    }

    public function getLundiMatinEte()
    {
        return $this->lundi_matin_ete;
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
    
    public function setId()
    {
    	return;
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
     * Set page_facebook_fr
     *
     * @param string $pageFacebookFr
     */
    public function setPageFacebookFr($pageFacebookFr)
    {
        $this->page_facebook_fr = $pageFacebookFr;
    }

    /**
     * Get page_facebook_fr
     *
     * @return string 
     */
    public function getPageFacebookFr()
    {
        return $this->page_facebook_fr;
    }

    /**
     * Set page_facebook_en
     *
     * @param string $pageFacebookEn
     */
    public function setPageFacebookEn($pageFacebookEn)
    {
        $this->page_facebook_en = $pageFacebookEn;
    }

    /**
     * Get page_facebook_en
     *
     * @return string 
     */
    public function getPageFacebookEn()
    {
        return $this->page_facebook_en;
    }

    /**
     * Set texte_description_fr
     *
     * @param text $texteDescriptionFr
     */
    public function setTexteDescriptionFr($texteDescriptionFr)
    {
        $this->texte_description_fr = $texteDescriptionFr;
    }

    /**
     * Get texte_description_fr
     *
     * @return text 
     */
    public function getTexteDescriptionFr()
    {
        return $this->texte_description_fr;
    }

    /**
     * Set texte_description_en
     *
     * @param text $texteDescriptionEn
     */
    public function setTexteDescriptionEn($texteDescriptionEn)
    {
        $this->texte_description_en = $texteDescriptionEn;
    }

    /**
     * Get texte_description_en
     *
     * @return text 
     */
    public function getTexteDescriptionEn()
    {
        return $this->texte_description_en;
    }
    
    /**
     * Set texte_express_fr
     *
     * @param text $texteExpressFr
     */
    public function setTexteExpressFr($texteExpressFr)
    {
        $this->texte_express_fr = $texteExpressFr;
    }

    /**
     * Get texte_express_fr
     *
     * @return text 
     */
    public function getTexteExpressFr()
    {
        return $this->texte_express_fr;
    }

    /**
     * Set texte_express_en
     *
     * @param text $texteExpressEn
     */
    public function setTexteExpressEn($texteExpressEn)
    {
        $this->texte_express_en = $texteExpressEn;
    }

    /**
     * Get texte_express_en
     *
     * @return text 
     */
    public function getTexteExpressEn()
    {
        return $this->texte_express_en;
    }

    /**
     * Set date_debut
     *
     * @param text $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->date_debut = $dateDebut;
    }

    /**
     * Get date_debut
     *
     * @return text 
     */
    public function getDateDebut()
    {
        return $this->date_debut;
    }

    /**
     * Set date_fin
     *
     * @param text $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->date_fin = $dateFin;
    }

    /**
     * Get date_fin
     *
     * @return text 
     */
    public function getDateFin()
    {
        return $this->date_fin;
    }

    /**
     * Set emplacements_0_service_camping
     *
     * @param boolean $emplacements0ServiceCamping
     */
    public function setEmplacements0ServiceCamping($emplacements0ServiceCamping)
    {
        $this->emplacements_0_service_camping = $emplacements0ServiceCamping;
    }

    /**
     * Get emplacements_0_service_camping
     *
     * @return boolean 
     */
    public function getEmplacements0ServiceCamping()
    {
        return $this->emplacements_0_service_camping;
    }

    /**
     * Set emplacements_1_service_camping
     *
     * @param boolean $emplacements1ServiceCamping
     */
    public function setEmplacements1ServiceCamping($emplacements1ServiceCamping)
    {
        $this->emplacements_1_service_camping = $emplacements1ServiceCamping;
    }

    /**
     * Get emplacements_1_service_camping
     *
     * @return boolean 
     */
    public function getEmplacements1ServiceCamping()
    {
        return $this->emplacements_1_service_camping;
    }

    /**
     * Set emplacements_2_services_camping
     *
     * @param boolean $emplacements2ServicesCamping
     */
    public function setEmplacements2ServicesCamping($emplacements2ServicesCamping)
    {
        $this->emplacements_2_services_camping = $emplacements2ServicesCamping;
    }

    /**
     * Get emplacements_2_services_camping
     *
     * @return boolean 
     */
    public function getEmplacements2ServicesCamping()
    {
        return $this->emplacements_2_services_camping;
    }

    /**
     * Set emplacements_3_services_camping
     *
     * @param boolean $emplacements3ServicesCamping
     */
    public function setEmplacements3ServicesCamping($emplacements3ServicesCamping)
    {
        $this->emplacements_3_services_camping = $emplacements3ServicesCamping;
    }

    /**
     * Get emplacements_3_services_camping
     *
     * @return boolean 
     */
    public function getEmplacements3ServicesCamping()
    {
        return $this->emplacements_3_services_camping;
    }

    /**
     * Set approuve
     *
     * @param boolean $approuve
     */
    public function setApprouve($approuve)
    {
        $this->approuve = $approuve;
    }

    /**
     * Get approuve
     *
     * @return boolean 
     */
    public function getApprouve()
    {
        return $this->approuve;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    }

    /**
     * Get actif
     *
     * @return boolean 
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set express
     *
     * @param boolean $express
     */
    public function setExpress($express)
    {
        $this->express = $express;
    }

    /**
     * Get express
     *
     * @return boolean 
     */
    public function getExpress()
    {
        return $this->express;
    }

    /**
     * Set payant
     *
     * @param boolean $payant
     */
    public function setPayant($payant)
    {
        $this->payant = $payant;
    }

    /**
     * Get payant
     *
     * @return boolean 
     */
    public function getPayant()
    {
        return $this->payant;
    }

    /**
     * Set adresse_web_cliquable
     *
     * @param boolean $adresseWebCliquable
     */
    public function setAdresseWebCliquable($adresseWebCliquable)
    {
        $this->adresse_web_cliquable = $adresseWebCliquable;
    }

    /**
     * Get adresse_web_cliquable
     *
     * @return boolean 
     */
    public function getAdresseWebCliquable()
    {
        return $this->adresse_web_cliquable;
    }

    /**
     * Set nouveau_membre
     *
     * @param boolean $nouveauMembre
     */
    public function setNouveauMembre($nouveauMembre)
    {
        $this->nouveau_membre = $nouveauMembre;
    }

    /**
     * Get nouveau_membre
     *
     * @return boolean 
     */
    public function getNouveauMembre()
    {
        return $this->nouveau_membre;
    }

    /**
     * Set date_creation
     *
     * @param date $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->date_creation = $dateCreation;
    }

    /**
     * Get date_creation
     *
     * @return date 
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * Set meta_titre_fr
     *
     * @param string $metaTitreFr
     */
    public function setMetaTitreFr($metaTitreFr)
    {
        $this->meta_titre_fr = $metaTitreFr;
    }

    /**
     * Get meta_titre_fr
     *
     * @return string 
     */
    public function getMetaTitreFr()
    {
        return $this->meta_titre_fr;
    }

    /**
     * Set meta_titre_en
     *
     * @param string $metaTitreEn
     */
    public function setMetaTitreEn($metaTitreEn)
    {
        $this->meta_titre_en = $metaTitreEn;
    }

    /**
     * Get meta_titre_en
     *
     * @return string 
     */
    public function getMetaTitreEn()
    {
        return $this->meta_titre_en;
    }

    /**
     * Set metakeywords_fr
     *
     * @param string $metakeywordsFr
     */
    public function setMetakeywordsFr($metakeywordsFr)
    {
        $this->metakeywords_fr = $metakeywordsFr;
    }

    /**
     * Get metakeywords_fr
     *
     * @return string 
     */
    public function getMetakeywordsFr()
    {
        return $this->metakeywords_fr;
    }

    /**
     * Set metakeywords_en
     *
     * @param string $metakeywordsEn
     */
    public function setMetakeywordsEn($metakeywordsEn)
    {
        $this->metakeywords_en = $metakeywordsEn;
    }

    /**
     * Get metakeywords_en
     *
     * @return string 
     */
    public function getMetakeywordsEn()
    {
        return $this->metakeywords_en;
    }

    /**
     * Set metadescription_fr
     *
     * @param text $metadescriptionFr
     */
    public function setMetadescriptionFr($metadescriptionFr)
    {
        $this->metadescription_fr = $metadescriptionFr;
    }

    /**
     * Get metadescription_fr
     *
     * @return text 
     */
    public function getMetadescriptionFr()
    {
        return $this->metadescription_fr;
    }

    /**
     * Set metadescription_en
     *
     * @param text $metadescriptionEn
     */
    public function setMetadescriptionEn($metadescriptionEn)
    {
        $this->metadescription_en = $metadescriptionEn;
    }

    /**
     * Get metadescription_en
     *
     * @return text 
     */
    public function getMetadescriptionEn()
    {
        return $this->metadescription_en;
    }

    /**
     * Set optvisibilite_grande_photo
     *
     * @param boolean $optvisibiliteGrandePhoto
     */
    public function setOptvisibiliteGrandePhoto($optvisibiliteGrandePhoto)
    {
        $this->optvisibilite_grande_photo = $optvisibiliteGrandePhoto;
    }

    /**
     * Get optvisibilite_grande_photo
     *
     * @return boolean 
     */
    public function getOptvisibiliteGrandePhoto()
    {
        return $this->optvisibilite_grande_photo;
    }

    /**
     * Set optvisibilite_photo_categorie
     *
     * @param boolean $optvisibilitePhotoCategorie
     */
    public function setOptvisibilitePhotoCategorie($optvisibilitePhotoCategorie)
    {
        $this->optvisibilite_photo_categorie = $optvisibilitePhotoCategorie;
    }

    /**
     * Get optvisibilite_photo_categorie
     *
     * @return boolean 
     */
    public function getOptvisibilitePhotoCategorie()
    {
        return $this->optvisibilite_photo_categorie;
    }

    /**
     * Set optvisibilite_nos_suggestions
     *
     * @param boolean $optvisibiliteNosSuggestions
     */
    public function setOptvisibiliteNosSuggestions($optvisibiliteNosSuggestions)
    {
        $this->optvisibilite_nos_suggestions = $optvisibiliteNosSuggestions;
    }

    /**
     * Get optvisibilite_nos_suggestions
     *
     * @return boolean 
     */
    public function getOptvisibiliteNosSuggestions()
    {
        return $this->optvisibilite_nos_suggestions;
    }

    /**
     * Set optvisibilite_proximite
     *
     * @param boolean $optvisibiliteProximite
     */
    public function setOptvisibiliteProximite($optvisibiliteProximite)
    {
        $this->optvisibilite_proximite = $optvisibiliteProximite;
    }

    /**
     * Get optvisibilite_proximite
     *
     * @return boolean 
     */
    public function getOptvisibiliteProximite()
    {
        return $this->optvisibilite_proximite;
    }

    /**
     * Set optvisibilite_lien_hebergement
     *
     * @param boolean $optvisibiliteLienHebergement
     */
    public function setOptvisibiliteLienHebergement($optvisibiliteLienHebergement)
    {
        $this->optvisibilite_lien_hebergement = $optvisibiliteLienHebergement;
    }

    /**
     * Get optvisibilite_lien_hebergement
     *
     * @return boolean 
     */
    public function getOptvisibiliteLienHebergement()
    {
        return $this->optvisibilite_lien_hebergement;
    }

    /**
     * Set optvisibilite_incontournables
     *
     * @param boolean $optvisibiliteIncontournables
     */
    public function setOptvisibiliteIncontournables($optvisibiliteIncontournables)
    {
        $this->optvisibilite_incontournables = $optvisibiliteIncontournables;
    }

    /**
     * Get optvisibilite_incontournables
     *
     * @return boolean 
     */
    public function getOptvisibiliteIncontournables()
    {
        return $this->optvisibilite_incontournables;
    }

    /**
     * Add soins_sante_id
     *
     * @param MyApp\MobileBundle\Entity\Soins_sante $soinsSanteId
     */
    public function addSoins_sante(\MyApp\MobileBundle\Entity\Soins_sante $soinsSanteId)
    {
        $this->soins_sante_id[] = $soinsSanteId;
    }

    /**
     * Get soins_sante_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSoinsSanteId()
    {
        return $this->soins_sante_id;
    }

    /**
     * Add devise_id
     *
     * @param MyApp\MobileBundle\Entity\Devises $deviseId
     */
    public function addDevises(\MyApp\MobileBundle\Entity\Devises $deviseId)
    {
        $this->devise_id[] = $deviseId;
    }

    /**
     * Get devise_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDeviseId()
    {
        return $this->devise_id;
    }

    /**
     * Add cuisine_id
     *
     * @param MyApp\MobileBundle\Entity\Cuisines $cuisineId
     */
    public function addCuisines(\MyApp\MobileBundle\Entity\Cuisines $cuisineId)
    {
        $this->cuisine_id[] = $cuisineId;
    }

    /**
     * Get cuisine_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCuisineId()
    {
        return $this->cuisine_id;
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
     * Set qcs_festival_attrait_id
     *
     * @param MyApp\MobileBundle\Entity\Qcs_festival_attraits $qcsFestivalAttraitId
     */
    public function setQcsFestivalAttraitId(\MyApp\MobileBundle\Entity\Qcs_festival_attraits $qcsFestivalAttraitId)
    {
        $this->qcs_festival_attrait_id = $qcsFestivalAttraitId;
    }

    /**
     * Get qcs_festival_attrait_id
     *
     * @return MyApp\MobileBundle\Entity\Qcs_festival_attraits 
     */
    public function getQcsFestivalAttraitId()
    {
        return $this->qcs_festival_attrait_id;
    }

    /**
     * Add attrait_activite_id
     *
     * @param MyApp\MobileBundle\Entity\Attraits_activites $attraitActiviteId
     */
    public function addAttraits_activites(\MyApp\MobileBundle\Entity\Attraits_activites $attraitActiviteId)
    {
        $this->attrait_activite_id[] = $attraitActiviteId;
    }

    /**
     * Get attrait_activite_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitActiviteId()
    {
        return $this->attrait_activite_id;
    }


    /**
     * Get qcs_thematique_attrait_id
     *
     * @return MyApp\MobileBundle\Entity\Qcs_thematiques_attraits 
     */
    public function getQcsThematiqueAttraitId()
    {
        return $this->qcs_thematique_attrait_id;
    }

    /**
     * Set province_id
     *
     * @param MyApp\MobileBundle\Entity\Provinces_etats $provinceId
     */
    public function setProvinceId(\MyApp\MobileBundle\Entity\Provinces_etats $provinceId)
    {
        $this->province_id = $provinceId;
    }

    /**
     * Get province_id
     *
     * @return MyApp\MobileBundle\Entity\Provinces_etats 
     */
    public function getProvinceId()
    {
        return $this->province_id;
    }

    /**
     * Set region_id
     *
     * @param MyApp\MobileBundle\Entity\Regions $regionId
     */
    public function setRegionId(\MyApp\MobileBundle\Entity\Regions $regionId)
    {
        $this->region_id = $regionId;
    }

    /**
     * Get region_id
     *
     * @return MyApp\MobileBundle\Entity\Regions 
     */
    public function getRegionId()
    {
        return $this->region_id;
    }

    /**
     * Set ville_id
     *
     * @param MyApp\MobileBundle\Entity\Villes $villeId
     */
    public function setVilleId(\MyApp\MobileBundle\Entity\Villes $villeId)
    {
        $this->ville_id = $villeId;
    }

    /**
     * Get ville_id
     *
     * @return MyApp\MobileBundle\Entity\Villes 
     */
    public function getVilleId()
    {
        return $this->ville_id;
    }


    /**
     * Set periode_pour_attrait
     *
     * @param boolean $periodePourAttrait
     */
    public function setPeriodePourAttrait($periodePourAttrait)
    {
        $this->periode_pour_attrait = $periodePourAttrait;
    }

    /**
     * Get periode_pour_attrait
     *
     * @return boolean 
     */
    public function getPeriodePourAttrait()
    {
        return $this->periode_pour_attrait;
    }

    /**
     * Add type_soins_id
     *
     * @param MyApp\MobileBundle\Entity\Types_soins_sante $typeSoinsId
     */
    public function addTypes_soins_sante(\MyApp\MobileBundle\Entity\Types_soins_sante $typeSoinsId)
    {
        $this->type_soins_id[] = $typeSoinsId;
    }
    

    /**
     * Get type_soins_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTypeSoinsId()
    {
        return $this->type_soins_id;
    }

    /**
     * Set zone_id
     *
     * @param MyApp\MobileBundle\Entity\Zones $zoneId
     */
    public function setZoneId(\MyApp\MobileBundle\Entity\Zones $zoneId)
    {
        $this->zone_id = $zoneId;
    }

    /**
     * Get zone_id
     *
     * @return MyApp\MobileBundle\Entity\Zones 
     */
    public function getZoneId()
    {
        return $this->zone_id;
    }

    /**
     * Set hebergement_id
     *
     * @param MyApp\MobileBundle\Entity\Hebergements $hebergementId
     */
    public function setHebergementId(\MyApp\MobileBundle\Entity\Hebergements $hebergementId)
    {
        $this->hebergement_id = $hebergementId;
    }


    /**
     * Set adresse
     *
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set code_postal
     *
     * @param string $codePostal
     */
    public function setCodePostal($codePostal)
    {
        $this->code_postal = $codePostal;
    }

    /**
     * Get code_postal
     *
     * @return string 
     */
    public function getCodePostal()
    {
        return $this->code_postal;
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
     * Add qcs_thematique_attrait_id
     *
     * @param MyApp\MobileBundle\Entity\Qcs_thematiques_attraits $qcsThematiqueAttraitId
     */
    public function addQcs_thematiques_attraits(\MyApp\MobileBundle\Entity\Qcs_thematiques_attraits $qcsThematiqueAttraitId)
    {
        $this->qcs_thematique_attrait_id[] = $qcsThematiqueAttraitId;
    }

    /**
     * Set qcs_thematique_attrait_id
     *
     * @param MyApp\MobileBundle\Entity\Qcs_thematiques_attraits $qcsThematiqueAttraitId
     */
    public function setQcsThematiqueAttraitId(\MyApp\MobileBundle\Entity\Qcs_thematiques_attraits $qcsThematiqueAttraitId)
    {
        $this->qcs_thematique_attrait_id = $qcsThematiqueAttraitId;
    }

    /**
     * Add qcs_festival_attrait_id
     *
     * @param MyApp\MobileBundle\Entity\Qcs_festival_attraits $qcsFestivalAttraitId
     */
    public function addQcs_festival_attraits(\MyApp\MobileBundle\Entity\Qcs_festival_attraits $qcsFestivalAttraitId)
    {
        $this->qcs_festival_attrait_id[] = $qcsFestivalAttraitId;
    }

    /**
     * Add paiement_id
     *
     * @param MyApp\MobileBundle\Entity\Modes_paiements $paiementId
     */
    public function addModes_paiements(\MyApp\MobileBundle\Entity\Modes_paiements $paiementId)
    {
        $this->paiement_id[] = $paiementId;
    }

    /**
     * Get paiement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPaiementId()
    {
        return $this->paiement_id;
    }
   
    /**
     * Set twitter_fr
     *
     * @param string $twitterFr
     */
    public function setTwitterFr($twitterFr)
    {
        $this->twitter_fr = $twitterFr;
    }

    /**
     * Get twitter_fr
     *
     * @return string 
     */
    public function getTwitterFr()
    {
        return $this->twitter_fr;
    }

    /**
     * Set twitter_en
     *
     * @param string $twitterEn
     */
    public function setTwitterEn($twitterEn)
    {
        $this->twitter_en = $twitterEn;
    }

    /**
     * Get twitter_en
     *
     * @return string 
     */
    public function getTwitterEn()
    {
        return $this->twitter_en;
    }

    /**
     * Set google_plus_fr
     *
     * @param string $googlePlusFr
     */
    public function setGooglePlusFr($googlePlusFr)
    {
        $this->google_plus_fr = $googlePlusFr;
    }

    /**
     * Get google_plus_fr
     *
     * @return string 
     */
    public function getGooglePlusFr()
    {
        return $this->google_plus_fr;
    }

    /**
     * Set google_plus_en
     *
     * @param string $googlePlusEn
     */
    public function setGooglePlusEn($googlePlusEn)
    {
        $this->google_plus_en = $googlePlusEn;
    }

    /**
     * Get google_plus_en
     *
     * @return string 
     */
    public function getGooglePlusEn()
    {
        return $this->google_plus_en;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set telephone2
     *
     * @param string $telephone2
     */
    public function setTelephone2($telephone2)
    {
        $this->telephone2 = $telephone2;
    }

    /**
     * Get telephone2
     *
     * @return string 
     */
    public function getTelephone2()
    {
        return $this->telephone2;
    }

    /**
     * Set telephone_poste
     *
     * @param string $telephonePoste
     */
    public function setTelephonePoste($telephonePoste)
    {
        $this->telephone_poste = $telephonePoste;
    }

    /**
     * Get telephone_poste
     *
     * @return string 
     */
    public function getTelephonePoste()
    {
        return $this->telephone_poste;
    }

    /**
     * Set sans_frais
     *
     * @param string $sansFrais
     */
    public function setSansFrais($sansFrais)
    {
        $this->sans_frais = $sansFrais;
    }

    /**
     * Get sans_frais
     *
     * @return string 
     */
    public function getSansFrais()
    {
        return $this->sans_frais;
    }

    /**
     * Set telecopieur
     *
     * @param string $telecopieur
     */
    public function setTelecopieur($telecopieur)
    {
        $this->telecopieur = $telecopieur;
    }

    /**
     * Get telecopieur
     *
     * @return string 
     */
    public function getTelecopieur()
    {
        return $this->telecopieur;
    }

    /**
     * Set courriel
     *
     * @param string $courriel
     */
    public function setCourriel($courriel)
    {
        $this->courriel = $courriel;
    }

    /**
     * Get courriel
     *
     * @return string 
     */
    public function getCourriel()
    {
        return $this->courriel;
    }

    /**
     * Set siteweb
     *
     * @param string $siteweb
     */
    public function setSiteweb($siteweb)
    {
        $this->siteweb = $siteweb;
    }

    /**
     * Get siteweb
     *
     * @return string 
     */
    public function getSiteweb()
    {
        return $this->siteweb;
    }

    /**
     * Get videos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Add videos
     *
     * @param MyApp\MobileBundle\Entity\Videos $videos
     */
    public function addVideos(\MyApp\MobileBundle\Entity\Videos $videos)
    {
        $this->videos[] = $videos;
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
     * Set logo
     *
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set logo_doctrine
     *
     * @param string $logoDoctrine
     */
    public function setLogoDoctrine($logoDoctrine)
    {
        $this->logo_doctrine = $logoDoctrine;
    }

    /**
     * Get logo_doctrine
     *
     * @return string 
     */
    public function getLogoDoctrine()
    {
        return $this->logo_doctrine;
    }

    /**
     * Set capacite
     *
     * @param integer $capacite
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;
    }

    /**
     * Get capacite
     *
     * @return integer 
     */
    public function getCapacite()
    {
        return $this->capacite;
    }

    /**
     * Set tarif_attrait
     *
     * @param float $tarifAttrait
     */
    public function setTarifAttrait($tarifAttrait)
    {
        $this->tarif_attrait = $tarifAttrait;
    }

    /**
     * Get tarif_attrait
     *
     * @return float 
     */
    public function getTarifAttrait()
    {
        return $this->tarif_attrait;
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
     * Set photo_payante
     *
     * @param string $photoPayante
     */
    public function setPhotoPayante($photoPayante)
    {
        $this->photo_payante = $photoPayante;
    }

    /**
     * Get photo_payante
     *
     * @return string 
     */
    public function getPhotoPayante()
    {
        return $this->photo_payante;
    }

    /**
     * Set photo_payante_doctrine
     *
     * @param string $photoPayanteDoctrine
     */
    public function setPhotoPayanteDoctrine($photoPayanteDoctrine)
    {
        $this->photo_payante_doctrine = $photoPayanteDoctrine;
    }

    /**
     * Get photo_payante_doctrine
     *
     * @return string 
     */
    public function getPhotoPayanteDoctrine()
    {
        return $this->photo_payante_doctrine;
    }

    /**
     * Set valider_par
     *
     * @param string $validerPar
     */
    public function setValiderPar($validerPar)
    {
        $this->valider_par = $validerPar;
    }

    /**
     * Get valider_par
     *
     * @return string 
     */
    public function getValiderPar()
    {
        return $this->valider_par;
    }

    /**
     * Add coupon_id
     *
     * @param MyApp\MobileBundle\Entity\Coupons $couponId
     */
    public function addCoupons(\MyApp\MobileBundle\Entity\Coupons $couponId)
    {
        $this->coupon_id[] = $couponId;
    }

    /**
     * Get coupon_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCouponId()
    {
        return $this->coupon_id;
    }

    /**
     * Set politique_annulation_fr
     *
     * @param text $politiqueAnnulationFr
     */
    public function setPolitiqueAnnulationFr($politiqueAnnulationFr)
    {
        $this->politique_annulation_fr = $politiqueAnnulationFr;
    }

    /**
     * Get politique_annulation_fr
     *
     * @return text 
     */
    public function getPolitiqueAnnulationFr()
    {
        return $this->politique_annulation_fr;
    }

    /**
     * Set politique_annulation_en
     *
     * @param text $politiqueAnnulationEn
     */
    public function setPolitiqueAnnulationEn($politiqueAnnulationEn)
    {
        $this->politique_annulation_en = $politiqueAnnulationEn;
    }

    /**
     * Get politique_annulation_en
     *
     * @return text 
     */
    public function getPolitiqueAnnulationEn()
    {
        return $this->politique_annulation_en;
    }

    /**
     * Set politique_tarif_fr
     *
     * @param text $politiqueTarifFr
     */
    public function setPolitiqueTarifFr($politiqueTarifFr)
    {
        $this->politique_tarif_fr = $politiqueTarifFr;
    }

    /**
     * Get politique_tarif_fr
     *
     * @return text 
     */
    public function getPolitiqueTarifFr()
    {
        return $this->politique_tarif_fr;
    }

    /**
     * Set politique_tarif_en
     *
     * @param text $politiqueTarifEn
     */
    public function setPolitiqueTarifEn($politiqueTarifEn)
    {
        $this->politique_tarif_en = $politiqueTarifEn;
    }

    /**
     * Get politique_tarif_en
     *
     * @return text 
     */
    public function getPolitiqueTarifEn()
    {
        return $this->politique_tarif_en;
    }

    /**
     * Add galerie_attraits
     *
     * @param MyApp\MobileBundle\Entity\Galerie_attraits $galerieAttraits
     */
    public function addGalerie_attraits(\MyApp\MobileBundle\Entity\Galerie_attraits $galerieAttraits)
    {
        $this->galerie_attraits[] = $galerieAttraits;
    }

    /**
     * Add attrait_service_id
     *
     * @param MyApp\MobileBundle\Entity\Attraits_services $attraitServiceId
     */
    public function addAttraits_services(\MyApp\MobileBundle\Entity\Attraits_services $attraitServiceId)
    {
        $this->attrait_service_id[] = $attraitServiceId;
    }

    /**
     * Get attrait_service_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitServiceId()
    {
        return $this->attrait_service_id;
    }

    /**
     * Set afficher_restaurant
     *
     * @param boolean $afficherRestaurant
     */
    public function setAfficherRestaurant($afficherRestaurant)
    {
        $this->afficher_restaurant = $afficherRestaurant;
    }

    /**
     * Get afficher_restaurant
     *
     * @return boolean 
     */
    public function getAfficherRestaurant()
    {
        return $this->afficher_restaurant;
    }

    /**
     * Set utilisateur
     *
     * @param MyApp\MobileBundle\Entity\Utilisateur $utilisateur
     */
    public function setUtilisateur(\MyApp\MobileBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;
    }

    /**
     * Get utilisateur
     *
     * @return MyApp\MobileBundle\Entity\Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set cotation_id
     *
     * @param MyApp\MobileBundle\Entity\Cotations $cotationId
     */
    public function setCotationId(\MyApp\MobileBundle\Entity\Cotations $cotationId)
    {
        $this->cotation_id = $cotationId;
    }

    /**
     * Get cotation_id
     *
     * @return MyApp\MobileBundle\Entity\Cotations 
     */
    public function getCotationId()
    {
        return $this->cotation_id;
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
     * Add qcs_echo_attrait_id
     *
     * @param MyApp\MobileBundle\Entity\Qcs_echos_attraits $qcsEchoAttraitId
     */
    public function addQcs_echos_attraits(\MyApp\MobileBundle\Entity\Qcs_echos_attraits $qcsEchoAttraitId)
    {
        $this->qcs_echo_attrait_id[] = $qcsEchoAttraitId;
    }

    /**
     * Get qcs_echo_attrait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsEchoAttraitId()
    {
        return $this->qcs_echo_attrait_id;
    }

    /**
     * Set texte_resume_fr
     *
     * @param text $texteResumeFr
     */
    public function setTexteResumeFr($texteResumeFr)
    {
        $this->texte_resume_fr = $texteResumeFr;
    }

    /**
     * Get texte_resume_fr
     *
     * @return text 
     */
    public function getTexteResumeFr()
    {
        return $this->texte_resume_fr;
    }

    /**
     * Set texte_resume_en
     *
     * @param text $texteResumeEn
     */
    public function setTexteResumeEn($texteResumeEn)
    {
        $this->texte_resume_en = $texteResumeEn;
    }

    /**
     * Get texte_resume_en
     *
     * @return text 
     */
    public function getTexteResumeEn()
    {
        return $this->texte_resume_en;
    }

    /**
     * Add distance_id
     *
     * @param MyApp\MobileBundle\Entity\Distances_attraits $distanceId
     */
    public function addDistances(\MyApp\MobileBundle\Entity\Distances_attraits $distanceId)
    {
        $this->distance_id[] = $distanceId;
    }

    /**
     * Get distance_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDistanceId()
    {
        return $this->distance_id;
    }

    /**
     * Get video_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVideoId()
    {
        return $this->video_id;
    }

    /**
     * Add distance_id
     *
     * @param MyApp\MobileBundle\Entity\Distances_attraits $distanceId
     */
    public function addDistances_attraits(\MyApp\MobileBundle\Entity\Distances_attraits $distanceId)
    {
        $this->distance_id[] = $distanceId;
    }


    /**
     * Add categorie_attrait
     *
     * @param MyApp\MobileBundle\Entity\Attraits_categories $categorieAttrait
     */
    public function addAttraits_categories(\MyApp\MobileBundle\Entity\Attraits_categories $categorieAttrait)
    {
        $this->categorie_attrait[] = $categorieAttrait;
    }

    /**
     * Get categorie_attrait
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategorieAttrait()
    {
        return $this->categorie_attrait;
    }
}