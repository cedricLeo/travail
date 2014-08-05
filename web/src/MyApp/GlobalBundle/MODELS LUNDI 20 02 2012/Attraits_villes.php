<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "attraits_villes")
 */
class Attraits_villes{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue( strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\OneToMany(targetEntity="Attraits", mappedBy="Attraits_villes")
	 * 
	 * @var integer $client_id
	 */
	private $attrait_id;
	
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
	 * @ORM\Column(type = "string", length = 12)
	 *
	 * @var string $telephone
	 */
	private $telephone;
	
	/**
	 * @ORM\Column(type = "string", length = 12)
	 *
	 * @var string $telephone_poste
	 */
	private $telephone_poste;
	
	/**
	 * @ORM\Column(type = "string", length = 12)
	 *
	 * @var string $telecopieur
	 */
	private $telecopieur;
	
	/**
	 * @ORM\Column(type = "string", length = 12)
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
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $site_web
	 */
	private $site_web;
	
	/**
	 * @ORM\Column(type = "decimal")
	 *
	 * @var decimal $latitude
	 */
	private $latitude;
	
	/**
	 * @ORM\Column(type = "decimal")
	 *
	 * @var decimal $longitude
	 */
	private $longitude;

    
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
     * Set site_web
     *
     * @param string $siteWeb
     */
    public function setSiteWeb($siteWeb)
    {
        $this->site_web = $siteWeb;
    }

    /**
     * Get site_web
     *
     * @return string 
     */
    public function getSiteWeb()
    {
        return $this->site_web;
    }

    /**
     * Set latitude
     *
     * @param decimal $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get latitude
     *
     * @return decimal 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param decimal $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return decimal 
     */
    public function getLongitude()
    {
        return $this->longitude;
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
}