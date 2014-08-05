<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "qcs_types_saisons")
 */
class Qcs_types_saisons
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
	* @var string $menu_id
	*/
	private $menu_id;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $fichier_css
	*/
	private $fichier_css;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $fichier_css2
	*/
	private $fichier_css2;
	
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
	* @var string $image_fond_menu
	*/
	private $image_fond_menu;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $image_bas_page1
	*/
	private $image_bas_page1;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $image_bas_page2
	*/
	private $image_bas_page2;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $image_bas_page3
	*/
	private $image_bas_page3;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $image_blogue_colonne_gauche
	*/
	private $image_blogue_colonne_gauche;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $image_festival_colonne_gauche_fr
	*/
	private $image_festival_colonne_gauche_fr;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $image_festival_colonne_gauche_en
	*/
	private $imagefestivalcolonnegaucheen;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $image_resume_colonne_gauche_fr
	*/
	private $image_resume_colonne_gauche_fr;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $image_resume_colonne_gauche_en
	*/
	private $image_resume_colonne_gauche_en;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $image_over_resume_colonne_gauche_fr
	*/
	private $image_over_resume_colonne_gauche_fr;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $image_over_resume_colonne_gauche_en
	*/
	private $image_over_resume_colonne_gauche_en;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Qcs_saisons", mappedBy = "Qcs_types_saisons")
	 * 
	 * @var integer $qcs_saisons
	 */
	private $qcs_saisons;
	
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
     * Set menu_id
     *
     * @param string $menuId
     */
    public function setMenuId($menuId)
    {
        $this->menu_id = $menuId;
    }

    /**
     * Get menu_id
     *
     * @return string 
     */
    public function getMenuId()
    {
        return $this->menu_id;
    }

    /**
     * Set fichier_css
     *
     * @param string $fichierCss
     */
    public function setFichierCss($fichierCss)
    {
        $this->fichier_css = $fichierCss;
    }

    /**
     * Get fichier_css
     *
     * @return string 
     */
    public function getFichierCss()
    {
        return $this->fichier_css;
    }

    /**
     * Set fichier_css2
     *
     * @param string $fichierCss2
     */
    public function setFichierCss2($fichierCss2)
    {
        $this->fichier_css2 = $fichierCss2;
    }

    /**
     * Get fichier_css2
     *
     * @return string 
     */
    public function getFichierCss2()
    {
        return $this->fichier_css2;
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
     * Set image_fond_menu
     *
     * @param string $imageFondMenu
     */
    public function setImageFondMenu($imageFondMenu)
    {
        $this->image_fond_menu = $imageFondMenu;
    }

    /**
     * Get image_fond_menu
     *
     * @return string 
     */
    public function getImageFondMenu()
    {
        return $this->image_fond_menu;
    }

    /**
     * Set image_bas_page1
     *
     * @param string $imageBasPage1
     */
    public function setImageBasPage1($imageBasPage1)
    {
        $this->image_bas_page1 = $imageBasPage1;
    }

    /**
     * Get image_bas_page1
     *
     * @return string 
     */
    public function getImageBasPage1()
    {
        return $this->image_bas_page1;
    }

    /**
     * Set image_bas_page2
     *
     * @param string $imageBasPage2
     */
    public function setImageBasPage2($imageBasPage2)
    {
        $this->image_bas_page2 = $imageBasPage2;
    }

    /**
     * Get image_bas_page2
     *
     * @return string 
     */
    public function getImageBasPage2()
    {
        return $this->image_bas_page2;
    }

    /**
     * Set image_bas_page3
     *
     * @param string $imageBasPage3
     */
    public function setImageBasPage3($imageBasPage3)
    {
        $this->image_bas_page3 = $imageBasPage3;
    }

    /**
     * Get image_bas_page3
     *
     * @return string 
     */
    public function getImageBasPage3()
    {
        return $this->image_bas_page3;
    }

    /**
     * Set image_blogue_colonne_gauche
     *
     * @param string $imageBlogueColonneGauche
     */
    public function setImageBlogueColonneGauche($imageBlogueColonneGauche)
    {
        $this->image_blogue_colonne_gauche = $imageBlogueColonneGauche;
    }

    /**
     * Get image_blogue_colonne_gauche
     *
     * @return string 
     */
    public function getImageBlogueColonneGauche()
    {
        return $this->image_blogue_colonne_gauche;
    }

    /**
     * Set image_festival_colonne_gauche_fr
     *
     * @param string $imageFestivalColonneGaucheFr
     */
    public function setImageFestivalColonneGaucheFr($imageFestivalColonneGaucheFr)
    {
        $this->image_festival_colonne_gauche_fr = $imageFestivalColonneGaucheFr;
    }

    /**
     * Get image_festival_colonne_gauche_fr
     *
     * @return string 
     */
    public function getImageFestivalColonneGaucheFr()
    {
        return $this->image_festival_colonne_gauche_fr;
    }

    /**
     * Set imagefestivalcolonnegaucheen
     *
     * @param string $imagefestivalcolonnegaucheen
     */
    public function setImagefestivalcolonnegaucheen($imagefestivalcolonnegaucheen)
    {
        $this->imagefestivalcolonnegaucheen = $imagefestivalcolonnegaucheen;
    }

    /**
     * Get imagefestivalcolonnegaucheen
     *
     * @return string 
     */
    public function getImagefestivalcolonnegaucheen()
    {
        return $this->imagefestivalcolonnegaucheen;
    }

    /**
     * Set image_resume_colonne_gauche_fr
     *
     * @param string $imageResumeColonneGaucheFr
     */
    public function setImageResumeColonneGaucheFr($imageResumeColonneGaucheFr)
    {
        $this->image_resume_colonne_gauche_fr = $imageResumeColonneGaucheFr;
    }

    /**
     * Get image_resume_colonne_gauche_fr
     *
     * @return string 
     */
    public function getImageResumeColonneGaucheFr()
    {
        return $this->image_resume_colonne_gauche_fr;
    }

    /**
     * Set image_resume_colonne_gauche_en
     *
     * @param string $imageResumeColonneGaucheEn
     */
    public function setImageResumeColonneGaucheEn($imageResumeColonneGaucheEn)
    {
        $this->image_resume_colonne_gauche_en = $imageResumeColonneGaucheEn;
    }

    /**
     * Get image_resume_colonne_gauche_en
     *
     * @return string 
     */
    public function getImageResumeColonneGaucheEn()
    {
        return $this->image_resume_colonne_gauche_en;
    }

    /**
     * Set image_over_resume_colonne_gauche_fr
     *
     * @param string $imageOverResumeColonneGaucheFr
     */
    public function setImageOverResumeColonneGaucheFr($imageOverResumeColonneGaucheFr)
    {
        $this->image_over_resume_colonne_gauche_fr = $imageOverResumeColonneGaucheFr;
    }

    /**
     * Get image_over_resume_colonne_gauche_fr
     *
     * @return string 
     */
    public function getImageOverResumeColonneGaucheFr()
    {
        return $this->image_over_resume_colonne_gauche_fr;
    }

    /**
     * Set image_over_resume_colonne_gauche_en
     *
     * @param string $imageOverResumeColonneGaucheEn
     */
    public function setImageOverResumeColonneGaucheEn($imageOverResumeColonneGaucheEn)
    {
        $this->image_over_resume_colonne_gauche_en = $imageOverResumeColonneGaucheEn;
    }

    /**
     * Get image_over_resume_colonne_gauche_en
     *
     * @return string 
     */
    public function getImageOverResumeColonneGaucheEn()
    {
        return $this->image_over_resume_colonne_gauche_en;
    }

    /**
     * Add qcs_festival_attrait_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_festival_attraits $qcsFestivalAttraitId
     */
    public function addQcs_festival_attraits(\MyApp\GlobalBundle\Entity\Qcs_festival_attraits $qcsFestivalAttraitId)
    {
        $this->qcs_festival_attrait_id[] = $qcsFestivalAttraitId;
    }

    /**
     * Get qcs_festival_attrait_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsFestivalAttraitId()
    {
        return $this->qcs_festival_attrait_id;
    }

    /**
     * Add qcs_echos_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_echos $qcsEchosId
     */
    public function addQcs_echos(\MyApp\GlobalBundle\Entity\Qcs_echos $qcsEchosId)
    {
        $this->qcs_echos_id[] = $qcsEchosId;
    }

    /**
     * Get qcs_echos_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsEchosId()
    {
        return $this->qcs_echos_id;
    }

    /**
     * Add qcs_echos_clients_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_echos_clients $qcsEchosClientsId
     */
    public function addQcs_echos_clients(\MyApp\GlobalBundle\Entity\Qcs_echos_clients $qcsEchosClientsId)
    {
        $this->qcs_echos_clients_id[] = $qcsEchosClientsId;
    }

    /**
     * Get qcs_echos_clients_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsEchosClientsId()
    {
        return $this->qcs_echos_clients_id;
    }

    /**
     * Add qcs_echo_hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_echos_hebergements $qcsEchoHebergementId
     */
    public function addQcs_echos_hebergements(\MyApp\GlobalBundle\Entity\Qcs_echos_hebergements $qcsEchoHebergementId)
    {
        $this->qcs_echo_hebergement_id[] = $qcsEchoHebergementId;
    }

    /**
     * Get qcs_echo_hebergement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsEchoHebergementId()
    {
        return $this->qcs_echo_hebergement_id;
    }
    public function __construct()
    {
        $this->qcs_saisons = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add qcs_saisons
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_saisons $qcsSaisons
     */
    public function addQcs_saisons(\MyApp\GlobalBundle\Entity\Qcs_saisons $qcsSaisons)
    {
        $this->qcs_saisons[] = $qcsSaisons;
    }

    /**
     * Get qcs_saisons
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQcsSaisons()
    {
        return $this->qcs_saisons;
    }
}