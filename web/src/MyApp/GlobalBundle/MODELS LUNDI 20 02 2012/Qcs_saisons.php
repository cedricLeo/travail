<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "qcs_saisons")
 */
class Qcs_saisons
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
	 * @ORM\ManyToOne(targetEntity = "Qcs_types_saisons", inversedBy = "Qcs_saisons")
	 * @ORM\JoinTable(name = "relations_qcs_saisons_qcs_types_saisons" )
	 * 
	 * @var integer $qcs_types_saisons
	 */
	private $qcs_types_saisons;
	
	/**
	 * @ORM\Column(type = "integer", length = 4)
	 *
	 * @var interger $annee
	 */
	private $annee;
	
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
	* @ORM\Column(type = "date")
	*
	* @var date $date_debut
	*/
	private $date_debut;
	
	/**
	 * @ORM\Column(type = "date")
	 *
	 * @var date $date_fin
	 */
	private $date_fin;
	
	/**
	* @ORM\Column(type = "string", length = 255)
	*
	* @var string $repertoire
	*/
	private $repertoire;
	
	/**
	* @ORM\Column(type = "boolean")
	*
	* @var boolean $encours
	*/
	private $encours;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $no_volume_fr
	 */
	private $no_volume_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $no_volume_en
	 */
	private $no_volume_en;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $resume_archive_fr
	 */
	private $resume_archive_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $resume_archive_en
	 */
	private $resume_archive_en;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $resume_colonne_gauche_fr
	 */
	private $resume_colonne_gauche_fr;
	
	/**
	 * @ORM\Column(type = "text")
	 *
	 * @var text $resume_colonne_gauche_en
	 */
	private $resume_colonne_gauche_en;
	
	/**
	 * @ORM\OneToMAny(targetEntity = "Qcs_festival_attraits", mappedBy = "Qcs_types_saisons")
	 *
	 * @var integer $qcs_festival_attrait_id
	 */
	private $qcs_festival_attrait_id;
	
	/**
	 * @ORM\OneToMAny(targetEntity = "Qcs_echos", mappedBy = "Qcs_types_saisons")
	 *
	 * @var integer $qcs_echos_id
	 */
	private $qcs_echos_id;
	
	/**
	 * @ORM\OneToMAny(targetEntity = "Qcs_echos_clients", mappedBy = "Qcs_types_saisons")
	 *
	 * @var integer $qcs_echos_clients_id
	 */
	private $qcs_echos_clients_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Qcs_echos_hebergements", mappedBy = "Qcs_types_saisons")
	 *
	 * @var ArrayCollection $qcs_echo_hebergement_id
	 */
	private $qcs_echo_hebergement_id;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Regions", mappedBy = "Qcs_types_saisons")
	 *
	 * @var ArrayCollection $regions_id
	 */
	private $region_id;
	
	public function __construct()
	{
		$this->qcs_echo_hebergement_id = new ArrayCollection();
		$this->region_id = new ArrayCollection();
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
     * Set annee
     *
     * @param integer $annee
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    }

    /**
     * Get annee
     *
     * @return integer 
     */
    public function getAnnee()
    {
        return $this->annee;
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
     * Set date_debut
     *
     * @param date $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->date_debut = $dateDebut;
    }

    /**
     * Get date_debut
     *
     * @return date 
     */
    public function getDateDebut()
    {
        return $this->date_debut;
    }

    /**
     * Set date_fin
     *
     * @param date $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->date_fin = $dateFin;
    }

    /**
     * Get date_fin
     *
     * @return date 
     */
    public function getDateFin()
    {
        return $this->date_fin;
    }

    /**
     * Set repertoire
     *
     * @param string $repertoire
     */
    public function setRepertoire($repertoire)
    {
        $this->repertoire = $repertoire;
    }

    /**
     * Get repertoire
     *
     * @return string 
     */
    public function getRepertoire()
    {
        return $this->repertoire;
    }

    /**
     * Set encours
     *
     * @param boolean $encours
     */
    public function setEncours($encours)
    {
        $this->encours = $encours;
    }

    /**
     * Get encours
     *
     * @return boolean 
     */
    public function getEncours()
    {
        return $this->encours;
    }

    /**
     * Set no_volume_fr
     *
     * @param string $noVolumeFr
     */
    public function setNoVolumeFr($noVolumeFr)
    {
        $this->no_volume_fr = $noVolumeFr;
    }

    /**
     * Get no_volume_fr
     *
     * @return string 
     */
    public function getNoVolumeFr()
    {
        return $this->no_volume_fr;
    }

    /**
     * Set no_volume_en
     *
     * @param string $noVolumeEn
     */
    public function setNoVolumeEn($noVolumeEn)
    {
        $this->no_volume_en = $noVolumeEn;
    }

    /**
     * Get no_volume_en
     *
     * @return string 
     */
    public function getNoVolumeEn()
    {
        return $this->no_volume_en;
    }

    /**
     * Set resume_archive_fr
     *
     * @param text $resumeArchiveFr
     */
    public function setResumeArchiveFr($resumeArchiveFr)
    {
        $this->resume_archive_fr = $resumeArchiveFr;
    }

    /**
     * Get resume_archive_fr
     *
     * @return text 
     */
    public function getResumeArchiveFr()
    {
        return $this->resume_archive_fr;
    }

    /**
     * Set resume_archive_en
     *
     * @param text $resumeArchiveEn
     */
    public function setResumeArchiveEn($resumeArchiveEn)
    {
        $this->resume_archive_en = $resumeArchiveEn;
    }

    /**
     * Get resume_archive_en
     *
     * @return text 
     */
    public function getResumeArchiveEn()
    {
        return $this->resume_archive_en;
    }

    /**
     * Set resume_colonne_gauche_fr
     *
     * @param text $resumeColonneGaucheFr
     */
    public function setResumeColonneGaucheFr($resumeColonneGaucheFr)
    {
        $this->resume_colonne_gauche_fr = $resumeColonneGaucheFr;
    }

    /**
     * Get resume_colonne_gauche_fr
     *
     * @return text 
     */
    public function getResumeColonneGaucheFr()
    {
        return $this->resume_colonne_gauche_fr;
    }

    /**
     * Set resume_colonne_gauche_en
     *
     * @param text $resumeColonneGaucheEn
     */
    public function setResumeColonneGaucheEn($resumeColonneGaucheEn)
    {
        $this->resume_colonne_gauche_en = $resumeColonneGaucheEn;
    }

    /**
     * Get resume_colonne_gauche_en
     *
     * @return text 
     */
    public function getResumeColonneGaucheEn()
    {
        return $this->resume_colonne_gauche_en;
    }

    /**
     * Set qcs_types_saisons
     *
     * @param MyApp\GlobalBundle\Entity\Qcs_types_saisons $qcsTypesSaisons
     */
    public function setQcsTypesSaisons(\MyApp\GlobalBundle\Entity\Qcs_types_saisons $qcsTypesSaisons)
    {
        $this->qcs_types_saisons = $qcsTypesSaisons;
    }

    /**
     * Get qcs_types_saisons
     *
     * @return MyApp\GlobalBundle\Entity\Qcs_types_saisons 
     */
    public function getQcsTypesSaisons()
    {
        return $this->qcs_types_saisons;
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
}