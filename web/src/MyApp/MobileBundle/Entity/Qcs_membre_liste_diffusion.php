<?php

namespace MyApp\MobileBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "qcs_membre_liste_diffusion")
 * @ORM\HasLifecycleCallbacks
 */
class Qcs_membre_liste_diffusion{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer")
	 *
	 * @var integer $id
	 */
	private $id;

	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $courriel
	 */
	private $courriel;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $langue
	 */
	private $langue;
	
	/**
	 * @ORM\Column(type = "boolean")
	 *
	 * @var boolean $sexe
	 */
	private $sexe;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $nom
	 */
	private $nom;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $prenom
	 */
	private $prenom;
	
	/**
	 * @ORM\Column(type = "string", length = 100)
	 *
	 * @var string $province
	 */
	private $province;
	
	/**
	 * @ORM\Column(type = "string", length = 100)
	 *
	 * @var string $pays
	 */
	private $pays;
	
	/**
	 * @ORM\Column(type = "string", length = 7)
	 *
	 * @var string $code_postal
	 */
	private $code_postal;
	
	/**
	 * @ORM\Column(type = "date")
	 *
	 * @var date $date_inscription
	 */
	private $date_inscription;
	

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
     * Set langue
     *
     * @param string $langue
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;
    }

    /**
     * Get langue
     *
     * @return string 
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Set sexe
     *
     * @param boolean $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * Get sexe
     *
     * @return boolean 
     */
    public function getSexe()
    {
        return $this->sexe;
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
     * Set date_inscription
     *
     * @param date $dateInscription
     */
    public function setDateInscription($dateInscription)
    {
        $this->date_inscription = $dateInscription;
    }

    /**
     * Get date_inscription
     *
     * @return date 
     */
    public function getDateInscription()
    {
        return $this->date_inscription;
    }
}