<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author leonardc
 * 
 * Fonctions pour les classifications
 *
 */
class ClassificationsRepository extends EntityRepository{
	
	/**
	 * Retourne la liste des classifications
	 */
	public function getListClassifications()
	{
		$sql = 'SELECT p.id, p.valeur, p.image FROM MyAppMobileBundle:Classifications p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
}