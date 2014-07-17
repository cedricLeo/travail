<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\Texte_accueil_mini_siteRepository")
 * @ORM\Table(name = "texte_accueil_mini_site")
 */
class Texte_accueil_mini_site {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_minisite_forfait_fr
	 */
	private $texte_minisite_forfait_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_minisite_forfait_en
	 */
	private $texte_minisite_forfait_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_minisite_corporatif_fr
	 */
	private $texte_minisite_corporatif_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_minisite_corporatif_en
	 */
	private $texte_minisite_corporatif_en;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_minisite_soin_fr
	 */
	private $texte_minisite_soin_fr;
	
	/**
	 * @ORM\Column(type="text", nullable = "true")
	 *
	 * @var text $texte_minisite_soin_en
	 */
	private $texte_minisite_soin_en;
	
	
	/**
	 * Set texte_minisite_forfait_fr
	 *
	 * @param text $texteMinisiteForfaitFr
	 */
	public function setTexteMinisiteForfaitFr($texteMinisiteForfaitFr)
	{
		$this->texte_minisite_forfait_fr = $texteMinisiteForfaitFr;
	}
	
	/**
	 * Get texte_minisite_forfait_fr
	 *
	 * @return text
	 */
	public function getTexteMinisiteForfaitFr()
	{
		return $this->texte_minisite_forfait_fr;
	}
	
	/**
	 * Set texte_minisite_forfait_en
	 *
	 * @param text $texteMinisiteForfaitEn
	 */
	public function setTexteMinisiteForfaitEn($texteMinisiteForfaitEn)
	{
		$this->texte_minisite_forfait_en = $texteMinisiteForfaitEn;
	}
	
	/**
	 * Get texte_minisite_forfait_en
	 *
	 * @return text
	 */
	public function getTexteMinisiteForfaitEn()
	{
		return $this->texte_minisite_forfait_en;
	}
	
	/**
	 * Set texte_minisite_corporatif_fr
	 *
	 * @param text $texteMinisiteCorporatifFr
	 */
	public function setTexteMinisiteCorporatifFr($texteMinisiteCorporatifFr)
	{
		$this->texte_minisite_corporatif_fr = $texteMinisiteCorporatifFr;
	}
	
	/**
	 * Get texte_minisite_corporatif_fr
	 *
	 * @return text
	 */
	public function getTexteMinisiteCorporatifFr()
	{
		return $this->texte_minisite_corporatif_fr;
	}
	
	/**
	 * Set texte_minisite_corporatif_en
	 *
	 * @param text $texteMinisiteCorporatifEn
	 */
	public function setTexteMinisiteCorporatifEn($texteMinisiteCorporatifEn)
	{
		$this->texte_minisite_corporatif_en = $texteMinisiteCorporatifEn;
	}
	
	/**
	 * Get texte_minisite_corporatif_en
	 *
	 * @return text
	 */
	public function getTexteMinisiteCorporatifEn()
	{
		return $this->texte_minisite_corporatif_en;
	}
	
	/**
	 * Set texte_minisite_soin_fr
	 *
	 * @param text $texteMinisiteSoinFr
	 */
	public function setTexteMinisiteSoinFr($texteMinisiteSoinFr)
	{
		$this->texte_minisite_soin_fr = $texteMinisiteSoinFr;
	}
	
	/**
	 * Get texte_minisite_soin_fr
	 *
	 * @return text
	 */
	public function getTexteMinisiteSoinFr()
	{
		return $this->texte_minisite_soin_fr;
	}
	
	/**
	 * Set texte_minisite_soin_en
	 *
	 * @param text $texteMinisiteSoinEn
	 */
	public function setTexteMinisiteSoinEn($texteMinisiteSoinEn)
	{
		$this->texte_minisite_soin_en = $texteMinisiteSoinEn;
	}
	
	/**
	 * Get texte_minisite_soin_en
	 *
	 * @return text
	 */
	public function getTexteMinisiteSoinEn()
	{
		return $this->texte_minisite_soin_en;
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
}