<?php

namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Texte_province_attraitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Texte_province_attraitRepository extends EntityRepository
{
    
    /**
     * Méthode qui valide si on a déjà des textes pour cette province
     */
    public function getValideTexteProvinceExiste($id)
    {
        $sql = 'SELECT p FROM MyAppGlobalBundle:Texte_province_attrait p WHERE p.province =:id';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter("id", $id);
        return $query->getResult();
    }
    
    /**
     * Recherche les textes d'accueil
     */
    public function getRechercheTexteAccueil($province, $attrait)
    {
        $sql = 'SELECT p FROM MyAppGlobalBundle:Texte_province_attrait p WHERE p.province =:province AND p.categorie_attrait = :attrait';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter("province", $province);
        $query->setParameter("attrait", $attrait);
        return $query->getResult();
    }
}