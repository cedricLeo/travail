<?php

namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "attraits_photos")
 */
class Attraits_photos{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Attraits", inversedBy = "Attraits_photos")
	 * @ORM\JoinColumn(name="attraits_id", referencedColumnName = "id")
	 *
	 * @var integer $attraits_id
	 */
	private $attraits_id;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var string $image_1
	 */
	private $image_1;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 * 
	 * @var integer $image_2
	 */
	private $image_2;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var string $titre_fr
	 */
	private $titre_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 255)
	 *
	 * @var integer $titre_en
	 */
	private $titre_en;
	
	/**
	 * @ORM\Column(type = "string", length = 1)
	 *
	 * @var integer $type
	 */
	private $type;
	

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
     * Set image_1
     *
     * @param string $image1
     */
    public function setImage1($image1)
    {
        $this->image_1 = $image1;
    }

    /**
     * Get image_1
     *
     * @return string 
     */
    public function getImage1()
    {
        return $this->image_1;
    }

    /**
     * Set image_2
     *
     * @param string $image2
     */
    public function setImage2($image2)
    {
        $this->image_2 = $image2;
    }

    /**
     * Get image_2
     *
     * @return string 
     */
    public function getImage2()
    {
        return $this->image_2;
    }

    /**
     * Set titre_fr
     *
     * @param string $titreFr
     */
    public function setTitreFr($titreFr)
    {
        $this->titre_fr = $titreFr;
    }

    /**
     * Get titre_fr
     *
     * @return string 
     */
    public function getTitreFr()
    {
        return $this->titre_fr;
    }

    /**
     * Set titre_en
     *
     * @param string $titreEn
     */
    public function setTitreEn($titreEn)
    {
        $this->titre_en = $titreEn;
    }

    /**
     * Get titre_en
     *
     * @return string 
     */
    public function getTitreEn()
    {
        return $this->titre_en;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set attraits_id
     *
     * @param MyApp\GlobalBundle\Entity\Attraits $attraitsId
     */
    public function setAttraitsId(\MyApp\GlobalBundle\Entity\Attraits $attraitsId)
    {
        $this->attraits_id = $attraitsId;
    }

    /**
     * Get attraits_id
     *
     * @return MyApp\GlobalBundle\Entity\Attraits 
     */
    public function getAttraitsId()
    {
        return $this->attraits_id;
    }
}