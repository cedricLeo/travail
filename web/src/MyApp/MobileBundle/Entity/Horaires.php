<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use MyApp\MobileBundle\Entity\Horaires;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\HorairesRepository")
 * @ORM\Table(name = "horaires")
 * @ORM\HasLifecycleCallbacks
 */
class Horaires{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue( strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $lundi_matin_ete
	 */
	private $lundi_matin_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $lundi_soir_ete
	 */
	private $lundi_soir_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $mardi_matin_ete
	 */
	private $mardi_matin_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $mardi_soir_ete
	 */
	private $mardi_soir_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $mercredi_matin_ete
	 */
	private $mercredi_matin_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $mercredi_soir_ete
	 */
	private $mercredi_soir_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $jeudi_matin_ete
	 */
	private $jeudi_matin_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $jeudi_soir_ete
	 */
	private $jeudi_soir_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $vendredi_matin_ete
	 */
	private $vendredi_matin_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $vendredi_soir_ete
	 */
	private $vendredi_soir_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $samedi_matin_ete
	 */
	private $samedi_matin_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $samedi_soir_ete
	 */
	private $samedi_soir_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $dimanche_matin_ete
	 */
	private $dimanche_matin_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $dimanche_soir_ete
	 */
	private $dimanche_soir_ete;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $lundi_matin_hiver
	 */
	private $lundi_matin_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $lundi_soir_hiver
	 */
	private $lundi_soir_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $mardi_matin_hiver
	 */
	private $mardi_matin_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $mardi_soir_hiver
	 */
	private $mardi_soir_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $mercredi_matin_hiver
	 */
	private $mercredi_matin_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $mercredi_soir_hiver
	 */
	private $mercredi_soir_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $jeudi_matin_hiver
	 */
	private $jeudi_matin_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $jeudi_soir_hiver
	 */
	private $jeudi_soir_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $vendredi_matin_hiver
	 */
	private $vendredi_matin_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $vendredi_soir_hiver
	 */
	private $vendredi_soir_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $samedi_matin_hiver
	 */
	private $samedi_matin_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $samedi_soir_hiver
	 */
	private $samedi_soir_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $dimanche_matin_hiver
	 */
	private $dimanche_matin_hiver;
	
	/**
	 * @ORM\Column(type = "time", nullable = "true")
	 *
	 * @var time $dimanche_soir_hiver
	 */
	private $dimanche_soir_hiver;
	
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
	 * Set lundi_matin_ete
	 *
	 * @param time $lundiMatinEte
	 */
	public function setLundiMatinEte($lundiMatinEte)
	{
		$this->lundi_matin_ete = $lundiMatinEte;
	}
	
	/**
	 * Get lundi_matin_ete
	 *
	 * @return time
	 */
	public function getLundiMatinEte()
	{
		return $this->lundi_matin_ete;
	}
	
	/**
	 * Set lundi_matin_hiver
	 *
	 * @param time $lundiMatinHiver
	 */
	public function setLundiMatinHiver($lundiMatinHiver)
	{
		$this->lundi_matin_hiver = $lundiMatinHiver;
	}
	
	/**
	 * Get lundi_matin_hiver
	 *
	 * @return time
	 */
	public function getLundiMatinHiver()
	{
		return $this->lundi_matin_hiver;
	}
	
	/**
	 * Set lundi_soir_ete
	 *
	 * @param time $lundiSoirEte
	 */
	public function setLundiSoirEte($lundiSoirEte)
	{
		$this->lundi_soir_ete = $lundiSoirEte;
	}
	
	/**
	 * Get lundi_soir_ete
	 *
	 * @return time
	 */
	public function getLundiSoirEte()
	{
		return $this->lundi_soir_ete;
	}
	
	/**
	 * Set lundi_soir_hiver
	 *
	 * @param time $lundiSoirHiver
	 */
	public function setLundiSoirHiver($lundiSoirHiver)
	{
		$this->lundi_soir_hiver = $lundiSoirHiver;
	}
	
	/**
	 * Get lundi_soir_hiver
	 *
	 * @return time
	 */
	public function getLundiSoirHiver()
	{
		return $this->lundi_soir_hiver;
	}
	
	/**
	 * Set mardi_matin_ete
	 *
	 * @param time $mardiMatinEte
	 */
	public function setMardiMatinEte($mardiMatinEte)
	{
		$this->mardi_matin_ete = $mardiMatinEte;
	}
	
	/**
	 * Get mardi_matin_ete
	 *
	 * @return time
	 */
	public function getMardiMatinEte()
	{
		return $this->mardi_matin_ete;
	}
	
	/**
	 * Set mardi_matin_hiver
	 *
	 * @param time $mardiMatinHiver
	 */
	public function setMardiMatinHiver($mardiMatinHiver)
	{
		$this->mardi_matin_hiver = $mardiMatinHiver;
	}
	
	/**
	 * Get mardi_matin_hiver
	 *
	 * @return time
	 */
	public function getMardiMatinHiver()
	{
		return $this->mardi_matin_hiver;
	}
	
	/**
	 * Set mardi_soir_ete
	 *
	 * @param time $mardiSoirEte
	 */
	public function setMardiSoirEte($mardiSoirEte)
	{
		$this->mardi_soir_ete = $mardiSoirEte;
	}
	
	/**
	 * Get mardi_soir_ete
	 *
	 * @return time
	 */
	public function getMardiSoirEte()
	{
		return $this->mardi_soir_ete;
	}
	
	/**
	 * Set mardi_soir_hiver
	 *
	 * @param time $mardiSoirHiver
	 */
	public function setMardiSoirHiver($mardiSoirHiver)
	{
		$this->mardi_soir_hiver = $mardiSoirHiver;
	}
	
	/**
	 * Get mardi_soir_hiver
	 *
	 * @return time
	 */
	public function getMardiSoirHiver()
	{
		return $this->mardi_soir_hiver;
	}
	
	/**
	 * Set mercredi_matin_ete
	 *
	 * @param time $mercrediMatinEte
	 */
	public function setMercrediMatinEte($mercrediMatinEte)
	{
		$this->mercredi_matin_ete = $mercrediMatinEte;
	}
	
	/**
	 * Get mercredi_matin_ete
	 *
	 * @return time
	 */
	public function getMercrediMatinEte()
	{
		return $this->mercredi_matin_ete;
	}
	
	/**
	 * Set mercredi_matin_hiver
	 *
	 * @param time $mercrediMatinHiver
	 */
	public function setMercrediMatinHiver($mercrediMatinHiver)
	{
		$this->mercredi_matin_hiver = $mercrediMatinHiver;
	}
	
	/**
	 * Get mercredi_matin_hiver
	 *
	 * @return time
	 */
	public function getMercrediMatinHiver()
	{
		return $this->mercredi_matin_hiver;
	}
	
	/**
	 * Set mercredi_soir_ete
	 *
	 * @param time $mercrediSoirEte
	 */
	public function setMercrediSoirEte($mercrediSoirEte)
	{
		$this->mercredi_soir_ete = $mercrediSoirEte;
	}
	
	/**
	 * Get mercredi_soir_ete
	 *
	 * @return time
	 */
	public function getMercrediSoirEte()
	{
		return $this->mercredi_soir_ete;
	}
	
	/**
	 * Set mercredi_soir_hiver
	 *
	 * @param time $mercrediSoirHiver
	 */
	public function setMercrediSoirHiver($mercrediSoirHiver)
	{
		$this->mercredi_soir_hiver = $mercrediSoirHiver;
	}
	
	/**
	 * Get mercredi_soir_hiver
	 *
	 * @return time
	 */
	public function getMercrediSoirHiver()
	{
		return $this->mercredi_soir_hiver;
	}
	
	/**
	 * Set jeudi_matin_ete
	 *
	 * @param time $jeudiMatinEte
	 */
	public function setJeudiMatinEte($jeudiMatinEte)
	{
		$this->jeudi_matin_ete = $jeudiMatinEte;
	}
	
	/**
	 * Get jeudi_matin_ete
	 *
	 * @return time
	 */
	public function getJeudiMatinEte()
	{
		return $this->jeudi_matin_ete;
	}
	
	/**
	 * Set jeudi_matin_hiver
	 *
	 * @param time $jeudiMatinHiver
	 */
	public function setJeudiMatinHiver($jeudiMatinHiver)
	{
		$this->jeudi_matin_hiver = $jeudiMatinHiver;
	}
	
	/**
	 * Get jeudi_matin_hiver
	 *
	 * @return time
	 */
	public function getJeudiMatinHiver()
	{
		return $this->jeudi_matin_hiver;
	}
	
	/**
	 * Set jeudi_soir_ete
	 *
	 * @param time $jeudiSoirEte
	 */
	public function setJeudiSoirEte($jeudiSoirEte)
	{
		$this->jeudi_soir_ete = $jeudiSoirEte;
	}
	
	/**
	 * Get jeudi_soir_ete
	 *
	 * @return time
	 */
	public function getJeudiSoirEte()
	{
		return $this->jeudi_soir_ete;
	}
	
	/**
	 * Set jeudi_soir_hiver
	 *
	 * @param time $jeudiSoirHiver
	 */
	public function setJeudiSoirHiver($jeudiSoirHiver)
	{
		$this->jeudi_soir_hiver = $jeudiSoirHiver;
	}
	
	/**
	 * Get jeudi_soir_hiver
	 *
	 * @return time
	 */
	public function getJeudiSoirHiver()
	{
		return $this->jeudi_soir_hiver;
	}
	
	/**
	 * Set vendredi_matin_ete
	 *
	 * @param time $vendrediMatinEte
	 */
	public function setVendrediMatinEte($vendrediMatinEte)
	{
		$this->vendredi_matin_ete = $vendrediMatinEte;
	}
	
	/**
	 * Get vendredi_matin_ete
	 *
	 * @return time
	 */
	public function getVendrediMatinEte()
	{
		return $this->vendredi_matin_ete;
	}
	
	/**
	 * Set vendredi_matin_hiver
	 *
	 * @param time $vendrediMatinHiver
	 */
	public function setVendrediMatinHiver($vendrediMatinHiver)
	{
		$this->vendredi_matin_hiver = $vendrediMatinHiver;
	}
	
	/**
	 * Get vendredi_matin_hiver
	 *
	 * @return time
	 */
	public function getVendrediMatinHiver()
	{
		return $this->vendredi_matin_hiver;
	}
	
	/**
	 * Set vendredi_soir_ete
	 *
	 * @param time $vendrediSoirEte
	 */
	public function setVendrediSoirEte($vendrediSoirEte)
	{
		$this->vendredi_soir_ete = $vendrediSoirEte;
	}
	
	/**
	 * Get vendredi_soir_ete
	 *
	 * @return time
	 */
	public function getVendrediSoirEte()
	{
		return $this->vendredi_soir_ete;
	}
	
	/**
	 * Set vendredi_soir_hiver
	 *
	 * @param time $vendrediSoirHiver
	 */
	public function setVendrediSoirHiver($vendrediSoirHiver)
	{
		$this->vendredi_soir_hiver = $vendrediSoirHiver;
	}
	
	/**
	 * Get vendredi_soir_hiver
	 *
	 * @return time
	 */
	public function getVendrediSoirHiver()
	{
		return $this->vendredi_soir_hiver;
	}
	
	/**
	 * Set samedi_matin_ete
	 *
	 * @param time $samediMatinEte
	 */
	public function setSamediMatinEte($samediMatinEte)
	{
		$this->samedi_matin_ete = $samediMatinEte;
	}
	
	/**
	 * Get samedi_matin_ete
	 *
	 * @return time
	 */
	public function getSamediMatinEte()
	{
		return $this->samedi_matin_ete;
	}
	
	/**
	 * Set samedi_matin_hiver
	 *
	 * @param time $samediMatinHiver
	 */
	public function setSamediMatinHiver($samediMatinHiver)
	{
		$this->samedi_matin_hiver = $samediMatinHiver;
	}
	
	/**
	 * Get samedi_matin_hiver
	 *
	 * @return time
	 */
	public function getSamediMatinHiver()
	{
		return $this->samedi_matin_hiver;
	}
	
	/**
	 * Set samedi_soir_ete
	 *
	 * @param time $samediSoirEte
	 */
	public function setSamediSoirEte($samediSoirEte)
	{
		$this->samedi_soir_ete = $samediSoirEte;
	}
	
	/**
	 * Get samedi_soir_ete
	 *
	 * @return time
	 */
	public function getSamediSoirEte()
	{
		return $this->samedi_soir_ete;
	}
	
	/**
	 * Set samedi_soir_hiver
	 *
	 * @param time $samediSoirHiver
	 */
	public function setSamediSoirHiver($samediSoirHiver)
	{
		$this->samedi_soir_hiver = $samediSoirHiver;
	}
	
	/**
	 * Get samedi_soir_hiver
	 *
	 * @return time
	 */
	public function getSamediSoirHiver()
	{
		return $this->samedi_soir_hiver;
	}
	
	/**
	 * Set dimanche_matin_ete
	 *
	 * @param time $dimancheMatinEte
	 */
	public function setDimancheMatinEte($dimancheMatinEte)
	{
		$this->dimanche_matin_ete = $dimancheMatinEte;
	}
	
	/**
	 * Get dimanche_matin_ete
	 *
	 * @return time
	 */
	public function getDimancheMatinEte()
	{
		return $this->dimanche_matin_ete;
	}
	
	/**
	 * Set dimanche_matin_hiver
	 *
	 * @param time $dimancheMatinHiver
	 */
	public function setDimancheMatinHiver($dimancheMatinHiver)
	{
		$this->dimanche_matin_hiver = $dimancheMatinHiver;
	}
	
	/**
	 * Get dimanche_matin_hiver
	 *
	 * @return time
	 */
	public function getDimancheMatinHiver()
	{
		return $this->dimanche_matin_hiver;
	}
	
	/**
	 * Set dimanche_soir_ete
	 *
	 * @param time $dimancheSoirEte
	 */
	public function setDimancheSoirEte($dimancheSoirEte)
	{
		$this->dimanche_soir_ete = $dimancheSoirEte;
	}
	
	/**
	 * Get dimanche_soir_ete
	 *
	 * @return time
	 */
	public function getDimancheSoirEte()
	{
		return $this->dimanche_soir_ete;
	}
	
	/**
	 * Set dimanche_soir_hiver
	 *
	 * @param time $dimancheSoirHiver
	 */
	public function setDimancheSoirHiver($dimancheSoirHiver)
	{
		$this->dimanche_soir_hiver = $dimancheSoirHiver;
	}
	
	/**
	 * Get dimanche_soir_hiver
	 *
	 * @return time
	 */
	public function getDimancheSoirHiver()
	{
		return $this->dimanche_soir_hiver;
	}
	
}