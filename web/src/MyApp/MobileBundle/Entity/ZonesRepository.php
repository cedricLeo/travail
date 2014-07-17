<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author leonardc
 * 
 * Classe qui contient les méthodes pour l'entité « ZONES »
 *
 */
class ZonesRepository extends EntityRepository{
	
	
	/**
	 * Affiche les zones géographiques avec la pagination
	 */
	public function getZones($page, $limit)
	{
		$paginator = ($page - 1)* $limit;
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Zones p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Recherche par lettre alphabétique
	 * Récupère toutes les zones commençants par la première lettre que l'on a sélectionnée
	 */
	public function getZoneByFirstLetter($letter)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Zones p WHERE p.nom_fr LIKE :letter';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('letter', $letter.'%');
		return $query->getResult();
	}
	
	/**
	 * Compte le nombre de zones dans la table.
	 */
	public function getCompteZones()
	{
		$sql = 'SELECT p.id, COUNT(p.id) AS nbzones FROM MyAppMobileBundle:Zones p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Récupère les infos de la zone.
	 */
	public function getZoneById($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Zones p WHERE p.id =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Récupère 4 zones pour nos suggestions
	 */
	public function get4Zones($tab)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Zones p WHERE p.id IN (:zone1, :zone2, :zone3, :zone4)';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('zone1', $tab[0]);
		$query->setParameter('zone2', $tab[1]);
		$query->setParameter('zone3', $tab[2]);
		$query->setParameter('zone4', $tab[3]);
		return $query->getResult();
	}
	
	/**
	 * Création de la liste des zones pour la région sélectionnée rangé par ordre alphabétique.
	 */
	public function getZonesbyRegion($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Zones p WHERE p.region_id =:id ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Moteur de recherche qui remplace la recherche dynamique CTRL-F qui ne peut plus fonctionner correctement depuis que la pagination est implenter.
	 */
	public function getWordSearchZone($word)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Zones p WHERE p.nom_fr=:word OR p.nom_en=:word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $word);
		return $query->getResult();
	}
	
	/**
	 * Méthode pour l'auto-complétion dans le moteur de recherche
	 * ATTENTION N'EST PAS SUPPORTER PAR TOUS LES NAVIGATEURS.
	 */
	public function getAutoCompletionZone()
	{
		$sql = 'SELECT p.id, p.nom_fr FROM MyAppMobileBundle:Zones p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Récupère l'id de la zone par le nom_fr
	 */
	public function getZoneByNomFr($nomfr)
	{	
		$sql = 'SELECT p.id, p.nom_fr FROM MyAppMobileBundle:Zones p WHERE p.nom_fr =:nomFR';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('nomFR', $nomfr);
		return $query->getResult();
	}

	
}