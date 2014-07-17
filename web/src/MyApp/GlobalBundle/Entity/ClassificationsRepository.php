<?php
namespace MyApp\GlobalBundle\Entity;
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
		$sql = 'SELECT p.id, p.valeur, p.image FROM MyAppGlobalBundle:Classifications p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
}