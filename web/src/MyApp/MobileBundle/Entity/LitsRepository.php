<?php
namespace MyApp\MobileBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LitsRepository extends EntityRepository{

	/**
	 * Liste tous les lits
	 */
	public function getListeLits()
	{
            $sql = 'SELECT p FROM MyAppMobileBundle:Lits p';
            $query = $this->getEntityManager()->createQuery($sql);
            return $query->getResult();
	}
 
        public function getChercheLit($id)
        {
            $sql = 'SELECT p FROM MyAppMobileBundle:Lits p WHERE p.id = :id';
            $query = $this->getEntityManager()->createQuery($sql);
            $query->setParameter('id', $id);
            return $query->getResult();
        }
	
}