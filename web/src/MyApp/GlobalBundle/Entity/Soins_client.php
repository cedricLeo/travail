<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name = "soins_client")
 * @ORM\HasLifecycleCallbacks
 */
class Soins_client{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 * @ORM\Column(type = "integer" )
	 * 
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @ORM\Column(type = "string", length = 10, nullable = "true")
	 * 
	 * @var string $prix
	 */
	private $prix;
	
	/**
	 * @ORM\Column(type = "string", length = 10 ,nullable = "true")
	 * 
	 * @var string $duree
	 */
	private $duree;
	
	/**
	 * @ORM\Column(type = "integer", nullable = "true")
	 *
	 * @var integer $soins_sante_id 
	 */
	private $soins_sante_id;
	
	/**
	 * @ORM\Column(type = "integer", nullable = "true")
	 *
	 * @var integer $client_attrait_id
	 */
	private $client_attrait_id;
   
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
}