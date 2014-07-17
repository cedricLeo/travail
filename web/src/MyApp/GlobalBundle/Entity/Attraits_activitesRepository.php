<?php
namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

class Attraits_activitesRepository extends EntityRepository{

	
	/**
	 *	Affiche la liste des activités.
	 */
	public function getListAttraitActivites()
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.image FROM MyAppGlobalBundle:Attraits_activites p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Compte le nombre d'activité dans la table
	 */
	public function getCompteIdActivite()
	{
		$sql = 'SELECT COUNT(p.id) AS nbActivite FROM MyAppGlobalBundle:Attraits_activites p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'activité entrée dans le moteur de recherche
	 */
	public function getSearchActivite($searchword)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.image FROM MyAppGlobalBundle:Attraits_activites p WHERE p.nom_fr = :word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $searchword);
		return $query->getResult();
	}
	
	/**
	 *	Affiche les activit�s avec la pagination.
	 */
	public function getAdminActivites($page, $limit)
	{	
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.image FROM MyAppGlobalBundle:Attraits_activites p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 *  Recherche toutes les activités qui commencent par cette lettre.
	 */
	public function getActiviteByFirstLetter($letter)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.image FROM MyAppGlobalBundle:Attraits_activites p WHERE p.nom_fr LIKE :letter';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('letter', $letter.'%' );
		return $query->getResult();
	}

	/**
	 * Recherche l'id activité par son nom
	 */
	public function getRechercheIdActiviteParSonNom($searchword)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Attraits_activites p WHERE p.nom_fr = :word OR p.nom_en = :word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $searchword);
		return $query->getResult();
	}
        
        /**
	 * Liste toutes les activités rangées par nom_fr alphabétique
	 */
	public function getListActivites()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Attraits_activites p WHERE p.id <> 135 ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Recherche les activités pour ces attraits qui sont de la même région et qui sont approuvés
	 */
	/*public function getRechercheActivitePourAttraitMemeRegion($tab, $categorie)
	{
		$sql = 'SELECT p, q FROM MyAppGlobalBundle:Attraits p JOIN p.attrait_activite_id q WHERE p.id IN (:tab) AND p.categorie_attrait = :categorie AND p.approuve = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		$query->setParameter('categorie', $categorie);
		if(sizeof($tab) == 1)
		{
			$query->setMaxResults($limit = 4);
		}
		elseif(sizeof($tab) == 2)
		{
			$query->setMaxResults($limit = 8);
		}
		elseif(sizeof($tab) == 3)
		{
			$query->setMaxResults($limit = 12);
		}
		else
		{
			$query->setMaxResults($limit = 16);
		}
		return $query->getResult();
	}*/


}