<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 *
 */
class Hebergements_activitesRepository extends EntityRepository{

	/**
	 * Liste toutes les activités rangées par nom_fr alphabétique
	 */
	public function getListActivites()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_activites p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Liste des activités pour les hébergements
	 */
	public function getAfficheListeActiviteHebergement()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_activites p ';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
}