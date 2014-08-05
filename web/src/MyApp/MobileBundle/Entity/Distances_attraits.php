<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MyApp\MobileBundle\Entity\Distances_attraitsRepository")
 * @ORM\Table(name="distances_attraits", indexes={@ORM\index(name="distance_attrait_idx", columns={"attrait"})})
 */
class Distances_attraits {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy= "AUTO")
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Attraits", inversedBy="Distances_attrait")
	 *
	 * @var integer $attrait_id
	 */
	private $attrait_id;
	
	/**
	 * @ORM\Column(type = "string", length = 10, nullable = "false")
	 *
	 * @var string $distance
	 */
	private $distance;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "false")
	 *
	 * @var string $nom_fr
	 */
	private $nom_fr;
	
	/**
	 * @ORM\Column(type = "string", length = 50, nullable = "false")
	 *
	 * @var string $nom_en
	 */
	private $nom_en;
	
	/**
	 * @ORM\Column(type = "integer", nullable = "false")
	 *
	 * @var integer $activite_id
	 */
	private $activite_id;
        
        /**
	 * @ORM\Column(type = "string", length = 50, nullable = "true")
	 *
	 * @var string $attrait
	 */
	private $attrait;

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
         * Set attrait_id
         *
         * @param integer $attraitId
         */
        public function setAttraitId($attraitId)
        {
            $this->attrait_id = $attraitId;
        }

        /**
         * Get attrait_id
         *
         * @return integer 
         */
        public function getAttraitId()
        {
            return $this->attrait_id;
        }

        /**
         * Set distance
         *
         * @param string $distance
         */
        public function setDistance($distance)
        {
            $this->distance = $distance;
        }

        /**
         * Get distance
         *
         * @return string 
         */
        public function getDistance()
        {
            return $this->distance;
        }

        /**
         * Set activite_id
         *
         * @param integer $activiteId
         */
        public function setActiviteId($activiteId)
        {
            $this->activite_id = $activiteId;
        }

        /**
         * Get activite_id
         *
         * @return integer 
         */
        public function getActiviteId()
        {
            return $this->activite_id;
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
         * Set attrait
         *
         * @param string $attrait
         */
        public function setAttrait($attrait)
        {
            $this->attrait = $attrait;
        }

        /**
         * Get attrait
         *
         * @return string 
         */
        public function getAttrait()
        {
            return $this->attrait;
        }
}