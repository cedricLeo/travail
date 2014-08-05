<?php
namespace MyApp\MobileBundle\Entity;
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
		$sql = 'SELECT p FROM MyAppMobileBundle:Cotations p WHERE p.id <> 28 ORDER BY p.valeur ';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

}