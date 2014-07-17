<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 * 
 * Classe qui contient les méthodes pour les soins de santé
 *
 */
class Soins_SanteRepository extends EntityRepository{
	
	
	/**
	 * Méthode qui compte tous les soins 
	 */
	public function getComptSoin()
	{
		$sql = 'SELECT COUNT(p.id) AS nbSoin FROM MyAppMobileBundle:Soins_sante p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Méthode pour l'auto-completion des soins de santé
	 */
	public function getAutotcompletion()
	{
		$sql = 'SELECT p.id, p.nom_fr FROM MyAppMobileBundle:Soins_sante p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Recherche le soin de santé entré dans le moteur de recherche
	 */
	public function getSearchSoin($searchword)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Soins_sante p WHERE p.nom_fr = :word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $searchword);
		return $query->getResult();
	}
	
	/**
	 *	Affiche les soins avec la pagination.
	 */
	public function getAdminSoin($page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Soins_sante p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 *  Recherche toutes les soins qui commencent par cette lettre (Coté admin).
	 */
	public function getSoinByFirstLetter($letter)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Soins_sante p WHERE p.nom_fr LIKE :letter';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('letter', $letter.'%' );
		return $query->getResult();
	}
	
	/**
	 * Sélectionne tous les types de soins disponibles
	 */
	public function getAfficheTousTypeSoin()
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Soins_sante p WHERE p.types_soins_sante_id is not null GROUP BY p.types_soins_sante_id';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne tous les attraits qui ont des soins de santé
	 */
	public function getAfficheAttraitTousTypeSoin()
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q GROUP BY q.id';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Affiche les catégories de type de soins de ces clients
	 */
	public function getAfficheTypeSoinTabClient($client)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE p.id IN (:client) AND p.approuve = 1 AND p.actif = 1 GROUP BY q.id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('client', $client);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne les prix et les durées des soins
	 */
	public function getAffichePrixetDureeSoin()
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Soins_sante p ';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

	/**
	 * Tri les soins de santé par type de soins
	 */
	public function getListTypeSoinPourMinisite($tabIdSoin)
	{
		$tab = array();
		for($i = 0 ; $i < count($tabIdSoin); $i++)
		{
			$sql = 'SELECT p  FROM MyAppMobileBundle:Soins_sante p WHERE p.id IN (:tabidsoin) ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter("tabidsoin", $tabIdSoin[$i]);
			array_push($tab, $query->getResult());
		}
		return $tab;
	}
	
	
	
	
}