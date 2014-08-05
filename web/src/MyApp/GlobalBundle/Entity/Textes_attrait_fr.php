<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\HebergementsRepository")
 * @ORM\Table(name = "textes_attrait_fr")
 * @ORM\HasLifecycleCallbacks
 */
class Textes_attrait_fr{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="text", nullable = "false")
	 *
	 * @var text $texte_resume_fr
	 */
	private $texte_resume_fr;
        
       /**
        * @ORM\Column(type="string", length = 255, nullable = "true")
        * 
        * @var string $repertoire_fr
        */
       private $repertoire_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_tarif_fr
	 */
	private $texte_tarif_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_periode_ouverture_fr
	 */
	private $texte_periode_ouverture_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_horaire_fr
	 */
	private $texte_horaire_fr;
	
	public $textes;
    

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
}