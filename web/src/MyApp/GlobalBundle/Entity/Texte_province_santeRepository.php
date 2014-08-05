<?php

namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Texte_province_santeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Texte_province_santeRepository extends EntityRepository
{
    
    /**
     * Méthode qui valide si on a déjà des textes pour cette province
     */
    public function getValideTexteProvinceExiste($id)
    {
        $sql = 'SELECT p FROM MyAppGlobalBundle:Texte_province_sante p WHERE p.province =:id';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter("id", $id);
        return $query->getResult();
    }
    
    /**
     * Recherche les textes d'accueil
     */
    public function getRechercheTexteAccueil($province, $sante)
    {
        $sql = 'SELECT p FROM MyAppGlobalBundle:Texte_province_sante p WHERE p.province =:province AND p.sante =:soin';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter("province", $province);
        $query->setParameter("soin", $sante);
        return $query->getResult();
    }
}