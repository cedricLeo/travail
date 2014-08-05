<?php
namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

class Cuisine_Repository extends EntityRepository
{
	public function getResto($id)
	{
		$dql = 'SELECT p, COUNT(p.id) AS nbh FROM MyAppGlobalBundle:ViewHebergement p WHERE p.categoriehebergement_id = :id ';
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	//R�cup�re l'idprovince dans la table des r�gions
	public function getRecupIdProvinceInRegion($id)
	{
		$dql = 'SELECT p FROM MyAppGlobalBundle:Regionstouristiques p WHERE p.id = :id';
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	//Affiche les types de restaurants pour la r�gion.
	public function getTypesCuisines($id)
	{
		$dql = 'SELECT p FROM MyAppGlobalBundle:Typescuisines p  ';
		$query = $this->getEntityManager()->createQuery($dql);
		//$query->setParameter('id', $id);
		return $query->getResult();
	}
	
}