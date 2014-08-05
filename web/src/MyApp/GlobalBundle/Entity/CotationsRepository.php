<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 *
 */
class CotationsRepository extends EntityRepository{
	
	/**
	 * Récupère la liste des cotations rangée par ordre alphabétique
	 */
	public function getListCotation()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Cotations p WHERE p.id <> 28 ORDER BY p.valeur ';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

}