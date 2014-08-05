<?php

namespace MyApp\MobileBundle\Entity;

use Doctrine\ORM\EntityRepository;

class Galerie_hebergementRepository extends EntityRepository
{
	
	/**
	 * Affiche les images de la galerie photo pour l'hébergement
	 */
	public function getDisplayThumbnail($tab)
	{
		$sql = 'SELECT p.id, p.image FROM MyAppMobileBundle:Galerie_hebergement p WHERE p.id IN (:tab)';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
	
	/**
	 * Recherche les images pour la galerie photo des chambres
	 */
	public function getDisplayThumbnailRoom($tab)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Galerie_photo_chambres p WHERE p.id IN (:tab)';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
	
	/**
	 * Recherche les images pour la galerie photo des forfaits
	 */
	public function getDisplayThumbnailPackage($tab)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Galerie_forfaits p WHERE p.id IN (:tab)';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
	
	/**
	 * Recherche les images pour la galerie photo des corporatifs
	 */
	public function getDisplayThumbnailCorporate($tab)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Corporatif_galerie_photo p WHERE p.id IN (:tab)';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
}