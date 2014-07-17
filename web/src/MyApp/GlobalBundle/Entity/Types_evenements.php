<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MyApp\GlobalBundle\Entity\Type_evenementsRepository")
 * @ORM\Table(name = "types_evenements")
 */
class Types_evenements
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
	 * @ORM\Column(type = "string", length = 100)
	 * 
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string" , length = 100)
	 * 
	 * @var string $nom_en
	 */
	private $nom_en;
        
       /**
        * @ORM\Column(type="string", length = 255, nullable = "true")
        * 
        * @var string $repertoire_fr
        */
       private $repertoire_fr;

       /**
        * @ORM\Column(type="string", length = 255, nullable = "true")
        * 
        * @var string $repertoire_en
        */
       private $repertoire_en;
	
	/**
	 * @ORM\ManyToMany(targetEntity = "Hebergements_salles_corporatives", mappedBy = "Types_evenements")
	 * 
	 * @var ArrayCollection $service_corporatif
	 */
	private $service_corporatif;
	
	/**
	 * @ORM\OneToMany(targetEntity = "Appel_Offre", mappedBy = "Types_evenements")
	 *
	 * @var integer $appel_offre_id
	 */
	private $appel_offre_id;
	
	public function __construct()
	{
		return $this->service_corporatif 	= new ArrayCollection();
	}
	
	public function __toString()
	{
		return $this->nom_fr;
		return $this->nom_en;
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
     * Add service_corporatif
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives $serviceCorporatif
     */
    public function addHebergements_salles_corporatives(\MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives $serviceCorporatif)
    {
        $this->service_corporatif[] = $serviceCorporatif;
    }

    /**
     * Get service_corporatif
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getServiceCorporatif()
    {
        return $this->service_corporatif;
    }

  

    /**
     * Add appel_offre_id
     *
     * @param MyApp\GlobalBundle\Entity\Appel_Offre $appelOffreId
     */
    public function addAppel_Offre(\MyApp\GlobalBundle\Entity\Appel_Offre $appelOffreId)
    {
        $this->appel_offre_id[] = $appelOffreId;
    }

    /**
     * Get appel_offre_id
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAppelOffreId()
    {
        return $this->appel_offre_id;
    }
}