<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Appel_OffreRepository")
 * @ORM\Table(name = "appel_offre")
 * @ORM\HasLifecycleCallbacks
 */
class Appel_Offre
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type ="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Hebergements_salles_corporatives", mappedBy = "Appel_Offre")
	 *  
	 * @var ArrayCollection $salle_corporative_hebergement_id
	 */
	private $salle_corporative_hebergement_id;
	
	/**
	 * @ORM\Column(type = "string", length = "100")
	 * 
	 * @var string $prenom
	 */
	private $prenom;
	
	/**
	 * @ORM\Column(type = "string", length = "100")
	 *
	 * @var string $nom
	 */
	private $nom;
	
	/**
	 * @ORM\Column(type = "string", length = "100")
	 *
	 * @var string $email
	 */
	private $email;
	
	/**
	 * @ORM\Column(type = "string", length = "100", nullable = "true")
	 *
	 * @var string $nom_entreprise
	 */
	private $nom_entreprise;
	
	/**
	 * @ORM\Column(type = "string", length = "100")
	 *
	 * @var string $adresse
	 */
	private $adresse;
	
	/**
	 * @ORM\Column(type = "string", length = "60")
	 *
	 * @var string $ville
	 */
	private $ville;
	
	/**
	 * @ORM\Column(type = "string", length = "60")
	 *
	 * @var string $province_etat
	 */
	private $province_etat;
	
	/**
	 * @ORM\Column(type = "string", length = "7")
	 *
	 * @var string $code_postal
	 */
	private $code_postal;
	
	/**
	 * @ORM\Column(type = "string", length = "60", nullable = "true")
	 *
	 * @var string $pays_offre
	 */
	private $pays_offre;
	
	/**
	 * @ORM\Column(type = "string", length = "22")
	 *
	 * @var string $telephone
	 */
	private $telephone;
	
	/**
	 * @ORM\Column(type = "string", length = "22")
	 *
	 * @var string $telecopieur
	 */
	private $telecopieur;
	
	/**
	 * @ORM\Column(type = "integer", length = "2", nullable = "true")
	 *
	 * @var integer $nb_chambre
	 */
	private $nb_chambre;
	
	/**
	 * @ORM\Column(type = "integer", length = "1", nullable = "true")
	 *
	 * @var integer $type_chambre
	 */
	private $type_chambre;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 *
	 * @var text $demande_specifique_hebergement
	 */
	private $demande_specifique_hebergement;
	
	/**
	 * @ORM\Column(type = "string", length = "100", nullable = "true")
	 *
	 * @var string $nom_reunion
	 */
	private $nom_reunion;
	
	/**
	 * @ORM\Column(type = "integer", length = "3", nullable = "true")
	 *
	 * @var integer $nb_personne
	 */
	private $nb_personne;
	
	/**
	 * @ORM\Column(type = "date")
	 *
	 * @var date $date_arrivee
	 */
	private $date_arrivee;
	
	/**
	 * @ORM\Column(type = "date")
	 *
	 * @var date $date_depart
	 */
	private $date_depart;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 *
	 * @var boolean $date_flexible
	 */
	private $date_flexible;
	
	/**
	 * @ORM\Column(type = "string", length = "50", nullable = "true")
	 *
	 * @var string $disposition_salle
	 */
	private $disposition_salle;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 *
	 * @var text $description_equipement
	 */
	private $description_equipement;
	
	/**
	 * @ORM\Column(type = "string", length = "50", nullable = "true")
	 *
	 * @var string $type_evenement
	 */
	private $type_evenement;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Provinces_etats", inversedBy="Appel_Offre")
	 * 
	 * @var integer $province_id
	 */
	private $province_id;
	
	/**
	 * @ORM\Column(type = "string", length = "50", nullable = "false")
	 *
	 * @var string $pays
	 */
	private $pays;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Regions", inversedBy = "Appel_Offre")
	 *
	 * @var integer $region
	 */
	private $region;
	
	/**
	 * @ORM\Column(type = "boolean",  nullable = "false")
	 *
	 * @var boolean $type_offre
	 */
	private $type_offre;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Types_evenements", inversedBy = "Appel_Offre")
	 *
	 * @var integer $type_event_id
	 */
	private $type_event_id;
	
	public function __construct()
	{
		$this->salle_corporative_hebergement_id 	= new ArrayCollection();
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
     * Set prenom
     *
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nom_entreprise
     *
     * @param string $nomEntreprise
     */
    public function setNomEntreprise($nomEntreprise)
    {
        $this->nom_entreprise = $nomEntreprise;
    }

    /**
     * Get nom_entreprise
     *
     * @return string 
     */
    public function getNomEntreprise()
    {
        return $this->nom_entreprise;
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
     * Set ville
     *
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set province_etat
     *
     * @param string $provinceEtat
     */
    public function setProvinceEtat($provinceEtat)
    {
        $this->province_etat = $provinceEtat;
    }

    /**
     * Get province_etat
     *
     * @return string 
     */
    public function getProvinceEtat()
    {
        return $this->province_etat;
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
     * Set pays_offre
     *
     * @param string $paysOffre
     */
    public function setPaysOffre($paysOffre)
    {
        $this->pays_offre = $paysOffre;
    }

    /**
     * Get pays_offre
     *
     * @return string 
     */
    public function getPaysOffre()
    {
        return $this->pays_offre;
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
     * Set nb_chambre
     *
     * @param integer $nbChambre
     */
    public function setNbChambre($nbChambre)
    {
        $this->nb_chambre = $nbChambre;
    }

    /**
     * Get nb_chambre
     *
     * @return integer 
     */
    public function getNbChambre()
    {
        return $this->nb_chambre;
    }

    /**
     * Set type_chambre
     *
     * @param integer $typeChambre
     */
    public function setTypeChambre($typeChambre)
    {
        $this->type_chambre = $typeChambre;
    }

    /**
     * Get type_chambre
     *
     * @return integer 
     */
    public function getTypeChambre()
    {
        return $this->type_chambre;
    }

    /**
     * Set demande_specifique_hebergement
     *
     * @param text $demandeSpecifiqueHebergement
     */
    public function setDemandeSpecifiqueHebergement($demandeSpecifiqueHebergement)
    {
        $this->demande_specifique_hebergement = $demandeSpecifiqueHebergement;
    }

    /**
     * Get demande_specifique_hebergement
     *
     * @return text 
     */
    public function getDemandeSpecifiqueHebergement()
    {
        return $this->demande_specifique_hebergement;
    }

    /**
     * Set nom_reunion
     *
     * @param string $nomReunion
     */
    public function setNomReunion($nomReunion)
    {
        $this->nom_reunion = $nomReunion;
    }

    /**
     * Get nom_reunion
     *
     * @return string 
     */
    public function getNomReunion()
    {
        return $this->nom_reunion;
    }

    /**
     * Set nb_personne
     *
     * @param integer $nbPersonne
     */
    public function setNbPersonne($nbPersonne)
    {
        $this->nb_personne = $nbPersonne;
    }

    /**
     * Get nb_personne
     *
     * @return integer 
     */
    public function getNbPersonne()
    {
        return $this->nb_personne;
    }

    /**
     * Set date_arrivee
     *
     * @param date $dateArrivee
     */
    public function setDateArrivee($dateArrivee)
    {
        $this->date_arrivee = $dateArrivee;
    }

    /**
     * Get date_arrivee
     *
     * @return date 
     */
    public function getDateArrivee()
    {
        return $this->date_arrivee;
    }

    /**
     * Set date_depart
     *
     * @param date $dateDepart
     */
    public function setDateDepart($dateDepart)
    {
        $this->date_depart = $dateDepart;
    }

    /**
     * Get date_depart
     *
     * @return date 
     */
    public function getDateDepart()
    {
        return $this->date_depart;
    }

    /**
     * Set date_flexible
     *
     * @param boolean $dateFlexible
     */
    public function setDateFlexible($dateFlexible)
    {
        $this->date_flexible = $dateFlexible;
    }

    /**
     * Get date_flexible
     *
     * @return boolean 
     */
    public function getDateFlexible()
    {
        return $this->date_flexible;
    }

    /**
     * Set disposition_salle
     *
     * @param string $dispositionSalle
     */
    public function setDispositionSalle($dispositionSalle)
    {
        $this->disposition_salle = $dispositionSalle;
    }

    /**
     * Get disposition_salle
     *
     * @return string 
     */
    public function getDispositionSalle()
    {
        return $this->disposition_salle;
    }

    /**
     * Set description_equipement
     *
     * @param text $descriptionEquipement
     */
    public function setDescriptionEquipement($descriptionEquipement)
    {
        $this->description_equipement = $descriptionEquipement;
    }

    /**
     * Get description_equipement
     *
     * @return text 
     */
    public function getDescriptionEquipement()
    {
        return $this->description_equipement;
    }

    /**
     * Set type_evenement
     *
     * @param string $typeEvenement
     */
    public function setTypeEvenement($typeEvenement)
    {
        $this->type_evenement = $typeEvenement;
    }

    /**
     * Get type_evenement
     *
     * @return string 
     */
    public function getTypeEvenement()
    {
        return $this->type_evenement;
    }

    /**
     * Set province
     *
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * Get province
     *
     * @return string 
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set pays
     *
     * @param string $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set region
     *
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set type_offre
     *
     * @param boolean $typeOffre
     */
    public function setTypeOffre($typeOffre)
    {
        $this->type_offre = $typeOffre;
    }

    /**
     * Get type_offre
     *
     * @return boolean 
     */
    public function getTypeOffre()
    {
        return $this->type_offre;
    }

    /**
     * Add salle_corporative_hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives $salleCorporativeHebergementId
     */
    public function addHebergements_salles_corporatives(\MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives $salleCorporativeHebergementId)
    {
        $this->salle_corporative_hebergement_id[] = $salleCorporativeHebergementId;
    }

    /**
     * Get salle_corporative_hebergement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSalleCorporativeHebergementId()
    {
        return $this->salle_corporative_hebergement_id;
    }

    /**
     * Set type_event_id
     *
     * @param MyApp\GlobalBundle\Entity\Types_evenements $typeEventId
     */
    public function setTypeEventId(\MyApp\GlobalBundle\Entity\Types_evenements $typeEventId)
    {
        $this->type_event_id = $typeEventId;
    }

    /**
     * Get type_event_id
     *
     * @return MyApp\GlobalBundle\Entity\Types_evenements 
     */
    public function getTypeEventId()
    {
        return $this->type_event_id;
    }

    /**
     * Add province_id
     *
     * @param MyApp\GlobalBundle\Entity\Provinces_etats $provinceId
     */
    public function addProvinces_etats(\MyApp\GlobalBundle\Entity\Provinces_etats $provinceId)
    {
        $this->province_id[] = $provinceId;
    }

    /**
     * Get province_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProvinceId()
    {
        return $this->province_id;
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
}