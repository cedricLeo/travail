<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "qcs_thematiques")
 */
class Qcs_thematiques{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Qcs_saisons", inversedBy = "Qcs_thematiques")
	 * @ORM\JoinColumn(name = "qcs_saison_id", referencedColumnName = "id")
	 * 
	 * @var integer $qcs_saison_id
	 */
	private $qcs_saison_id;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $page_fr
	 */
	private $page_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $page_en
	 */
	private $page_en;
        
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
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $metatitre_fr
	 */
	private $metatitre_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $metatitre_en
	 */
	private $metatitre_en;
	
	/**
	 * @ORM\Column(type="text")
	 *
	 * @var text $metadescription_fr
	 */
	private $metadescription_fr;
	
	/**
	 * @ORM\Column(type="text")
	 *
	 * @var text $metadescription_en
	 */
	private $metadescription_en;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $nom_en
	 */
	private $nom_en;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $titre_fr
	 */
	private $titre_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $titre_en
	 */
	private $titre_en;
	
	/**
	 * @ORM\Column(type="text")
	 *
	 * @var text $description_fr
	 */
	private $description_fr;
	
	/**
	 * @ORM\Column(type="text")
	 *
	 * @var text $description_en
	 */
	private $description_en;
	
	/**
	 * @ORM\Column(type="text")
	 *
	 * @var text $resume_fr
	 */
	private $resume_fr;
	
	/**
	 * @ORM\Column(type="text")
	 *
	 * @var text $resume_en
	 */
	private $resume_en;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $image_entete_fr
	 */
	private $image_entete_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $image_entete_en
	 */
	private $image_entete_en;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $image_accueil_fr
	 */
	private $image_accueil_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $image_accueil_en
	 */
	private $image_accueil_en;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $image_bas_page
	 */
	private $image_bas_page;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $image_article
	 */
	private $image_article;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Qcs_thematiques_attraits", mappedBy = "Qcs_thematiques")
	 * 
	 * @var integer $qcs_thematique_attrait_id
	 */
	private $qcs_thematique_attrait_id;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Qcs_thematiques_hebergements", mappedBy = "Qcs_thematiques")
	 *
	 * @var integer $qcs_thematique_hebergement_id
	 */
	private $qcs_thematique_hebergement_id;
	
    public function __construct()
    {
        $this->qcs_thematique_attrait_id = new ArrayCollection();
    	$this->qcs_thematique_hebergement_id = new ArrayCollection();
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
     * Set page_fr
     *
     * @param string $pageFr
     */
    public function setPageFr($pageFr)
    {
        $this->page_fr = $pageFr;
    }

    /**
     * Get page_fr
     *
     * @return string 
     */
    public function getPageFr()
    {
        return $this->page_fr;
    }

    /**
     * Set page_en
     *
     * @param string $pageEn
     */
    public function setPageEn($pageEn)
    {
        $this->page_en = $pageEn;
    }

    /**
     * Get page_en
     *
     * @return string 
     */
    public function getPageEn()
    {
        return $this->page_en;
    }

    /**
     * Set metatitre_fr
     *
     * @param string $metatitreFr
     */
    public function setMetatitreFr($metatitreFr)
    {
        $this->metatitre_fr = $metatitreFr;
    }

    /**
     * Get metatitre_fr
     *
     * @return string 
     */
    public function getMetatitreFr()
    {
        return $this->metatitre_fr;
    }

    /**
     * Set metatitre_en
     *
     * @param string $metatitreEn
     */
    public function setMetatitreEn($metatitreEn)
    {
        $this->metatitre_en = $metatitreEn;
    }

    /**
     * Get metatitre_en
     *
     * @return string 
     */
    public function getMetatitreEn()
    {
        return $this->metatitre_en;
    }

    /**
     * Set metadescription_fr
     *
     * @param text $metadescriptionFr
     */
    public function setMetadescriptionFr($metadescriptionFr)
    {
        $this->metadescription_fr = $metadescriptionFr;
    }

    /**
     * Get metadescription_fr
     *
     * @return text 
     */
    public function getMetadescriptionFr()
    {
        return $this->metadescription_fr;
    }

    /**
     * Set metadescription_en
     *
     * @param text $metadescriptionEn
     */
    public function setMetadescriptionEn($metadescriptionEn)
    {
        $this->metadescription_en = $metadescriptionEn;
    }

    /**
     * Get metadescription_en
     *
     * @return text 
     */
    public function getMetadescriptionEn()
    {
        return $this->metadescription_en;
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
     * Set titre_fr
     *
     * @param string $titreFr
     */
    public function setTitreFr($titreFr)
    {
        $this->titre_fr = $titreFr;
    }

    /**
     * Get titre_fr
     *
     * @return string 
     */
    public function getTitreFr()
    {
        return $this->titre_fr;
    }

    /**
     * Set titre_en
     *
     * @param string $titreEn
     */
    public function setTitreEn($titreEn)
    {
        $this->titre_en = $titreEn;
    }

    /**
     * Get titre_en
     *
     * @return string 
     */
    public function getTitreEn()
    {
        return $this->titre_en;
    }

    /**
     * Set description_fr
     *
     * @param text $descriptionFr
     */
    public function setDescriptionFr($descriptionFr)
    {
        $this->description_fr = $descriptionFr;
    }

    /**
     * Get description_fr
     *
     * @return text 
     */
    public function getDescriptionFr()
    {
        return $this->description_fr;
    }

    /**
     * Set description_en
     *
     * @param text $descriptionEn
     */
    public function setDescriptionEn($descriptionEn)
    {
        $this->description_en = $descriptionEn;
    }

    /**
     * Get description_en
     *
     * @return text 
     */
    public function getDescriptionEn()
    {
        return $this->description_en;
    }

    /**
     * Set resume_fr
     *
     * @param text $resumeFr
     */
    public function setResumeFr($resumeFr)
    {
        $this->resume_fr = $resumeFr;
    }

    /**
     * Get resume_fr
     *
     * @return text 
     */
    public function getResumeFr()
    {
        return $this->resume_fr;
    }

    /**
     * Set resume_en
     *
     * @param text $resumeEn
     */
    public function setResumeEn($resumeEn)
    {
        $this->resume_en = $resumeEn;
    }

    /**
     * Get resume_en
     *
     * @return text 
     */
    public function getResumeEn()
    {
        return $this->resume_en;
    }

    /**
     * Set image_entete_fr
     *
     * @param string $imageEnteteFr
     */
    public function setImageEnteteFr($imageEnteteFr)
    {
        $this->image_entete_fr = $imageEnteteFr;
    }

    /**
     * Get image_entete_fr
     *
     * @return string 
     */
    public function getImageEnteteFr()
    {
        return $this->image_entete_fr;
    }

    /**
     * Set image_entete_en
     *
     * @param string $imageEnteteEn
     */
    public function setImageEnteteEn($imageEnteteEn)
    {
        $this->image_entete_en = $imageEnteteEn;
    }

    /**
     * Get image_entete_en
     *
     * @return string 
     */
    public function getImageEnteteEn()
    {
        return $this->image_entete_en;
    }

    /**
     * Set image_accueil_fr
     *
     * @param string $imageAccueilFr
     */
    public function setImageAccueilFr($imageAccueilFr)
    {
        $this->image_accueil_fr = $imageAccueilFr;
    }

    /**
     * Get image_accueil_fr
     *
     * @return string 
     */
    public function getImageAccueilFr()
    {
        return $this->image_accueil_fr;
    }

    /**
     * Set image_accueil_en
     *
     * @param string $imageAccueilEn
     */
    public function setImageAccueilEn($imageAccueilEn)
    {
        $this->image_accueil_en = $imageAccueilEn;
    }

    /**
     * Get image_accueil_en
     *
     * @return string 
     */
    public function getImageAccueilEn()
    {
        return $this->image_accueil_en;
    }

    /**
     * Set image_bas_page
     *
     * @param string $imageBasPage
     */
    public function setImageBasPage($imageBasPage)
    {
        $this->image_bas_page = $imageBasPage;
    }

    /**
     * Get image_bas_page
     *
     * @return string 
     */
    public function getImageBasPage()
    {
        return $this->image_bas_page;
    }

    /**
     * Set image_article
     *
     * @param string $imageArticle
     */
    public function setImageArticle($imageArticle)
    {
        $this->image_article = $imageArticle;
    }

    /**
     * Get image_article
     *
     * @return string 
     */
    public function getImageArticle()
    {
        return $this->image_article;
    }

    /**
     * Set qcs_saison_id
     *
     * @param MyApp\MobileBundle\Entity\Qcs_saisons $qcsSaisonId
     */
    public function setQcsSaisonId(\MyApp\MobileBundle\Entity\Qcs_saisons $qcsSaisonId)
    {
        $this->qcs_saison_id = $qcsSaisonId;
    }

    /**
     * Get qcs_saison_id
     *
     * @return MyApp\MobileBundle\Entity\Qcs_saisons 
     */
    public function getQcsSaisonId()
    {
        return $this->qcs_saison_id;
    }

    /**
     * Add qcs_thematique_attrait_id
     *
     * @param MyApp\MobileBundle\Entity\Qcs_thematiques $qcsThematiqueAttraitId
     */
    public function addQcs_thematiques(\MyApp\MobileBundle\Entity\Qcs_thematiques $qcsThematiqueAttraitId)
    {
        $this->qcs_thematique_attrait_id[] = $qcsThematiqueAttraitId;
    }

    /**
     * Get qcs_thematique_attrait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsThematiqueAttraitId()
    {
        return $this->qcs_thematique_attrait_id;
    }

    /**
     * Add qcs_thematique_hebergement_id
     *
     * @param MyApp\MobileBundle\Entity\Qcs_thematiques_hebergements $qcsThematiqueHebergementId
     */
    public function addQcs_thematiques_hebergements(\MyApp\MobileBundle\Entity\Qcs_thematiques_hebergements $qcsThematiqueHebergementId)
    {
        $this->qcs_thematique_hebergement_id[] = $qcsThematiqueHebergementId;
    }

    /**
     * Get qcs_thematique_hebergement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsThematiqueHebergementId()
    {
        return $this->qcs_thematique_hebergement_id;
    }

    /**
     * Add qcs_thematique_attrait_id
     *
     * @param MyApp\MobileBundle\Entity\Qcs_thematiques_attraits $qcsThematiqueAttraitId
     */
    public function addQcs_thematiques_attraits(\MyApp\MobileBundle\Entity\Qcs_thematiques_attraits $qcsThematiqueAttraitId)
    {
        $this->qcs_thematique_attrait_id[] = $qcsThematiqueAttraitId;
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
}