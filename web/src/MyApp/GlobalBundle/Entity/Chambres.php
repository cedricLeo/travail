<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @author leonardc
 *
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\ChambresRepository")
 * @ORM\Table(name = "chambres", indexes={@ORM\index(name="chambre_idx", columns={"id", "nom_fr", "actif"})})
 * @ORM\HasLifecycleCallbacks
 */
class Chambres{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type = "string", length = 2, nullable = "false")
	 *
	 * @var string $max_personne
	 */
	private $max_personne;
        
        /**
	 * @ORM\Column(type = "integer", length = 2, nullable = "true")
	 *
	 * @var integer $nombre_lit
	 */
	private $nombre_lit;
	
	/**
	 * @ORM\Column(type = "string", length = 100, nullable = "true")
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 100, nullable = "true")
	 * 
	 * @var string $nom_en
	 */
	private $nom_en;
        
       /**
        * @ORM\Column(type="string", length = 255, nullable = "true")
        * 
        * @var string $repertoire_fr
        */
       private $repertoire_fr;

       /**
        * @ORM\Column(type="string", length = 255, nullable = "true")
        * 
        * @var string $repertoire_en
        */
       private $repertoire_en;
	
	/**
	 * @ORM\Column(type = "integer", length = 4, nullable = "false")
	 * 
	 * @var integer $quantite
	 */
	private $quantite;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $description_fr
	 */
	private $description_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $description_en
	 */
	private $description_en;
	
	/**
	 * @ORM\Column(type = "boolean", nullable = "true")
	 * 
	 * @var boolean $actif
	 */
	private $actif;
	
	/**
	 * @ORM\Column(type = "float", length = 5, nullable = "true")
	 *
	 * @var float $tarif_min_basse_saison
	 */
	private $tarif_min_basse_saison;
	
	/**
	 * @ORM\Column(type = "float", length = 5, nullable = "true")
	 *
	 * @var float $tarif_max_basse_saison
	 */
	private $tarif_max_basse_saison;
	
	/**
	 * @ORM\Column(type = "float", length = 5, nullable = "true")
	 *
	 * @var float $tarif_min_haute_saison
	 */
	private $tarif_min_haute_saison;
	
	/**
	 * @ORM\Column(type = "float", length = 5, nullable = "true")
	 *
	 * @var float $tarif_max_haute_saison
	 */
	private $tarif_max_haute_saison;
	
	/**
	 * @ORM\Column(type = "float", length = 5, nullable = "true")
	 *
	 * @var float $tarif_min_relache
	 */
	private $tarif_min_relache;
	
	/**
	 * @ORM\Column(type = "float", length = 5, nullable = "true")
	 *
	 * @var float $tarif_max_relache
	 */
	private $tarif_max_relache;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 *
	 * @var text $texte_presentation_fr
	 */
	private $texte_presentation_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 *
	 * @var text $texte_presentation_en
	 */
	private $texte_presentation_en;
	
	/**
	 * @ORM\Column(type="boolean" , nullable = "true")
	 * 
	 * @var boolean $tarif_preferentiel
	 */
	private $tarif_preferentiel;
	
	/**
	 * @ORM\Column(type="boolean" , nullable = "true")
	 *
	 * @var boolean $dejeuner_continental
	 */
	private $dejeuner_continental;
	
	/**
	 * @ORM\Column(type="boolean" , nullable = "true")
	 *
	 * @var boolean $dejeuner_americain
	 */
	private $dejeuner_americain;
	
	/**
	 * @ORM\Column(type="boolean" , nullable = "true")
	 *
	 * @var boolean $dejeuner_buffet
	 */
	private $dejeuner_buffet;
	
	/**
	 * @ORM\Column(type="boolean" , nullable = "true")
	 *
	 * @var boolean $dejeuner_non_compris
	 */
	private $dejeuner_non_compris;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Lits", inversedBy="Chambres")
	 * 
	 * @var ArrayCollection $lit_id
	 */
	private $lit_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Equipements", inversedBy="Chambres")
	 *
	 * @var ArrayCollection $equipement_id
	 */
	private $equipement_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Hebergements", inversedBy="Chambres")
	 *
	 * @var integer $hebergement
	 */
	private $hebergement;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Galerie_photo_chambres", inversedBy="Chambres", cascade={"persist", "remove"})
	 *
	 * @var ArrayCollection $galerie_chambre
	 */
	private $galerie_chambre;
        
        /**
	 * @ORM\ManyToMany(targetEntity="Types_chambres", inversedBy="Chambres")
	 *
	 * @var ArrayCollection $type_chambre_id
	 */
	private $type_chambre_id;
	
	/**
	 * @ORM\Column(type="integer" , length="2", nullable = "true")
	 *
	 * @var integer $ordre_affichage
	 */
	private $ordre_affichage;
	
	/**
        * @ORM\ManyToMany(targetEntity="Types_prix", inversedBy="Chambres")
        *
        * @var ArrayCollection $type_prix 
        */
	private $type_prix;
        
        /**
	 * @ORM\Column(type = "boolean", nullable = true)
	 *
	 * @var boolean $reserver_chambre_en_ligne
	 */
	private $reserver_chambre_en_ligne;            
			
	public function __construct()
	{
		$this->type_chambre_id  	= new ArrayCollection();
		$this->lit_id 			= new ArrayCollection();
		$this->galerie_chambre          = new ArrayCollection();
		$this->equipement_id    	= new ArrayCollection();
		$this->type_prix 		= new ArrayCollection();              
	}
        
	
	public function __toString()
	{
		return (string)$this->nom_fr;
	}
                        	
	/**********************************************************/
	
	/**
	 * @ORM\Column(type = "string", length = 100, nullable = "true")
	 *
	 * @var string $photo1
	 */
	private $photo1;
	
	/**
	 * @ORM\Column(type = "string", length = 100, nullable = "true")
	 *
	 * @var string $photo1_doctrine
	 */
	private $photo1_doctrine;
	
	
	public function getFullPicturePath() {
		return null === $this->photo1 ? null : $this->getUploadRootDir(). $this->photo1;
	}
	
	protected function getUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return $this->getTmpUploadRootDir().$this->getId()."/";
	}
	
	protected function getTmpUploadRootDir() {
		// the absolute directory path where uploaded documents should be saved
		return __DIR__ . '/../../../../web/uploads/chambres/';
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function uploadPicture() {
		// the file property can be empty if the field is not required
		if (null === $this->photo1) {
			return;
		}
		/*if (null === $this->photo1_doctrine) {
			return;
		}*/
		if(!$this->id){
			$this->photo1->move($this->getTmpUploadRootDir(), $this->photo1->getClientOriginalName());
		}else{
                    if(is_object($this->photo1)){
			$this->photo1->move($this->getUploadRootDir(), $this->photo1->getClientOriginalName());
                    }
		}
                if(is_object($this->photo1)){
                    $this->setPhoto1($this->photo1->getClientOriginalName());
                }
	}
	
	/**
	 * @ORM\PostPersist()
	 */
	public function move()
	{
		if (null === $this->photo1) {
			return;
		}
		if(!is_dir($this->getUploadRootDir())){
			mkdir($this->getUploadRootDir());
		}
		copy($this->getTmpUploadRootDir().$this->photo1, $this->getFullPicturePath());
		unlink($this->getTmpUploadRootDir().$this->photo1);
	}
	
	/**
	 * @ORM\PreRemove()
	 */
	public function remove()
	{
		if($this->getFullPicturePath() != null){
			unlink($this->getFullPicturePath());
			rmdir($this->getUploadRootDir());
		}
	}
	
	
	/**********************************************************/
	

	
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
     * Set quantite
     *
     * @param integer $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set description_fr
     *
     * @param text $descriptionFr
     */
    public function setDescriptionFr($descriptionFr)
    {
        $this->description_fr = htmlentities( $descriptionFr);
    }

    /**
     * Get description_fr
     *
     * @return text 
     */
    public function getDescriptionFr()
    {
        return html_entity_decode( $this->description_fr);
    }

    /**
     * Set description_en
     *
     * @param text $descriptionEn
     */
    public function setDescriptionEn($descriptionEn)
    {
        $this->description_en = htmlentities( $descriptionEn);
    }

    /**
     * Get description_en
     *
     * @return text 
     */
    public function getDescriptionEn()
    {
        return html_entity_decode( $this->description_en);
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
     * Set tarif_min_basse_saison
     *
     * @param float $tarifMinBasseSaison
     */
    public function setTarifMinBasseSaison($tarifMinBasseSaison)
    {
        $this->tarif_min_basse_saison = $tarifMinBasseSaison;
    }

    /**
     * Get tarif_min_basse_saison
     *
     * @return float 
     */
    public function getTarifMinBasseSaison()
    {
        return $this->tarif_min_basse_saison;
    }

    /**
     * Set tarif_max_basse_saison
     *
     * @param float $tarifMaxBasseSaison
     */
    public function setTarifMaxBasseSaison($tarifMaxBasseSaison)
    {
        $this->tarif_max_basse_saison = $tarifMaxBasseSaison;
    }

    /**
     * Get tarif_max_basse_saison
     *
     * @return float 
     */
    public function getTarifMaxBasseSaison()
    {
        return $this->tarif_max_basse_saison;
    }

    /**
     * Set tarif_min_haute_saison
     *
     * @param float $tarifMinHauteSaison
     */
    public function setTarifMinHauteSaison($tarifMinHauteSaison)
    {
        $this->tarif_min_haute_saison = $tarifMinHauteSaison;
    }

    /**
     * Get tarif_min_haute_saison
     *
     * @return float 
     */
    public function getTarifMinHauteSaison()
    {
        return $this->tarif_min_haute_saison;
    }

    /**
     * Set tarif_max_haute_saison
     *
     * @param float $tarifMaxHauteSaison
     */
    public function setTarifMaxHauteSaison($tarifMaxHauteSaison)
    {
        $this->tarif_max_haute_saison = $tarifMaxHauteSaison;
    }

    /**
     * Get tarif_max_haute_saison
     *
     * @return float 
     */
    public function getTarifMaxHauteSaison()
    {
        return $this->tarif_max_haute_saison;
    }

    /**
     * Add type_chambre_id
     *
     * @param MyApp\GlobalBundle\Entity\Types_chambres $typeChambreId
     */
    public function addTypes_chambres(\MyApp\GlobalBundle\Entity\Types_chambres $typeChambreId)
    {
        $this->type_chambre_id[] = $typeChambreId;
    }

    /**
     * Get type_chambre_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTypeChambreId()
    {
        return $this->type_chambre_id;
    }

    /**
     * Add lit_id
     *
     * @param MyApp\GlobalBundle\Entity\Lits $litId
     */
    public function addLits(\MyApp\GlobalBundle\Entity\Lits $litId)
    {
        $this->lit_id[] = $litId;
    }

    /**
     * Get lit_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLitId()
    {
        return $this->lit_id;
    }

    /**
     * Set hebergement
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergement
     */
    public function setHebergement(\MyApp\GlobalBundle\Entity\Hebergements $hebergement)
    {
        $this->hebergement = $hebergement;
    }

    /**
     * Get hebergement
     *
     * @return MyApp\GlobalBundle\Entity\Hebergements 
     */
    public function getHebergement()
    {
        return $this->hebergement;
    }

    /**
     * Set photo1
     *
     * @param string $photo1
     */
    public function setPhoto1($photo1)
    {
    	//if($photo1 != null){
        	$this->photo1 = $photo1;
    	//}
    }

    /**
     * Get photo1
     *
     * @return string 
     */
    public function getPhoto1()
    {
        return $this->photo1;
    }

    /**
     * Set texte_presentation_fr
     *
     * @param text $textePresentationFr
     */
    public function setTextePresentationFr($textePresentationFr)
    {
        $this->texte_presentation_fr = htmlentities( $textePresentationFr);
    }

    /**
     * Get texte_presentation_fr
     *
     * @return text 
     */
    public function getTextePresentationFr()
    {
        return html_entity_decode( $this->texte_presentation_fr);
    }

    /**
     * Set texte_presentation_en
     *
     * @param text $textePresentationEn
     */
    public function setTextePresentationEn($textePresentationEn)
    {
        $this->texte_presentation_en = htmlentities( $textePresentationEn);
    }

    /**
     * Get texte_presentation_en
     *
     * @return text 
     */
    public function getTextePresentationEn()
    {
        return html_entity_decode( $this->texte_presentation_en);
    }

    /**
     * Set tarif_preferentiel
     *
     * @param boolean $tarifPreferentiel
     */
    public function setTarifPreferentiel($tarifPreferentiel)
    {
        $this->tarif_preferentiel = $tarifPreferentiel;
    }

    /**
     * Get tarif_preferentiel
     *
     * @return boolean 
     */
    public function getTarifPreferentiel()
    {
        return $this->tarif_preferentiel;
    }


    /**
     * Set photo1_doctrine
     *
     * @param string $photo1Doctrine
     */
    public function setPhoto1Doctrine($photo1Doctrine)
    {
        $this->photo1_doctrine = $photo1Doctrine;
    }

    /**
     * Get photo1_doctrine
     *
     * @return string 
     */
    public function getPhoto1Doctrine()
    {
        return $this->photo1_doctrine;
    }

    /**
     * Add equipement_id
     *
     * @param MyApp\GlobalBundle\Entity\Equipements $equipementId
     */
    public function addEquipements(\MyApp\GlobalBundle\Entity\Equipements $equipementId)
    {
        $this->equipement_id[] = $equipementId;
    }

    /**
     * Get equipement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEquipementId()
    {
        return $this->equipement_id;
    }

    /**
     * Set tarif_min_relache
     *
     * @param float $tarifMinRelache
     */
    public function setTarifMinRelache($tarifMinRelache)
    {
        $this->tarif_min_relache = $tarifMinRelache;
    }

    /**
     * Get tarif_min_relache
     *
     * @return float 
     */
    public function getTarifMinRelache()
    {
        return $this->tarif_min_relache;
    }

    /**
     * Set tarif_max_relache
     *
     * @param float $tarifMaxRelache
     */
    public function setTarifMaxRelache($tarifMaxRelache)
    {
        $this->tarif_max_relache = $tarifMaxRelache;
    }

    /**
     * Get tarif_max_relache
     *
     * @return float 
     */
    public function getTarifMaxRelache()
    {
        return $this->tarif_max_relache;
    }

    /**
     * Set dejeuner_continental
     *
     * @param boolean $dejeunerContinental
     */
    public function setDejeunerContinental($dejeunerContinental)
    {
        $this->dejeuner_continental = $dejeunerContinental;
    }

    /**
     * Get dejeuner_continental
     *
     * @return boolean 
     */
    public function getDejeunerContinental()
    {
        return $this->dejeuner_continental;
    }

    /**
     * Set dejeuner_americain
     *
     * @param boolean $dejeunerAmericain
     */
    public function setDejeunerAmericain($dejeunerAmericain)
    {
        $this->dejeuner_americain = $dejeunerAmericain;
    }

    /**
     * Get dejeuner_americain
     *
     * @return boolean 
     */
    public function getDejeunerAmericain()
    {
        return $this->dejeuner_americain;
    }

    /**
     * Set dejeuner_buffet
     *
     * @param boolean $dejeunerBuffet
     */
    public function setDejeunerBuffet($dejeunerBuffet)
    {
        $this->dejeuner_buffet = $dejeunerBuffet;
    }

    /**
     * Get dejeuner_buffet
     *
     * @return boolean 
     */
    public function getDejeunerBuffet()
    {
        return $this->dejeuner_buffet;
    }

    /**
     * Set dejeuner_non_compris
     *
     * @param boolean $dejeunerNonCompris
     */
    public function setDejeunerNonCompris($dejeunerNonCompris)
    {
        $this->dejeuner_non_compris = $dejeunerNonCompris;
    }

    /**
     * Get dejeuner_non_compris
     *
     * @return boolean 
     */
    public function getDejeunerNonCompris()
    {
        return $this->dejeuner_non_compris;
    }


    /**
     * Set max_personne
     *
     * @param string $maxPersonne
     */
    public function setMaxPersonne($maxPersonne)
    {
        $this->max_personne = $maxPersonne;
    }

    /**
     * Get max_personne
     *
     * @return string 
     */
    public function getMaxPersonne()
    {
        return $this->max_personne;
    }


    /**
     * Set ordre_affichage
     *
     * @param integer $ordreAffichage
     */
    public function setOrdreAffichage($ordreAffichage)
    {
        $this->ordre_affichage = $ordreAffichage;
    }

    /**
     * Get ordre_affichage
     *
     * @return integer 
     */
    public function getOrdreAffichage()
    {
        return $this->ordre_affichage;
    }

    /**
     * Add galerie_chambre
     *
     * @param MyApp\GlobalBundle\Entity\Galerie_photo_chambres $galerieChambre
     */
    public function addGalerie_photo_chambres(\MyApp\GlobalBundle\Entity\Galerie_photo_chambres $galerieChambre)
    {
        $this->galerie_chambre[] = $galerieChambre;
    }

    /**
     * Get galerie_chambre
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGalerieChambre()
    {
        return $this->galerie_chambre;
    }
    

    /**
     * Add type_prix
     *
     * @param MyApp\GlobalBundle\Entity\Types_prix $typePrix
     */
    public function addTypes_prix(\MyApp\GlobalBundle\Entity\Types_prix $typePrix, $em)
    {
    	if($typePrix->getPrixMin() != null and $typePrix->getPrixMax() != null and $typePrix->getCalendrierId() != null and $typePrix->getTitreHauteSaisonEn() != null and $typePrix->getTitreHauteSaisonFr() != null and $typePrix->getIndexChambre() != null){
    		//On regarde si on a un prix qui existe déjà pour cette chambre
    		$prixExiste = $em->find("MyAppGlobalBundle:Types_prix", $typePrix->getId());
			if($prixExiste == null)
    			$this->type_prix[] = $typePrix;
    	}
    }

    /**
     * Get type_prix
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTypePrix()
    {
        return $this->type_prix;
    }

    /**
     * Set reserver_chambre_en_ligne
     *
     * @param boolean $reserverChambreEnLigne
     */
    public function setReserverChambreEnLigne($reserverChambreEnLigne)
    {
        $this->reserver_chambre_en_ligne = $reserverChambreEnLigne;
    }

    /**
     * Get reserver_chambre_en_ligne
     *
     * @return boolean 
     */
    public function getReserverChambreEnLigne()
    {
        return $this->reserver_chambre_en_ligne;
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
     * Set nombre_lit
     *
     * @param integer $nombreLit
     */
    public function setNombreLit($nombreLit)
    {
        $this->nombre_lit = $nombreLit;
    }

    /**
     * Get nombre_lit
     *
     * @return integer 
     */
    public function getNombreLit()
    {
        return $this->nombre_lit;
    }
}