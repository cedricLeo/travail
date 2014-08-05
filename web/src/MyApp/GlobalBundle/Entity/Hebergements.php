<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\GlobalBundle\Entity\Galerie_hebergement;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\HebergementsRepository")
 * @ORM\Table(name = "hebergements", indexes={@ORM\index(name="hebergement_idx", columns={"id", "province_id", "region_id", "ville_id", "repertoire_fr", "repertoire_en", "actif", "aprouver",  "nom_fr"})})
 * @ORM\HasLifecycleCallbacks
 */
class Hebergements{
	
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Forfaits", inversedBy = "Hebergements", cascade={"peresist"})
	 * 
	 * @var ArrayCollection $forfait_id
	 */
	private $forfait_id;
	
	/**
	 * @ORM\Column(type = "string", length = 100, nullable="false")
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 100, nullable="false")
	 * 
	 * @var string $nom_en
	 */
	private $nom_en;
	
	/**
	 * @ORM\Column(type = "string", length = 100, nullable = "true")
	 * 
	 * @var string $nom_abrege_fr
	 */
	private $nom_abrege_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 100, nullable = "true")
	 * 
	 * @var string $nom_abrege_en
	 */
	private $nom_abrege_en;
	
	/**
	 * @ORM\Column(type = "string", length = 150, nullable="false")
	 * 
	 * @var string $adresse
	 */
	private $adresse;
	
	/**
	 * @ORM\Column(type = "string", length = 7, nullable="false")
	 * 
	 * @var string $code_postal
	 */
	private $code_postal;
	
	/**
	 * @ORM\Column(type = "string", length = 18, nullable="false")
	 * 
	 * @var string $telephone
	 */
	private $telephone;
	
	/**
	 * @ORM\Column(type = "string", length = 18, nullable = "true")
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
	 * @ORM\Column(type = "string", length = 18, nullable = "true")
	 * 
	 * @var sstring $telecopieur
	 */
	private $telecopieur;
	
	/**
	 * @ORM\Column(type = "string", length = 20, nullable = "true")
	 * 
	 * @var string $sans_frais
	 */
	private $sans_frais;
	
	/**
	 * @ORM\Column(type = "string", length = 100, nullable = "true")
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
	 * @ORM\Column(type = "string", length = 100, nullable = true)
	 *
	 * @var string $email_corporatif
	 */
	private $email_corporatif;
	
	/**
	 * @ORM\Column(type = "string", length = 10, nullable = "true")
	 *
	 * @var string $paiement_id
	 */
	private $paiement_id;
	
	/**
	 * @ORM\Column(type = "float", nullable = "true")
	 * 
	 * @var float $latitude
	 */
	private $latitude;
	
	/**
	 * @ORM\Column(type = "float", nullable = "true")
	 * 
	 * @var float $longitude
	 */
	private $longitude;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "true")
	 *
	 * @var string $valider_par
	 */
	private $valider_par;
	
	/**
	 * @ORM\Column(type = "integer", length = 10, nullable = "true")
	 * 
	 * @var integer $reservit_id
	 */
	private $reservit_id;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 * 
	 * @var boolean $actif
	 */
	private $actif;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 * 
	 * @var boolean $etablissement_saisonnier
	 */
	private $etablissement_saisonnier;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 * 
	 * @var boolean $adsense
	 */
	private $adsense;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 * 
	 * @var boolean $corporatif
	 */
	private $corporatif;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 * 
	 * @var boolean $tarif_preferentiel
	 */
	private $tarif_preferentiel;
	
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
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 * 
	 * @var string $meta_keywords_fr
	 */
	private $meta_keywords_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 * 
	 * @var string $meta_keywords_en
	 */
	private $meta_keywords_en;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $meta_description_fr
	 */
	private $meta_description_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $meta_description_en
	 */
	private $meta_description_en;
	
	/**
	 * @ORM\Column(type = "string", nullable = "true", length = 15)
	 * 
	 * @var string $date_debut_saisonnier
	 */
	private $date_debut_saisonnier;
	
	/**
	 * @ORM\Column(type = "string", nullable = "true", length = 15)
	 * 
	 * @var string $date_fin_saisonnier
	 */
	private $date_fin_saisonnier;
	
	/**
	 * @ORM\Column(type = "integer", length = 2, nullable = "true")
	 * 
	 * @var integer $nombre_chambres_chalets
	 */
	private $nombre_chambres_chalets;
	
	/**
	 * @ORM\Column(type = "string", length = 10, nullable = "true")
	 * 
	 * @var string $nombre_etages
	 */
	private $nombre_etages;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "true")
	 * 
	 * @var string $checkin
	 */
	private $checkin;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "true")
	 * 
	 * @var string $checkout
	 */
	private $checkout;
	
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
	 * @var boolean $optvisibilite_criteres_semblables
	 */
	private $optvisibilite_criteres_semblables;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 * 
	 * @var boolean $optvisibilite_nouveautes
	 */
	private $optvisibilite_nouveautes;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 * 
	 * @var boolean $optvisibilite_incontournables
	 */
	private $optvisibilite_incontournables;
	
	/**
	 * @ORM\Column(type = "date", nullable = "true")
	 * 
	 * @var date $date_creation
	 */
	private $date_creation;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 *
	 * @var boolean $referencement_payant
	 */
	private $referencement_payant;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 *
	 * @var boolean $referencement_mini_site_update_souvent
	 */
	private $referencement_mini_site_update_souvent;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Devises", inversedBy="Hebergements", cascade={"persist"})
	 * 
	 * @var ArrayCollection $devise_id
	 */
	private $devise_id;	
	
	/**
	 * @ORM\OneToMany(targetEntity="Attraits", mappedBy="Hebergements", fetch="EXTRA_LAZY")
	 *
	 * @var integer $attrait_id
	 */
	private $attrait_id;
	
	/**
	 * @ORM\OneToMany(targetEntity="Temporaire_attraits", mappedBy="Hebergements", fetch="EXTRA_LAZY")
	 *
	 * @var integer $temporaire_attrait_id
	 */
	private $temporaire_attrait_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Equipements", inversedBy="Hebergements")
	 *
	 * @var ArrayCollection $hebergement_equipement_id
	 */
	private $hebergement_equipement_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Modes_paiements", inversedBy="Hebergements")
	 *
	 * @var ArrayCollection $hebergement_paiements_id
	 */
	private $hebergement_paiements_id;
	
	/**
	 * @ORM\OneToMany(targetEntity="Hebergements_salles_corporatives", mappedBy="Hebergements", fetch="EXTRA_LAZY", cascade={"persist", "remove"})
	 * 
	 * @var integer $salles_corpo_id
	 */
	private $salles_corpo_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Affiliations", inversedBy="Hebergements")
	 * 
	 * @var integer $affiliation_id
	 */
	private $affiliation_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Acomptes", inversedBy="Hebergements", cascade={"persist"})
	 * 
	 */
	private $acompte_id;
	
	/**
	 * @ORM\OneToOne(targetEntity="Qcs_forfaits", inversedBy="Hebergements")
	 * @ORM\JoinColumn(name = "qcs_forfait_id", referencedColumnName = "id")
	 *
	 * @var integer $qcs_forfait_id
	 */
	private $qcs_forfait_id;
	
	/**
	 * @ORM\OneToOne(targetEntity="Qcs_echos_hebergements", inversedBy="Hebergements")
	 * @ORM\JoinColumn(name = "qcs_echo_hebergement_id", referencedColumnName = "id")
	 *
	 * @var integer $qcs_echo_hebergement_id
	 */
	private $qcs_echo_hebergement_id;
	
	/**
	 * @ORM\OneToMany(targetEntity="Qcs_concours", mappedBy="Hebergements")
	 * 
	 * @var integer $qcs_concour_id
	 */
	private $qcs_concour_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Hebergements_services", inversedBy="Hebergements")
	 *
	 * @var ArrayCollection $hebergement_service_id
	 */
	private $hebergement_service_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Styles_hebergements", inversedBy="Hebergements")
	 *
	 * @var ArrayCollection $style_hebergement_id
	 */
	private $style_hebergement_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Categories_hebergements", inversedBy="Hebergements")
	 * 
	 * @var ArrayCollection $categorie_hebergement_id
	 */
	private $categorie_hebergement_id;
	
	/**
	 * @ORM\OneToOne(targetEntity = "Qcs_thematiques_hebergements", inversedBy = "Hebergements")
	 * @ORM\JoinColumn(name = "qcs_thematiques_hebergement_id", referencedColumnName = "id")
	 *
	 * @var integer $qcs_thematiques_hebergement_id
	 */
	private $qcs_thematiques_hebergement_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Provinces_etats", inversedBy = "Hebergements")
	 * @ORM\JoinColumn(name = "province_id", referencedColumnName = "id")
	 * 
	 * @var integer $province_id
	 */
	private $province_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Regions", inversedBy = "Hebergements")
	 * @ORM\JoinColumn(name = "region_id", referencedColumnName = "id")
	 * 
	 * @var integer $region_id
	 */
	private $region_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Zones", inversedBy = "Hebergements")
	 * @ORM\JoinColumn(name = "zone_id", referencedColumnName = "id")
	 *
	 * @var integer $zone_id
	 */
	private $zone_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Villes", inversedBy = "Hebergements")
	 * @ORM\JoinColumn(name = "ville_id", referencedColumnName = "id")
	 *
	 * @var integer $ville_id
	 */
	private $ville_id;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Videos", mappedBy = "Hebergements", fetch="EXTRA_LAZY")
	 * 
	 * @var integer $video_id
	 */
	private $video_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Cotations", inversedBy = "Hebergements")
	 *
	 * @var integer $cotation_id
	 */
	private $cotation_id;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 *
	 * @var string $facebook_fr
	 */
	private $facebook_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 *
	 * @var string $facebook_en
	 */
	private $facebook_en;
	
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
	 * @ORM\Column(type = "boolean", nullable = "true")
	 *
	 * @var boolean $aprouver
	 */
	private $aprouver;
	
	/**
	 * @ORM\Column(type = "string", nullable = "true")
	 *
	 * @var string $photo_payante
	 */
	private $photo_payante;
	
	/**
	 * @ORM\Column(type = "string", nullable = "true")
	 *
	 * @var string $photo_categorie_payante
	 */
	private $photo_categorie_payante;
	
	/**
	 * @ORM\Column(type = "string", nullable = "true")
	 *
	 * @var string $photo_payante_doctrine
	 */
	private $photo_payante_doctrine;
	
	/**
	 * @ORM\Column(type = "string", nullable = "true")
	 *
	 * @var string $photo_categorie_payante_doctrine
	 */
	private $photo_categorie_payante_doctrine;
	
	/**
	 * @ORM\Column(type = "string", length="8", nullable = "true")
	 *
	 * @var string $prix_a_partir
	 */
	private $prix_a_partir;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable= false)
	 *
	 * @var string $repertoire_fr
	 */
	private $repertoire_fr;
	
	/**
	 * @ORM\Column(type = "string", length = "255", nullable = false)
	 *
	 * @var string $repertoire_en
	 */
	private $repertoire_en;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Hebergements_activites")
	 *
	 * @var ArrayCollection $hebergement_activite_id
	 */
	private $hebergement_activite_id;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Chambres", mappedBy="Hebergements" )
	 *
         * @var integer $chambre_hebergement_id
	 */
	private $chambre_hebergement_id;
	
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
	
	/**
	 * @ORM\Column(type = "string", length = "100", nullable = "true")
	 *
	 * @var string $logo
	 */
	private $logo;
	
	/**
	 * @ORM\Column(type = "string", length = "100", nullable = "true")
	 *
	 * @var string $logo_doctrine
	 */
	private $logo_doctrine;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Classifications", inversedBy="Hebergements", cascade={"persist"})
	 *
	 * @var integer $classification_id
	 */
	private $classification_id;
	
	/**
	 * @ORM\Column(type = "string", length = "100", nullable = "true")
	 *
	 * @var string $classification
	 */
	private $classification;
	
	/**
	 * @ORM\OneToMany(targetEntity="Forfaits_clients", mappedBy = "Hebergements")
	 *
	 * @var integer $hebergement_forfait_client_id
	 */
	private $hebergement_forfait_client_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Galerie_hebergement", inversedBy="Hebergements", cascade={"persist", "remove"})
	 *
	 * @var ArrayCollection $galerie_hebergement
	 */
	private $galerie_hebergement;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Calendrier_saison", inversedBy="Hebergements", cascade={"persist", "remove"})
	 *
	 * @var ArrayCollection $calendrier
	 */
	private $calendrier;
	
	/**
	 * @ORM\OneToMany(targetEntity="Distances", mappedBy = "Hebergements", cascade={"persist"})
	 *
	 * @var integer $distance_id
	 */
	private $distance_id;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 *
	 * @var boolean $saisonnier
	 */
	private $saisonnier;
	
	/**
	 * @ORM\Column(type = "string", length = 4, nullable = "true")
	 *
	 * @var string $nombre_chambre
	 */
	private $nombre_chambre;
	
	/**
        * @ORM\ManyToOne(targetEntity="MyApp\GlobalBundle\Entity\Politique_fr", cascade={"persist", "remove"})
        */
	private $politique_hebergement_fr;
	
	/**
	 * @ORM\ManyToOne(targetEntity="MyApp\GlobalBundle\Entity\Politique_en", cascade={"persist"})
	 */
	private $politique_hebergement_en;
	
	/**
	 * @ORM\ManyToOne(targetEntity="MyApp\GlobalBundle\Entity\Description_fr", cascade={"persist"})
	 */
	private $description_hebergement_fr;
	
	/**
	 * @ORM\ManyToOne(targetEntity="MyApp\GlobalBundle\Entity\Description_en", cascade={"persist"})
	 */
	private $description_hebergement_en;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="Hebergements")
	 */
	private $utilisateur;
	
	public function __construct()
	{
		$this->forfait_id 					= new ArrayCollection();
		$this->devise_id 					= new ArrayCollection();
		$this->hebergement_activite_id  			= new ArrayCollection();
		$this->hebergement_equipement_id 			= new ArrayCollection();
		$this->hebergement_paiements_id 			= new ArrayCollection();
		$this->hebergement_service_id 				= new ArrayCollection();
		$this->style_hebergement_id 				= new ArrayCollection();	
		$this->galerie_hebergement 				= new ArrayCollection();
		$this->categorie_hebergement_id                         = new ArrayCollection();
		$this->calendrier                                       = new ArrayCollection();
	}
	
	public function __toString() {
		return $this->nom_fr;
		return $this->nom_en;
	}
	
	public function setPolitiqueHebergementFr(Politique_fr $politique = null)
	{
		$this->politique_hebergement_fr = $politique;
	}
	
	public function getPolitiqueHebergementFr()
	{
		return $this->politique_hebergement_fr;
	}
	
	public function setPolitiqueHebergementEn(Politique_en $politique = null)
	{
		$this->politique_hebergement_en = $politique;
	}
	
	public function getPolitiqueHebergementEn()
	{
		return $this->politique_hebergement_en;
	}
	
	public function setDescriptionHebergementFr(Description_fr $description = null)
	{
		$this->description_hebergement_fr = $description;
	}
	
	public function getDescriptionHebergementFr()
	{
		return $this->description_hebergement_fr;
	}
	
	public function setDescriptionHebergementEn(Description_en $description = null)
	{
		$this->description_hebergement_en = $description;
	}
	
	public function getDescriptionHebergementEn()
	{
		return $this->description_hebergement_en;
	}
	
	public function getFullPhotoPayantePath() {
		return null === $this->photo_payante ? null : $this->getUploadRootDirPhotoPayante(). $this->photo_payante;
	}
	
	public function getFullPhotoCategoriePayantePath() {
		return null === $this->photo_categorie_payante ? null : $this->getUploadRootDirPhotoCategoriePayante(). $this->photo_categorie_payante;
	}
	
	public function getFullLogoPath() {
		return null === $this->logo ? null : $this->getUploadRootDirLogo(). $this->logo;
	}
	
	protected function getUploadRootDirPhotoPayante() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDirPhotoPayante().$this->getId()."/";
	}
	
	protected function getUploadRootDirPhotoCategoriePayante() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDirPhotoCategoriePayante().$this->getId()."/";
	}
	
	protected function getUploadRootDirLogo() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDirLogo().$this->getId()."/";
	}
	
	protected function getTmpUploadRootDirPhotoPayante() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/hebergement/photo_payante/photo_payante';
	}
	
	protected function getTmpUploadRootDirPhotoCategoriePayante() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/hebergement/photo_categorie_payante/photo_categorie_payante';
	}
	
	protected function getTmpUploadRootDirLogo() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/hebergement/logos/logo';
	}
        
        public function getRepertoireImageHebergement($type){
            
            if($type == "imgprincipale"){
               return $this->getUploadRootDirPhotoPayante();
            }elseif( $type == "imgcategorie"){
               return $this->getUploadRootDirPhotoCategoriePayante();
            }elseif($type == "imglogo"){
               return getUploadRootDirLogo(); 
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
                        $this->photo_payante->move($this->getTmpUploadRootDirPhotoPayante(), $this->photo_payante->getClientOriginalName());
                }else{ 
               
                    if(is_object($this->photo_payante)){
                        $this->photo_payante->move($this->getUploadRootDirPhotoPayante(), $this->photo_payante->getClientOriginalName());        
                    }
                    if(is_object($this->photo_categorie_payante)){
                        $this->photo_categorie_payante->move($this->getUploadRootDirPhotoCategoriePayante(), $this->photo_categorie_payante->getClientOriginalName());
                    }
                    if(is_object($this->logo)){
                        $this->logo->move($this->getUploadRootDirLogo(), $this->logo->getClientOriginalName());
                    }
                }
                if(is_object($this->photo_payante)){
                    $this->setPhotoPayante($this->photo_payante->getClientOriginalName());
                }
                if(is_object($this->photo_categorie_payante)){
                    $this->setPhotoCategoriePayante($this->photo_categorie_payante->getClientOriginalName());
                }
                if(is_object($this->logo)){
                    $this->setLogo($this->logo->getClientOriginalName());
                }
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function uploadPhotoCategoriePayante() {
		// the file property can be empty if the field is not required
		if (null === $this->photo_categorie_payante) {
			return;
		}
		if(!$this->id){
			$this->photo_categorie_payante->move($this->getTmpUploadRootDirPhotoCategoriePayante(), $this->photo_categorie_payante->getClientOriginalName());
		}else{
                        if(is_object($this->photo_categorie_payante)){
                            $this->photo_categorie_payante->move($this->getUploadRootDirPhotoCategoriePayante(), $this->photo_categorie_payante->getClientOriginalName());
                        }
		}
                if(is_object($this->photo_categorie_payante)){
                    $this->setPhotoCategoriePayante($this->photo_categorie_payante->getClientOriginalName());
                }
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	private function uploadLogo() {
		// the file property can be empty if the field is not required
		if (null === $this->logo) {
			return;
		}
		if(!$this->id){
			$this->logo->move($this->getTmpUploadRootDirLogo(), $this->logo->getClientOriginalName());
		}else{
                     if(is_object($this->logo)){
                            $this->logo->move($this->getUploadRootDirLogo(), $this->logo->getClientOriginalName());
                     }
		}
                if(is_object($this->logo)){
                    $this->setLogo($this->logo->getClientOriginalName());
                }
	}
	
	/**
	 * @ORM\PostPersist()
	 */
	public function movePhotoPayante()
	{
		if (null === $this->photo_payante) {
			return;
		}
		if(!is_dir($this->getUploadRootDirPhotoPayante())){
			mkdir($this->getUploadRootDirPhotoPayante());
		}
		copy($this->getTmpUploadRootDirPhotoPayante().$this->photo_payante, $this->getFullPhotoPayantePath());
		unlink($this->getTmpUploadRootDirPhotoPayante().$this->photo_payante);
	}
	
	/**
	 * @ORM\PostPersist()
	 */
	public function movePhotoCategoriePayante()
	{
		if (null === $this->photo_categorie_payante) {
			return;
		}
		if(!is_dir($this->getUploadRootDirPhotoCategoriePayante())){
			mkdir($this->getUploadRootDirPhotoCategoriePayante());
		}
		copy($this->getTmpUploadRootDirPhotoCategoriePayante().$this->photo_categorie_payante, $this->getFullPhotoCategoriePayantePath());
		unlink($this->getTmpUploadRootDirPhotoCategoriePayante().$this->photo_categorie_payante);
	}
	
	/**
	 * @ORM\PostPersist()
	 */
	private function moveLogo()
	{
		if (null === $this->logo) {
			return;
		}
		if(!is_dir($this->getUploadRootDirLogo())){
			mkdir($this->getUploadRootDirLogo());
		}
		copy($this->getTmpUploadRootDirLogo().$this->logo, $this->getFullLogoPath());
		unlink($this->getTmpUploadRootDirLogo().$this->logo);
	}

	
	/**
	 * @ORM\PreRemove()
	 */
	private function removePhotoPayante()
	{
		if($this->getFullPhotoPayantePath() != null){
			unlink($this->getFullPhotoPayantePath());
			rmdir($this->getUploadRootDirPhotoPayante());
		}
	}
	
	/**
	 * @ORM\PreRemove()
	 */
	private function removeLogo()
	{
		if($this->getFullLogoPath()){
			unlink($this->getFullLogoPath());
			rmdir($this->getUploadRootDirLogo());
		}
	}
	
	/**
	 * @ORM\PreRemove()
	 */
	private function removePhotoCategoriePayante()
	{
		if($this->getFullPhotoCategoriePayantePath()){
			unlink($this->getFullPhotoCategoriePayantePath());
			rmdir($this->getUploadRootDirPhotoCategoriePayante());
		}
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
     * Set nom_abrege_fr
     *
     * @param string $nomAbregeFr
     */
    public function setNomAbregeFr($nomAbregeFr)
    {
        $this->nom_abrege_fr = $nomAbregeFr;
    }

    /**
     * Get nom_abrege_fr
     *
     * @return string 
     */
    public function getNomAbregeFr()
    {
        return $this->nom_abrege_fr;
    }

    /**
     * Set nom_abrege_en
     *
     * @param string $nomAbregeEn
     */
    public function setNomAbregeEn($nomAbregeEn)
    {
        $this->nom_abrege_en = $nomAbregeEn;
    }

    /**
     * Get nom_abrege_en
     *
     * @return string 
     */
    public function getNomAbregeEn()
    {
        return $this->nom_abrege_en;
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
     * Set etablissement_saisonnier
     *
     * @param boolean $etablissementSaisonnier
     */
    public function setEtablissementSaisonnier($etablissementSaisonnier)
    {
        $this->etablissement_saisonnier = $etablissementSaisonnier;
    }

    /**
     * Get etablissement_saisonnier
     *
     * @return boolean 
     */
    public function getEtablissementSaisonnier()
    {
        return $this->etablissement_saisonnier;
    }

    /**
     * Set adsense
     *
     * @param boolean $adsense
     */
    public function setAdsense($adsense)
    {
        $this->adsense = $adsense;
    }

    /**
     * Get adsense
     *
     * @return boolean 
     */
    public function getAdsense()
    {
        return $this->adsense;
    }

    /**
     * Set corporatif
     *
     * @param boolean $corporatif
     */
    public function setCorporatif($corporatif)
    {
        $this->corporatif = $corporatif;
    }

    /**
     * Get corporatif
     *
     * @return boolean 
     */
    public function getCorporatif()
    {
        return $this->corporatif;
    }

    /**
     * Set tarif_preferentiel
     *
     * @param boolean $tarifPreferentiel
     */
    public function setTarifPreferentiel($tarifPreferentiel)
    {
        $this->tarif_preferentiel = $tarifPreferentiel;
    }

    /**
     * Get tarif_preferentiel
     *
     * @return boolean 
     */
    public function getTarifPreferentiel()
    {
        return $this->tarif_preferentiel;
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
     * Set meta_keywords_fr
     *
     * @param string $metaKeywordsFr
     */
    public function setMetaKeywordsFr($metaKeywordsFr)
    {
        $this->meta_keywords_fr = $metaKeywordsFr;
    }

    /**
     * Get meta_keywords_fr
     *
     * @return string 
     */
    public function getMetaKeywordsFr()
    {
        return $this->meta_keywords_fr;
    }

    /**
     * Set meta_keywords_en
     *
     * @param string $metaKeywordsEn
     */
    public function setMetaKeywordsEn($metaKeywordsEn)
    {
        $this->meta_keywords_en = $metaKeywordsEn;
    }

    /**
     * Get meta_keywords_en
     *
     * @return string 
     */
    public function getMetaKeywordsEn()
    {
        return $this->meta_keywords_en;
    }

    /**
     * Set meta_description_fr
     *
     * @param text $metaDescriptionFr
     */
    public function setMetaDescriptionFr($metaDescriptionFr)
    {
        $this->meta_description_fr = $metaDescriptionFr;
    }

    /**
     * Get meta_description_fr
     *
     * @return text 
     */
    public function getMetaDescriptionFr()
    {
        return $this->meta_description_fr;
    }

    /**
     * Set meta_description_en
     *
     * @param text $metaDescriptionEn
     */
    public function setMetaDescriptionEn($metaDescriptionEn)
    {
        $this->meta_description_en = $metaDescriptionEn;
    }

    /**
     * Get meta_description_en
     *
     * @return text 
     */
    public function getMetaDescriptionEn()
    {
        return $this->meta_description_en;
    }

    /**
     * Set date_debut_saisonnier
     *
     * @param string $dateDebutSaisonnier
     */
    public function setDateDebutSaisonnier($dateDebutSaisonnier)
    {
        $this->date_debut_saisonnier = $dateDebutSaisonnier;
    }

    /**
     * Get date_debut_saisonnier
     *
     * @return string 
     */
    public function getDateDebutSaisonnier()
    {
        return $this->date_debut_saisonnier;
    }

    /**
     * Set date_fin_saisonnier
     *
     * @param string $dateFinSaisonnier
     */
    public function setDateFinSaisonnier($dateFinSaisonnier)
    {
        $this->date_fin_saisonnier = $dateFinSaisonnier;
    }

    /**
     * Get date_fin_saisonnier
     *
     * @return string 
     */
    public function getDateFinSaisonnier()
    {
        return $this->date_fin_saisonnier;
    }

    /**
     * Set nombre_chambres_chalets
     *
     * @param integer $nombreChambresChalets
     */
    public function setNombreChambresChalets($nombreChambresChalets)
    {
        $this->nombre_chambres_chalets = $nombreChambresChalets;
    }

    /**
     * Get nombre_chambres_chalets
     *
     * @return integer 
     */
    public function getNombreChambresChalets()
    {
        return $this->nombre_chambres_chalets;
    }

    /**
     * Set nombre_etages
     *
     * @param string $nombreEtages
     */
    public function setNombreEtages($nombreEtages)
    {
        $this->nombre_etages = $nombreEtages;
    }

    /**
     * Get nombre_etages
     *
     * @return string 
     */
    public function getNombreEtages()
    {
        return $this->nombre_etages;
    }

    /**
     * Set checkin
     *
     * @param string $checkin
     */
    public function setCheckin($checkin)
    {
        $this->checkin = $checkin;
    }

    /**
     * Get checkin
     *
     * @return string 
     */
    public function getCheckin()
    {
        return $this->checkin;
    }

    /**
     * Set checkout
     *
     * @param string $checkout
     */
    public function setCheckout($checkout)
    {
        $this->checkout = $checkout;
    }

    /**
     * Get checkout
     *
     * @return string
     */
    public function getCheckout()
    {
        return $this->checkout;
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
     * Set optvisibilite_criteres_semblables
     *
     * @param boolean $optvisibiliteCriteresSemblables
     */
    public function setOptvisibiliteCriteresSemblables($optvisibiliteCriteresSemblables)
    {
        $this->optvisibilite_criteres_semblables = $optvisibiliteCriteresSemblables;
    }

    /**
     * Get optvisibilite_criteres_semblables
     *
     * @return boolean 
     */
    public function getOptvisibiliteCriteresSemblables()
    {
        return $this->optvisibilite_criteres_semblables;
    }

    /**
     * Set optvisibilite_nouveautes
     *
     * @param boolean $optvisibiliteNouveautes
     */
    public function setOptvisibiliteNouveautes($optvisibiliteNouveautes)
    {
        $this->optvisibilite_nouveautes = $optvisibiliteNouveautes;
    }

    /**
     * Get optvisibilite_nouveautes
     *
     * @return boolean 
     */
    public function getOptvisibiliteNouveautes()
    {
        return $this->optvisibilite_nouveautes;
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
     * Set referencement_payant
     *
     * @param boolean $referencementPayant
     */
    public function setReferencementPayant($referencementPayant)
    {
        $this->referencement_payant = $referencementPayant;
    }

    /**
     * Get referencement_payant
     *
     * @return boolean 
     */
    public function getReferencementPayant()
    {
        return $this->referencement_payant;
    }

    /**
     * Set referencement_mini_site_update_souvent
     *
     * @param boolean $referencementMiniSiteUpdateSouvent
     */
    public function setReferencementMiniSiteUpdateSouvent($referencementMiniSiteUpdateSouvent)
    {
        $this->referencement_mini_site_update_souvent = $referencementMiniSiteUpdateSouvent;
    }

    /**
     * Get referencement_mini_site_update_souvent
     *
     * @return boolean 
     */
    public function getReferencementMiniSiteUpdateSouvent()
    {
        return $this->referencement_mini_site_update_souvent;
    }


    /**
     * Add forfait_id
     *
     * @param MyApp\GlobalBundle\Entity\Forfaits $forfaitId
     */
    public function addForfaits(\MyApp\GlobalBundle\Entity\Forfaits $forfaitId)
    {
        $this->forfait_id[] = $forfaitId;
    }

    /**
     * Get forfait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getForfaitId()
    {
        return $this->forfait_id;
    }

    /**
     * Add devise_id
     *
     * @param MyApp\GlobalBundle\Entity\Devises $deviseId
     */
    public function addDevises(\MyApp\GlobalBundle\Entity\Devises $deviseId)
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
     * Get politique_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPolitiqueId()
    {
        return $this->politique_id;
    }

    /**
     * Add affiliation_id
     *
     * @param MyApp\GlobalBundle\Entity\Affiliations $affiliationId
     */
    public function addAffiliations(\MyApp\GlobalBundle\Entity\Affiliations $affiliationId)
    {
        $this->affiliation_id[] = $affiliationId;
    }

    /**
     * Get affiliation_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAffiliationId()
    {
        return $this->affiliation_id;
    }

    /**
     * Set qcs_forfait_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_forfaits $qcsForfaitId
     */
    public function setQcsForfaitId(\MyApp\GlobalBundle\Entity\Qcs_forfaits $qcsForfaitId)
    {
        $this->qcs_forfait_id = $qcsForfaitId;
    }

    /**
     * Get qcs_forfait_id
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_forfaits 
     */
    public function getQcsForfaitId()
    {
        return $this->qcs_forfait_id;
    }

    /**
     * Set qcs_echo_hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_echos_hebergements $qcsEchoHebergementId
     */
    public function setQcsEchoHebergementId(\MyApp\GlobalBundle\Entity\Qcs_echos_hebergements $qcsEchoHebergementId)
    {
        $this->qcs_echo_hebergement_id = $qcsEchoHebergementId;
    }

    /**
     * Get qcs_echo_hebergement_id
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_echos_hebergements 
     */
    public function getQcsEchoHebergementId()
    {
        return $this->qcs_echo_hebergement_id;
    }

    /**
     * Set qcs_concour_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_concours $qcsConcourId
     */
    public function setQcsConcourId(\MyApp\GlobalBundle\Entity\Qcs_concours $qcsConcourId)
    {
        $this->qcs_concour_id = $qcsConcourId;
    }

    /**
     * Get qcs_concour_id
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_concours 
     */
    public function getQcsConcourId()
    {
        return $this->qcs_concour_id;
    }

    /**
     * Add hebergement_service_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements_services $hebergementServiceId
     */
    public function addHebergements_services(\MyApp\GlobalBundle\Entity\Hebergements_services $hebergementServiceId)
    {
        $this->hebergement_service_id[] = $hebergementServiceId;
    }

    /**
     * Get hebergement_service_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementServiceId()
    {
        return $this->hebergement_service_id;
    }

    /**
     * Add style_hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Styles_hebergements $styleHebergementId
     */
    public function addStyles_hebergements(\MyApp\GlobalBundle\Entity\Styles_hebergements $styleHebergementId)
    {
        $this->style_hebergement_id[] = $styleHebergementId;
    }

    /**
     * Get style_hebergement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getStyleHebergementId()
    {
        return $this->style_hebergement_id;
    }

    /**
     * Set qcs_thematiques_hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_thematiques_hebergements $qcsThematiquesHebergementId
     */
    public function setQcsThematiquesHebergementId(\MyApp\GlobalBundle\Entity\Qcs_thematiques_hebergements $qcsThematiquesHebergementId)
    {
        $this->qcs_thematiques_hebergement_id = $qcsThematiquesHebergementId;
    }

    /**
     * Get qcs_thematiques_hebergement_id
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_thematiques_hebergements 
     */
    public function getQcsThematiquesHebergementId()
    {
        return $this->qcs_thematiques_hebergement_id;
    }

    /**
     * Set province_id
     *
     * @param MyApp\GlobalBundle\Entity\Provinces_etats $provinceId
     */
    public function setProvinceId(\MyApp\GlobalBundle\Entity\Provinces_etats $provinceId)
    {
        $this->province_id = $provinceId;
    }

    /**
     * Get province_id
     *
     * @return MyApp\GlobalBundle\Entity\Provinces_etats 
     */
    public function getProvinceId()
    {
        return $this->province_id;
    }

    /**
     * Set region_id
     *
     * @param MyApp\GlobalBundle\Entity\Regions $regionId
     */
    public function setRegionId(\MyApp\GlobalBundle\Entity\Regions $regionId)
    {
        $this->region_id = $regionId;
    }

    /**
     * Get region_id
     *
     * @return MyApp\GlobalBundle\Entity\Regions 
     */
    public function getRegionId()
    {
        return $this->region_id;
    }

    /**
     * Set ville_id
     *
     * @param MyApp\GlobalBundle\Entity\Villes $villeId
     */
    public function setVilleId(\MyApp\GlobalBundle\Entity\Villes $villeId)
    {
        $this->ville_id = $villeId;
    }

    /**
     * Get ville_id
     *
     * @return MyApp\GlobalBundle\Entity\Villes 
     */
    public function getVilleId()
    {
        return $this->ville_id;
    }

    /**
     * Add video_id
     *
     * @param MyApp\GlobalBundle\Entity\Videos $videoId
     */
    public function addVideos(\MyApp\GlobalBundle\Entity\Videos $videoId)
    {
        $this->video_id[] = $videoId;
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
     * Set affiliation_id
     *
     * @param integer $affiliationId
     */
    public function setAffiliationId($affiliationId)
    {
        $this->affiliation_id = $affiliationId;
    }

    /**
     * Set cotation_id
     *
     * @param MyApp\GlobalBundle\Entity\Cotations $cotationId
     */
    public function setCotationId(\MyApp\GlobalBundle\Entity\Cotations $cotationId)
    {
        $this->cotation_id = $cotationId;
    }

    /**
     * Get cotation_id
     *
     * @return MyApp\GlobalBundle\Entity\Cotations 
     */
    public function getCotationId()
    {
        return $this->cotation_id;
    }

    /**
     * Set politique_generale_fr
     *
     * @param text $politiqueGeneraleFr
     */
    public function setPolitiqueGeneraleFr($politiqueGeneraleFr)
    {
        $this->politique_generale_fr = $politiqueGeneraleFr;
    }

    /**
     * Get politique_generale_fr
     *
     * @return text 
     */
    public function getPolitiqueGeneraleFr()
    {
        return $this->politique_generale_fr;
    }

    /**
     * Set politique_generale_en
     *
     * @param text $politiqueGeneraleEn
     */
    public function setPolitiqueGeneraleEn($politiqueGeneraleEn)
    {
        $this->politique_generale_en = $politiqueGeneraleEn;
    }

    /**
     * Get politique_generale_en
     *
     * @return text 
     */
    public function getPolitiqueGeneraleEn()
    {
        return $this->politique_generale_en;
    }

    /**
     * Set politique_animaux_fr
     *
     * @param text $politiqueAnimauxFr
     */
    public function setPolitiqueAnimauxFr($politiqueAnimauxFr)
    {
        $this->politique_animaux_fr = $politiqueAnimauxFr;
    }

    /**
     * Get politique_animaux_fr
     *
     * @return text 
     */
    public function getPolitiqueAnimauxFr()
    {
        return $this->politique_animaux_fr;
    }

    /**
     * Set politique_animaux_en
     *
     * @param text $politiqueAnimauxEn
     */
    public function setPolitiqueAnimauxEn($politiqueAnimauxEn)
    {
        $this->politique_animaux_en = $politiqueAnimauxEn;
    }

    /**
     * Get politique_animaux_en
     *
     * @return text 
     */
    public function getPolitiqueAnimauxEn()
    {
        return $this->politique_animaux_en;
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
     * Set facebook_fr
     *
     * @param string $facebookFr
     */
    public function setFacebookFr($facebookFr)
    {
        $this->facebook_fr = $facebookFr;
    }

    /**
     * Get facebook_fr
     *
     * @return string 
     */
    public function getFacebookFr()
    {
        return $this->facebook_fr;
    }

    /**
     * Set facebook_en
     *
     * @param string $facebookEn
     */
    public function setFacebookEn($facebookEn)
    {
        $this->facebook_en = $facebookEn;
    }

    /**
     * Get facebook_en
     *
     * @return string 
     */
    public function getFacebookEn()
    {
        return $this->facebook_en;
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
     * Set texte_description_fr
     *
     * @param text $texteDescriptionFr
     */
    public function setTexteDescriptionFr($texteDescriptionFr)
    {
        $this->texte_description_fr = htmlentities( $texteDescriptionFr);
    }

    /**
     * Get texte_description_fr
     *
     * @return text 
     */
    public function getTexteDescriptionFr()
    {
        return html_entity_decode( $this->texte_description_fr);
    }

    /**
     * Set texte_description_en
     *
     * @param text $texteDescriptionEn
     */
    public function setTexteDescriptionEn($texteDescriptionEn)
    {
        $this->texte_description_en = htmlentities($texteDescriptionEn);
    }

    /**
     * Get texte_description_en
     *
     * @return text 
     */
    public function getTexteDescriptionEn()
    {
        return html_entity_decode( $this->texte_description_en);
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
     * Set zone_id
     *
     * @param MyApp\GlobalBundle\Entity\Zones $zoneId
     */
    public function setZoneId(\MyApp\GlobalBundle\Entity\Zones $zoneId)
    {
        $this->zone_id = $zoneId;
    }

    /**
     * Get zone_id
     *
     * @return MyApp\GlobalBundle\Entity\Zones 
     */
    public function getZoneId()
    {
        return $this->zone_id;
    }

    /**
     * Set aprouver
     *
     * @param boolean $aprouver
     */
    public function setAprouver($aprouver)
    {
        $this->aprouver = $aprouver;
    }

    /**
     * Get aprouver
     *
     * @return boolean 
     */
    public function getAprouver()
    {
        return $this->aprouver;
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
     * Set photo_categorie_payante
     *
     * @param string $photoCategoriePayante
     */
    public function setPhotoCategoriePayante($photoCategoriePayante)
    {
        $this->photo_categorie_payante = $photoCategoriePayante;
    }

    /**
     * Get photo_categorie_payante
     *
     * @return string 
     */
    public function getPhotoCategoriePayante()
    {
        return $this->photo_categorie_payante;
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
     * Set photo_categorie_payante_doctrine
     *
     * @param string $photoCategoriePayanteDoctrine
     */
    public function setPhotoCategoriePayanteDoctrine($photoCategoriePayanteDoctrine)
    {
        $this->photo_categorie_payante_doctrine = $photoCategoriePayanteDoctrine;
    }

    /**
     * Get photo_categorie_payante_doctrine
     *
     * @return string 
     */
    public function getPhotoCategoriePayanteDoctrine()
    {
        return $this->photo_categorie_payante_doctrine;
    }

    /**
     * Set fichier_liste_salles_fr_doctrine
     *
     * @param string $fichierListeSallesFrDoctrine
     */
    public function setFichierListeSallesFrDoctrine($fichierListeSallesFrDoctrine)
    {
        $this->fichier_liste_salles_fr_doctrine = $fichierListeSallesFrDoctrine;
    }

    /**
     * Get fichier_liste_salles_fr_doctrine
     *
     * @return string 
     */
    public function getFichierListeSallesFrDoctrine()
    {
        return $this->fichier_liste_salles_fr_doctrine;
    }

    /**
     * Set fichier_liste_salles_en_doctrine
     *
     * @param string $fichierListeSallesEnDoctrine
     */
    public function setFichierListeSallesEnDoctrine($fichierListeSallesEnDoctrine)
    {
        $this->fichier_liste_salles_en_doctrine = $fichierListeSallesEnDoctrine;
    }

    /**
     * Get fichier_liste_salles_en_doctrine
     *
     * @return string 
     */
    public function getFichierListeSallesEnDoctrine()
    {
        return $this->fichier_liste_salles_en_doctrine;
    }

    /**
     * Set fichier_plan_salles_fr_doctrine
     *
     * @param string $fichierPlanSallesFrDoctrine
     */
    public function setFichierPlanSallesFrDoctrine($fichierPlanSallesFrDoctrine)
    {
        $this->fichier_plan_salles_fr_doctrine = $fichierPlanSallesFrDoctrine;
    }

    /**
     * Get fichier_plan_salles_fr_doctrine
     *
     * @return string 
     */
    public function getFichierPlanSallesFrDoctrine()
    {
        return $this->fichier_plan_salles_fr_doctrine;
    }

    /**
     * Set fichier_plan_salles_en_doctrine
     *
     * @param string $fichierPlanSallesEnDoctrine
     */
    public function setFichierPlanSallesEnDoctrine($fichierPlanSallesEnDoctrine)
    {
        $this->fichier_plan_salles_en_doctrine = $fichierPlanSallesEnDoctrine;
    }

    /**
     * Get fichier_plan_salles_en_doctrine
     *
     * @return string 
     */
    public function getFichierPlanSallesEnDoctrine()
    {
        return $this->fichier_plan_salles_en_doctrine;
    }

    /**
     * Add hebergement_equipement_id
     *
     * @param MyApp\GlobalBundle\Entity\Equipements $hebergementEquipementId
     */
    public function addEquipements(\MyApp\GlobalBundle\Entity\Equipements $hebergementEquipementId)
    {
        $this->hebergement_equipement_id[] = $hebergementEquipementId;
    }

    /**
     * Get hebergement_equipement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementEquipementId()
    {
        return $this->hebergement_equipement_id;
    }

    /**
     * Add hebergement_paiements_id
     *
     * @param MyApp\GlobalBundle\Entity\Modes_paiements $hebergementPaiementsId
     */
    public function addModes_paiements(\MyApp\GlobalBundle\Entity\Modes_paiements $hebergementPaiementsId)
    {
        $this->hebergement_paiements_id[] = $hebergementPaiementsId;
    }

    /**
     * Get hebergement_paiements_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementPaiementsId()
    {
        return $this->hebergement_paiements_id;
    }

    /**
     * Add hebergement_activite_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements_activites $hebergementActiviteId
     */
    public function addHebergements_activites(\MyApp\GlobalBundle\Entity\Hebergements_activites $hebergementActiviteId)
    {
        $this->hebergement_activite_id[] = $hebergementActiviteId;
    }

    /**
     * Get hebergement_activite_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementActiviteId()
    {
        return $this->hebergement_activite_id;
    }

    /**
     * Get chambre_hebergement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChambreHebergementId()
    {
        return $this->chambre_hebergement_id;
    }

  

    /**
     * Set texte_resume_fr
     *
     * @param text $texteResumeFr
     */
    public function setTexteResumeFr($texteResumeFr)
    {
        $this->texte_resume_fr = htmlentities( $texteResumeFr);
    }

    /**
     * Get texte_resume_fr
     *
     * @return text 
     */
    public function getTexteResumeFr()
    {
        return html_entity_decode( $this->texte_resume_fr);
    }

    /**
     * Set texte_resume_en
     *
     * @param text $texteResumeEn
     */
    public function setTexteResumeEn($texteResumeEn)
    {
        $this->texte_resume_en = htmlentities( $texteResumeEn);
    }

    /**
     * Get texte_resume_en
     *
     * @return text 
     */
    public function getTexteResumeEn()
    {
        return html_entity_decode( $this->texte_resume_en);
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
     * Add hebergement_forfait_client_id
     *
     * @param MyApp\GlobalBundle\Entity\Forfaits_clients $hebergementForfaitClientId
     */
    public function addForfaits_clients(\MyApp\GlobalBundle\Entity\Forfaits_clients $hebergementForfaitClientId)
    {
        $this->hebergement_forfait_client_id[] = $hebergementForfaitClientId;
    }

    /**
     * Get hebergement_forfait_client_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementForfaitClientId()
    {
        return $this->hebergement_forfait_client_id;
    }

    /**
     * Set email_corporatif
     *
     * @param string $emailCorporatif
     */
    public function setEmailCorporatif($emailCorporatif)
    {
        $this->email_corporatif = $emailCorporatif;
    }

    /**
     * Get email_corporatif
     *
     * @return string 
     */
    public function getEmailCorporatif()
    {
        return $this->email_corporatif;
    }

    /**
     * Set paiement_id
     *
     * @param string $paiementId
     */
    public function setPaiementId($paiementId)
    {
        $this->paiement_id = $paiementId;
    }

    /**
     * Get paiement_id
     *
     * @return string 
     */
    public function getPaiementId()
    {
        return $this->paiement_id;
    }

    /**
     * Add galerie_hebergement
     *
     * @param MyApp\GlobalBundle\Entity\Galerie_hebergement $galerieHebergement
     */
    public function addGalerie_hebergement(\MyApp\GlobalBundle\Entity\Galerie_hebergement $galerieHebergement)
    {
        //$this->galerie_hebergement[] = $galerieHebergement;
        if (!$this->galerie_hebergement->contains($galerieHebergement)) {
        	$this->galerie_hebergement->add($galerieHebergement);
        }
    }

    /**
     * Get galerie_hebergement
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGalerieHebergement()
    {
        return $this->galerie_hebergement;
    }
    
    public function setGalerieHebergement(ArrayCollection $galerieHebergement)
    {
    	foreach ($galerieHebergement as $tag) {
    		$tag->addGalerie_hebergement($this);
    	}
    
    	$this->galerie_hebergement = $galerieHebergement;
    }

    /**
     * Add distance_id
     *
     * @param MyApp\GlobalBundle\Entity\Distances $distanceId
     */
    public function addDistances(\MyApp\GlobalBundle\Entity\Distances $distanceId)
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
     * Add temporaire_attrait_id
     *
     * @param MyApp\GlobalBundle\Entity\Temporaire_attraits $temporaireAttraitId
     */
    public function addTemporaire_attraits(\MyApp\GlobalBundle\Entity\Temporaire_attraits $temporaireAttraitId)
    {
        $this->temporaire_attrait_id[] = $temporaireAttraitId;
    }

    /**
     * Get temporaire_attrait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTemporaireAttraitId()
    {
        return $this->temporaire_attrait_id;
    }

    /**
     * Set saisonnier
     *
     * @param boolean $saisonnier
     */
    public function setSaisonnier($saisonnier)
    {
        $this->saisonnier = $saisonnier;
    }

    /**
     * Get saisonnier
     *
     * @return boolean 
     */
    public function getSaisonnier()
    {
        return $this->saisonnier;
    }

    /**
     * Set hebergement_politique_fr
     *
     * @param MyApp\GlobalBundle\Entity\Politique_fr $hebergementPolitiqueFr
     */
    public function setHebergementPolitiqueFr(\MyApp\GlobalBundle\Entity\Politique_fr $hebergementPolitiqueFr)
    {
        $this->hebergement_politique_fr = $hebergementPolitiqueFr;
    }

    /**
     * Get hebergement_politique_fr
     *
     * @return MyApp\GlobalBundle\Entity\Politique_fr 
     */
    public function getHebergementPolitiqueFr()
    {
        return $this->hebergement_politique_fr;
    }

    /**
     * Set hebergement_politique_en
     *
     * @param MyApp\GlobalBundle\Entity\Politique_en $hebergementPolitiqueEn
     */
    public function setHebergementPolitiqueEn(\MyApp\GlobalBundle\Entity\Politique_en $hebergementPolitiqueEn)
    {
        $this->hebergement_politique_en = $hebergementPolitiqueEn;
    }

    /**
     * Get hebergement_politique_en
     *
     * @return MyApp\GlobalBundle\Entity\Politique_en 
     */
    public function getHebergementPolitiqueEn()
    {
        return $this->hebergement_politique_en;
    }

    /**
     * Set utilisateur
     *
     * @param MyApp\GlobalBundle\Entity\Utilisateur $utilisateur
     */
    public function setUtilisateur(\MyApp\GlobalBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;
    }

    /**
     * Get utilisateur
     *
     * @return MyApp\GlobalBundle\Entity\Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set acompte_id
     *
     * @param MyApp\GlobalBundle\Entity\Acomptes $acompteId
     */
    public function setAcompteId(\MyApp\GlobalBundle\Entity\Acomptes $acompteId)
    {
        $this->acompte_id = $acompteId;
    }

    /**
     * Get acompte_id
     *
     * @return MyApp\GlobalBundle\Entity\Acomptes 
     */
    public function getAcompteId()
    {
        return $this->acompte_id;
    }

    /**
     * Add qcs_concour_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_concours $qcsConcourId
     */
    public function addQcs_concours(\MyApp\GlobalBundle\Entity\Qcs_concours $qcsConcourId)
    {
        $this->qcs_concour_id[] = $qcsConcourId;
    }

    /**
     * Set classification_id
     *
     * @param MyApp\GlobalBundle\Entity\Classifications $classificationId
     */
    public function setClassificationId(\MyApp\GlobalBundle\Entity\Classifications $classificationId)
    {
        $this->classification_id = $classificationId;
    }

    /**
     * Get classification_id
     *
     * @return MyApp\GlobalBundle\Entity\Classifications 
     */
    public function getClassificationId()
    {
        return $this->classification_id;
    }

    /**
     * Add categorie_hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Categories_hebergements $categorieHebergementId
     */
    public function addCategories_hebergements(\MyApp\GlobalBundle\Entity\Categories_hebergements $categorieHebergementId)
    {
        $this->categorie_hebergement_id[] = $categorieHebergementId;
    }

    /**
     * Get categorie_hebergement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategorieHebergementId()
    {
        return $this->categorie_hebergement_id;
    }

    /**
     * Set prix_a_partir
     *
     * @param string $prixAPartir
     */
    public function setPrixAPartir($prixAPartir)
    {
        $this->prix_a_partir = $prixAPartir;
    }

    /**
     * Get prix_a_partir
     *
     * @return string 
     */
    public function getPrixAPartir()
    {
        return $this->prix_a_partir;
    }

    /**
     * Add calendrier
     *
     * @param MyApp\GlobalBundle\Entity\Calendrier_saison $calendrier
     */
    public function addCalendrier_saison(\MyApp\GlobalBundle\Entity\Calendrier_saison $calendrier)
    {
        $this->calendrier[] = $calendrier;
    }

    /**
     * Get calendrier
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCalendrier()
    {
        return $this->calendrier;
    }

    /**
     * Set nombre_chambre
     *
     * @param string $nombreChambre
     */
    public function setNombreChambre($nombreChambre)
    {
        $this->nombre_chambre = $nombreChambre;
    }

    /**
     * Get nombre_chambre
     *
     * @return string 
     */
    public function getNombreChambre()
    {
        return $this->nombre_chambre;
    }

    /**
     * Set classification
     *
     * @param string $classification
     */
    public function setClassification($classification)
    {
        $this->classification = $classification;
    }

    /**
     * Get classification
     *
     * @return string 
     */
    public function getClassification()
    {
        return $this->classification;
    }

    

    /**
     * Add salles_corpo_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives $sallesCorpoId
     */
    public function addHebergements_salles_corporatives(\MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives $sallesCorpoId)
    {
        $this->salles_corpo_id[] = $sallesCorpoId;
    }
    
    /**
     * Get salles_corpo_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSallesCorpoId()
    {
        return $this->salles_corpo_id;
    }

    /**
     * Add chambre_hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Chambres $chambreHebergementId
     */
    public function addChambres(\MyApp\GlobalBundle\Entity\Chambres $chambreHebergementId)
    {
        $this->chambre_hebergement_id[] = $chambreHebergementId;
    }
}