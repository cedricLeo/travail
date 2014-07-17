<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;

class Modes_paiementRepository extends EntityRepository{
	
	/**
	 * On liste tous les modes de paiement pour les faire afficher sur la page d'accueil de la gestion des paiements.
	 */
	public function getListmodePaiement(){
		
		$sql = 'SELECT p FROM MyAppMobileBundle:Modes_paiements p ORDER BY p.nom_fr ';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

}