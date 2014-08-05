<?php
namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

class Hebergements_politiquesRepository extends EntityRepository{

	/*******************************************************************/
	//	Méthodes pour politiques
	/*******************************************************************/
	
	/**
	 * Affiche la liste des politiques
	 */
	public function getListPolitiques()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_politiques p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	



}