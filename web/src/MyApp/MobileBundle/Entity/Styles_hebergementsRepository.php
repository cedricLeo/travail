<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;

class Styles_hebergementsRepository extends EntityRepository{

	/**
	 *	Affiche la liste des styles d'hébergements.
	 */
	public function getListStyleHebergement()
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Styles_hebergements p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	

}