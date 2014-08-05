<?php

namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Calendrier_saisonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Calendrier_saisonRepository extends EntityRepository
{
	/**
	 * Retourne la liste des prix pour la chambre
	 */
	public function getRetourneListePrixChambre($id)
	{
            $sql = 'SELECT p FROM MyAppGlobalBundle:Types_prix p WHERE p.index_chambre = :id';
            $query = $this->getEntityManager()->createQuery($sql);
            $query->setParameter('id', $id);
            return $query->getResult();
	}	     
	
}