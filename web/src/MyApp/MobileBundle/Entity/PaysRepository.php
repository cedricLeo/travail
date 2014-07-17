<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;

class PaysRepository extends EntityRepository{
	
	/**
	 * Fonction pour lister les pays dans l'admin.
	 */
	public function getListStates()
	{
		$dql = 'SELECT p.id, p.nom_fr, p.nom_en, p.flag FROM MyAppMobileBundle:pays p';
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
	}
	
	/**
	 * Récupère le pays qui doit être modifier.
	 */
	public function getUpdateState($id)
	{
		$dql = 'SELECT p FROM MyAppMobileBundle:Pays p WHERE p.id =:id';
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Récupère les pays qui sont dans le reservit
	 */
	public function getRetourneListePaysReservit()
	{
		$dql = 'SELECT p FROM MyAppMobileBundle:Pays p WHERE p.reservit_id is not null AND p.affiche = 1';
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
	}

}