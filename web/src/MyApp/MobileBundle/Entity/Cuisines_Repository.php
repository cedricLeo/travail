<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 *
 */
class Cuisines_Repository extends EntityRepository
{
	
	/**
	 * Liste toutes les cuisines 
	 */
	public function getListCuisine()
	{
		$dql = 'SELECT p FROM MyAppMobileBundle:Cuisines p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
	}
	
	/**
	 * Récupère l'id de la spécialité par son nom
	 */
	public function getSearchIdByNameSpecialite($name)
	{
		$dql = 'SELECT p FROM MyAppMobileBundle:Cuisines p WHERE p.nom_fr = :nom OR p.nom_en = :nom';
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('nom', $name);
		return $query->getResult();
	}
	
	
	
}