<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="clients")
 */
class Clients{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $no_interne
	 */
	private $no_interne;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $password
	 */
	private $password;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $nom
	 */
	private $nom;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $adresse
	 */
	private $adresse;
	
	/**
	 * @ORM\Column(type="string", length = 7)
	 * 
	 * @var string $code_postal
	 */
	private $code_postal;
	
	/**
	 * @ORM\Column(type ="string", length = 10)
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
	 * @var string $sans_frais
	 */
	private $sans_frais;
	
	/**
	 * @ORM\Column(type = "string", length = 10)
	 * 
	 * @var string $telecopieur
	 */
	private $telecopieur;
	
	/**
	 * @ORM\Column(type="string", length = 100)
	 * 
	 * @var string $courriel
	 */
	private $courriel;
	
	/**
	 * @ORM\Column(type="string", length = 100)
	 * 
	 * @var string $siteweb
	 */
	private $siteweb;
	
	/**
	 * @ORM\column(type = "datetime")
	 * 
	 * @var datetime $date_de_log
	 */
	private $date_de_log;
	
	/**
	 * @ORM\Column(type = "integer", length = 2)
	 * 
	 * @var integer $nb_log_par_mois
	 */
	private $nb_log_par_mois;
	
	/**
	 * @ORM\OneToOne(targetEntity = "Qcs_echos_clients", mappedBy = "Clients" )
	 * 
	 * @var integer $qcs_echo_client
	 */
	private $qcs_echo_client;
	

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
     * Set no_interne
     *
     * @param string $noInterne
     */
    public function setNoInterne($noInterne)
    {
        $this->no_interne = $noInterne;
    }

    /**
     * Get no_interne
     *
     * @return string 
     */
    public function getNoInterne()
    {
        return $this->no_interne;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
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
     * Set date_de_log
     *
     * @param datetime $dateDeLog
     */
    public function setDateDeLog($dateDeLog)
    {
        $this->date_de_log = $dateDeLog;
    }

    /**
     * Get date_de_log
     *
     * @return datetime 
     */
    public function getDateDeLog()
    {
        return $this->date_de_log;
    }

    /**
     * Set nb_log_par_mois
     *
     * @param integer $nbLogParMois
     */
    public function setNbLogParMois($nbLogParMois)
    {
        $this->nb_log_par_mois = $nbLogParMois;
    }

    /**
     * Get nb_log_par_mois
     *
     * @return integer 
     */
    public function getNbLogParMois()
    {
        return $this->nb_log_par_mois;
    }

    /**
     * Set qcs_echo_client
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_echos_clients $qcsEchoClient
     */
    public function setQcsEchoClient(\MyApp\GlobalBundle\Entity\Qcs_echos_clients $qcsEchoClient)
    {
        $this->qcs_echo_client = $qcsEchoClient;
    }

    /**
     * Get qcs_echo_client
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_echos_clients 
     */
    public function getQcsEchoClient()
    {
        return $this->qcs_echo_client;
    }
}