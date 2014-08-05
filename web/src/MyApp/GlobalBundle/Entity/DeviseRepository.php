<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 * 
 * Fonctions pour les devises
 *
 */
class DeviseRepository extends EntityRepository
{
	/**
	 * Liste toutes les devises
	 */
	public function getDevise()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Devises p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

	
	
}