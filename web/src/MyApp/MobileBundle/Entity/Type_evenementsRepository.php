<?php
namespace MyApp\MobileBundle\Entity;

use Doctrine\ORM\EntityRepository;

class Type_evenementsRepository extends EntityRepository{


	/**
	 *	Affiche la liste des types événements pour les hébergements.
	 */
	public function getListTypeEvenement()
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Types_evenements p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

}