<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 * 
 * Fonctions pour les chambres
 *
 */
class ChambresRepository extends EntityRepository
{
	
	/**
	 * Liste toutes les chambres ordonnée par id décroissant pour voir les dernières rentrées
	 */
	public function getListChambre()
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Chambres p ORDER BY p.id DESC';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Pagination pour les chambres
	 */
	public function getChambres($page, $limit)
	{
		$paginator = ($page - 1)* $limit;
		$sql = 'SELECT p FROM MyAppMobileBundle:Chambres p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}

	
	/**
	 * Méthode pour la recherche par lettre alphabétique
	 */
	public function getChambreByFirstLetter($letter)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Chambres p WHERE p.nom_fr LIKE :letter';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('letter', $letter.'%');
		return $query->getResult();
	}
	
	/**
	 * Compte le nombre de chambre qu'il y a dans la table.
	 */
	public function getCompteChambre()
	{
		$sql = 'SELECT COUNT(p.id) AS nbchambre FROM MyAppMobileBundle:Chambres p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Recherche la chambre par son nom avec le moteur de recherche
	 */
	public function getWordSearchChambre($word)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Chambres p WHERE p.nom_fr=:wordfr';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('wordfr', $word);
		return $query->getResult();
	}
	
	/**
	 * Recherche toutes les chambres de cet établissement
	 */
	public function getChambreDeLEtablissement($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Chambres p WHERE p.hebergement =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Recherche toutes les chambres de cet établissement qui sont actives
	 */
	public function getRetourneChambreCorpo($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Chambres p WHERE p.hebergement =:id AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Recherche toutes les chambres de cet établissement qui sont actives et récupère le prix de la chambre la moins chère
	 */
	public function getRetourneChambreLaMoinsChere($id)
	{
		$tab = array();
		foreach($id as $tw){
			$sql = 'SELECT p FROM MyAppMobileBundle:Chambres p WHERE p.hebergement = :id AND p.actif = 1 ORDER BY p.tarif_min_basse_saison ASC';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $tw);
			$query->setMaxResults(1);
			array_push($tab, $query->getResult());
		}
		return $tab;
	}
	
	/**
	 * Recherche toutes les chambres affaires de cet établissement qui sont actives et récupère le prix de la chambre la moins chère
	 */
	public function getRetourneChambreAffaireLaMoinsChere($id)
	{
		$tab = array();
		foreach($id as $tw){
			$sql = 'SELECT p FROM MyAppMobileBundle:Chambres p JOIN p.type_chambre_id q WHERE p.hebergement = :id AND p.actif = 1 AND q.id = 18 ORDER BY p.tarif_min_basse_saison ASC';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $tw);
			$query->setMaxResults(1);
			array_push($tab, $query->getResult());
		}
		return $tab;
	}
	
	
	public function getTest($id)
	{
		$tab = array();
		foreach($id as $tw){
			$sql = 'SELECT p FROM MyAppMobileBundle:Chambres p  WHERE p.hebergement = :id AND p.actif = 1 ORDER BY p.tarif_min_basse_saison ASC';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $tw);
			$query->setMaxResults(1);
			array_push($tab, $query->getResult());
		}
		return $tab;
	}
	
	/**
	 * Recherche toutes les chambres de cet établissement en relation avec leur type et qui sont actifs pour la parution sur le portail ordonné par ordre affichage ASC
	 */
	public function getChambreEtTypeDeEtablissement($id)
	{
		$sql = 'SELECT p, q, r FROM MyAppMobileBundle:Chambres p JOIN p.type_chambre_id q JOIN p.equipement_id r WHERE p.hebergement =:id AND p.actif = 1 ORDER BY p.ordre_affichage ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne les chambre du client qui n'ont pas de catégorie
	 */
	public function getChambreEtTypeDeEtablissementSansCategorie($id, $tab)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Chambres p JOIN p.equipement_id q WHERE p.hebergement =:id AND p.id NOT IN (:tab) AND p.actif = 1 ORDER BY p.ordre_affichage ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
	
	/**
	 * Retourne les chambres du clients avec comme arguments le tableau pour l'ordre d'affichage
	 */
	public function getChambreClientTrier($id, $tab)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Chambres p JOIN p.equipement_id q WHERE p.hebergement =:id AND p.ordre_affichage IN (:tab) AND p.actif = 1 GROUP BY q.id ORDER BY p.ordre_affichage';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
	
	/**
	 * Recherche toutes les chambres de l'établissement en relation avec leur type et rangé par ordre d'afffichage
	 */
	public function getListeChambreTypeEtablissement($id)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Chambres p JOIN p.type_chambre_id q WHERE p.hebergement =:id ORDER BY p.ordre_affichage ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Recherche toutes les chambres de l'établissement rangé par ordre d'afffichage
	 */
	public function getListeChambreEtablissement($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Chambres p WHERE p.hebergement =:id ORDER BY p.ordre_affichage ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Compte toutes les chambres de l'établissement rangé par ordre d'afffichage
	 */
	public function getCompteListeChambreTypeEtablissement($id)
	{
		$sql = 'SELECT p, q, COUNT(p.id) AS nbchambre FROM MyAppMobileBundle:Chambres p JOIN p.type_chambre_id q WHERE p.hebergement =:id ORDER BY p.ordre_affichage ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Recherche toutes les chambres affaires
	 */
	public function getListeChambreAffaire()
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Chambres p JOIN p.type_chambre_id q JOIN p.hebergement r WHERE q.id = 18 ';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Recherche toutes les chambres affaires pour la province choisi
	 */
	public function getListeChambreAffaireProvince($id)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Chambres p JOIN p.type_chambre_id q JOIN p.hebergement r WHERE q.id = 18 AND r.province_id =:id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Recherche toutes les chambres affaires qui sont de la région choisi
	 */
	public function getListeChambreAffaireRegion($id)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Chambres p JOIN p.type_chambre_id q JOIN p.hebergement r WHERE q.id = 18 AND r.region_id =:id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Pagination pour toutes les chambres affaires qui sont de la région choisi
	 */
	public function getListeChambreAffaireRegionAvecPagination($id, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Chambres p JOIN p.type_chambre_id q JOIN p.hebergement r WHERE q.id = 18 AND r.region_id =:id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Recherche toutes les chambres affaires qui sont de la ville choisi
	 */
	public function getListeChambreAffaireVille($id)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Chambres p JOIN p.type_chambre_id q JOIN p.hebergement r WHERE q.id = 18 AND r.ville_id =:id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Pagination pour toutes les chambres affaires qui sont de la ville choisi
	 */
	public function getListeChambreAffaireVilleAvecPagination($id, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Chambres p JOIN p.type_chambre_id q JOIN p.hebergement r WHERE q.id = 18 AND r.ville_id =:id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Recherche une liste de 5 chambres affaires pour ces régions
	 */
	public function getListeChambreAffaireRegionLimit5($id)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Chambres p JOIN p.type_chambre_id q JOIN p.hebergement r WHERE q.id = 18 AND r.region_id IN (:id) ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setMaxResults(5);
		return $query->getResult();
	}
	
	/**
	 * FONCTIONS POUR LES TYPES DE CHAMBRES
	 */
	
	/**
	 * Affiche la liste des types de chambres
	 */
	public function getTypesChambres()
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Types_chambres p ORDER BY p.nom_fr';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Affiche les chambres de l'établissement avec ses types de chambres
	 */
	public function getChambreEtTypesChambre($id)
	{
		$sql = 'SELECT p, q, r FROM MyAppMobileBundle:Hebergements p JOIN p.hebergement_type_chambre q JOIN q.chambre_id r WHERE p.id =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne la dernière chambre enregictrée pour cet hébergement
	 */
	public function getReturnLastRecoder($id)
	{
		$sql = 'SELECT p.id FROM MyAppMobileBundle:Chambres p WHERE p.hebergement = :id ORDER BY p.id DESC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setMaxResults(1);
		return $query->getResult();
	}
	
	/**
	 * FONCTIONS POUR LES PRIX
	 */
	
	/**
	 * Retourne les prix de ce client
	 */
	public function getRetourneListePrixClient($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Types_prix p WHERE p.index_chambre = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}