<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\HebergementsRepository")
 * @ORM\Table(name = "hebergements")
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
	 * @ORM\Column(type="integer")
	 * 
	 * @var integer $client_id
	 */
	private $client_id;
	
	/**
	 * @ORM\Column(type="integer")
	 * 
	 * @var integer $ville_id
	 */
	private $ville_id;
	
	/**
	 * @ORM\Column(type="integer")
	 *
	 * @var integer $region_id
	 */
	private $region_id;
	
	/**
	 * @ORM\Column(type="integer")
	 * 
	 * @var integer $province_id
	 */
	private $province_id;
	
	/**
	 * @ORM\Column(type="integer")
	 * 
	 * @var integer $cotation_id
	 */
	private $cotation_id;
	
	/**
	 * @ORM\Column(type="integer")
	 * 
	 * @var integer $acompte_id
	 */
	private $acompte_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Forfaits", inversedBy = "Hebergements")
	 * @ORM\JoinTable(name = "relations_forfaits_hebergements")
	 * 
	 * @var ArrayCollection $forfait_id
	 */
	private $forfait_id;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $contact
	 */
	private $contact;
	
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
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $nom_abrege_fr
	 */
	private $nom_abrege_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $nom_abrege_en
	 */
	private $nom_abrege_en;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var string $adresse
	 */
	private $adresse;
	
	/**
	 * @ORM\Column(type = "string", length = 7)
	 * 
	 * @var string $code_postal
	 */
	private $code_postal;
	
	/**
	 * @ORM\Column(type = "string", length = 10)
	 * 
	 * @var string $telephone
	 */
	private $telephone;
	
	/**
	 * @ORM\Column(type = "string", length = 10)
	 * 
	 * @var string $telephone_poste
	 */
	private $telephone_poste;
	
	/**
	 * @ORM\Column(type = "string", length = 10)
	 * 
	 * @var sstring $telecopieur
	 */
	private $telecopieur;
	
	/**
	 * @ORM\Column(type = "string", length = 10)
	 * 
	 * @var string $sans_frais
	 */
	private $sans_frais;
	
	/**
	 * @ORM\Column(type = "string", length = 100)
	 * 
	 * @var string $courriel
	 */
	private $courriel;
	
	/**
	 * @ORM\Column(type = "string", length = 100)
	 * 
	 * @var string $siteweb
	 */
	private $siteweb;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $latitude
	 */
	private $latitude;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $longitude
	 */
	private $longitude;
	
	/**
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $reservit_id
	 */
	private $reservit_id;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $repertoire_fr
	 */
	private $repertoire_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $repertoire_en
	 */
	private $repertoire_en;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $actif
	 */
	private $actif;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $etablissement_saisonnier
	 */
	private $etablissement_saisonnier;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $formulaire
	 */
	private $formulaire;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $adsense
	 */
	private $adsense;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $corporatif
	 */
	private $corporatif;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $tarif_preferentiel
	 */
	private $tarif_preferentiel;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $nouveau_membre
	 */
	private $nouveau_membre;
	
	/**
	 * @ORM\Column(type = "date")
	 * 
	 * @var date $date_nouveau_membre
	 */
	private $date_nouveau_membre;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $meta_titre_fr
	 */
	private $meta_titre_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $meta_titre_en
	 */
	private $meta_titre_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $meta_keywords_fr
	 */
	private $meta_keywords_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $meta_keywords_en
	 */
	private $meta_keywords_en;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $meta_description_fr
	 */
	private $meta_description_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $meta_description_en
	 */
	private $meta_description_en;
	
	/**
	 * @ORM\Column(type = "date")
	 * 
	 * @var date $date_debut_saisonnier
	 */
	private $date_debut_saisonnier;
	
	/**
	 * @ORM\Column(type = "date")
	 * 
	 * @var date $date_fin_saisonnier
	 */
	private $date_fin_saisonnier;
	
	/**
	 * @ORM\Column(type = "integer", length = 2)
	 * 
	 * @var integer $nombre_chambres_chalets
	 */
	private $nombre_chambres_chalets;
	
	/**
	 * @ORM\Column(type = "integer", length = 2)
	 * 
	 * @var integer $nombre_etages
	 */
	private $nombre_etages;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $checkin
	 */
	private $checkin;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $checkout
	 */
	private $checkout;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $fichier_liste_salles_fr
	 */
	private $fichier_liste_salles_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $fichier_liste_salles_en
	 */
	private $fichier_liste_salles_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $fichier_plan_salles_fr
	 */
	private $fichier_plan_salles_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $fichier_plan_salles_en
	 */
	private $fichier_plans_alles_en;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $optvisibilite_grande_photo
	 */
	private $optvisibilite_grande_photo;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $optvisibilite_photo_categorie
	 */
	private $optvisibilite_photo_categorie;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $optvisibilite_nos_suggestions
	 */
	private $optvisibilite_nos_suggestions;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $optvisibilite_criteres_semblables
	 */
	private $optvisibilite_criteres_semblables;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $optvisibilite_nouveautes
	 */
	private $optvisibilite_nouveautes;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $optvisibilite_incontournables
	 */
	private $optvisibilite_incontournables;
	
	/**
	 * @ORM\Column(type = "date")
	 * 
	 * @var date $date_creation
	 */
	private $date_creation;
	
	/**
	 * @ORM\Column(type = "boolean")
	 *
	 * @var boolean $referencement_payant
	 */
	private $referencement_payant;
	
	/**
	 * @ORM\Column(type = "boolean")
	 *
	 * @var boolean $referencement_mini_site_update_souvent
	 */
	private $referencement_mini_site_update_souvent;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Devises", inversedBy = "Hebergements")
	 * @ORM\JoinTable(name="relations_devises_hebergements")
	 * 
	 * @var ArrayCollection $devise_id
	 */
	private $devise_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Hebergements_activites", mappedBy="Hebergements")
	 * 
	 * @var ArrayCollection $hebergement_activite_id
	 */
	private $hebergement_activite_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Attraits", mappedBy="Hebergements")
	 *
	 * @var ArrayCollection $attrait_id
	 */
	private $attrait_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Equipements", mappedBy="Hebergements")
	 *
	 * @var ArrayCollection $equipement_id
	 */
	private $equipement_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Modes_paiements", mappedBy="Hebergements")
	 *
	 * @var ArrayCollection $paiements_id
	 */
	private $paiements_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Chambres", mappedBy="Hebergements")
	 *
	 * @var ArrayCollection $chambre_id
	 */
	private $chambre_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Hebergements_salles_corporatives", mappedBy="Hebergements")
	 *
	 * @var integer $salle_corpo_id
	 */
	private $salles_corpo_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Hebergements_politiques", mappedBy="Hebergements")
	 *
	 * @var ArrayCollection $politique_id
	 */
	private $politique_id;
	
	/**
	 * @ORM\OneToMany(targetEntity="Affiliations", mappedBy="Hebergements")
	 *
	 * @var integer $affiliation_id
	 */
	private $affiliation_id;
	
	/**
	 * @ORM\OneToOne(targetEntity="Qcs_forfaits", mappedBy="Hebergements")
	 *
	 * @var integer $qcs_forfait_id
	 */
	private $qcs_forfait_id;
	
	/**
	 * @ORM\OneToOne(targetEntity="Qcs_echos_hebergements", mappedBy="Hebergements")
	 *
	 * @var integer $qcs_echo_hebergement_id
	 */
	private $qcs_echo_hebergement_id;
	
	/**
	 * @ORM\OneToOne(targetEntity="Qcs_concours", mappedBy="Hebergements")
	 *
	 * @var integer $qcs_concour_id
	 */
	private $qcs_concour_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Hebergements_services", mappedBy="Hebergements")
	 *
	 * @var ArrayCollection $hebergement_service_id
	 */
	private $hebergement_service_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Styles_hebergements", mappedBy="Hebergements")
	 *
	 * @var ArrayCollection $style_hebergement_id
	 */
	private $style_hebergement_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Categories_hebergements", inversedBy = "Hebergements")
	 * @ORM\JoinColumn(name = "categorie_hebergement_id", referencedColumnName = "id")
	 * 
	 * @var integer $categorie_hebergement_id
	 */
	private $categorie_hebergement_id;
		
	public function __construct()
	{
		$this->salle_corpo_id = new ArrayCollection();
		$this->forfait_id = new ArrayCollection();
		$this->devise_id = new ArrayCollection();
		$this->hebergement_activite_id = new ArrayCollection();
		$this->attrait_id = new ArrayCollection();
		$this->equipement_id = new ArrayCollection();
		$this->paiements_id = new ArrayCollection();
		$this->chambre_id = new ArrayCollection();
		$this->politique_id = new ArrayCollection();
		$this->hebergement_service_id = new ArrayCollection();
		$this->style_hebergement_id = new ArrayCollection();
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
     * Set client_id
     *
     * @param integer $clientId
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;
    }

    /**
     * Get client_id
     *
     * @return integer 
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set ville_id
     *
     * @param integer $villeId
     */
    public function setVilleId($villeId)
    {
        $this->ville_id = $villeId;
    }

    /**
     * Get ville_id
     *
     * @return integer 
     */
    public function getVilleId()
    {
        return $this->ville_id;
    }

    /**
     * Set region_id
     *
     * @param integer $regionId
     */
    public function setRegionId($regionId)
    {
        $this->region_id = $regionId;
    }

    /**
     * Get region_id
     *
     * @return integer 
     */
    public function getRegionId()
    {
        return $this->region_id;
    }

    /**
     * Set province_id
     *
     * @param integer $provinceId
     */
    public function setProvinceId($provinceId)
    {
        $this->province_id = $provinceId;
    }

    /**
     * Get province_id
     *
     * @return integer 
     */
    public function getProvinceId()
    {
        return $this->province_id;
    }

    /**
     * Set categorie_hebergement_id
     *
     * @param integer $categorieHebergementId
     */
    public function setCategorieHebergementId($categorieHebergementId)
    {
        $this->categorie_hebergement_id = $categorieHebergementId;
    }

    /**
     * Get categorie_hebergement_id
     *
     * @return integer 
     */
    public function getCategorieHebergementId()
    {
        return $this->categorie_hebergement_id;
    }

    /**
     * Set cotation_id
     *
     * @param integer $cotationId
     */
    public function setCotationId($cotationId)
    {
        $this->cotation_id = $cotationId;
    }

    /**
     * Get cotation_id
     *
     * @return integer 
     */
    public function getCotationId()
    {
        return $this->cotation_id;
    }

    /**
     * Set acompte_id
     *
     * @param integer $acompteId
     */
    public function setAcompteId($acompteId)
    {
        $this->acompte_id = $acompteId;
    }

    /**
     * Get acompte_id
     *
     * @return integer 
     */
    public function getAcompteId()
    {
        return $this->acompte_id;
    }

    /**
     * Set contact
     *
     * @param string $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
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
     * @param text $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * Get adresse
     *
     * @return text 
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
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return string 
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
     * Set formulaire
     *
     * @param boolean $formulaire
     */
    public function setFormulaire($formulaire)
    {
        $this->formulaire = $formulaire;
    }

    /**
     * Get formulaire
     *
     * @return boolean 
     */
    public function getFormulaire()
    {
        return $this->formulaire;
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
     * Set date_nouveau_membre
     *
     * @param date $dateNouveauMembre
     */
    public function setDateNouveauMembre($dateNouveauMembre)
    {
        $this->date_nouveau_membre = $dateNouveauMembre;
    }

    /**
     * Get date_nouveau_membre
     *
     * @return date 
     */
    public function getDateNouveauMembre()
    {
        return $this->date_nouveau_membre;
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
     * @param date $dateDebutSaisonnier
     */
    public function setDateDebutSaisonnier($dateDebutSaisonnier)
    {
        $this->date_debut_saisonnier = $dateDebutSaisonnier;
    }

    /**
     * Get date_debut_saisonnier
     *
     * @return date 
     */
    public function getDateDebutSaisonnier()
    {
        return $this->date_debut_saisonnier;
    }

    /**
     * Set date_fin_saisonnier
     *
     * @param date $dateFinSaisonnier
     */
    public function setDateFinSaisonnier($dateFinSaisonnier)
    {
        $this->date_fin_saisonnier = $dateFinSaisonnier;
    }

    /**
     * Get date_fin_saisonnier
     *
     * @return date 
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
     * @param integer $nombreEtages
     */
    public function setNombreEtages($nombreEtages)
    {
        $this->nombre_etages = $nombreEtages;
    }

    /**
     * Get nombre_etages
     *
     * @return integer 
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
     * Set fichier_liste_salles_fr
     *
     * @param string $fichierListeSallesFr
     */
    public function setFichierListeSallesFr($fichierListeSallesFr)
    {
        $this->fichier_liste_salles_fr = $fichierListeSallesFr;
    }

    /**
     * Get fichier_liste_salles_fr
     *
     * @return string 
     */
    public function getFichierListeSallesFr()
    {
        return $this->fichier_liste_salles_fr;
    }

    /**
     * Set fichier_liste_salles_en
     *
     * @param string $fichierListeSallesEn
     */
    public function setFichierListeSallesEn($fichierListeSallesEn)
    {
        $this->fichier_liste_salles_en = $fichierListeSallesEn;
    }

    /**
     * Get fichier_liste_salles_en
     *
     * @return string 
     */
    public function getFichierListeSallesEn()
    {
        return $this->fichier_liste_salles_en;
    }

    /**
     * Set fichier_plan_salles_fr
     *
     * @param string $fichierPlanSallesFr
     */
    public function setFichierPlanSallesFr($fichierPlanSallesFr)
    {
        $this->fichier_plan_salles_fr = $fichierPlanSallesFr;
    }

    /**
     * Get fichier_plan_salles_fr
     *
     * @return string 
     */
    public function getFichierPlanSallesFr()
    {
        return $this->fichier_plan_salles_fr;
    }

    /**
     * Set fichier_plans_alles_en
     *
     * @param string $fichierPlansAllesEn
     */
    public function setFichierPlansAllesEn($fichierPlansAllesEn)
    {
        $this->fichier_plans_alles_en = $fichierPlansAllesEn;
    }

    /**
     * Get fichier_plans_alles_en
     *
     * @return string 
     */
    public function getFichierPlansAllesEn()
    {
        return $this->fichier_plans_alles_en;
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
     * Add types_chambre_id
     *
     * @param MyApp\GlobalBundle\Entity\TypesChambres $typesChambreId
     */
    public function addTypesChambres(\MyApp\GlobalBundle\Entity\TypesChambres $typesChambreId)
    {
        $this->types_chambre_id[] = $typesChambreId;
    }

    /**
     * Get types_chambre_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTypesChambreId()
    {
        return $this->types_chambre_id;
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
     * Add types_chambre_id
     *
     * @param MyApp\GlobalBundle\Entity\Types_Chambres $typesChambreId
     */
    public function addTypes_Chambres(\MyApp\GlobalBundle\Entity\Types_Chambres $typesChambreId)
    {
        $this->types_chambre_id[] = $typesChambreId;
    }

    /**
     * Add equipement_id
     *
     * @param MyApp\GlobalBundle\Entity\Equipements $equipementId
     */
    public function addEquipements(\MyApp\GlobalBundle\Entity\Equipements $equipementId)
    {
        $this->equipement_id[] = $equipementId;
    }

    /**
     * Get equipement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEquipementId()
    {
        return $this->equipement_id;
    }

    /**
     * Add paiements_id
     *
     * @param MyApp\GlobalBundle\Entity\Modes_paiements $paiementsId
     */
    public function addModes_paiements(\MyApp\GlobalBundle\Entity\Modes_paiements $paiementsId)
    {
        $this->paiements_id[] = $paiementsId;
    }

    /**
     * Get paiements_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPaiementsId()
    {
        return $this->paiements_id;
    }

    /**
     * Add chambre_id
     *
     * @param MyApp\GlobalBundle\Entity\Chambres $chambreId
     */
    public function addChambres(\MyApp\GlobalBundle\Entity\Chambres $chambreId)
    {
        $this->chambre_id[] = $chambreId;
    }

    /**
     * Get chambre_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChambreId()
    {
        return $this->chambre_id;
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
     * Add politique_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements_politiques $politiqueId
     */
    public function addHebergements_politiques(\MyApp\GlobalBundle\Entity\Hebergements_politiques $politiqueId)
    {
        $this->politique_id[] = $politiqueId;
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
}