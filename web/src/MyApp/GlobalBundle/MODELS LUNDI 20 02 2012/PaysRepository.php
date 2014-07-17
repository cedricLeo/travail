<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

class PaysRepository extends EntityRepository{
	
	//Fonction pour lister les pays dans l'admin.
	public function getListStates()
	{
		$dql = 'SELECT p FROM MyAppGlobalBundle:pays p';
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
	}
	
	//Récupère le pays qui doit être modifier.
	public function getUpdateState($id)
	{
		$dql = 'SELECT p FROM MyAppGlobalBundle:Pays p WHERE p.id =:id';
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
}