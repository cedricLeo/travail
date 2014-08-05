<?php
namespace MyApp\MobileBundle\Entity;

use Doctrine\ORM\EntityRepository;

class Attraits_serviceRepository extends EntityRepository{


	/**
	 *	Affiche la liste des services.
	 */
	public function getListAttraitService()
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.image FROM MyAppMobileBundle:Attraits_services p ORDER BY p.nom_fr';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

	/**
	 * Compte le nombre de service dans la table
	 */
	public function getCompteIdService()
	{
		$sql = 'SELECT COUNT(p.id) AS nbService FROM MyAppMobileBundle:Attraits_services p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

	/**
	 * Recherche le service entré dans le moteur de recherche
	 */
	public function getSearchService($searchword)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.image FROM MyAppMobileBundle:Attraits_services p WHERE p.nom_fr = :word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $searchword);
		return $query->getResult();
	}

	/**
	 *	Affiche les services avec la pagination.
	 */
	public function getAdminService($page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.image FROM MyAppMobileBundle:Attraits_services p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}

	/**
	 *  Recherche toutes les services qui commencent par cette lettre.
	 */
	public function getServiceByFirstLetter($letter)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.image FROM MyAppMobileBundle:Attraits_services p WHERE p.nom_fr LIKE :letter';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('letter', $letter.'%' );
		return $query->getResult();
	}
	
	
	



}