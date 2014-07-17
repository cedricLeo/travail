<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "Hebergements_politiques")
 */
class Hebergements_politiques
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
	 * @ORM\ManyToMany(targetEntity = "Hebergements", inversedBy = "Hebergements_politiques")
	 * @ORM\JoinTable(name = "relations_hebergements_politiques_hebergements")
	 *
	 * @var ArrayCollection $hebergement_id
	 */
	private $hebergement_id;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $politique_generale_fr
	 */
	private $politique_generale_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $politique_generale_en
	 */
	private $politique_generale_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $politique_animaux_fr
	 */
	private $politique_animaux_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $politique_animaux_en
	 */
	private $politique_animaux_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $politique_annulation_fr
	 */
	private $politique_annulation_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 * 
	 * @var string $politique_annulation_en
	 */
	private $politique_annulation_en;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $politique_tarif_fr
	 */
	private $politique_tarif_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 255)
	 *
	 * @var string $politique_tarif_en
	 */
	private $politique_tarif_en;
		
	public function __construct()
	{
		$this->hebergement_id = new ArrayCollection();
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
     * Set politique_generale_fr
     *
     * @param string $politiqueGeneraleFr
     */
    public function setPolitiqueGeneraleFr($politiqueGeneraleFr)
    {
        $this->politique_generale_fr = $politiqueGeneraleFr;
    }

    /**
     * Get politique_generale_fr
     *
     * @return string 
     */
    public function getPolitiqueGeneraleFr()
    {
        return $this->politique_generale_fr;
    }

    /**
     * Set politique_generale_en
     *
     * @param string $politiqueGeneraleEn
     */
    public function setPolitiqueGeneraleEn($politiqueGeneraleEn)
    {
        $this->politique_generale_en = $politiqueGeneraleEn;
    }

    /**
     * Get politique_generale_en
     *
     * @return string 
     */
    public function getPolitiqueGeneraleEn()
    {
        return $this->politique_generale_en;
    }

    /**
     * Set politique_animaux_fr
     *
     * @param string $politiqueAnimauxFr
     */
    public function setPolitiqueAnimauxFr($politiqueAnimauxFr)
    {
        $this->politique_animaux_fr = $politiqueAnimauxFr;
    }

    /**
     * Get politique_animaux_fr
     *
     * @return string 
     */
    public function getPolitiqueAnimauxFr()
    {
        return $this->politique_animaux_fr;
    }

    /**
     * Set politique_animaux_en
     *
     * @param string $politiqueAnimauxEn
     */
    public function setPolitiqueAnimauxEn($politiqueAnimauxEn)
    {
        $this->politique_animaux_en = $politiqueAnimauxEn;
    }

    /**
     * Get politique_animaux_en
     *
     * @return string 
     */
    public function getPolitiqueAnimauxEn()
    {
        return $this->politique_animaux_en;
    }

    /**
     * Set politique_annulation_fr
     *
     * @param string $politiqueAnnulationFr
     */
    public function setPolitiqueAnnulationFr($politiqueAnnulationFr)
    {
        $this->politique_annulation_fr = $politiqueAnnulationFr;
    }

    /**
     * Get politique_annulation_fr
     *
     * @return string 
     */
    public function getPolitiqueAnnulationFr()
    {
        return $this->politique_annulation_fr;
    }

    /**
     * Set politique_annulation_en
     *
     * @param string $politiqueAnnulationEn
     */
    public function setPolitiqueAnnulationEn($politiqueAnnulationEn)
    {
        $this->politique_annulation_en = $politiqueAnnulationEn;
    }

    /**
     * Get politique_annulation_en
     *
     * @return string 
     */
    public function getPolitiqueAnnulationEn()
    {
        return $this->politique_annulation_en;
    }

    /**
     * Set politique_tarif_fr
     *
     * @param string $politiqueTarifFr
     */
    public function setPolitiqueTarifFr($politiqueTarifFr)
    {
        $this->politique_tarif_fr = $politiqueTarifFr;
    }

    /**
     * Get politique_tarif_fr
     *
     * @return string 
     */
    public function getPolitiqueTarifFr()
    {
        return $this->politique_tarif_fr;
    }

    /**
     * Set politique_tarif_en
     *
     * @param string $politiqueTarifEn
     */
    public function setPolitiqueTarifEn($politiqueTarifEn)
    {
        $this->politique_tarif_en = $politiqueTarifEn;
    }

    /**
     * Get politique_tarif_en
     *
     * @return string 
     */
    public function getPolitiqueTarifEn()
    {
        return $this->politique_tarif_en;
    }

    /**
     * Add hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementId
     */
    public function addHebergements(\MyApp\GlobalBundle\Entity\Hebergements $hebergementId)
    {
        $this->hebergement_id[] = $hebergementId;
    }

    /**
     * Get hebergement_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHebergementId()
    {
        return $this->hebergement_id;
    }
}