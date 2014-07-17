<?php
namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EquipementsRepository extends EntityRepository{

	/**
	 * Affiche les équipements
	 */
	public function getListEquipements()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Equipements p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}


}