<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "qcs_pages_statiques")
 */
class Qcs_pages_statiques{
	
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
	 * @var string $nom
	 */
	private $nom;
	
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
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $metakeyword_fr
	 */
	private $metakeyword_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $metakeyword_en
	 */
	private $metakeyword_en;
	
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
	 * @ORM\Column(type="integer", length = 4)
	 *
	 * @var integer $largeur_image_entete
	 */
	private $largeur_image_entete;
	
	/**
	 * @ORM\Column(type="integer", length = 4)
	 *
	 * @var integer $hauteur_image_entete
	 */
	private $hauteur_image_entete;


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
     * Set metakeyword_fr
     *
     * @param string $metakeywordFr
     */
    public function setMetakeywordFr($metakeywordFr)
    {
        $this->metakeyword_fr = $metakeywordFr;
    }

    /**
     * Get metakeyword_fr
     *
     * @return string 
     */
    public function getMetakeywordFr()
    {
        return $this->metakeyword_fr;
    }

    /**
     * Set metakeyword_en
     *
     * @param string $metakeywordEn
     */
    public function setMetakeywordEn($metakeywordEn)
    {
        $this->metakeyword_en = $metakeywordEn;
    }

    /**
     * Get metakeyword_en
     *
     * @return string 
     */
    public function getMetakeywordEn()
    {
        return $this->metakeyword_en;
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
     * Set largeur_image_entete
     *
     * @param integer $largeurImageEntete
     */
    public function setLargeurImageEntete($largeurImageEntete)
    {
        $this->largeur_image_entete = $largeurImageEntete;
    }

    /**
     * Get largeur_image_entete
     *
     * @return integer 
     */
    public function getLargeurImageEntete()
    {
        return $this->largeur_image_entete;
    }

    /**
     * Set hauteur_image_entete
     *
     * @param integer $hauteurImageEntete
     */
    public function setHauteurImageEntete($hauteurImageEntete)
    {
        $this->hauteur_image_entete = $hauteurImageEntete;
    }

    /**
     * Get hauteur_image_entete
     *
     * @return integer 
     */
    public function getHauteurImageEntete()
    {
        return $this->hauteur_image_entete;
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