<?php
namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

class Corporatifs_servicesRepository extends EntityRepository{

	/*******************************************************************/
	//	Méthodes pour corporatifs_services
	/*******************************************************************/

	/**
	 *	Affiche la liste des services corporatifs pour les h�bergements.
	 */
	public function getListCorporatifService()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Corporatifs_services p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

}