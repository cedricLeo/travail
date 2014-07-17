<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Hebergements_salles_corporativesRepository")
 * @ORM\Table(name = "hebergements_salles_corporatives")
 * @ORM\HasLifecycleCallbacks
 */
class Hebergements_salles_corporatives
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
	 * @ORM\ManyToOne(targetEntity = "Hebergements", inversedBy = "Hebergements_salles_corporatives")
         * 
	 * @var integer $salle_corporative_hebergement
	 */
	private $salle_corporative_hebergement;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_salle_corporative_fr
	 */
	private $texte_salle_corporative_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_salle_corporative_en
	 */
	private $texte_salle_corporative_en;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 *
	 * @var text $texte_capacite_salle_corporative_fr
	 */
	private $texte_capacite_salle_corporative_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_capacite_salle_corporative_en
	 */
	private $texte_capacite_salle_corporative_en;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Corporatifs_services", inversedBy = "Hebergements_salles_corporatives", fetch="EXTRA_LAZY")
	 * 
	 * @var ArrayCollection $corporatif_service_id
	 */
	private $corporatif_service_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Types_evenements", inversedBy = "Hebergements_salles_corporatives", fetch="EXTRA_LAZY")
	 *
	 * @var ArrayCollection $type_evenement
	 */
	private $type_evenement;
	
	/**
	 * @ORM\Column(type = "float", length="6", nullable="true")
	 *
	 * @var float $largeur_metre
	 */
	private $largeur_metre;
	
	/**
	 * @ORM\Column(type = "float", length ="6", nullable="true")
	 *
	 * @var float $hauteur_metre
	 */
	private $hauteur_metre;
	
	/**
	 * @ORM\Column(type = "float", length="6", nullable="true")
	 *
	 * @var float $profondeur_metre
	 */
	private $profondeur_metre;
	
	/**
	 * @ORM\Column(type = "float", length="10", nullable="true")
	 *
	 * @var float $largeur
	 */
	private $largeur;
	
	/**
	 * @ORM\Column(type = "float", length ="10", nullable="true")
	 *
	 * @var float $hauteur
	 */
	private $hauteur;
	
	/**
	 * @ORM\Column(type = "float", length="10", nullable="true")
	 *
	 * @var float $profondeur
	 */
	private $profondeur;
	
	/**
	 * @ORM\Column(type = "boolean", nullable ="true")
	 *
	 * @var boolean $actif
	 */
	private $actif;
	
	/**
	 * @ORM\Column(type = "string", length="100")
	 *
	 * @var string $email_corporatif
	 */
	private $email_corporatif;
	
	/**
	 * @ORM\Column(type = "string", length="100")
	 *
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length="100")
	 *
	 * @var string $nom_en
	 */
	private $nom_en;
	
	/**
	 * @ORM\Column(type = "integer", length="4", nullable="true")
	 *
	 * @var integer $banquet
	 */
	private $banquet;
	
	/**
	 * @ORM\Column(type = "integer", length="4", nullable="true")
	 *
	 * @var integer $carre_ouvert
	 */
	private $carre_ouvert;
	
	/**
	 * @ORM\Column(type = "integer", length="4", nullable="true")
	 *
	 * @var integer $chevron
	 */
	private $chevron;
	
	/**
	 * @ORM\Column(type = "integer", length="4", nullable="true")
	 *
	 * @var integer $conference
	 */
	private $conference;
	
	/**
	 * @ORM\Column(type = "integer", length="4", nullable="true")
	 *
	 * @var integer $demi_lune
	 */
	private $demi_lune;
	
	/**
	 * @ORM\Column(type = "integer", length="4", nullable="true")
	 *
	 * @var integer $ecole
	 */
	private $ecole;
	
	/**
	 * @ORM\Column(type = "integer", length="4", nullable="true")
	 *
	 * @var integer $en_t
	 */
	private $en_t;
	
	/**
	 * @ORM\Column(type = "integer", length="4", nullable="true")
	 *
	 * @var integer $en_u
	 */
	private $en_u;
	
	/**
	 * @ORM\Column(type = "integer", length="4", nullable="true")
	 *
	 * @var integer $salon_commercial
	 */
	private $salon_commercial;
	
	/**
	 * @ORM\Column(type = "integer", length="4", nullable="true")
	 *
	 * @var integer $theatre
	 */
	private $theatre;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Corporatif_galerie_photo", cascade={"persist", "remove"})
	 * 
	 * @var array_collection $galerie_corpo
	 */
	private $galerie_corpo;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 *
	 * @var string $fichier_liste_salles_fr
	 */
	private $fichier_liste_salles_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 *
	 * @var string $fichier_liste_salles_fr_doctrine
	 */
	private $fichier_liste_salles_fr_doctrine;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 *
	 * @var string $fichier_liste_salles_en
	 */
	private $fichier_liste_salles_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 *
	 * @var string $fichier_liste_salles_en_doctrine
	 */
	private $fichier_liste_salles_en_doctrine;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 *
	 * @var string $fichier_plan_salles_fr
	 */
	private $fichier_plan_salles_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 *
	 * @var string $fichier_plan_salles_fr_doctrine
	 */
	private $fichier_plan_salles_fr_doctrine;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 *
	 * @var string $fichier_plan_salles_en
	 */
	private $fichier_plan_salles_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = "true")
	 *
	 * @var string $fichier_plan_salles_en_doctrine
	 */
	private $fichier_plan_salles_en_doctrine;

	
	public function getFullListeFRPath() {
		return null === $this->fichier_liste_salles_fr ? null : $this->getUploadRootDir(). $this->fichier_liste_salles_fr;
	}
	
	public function getFullListeENPath() {
		return null === $this->fichier_liste_salles_en ? null : $this->getUploadRootENDir(). $this->fichier_liste_salles_en;
	}
	
	public function getFullPlanFRPath() {
		return null === $this->fichier_plan_salles_fr ? null : $this->getUploadRootPlanDir(). $this->fichier_plan_salles_fr;
	}
	
	public function getFullPlanENPath() {
		return null === $this->fichier_plan_salles_en ? null : $this->getUploadRootPlanENDir(). $this->fichier_plan_salles_en;
	}
	
	protected function getUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDir().$this->getId()."/";
	}
	
	protected function getUploadRootENDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootENDir().$this->getId()."/";
	}
	
	protected function getUploadRootPlanDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootPlanDir().$this->getId()."/";
	}
	
	protected function getUploadRootPlanENDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootPlanENDir().$this->getId()."/";
	}
	
	protected function getUploadRootImgDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootImgDir().$this->getId()."/";
	}
	
	protected function getTmpUploadRootENDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/hebergement/liste/english';
	}
	
	protected function getTmpUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/hebergement/liste/french';
	}
	
	protected function getTmpUploadRootPlanENDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/hebergement/plan/english';
	}
	
	protected function getTmpUploadRootPlanDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/hebergement/plan/french';
	}
	
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function upload() {
		// the file property can be empty if the field is not required
		if (null === $this->fichier_liste_salles_fr) {
			return;
		}
		if (null === $this->fichier_liste_salles_fr_doctrine) {
			return;
		}	
		if(!$this->id){
			$this->fichier_liste_salles_fr->move($this->getTmpUploadRootDir(), $this->fichier_liste_salles_fr->getClientOriginalName());
		}else{
			$this->fichier_liste_salles_fr->move($this->getUploadRootDir(), $this->fichier_liste_salles_fr->getClientOriginalName());
		}
		$this->setFichierListeSallesFr($this->fichier_liste_salles_fr->getClientOriginalName());
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function uploadEN() {
		// the file property can be empty if the field is not required
		if (null === $this->fichier_liste_salles_en) {
			return;
		}
		if (null === $this->fichier_liste_salles_en_doctrine) {
			return;
		}
		if(!$this->id){
			$this->fichier_liste_salles_en->move($this->getTmpUploadRootENDir(), $this->fichier_liste_salles_en->getClientOriginalName());
		}else{
			$this->fichier_liste_salles_en->move($this->getUploadRootENDir(), $this->fichier_liste_salles_en->getClientOriginalName());
		}
		$this->setFichierListeSallesEn($this->fichier_liste_salles_en->getClientOriginalName());
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function uploadPlan() {
		// the file property can be empty if the field is not required
		if (null === $this->fichier_plan_salles_fr) {
			return;
		}
		if (null === $this->fichier_plan_salles_fr_doctrine) {
			return;
		}
		if(!$this->id){
			$this->fichier_plan_salles_fr->move($this->getTmpUploadRootPlanDir(), $this->fichier_plan_salles_fr->getClientOriginalName());
		}else{
			$this->fichier_plan_salles_fr->move($this->getUploadRootPlanDir(), $this->fichier_plan_salles_fr->getClientOriginalName());
		}
		$this->setFichierPlanSallesFr($this->fichier_plan_salles_fr->getClientOriginalName());
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function uploadPlanEn() {
		// the file property can be empty if the field is not required
		if (null === $this->fichier_plan_salles_en) {
			return;
		}
		if (null === $this->fichier_plan_salles_en_doctrine) {
			return;
		}
		if(!$this->id){
			$this->fichier_plan_salles_en->move($this->getTmpUploadRootPlanENDir(), $this->fichier_plan_salles_en->getClientOriginalName());
		}else{
			$this->fichier_plan_salles_en->move($this->getUploadRootPlanENDir(), $this->fichier_plan_salles_en->getClientOriginalName());
		}
		$this->setFichierPlanSallesEn($this->fichier_plan_salles_en->getClientOriginalName());
	}
	
	/**
	 * @ORM\PostPersist()
	 */
	public function move()
	{
	
		if (null === $this->fichier_liste_salles_fr) {
			return;
		}
		if (null === $this->fichier_liste_salles_en) {
			return;
		}
		if (null === $this->fichier_plan_salles_fr) {
			return;
		}
		if (null === $this->fichier_plan_salles_en) {
			return;
		}
		if(!is_dir($this->getUploadRootDir())){
			mkdir($this->getUploadRootDir());
		}
		if(!is_dir($this->getUploadRootENDir())){
			mkdir($this->getUploadRootENDir());
		}
		if(!is_dir($this->getUploadRootPlanDir())){
			mkdir($this->getUploadRootPlanDir());
		}
		if(!is_dir($this->getUploadRootPlanENDir())){
			mkdir($this->getUploadRootPlanENDir());
		}
		if(!is_dir($this->getUploadRootImgDir())){
			mkdir($this->getUploadRootImgDir());
		}
		
		copy($this->getTmpUploadRootDir().$this->fichier_liste_salles_fr, $this->getFullListeFRPath());
		unlink($this->getTmpUploadRootDir().$this->fichier_liste_salles_fr);
		
		copy($this->getTmpUploadRootENDir().$this->fichier_liste_salles_en, $this->getFullListeENPath());
		unlink($this->getTmpUploadRootENDir().$this->fichier_liste_salles_en);
		
		copy($this->getTmpUploadRootDir().$this->fichier_plan_salles_fr, $this->getFullListeFRPath());
		unlink($this->getTmpUploadRootDir().$this->fichier_plan_salles_fr);
		
		copy($this->getTmpUploadRootENDir().$this->fichier_plan_salles_en, $this->getFullListeENPath());
		unlink($this->getTmpUploadRootENDir().$this->fichier_plan_salles_en);
		
	}
	
	/**
	 * @ORM\PreRemove()
	 */
	public function remove()
	{
		if($this->getFullListeFRPath() or $this->getFullListeENPath() or $this->getFullPlanFRPath() or $this->getFullPlanENPath()){
			unlink($this->getFullListeFRPath());
			unlink($this->getFullListeENPath());
			unlink($this->getFullPlanFRPath());
			unlink($this->getFullPlanENPath());
			rmdir($this->getUploadRootDir());
			rmdir($this->getUploadRootENDir());
			rmdir($this->getUploadRootPlanDir());
			rmdir($this->getUploadRootPlanENDir());
		}
	}
	
   /**
	* @ORM\ManyToMany(targetEntity = "Appel_Offre", inversedBy = "Hebergements_salles_corporatives", fetch="EXTRA_LAZY")
	*
	* @var ArrayCollection $appel_offre
	*/
	private $appel_offre;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Forfaits_clients", mappedBy = "Hebergements_salles_corporatives")
	 *
	 * @var integer $forfait_id
	 */
	private $forfait_id;
	
	public function __construct()
	{
		$this->corporatif_service_id 		= new ArrayCollection();
		//$this->salle_corporative_hebergement	= new ArrayCollection();
		$this->type_evenement                   = new ArrayCollection();
		$this->appel_offre                   	= new ArrayCollection();
		$this->galerie_corpo			= new ArrayCollection();
	}
	
	public function __toString()
	{
		return $this->nom_fr;
		return $this->nom_en;
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
     * Set texte_salle_corporative_fr
     *
     * @param text $texteSalleCorporativeFr
     */
    public function setTexteSalleCorporativeFr($texteSalleCorporativeFr)
    {
        $this->texte_salle_corporative_fr = $texteSalleCorporativeFr;
    }

    /**
     * Get texte_salle_corporative_fr
     *
     * @return text 
     */
    public function getTexteSalleCorporativeFr()
    {
        return $this->texte_salle_corporative_fr;
    }

    /**
     * Set texte_salle_corporative_en
     *
     * @param text $texteSalleCorporativeEn
     */
    public function setTexteSalleCorporativeEn($texteSalleCorporativeEn)
    {
        $this->texte_salle_corporative_en = $texteSalleCorporativeEn;
    }

    /**
     * Get texte_salle_corporative_en
     *
     * @return text 
     */
    public function getTexteSalleCorporativeEn()
    {
        return $this->texte_salle_corporative_en;
    }

    /**
     * Set texte_capacite_salle_corporative_fr
     *
     * @param text $texteCapaciteSalleCorporativeFr
     */
    public function setTexteCapaciteSalleCorporativeFr($texteCapaciteSalleCorporativeFr)
    {
        $this->texte_capacite_salle_corporative_fr = $texteCapaciteSalleCorporativeFr;
    }

    /**
     * Get texte_capacite_salle_corporative_fr
     *
     * @return text 
     */
    public function getTexteCapaciteSalleCorporativeFr()
    {
        return $this->texte_capacite_salle_corporative_fr;
    }

    /**
     * Set texte_capacite_salle_corporative_en
     *
     * @param text $texteCapaciteSalleCorporativeEn
     */
    public function setTexteCapaciteSalleCorporativeEn($texteCapaciteSalleCorporativeEn)
    {
        $this->texte_capacite_salle_corporative_en = $texteCapaciteSalleCorporativeEn;
    }

    /**
     * Get texte_capacite_salle_corporative_en
     *
     * @return text 
     */
    public function getTexteCapaciteSalleCorporativeEn()
    {
        return $this->texte_capacite_salle_corporative_en;
    }

    /**
     * Set largeur_metre
     *
     * @param float $largeurMetre
     */
    public function setLargeurMetre($largeurMetre)
    {
        $this->largeur_metre = $largeurMetre;
    }

    /**
     * Get largeur_metre
     *
     * @return float 
     */
    public function getLargeurMetre()
    {
        return $this->largeur_metre;
    }

    /**
     * Set hauteur_metre
     *
     * @param float $hauteurMetre
     */
    public function setHauteurMetre($hauteurMetre)
    {
        $this->hauteur_metre = $hauteurMetre;
    }

    /**
     * Get hauteur_metre
     *
     * @return float 
     */
    public function getHauteurMetre()
    {
        return $this->hauteur_metre;
    }

    /**
     * Set profondeur_metre
     *
     * @param float $profondeurMetre
     */
    public function setProfondeurMetre($profondeurMetre)
    {
        $this->profondeur_metre = $profondeurMetre;
    }

    /**
     * Get profondeur_metre
     *
     * @return float 
     */
    public function getProfondeurMetre()
    {
        return $this->profondeur_metre;
    }

    /**
     * Set largeur
     *
     * @param float $largeur
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
    }

    /**
     * Get largeur
     *
     * @return float 
     */
    public function getLargeur()
    {
        return $this->largeur;
    }

    /**
     * Set hauteur
     *
     * @param float $hauteur
     */
    public function setHauteur($hauteur)
    {
        $this->hauteur = $hauteur;
    }

    /**
     * Get hauteur
     *
     * @return float 
     */
    public function getHauteur()
    {
        return $this->hauteur;
    }

    /**
     * Set profondeur
     *
     * @param float $profondeur
     */
    public function setProfondeur($profondeur)
    {
        $this->profondeur = $profondeur;
    }

    /**
     * Get profondeur
     *
     * @return float 
     */
    public function getProfondeur()
    {
        return $this->profondeur;
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
     * Set email_corporatif
     *
     * @param string $emailCorporatif
     */
    public function setEmailCorporatif($emailCorporatif)
    {
        $this->email_corporatif = $emailCorporatif;
    }

    /**
     * Get email_corporatif
     *
     * @return string 
     */
    public function getEmailCorporatif()
    {
        return $this->email_corporatif;
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
     * Set banquet
     *
     * @param integer $banquet
     */
    public function setBanquet($banquet)
    {
        $this->banquet = $banquet;
    }

    /**
     * Get banquet
     *
     * @return integer 
     */
    public function getBanquet()
    {
        return $this->banquet;
    }

    /**
     * Set carre_ouvert
     *
     * @param integer $carreOuvert
     */
    public function setCarreOuvert($carreOuvert)
    {
        $this->carre_ouvert = $carreOuvert;
    }

    /**
     * Get carre_ouvert
     *
     * @return integer 
     */
    public function getCarreOuvert()
    {
        return $this->carre_ouvert;
    }

    /**
     * Set chevron
     *
     * @param integer $chevron
     */
    public function setChevron($chevron)
    {
        $this->chevron = $chevron;
    }

    /**
     * Get chevron
     *
     * @return integer 
     */
    public function getChevron()
    {
        return $this->chevron;
    }

    /**
     * Set conference
     *
     * @param integer $conference
     */
    public function setConference($conference)
    {
        $this->conference = $conference;
    }

    /**
     * Get conference
     *
     * @return integer 
     */
    public function getConference()
    {
        return $this->conference;
    }

    /**
     * Set demi_lune
     *
     * @param integer $demiLune
     */
    public function setDemiLune($demiLune)
    {
        $this->demi_lune = $demiLune;
    }

    /**
     * Get demi_lune
     *
     * @return integer 
     */
    public function getDemiLune()
    {
        return $this->demi_lune;
    }

    /**
     * Set ecole
     *
     * @param integer $ecole
     */
    public function setEcole($ecole)
    {
        $this->ecole = $ecole;
    }

    /**
     * Get ecole
     *
     * @return integer 
     */
    public function getEcole()
    {
        return $this->ecole;
    }

    /**
     * Set en_t
     *
     * @param integer $enT
     */
    public function setEnT($enT)
    {
        $this->en_t = $enT;
    }

    /**
     * Get en_t
     *
     * @return integer 
     */
    public function getEnT()
    {
        return $this->en_t;
    }

    /**
     * Set en_u
     *
     * @param integer $enU
     */
    public function setEnU($enU)
    {
        $this->en_u = $enU;
    }

    /**
     * Get en_u
     *
     * @return integer 
     */
    public function getEnU()
    {
        return $this->en_u;
    }

    /**
     * Set salon_commercial
     *
     * @param integer $salonCommercial
     */
    public function setSalonCommercial($salonCommercial)
    {
        $this->salon_commercial = $salonCommercial;
    }

    /**
     * Get salon_commercial
     *
     * @return integer 
     */
    public function getSalonCommercial()
    {
        return $this->salon_commercial;
    }

    /**
     * Set theatre
     *
     * @param integer $theatre
     */
    public function setTheatre($theatre)
    {
        $this->theatre = $theatre;
    }

    /**
     * Get theatre
     *
     * @return integer 
     */
    public function getTheatre()
    {
        return $this->theatre;
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
     * Set fichier_liste_salles_fr_doctrine
     *
     * @param string $fichierListeSallesFrDoctrine
     */
    public function setFichierListeSallesFrDoctrine($fichierListeSallesFrDoctrine)
    {
        $this->fichier_liste_salles_fr_doctrine = $fichierListeSallesFrDoctrine;
    }

    /**
     * Get fichier_liste_salles_fr_doctrine
     *
     * @return string 
     */
    public function getFichierListeSallesFrDoctrine()
    {
        return $this->fichier_liste_salles_fr_doctrine;
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
     * Set fichier_liste_salles_en_doctrine
     *
     * @param string $fichierListeSallesEnDoctrine
     */
    public function setFichierListeSallesEnDoctrine($fichierListeSallesEnDoctrine)
    {
        $this->fichier_liste_salles_en_doctrine = $fichierListeSallesEnDoctrine;
    }

    /**
     * Get fichier_liste_salles_en_doctrine
     *
     * @return string 
     */
    public function getFichierListeSallesEnDoctrine()
    {
        return $this->fichier_liste_salles_en_doctrine;
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
     * Set fichier_plan_salles_fr_doctrine
     *
     * @param string $fichierPlanSallesFrDoctrine
     */
    public function setFichierPlanSallesFrDoctrine($fichierPlanSallesFrDoctrine)
    {
        $this->fichier_plan_salles_fr_doctrine = $fichierPlanSallesFrDoctrine;
    }

    /**
     * Get fichier_plan_salles_fr_doctrine
     *
     * @return string 
     */
    public function getFichierPlanSallesFrDoctrine()
    {
        return $this->fichier_plan_salles_fr_doctrine;
    }

    /**
     * Set fichier_plan_salles_en
     *
     * @param string $fichierPlanSallesEn
     */
    public function setFichierPlanSallesEn($fichierPlanSallesEn)
    {
        $this->fichier_plan_salles_en = $fichierPlanSallesEn;
    }

    /**
     * Get fichier_plan_salles_en
     *
     * @return string 
     */
    public function getFichierPlanSallesEn()
    {
        return $this->fichier_plan_salles_en;
    }

    /**
     * Set fichier_plan_salles_en_doctrine
     *
     * @param string $fichierPlanSallesEnDoctrine
     */
    public function setFichierPlanSallesEnDoctrine($fichierPlanSallesEnDoctrine)
    {
        $this->fichier_plan_salles_en_doctrine = $fichierPlanSallesEnDoctrine;
    }

    /**
     * Get fichier_plan_salles_en_doctrine
     *
     * @return string 
     */
    public function getFichierPlanSallesEnDoctrine()
    {
        return $this->fichier_plan_salles_en_doctrine;
    }

    /**
     * Set salle_corporative_hebergement
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $salleCorporativeHebergement
     */
    public function setSalleCorporativeHebergement(\MyApp\GlobalBundle\Entity\Hebergements $salleCorporativeHebergement)
    {
        $this->salle_corporative_hebergement = $salleCorporativeHebergement;
    }

    /**
     * Get salle_corporative_hebergement
     *
     * @return MyApp\GlobalBundle\Entity\Hebergements 
     */
    public function getSalleCorporativeHebergement()
    {
        return $this->salle_corporative_hebergement;
    }

    /**
     * Add corporatif_service_id
     *
     * @param MyApp\GlobalBundle\Entity\Corporatifs_services $corporatifServiceId
     */
    public function addCorporatifs_services(\MyApp\GlobalBundle\Entity\Corporatifs_services $corporatifServiceId)
    {
        $this->corporatif_service_id[] = $corporatifServiceId;
    }

    /**
     * Get corporatif_service_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCorporatifServiceId()
    {
        return $this->corporatif_service_id;
    }

    /**
     * Add type_evenement
     *
     * @param MyApp\GlobalBundle\Entity\Types_evenements $typeEvenement
     */
    public function addTypes_evenements(\MyApp\GlobalBundle\Entity\Types_evenements $typeEvenement)
    {
        $this->type_evenement[] = $typeEvenement;
    }

    /**
     * Get type_evenement
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTypeEvenement()
    {
        return $this->type_evenement;
    }

    /**
     * Add galerie_corpo
     *
     * @param MyApp\GlobalBundle\Entity\Corporatif_galerie_photo $galerieCorpo
     */
    public function addCorporatif_galerie_photo(\MyApp\GlobalBundle\Entity\Corporatif_galerie_photo $galerieCorpo)
    {
        $this->galerie_corpo[] = $galerieCorpo;
    }

    /**
     * Get galerie_corpo
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGalerieCorpo()
    {
        return $this->galerie_corpo;
    }

    /**
     * Add appel_offre
     *
     * @param MyApp\GlobalBundle\Entity\Appel_Offre $appelOffre
     */
    public function addAppel_Offre(\MyApp\GlobalBundle\Entity\Appel_Offre $appelOffre)
    {
        $this->appel_offre[] = $appelOffre;
    }

    /**
     * Get appel_offre
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAppelOffre()
    {
        return $this->appel_offre;
    }

    /**
     * Add forfait_id
     *
     * @param MyApp\GlobalBundle\Entity\Forfaits_clients $forfaitId
     */
    public function addForfaits_clients(\MyApp\GlobalBundle\Entity\Forfaits_clients $forfaitId)
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
}