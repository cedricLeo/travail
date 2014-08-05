<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\MobileBundle\Entity\Galerie_hebergement;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\HebergementsRepository")
 * @ORM\Table(name = "politique_fr")
 * @ORM\HasLifecycleCallbacks
 */
class Politique_fr{
	
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
	 * @var text $politique_generale_fr
	 */
	private $politique_generale_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $politique_annulation_forfait_fr
	 */
	private $politique_annulation_forfait_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $politique_animaux_fr
	 */
	private $politique_animaux_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $politique_annulation_fr
	 */
	private $politique_annulation_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $politique_tarif_fr
	 */
	private $politique_tarif_fr;
	
	public $politique;
    
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
     * @param text $politiqueGeneraleFr
     */
    public function setPolitiqueGeneraleFr($politiqueGeneraleFr)
    {
    	if($politiqueGeneraleFr != null)
        	$this->politique_generale_fr = htmlentities ( $politiqueGeneraleFr );	
    }

    /**
     * Get politique_generale_fr
     *
     * @return text 
     */
    public function getPolitiqueGeneraleFr()
    {
        return html_entity_decode( $this->politique_generale_fr );
    }

    /**
     * Set politique_animaux_fr
     *
     * @param text $politiqueAnimauxFr
     */
    public function setPolitiqueAnimauxFr($politiqueAnimauxFr)
    {
    	if($politiqueAnimauxFr != null)
        	$this->politique_animaux_fr = htmlentities ( $politiqueAnimauxFr );	
    }

    /**
     * Get politique_animaux_fr
     *
     * @return text 
     */
    public function getPolitiqueAnimauxFr()
    {
        return html_entity_decode( $this->politique_animaux_fr );
    }

    /**
     * Set politique_annulation_fr
     *
     * @param text $politiqueAnnulationFr
     */
    public function setPolitiqueAnnulationFr($politiqueAnnulationFr)
    {
    	if($politiqueAnnulationFr != null)
        	$this->politique_annulation_fr = htmlentities ( $politiqueAnnulationFr) ;
    }

    /**
     * Get politique_annulation_fr
     *
     * @return text 
     */
    public function getPolitiqueAnnulationFr()
    {
        return html_entity_decode( $this->politique_annulation_fr);
    }

    /**
     * Set politique_tarif_fr
     *
     * @param text $politiqueTarifFr
     */
    public function setPolitiqueTarifFr($politiqueTarifFr)
    {
    	if($politiqueTarifFr != null)
        	$this->politique_tarif_fr = htmlentities ( $politiqueTarifFr);
    }

    /**
     * Get politique_tarif_fr
     *
     * @return text 
     */
    public function getPolitiqueTarifFr()
    {
        return html_entity_decode( $this->politique_tarif_fr );
    }

    /**
     * Set politique_annulation_forfait_fr
     *
     * @param text $politiqueAnnulationForfaitFr
     */
    public function setPolitiqueAnnulationForfaitFr($politiqueAnnulationForfaitFr)
    {
        if($politiqueAnnulationForfaitFr != null)
    		$this->politique_annulation_forfait_fr = htmlentities ( $politiqueAnnulationForfaitFr);
    }

    /**
     * Get politique_annulation_forfait_fr
     *
     * @return text 
     */
    public function getPolitiqueAnnulationForfaitFr()
    {
        return html_entity_decode( $this->politique_annulation_forfait_fr);
    }
}