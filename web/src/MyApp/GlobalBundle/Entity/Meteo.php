<?php

namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "meteo")
 */
class Meteo
{
   	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 *
	 * @var integer $id
	 */
	private $id;

    /**
     * @ORM\Column(type="string", length = 8)
     * @var string $placecode
     */
    private $placecode;

    /**
     * @ORM\Column(type="string", length = 50)
     * @var string $name_en
     */
    private $name_en;

    /**
     * @ORM\Column(type="string", length = 50)
     * @var string $prov_code
     */
    private $prov_code;

    /**
     * @ORM\Column(type="string", length = 50)
     * @var string $prov_en
     */
    private $prov_en;

    /**
     * @ORM\Column(type="string", length = 50)
     * @var string $country_code
     */
    private $country_code;

    /**
     * @ORM\Column(type="string", length = 50)
     * @var string $country_en
     */
    private $country_en;


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
     * Set placecode
     *
     * @param string $placecode
     */
    public function setPlacecode($placecode)
    {
        $this->placecode = $placecode;
    }

    /**
     * Get placecode
     *
     * @return string 
     */
    public function getPlacecode()
    {
        return $this->placecode;
    }

    /**
     * Set name_en
     *
     * @param string $nameEn
     */
    public function setNameEn($nameEn)
    {
        $this->name_en = $nameEn;
    }

    /**
     * Get name_en
     *
     * @return string 
     */
    public function getNameEn()
    {
        return $this->name_en;
    }

    /**
     * Set prov_code
     *
     * @param string $provCode
     */
    public function setProvCode($provCode)
    {
        $this->prov_code = $provCode;
    }

    /**
     * Get prov_code
     *
     * @return string 
     */
    public function getProvCode()
    {
        return $this->prov_code;
    }

    /**
     * Set prov_en
     *
     * @param string $provEn
     */
    public function setProvEn($provEn)
    {
        $this->prov_en = $provEn;
    }

    /**
     * Get prov_en
     *
     * @return string 
     */
    public function getProvEn()
    {
        return $this->prov_en;
    }

    /**
     * Set country_code
     *
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->country_code = $countryCode;
    }

    /**
     * Get country_code
     *
     * @return string 
     */
    public function getCountryCode()
    {
        return $this->country_code;
    }

    /**
     * Set country_en
     *
     * @param string $countryEn
     */
    public function setCountryEn($countryEn)
    {
        $this->country_en = $countryEn;
    }

    /**
     * Get country_en
     *
     * @return string 
     */
    public function getCountryEn()
    {
        return $this->country_en;
    }
}