<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class Types_occupationsRepository extends EntityRepository{


	/**
	 * Méthode pour lister les types d'occupations
	 */
	public function getListTypeOccupation()
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Types_occupations p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

}