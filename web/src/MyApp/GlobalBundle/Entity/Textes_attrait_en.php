<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\HebergementsRepository")
 * @ORM\Table(name = "textes_attrait_en")
 * @ORM\HasLifecycleCallbacks
 */
class Textes_attrait_en{
	
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
	 * @var text $texte_resume_en
	 */
	private $texte_resume_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_tarif_en
	 */
	private $texte_tarif_en;

        /**
         * @ORM\Column(type="string", length = 255, nullable = "true")
         * 
         * @var string $repertoire_en
         */
        private $repertoire_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_periode_ouverture_en
	 */
	private $texte_periode_ouverture_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_horaire_en
	 */
	private $texte_horaire_en;
	
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