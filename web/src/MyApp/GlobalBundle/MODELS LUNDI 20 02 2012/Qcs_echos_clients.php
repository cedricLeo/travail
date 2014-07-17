<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "qcs_echos_clients")
 * @ORM\HasLifecycleCallbacks
 */
class Qcs_echos_clients{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\OneToOne(targetEntity = "Clients", inversedBy = "Qcs_echos_clients")
	 * @ORM\JoinColumn(name = "client_id", referencedColumnName = "id")
	 *
	 * @var integer $client_id
	 */
	private $client_id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Qcs_saisons", inversedBy = "Qcs_echos_clients")
	 * @ORM\JoinColumn(name = "qcs_saisons_id", referencedColumnName = "id")
	 *
	 * @var integer $qcs_saisons_id
	 */
	private $qcs_saisons_id;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_fr
	 */
	private $page_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $page_en
	 */
	private $page_en;
	
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
	 * @ORM\Column(type = "integer", length = 2)
	 * 
	 * @var integer $ordre
	 */
	private $ordre;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var text $image_entete_fr
	 */
	private $image_entete_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var text $image_entete_en
	 */
	private $image_entete_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $image_article
	 */
	private $image_article;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var text $image_liste
	 */
	private $image_liste;

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
     * Set ordre
     *
     * @param integer $ordre
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
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
     * Set image_liste
     *
     * @param string $imageListe
     */
    public function setImageListe($imageListe)
    {
        $this->image_liste = $imageListe;
    }

    /**
     * Get image_liste
     *
     * @return string 
     */
    public function getImageListe()
    {
        return $this->image_liste;
    }

    /**
     * Set client_id
     *
     * @param MyApp\GlobalBundle\Entity\Clients $clientId
     */
    public function setClientId(\MyApp\GlobalBundle\Entity\Clients $clientId)
    {
        $this->client_id = $clientId;
    }

    /**
     * Get client_id
     *
     * @return MyApp\GlobalBundle\Entity\Clients 
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set qcs_types_saisons_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_types_saisons $qcsTypesSaisonsId
     */
    public function setQcsTypesSaisonsId(\MyApp\GlobalBundle\Entity\Qcs_types_saisons $qcsTypesSaisonsId)
    {
        $this->qcs_types_saisons_id = $qcsTypesSaisonsId;
    }

    /**
     * Get qcs_types_saisons_id
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_types_saisons 
     */
    public function getQcsTypesSaisonsId()
    {
        return $this->qcs_types_saisons_id;
    }

    /**
     * Set qcs_saisons_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_saisons $qcsSaisonsId
     */
    public function setQcsSaisonsId(\MyApp\GlobalBundle\Entity\Qcs_saisons $qcsSaisonsId)
    {
        $this->qcs_saisons_id = $qcsSaisonsId;
    }

    /**
     * Get qcs_saisons_id
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_saisons 
     */
    public function getQcsSaisonsId()
    {
        return $this->qcs_saisons_id;
    }
}