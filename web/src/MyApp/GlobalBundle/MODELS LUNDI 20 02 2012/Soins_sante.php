<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Centre_SanteRepository")
 * @ORM\Table(name = "soins_sante")
 * @ORM\HasLifecycleCallbacks
 */
class Soins_sante{
	
	/**
	 * @ORM\Id
	 * @ORM\Column( type = "integer")
	 * @ORM\Generatedvalue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Sous_categories_attraits", inversedBy = "Soins_sante")
	 * @ORM\JoinColumn(name = "sous_categorie_attrait_id",  referencedColumnName = "id")
	 * 
	 * @var ArrayCollection $sous_categorie_attrait_id
	 */
	private $sous_categorie_attrait_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Villes", inversedBy = "Soins_sante")
	 * @ORM\JoinTable(name = "relations_villes_soins_sante")
	 * 
	 * @var ArrayCollection $ville_id
	 */
	private $ville_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Provinces_etats", mappedBy="Soins_sante")
	 * 
	 * @var ArrayCollection $province_etat_id
	 */
	private $province_etat_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Regions", mappedBy="Soins_sante")
	 *
	 * @var ArrayCollection $region_id
	 */
	private $region_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Attraits", mappedBy="Soins_sante")
	 * 
	 * @var ArrayCollection $attrait_id
	 */
	private $attrait_id;
	
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
	 * @var string $page_titre_fr
	 */
	private $page_titre_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $page_titre_en
	 */
	private $page_titre_en;
	
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
	 * @var text $texte_fr
	 */
	private $texte_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 * 
	 * @var text $texte_en
	 */
	private $texte_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $resume_fr
	 */
	private $resume_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $resume_en
	 */
	private $resume_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $image
	 */
	private $image;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Periode_soins_sante", mappedBy = "Soins_sante")
	 * 
	 * @var ArrayCollection $periode_soins_sante_id
	 */
	private $periode_soins_sante_id;	
	
	/**
	 * @ORM\OneToMany(targetEntity = "Categorie_soins_sante", mappedBy = "Soins_sante")
	 * 
	 * @var integer $categorie_soin_sante_id
	 */
	private $categorie_soin_sante_id;
	
    public function __construct()
    {
        $this->sous_categorie_attrait_id = new ArrayCollection();
        $this->province_etat_id = new ArrayCollection();
        $this->region_id = new ArrayCollection();
        $this->attrait_id = new ArrayCollection();
        $this->ville_id = new ArrayCollection();
        $this->periode_soins_sante_id = new ArrayCollection();
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
     * Set page_titre_fr
     *
     * @param string $pageTitreFr
     */
    public function setPageTitreFr($pageTitreFr)
    {
        $this->page_titre_fr = $pageTitreFr;
    }

    /**
     * Get page_titre_fr
     *
     * @return string 
     */
    public function getPageTitreFr()
    {
        return $this->page_titre_fr;
    }

    /**
     * Set page_titre_en
     *
     * @param string $pageTitreEn
     */
    public function setPageTitreEn($pageTitreEn)
    {
        $this->page_titre_en = $pageTitreEn;
    }

    /**
     * Get page_titre_en
     *
     * @return string 
     */
    public function getPageTitreEn()
    {
        return $this->page_titre_en;
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
     * Set texte_fr
     *
     * @param text $texteFr
     */
    public function setTexteFr($texteFr)
    {
        $this->texte_fr = $texteFr;
    }

    /**
     * Get texte_fr
     *
     * @return text 
     */
    public function getTexteFr()
    {
        return $this->texte_fr;
    }

    /**
     * Set texte_en
     *
     * @param text $texteEn
     */
    public function setTexteEn($texteEn)
    {
        $this->texte_en = $texteEn;
    }

    /**
     * Get texte_en
     *
     * @return text 
     */
    public function getTexteEn()
    {
        return $this->texte_en;
    }

    /**
     * Set resume_fr
     *
     * @param string $resumeFr
     */
    public function setResumeFr($resumeFr)
    {
        $this->resume_fr = $resumeFr;
    }

    /**
     * Get resume_fr
     *
     * @return string 
     */
    public function getResumeFr()
    {
        return $this->resume_fr;
    }

    /**
     * Set resume_en
     *
     * @param string $resumeEn
     */
    public function setResumeEn($resumeEn)
    {
        $this->resume_en = $resumeEn;
    }

    /**
     * Get resume_en
     *
     * @return string 
     */
    public function getResumeEn()
    {
        return $this->resume_en;
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
     * Set sous_categorie_attrait_id
     *
     * @param MyApp\GlobalBundle\Entity\Sous_categories_attraits $sousCategorieAttraitId
     */
    public function setSousCategorieAttraitId(\MyApp\GlobalBundle\Entity\Sous_categories_attraits $sousCategorieAttraitId)
    {
        $this->sous_categorie_attrait_id = $sousCategorieAttraitId;
    }

    /**
     * Get sous_categorie_attrait_id
     *
     * @return MyApp\GlobalBundle\Entity\Sous_categories_attraits 
     */
    public function getSousCategorieAttraitId()
    {
        return $this->sous_categorie_attrait_id;
    }

    /**
     * Add ville_id
     *
     * @param MyApp\GlobalBundle\Entity\Villes $villeId
     */
    public function addVilles(\MyApp\GlobalBundle\Entity\Villes $villeId)
    {
        $this->ville_id[] = $villeId;
    }

    /**
     * Get ville_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVilleId()
    {
        return $this->ville_id;
    }

    /**
     * Add province_etat_id
     *
     * @param MyApp\GlobalBundle\Entity\Provinces_etats $provinceEtatId
     */
    public function addProvinces_etats(\MyApp\GlobalBundle\Entity\Provinces_etats $provinceEtatId)
    {
        $this->province_etat_id[] = $provinceEtatId;
    }

    /**
     * Get province_etat_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProvinceEtatId()
    {
        return $this->province_etat_id;
    }

    /**
     * Add region_id
     *
     * @param MyApp\GlobalBundle\Entity\Regions $regionId
     */
    public function addRegions(\MyApp\GlobalBundle\Entity\Regions $regionId)
    {
        $this->region_id[] = $regionId;
    }

    /**
     * Get region_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRegionId()
    {
        return $this->region_id;
    }

    /**
     * Add attrait_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits $attraitId
     */
    public function addAttraits(\MyApp\GlobalBundle\Entity\Attraits $attraitId)
    {
        $this->attrait_id[] = $attraitId;
    }

    /**
     * Get attrait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAttraitId()
    {
        return $this->attrait_id;
    }

    /**
     * Add periode_soins_sante_id
     *
     * @param MyApp\GlobalBundle\Entity\Periode_soins_sante $periodeSoinsSanteId
     */
    public function addPeriode_soins_sante(\MyApp\GlobalBundle\Entity\Periode_soins_sante $periodeSoinsSanteId)
    {
        $this->periode_soins_sante_id[] = $periodeSoinsSanteId;
    }

    /**
     * Get periode_soins_sante_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPeriodeSoinsSanteId()
    {
        return $this->periode_soins_sante_id;
    }

    /**
     * Add categorie_soin_sante_id
     *
     * @param MyApp\GlobalBundle\Entity\Categorie_soins_sante $categorieSoinSanteId
     */
    public function addCategorie_soins_sante(\MyApp\GlobalBundle\Entity\Categorie_soins_sante $categorieSoinSanteId)
    {
        $this->categorie_soin_sante_id[] = $categorieSoinSanteId;
    }

    /**
     * Get categorie_soin_sante_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategorieSoinSanteId()
    {
        return $this->categorie_soin_sante_id;
    }
}