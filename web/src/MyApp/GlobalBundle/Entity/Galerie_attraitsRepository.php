<?php

namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Galerie_attraitsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Galerie_attraitsRepository extends EntityRepository
{
	/**
	 * Affiche les images de la galerie photo pour l'attrait
	 */
	public function getDisplayThumbnailAttrait($tab)
	{
		$sql = 'SELECT p.id, p.image FROM MyAppGlobalBundle:Galerie_attraits p WHERE p.id IN (:tab)';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
}