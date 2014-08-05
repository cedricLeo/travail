<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Temporaire_attraitsRepository")
 * @ORM\Table(name = "temporaire_attraits", indexes={@ORM\index(name="temporaire_attrait_idx", columns={"id"})})
 * @ORM\HasLifecycleCallbacks
 */
class Temporaire_attraits{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue( strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_description_fr
	 */
	private $texte_description_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_description_en
	 */
	private $texte_description_en;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_resume_fr
	 */
	private $texte_resume_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_resume_en
	 */
	private $texte_resume_en;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_express_fr
	 */
	private $texte_express_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_express_en
	 */
	private $texte_express_en;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_tarif_fr
	 */
	private $texte_tarif_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_tarif_en
	 */
	private $texte_tarif_en;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_horaire_fr
	 */
	private $texte_horaire_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_horaire_en
	 */
	private $texte_horaire_en;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_periode_ouverture_fr
	 */
	private $texte_periode_ouverture_fr;
	
	/**
	 * @ORM\Column(type = "text", nullable = "true")
	 * 
	 * @var text $texte_periode_ouverture_en
	 */
	private $texte_periode_ouverture_en;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Videos")
	 */
	private $url1_fr;
	
	/**
	 * @ORM\ManyToOne(targetEntity="MyApp\GlobalBundle\Entity\Horaires")
	 */
	private $lundi_matin_ete;
	
	
	public function __construct()
	{
		$this->url1_fr	= new ArrayCollection();
	}
	
	
	public function addUrl1Fr(Videos $url1fr)
	{
		$this->url1_fr[] = $url1fr;
	}
	
	public function getUrl1Fr()
	{
		return $this->url1_fr;
	}
    
	public function setLundiMatinEte($lundiMatinEte)
    {
        $this->lundi_matin_ete = $lundiMatinEte;
    }

    public function getLundiMatinEte()
    {
        return $this->lundi_matin_ete;
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
     * Set texte_description_fr
     *
     * @param text $texteDescriptionFr
     */
    public function setTexteDescriptionFr($texteDescriptionFr)
    {
        $this->texte_description_fr = $texteDescriptionFr;
    }

    /**
     * Get texte_description_fr
     *
     * @return text 
     */
    public function getTexteDescriptionFr()
    {
        return $this->texte_description_fr;
    }

    /**
     * Set texte_description_en
     *
     * @param text $texteDescriptionEn
     */
    public function setTexteDescriptionEn($texteDescriptionEn)
    {
        $this->texte_description_en = $texteDescriptionEn;
    }

    /**
     * Get texte_description_en
     *
     * @return text 
     */
    public function getTexteDescriptionEn()
    {
        return $this->texte_description_en;
    }

    /**
     * Set texte_resume_fr
     *
     * @param text $texteResumeFr
     */
    public function setTexteResumeFr($texteResumeFr)
    {
        $this->texte_resume_fr = $texteResumeFr;
    }

    /**
     * Get texte_resume_fr
     *
     * @return text 
     */
    public function getTexteResumeFr()
    {
        return $this->texte_resume_fr;
    }

    /**
     * Set texte_resume_en
     *
     * @param text $texteResumeEn
     */
    public function setTexteResumeEn($texteResumeEn)
    {
        $this->texte_resume_en = $texteResumeEn;
    }

    /**
     * Get texte_resume_en
     *
     * @return text 
     */
    public function getTexteResumeEn()
    {
        return $this->texte_resume_en;
    }

    /**
     * Set texte_express_fr
     *
     * @param text $texteExpressFr
     */
    public function setTexteExpressFr($texteExpressFr)
    {
        $this->texte_express_fr = $texteExpressFr;
    }

    /**
     * Get texte_express_fr
     *
     * @return text 
     */
    public function getTexteExpressFr()
    {
        return $this->texte_express_fr;
    }

    /**
     * Set texte_express_en
     *
     * @param text $texteExpressEn
     */
    public function setTexteExpressEn($texteExpressEn)
    {
        $this->texte_express_en = $texteExpressEn;
    }

    /**
     * Get texte_express_en
     *
     * @return text 
     */
    public function getTexteExpressEn()
    {
        return $this->texte_express_en;
    }

    /**
     * Set texte_tarif_fr
     *
     * @param text $texteTarifFr
     */
    public function setTexteTarifFr($texteTarifFr)
    {
        $this->texte_tarif_fr = $texteTarifFr;
    }

    /**
     * Get texte_tarif_fr
     *
     * @return text 
     */
    public function getTexteTarifFr()
    {
        return $this->texte_tarif_fr;
    }

    /**
     * Set texte_tarif_en
     *
     * @param text $texteTarifEn
     */
    public function setTexteTarifEn($texteTarifEn)
    {
        $this->texte_tarif_en = $texteTarifEn;
    }

    /**
     * Get texte_tarif_en
     *
     * @return text 
     */
    public function getTexteTarifEn()
    {
        return $this->texte_tarif_en;
    }

    /**
     * Set texte_horaire_fr
     *
     * @param text $texteHoraireFr
     */
    public function setTexteHoraireFr($texteHoraireFr)
    {
        $this->texte_horaire_fr = $texteHoraireFr;
    }

    /**
     * Get texte_horaire_fr
     *
     * @return text 
     */
    public function getTexteHoraireFr()
    {
        return $this->texte_horaire_fr;
    }

    /**
     * Set texte_horaire_en
     *
     * @param text $texteHoraireEn
     */
    public function setTexteHoraireEn($texteHoraireEn)
    {
        $this->texte_horaire_en = $texteHoraireEn;
    }

    /**
     * Get texte_horaire_en
     *
     * @return text 
     */
    public function getTexteHoraireEn()
    {
        return $this->texte_horaire_en;
    }

    /**
     * Set texte_periode_ouverture_fr
     *
     * @param text $textePeriodeOuvertureFr
     */
    public function setTextePeriodeOuvertureFr($textePeriodeOuvertureFr)
    {
        $this->texte_periode_ouverture_fr = $textePeriodeOuvertureFr;
    }

    /**
     * Get texte_periode_ouverture_fr
     *
     * @return text 
     */
    public function getTextePeriodeOuvertureFr()
    {
        return $this->texte_periode_ouverture_fr;
    }

    /**
     * Set texte_periode_ouverture_en
     *
     * @param text $textePeriodeOuvertureEn
     */
    public function setTextePeriodeOuvertureEn($textePeriodeOuvertureEn)
    {
        $this->texte_periode_ouverture_en = $textePeriodeOuvertureEn;
    }

    /**
     * Get texte_periode_ouverture_en
     *
     * @return text 
     */
    public function getTextePeriodeOuvertureEn()
    {
        return $this->texte_periode_ouverture_en;
    }

    /**
     * Add url1_fr
     *
     * @param MyApp\GlobalBundle\Entity\Videos $url1Fr
     */
    public function addVideos(\MyApp\GlobalBundle\Entity\Videos $url1Fr)
    {
        $this->url1_fr[] = $url1Fr;
    }
}