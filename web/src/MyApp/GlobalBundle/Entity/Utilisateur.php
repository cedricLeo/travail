<?php 
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * MyApp\GlobalBundle\Entity\Utilisateur
 * @ORM\Table(name="utilisateur", indexes={@ORM\index(name="utilisateur_idx", columns={"username"})})
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\UtilisateurRepository")
 * 
 */
class Utilisateur implements UserInterface 
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true, nullable = true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=40, nullable = true)
     */
    private $password;
    
    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    private $reset_password;

    /**
     * @ORM\Column(type="string", length=60, nullable = true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\Column(type="string", length=25, nullable = "true")
     */
    private $role;
    
    /**
     * @ORM\Column(type = "date", nullable = "true")
     *
     * @var date $date_creation
     */
    private $date_creation;
    
    /**
     * @ORM\Column(type = "string", length="100",  nullable="true")
     *
     * @var string $valider_par
     */
    private $valider_par;
    
    /**
     * @ORM\Column(type="string", length = 255, nullable="true")
     *
     * @var string $siteweb
     */
    private $siteweb;
    
    /**
     * @ORM\Column(type="string", length = 255, nullable = "false")
     *
     * @var string $nom
     */
    private $nom;
    
    /**
     * @ORM\Column(type="string", length = 255, nullable = "false")
     *
     * @var string $adresse
     */
    private $adresse;
    
    /**
     * @ORM\Column(type="string", length = 7, nullable = "false")
     *
     * @var string $code_postal
     */
    private $code_postal;
    
    /**
     * @ORM\Column(type ="string", length = 20, nullable= "false")
     *
     * @var string $telephone
     */
    private $telephone;
    
    /**
     * @ORM\Column(type = "string", length = 8, nullable = "true")
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
     * @ORM\Column(type = "string", length = 20, nullable = "true" )
     *
     * @var string $telecopieur
     */
    private $telecopieur;
    
    /**
     * @ORM\ManyToOne(targetEntity="Villes", inversedBy="Utilisateur")
     * @ORM\JoinColumn(name ="villes", referencedColumnName="id")
     *
     * @var integer $villes
     */
    private $villes;
    
    /**
     * @ORM\OneToMany(targetEntity="Hebergements", mappedBy="Utilisateur", cascade={"persist", "remove"})
     * 
     * @var ArrayCollection $hebergements
     */
    private $hebergements;
    
    /**
     * @ORM\OneToMany(targetEntity="Attraits", mappedBy="Utilisateur", cascade={"persist", "remove"})
     * 
     * @var ArrayCollection $attraits
     */
    private $attraits;
    
    /**
     * @ORM\Column(type = "boolean", nullable="true")
     *
     * @var boolean $hebergement_existe
     */
    private $hebergement_existe;
    
    /**
     * @ORM\Column(type = "boolean", nullable="true")
     *
     * @var boolean $attrait_existe
     */
    private $attrait_existe;
    
    public function __construct()
    {
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
        $this->attraits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hebergements = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __sleep(){
         return array('id', 'username', 'email');
    }
    
    public function __toString()
    {
    	return $this->nom;
    }
    
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->role);
    }
    
    /**
     * @inheritDoc
     */
    public function setRoles($role)
    {
    	$this->role = $role;
    }
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
    
    /**
     * @param UserInterface $user
     */
    public function equals(UserInterface $user) 
    {	
            return $this->username === $user->getUsername();
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
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
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
     * Set isActive
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set role
     *
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set reset_password
     *
     * @param boolean $resetPassword
     */
    public function setResetPassword($resetPassword)
    {
        $this->reset_password = $resetPassword;
    }

    /**
     * Get reset_password
     *
     * @return boolean 
     */
    public function getResetPassword()
    {
        return $this->reset_password;
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
     * Set villes
     *
     * @param MyApp\GlobalBundle\Entity\Villes $villes
     */
    public function setVilles(\MyApp\GlobalBundle\Entity\Villes $villes)
    {
        $this->villes = $villes;
    }

    /**
     * Get villes
     *
     * @return MyApp\GlobalBundle\Entity\Villes 
     */
    public function getVilles()
    {
        return $this->villes;
    }

   

    /**
     * Add hebergements
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergements
     */
    public function addHebergements(\MyApp\GlobalBundle\Entity\Hebergements $hebergements)
    {
        $this->hebergements[] = $hebergements;
        //$hebergements->setUtilisateur($this);
        return $this;
    }

    /**
     * Get hebergements
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergements()
    {
        return $this->hebergements;
    }

    /**
     * Add attraits
     *
     * @param MyApp\GlobalBundle\Entity\Attraits $attraits
     */
    public function addAttraits(\MyApp\GlobalBundle\Entity\Attraits $attraits)
    {
        $this->attraits[] = $attraits;
        //$attraits->setUtilisateur($this);
        return $this;
    }

    /**
     * Get attraits
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraits()
    {
        return $this->attraits;
    }

    /**
     * Set hebergement_existe
     *
     * @param boolean $hebergementExiste
     */
    public function setHebergementExiste($hebergementExiste)
    {
        $this->hebergement_existe = $hebergementExiste;
    }

    /**
     * Get hebergement_existe
     *
     * @return boolean 
     */
    public function getHebergementExiste()
    {
        return $this->hebergement_existe;
    }

    /**
     * Set attrait_existe
     *
     * @param boolean $attraitExiste
     */
    public function setAttraitExiste($attraitExiste)
    {
        $this->attrait_existe = $attraitExiste;
    }

    /**
     * Get attrait_existe
     *
     * @return boolean 
     */
    public function getAttraitExiste()
    {
        return $this->attrait_existe;
    }
}