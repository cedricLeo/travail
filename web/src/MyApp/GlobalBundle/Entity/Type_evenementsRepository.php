<?php
namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

class Type_evenementsRepository extends EntityRepository{


	/**
	 *	Affiche la liste des types événements pour les hébergements.
	 */
	public function getListTypeEvenement()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Types_evenements p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

}