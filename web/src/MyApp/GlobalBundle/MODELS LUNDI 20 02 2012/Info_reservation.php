<?php
namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "info_reservation")
 */
class Info_reservation
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type = "string", length = 100)
	 * 
	 * @var string $prenom
	 */
	private $prenom;
	
	/**
	* @ORM\Column(type = "string", length = 100)
	* 
	* @var string $nom
	*/
	private $nom;
	
	/**
	* @ORM\Column(type = "text")
	*
	* @var text $adresse
	*/
	private $adresse;
	
	/**
	* @ORM\Column(type = "string", length = 100)
	*
	* @var string $ville
	*/
	private $ville;
	
	/**
	* @ORM\Column(type = "string", length = 100)
	*
	* @var string $province_etat
	*/
	private $province_etat;
	
	/**
	* @ORM\Column(type = "string", length = 100)
	*
	* @var string $pays
	*/
	private $pays;
	
	/**
	* @ORM\Column(type = "string", length = 7)
	*
	* @var string $codepostal
	*/
	private $codepostal;
	
	/**
	* @ORM\Column(type = "string", length = 12)
	*
	* @var string $telephone
	*/
	private $telephone;
	
	/**
	* @ORM\Column(type = "string", length = 12)
	*
	* @var string $telecopieur
	*/
	private $telecopieur;
	
	/**
	* @ORM\Column(type = "string", length = 100)
	*
	* @var string $email
	*/
	private $email;
	
	/**
	* @ORM\Column(type = "string", length = 100)
	*
	* @var string $confirmemail
	*/
	private $confirmemail;
	
	/**
	* @ORM\Column(type = "date")
	*
	* @var date $date_arrive
	*/
	private $date_arrive;
	
	/**
	* @ORM\Column(type = "integer")
	*
	* @var integer $nb_nuit
	*/
	private $nb_nuit;
	
	/**
	* @ORM\Column(type = "integer")
	*
	* @var integer $nb_adulte
	*/
	private $nb_adulte;
	
	/**
	* @ORM\Column(type = "integer")
	*
	* @var integer $nbenfant
	*/
	private $nb_enfant;
	
	/**
	* @ORM\Column(type = "integer")
	*
	* @var integer $age_enfant
	*/
	private $age_enfant;
	
	/**
	* @ORM\Column(type = "integer")
	*
	* @var integer $nb_chambre
	*/
	private $nb_chambre;
	
	/**
	* @ORM\Column(type = "boolean")
	*
	* @var boolean $chambre_fumeur
	*/
	private $chambre_fumeur;
	
	/**
	* @ORM\Column(type = "text")
	*
	* @var text $commentaire
	*/
	private $commentaire;


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
     * Set codepostal
     *
     * @param string $codepostal
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;
    }

    /**
     * Get codepostal
     *
     * @return string 
     */
    public function getCodepostal()
    {
        return $this->codepostal;
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
     * Set confirmemail
     *
     * @param string $confirmemail
     */
    public function setConfirmemail($confirmemail)
    {
        $this->confirmemail = $confirmemail;
    }

    /**
     * Get confirmemail
     *
     * @return string 
     */
    public function getConfirmemail()
    {
        return $this->confirmemail;
    }

    /**
     * Set date_arrive
     *
     * @param date $dateArrive
     */
    public function setDateArrive($dateArrive)
    {
        $this->date_arrive = $dateArrive;
    }

    /**
     * Get date_arrive
     *
     * @return date 
     */
    public function getDateArrive()
    {
        return $this->date_arrive;
    }

    /**
     * Set nb_nuit
     *
     * @param integer $nbNuit
     */
    public function setNbNuit($nbNuit)
    {
        $this->nb_nuit = $nbNuit;
    }

    /**
     * Get nb_nuit
     *
     * @return integer 
     */
    public function getNbNuit()
    {
        return $this->nb_nuit;
    }

    /**
     * Set nb_adulte
     *
     * @param integer $nbAdulte
     */
    public function setNbAdulte($nbAdulte)
    {
        $this->nb_adulte = $nbAdulte;
    }

    /**
     * Get nb_adulte
     *
     * @return integer 
     */
    public function getNbAdulte()
    {
        return $this->nb_adulte;
    }

    /**
     * Set nb_enfant
     *
     * @param integer $nbEnfant
     */
    public function setNbEnfant($nbEnfant)
    {
        $this->nb_enfant = $nbEnfant;
    }

    /**
     * Get nb_enfant
     *
     * @return integer 
     */
    public function getNbEnfant()
    {
        return $this->nb_enfant;
    }

    /**
     * Set age_enfant
     *
     * @param integer $ageEnfant
     */
    public function setAgeEnfant($ageEnfant)
    {
        $this->age_enfant = $ageEnfant;
    }

    /**
     * Get age_enfant
     *
     * @return integer 
     */
    public function getAgeEnfant()
    {
        return $this->age_enfant;
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
     * Set chambre_fumeur
     *
     * @param boolean $chambreFumeur
     */
    public function setChambreFumeur($chambreFumeur)
    {
        $this->chambre_fumeur = $chambreFumeur;
    }

    /**
     * Get chambre_fumeur
     *
     * @return boolean 
     */
    public function getChambreFumeur()
    {
        return $this->chambre_fumeur;
    }

    /**
     * Set commentaire
     *
     * @param text $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * Get commentaire
     *
     * @return text 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
}