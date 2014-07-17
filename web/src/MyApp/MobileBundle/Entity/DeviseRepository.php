<?php
namespace MyApp\MobileBundle\Entity;
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
		$sql = 'SELECT p FROM MyAppMobileBundle:Devises p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

	
	
}