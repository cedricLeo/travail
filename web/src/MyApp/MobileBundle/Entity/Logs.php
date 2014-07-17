<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\LogsRepository")
 * @ORM\Table(name = "logs")
 * @ORM\HasLifecycleCallbacks
 */
class Logs{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="integer", nullable="false")
	 * 
	 * @var integer $utilisateur_id
	 */
	private $utilisateur_id;
	
	/**
	 * @ORM\Column(type="datetime", nullable="false")
	 * 
	 * @var datetime $date_connexion
	 */
	private $date_connexion;
	
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
     * Set date_connexion
     *
     * @param datetime $dateConnexion
     */
    public function setDateConnexion($dateConnexion)
    {
        $this->date_connexion = $dateConnexion;
    }

    /**
     * Get date_connexion
     *
     * @return datetime 
     */
    public function getDateConnexion()
    {
        return $this->date_connexion;
    }


    /**
     * Set utilisateur_id
     *
     * @param integer $utilisateurId
     */
    public function setUtilisateurId($utilisateurId)
    {
        $this->utilisateur_id = $utilisateurId;
    }

    /**
     * Get utilisateur_id
     *
     * @return integer 
     */
    public function getUtilisateurId()
    {
        return $this->utilisateur_id;
    }

}