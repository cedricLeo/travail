<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 * 
 * Fonctions pour les forfaits coté portail
 * 
 */
class Forfaits_clientsRepository extends EntityRepository
{
	
	/**
	 * Affiche les clients qui ont des forfaits valides dans le temps et qui sont valides pour la publication 
	 * (doctrine 2 ne reconnait pas la fonction NOW())
	 */
	public function getAfficheListeForfaitValideGroupBy()
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.hebergement_id is not null AND p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin GROUP BY p.forfait_client_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
       
        
        /**
         * Retourne les forfaits groupés
         */
        public function getAfficheListeForfaitValide()
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.hebergement_id is not null AND p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
        
        /**
         * Retourne les forfaits groupés par province version mobile
         */
        public function getAfficheListeForfaitValideGrouperProvinceMobile()
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.hebergement_id is not null AND p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin GROUP BY q.province_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
        
        /**
         * Retourne les forfaits de ce groupe d'hébergements
         */
        public function getAfficheListeForfaitValideGroupeHebergement($tab)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.hebergement_id IN (:tab) AND p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
                $query->setParameter("tab", $tab);
		return $query->getResult();
	}
	
	/**
	 * Affiche les forfaits valides de la même région
	 */
	public function getAfficheListeForfaitValideRegion($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE q.region_id = :id AND p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin GROUP BY p.forfait_client_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Affiche les forfaits valides de la même ville
	 */
	public function getAfficheListeForfaitValideVille($id)
	{
		$today = new \DateTime("now");		
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE q.ville_id = :id AND p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin GROUP BY p.forfait_client_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('id', $id);
		return $query->getResult();
	}

	/**
	 * Affiche les régions qui ont des forfaits valides
	 */
	public function getAfficheListeForfaitRegion($idProvince)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p INDEX BY p.id JOIN p.hebergement_id q WHERE :now BETWEEN p.date_creation AND p.date_de_fin  AND q.province_id = :idProvince AND p.actif = 1 AND q.aprouver = 1 AND q.actif = 1 GROUP BY q.region_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('idProvince', $idProvince);
		return $query->getResult();
	}
        
        /**
	 * Affiche les régions qui ont des forfaits valides
	 */
	public function getAfficheListeForfaitRegion2($idProvince)
	{
                $tab = [];
		$today = new \DateTime("now");
                for($i = 0; $i < count($idProvince); $i++){
                    $sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p INDEX BY p.id JOIN p.hebergement_id q WHERE :now BETWEEN p.date_creation AND p.date_de_fin  AND q.province_id = :idProvince AND p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 GROUP BY q.region_id ';
                    $query = $this->getEntityManager()->createQuery($sql);
                    $query->setParameter('now', $today);
                    $query->setParameter('idProvince', $idProvince[$i]);
                    array_push($tab, $query->getResult());
                }
		return $tab;
	}
	
	/**
	 * Affiche les villes de la région qui ont des forfaits valides et groupé par ville
	 */
	public function getTousLesForfaitsDesVillesDeLaRegion($idregion)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p INDEX BY p.id JOIN p.hebergement_id q WHERE :now BETWEEN p.date_creation AND p.date_de_fin AND q.region_id = :idregion AND p.actif = 1 AND q.aprouver = 1 GROUP BY q.ville_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('idregion', $idregion);
		return $query->getResult();
	}
	
	/**
	 * Recherche tous les forfaits du client
	 */
	public function getListeTousLesForfaits($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.hebergement_id = :id AND q.aprouver = 1 AND q.actif  = 1 AND p.actif = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin ORDER BY p.id DESC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche le forfait aleatoire
	 */
	public function getAfficheForfaitAleatoire($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p WHERE p.id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits affaires du client
	 */
	public function getListeForfaitsAffaires($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.forfait_client_id = 4 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.hebergement_id = :id AND p.actif = 1 ORDER BY p.id DESC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits soins santé du client et qui sont valides si le client a un hébergement
	 */
	public function getListeForfaitsSoinsSanteAvecHebergement($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p WHERE q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.hebergement_id = :id AND p.actif = 1 AND p.forfait_client_id = 9  ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits soins santé du client et qui sont valides pour les clients qui n'ont pas d'hébergement
	 */
	public function getListeForfaitsSoinsSanteSansHebergement($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p WHERE q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.hebergement_id = :id AND p.actif = 1 AND p.forfait_client_id = 9  ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Affiche les forfaits affaires valides de la ville
	 */
	public function getAfficheForfaitAffaireVille($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p INDEX BY p.id JOIN p.hebergement_id q '.
			   'WHERE q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.ville_id = :id AND p.actif = 1 AND p.forfait_client_id = 4 ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Affiche les forfaits affaires valides de la région avec la pagination
	 */
	public function getAfficheForfaitAffaireRegion($id, $page, $limit)
	{
		$today = new \DateTime("now");
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p INDEX BY p.id JOIN p.hebergement_id q '.
			   'WHERE q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.region_id = :id AND p.actif = 1 AND p.forfait_client_id = 4';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('id', $id);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Retourne la liste des forfaits affaires valides de la région
	 */
	public function getCompteForfaitAffaireRegion($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
                        'WHERE q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.region_id = :id AND p.actif = 1 AND p.forfait_client_id = 4 GROUP BY p.hebergement_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits affaires de la province
	 */
	public function getListeForfaitsAffairesProvince($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
			'WHERE q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.province_id = :id AND p.actif = 1 AND p.forfait_client_id = 4 GROUP BY p.hebergement_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits affaires pour plusieurs provinces
	 */
	public function getListeForfaitsAffairesMultiProvince()
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.actif = 1 AND p.forfait_client_id = 4 GROUP BY p.hebergement_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits affaires du client et retourne celui qui a le prix le plus bas
	 */
	public function getListeForfaitsAffairesPlusBasPrix($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p '.
			   'WHERE q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.hebergement_id = :id AND p.actif = 1 AND p.forfait_client_id = 4 ORDER BY p.tarif ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		$query->setMaxResults(1);
		return $query->getResult();
	}
	
	/**
	 * Retourne les forfaits affaires du client
	 */
	public function getListeForfaitsAffairesDuClient($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p '.
				'WHERE q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.hebergement_id = :id AND p.actif = 1 AND p.forfait_client_id = 4 ORDER BY p.tarif ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Retourne les forfaits du client
	 */
	public function getListeForfaitsHebergementDuClient($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p '.
			   'WHERE p.hebergement_id = :id ORDER BY p.date_debut ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Compte les forfaits de cette catégorie et qui sont dans cette ville
	 */
	public function getCompteFofaitCategorieDeLaVille($ville, $categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT COUNT(p.id) AS numb FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
			   'WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND p.forfait_client_id = :cat AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.ville_id = :ville';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('ville', $ville);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits de cette catégorie et qui sont dans cette ville
	 */
	public function getRechercheFofaitCategorieDeLaVille($ville, $categorie, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND p.forfait_client_id = :cat AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.ville_id = :ville ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('ville', $ville);
		$query->setParameter('now', $today);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits de cette catégorie et qui sont dans cette région (hébergements)
	 */
	public function getRechercheFofaitCategorieDeLaRegion($region, $categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.region_id = :region ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('region', $region);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits de cette catégorie et qui sont dans cette région (hébergements) avec la pagination
	 */
	public function getRechercheFofaitCategorieDeLaRegionAvecPagination($region, $categorie, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.region_id = :region';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('region', $region);
		$query->setParameter('now', $today);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Compte les forfaits de cette catégorie et qui sont dans cette région (hébergements)
	 */
	public function getCompteFofaitCategorieDeLaRegion($region, $categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p, COUNT(p.id) AS nbTypeForfait FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.region_id = :region ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('region', $region);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Retourne les forfaits de cette catégorie et qui sont dans cette région (hébergements) grouper par ville
	 */
	public function getCompteFofaitCategorieDeLaRegionGrouperParVille($region, $categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.region_id = :region GROUP BY q.ville_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('region', $region);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits de cette catégorie et qui sont dans la région pour les attraits
	 */
	public function getRechercheFofaitCategorieDeLaRegionAttrait($region, $categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.attrait_id q '.
				'WHERE  p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now p.date_creation AND p.date_de_fin AND q.region_id = :region ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('region', $region);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits de cette catégorie et qui sont dans cette province
	 */
	public function getRechercheFofaitCategorieDeLaProvince($province, $categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.province_id = :province GROUP BY q.region_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('province', $province);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits de cette catégorie et qui sont dans cette région trier par id province
	 */
	public function getRechercheFofaitCategorieDeLaRegionGroupByRegion($province, $categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.province_id = :province GROUP BY q.region_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('province', $province);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits de cette catégorie 
	 */
	public function getRechercheFofaitCategorieIndex($categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
			   'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
        
        /**
	 * Recherche les forfaits de cette catégorie grouper par région 
	 */
	public function getRechercheFofaitCategorieIndexGroupBy($categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
			   'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin GROUP BY q.region_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Affiche les forfaits disponibles et valides grouper par région 
	 */
	public function getAfficheListeForfaitValideGroupByRegion()
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN date_creation AND p.date_de_fin GROUP BY q.region_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Recherche les forfaits gastronomiques du client qui sont valides
	 */
	public function getForfaitsGastronomiques($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.hebergement_id = :id AND p.actif = 1 AND p.forfait_client_id IN (7, 8)  ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Fonction pour rechercher les tarifs de dernières minutes qui sont valides par province grouper par région
	 */
	public function getRechercheProvinceDerniereMinute( $id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.derniere_minute = 1 AND q.province_id = :id GROUP BY q.region_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
        
	/**
	 * Fonction pour la pagination des promotions de la province avec les tarifs de dernières minutes qui sont valides rangé par ordre décroissant
	 */
	public function getPaginationProvinceDerniereMinute($page, $limit, $id)
	{
		$today = new \DateTime("now");
		$paginator = ($page - 1)* $limit;
		if(is_array($id) == 0){
			$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.derniere_minute = 1 AND q.province_id = :id ORDER BY p.id DESC ';
		}else{    
			$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.derniere_minute = 1 AND q.province_id IN (:id) ORDER BY p.id DESC ';
		}
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
        
        /**
         * Compte le total des promotions en cours
         */
        public function getComptabiliseNombrePromotion($id)
        {
                $today = new \DateTime("now");		
                $sql = 'SELECT COUNT(p.id) AS nbPromotion FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.derniere_minute = 1 AND q.province_id IN (:id) ORDER BY p.id DESC ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);	
		return $query->getSingleResult();
        }
        
        /**
         * Flux Rss Destination
         */
        public function getFluxRssDestination($id)
	{
		$today = new \DateTime("now");		
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.derniere_minute = 1 AND q.province_id IN (:id) ORDER BY p.id DESC ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Compte les promotions pour cette région
	 */
	public function getCompteProvinceDerniereMinute($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT COUNT(p.id) AS numb FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.derniere_minute = 1 AND q.province_id = :id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		return $query->getResult();
	}

	/**
	 * Fonction pour rechercher les tarifs de dernières minutes qui sont valides par région
	 */
	public function getRechercheRegionDerniereMinute($page, $limit, $id)
	{
		$today = new \DateTime("now");
		$paginator = ($page - 1)* $limit;
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.derniere_minute = 1 AND q.region_id = :id ORDER BY p.id DESC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Fonction pour rechercher les tarifs de dernières minutes qui sont valides par ville
	 */
	public function getRechercheVilleDerniereMinute($page, $limit, $id)
	{
		$today = new \DateTime("now");
		$paginator = ($page - 1)* $limit;
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.derniere_minute = 1 AND q.ville_id = :id ORDER BY p.id DESC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Compte les promotions pour cette région
	 */
	public function getCompteRegionDerniereMinute($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT COUNT(p.id) AS numb FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE q.actif = 1 AND q.aprouver = 1 AND p.actif = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.derniere_minute = 1 AND q.region_id = :id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Fonction pour rechercher les tarifs de dernières minutes de la région sélectionnée
	 */
	public function getRechercheRegionForfaitsDerniereMinuteAvecCategorie($id, $region)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.derniere_minute = 1 AND q.region_id = :region AND p.forfait_client_id = :id ORDER BY p.id DESC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('region', $region);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
	/**
	 * Fonction pour rechercher les tarifs de dernières minutes de la ville sélectionnée
	 */
	public function getRechercheVilleForfaitsDerniereMinuteAvecCategorie($id, $ville)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.derniere_minute = 1 AND q.ville_id = :ville AND p.forfait_client_id = :id ORDER BY p.id DESC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('ville', $ville);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
	
        /**
	 * Retourne le dernier forfait du client
	 */
	public function getRechercheDernierForfaitsHebergementDuClient($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p WHERE p.hebergement_id = :id ORDER BY p.id DESC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
        
        /**
	 * Affiche les catégories de forfaits version mobile
	 */
	public function getAfficheListeForfaitValideCategorieMobile()
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q JOIN p.forfait_client_id w WHERE p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin GROUP BY p.forfait_client_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
        
        /**
	 * Affiche les forfaits valides de la même région version mobile
	 */
	public function getAfficheListeForfaitRegionMobile($id)
	{                      
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE q.province_id IN (:id) AND p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin GROUP BY q.region_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Affiche les forfaits valides de la même ville version mobile
	 */
	public function getAfficheListeForfaitVilleMobile($id)
	{
		$today = new \DateTime("now");		
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE q.region_id IN (:id) AND p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin GROUP BY q.ville_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('id', $id);
		return $query->getResult();
	}              

	/**
	 * Affiche les provinces qui ont des forfaits valides version mobile
	 */
	public function getAfficheListeForfaitProvinceMobile($idProvince)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p INDEX BY p.id JOIN p.hebergement_id q WHERE :now BETWEEN p.date_creation AND p.date_de_fin  AND q.province_id IN (:idProvince) AND p.actif = 1 AND q.aprouver = 1 AND q.actif = 1 GROUP BY q.province_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('idProvince', $idProvince);
		return $query->getResult();
	}
        
        /**
	 * Recherche les forfaits de cette catégorie avec le filtre grouper par province version mobile
	 */
	public function getRechercheFofaitCategorieGroupByProvinceMobile($categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
			   'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin GROUP BY q.province_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
        
        /**
	 * Recherche les forfaits de cette catégorie et qui sont dans cette province grouper par région version mobile
	 */
	public function getRechercheFofaitCategorieProvinceGroupByRegionMobile($province, $categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.province_id IN (:province) GROUP BY q.region_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('province', $province);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
        
        /**
	 * Retourne les forfaits de cette catégorie et qui sont dans cette région grouper par ville version mobile
	 */
	public function getCompteFofaitCategorieRegionGroupByVilleMobile($region, $categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.region_id IN (:region) GROUP BY q.ville_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('region', $region);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
        
        /**
	 * Recherche les forfaits de cette province avec la pagination version mobile
	 */
	public function getRechercheFofaitProvinceAvecPaginationMobile($province, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.province_id = :province';
		$query = $this->getEntityManager()->createQuery($sql);	
		$query->setParameter('province', $province);
		$query->setParameter('now', $today);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
        
        /**
	 * Recherche les forfaits de cette région avec la pagination version mobile
	 */
	public function getRechercheFofaitRegionAvecPaginationMobile($region, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.region_id = :region';
		$query = $this->getEntityManager()->createQuery($sql);	
		$query->setParameter('region', $region);
		$query->setParameter('now', $today);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
        
        /**
	 * Recherche les forfaits de cette ville avec la pagination version mobile
	 */
	public function getRechercheFofaitVilleAvecPaginationMobile($ville, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.ville_id = :ville';
		$query = $this->getEntityManager()->createQuery($sql);	
		$query->setParameter('ville', $ville);
		$query->setParameter('now', $today);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
        
        /**
	 * Fonction pour rechercher les forfaits valides de cette catégorie du pays avec pagination version mobile
	 */
	public function getRechercheForfaitCategoriePaginationMobile($page, $limit, $id)
	{
		$today = new \DateTime("now");
		$paginator = ($page - 1)* $limit;
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE q.actif = 1 AND q.aprouver = 1 AND p.actif = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND p.forfait_client_id = :id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('now', $today);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);            
		return $query->getResult();
	}
        
        /**
	 * Fonction pour rechercher les forfaits valides sans catégorie du pays avec pagination version mobile
	 */
	public function getRechercheForfaitSansCategoriePaginationMobile($page, $limit )
	{
		$today = new \DateTime("now");
		$paginator = ($page - 1)* $limit;
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE q.actif = 1 AND q.aprouver = 1 AND p.actif = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);            
		return $query->getResult();
	}
        
        /**
	 * Affiche les provinces qui ont des forfaits valides non groupé version mobile
	 */
	public function getAfficheListeForfaitProvinceMobileNonGrouper($idProvince)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p INDEX BY p.id JOIN p.hebergement_id q WHERE :now BETWEEN p.date_creation AND p.date_de_fin  AND q.province_id IN (:idProvince) AND p.actif = 1 AND q.aprouver = 1 AND q.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('idProvince', $idProvince);
		return $query->getResult();
	}
        
        /**
	 * Affiche les forfaits valides de la même région non groupé version mobile
	 */
	public function getAfficheListeForfaitValideRegionNonGrouper($id)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE q.region_id = :id AND p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Affiche les forfaits valides de la même ville non groupé version mobile
	 */
	public function getAfficheListeForfaitValideVilleNonGrouper($id)
	{
		$today = new \DateTime("now");		
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q WHERE q.ville_id = :id AND p.actif = 1 AND q.aprouver = 1 AND q.actif  = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('now', $today);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
        
        /**
	 * Recherche les forfaits de cette catégorie et qui sont dans cette province non groupés version mobile
	 */
	public function getRechercheFofaitCategorieDeLaProvinceNonGrouper($province, $categorie)
	{
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.province_id = :province';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('province', $province);
		$query->setParameter('now', $today);
		return $query->getResult();
	}
        
        /**
	 * Recherche les forfaits de cette catégorie et qui sont dans cette province (hébergements) avec la pagination version mobile
	 */
	public function getRechercheForfaitCategorieDeLaProvinceAvecPaginationMobile($province, $categorie, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$today = new \DateTime("now");
		$sql = 'SELECT p FROM MyAppGlobalBundle:Forfaits_clients p JOIN p.hebergement_id q '.
				'WHERE p.actif = 1 AND p.forfait_client_id = :cat AND q.actif = 1 AND q.aprouver = 1 AND :now BETWEEN p.date_creation AND p.date_de_fin AND q.province_id = :province';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $categorie);
		$query->setParameter('province', $province);
		$query->setParameter('now', $today);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
              
}