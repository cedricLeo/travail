<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "Hebergement_photo")
 */
class Hebergement_photo{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Hebergements" )
	 * @ORM\JoinColumn(name="hebergement_id", referencedColumnName="id")
	 *
	 * @var integer $hebergement_id
	 */
	private $hebergement_id;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $image_1
	 */
	private $image_1;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 *
	 * @var string $image_2
	 */
	private $image_2;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $titre_fr
	 */
	private $titre_fr;
	
	/**
	 * @ORM\Column(type="string", length = 255)
	 * 
	 * @var string $titre_en
	 */
	private $titre_en;
	
	/**
	 * @ORM\Column(type="string", length = 1)
	 *
	 * @var string $type
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
     * Set hebergement_id
     *
     * @param MyApp\GlobalBundle\Entity\Hebergements $hebergementId
     */
    public function setHebergementId(\MyApp\GlobalBundle\Entity\Hebergements $hebergementId)
    {
        $this->hebergement_id = $hebergementId;
    }

    /**
     * Get hebergement_id
     *
     * @return MyApp\GlobalBundle\Entity\Hebergements 
     */
    public function getHebergementId()
    {
        return $this->hebergement_id;
    }
}