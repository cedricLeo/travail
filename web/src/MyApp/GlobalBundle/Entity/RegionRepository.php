<?php
namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RegionRepository extends EntityRepository
{

	/**
	 * Affiche toutes les régions de la province ordonnées par nom_fr ASC
	 */
	public function getRegions($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.province_etat_id = :id ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
        
        /**
	 * Affiche toutes les régions de la province ordonnées par nom_fr ASCpour la version mobile
	 */
	public function getRegionsMobile($id, $lang)
	{
            if($lang == "fr"){
		$sql = 'SELECT p.id, p.nom_fr, p.reservit_id, p.repertoire_fr FROM MyAppMobileBundle:Regions p WHERE p.province_etat_id = :id ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
            }else{
                $sql = 'SELECT p.id, p_nom_en, p.reservit_id, p.repertoire_en FROM MyAppMobileBundle:Regions p WHERE p.province_etat_id = :id ORDER BY p.nom_en ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
            }
	}   
	
	/**
	 * Affiche la pagination pour les régions.
	 */
	public function getAdminRegions($page, $limit)
	{
		$paginator = ($page - 1)* $limit;
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppGlobalBundle:Regions p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Récupère les informations sur la région.
	 */
	public function getAdminRegionById($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.id =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Recherche dans la table toutes les régions qui commencent par cette lettre
	 * RECHERCHE ALPHABÉTIQUE EN BAS DE LA LISTE DES RÉGIONS
	 */
	public function getRegionByFirstLetter($letter)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppGlobalBundle:Regions p WHERE p.nom_fr LIKE :letter';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('letter', $letter.'%');
		return $query->getResult();
	}
	
	/**
	 * Recherche dans la table la région le nom a était transmit dans l'url
	 * MOTEUR DE RECHERCHE EN HAUT À DROITE DE LA LISTE DES RÉGIONS
	 */
	public function getWordSearchRegion($word)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppGlobalBundle:Regions p WHERE p.nom_fr =:word OR p.nom_en =:word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $word);
		return $query->getResult();
	}
	
	/**
	 * Compte le nombre de région qu'il y a dans la table
	 */
	public function getCompteRegions()
	{
		$sql = 'SELECT COUNT(p.id) AS nbregions FROM MyAppGlobalBundle:Regions p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Méthode pour l'auto-complétion dans le moteur de recherche
	 * ATTENTION N'EST PAS SUPPORTER PAR TOUS LES NAVIGATEURS.
	 */
	public function getAutoCompletionRegion()
	{
		$sql = 'SELECT p.id, p.nom_fr FROM MyAppGlobalBundle:Regions p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Affiche une région pour les suggestions.
	 */
	public function getRegionAleatoire($r)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.id =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $r);
		return $query->getResult();
	}        
	
	/**
	 * Recherche la région par son nom pour retourner aussi sa province
	 */
	public function getSearchRegion($word)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.nom_fr =:word OR p.nom_en =:word GROUP BY p.province_etat_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $word);
		return $query->getResult();
	}
	
	/**
	 * Affiche 4 régions pour nos suggestions
	 */
	public function get4RegionsSuggestion($tab)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.id IN (:tab)';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'id de la région par son nom
	 */
	public function getNameSearchRegion($word)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.nom_fr =:word OR p.nom_en =:word OR p.repertoire_fr =:word OR p.repertoire_en =:word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $word);
		return $query->getResult();
	}
	
	/**
	 * Affiche toutes les régions de la province ordonnées par nom_fr ASC
	 */
	public function getRegionsDeLaProvince($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.province_etat_id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
        
        /**
	 * Affiche toutes les régions de la province ordonnées par nom_fr ASC version mobile
	 */
	public function getRegionsDeLaProvinceMobile()
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.reservit_id, p.repertoire_fr, p.repertoire_en FROM MyAppMobileBundle:Regions p WHERE p.affiche = 1 AND p.reservit_id <> 0';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}               

	/**
	 * Retourne les régions du tableau passé en paramètres
	 */
	public function getTabIdRegion($id)
	{         
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.id IN (:id)';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Méthode qui retourne tous les noms des régions dans une seule langue
	 */
	public function getListeNomUneSeuleLangue($lang)
	{
		if($lang == "fr"){
			$sql = 'SELECT p.nom_fr FROM MyAppGlobalBundle:Regions p';
			$query = $this->getEntityManager()->createQuery($sql);
		}else{
			$sql = 'SELECT p.nom_en FROM MyAppGlobalBundle:Regions p';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		return $query->getResult();
	}
	
	/**
	 * Retourne la liste des régions qui sont dans reservit
	 */
	public function getRetourneListeRegionReservit($id)
	{
		$sql = 'SELECT p.id, p.reservit_id, p.nom_fr, p.nom_en FROM MyAppGlobalBundle:Regions p WHERE p.province_etat_id = :id AND p.reservit_id <> 0 AND p.affiche = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'id de la région par son id de reservit
	 */
	public function getSearchIdByReservitId($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.reservit_id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
        
        /**
         * Liste toutes les régions 
         */
        public function getListAllRegion()
        {
            $sql = "SELECT p.id, p.nom_fr, p.nom_en, p.reservit_id FROM MyAppGlobalBundle:Regions p WHERE p.reservit_id != 0 AND p.affiche = 1";
            $query = $this->getEntityManager()->createQuery($sql);
            return $query->getResult();
        }
	
	/**
	 * Recherche dans la table la région le nom a était transmit dans l'url
	 * MOTEUR DE RECHERCHE EN HAUT À DROITE DE LA LISTE DES RÉGIONS
	 */
	public function getSearchIdByName($word)
	{
		$sql = 'SELECT p.id FROM MyAppMobileBundle:Regions p WHERE p.repertoire_fr =:word OR p.repertoire_en =:word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $word);
		return $query->getSingleResult();
	}
}