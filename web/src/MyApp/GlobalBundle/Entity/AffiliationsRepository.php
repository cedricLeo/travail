<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 *
 */
class AffiliationsRepository extends EntityRepository{

	/**
	 * Liste toutes les affiliations
	 */
	public function getListAffiliation()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Affiliations p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}





}