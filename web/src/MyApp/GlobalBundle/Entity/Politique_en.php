<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\GlobalBundle\Entity\Galerie_hebergement;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\HebergementsRepository")
 * @ORM\Table(name = "politique_en")
 * @ORM\HasLifecycleCallbacks
 */
class Politique_en{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $politique_generale_en
	 */
	private $politique_generale_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $politique_annulation_forfait_en
	 */
	private $politique_annulation_forfait_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $politique_animaux_en
	 */
	private $politique_animaux_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $politique_annulation_en
	 */
	private $politique_annulation_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $politique_tarif_en
	 */
	private $politique_tarif_en;
	
	//public $politique;
    
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
     * Set politique_generale_en
     *
     * @param text $politiqueGeneraleEn
     */
    public function setPolitiqueGeneraleEn($politiqueGeneraleEn)
    {
        //if($politiqueGeneraleEn != null)
    		$this->politique_generale_en = htmlentities ( $politiqueGeneraleEn );
    }

    /**
     * Get politique_generale_en
     *
     * @return text 
     */
    public function getPolitiqueGeneraleEn()
    {
        return html_entity_decode( $this->politique_generale_en );
    }

    /**
     * Set politique_animaux_en
     *
     * @param text $politiqueAnimauxEn
     */
    public function setPolitiqueAnimauxEn($politiqueAnimauxEn)
    {
        //if($politiqueAnimauxEn != null)
    		$this->politique_animaux_en = htmlentities ( $politiqueAnimauxEn );
    }

    /**
     * Get politique_animaux_en
     *
     * @return text 
     */
    public function getPolitiqueAnimauxEn()
    {
        return html_entity_decode( $this->politique_animaux_en );
    }

    /**
     * Set politique_annulatione_en
     *
     * @param text $politiqueAnnulationEn
     */
    public function setPolitiqueAnnulationEn($politiqueAnnulationEn)
    {
        //if($politiqueAnnulationEn != null)
    		$this->politique_annulation_en = htmlentities ( $politiqueAnnulationEn );
    }

    /**
     * Get politique_annulation_en
     *
     * @return text 
     */
    public function getPolitiqueAnnulationEn()
    {
        return html_entity_decode( $this->politique_annulation_en);
    }

    /**
     * Set politique_tarif_en
     *
     * @param text $politiqueTarifEn
     */
    public function setPolitiqueTarifEn($politiqueTarifEn)
    {
        //if($politiqueTarifEn != null)
    		$this->politique_tarif_en = htmlentities ( $politiqueTarifEn );
    }

    /**
     * Get politique_tarif_en
     *
     * @return text 
     */
    public function getPolitiqueTarifEn()
    {
        return html_entity_decode( $this->politique_tarif_en );
    }

    /**
     * Set politique_annulation_forfait_en
     *
     * @param text $politiqueAnnulationForfaitEn
     */
    public function setPolitiqueAnnulationForfaitEn($politiqueAnnulationForfaitEn)
    {
        //if($politiqueAnnulationForfaitEn != null)
    		$this->politique_annulation_forfait_en = htmlentities ( $politiqueAnnulationForfaitEn );
    }

    /**
     * Get politique_annulation_forfait_en
     *
     * @return text 
     */
    public function getPolitiqueAnnulationForfaitEn()
    {
        return html_entity_decode( $this->politique_annulation_forfait_en );
    }
}