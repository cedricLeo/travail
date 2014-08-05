<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

class ZonesRepository extends EntityRepository{
	
	//Affiche les zones géographiques
	public function getZones()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Zones p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	//Compte le nombre de zones dans la table.
	public function getCompteZones($limit = 30)
	{
		$sql = 'SELECT p, COUNT(p.id) AS nbzones FROM MyAppGlobalBundle:Zones p';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	//Récupère les info de la zone.
	public function getZoneById($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Zones p WHERE p.id =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
}