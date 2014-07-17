<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "qcs_concours")
 */
class Qcs_concours
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Qcs_reglements", inversedBy = "Qcs_concours")
	 * 
	 * @var integer $reglement_id
	 */
	private $reglement_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Hebergements", inversedBy = "Qcs_concours")
	 *
	 * @var integer $hebergement_id
	 */
	private $hebergement_id;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $metatitre_fr
	 */
	private $metatitre_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $metatitre_en
	 */
	private $metatitre_en;
        
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
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $metakeywords_fr
	 */
	private $metakeywords_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $metakeywords_en
	 */
	private $metakeywords_en;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $metadescription_fr
	 */
	private $metadescription_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $metadescription_en
	 */
	private $metadescription_en;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $titre_fr
	*/
	private $titre_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $titre_en
	 */
	private $titre_en;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $description_fr
	 */
	private $description_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $description_en
	 */
	private $description_en;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $resume_fr
	 */
	private $resume_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $resume_en
	 */
	private $resume_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $image_entete_fr
	 */
	private $image_entete_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $image_entete_en
	 */
	private $image_entete_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $image_accueil_fr
	 */
	private $image_accueil_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $image_accueil_en
	 */
	private $image_accueil_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $image_article
	 */
	private $image_article;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Qcs_saisons", inversedBy = "Qcs_Concours")
	 * @ORM\JoinColumn(name = "qcs_saison_id", referencedColumnName = "id")
	 *
	 * @var integer $qcs_saison_id
	 */
	private $qcs_saison_id;
	

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
     * Set metakeywords_fr
     *
     * @param string $metakeywordsFr
     */
    public function setMetakeywordsFr($metakeywordsFr)
    {
        $this->metakeywords_fr = $metakeywordsFr;
    }

    /**
     * Get metakeywords_fr
     *
     * @return string 
     */
    public function getMetakeywordsFr()
    {
        return $this->metakeywords_fr;
    }

    /**
     * Set metakeywords_en
     *
     * @param string $metakeywordsEn
     */
    public function setMetakeywordsEn($metakeywordsEn)
    {
        $this->metakeywords_en = $metakeywordsEn;
    }

    /**
     * Get metakeywords_en
     *
     * @return string 
     */
    public function getMetakeywordsEn()
    {
        return $this->metakeywords_en;
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
     * @param string $metadescriptionEn
     */
    public function setMetadescriptionEn($metadescriptionEn)
    {
        $this->metadescription_en = $metadescriptionEn;
    }

    /**
     * Get metadescription_en
     *
     * @return string 
     */
    public function getMetadescriptionEn()
    {
        return $this->metadescription_en;
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
     * Set reglement_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_reglements $reglementId
     */
    public function setReglementId(\MyApp\GlobalBundle\Entity\Qcs_reglements $reglementId)
    {
        $this->reglement_id = $reglementId;
    }

    /**
     * Get reglement_id
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_reglements 
     */
    public function getReglementId()
    {
        return $this->reglement_id;
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
     * Get hebergement_id
     *
     * @return MyApp\GlobalBundle\Entity\Hebergements 
     */
    public function getHebergementId()
    {
        return $this->hebergement_id;
    }

    /**
     * Set qcs_saison_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_Concours $qcsSaisonId
     */
    public function setQcsSaisonId(\MyApp\GlobalBundle\Entity\Qcs_Concours $qcsSaisonId)
    {
        $this->qcs_saison_id = $qcsSaisonId;
    }

    /**
     * Get qcs_saison_id
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_Concours 
     */
    public function getQcsSaisonId()
    {
        return $this->qcs_saison_id;
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