<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author Cédric Léonard
 * 
 * Fonctions pour les corporatifs  
 */
class Hebergements_salles_corporativesRepository extends EntityRepository{

	/**
	 * Retourne toutes les salles corporatives du client
	 */
	public function getListSalleCorporative($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p WHERE p.salle_corporative_hebergement = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
        
        /**
	 * Retourne toutes les salles corporatives du client
	 */
	public function getListSalleCorporativeActiveDuClient($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p WHERE p.salle_corporative_hebergement = :id AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne toutes les salles corporatives de ce groupe de client
	 */
	public function getListeSalleCorporativeDuGroupeClient($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p WHERE p.salle_corporative_hebergement IN (:id) GROUP BY p.salle_corporative_hebergement';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne les salles corporatives qui sont actives
	 */
	public function getAfficheSalleCorporative()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p WHERE p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Retourne les salles corporatives du client
	 */
	public function getAfficheSalleCorporativeAdmin($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p WHERE p.id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne juste les salles corporatives du client qui sont actives
	 */
	public function getSalleCorporativeMiniSite($id)
	{
		$sql = 'SELECT p, b, q FROM MyAppGlobalBundle:Hebergements_salles_corporatives p JOIN p.type_evenement b JOIN p.corporatif_service_id q JOIN p.salle_corporative_hebergement w WHERE p.salle_corporative_hebergement = :id AND p.actif = 1 AND w.corporatif = 1 GROUP BY b.nom_fr, q.nom_fr';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne les salles corporatives actives des provinces
	 */
	public function getAfficheSalleCorporativeActiveToutesProvinces()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p '.
				'INNER JOIN p.salle_corporative_hebergement q WHERE q.corporatif = 1 '.
				'AND q.actif = 1 AND p.actif = 1 GROUP BY q.province_id';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Retourne les salles corporatives actives dans la province
	 */
	public function getAfficheSalleCorporativeActive($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p '.
			   'INNER JOIN p.salle_corporative_hebergement q WHERE p.actif = 1 AND q.province_id = :id '.
			   'AND q.actif = 1 AND q.corporatif = 1 GROUP BY q.province_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne les salles corporatives actives des régions de la province et qui sont approuvées par l'admin
	 */
	public function getAfficheSalleCorporativeActiveRegion($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p '.
			   'INNER JOIN p.salle_corporative_hebergement q WHERE p.actif = 1 AND q.actif = 1 AND q.province_id = :id '.
			   'AND q.corporatif = 1 GROUP BY q.region_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne les salles corporatives actives des villes de la région
	 */
	public function getAfficheSalleCorporativeActiveVille($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p '.
				'INNER JOIN p.salle_corporative_hebergement q WHERE p.actif = 1 AND q.actif = 1 AND q.region_id = :id '.
				'AND q.corporatif = 1 GROUP BY q.ville_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne les salles corporatives actives group by salle_corporative_hebergement
	 */
	public function getAfficheListeSalleAppleOffre()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p WHERE p.actif = 1 GROUP BY p.salle_corporative_hebergement';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Retourne les salles corporatives actives des villes approuvées par l'admin pour la région choisi
	 */
	public function getAfficheListeSalleCorporativeActiveVille($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p '.
			   'INNER JOIN p.salle_corporative_hebergement q WHERE p.actif = 1 AND q.region_id = :id '.
			   'AND q.corporatif = 1 AND q.actif = 1 GROUP BY q.ville_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne les salles corporatives actives de la région approuvées par l'admin avec la pagination
	 */
	public function getAfficheListeSalleCorporativeActivePagination($id, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p '.
				'INNER JOIN p.salle_corporative_hebergement q WHERE p.actif = 1 AND q.region_id = :id '.
				'AND q.corporatif = 1 ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Retourne les salles corporatives actives de la ville approuvées par l'admin avec la pagination
	 */
	public function getAfficheListeSalleCorporativeActiveVillePagination($id, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p '.
				'INNER JOIN p.salle_corporative_hebergement q WHERE p.actif = 1 AND q.ville_id = :id '.
				'AND q.corporatif = 1 AND q.actif = 1 GROUP BY q.id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Compte le nombre de salles corporatives actives approuvées par l'admin pour la ville choisi
	 */
	public function getCompteListeSalleCorporativeActiveVille($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p '.
				'INNER JOIN p.salle_corporative_hebergement q WHERE p.actif = 1 AND q.ville_id = :id '.
				'AND q.corporatif = 1 AND q.actif = 1 GROUP BY q.id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne les chambres d'affaires qui sont actives grouper par région
	 */
	public function getAfficheChambreAffaire($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p JOIN p.salle_corporative_hebergement q WHERE  q.corporatif = 1 AND q.province_id = :id AND p.actif = 1 GROUP BY q.region_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne une liste de 5 de chambres d'affaires qui sont actives pour les suggestions
	 */
	public function getAfficheListeChambreAffaire($tab)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p JOIN p.salle_corporative_hebergement q WHERE q.id IN (:tab) AND q.corporatif = 1 AND p.actif = 1 GROUP BY p.salle_corporative_hebergement';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
	
	/**
	 * Retourne une liste de 5 clients qui ont une ou plusieurs salles corporatives et qui sont de la même region
	 */
	public function getAffiche5clientsSalleCorporativeMemeRegion($tab)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Hebergements_salles_corporatives p JOIN p.salle_corporative_hebergement q WHERE q.region_id = :tab AND q.corporatif = 1 AND p.actif = 1 GROUP BY p.salle_corporative_hebergement';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		//$query->setMaxResults(5);
		return $query->getResult();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}