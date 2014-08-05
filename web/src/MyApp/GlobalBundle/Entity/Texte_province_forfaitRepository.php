<?php

namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Texte_province_forfaitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Texte_province_forfaitRepository extends EntityRepository
{
    /**
     * Méthode qui valide si on a déjà des textes pour cette province
     */
    public function getValideTexteProvinceExiste($id)
    {
        $sql = 'SELECT p FROM MyAppGlobalBundle:Texte_province_forfait p WHERE p.province =:id';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter("id", $id);
        return $query->getResult();
    }
    
    /**
     * Recherche les textes d'accueil
     */
    public function getRechercheTexteAccueil($province, $forfait)
    {
        $sql = 'SELECT p FROM MyAppGlobalBundle:Texte_province_forfait p WHERE p.province = :province AND p.forfait =:forfait';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter("province", $province);
        $query->setParameter("forfait", $forfait);
        return $query->getResult();
    }
}