<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Provinces_etatsRepository")
 * @ORM\Table(name = "Provinces_etats")
 * @ORM\HasLifecycleCallbacks
 */
class Provinces_etats
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     * 
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $nom_fr
     */
    private $nom_fr;

    /**
     * @ORM\Column(type = "string", length = 255)
     *  
     * @var string $nom_en
     */
    private $nom_en;

    /**
     * @ORM\Column(type = "string", length = 255)
     *  
     * @var string $titre_fr_travel_attraits
     */
    private $titre_fr_travel_attraits;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $titre_en_travel_attraits
     */
    private $titre_en_travel_attraits;

    /**
     * @ORM\Column(type = "text")
     * 
     * @var text $texte_fr_travel_attraits
     */
    private $texte_fr_travel_attraits;

    /**
     * @ORM\Column(type = "text")
     * 
     * @var text $texte_en_travel_attraits
     */
    private $texte_en_travel_attraits;

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
     * @var string $page_metakeyword_fr
     */
    private $page_metakeyword_fr;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $page_metakeyword_en
     */
    private $page_metakeyword_en;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $page_metadescription_fr
     */
    private $page_metadescription_fr;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $page_metadescription_en
     */
    private $page_metadescription_en;

    /**
     * @ORM\Column(type = "text")
     * 
     * @var text $texte_accueil_fr
     */
    private $texte_accueil_fr;

    /**
     * @ORM\Column(type = "text")
     * 
     * @var text $texte_accueil_en
     */
    private $texte_accueil_en;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $image
     */
    private $image;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var string $image_suggestion
     */
    private $image_suggestion;

    /**
     * @ORM\Column(type = "string", length = 255)
     * 
     * @var integer $reservit_id
     */
    private $reservit_id;

	/**
	 * @ORM\ManyToOne(targetEntity="Pays", inversedBy="Provinces_etats")
	 *
	 * 
	 * @var integer $pays_id
	 */
    private $pays_id;

    /**
     * @ORM\ManyToMany(targetEntity = "Soins_sante")
     * @ORM\JoinTable(name = "relations_provinces_soins_sante",
     * 		joinColumns={@ORM\JoinColumn(name = "provinces_etats_id", referencedColumnName = "id")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name = "soins_sante_id", referencedColumnName = "id")}
     * )
     *
     * @var ArrayCollection $soins_sante_id
     */
     private $soins_sante_id;
    
    /**
     * @ORM\ManyToMany(targetEntity = "Attraits")
     * @ORM\JoinTable(name = "relations_provinces_Attraits",
     * 		joinColumns={@ORM\JoinColumn(name = "provinces_etats_id", referencedColumnName = "id")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name = "attraits_id", referencedColumnName = "id")}
     * )
     *
     * @var ArrayCollection $attraits_id
     */
     private $attraits_id;
    
    /**
     * @ORM\ManyToMany(targetEntity = "Hebergements")
     * @ORM\JoinTable(name = "relations_provinces_Hebergements",
     * 		joinColumns={@ORM\JoinColumn(name = "provinces_etats_id", referencedColumnName = "id")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name = "hebergements_id", referencedColumnName = "id")}
     * )
     *
     * @var ArrayCollection $hebergements_id
     */
     private $hebergements_id;
     
    /* public function getAbsolutePath()
     {
     	return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
     }
     
     public function getWebPath()
     {
     	return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
     }
     
	public function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/images';
    }
      
	public function upload()
	{
	    // the file property can be empty if the field is not required
	    if (null === $this->image) {
	        return;
	    }
	
	    // we use the original file name here but you should
	    // sanitize it at least to avoid any security issues
	
	    // move takes the target directory and then the target filename to move to
	    $this->image->move($this->getUploadRootDir(), $this->image->getUploadRootDir());
	
	    // set the path property to the filename where you'ved saved the file
	    $this->path = $this->image->getUploadRootDir();
	
	    // clean up the file property as you won't need it anymore
	    $this->image = null;
	}*/

    public function __construct()
    {
        $this->soins_sante_id = new ArrayCollection();
        $this->attraits_id = new ArrayCollection();
        $this->hebergements_id = new ArrayCollection();
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
     * Set titre_fr_travel_attraits
     *
     * @param string $titreFrTravelAttraits
     */
    public function setTitreFrTravelAttraits($titreFrTravelAttraits)
    {
        $this->titre_fr_travel_attraits = $titreFrTravelAttraits;
    }

    /**
     * Get titre_fr_travel_attraits
     *
     * @return string 
     */
    public function getTitreFrTravelAttraits()
    {
        return $this->titre_fr_travel_attraits;
    }

    /**
     * Set titre_en_travel_attraits
     *
     * @param string $titreEnTravelAttraits
     */
    public function setTitreEnTravelAttraits($titreEnTravelAttraits)
    {
        $this->titre_en_travel_attraits = $titreEnTravelAttraits;
    }

    /**
     * Get titre_en_travel_attraits
     *
     * @return string 
     */
    public function getTitreEnTravelAttraits()
    {
        return $this->titre_en_travel_attraits;
    }

    /**
     * Set texte_fr_travel_attraits
     *
     * @param text $texteFrTravelAttraits
     */
    public function setTexteFrTravelAttraits($texteFrTravelAttraits)
    {
        $this->texte_fr_travel_attraits = $texteFrTravelAttraits;
    }

    /**
     * Get texte_fr_travel_attraits
     *
     * @return text 
     */
    public function getTexteFrTravelAttraits()
    {
        return $this->texte_fr_travel_attraits;
    }

    /**
     * Set texte_en_travel_attraits
     *
     * @param text $texteEnTravelAttraits
     */
    public function setTexteEnTravelAttraits($texteEnTravelAttraits)
    {
        $this->texte_en_travel_attraits = $texteEnTravelAttraits;
    }

    /**
     * Get texte_en_travel_attraits
     *
     * @return text 
     */
    public function getTexteEnTravelAttraits()
    {
        return $this->texte_en_travel_attraits;
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
     * Set page_metakeyword_fr
     *
     * @param string $pageMetakeywordFr
     */
    public function setPageMetakeywordFr($pageMetakeywordFr)
    {
        $this->page_metakeyword_fr = $pageMetakeywordFr;
    }

    /**
     * Get page_metakeyword_fr
     *
     * @return string 
     */
    public function getPageMetakeywordFr()
    {
        return $this->page_metakeyword_fr;
    }

    /**
     * Set page_metakeyword_en
     *
     * @param string $pageMetakeywordEn
     */
    public function setPageMetakeywordEn($pageMetakeywordEn)
    {
        $this->page_metakeyword_en = $pageMetakeywordEn;
    }

    /**
     * Get page_metakeyword_en
     *
     * @return string 
     */
    public function getPageMetakeywordEn()
    {
        return $this->page_metakeyword_en;
    }

    /**
     * Set page_metadescription_fr
     *
     * @param string $pageMetadescriptionFr
     */
    public function setPageMetadescriptionFr($pageMetadescriptionFr)
    {
        $this->page_metadescription_fr = $pageMetadescriptionFr;
    }

    /**
     * Get page_metadescription_fr
     *
     * @return string 
     */
    public function getPageMetadescriptionFr()
    {
        return $this->page_metadescription_fr;
    }

    /**
     * Set page_metadescription_en
     *
     * @param string $pageMetadescriptionEn
     */
    public function setPageMetadescriptionEn($pageMetadescriptionEn)
    {
        $this->page_metadescription_en = $pageMetadescriptionEn;
    }

    /**
     * Get page_metadescription_en
     *
     * @return string 
     */
    public function getPageMetadescriptionEn()
    {
        return $this->page_metadescription_en;
    }

    /**
     * Set texte_accueil_fr
     *
     * @param text $texteAccueilFr
     */
    public function setTexteAccueilFr($texteAccueilFr)
    {
        $this->texte_accueil_fr = $texteAccueilFr;
    }

    /**
     * Get texte_accueil_fr
     *
     * @return text 
     */
    public function getTexteAccueilFr()
    {
        return $this->texte_accueil_fr;
    }

    /**
     * Set texte_accueil_en
     *
     * @param text $texteAccueilEn
     */
    public function setTexteAccueilEn($texteAccueilEn)
    {
        $this->texte_accueil_en = $texteAccueilEn;
    }

    /**
     * Get texte_accueil_en
     *
     * @return text 
     */
    public function getTexteAccueilEn()
    {
        return $this->texte_accueil_en;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image_suggestion
     *
     * @param string $imageSuggestion
     */
    public function setImageSuggestion($imageSuggestion)
    {
        $this->image_suggestion = $imageSuggestion;
    }

    /**
     * Get image_suggestion
     *
     * @return string 
     */
    public function getImageSuggestion()
    {
        return $this->image_suggestion;
    }

    /**
     * Set reservit_id
     *
     * @param string $reservitId
     */
    public function setReservitId($reservitId)
    {
        $this->reservit_id = $reservitId;
    }

    /**
     * Get reservit_id
     *
     * @return string 
     */
    public function getReservitId()
    {
        return $this->reservit_id;
    }

    /**
     * Set pays_id
     *
     * @param MyApp\GlobalBundle\Entity\Pays $paysId
     */
    public function setPaysId(\MyApp\GlobalBundle\Entity\Pays $paysId)
    {
        $this->pays_id = $paysId;
    }

    /**
     * Get pays_id
     *
     * @return MyApp\GlobalBundle\Entity\Pays 
     */
    public function getPaysId()
    {
        return $this->pays_id;
    }

    /**
     * Add soins_sante_id
     *
     * @param MyApp\GlobalBundle\Entity\Soins_sante $soinsSanteId
     */
    public function addSoins_sante(\MyApp\GlobalBundle\Entity\Soins_sante $soinsSanteId)
    {
        $this->soins_sante_id[] = $soinsSanteId;
    }

    /**
     * Get soins_sante_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSoinsSanteId()
    {
        return $this->soins_sante_id;
    }

    /**
     * Add attraits_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits $attraitsId
     */
    public function addAttraits(\MyApp\GlobalBundle\Entity\Attraits $attraitsId)
    {
        $this->attraits_id[] = $attraitsId;
    }

    /**
     * Get attraits_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitsId()
    {
        return $this->attraits_id;
    }

    /**
     * Add hebergements_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementsId
     */
    public function addHebergements(\MyApp\GlobalBundle\Entity\Hebergements $hebergementsId)
    {
        $this->hebergements_id[] = $hebergementsId;
    }

    /**
     * Get hebergements_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementsId()
    {
        return $this->hebergements_id;
    }
}