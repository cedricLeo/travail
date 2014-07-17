<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "categorie_soins_sante")
 * @ORM\HasLifecycleCallbacks
 */
class Categorie_soins_sante{
	
	/**
	 * @ORM\Id
	 * @ORM\Column( type = "integer")
	 * @ORM\Generatedvalue(strategy = "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity = "Soins_sante", inversedBy = "Categorie_soins_sante")
	 * @ORM\JoinColumn(name = "soin_sante_id",  referencedColumnName = "id")
	 * 
	 * @var integer $soin_sante_id
	 */
	private $soin_sante_id;
	
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
     * Set soin_sante_id
     *
     * @param MyApp\GlobalBundle\Entity\Soins_sante $soinSanteId
     */
    public function setSoinSanteId(\MyApp\GlobalBundle\Entity\Soins_sante $soinSanteId)
    {
        $this->soin_sante_id = $soinSanteId;
    }

    /**
     * Get soin_sante_id
     *
     * @return MyApp\GlobalBundle\Entity\Soins_sante 
     */
    public function getSoinSanteId()
    {
        return $this->soin_sante_id;
    }
}