<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "attraits")
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
	 * @ORM\OneToOne(targetEntity="Clients", inversedBy="Attraits")
	 * 
	 * @var integer $client_id
	 */
	private $client_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Soins_sante", inversedBy="Attraits")
	 * @ORM\JoinTable(name = "relations_attraits_soins_sante")
	 * 
	 * @var ArrayCollection $soins_sante_id
	 */
	private $soins_sante_id;

	/**
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $type_cotation_cotation_camping_id
	 */
	private $type_cotation_cotation_camping_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Devises", inversedBy="Attraits")
	 * @ORM\JoinTable(name="relations_devises_attraits")
	 * 
	 * @var ArrayCollection $devise_id
	 */
	private $devise_id;
	
	
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
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_facebook_fr
	 */
	private $page_facebook_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_facebook_en
	 */
	private $page_facebook_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $titre_fr
	 */
	private $titre_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $titre_en
	 */
	private $titre_en;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_description_fr
	 */
	private $texte_description_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_description_en
	 */
	private $texte_description_en;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_resume_fr
	 */
	private $texte_resume_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_resume_en
	 */
	private $texte_resume_en;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_express_fr
	 */
	private $texte_express_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_express_en
	 */
	private $texte_express_en;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_tarif_fr
	 */
	private $texte_tarif_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_tarif_en
	 */
	private $texte_tarif_en;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_horaire_fr
	 */
	private $texte_horaire_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_horaire_en
	 */
	private $texte_horaire_en;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_periode_ouverture_fr
	 */
	private $texte_periode_ouverture_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_periode_ouverture_en
	 */
	private $texte_periode_ouverture_en;
	
	/**
	 * @ORM\Column(type = "date")
	 * 
	 * @var date $date_debut
	 */
	private $date_debut;
	
	/**
	 * @ORM\Column(type = "date")
	 * 
	 * @var date $date_fin
	 */
	private $date_fin;
	
	/**
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $emplacements_0_service_camping
	 */
	private $emplacements_0_service_camping;
	
	/**
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $emplacements_1_service_camping
	 */
	private $emplacements_1_service_camping;
	
	/**
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $emplacements_2_services_camping
	 */
	private $emplacements_2_services_camping;
	
	/**
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $emplacements_3_services_camping
	 */
	private $emplacements_3_services_camping;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $approuve
	 */
	private $approuve;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $actif
	 */
	private $actif;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $express
	 */
	private $express;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $payant
	 */
	private $payant;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $adressewebcliquable
	 */
	private $adresse_web_cliquable;
	
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
	 * @var string $metakeywords_fr
	 */
	private $metakeywords_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $metakeywords_en
	 */
	private $metakeywords_en;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $metadescription_fr
	 */
	private $metadescription_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $metadescription_en
	 */
	private $metadescription_en;
	
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
	 * @var boolean $optvisibilite_proximite
	 */
	private $optvisibilite_proximite;
	
	/**
	 * @ORM\Column(type = "boolean")
	 * 
	 * @var boolean $optvisibilite_lien_hebergement
	 */
	private $optvisibilite_lien_hebergement;
	
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
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $clients_id
	 */
	private $clients_id;
	
	/**
	 * @ORM\Column(type = "integer")
	 *
	 * @var integer $villes_id
	 */
	private $villes_id;
	
	/**
	 * @ORM\Column(type = "integer")
	 *
	 * @var integer $regions_id
	 */
	private $regions_id;
	
	/**
	 * @ORM\Column(type = "integer")
	 *
	 * @var integer $provinces_id
	 */
	private $provinces_id;
	
	/**
	 * @ORM\ManyToMAny(targetEntity="Cotations", mappedBy="Attraits")
	 * 
	 * @var ArrayCollection $cotation_id
	 */
	private $cotation_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Cuisines", mappedBy="Attraits")
	 * 
	 * @var ArrayCollection $cuisine_id
	 */
	private $cuisine_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Hebergements", inversedBy = "Attraits")
	 * @ORM\JoinTable(name="relation_attrait_hebergement")
	 *
	 * @var ArrayCollection $hebergement_id
	 */
	private $hebergement_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Attraits_services", mappedBy="Attraits")
	 * 
	 * @var ArrayCollection $attrait_service_id
	 */
	private $attrait_service_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Modes_paiements", mappedBy="Attraits")
	 *
	 * @var ArrayCollection $paiement_id
	 */
	private $paiement_id;
	
	/**
	 * @ORM\OneToOne(targetEntity="Qcs_festival_attraits", mappedBy="Attraits")
	 *
	 * @var integer $qcs_festival_attrait_id
	 */
	private $qcs_festival_attrait_id;
	
	/**
	 * @ORM\OneToOne(targetEntity="Qcs_echos_attraits", mappedBy="Attraits")
	 *
	 * @var integer $qcs_echo_attrait_id
	 */
	private $qcs_echo_attrait_id;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Attraits_photos", mappedBy = "Attraits")
	 * 
	 * @var integer $attrait_photo_id
	 */
	private $attrait_photo_id;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Attraits_videos", mappedBy = "Attraits")
	 *
	 * @var integer $attrait_video_id
	 */
	private $attrait_video_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Attraits_villes", inversedBy = "Attraits")
	 * @ORM\JoinColumn(name = "attrait_id", referencedColumnName = "id")
	 *
	 * @var integer $attrait_ville_id
	 */
	private $attrait_ville_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Attraits_activites", mappedBy="Attraits")
	 *
	 * @var ArrayCollection $attrait_activite_id
	 */
	private $attrait_activite_id;
	
	public function __construct()
	{
		$this->type_cotation_camping_id = new ArrayCollection();
		$this->soins_sante_id = new ArrayCollection();
		$this->devise_id = new ArrayCollection();
		$this->cotation_id = new ArrayCollection();
		$this->cuisine_id = new ArrayCollection();
		$this->hebergement_id = new ArrayCollection();
		$this->attrait_service_id = new ArrayCollection();
		$this->paiement_id = new ArrayCollection();
		$this->attrait_activite_id = new ArrayCollection();
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
     * Set type_cotation_cotation_camping_id
     *
     * @param integer $typeCotationCotationCampingId
     */
    public function setTypeCotationCotationCampingId($typeCotationCotationCampingId)
    {
        $this->type_cotation_cotation_camping_id = $typeCotationCotationCampingId;
    }

    /**
     * Get type_cotation_cotation_camping_id
     *
     * @return integer 
     */
    public function getTypeCotationCotationCampingId()
    {
        return $this->type_cotation_cotation_camping_id;
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
     * Set texte_tarif_fr
     *
     * @param text $texteTarifFr
     */
    public function setTexteTarifFr($texteTarifFr)
    {
        $this->texte_tarif_fr = $texteTarifFr;
    }

    /**
     * Get texte_tarif_fr
     *
     * @return text 
     */
    public function getTexteTarifFr()
    {
        return $this->texte_tarif_fr;
    }

    /**
     * Set texte_tarif_en
     *
     * @param text $texteTarifEn
     */
    public function setTexteTarifEn($texteTarifEn)
    {
        $this->texte_tarif_en = $texteTarifEn;
    }

    /**
     * Get texte_tarif_en
     *
     * @return text 
     */
    public function getTexteTarifEn()
    {
        return $this->texte_tarif_en;
    }

    /**
     * Set texte_horaire_fr
     *
     * @param text $texteHoraireFr
     */
    public function setTexteHoraireFr($texteHoraireFr)
    {
        $this->texte_horaire_fr = $texteHoraireFr;
    }

    /**
     * Get texte_horaire_fr
     *
     * @return text 
     */
    public function getTexteHoraireFr()
    {
        return $this->texte_horaire_fr;
    }

    /**
     * Set texte_horaire_en
     *
     * @param text $texteHoraireEn
     */
    public function setTexteHoraireEn($texteHoraireEn)
    {
        $this->texte_horaire_en = $texteHoraireEn;
    }

    /**
     * Get texte_horaire_en
     *
     * @return text 
     */
    public function getTexteHoraireEn()
    {
        return $this->texte_horaire_en;
    }

    /**
     * Set texte_periode_ouverture_fr
     *
     * @param text $textePeriodeOuvertureFr
     */
    public function setTextePeriodeOuvertureFr($textePeriodeOuvertureFr)
    {
        $this->texte_periode_ouverture_fr = $textePeriodeOuvertureFr;
    }

    /**
     * Get texte_periode_ouverture_fr
     *
     * @return text 
     */
    public function getTextePeriodeOuvertureFr()
    {
        return $this->texte_periode_ouverture_fr;
    }

    /**
     * Set texte_periode_ouverture_en
     *
     * @param text $textePeriodeOuvertureEn
     */
    public function setTextePeriodeOuvertureEn($textePeriodeOuvertureEn)
    {
        $this->texte_periode_ouverture_en = $textePeriodeOuvertureEn;
    }

    /**
     * Get texte_periode_ouverture_en
     *
     * @return text 
     */
    public function getTextePeriodeOuvertureEn()
    {
        return $this->texte_periode_ouverture_en;
    }

    /**
     * Set date_debut
     *
     * @param date $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->date_debut = $dateDebut;
    }

    /**
     * Get date_debut
     *
     * @return date 
     */
    public function getDateDebut()
    {
        return $this->date_debut;
    }

    /**
     * Set date_fin
     *
     * @param date $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->date_fin = $dateFin;
    }

    /**
     * Get date_fin
     *
     * @return date 
     */
    public function getDateFin()
    {
        return $this->date_fin;
    }

    /**
     * Set emplacements_0_service_camping
     *
     * @param integer $emplacements0ServiceCamping
     */
    public function setEmplacements0ServiceCamping($emplacements0ServiceCamping)
    {
        $this->emplacements_0_service_camping = $emplacements0ServiceCamping;
    }

    /**
     * Get emplacements_0_service_camping
     *
     * @return integer 
     */
    public function getEmplacements0ServiceCamping()
    {
        return $this->emplacements_0_service_camping;
    }

    /**
     * Set emplacements_1_service_camping
     *
     * @param integer $emplacements1ServiceCamping
     */
    public function setEmplacements1ServiceCamping($emplacements1ServiceCamping)
    {
        $this->emplacements_1_service_camping = $emplacements1ServiceCamping;
    }

    /**
     * Get emplacements_1_service_camping
     *
     * @return integer 
     */
    public function getEmplacements1ServiceCamping()
    {
        return $this->emplacements_1_service_camping;
    }

    /**
     * Set emplacements_2_services_camping
     *
     * @param integer $emplacements2ServicesCamping
     */
    public function setEmplacements2ServicesCamping($emplacements2ServicesCamping)
    {
        $this->emplacements_2_services_camping = $emplacements2ServicesCamping;
    }

    /**
     * Get emplacements_2_services_camping
     *
     * @return integer 
     */
    public function getEmplacements2ServicesCamping()
    {
        return $this->emplacements_2_services_camping;
    }

    /**
     * Set emplacements_3_services_camping
     *
     * @param integer $emplacements3ServicesCamping
     */
    public function setEmplacements3ServicesCamping($emplacements3ServicesCamping)
    {
        $this->emplacements_3_services_camping = $emplacements3ServicesCamping;
    }

    /**
     * Get emplacements_3_services_camping
     *
     * @return integer 
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
     * Set clients_id
     *
     * @param integer $clientsId
     */
    public function setClientsId($clientsId)
    {
        $this->clients_id = $clientsId;
    }

    /**
     * Get clients_id
     *
     * @return integer 
     */
    public function getClientsId()
    {
        return $this->clients_id;
    }

    /**
     * Set villes_id
     *
     * @param integer $villesId
     */
    public function setVillesId($villesId)
    {
        $this->villes_id = $villesId;
    }

    /**
     * Get villes_id
     *
     * @return integer 
     */
    public function getVillesId()
    {
        return $this->villes_id;
    }

    /**
     * Set regions_id
     *
     * @param integer $regionsId
     */
    public function setRegionsId($regionsId)
    {
        $this->regions_id = $regionsId;
    }

    /**
     * Get regions_id
     *
     * @return integer 
     */
    public function getRegionsId()
    {
        return $this->regions_id;
    }

    /**
     * Set provinces_id
     *
     * @param integer $provincesId
     */
    public function setProvincesId($provincesId)
    {
        $this->provinces_id = $provincesId;
    }

    /**
     * Get provinces_id
     *
     * @return integer 
     */
    public function getProvincesId()
    {
        return $this->provinces_id;
    }

    /**
     * Set client_id
     *
     * @param MyApp\GlobalBundle\Entity\Clients $clientId
     */
    public function setClientId(\MyApp\GlobalBundle\Entity\Clients $clientId)
    {
        $this->client_id = $clientId;
    }

    /**
     * Get client_id
     *
     * @return MyApp\GlobalBundle\Entity\Clients 
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Add soins_sante_id
     *
     * @param MyApp\GlobalBundle\Entity\Soins_sante $soinsSanteId
     */
    public function addSoins_sante(\MyApp\GlobalBundle\Entity\Soins_sante $soinsSanteId)
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
     * Add cotation_id
     *
     * @param MyApp\GlobalBundle\Entity\Cotations $cotationId
     */
    public function addCotations(\MyApp\GlobalBundle\Entity\Cotations $cotationId)
    {
        $this->cotation_id[] = $cotationId;
    }

    /**
     * Get cotation_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCotationId()
    {
        return $this->cotation_id;
    }

    /**
     * Add cuisine_id
     *
     * @param MyApp\GlobalBundle\Entity\Cuisines $cuisineId
     */
    public function addCuisines(\MyApp\GlobalBundle\Entity\Cuisines $cuisineId)
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
     * Add attrait_service_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits_services $attraitServiceId
     */
    public function addAttraits_services(\MyApp\GlobalBundle\Entity\Attraits_services $attraitServiceId)
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
     * Add paiement_id
     *
     * @param MyApp\GlobalBundle\Entity\Modes_paiements $paiementId
     */
    public function addModes_paiements(\MyApp\GlobalBundle\Entity\Modes_paiements $paiementId)
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
     * Set qcs_festival_attrait_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_festival_attraits $qcsFestivalAttraitId
     */
    public function setQcsFestivalAttraitId(\MyApp\GlobalBundle\Entity\Qcs_festival_attraits $qcsFestivalAttraitId)
    {
        $this->qcs_festival_attrait_id = $qcsFestivalAttraitId;
    }

    /**
     * Get qcs_festival_attrait_id
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_festival_attraits 
     */
    public function getQcsFestivalAttraitId()
    {
        return $this->qcs_festival_attrait_id;
    }

    /**
     * Set qcs_echo_attrait_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_echos_attraits $qcsEchoAttraitId
     */
    public function setQcsEchoAttraitId(\MyApp\GlobalBundle\Entity\Qcs_echos_attraits $qcsEchoAttraitId)
    {
        $this->qcs_echo_attrait_id = $qcsEchoAttraitId;
    }

    /**
     * Get qcs_echo_attrait_id
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_echos_attraits 
     */
    public function getQcsEchoAttraitId()
    {
        return $this->qcs_echo_attrait_id;
    }

    /**
     * Add attrait_photo_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits_photos $attraitPhotoId
     */
    public function addAttraits_photos(\MyApp\GlobalBundle\Entity\Attraits_photos $attraitPhotoId)
    {
        $this->attrait_photo_id[] = $attraitPhotoId;
    }

    /**
     * Get attrait_photo_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitPhotoId()
    {
        return $this->attrait_photo_id;
    }

    /**
     * Add attrait_videos_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits_videos $attraitVideosId
     */
    public function addAttraits_videos(\MyApp\GlobalBundle\Entity\Attraits_videos $attraitVideosId)
    {
        $this->attrait_videos_id[] = $attraitVideosId;
    }

    /**
     * Get attrait_videos_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitVideosId()
    {
        return $this->attrait_videos_id;
    }

    /**
     * Set attrait_ville_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits_villes $attraitVilleId
     */
    public function setAttraitVilleId(\MyApp\GlobalBundle\Entity\Attraits_villes $attraitVilleId)
    {
        $this->attrait_ville_id = $attraitVilleId;
    }

    /**
     * Get attrait_ville_id
     *
     * @return MyApp\GlobalBundle\Entity\Attraits_villes 
     */
    public function getAttraitVilleId()
    {
        return $this->attrait_ville_id;
    }

    /**
     * Add attrait_activite_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits_activites $attraitActiviteId
     */
    public function addAttraits_activites(\MyApp\GlobalBundle\Entity\Attraits_activites $attraitActiviteId)
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
     * Get attrait_video_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitVideoId()
    {
        return $this->attrait_video_id;
    }
}