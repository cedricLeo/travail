<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 * 
 * Classe qui contient toute la logique métier l'entité Ville
 */
class VillesRepository extends EntityRepository
{

	/**
	 * Affiche les villes pour la région sélectionnée en bas de page.
	 */
	public function getSelectTown($id)
	{
		$sql = 'SELECT q FROM MyAppMobileBundle:Villes q WHERE q.region_id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
        
        /**
	 * Affiche la liste des villes pour la région pour le mobile.
	 */
	public function getSelectListTown()
	{
		$sql = 'SELECT q.id, q.nom_fr, q.nom_en, q.reservit_id, q.repertoire_fr, q.repertoire_en FROM MyAppMobileBundle:Villes q WHERE q.affiche = 1 AND q.reservit_id <> 0';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
        
        /**
	 * Affiche la liste des villes pour la région pour le mobile triée par nom des villes Asc.
	 */
	public function getVilles($id, $lang)
	{
            if($lang == "fr"){
		$sql = 'SELECT q.id, q.nom_fr, q.reservit_id, q.repertoire_fr FROM MyAppMobileBundle:Villes q WHERE q.region_id = :id ORDER BY q.nom_fr';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
            }else{
                $sql = 'SELECT q.id, q.nom_en, q.reservit_id, q.repertoire_en FROM MyAppMobileBundle:Villes q WHERE q.region_id = :id ORDER BY q.nom_en';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
            }
	}
        
        /**
	 * Affiche la liste des villes pour la région pour le mobile triée par nom des villes Asc.
	 */
	public function getVillesSansChoix($id, $lang)
	{
            if($lang == "fr"){
		$sql = 'SELECT q.id, q.nom_fr, q.reservit_id FROM MyAppMobileBundle:Villes q WHERE q.region_id IN (:id) ORDER BY q.nom_fr';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
            }else{
                $sql = 'SELECT q.id, q.nom_en, q.reservit_id FROM MyAppMobileBundle:Villes q WHERE q.region_id IN (:id) ORDER BY q.nom_en';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
            }
	}

	/**
	 * Création de la liste des villes pour la page accueil de la gestion des villes
	 *
	 * @ORM\PostLoad()
	 */
	public function getListTown($page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Villes p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Moteur de recherche section ville
	 */
	public function getWordSearchTown($word)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.repertoire_fr, p.repertoire_en FROM MyAppMobileBundle:Villes p WHERE p.nom_fr = :word OR p.nom_en = :word OR p.repertoire_fr =:word OR p.repertoire_en =:word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $word);
		return $query->getResult();
	}
	
	/**
	 * Récupère toutes les villes commencant par la première lettre que l'on a sélectionné
	 * RECHERCHE PAR LETTRE ALPHABÉTIQUE EN BAS DE LA PAGE D'ACCUEIL DES VILLES.
	 */
	public function getTownByFirstLetter($letter)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Villes p WHERE p.nom_fr LIKE :letter ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('letter', $letter.'%');
		return $query->getResult();
	}
	
	/**
	 * Compte le nombre de ville dans la table.
	 */
	public function getCompteVilles()
	{
		$sql = 'SELECT COUNT(p.id) AS nbville FROM MyAppMobileBundle:Villes p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Méthode pour l'auto-complétion dans le moteur de recherche
	 * ATTENTION N'EST PAS SUPPORTÉ PAR TOUS LES NAVIGATEURS.
	 */
	public function getAutoCompletionVille()
	{
		$sql = 'SELECT p.id, p.nom_fr FROM MyAppMobileBundle:Villes p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Récupère les infos de la vidéo pour la ville
	 */
	public function getMovie($idvideo)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Videos p WHERE p.ville =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $idvideo);
		return $query->getResult();
	}
	
	/**
	 * Récupère l'id du dernier enregistrement dans la table ville et on l'incrémente de 1
	 */
	public function getLastIdVille()
	{
		$sql = 'SELECT MAX(p.id) AS lastid FROM MyAppMobileBundle:Villes p ';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Récupération des informations de la ville sélectionnée.
	 */
	public function getTown($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Villes p WHERE p.id =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Récupère l'id de la ville par le nom_fr
	 */
	public function getVilleByNomFr($nomfr)
	{
		$sql = 'SELECT p.id, p.nom_fr FROM MyAppMobileBundle:Villes p WHERE p.nom_fr =:nomFR';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('nomFR', $nomfr);
		return $query->getResult();
	}
	
	/**
	 * Récupére les 30 villes pour la section clients
	 */
	public function getIdClientVille($tablo)
	{	
		array_reverse($tablo);
		$sql = 'SELECT p FROM MyAppMobileBundle:Villes p WHERE p.id IN (:tab)';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tablo);
		return $query->getResult();
	}
	
	/**
	 * Récupère les villes de la zone sélectionnée
	 */
	public function getSelectTownByArea($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Villes p WHERE p.zone_id = :zone_id ORDER BY p.nom_fr';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('zone_id', $id);
		return $query->getResult();
	}
	
	/**
	 * Récupère les informations de la ville en question en la recherchent soit par son nom_fr ou nom_en
	 */
	public function getInfosVille($nom)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Villes p WHERE p.nom_fr =:nom OR p.nom_en =:nom OR p.repertoire_fr =:nom OR p.repertoire_en =:nom';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('nom', $nom);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'id de la ville par son nom
	 */
	public function getSearchTown($word)
	{
		$sql = 'SELECT p.id FROM MyAppMobileBundle:Villes p WHERE p.nom_fr = :word OR p.nom_en = :word OR p.repertoire_fr =:word OR p.repertoire_en =:word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $word);
		return $query->getSingleResult();
	}
	
	/**
	 * Retourne la liste des villes qui sont dans reservit
	 */
	public function getRetourneListeVilleReservit($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Villes p WHERE p.region_id = :id AND p.reservit_id is not null AND p.affiche = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}

}