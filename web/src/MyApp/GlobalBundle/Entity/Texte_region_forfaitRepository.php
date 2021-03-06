<?php

namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Texte_region_forfaitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Texte_region_forfaitRepository extends EntityRepository
{
    
    /**
     * Méthode qui valide si on a déjà des textes pour cette région
     */
    public function getValideTexteRegionExiste($id)
    {
        $sql = 'SELECT p FROM MyAppGlobalBundle:Texte_region_forfait p WHERE p.region =:id';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter("id", $id);
        return $query->getResult();
    }
    
    /**
     * Recherche les textes d'accueil
     */
    public function getRechercheTexteAccueil($region, $forfait)
    {
        $sql = 'SELECT p FROM MyAppGlobalBundle:Texte_region_forfait p WHERE p.region =:region AND p.forfait =:forfait';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter("region", $region);
        $query->setParameter("forfait", $forfait);
        return $query->getResult();
    }
}