<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Forfaits_clientsRepository")
 * @ORM\Table(name = "forfaits_clients")
 * @ORM\HasLifecycleCallbacks
 */
class Forfaits_clients{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type = "date", nullable="true")
	 *
	 * @var date $date_debut
	 */
	private $date_debut;
	
	/**
	 * @ORM\Column(type = "date", nullable="true")
	 *
	 * @var date $date_de_fin
	 */
	private $date_de_fin;        
        
        /**
	 * @ORM\Column(type = "date", nullable="true")
	 *
	 * @var date $date_creation
	 */
	private $date_creation;  
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 *
	 * @var boolean $tarif_derniere_minute
	 */
	private $tarif_derniere_minute;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "false")
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "false")
	 * 
	 * @var string $nom_en
	 */
	private $nom_en;
	
	/**
	 * @ORM\Column( type = "text", nullable="true")
	 * 
	 * @var text $texte_fr
	 */
	private $texte_fr;
	
	/**
	 * @ORM\Column( type = "text", nullable="true")
	 * 
	 * @var text $texte_en
	 */
	private $texte_en;
	
	/**
	 * @ORM\Column( type = "text", nullable="true")
	 *
	 * @var text $descriptif_derniere_minute_fr
	 */
	private $descriptif_derniere_minute_fr;
	
	/**
	 * @ORM\Column( type = "text", nullable="true")
	 *
	 * @var text $descriptif_derniere_minute_en
	 */
	private $descriptif_derniere_minute_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable="true")
     *
	 * @var string $image_categorie
	 */
	private $image_categorie;
	
	/**
	 * @ORM\Column(type = "boolean", nullable="true")
	 *
	 * @var boolean $actif
	 */
	private $actif;
	
	/**
	 * @ORM\Column(type = "string", length = 10, nullable="false")
	 *
	 * @var string $tarif
	 */
	private $tarif;
	
	/**
	 * @ORM\Column(type = "datetime", nullable="true")
	 *
	 * @var datetime $publication
	 */
	private $publication;
	
        /**
	* @ORM\Column(type = "boolean", nullable="true")
	*
	* @var boolean $derniere_minute
	*/
	private $derniere_minute;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "false")
	 *
	 * @var string $titre_derniere_minute_fr
	 */
	private $titre_derniere_minute_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "false")
	 *
	 * @var string $titre_derniere_minute_en
	 */
	private $titre_derniere_minute_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable="true")
	 *
	 * @var string $image_categorie_doctrine
	 */
	private $image_categorie_doctrine;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable="true")
	 *
	 * @var string $image_principale_doctrine
	 */
	private $image_principale_doctrine;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable="true")
	 *
	 * @var string $image_principale
	 */
	private $image_principale;
	
	public function getFullPicturePrincipalePath() {
		return null === $this->image_principale ? null : $this->getUploadRootPrincipaleDir(). $this->image_principale;
	}
	
	protected function getUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDir().$this->getId()."/";
	}
	
	protected function getUploadRootPrincipaleDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootPrincipaleDir().$this->getId()."/";
	}
	
	protected function getTmpUploadRootPrincipaleDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/forfaits-client/image_principale/';
	}
	
        public function getAccessRepertoire(){
            return $this->getTmpUploadRootPrincipaleDir();
        }
        
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function uploadPicturePrincipale() {
		// the file property can be empty if the field is not required
		if (null === $this->image_principale) {
			return;
		}
		if (null === $this->image_principale_doctrine) {
			return;
		}
		if(!$this->id){
			$this->image_principale->move($this->getTmpUploadRootPrincipaleDir(), $this->image_principale->getClientOriginalName());
		}else{
			$this->image_principale->move($this->getUploadRootPrincipaleDir(), $this->image_principale->getClientOriginalName());
		}
		$this->setImagePrincipale($this->image_principale->getClientOriginalName());
	}
	
	/**
	 * @ORM\PostPersist()
	 */
	public function movePicturePrincipale()
	{
		if (null === $this->image_principale) {
			return;
		}
		if(!is_dir($this->getUploadRootPrincipaleDir())){
			mkdir($this->getUploadRootPrincipaleDir());
		}
		copy($this->getTmpUploadRootPrincipaleDir().$this->image_principale, $this->getFullPicturePrincipalePath());
		unlink($this->getTmpUploadRootPrincipaleDir().$this->image_principale);
	}
	
	/**
	 * @ORM\PreRemove()
	 */
	public function remove()
	{
		if($this->getFullPicturePrincipalePath()){
			unlink($this->getFullPicturePrincipalePath());
			rmdir($this->getUploadRootPrincipaleDir());
		}
	}
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Forfaits", inversedBy = "Forfaits_clients")
	 * @ORM\JoinColumn(name = "forfait_client_id", referencedColumnName = "id")
	 *
	 * @var integer $forfait_client_id
	 */
	private $forfait_client_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Hebergements", inversedBy = "Forfaits_clients")
	 * @ORM\JoinColumn(name = "hebergement_id", referencedColumnName = "id")
	 *
	 * @var integer $hebergement_id
	 */
	private $hebergement_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Hebergements_salles_corporatives", inversedBy = "Forfaits_clients")
	 *
	 * @var integer $corpo_id
	 */
	private $corpo_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Galerie_forfaits", cascade={"persist", "remove"})
	 * 
	 * @var array_collection $galerie_forfaits
	 */
	private $galerie_forfaits;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = true)
	 *
	 * @var boolean $reserver_forfait_en_ligne
	 */
	private $reserver_forfait_en_ligne;
	
	
	public function __construct()
	{
		$this->galerie_forfaits = new ArrayCollection();
	}
	
	public function __toString()
	{
		return $this->nom_fr;
		//return $this->nom_en;
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
     * Set date_de_fin
     *
     * @param date $dateDeFin
     */
    public function setDateDeFin($dateDeFin)
    {
        $this->date_de_fin = $dateDeFin;
    }

    /**
     * Get date_de_fin
     *
     * @return date 
     */
    public function getDateDeFin()
    {
        return $this->date_de_fin;
    }

    /**
     * Set tarif_derniere_minute
     *
     * @param boolean $tarifDerniereMinute
     */
    public function setTarifDerniereMinute($tarifDerniereMinute)
    {
        $this->tarif_derniere_minute = $tarifDerniereMinute;
    }

    /**
     * Get tarif_derniere_minute
     *
     * @return boolean 
     */
    public function getTarifDerniereMinute()
    {
        return $this->tarif_derniere_minute;
    }

    /**
     * Set nom_fr
     *
     * @param string $nomFr
     */
    public function setNomFr($nomFr)
    {
        $this->nom_fr = htmlentities($nomFr);
    }

    /**
     * Get nom_fr
     *
     * @return string 
     */
    public function getNomFr()
    {
        return html_entity_decode($this->nom_fr);
    }

    /**
     * Set nom_en
     *
     * @param string $nomEn
     */
    public function setNomEn($nomEn)
    {
        $this->nom_en = htmlentities($nomEn);
    }

    /**
     * Get nom_en
     *
     * @return string 
     */
    public function getNomEn()
    {
        return html_entity_decode( $this->nom_en);
    }

    /**
     * Set texte_fr
     *
     * @param text $texteFr
     */
    public function setTexteFr($texteFr)
    {
        $this->texte_fr = htmlentities($texteFr);
    }

    /**
     * Get texte_fr
     *
     * @return text 
     */
    public function getTexteFr()
    {
        return html_entity_decode($this->texte_fr);
    }

    /**
     * Set texte_en
     *
     * @param text $texteEn
     */
    public function setTexteEn($texteEn)
    {
        $this->texte_en = htmlentities($texteEn);
    }

    /**
     * Get texte_en
     *
     * @return text 
     */
    public function getTexteEn()
    {
        return html_entity_decode($this->texte_en);
    }

    /**
     * Set image_categorie
     *
     * @param string $image_categorie
     */
    public function setImageCategorie($image_categorie)
    {
        $this->image_categorie = $image_categorie;
    }

    /**
     * Get image_categorie
     *
     * @return string 
     */
    public function getImageCategorie()
    {
        return $this->image_categorie;
    }

    /**
     * Set image_categorie_doctrine
     *
     * @param string $imageCategorieDoctrine
     */
    public function setImageCategorieDoctrine($imageCategorieDoctrine)
    {
        $this->image_categorie_doctrine = $imageCategorieDoctrine;
    }

    /**
     * Get image_categorie_doctrine
     *
     * @return string 
     */
    public function getImageCategorieDoctrine()
    {
        return $this->image_categorie_doctrine;
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
     * Get forfait_client_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getForfaitClientId()
    {
        return $this->forfait_client_id;
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
     * Set forfait_client_id
     *
     * @param MyApp\GlobalBundle\Entity\Forfaits $forfaitClientId
     */
    public function setForfaitClientId(\MyApp\GlobalBundle\Entity\Forfaits $forfaitClientId)
    {
        $this->forfait_client_id = $forfaitClientId;
    }

    /**
     * Set hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementId
     */
    public function setHebergementId(\MyApp\GlobalBundle\Entity\Hebergements $hebergementId)
    {
        $this->hebergement_id = $hebergementId;
    }

    /**
     * Set tarif
     *
     * @param string $tarif
     */
    public function setTarif($tarif)
    {
        $this->tarif = htmlentities($tarif);
    }

    /**
     * Get tarif
     *
     * @return string 
     */
    public function getTarif()
    {
        return html_entity_decode( $this->tarif);
    }

    /**
     * Set corpo_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives $corpoId
     */
    public function setCorpoId(\MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives $corpoId)
    {
        $this->corpo_id = $corpoId;
    }

    /**
     * Get corpo_id
     *
     * @return MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives 
     */
    public function getCorpoId()
    {
        return $this->corpo_id;
    }

    /**
     * Set attrait_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits $attraitId
     */
    public function setAttraitId(\MyApp\GlobalBundle\Entity\Attraits $attraitId)
    {
        $this->attrait_id = $attraitId;
    }

    /**
     * Set image_principale_doctrine
     *
     * @param string $imagePrincipaleDoctrine
     */
    public function setImagePrincipaleDoctrine($imagePrincipaleDoctrine)
    {
        $this->image_principale_doctrine = $imagePrincipaleDoctrine;
    }

    /**
     * Get image_principale_doctrine
     *
     * @return string 
     */
    public function getImagePrincipaleDoctrine()
    {
        return $this->image_principale_doctrine;
    }

    /**
     * Set image_principale
     *
     * @param string $imagePrincipale
     */
    public function setImagePrincipale($imagePrincipale)
    {
        $this->image_principale = $imagePrincipale;
    }

    /**
     * Get image_principale
     *
     * @return string 
     */
    public function getImagePrincipale()
    {
        return $this->image_principale;
    }

    /**
     * Add galerie_forfaits
     *
     * @param MyApp\GlobalBundle\Entity\Galerie_forfaits $galerieForfaits
     */
    public function addGalerieForfaits(\MyApp\GlobalBundle\Entity\Galerie_forfaits $galerieForfaits)
    {
        if (!$this->galerie_forfaits->contains($galerieForfaits)) {
        	$this->galerie_forfaits->add($galerieForfaits);
        }
    }

    /**
     * Get galerie_forfaits
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGalerieForfaits()
    {
        return $this->galerie_forfaits;
    }
    
    public function setGalerieForfaits(ArrayCollection $galerieForfaits)
    {
    	foreach ($galerieForfaits as $tag) {
    		$tag->addGalerieForfaits($this);
    	}
    
    	$this->galerie_forfaits = $galerieForfaits;
    }


    /**
     * Set derniere_minute
     *
     * @param boolean $derniereMinute
     */
    public function setDerniereMinute($derniereMinute)
    {
        $this->derniere_minute = $derniereMinute;
    }

    /**
     * Get derniere_minute
     *
     * @return boolean 
     */
    public function getDerniereMinute()
    {
        return $this->derniere_minute;
    }

    /**
     * Add galerie_forfaits
     *
     * @param MyApp\GlobalBundle\Entity\Galerie_forfaits $galerieForfaits
     */
    public function addGalerie_forfaits(\MyApp\GlobalBundle\Entity\Galerie_forfaits $galerieForfaits)
    {
        $this->galerie_forfaits[] = $galerieForfaits;
    }

    /**
     * Set descriptif_derniere_minute_fr
     *
     * @param text $descriptifDerniereMinuteFr
     */
    public function setDescriptifDerniereMinuteFr($descriptifDerniereMinuteFr)
    {
        $this->descriptif_derniere_minute_fr = htmlentities( $descriptifDerniereMinuteFr);
    }

    /**
     * Get descriptif_derniere_minute_fr
     *
     * @return text 
     */
    public function getDescriptifDerniereMinuteFr()
    {
        return html_entity_decode( $this->descriptif_derniere_minute_fr);
    }

    /**
     * Set descriptif_derniere_minute_en
     *
     * @param text $descriptifDerniereMinuteEn
     */
    public function setDescriptifDerniereMinuteEn($descriptifDerniereMinuteEn)
    {
        $this->descriptif_derniere_minute_en = htmlentities( $descriptifDerniereMinuteEn);
    }

    /**
     * Get descriptif_derniere_minute_en
     *
     * @return text 
     */
    public function getDescriptifDerniereMinuteEn()
    {
        return html_entity_decode( $this->descriptif_derniere_minute_en);
    }

    /**
     * Set titre_derniere_minute_fr
     *
     * @param string $titreDerniereMinuteFr
     */
    public function setTitreDerniereMinuteFr($titreDerniereMinuteFr)
    {
        $this->titre_derniere_minute_fr = htmlentities( $titreDerniereMinuteFr);
    }

    /**
     * Get titre_derniere_minute_fr
     *
     * @return string 
     */
    public function getTitreDerniereMinuteFr()
    {
        return html_entity_decode( $this->titre_derniere_minute_fr);
    }

    /**
     * Set titre_derniere_minute_en
     *
     * @param string $titreDerniereMinuteEn
     */
    public function setTitreDerniereMinuteEn($titreDerniereMinuteEn)
    {
        $this->titre_derniere_minute_en = htmlentities($titreDerniereMinuteEn);
    }

    /**
     * Get titre_derniere_minute_en
     *
     * @return string 
     */
    public function getTitreDerniereMinuteEn()
    {
        return html_entity_decode( $this->titre_derniere_minute_en);
    }


    /**
     * Get forfaitreverse_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getForfaitreverseId()
    {
        return $this->forfaitreverse_id;
    }

    /**
     * Set reserver_forfait_en_ligne
     *
     * @param boolean $reserverForfaitEnLigne
     */
    public function setReserverForfaitEnLigne($reserverForfaitEnLigne)
    {
        $this->reserver_forfait_en_ligne = $reserverForfaitEnLigne;
    }

    /**
     * Get reserver_forfait_en_ligne
     *
     * @return boolean 
     */
    public function getReserverForfaitEnLigne()
    {
        return $this->reserver_forfait_en_ligne;
    }

    /**
     * Set publication
     *
     * @param datetime $publication
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    }

    /**
     * Get publication
     *
     * @return datetime 
     */
    public function getPublication()
    {
        return $this->publication;
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
}