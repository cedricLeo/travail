<?php

namespace MyApp\MobileBundle\Entity;

use Doctrine\ORM\EntityRepository;

class HebergementsRepository extends EntityRepository
{
	
		/**
		 * Liste tous les hébergements pour l'auto-completion du moteur de recherche coté admin
		 *
		 * @ORM\PreLoad()
		 */
		public function getAutocompletionHebergement()
		{
			$sql = 'SELECT p.id, p.nom_fr FROM MyAppMobileBundle:Hebergements p';
			$query = $this->getEntityManager()->createQuery($sql);
			return $query->getResult();
		}
		
		/**
		 * Liste tous les hébergements pour l'auto-completion du moteur de recherche coté portail
		 *
		 * @ORM\PreLoad()
		 */
		public function getAutocompletionHebergementPortail()
		{
			$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Hebergements p WHERE p.aprouver = 1 AND p.actif = 1';
			$query = $this->getEntityManager()->createQuery($sql);
			return $query->getResult();
		}
                
                /**
                 * 
                 * Méthode pour compter le nombre d'id d'hébergement dans la province
                 */
                public function getCompteHebergement($id)
		{
			$sql = 'SELECT COUNT(p.id) AS numbId FROM MyAppMobileBundle:Hebergements p WHERE p.province_id =:id AND p.aprouver = 1 AND p.actif = 1';
			$query = $this->getEntityManager()->createQuery($sql);
                        $query->setParameter("id", $id);
			return $query->getSingleResult();
		}
                
                /**
                 * 
                 * Méthode pour compter le nombre d'id d'hébergement dans la région
                 */
                public function getCompteHebergementRegion($id)
		{
			$sql = 'SELECT COUNT(p.id) AS numbId FROM MyAppMobileBundle:Hebergements p WHERE p.region_id =:id AND p.aprouver = 1 AND p.actif = 1';
			$query = $this->getEntityManager()->createQuery($sql);
                        $query->setParameter("id", $id);
			return $query->getSingleResult();
		}
                
                /**
                 * 
                 * Méthode pour compter le nombre d'id d'hébergement dans la ville
                 */
                public function getCompteHebergementVille($id)
		{
			$sql = 'SELECT COUNT(p.id) AS numbId FROM MyAppMobileBundle:Hebergements p WHERE p.ville_id =:id AND p.aprouver = 1 AND p.actif = 1';
			$query = $this->getEntityManager()->createQuery($sql);
                        $query->setParameter("id", $id);
			return $query->getSingleResult();
		}
	
		/**
		 * Pagination pour les hébergements
		 *
		 * @ORM\PostLoad()
		 */
		public function getAdminHebergement($page, $limit)
		{
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.actif FROM MyAppMobileBundle:Hebergements p ORDER BY p.nom_fr ASC';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			return $query->getResult();
		}
		
		/**
		 * Pagination pour les hébergements dans le tableau de bord pour lister les clients
		 *
		 * @ORM\PostLoad()
		 */
		public function getAdminHebergementTBClient($page, $limit )
		{
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p ORDER BY p.nom_fr ASC';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			return $query->getResult();
		}
		
		/**
		 * Recherche tous les hébergements qui leur nom_fr commencent par cette lettre
		 */
		public function getHebergementByFirstLetter($letter)
		{
			$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.actif FROM MyAppMobileBundle:Hebergements p WHERE p.nom_fr LIKE :letter';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('letter', $letter.'%');
			return $query->getResult();
		}
		
		/**
		 * Recherche l'hébergement dans la table par son nom ou son n° interne
		 */
		public function getSearchHebergement($word)
		{	
			$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.actif, q.id, q.username FROM MyAppMobileBundle:Hebergements p JOIN p.utilisateur q WHERE q.username =:word OR p.nom_fr = :word OR p.nom_en =:word ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('word', $word);
			return $query->getResult();
		}
                
                /**
		 * Recherche l'hébergement dans la table par son nom 
		 */
		public function getSearchHebergementSansRelationAvecUtilisateur($word)
		{	
			$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.actif FROM MyAppMobileBundle:Hebergements p WHERE p.nom_fr = :word OR p.utilisateur =:word';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('word', $word);
			return $query->getResult();
		}
		
		/**
		 * Affiche tous les clients qui sont dans le type de categorie d'hébergement choisie et de la région aussi choisie avec les villes groupées 
		 */
		public function getAllCustomerByRegionAndCategoryGrouperParVille($cat, $reg)
		{
			$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.region_id = :reg AND p.aprouver = 1 AND p.actif = 1 AND q.id = :cat GROUP BY p.ville_id';
			$query = $this->getEntityManager()->createQuery($dql);
			$query->setParameter('cat', $cat);
			$query->setParameter('reg', $reg);
			return $query->getResult();
		}
		
		/**
		 * Compte le nombre d'hébergement dans la table.
		 */
		public function getCompteIdHebergement()
		{
			$sql = 'SELECT COUNT(q.id) AS nbHebergement FROM MyAppMobileBundle:Hebergements q';
			$query = $this->getEntityManager()->createQuery($sql);
			return $query->getResult();
		}
		
		/**
		 * Renvoie le nombre d'hébergement qui sont de cette catégorie d'hébergement et de la même région
		 */
		public function getCompteByRegionAndCategory($reg, $cat)
		{
			$sql = 'SELECT q, r FROM MyAppMobileBundle:Hebergements q JOIN q.categorie_hebergement_id r WHERE q.region_id = :reg AND r.id = :cat';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('reg', $reg);
			$query->setParameter('cat', $cat);
			return $query->getResult();
		}
	
		/**
		 * Compte le nombre d'hébergement pour cette catégorie d'hébergement.
		 */
		public function getCountNbIdHebergement($id)
		{
			$dql = 'SELECT p, q, COUNT(p.id) AS nbh FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE q.id = :id GROUP BY q.id';
			$query = $this->getEntityManager()->createQuery($dql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Compte le nombre d'hébergement pour cette catégorie d'hébergement dans cette région qui sont approuvés.
		 */
		public function getCountNbIdHebergementByRegion($id, $region)
		{
			$dql = 'SELECT p, q, COUNT(p.id) AS nbhr FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.region_id = :region AND p.aprouver = 1 AND p.actif = 1 AND q.id = :id GROUP BY q.id';
			$query = $this->getEntityManager()->createQuery($dql);
			$query->setParameter('id', $id);
			$query->setParameter('region', $region);
			return $query->getResult();
		}

		/**
		 * Affiche une liste de 5 établissements approuvés par région pour chaque région sortie aléatoire dans les suggestions d'hotels.
		 */
		public function getHebergementLimit($id, $tab, $limit = 5)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.id IN (:u) AND p.aprouver = 1 AND p.actif = 1 AND q.id = :id';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			$query->setParameter('u', $tab);
			$query->setMaxResults($limit);
			return $query->getResult();		
		}
		
		/**
		 * Récupère l'hébergement du client
		 */
		public function getExistHebergementCustomer($id)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p INNER JOIN p.client_id q WHERE p.id = :id AND p.actif = 1 AND p.aprouver = 1';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Affiche l'id et le nom_fr pour la relation entre entity dans le formulaire ou la liste des hébergements est appelés
		 */
		public function getDisplayJustIdAndNom()
		{
			return $this->_em->createQuery('SELECT p.id, p.nom_fr FROM MyAppMobileBundle:Hebergements p ')->getResult();
		}
		
		/**
		 * Affiche tous les clients qui sont dans le type de categorie d'hébergement choisie et de la région aussi choisie
		 */
		public function getAllCustomerByRegionAndCategory($cat, $reg)
		{
			$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q  WHERE p.region_id = :reg AND p.aprouver = 1 AND p.actif = 1 AND q.id = :cat ORDER BY p.nom_fr';
			$query = $this->getEntityManager()->createQuery($dql);
			$query->setParameter('cat', $cat);
			$query->setParameter('reg', $reg);
			return $query->getResult();
		}
		
		/**
		 * Affiche les clients qui ont la même catégorie d'hébergement et de la même région avec filtrage soit par par cotation ou prix
		 */
		public function getAllCustomerByRegionAndCategoryFiltreChoix($cat, $reg, $choix, $page, $limit)
		{
			if($choix == 1){ 
				$tab = array(3,4,5,6,7); //étoiles
				$paginator = ($page - 1) * $limit;
				$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.region_id = :reg AND p.aprouver = 1 AND p.actif = 1 AND q.id = :cat AND p.classification_id IN (:class) ORDER BY p.classification';
				$query = $this->getEntityManager()->createQuery($dql);
				$query->setParameter('cat', $cat);
				$query->setParameter('reg', $reg);
				$query->setParameter('class', $tab);
				$query->setFirstResult($paginator);
				$query->setMaxResults($limit);
				return $query->getResult();
			}elseif($choix == 3){
				$tab = array(13,14,15,16,17); //soleils
				$paginator = ($page - 1) * $limit;
				$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.region_id = :reg AND p.aprouver = 1 AND p.actif = 1 AND q.id = :cat AND p.classification_id IN (:class) ORDER BY p.classification';
				$query = $this->getEntityManager()->createQuery($dql);
				$query->setParameter('cat', $cat);
				$query->setParameter('reg', $reg);
				$query->setParameter('class', $tab);
				$query->setFirstResult($paginator);
				$query->setMaxResults($limit);
				return $query->getResult();
			}elseif($choix == 2){ //tarifs
                                $paginator = ($page - 1) * $limit;
				$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.region_id = :reg AND p.aprouver = 1 AND p.actif = 1 AND q.id = :cat ORDER BY p.prix_a_partir';
				$query = $this->getEntityManager()->createQuery($dql);
				$query->setParameter('cat', $cat);
				$query->setParameter('reg', $reg);
				$query->setFirstResult($paginator);
				$query->setMaxResults($limit);
				return $query->getResult();
			}
		}
		
		/**
		 * Affiche tous les clients qui sont dans le type de categorie d'hébergement choisie et de la ville aussi choisie
		 */
		public function getAllCustomerByVilleAndCategory($cat, $reg)
		{
			$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.ville_id = :reg AND p.aprouver = 1 AND p.actif = 1 AND q.id = :cat ';
			$query = $this->getEntityManager()->createQuery($dql);
			$query->setParameter('cat', $cat);
			$query->setParameter('reg', $reg);
			return $query->getResult();
		}
		
		/**
		 * Affiche tous les clients qui sont dans le type de categorie d'hébergement choisie et de la région aussi choisie avec la pagination
		 */
		public function getAllCustomerByRegionAndCategoryPagination($cat, $reg, $page, $limit)
		{
			$paginator = ($page - 1) * $limit;
			$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.region_id = :reg AND p.aprouver = 1 AND p.actif = 1 AND q.id = :cat';
			$query = $this->getEntityManager()->createQuery($dql);
			$query->setParameter('cat', $cat);
			$query->setParameter('reg', $reg);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			return $query->getResult();
		}
		
		/**
		 * Affiche tous les clients qui sont dans le type de categorie d'hébergement choisie et de la ville aussi choisie avec la pagination
		 */
		public function getAllCustomerByVilleAndCategoryPagination($cat, $ville, $page, $limit)
		{
			$paginator = ($page - 1) * $limit;
			$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.ville_id = :ville AND p.aprouver = 1 AND p.actif = 1 AND q.id = :cat';
			$query = $this->getEntityManager()->createQuery($dql);
			$query->setParameter('cat', $cat);
			$query->setParameter('ville', $ville);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			return $query->getResult();
		}
                
                
                /**
		 * Affiche tous les clients qui sont de la province choisie avec la pagination
		 */
		public function getAllCustomerByProvincePagination($province, $page, $limit)
		{
			$paginator = ($page - 1) * $limit;
			$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.province_id = :province AND p.aprouver = 1 AND p.actif = 1 ';
			$query = $this->getEntityManager()->createQuery($dql);	
			$query->setParameter('province', $province);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			return $query->getResult();
		}
                
                
                /**
		 * Affiche tous les clients qui sont de la ville choisie avec la pagination
		 */
		public function getAllCustomerByVillePagination($ville, $page, $limit)
		{
			$paginator = ($page - 1) * $limit;
			$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.ville_id = :ville AND p.aprouver = 1 AND p.actif = 1 ';
			$query = $this->getEntityManager()->createQuery($dql);	
			$query->setParameter('ville', $ville);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			return $query->getResult();
		}
		
		/**
		 * Compte tous les clients qui sont de cette catégorie d'hébergement
		 */
		public function getCompteCustomerByCategorieHebergement($cat)
		{
			$dql = 'SELECT p.id, p.nom_fr, p.nom_en, q  FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE q.id = :cat';
			$query = $this->getEntityManager()->createQuery($dql);
			$query->setParameter('cat', $cat);
			return $query->getResult();
		}	
		
		/**
		 * Affiche la province si elle a des hébergements qui sont du type recherché
		 */
		public function getSelectTypeHebergementProvince($id,  $catHeberg)
		{
			$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.province_id = :id AND p.aprouver = 1 AND p.actif = 1 AND q.id = :cat';
			$query = $this->getEntityManager()->createQuery($dql);
			$query->setParameter('id', $id);
			$query->setParameter('cat', $catHeberg);
			$query->setMaxResults(1);
			return $query->getResult();
		}	
		
		/**
		 * Affiche tous les hébergements de type hôtels pour la province choisie
		 */
		public function getSelectAllHebergementProvince($id, $catHeberg)
		{
			$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE q.id = :cat AND p.province_id = :id AND p.aprouver = 1 AND p.actif = 1 GROUP BY p.region_id';
			$query = $this->getEntityManager()->createQuery($dql);
			$query->setParameter('id', $id);
			$query->setParameter('cat', $catHeberg);
			return $query->getResult();
		}
		
		/**
		 * Affiche une liste d'hébergement pour qui sont de la même catégorie et de la même région
		 */
		public function getListHebergementMemeRegionMemeCategorie( $tab)
		{	
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.id IN (:u, :v, :x, :y, :z)';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('u', $tab[0]);
			$query->setParameter('v', $tab[1]);
			$query->setParameter('x', $tab[2]);
			$query->setParameter('y', $tab[3]);
			$query->setParameter('z', $tab[4]);
			return $query->getResult();
		}
		
		/**
		 * Affiche les types d'hébergements disponibles pour cette région
		 */
		public function getChoiceCategoryHebergementByRegion($reg)
		{
			$dql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.region_id = :id AND q.id is not null GROUP BY q.id';
			$query = $this->getEntityManager()->createQuery($dql);
			$query->setParameter('id', $reg);
			return $query->getResult();
		}
		
		/**
		 * Affiche une liste de 5 hôtels pour chaque région dans suggestion bas de page
		 */
		public function getAfficheListeClient($id, $limit = 5)
		{	
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.region_id = :id AND p.aprouver = 1 AND p.actif = 1';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			$query->setMaxResults($limit);
			return $query->getResult();
		}
		
		/**
		 * Affiche les provinces qui ont des établissements hôteliers
		 */
		public function getAfficheProvincesCoteClient($id)
		{
			$sql = 'SELECT p.id, p.nom_fr, p.adresse, p.code_postal, p.region_id, p.ville_id, p.reservit_id FROM MyAppMobileBundle:Hebergements p WHERE p.province_id = :id AND p.aprouver = 1 AND p.actif = 1 GROUP BY p.province_id';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Affiche les régions qui ont des établissements hôteliers
		 */
		public function getAfficheRegionsCoteClient($id)
		{
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.province_id = :id AND p.aprouver = 1 AND p.actif = 1 GROUP BY p.region_id';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Récupère tous les clients de cette région qui sont approuvés et de la même catégorie d'hébergement pour les listes de suggestions colonne de gauche
		 */
		public function getRecupListeHotelPourSuggestionGauche($id)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.region_id = :id AND p.aprouver = 1 AND p.actif = 1 AND q.id = 7';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			$query->setMaxResults(5);
			return $query->getResult();
		}
		
		/**
		 * Récupère l'hébergement du client
		 */
		public function getRechercheHebergementCustomer($id)
		{
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.id = :id';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Récupère tous les clients de cette région qui sont approuvés et de la même catégorie d'hébergement pour les listes de suggestions bas de page
		 */
		public function getRecupListeHotelPourSuggestionBasPage($id, $cat)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE q.id =:cat AND p.aprouver = 1 AND p.actif = 1 AND p.region_id = :id';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			$query->setParameter('cat', $cat);
			$query->setMaxResults(5);
			return $query->getResult();
		}
		
		/**
		 * Affiche un client approuvé qui est de la catégorie d'hébergement demandée
		 */
		public function getAfficheUnClientParCategorie($id, $geographie, $name)
		{
			if($name == "province")
			{
				$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.province_id IN (:geo) AND p.aprouver = 1 AND p.actif = 1 AND q.id = :id ';
				$query = $this->getEntityManager()->createQuery($sql);
				$query->setParameter('id', $id);
				$query->setParameter('geo', $geographie);
				return $query->getResult();
			}
			elseif($name == "categorie&region")
			{
				$limit = 5;
				$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.region_id =:geo AND p.aprouver = 1 AND p.actif = 1 AND q.id = :id ';
				$query = $this->getEntityManager()->createQuery($sql);
				$query->setParameter('id', $id);
				$query->setParameter('geo', $geographie);
				$query->setMaxResults($limit);
				return $query->getResult();
			}
			elseif($name == "region")
			{
				$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.region_id = :geo AND p.aprouver = 1 AND p.actif = 1 AND q.id = :id';
				$query = $this->getEntityManager()->createQuery($sql);
				$query->setParameter('id', $id);
				$query->setParameter('geo', $geographie);
				return $query->getResult();
			}
			else
			{
				$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE  p.ville_id = :geo AND p.aprouver = 1 AND p.actif = 1 AND q.id = :id';
				$query = $this->getEntityManager()->createQuery($sql);
				$query->setParameter('id', $id);
				$query->setParameter('geo', $geographie);
				return $query->getResult();
			}
		}
		
		/**
		 * Retourne une liste de 5 clients qui sont de la même région et ont le m^me type d'hébergement
		 */
		public function getListe5ClientRegionCategorieHebergement($cat, $region, $limit = 5)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.region_id = :region AND p.aprouver = 1 AND p.actif = 1 AND q.id = :cat ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('cat', $cat);
			$query->setParameter('region', $region);
			$query->setMaxResults($limit);
			return $query->getResult();
		}
		
		/**
		 * Recherche un client par son id 
		 */
		public function getAfficheUnClientHebergement($id)
		{
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.id = :id AND p.aprouver = 1 AND p.actif = 1';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Recherche un client par son id et par sa categorie
		 */
		public function getAfficheUnClientHebergementCategorie($id)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.aprouver = 1 AND p.actif = 1 AND q.id = :id ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Recherche l'id de l'hébergement par son nom de repertoire
		 */
		public function getNameHebergement($word)
		{
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.actif = 1 AND p.aprouver = 1 AND ( p.repertoire_fr = :nom OR p.repertoire_en = :nom)';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('nom', $word);
			return $query->getResult();
		}
		
		/**
		 * Recherche l'hébergement par son nom_fr ou son nom_en
		 */
		public function getRechercheNomHebergement($word)
		{
                        $word = html_entity_decode($word);
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.nom_fr LIKE :word AND p.aprouver = 1 and p.actif = 1 OR p.nom_en LIKE :word AND p.aprouver = 1 and p.actif = 1';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('word', '%'.$word);
			return $query->getResult();
		}
		
		/**
		 * Récupère les devises de l'établissement et son style
		 */
		public function getDeviseHebergement($id)
		{
			$sql = 'SELECT p, q, r, s FROM MyAppMobileBundle:Hebergements p JOIN p.devise_id q JOIN p.style_hebergement_id r JOIN p.hebergement_paiements_id s WHERE p.id = :id';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
                
                /**
                 * Méthode pour récupérer les devises de L,hébergement si le client a pas renseigné le ou les styles d'hébergement comme le client doit maintenant renseigné les styles et les modes de paiements
                 */
                public function getRetourneDevise($id)
                {
                        $sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.devise_id q WHERE p.id = :id';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
                }
		
		/**
		 * Recherche des établissements qui ont les mêmes critères auxquels on supprime de la recherche l'hébergement qui nous sert de référence.
		 */
		public function getCritereEtablissement($ville, $styleHeb, $idclient)
		{       
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.style_hebergement_id q WHERE  p.ville_id = :ville AND p.actif = 1 AND p.aprouver = 1 AND q.id IN (:styleHeb) AND p.id <> :idclient ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('ville', $ville);
			$query->setParameter('styleHeb', $styleHeb);
			$query->setParameter('idclient', $idclient);
			return $query->getResult();
		}
		
		/**
		 * Récupère les services de l'hébergement
		 */
		public function getServiceHebergement($id)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.hebergement_service_id q WHERE p.id = :id';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Récupère les activités de l'hébergement
		 */
		public function getActivitesHebergement($id)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.hebergement_activite_id q WHERE p.id = :id';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Récupère tous les hébergements de la province qui ont des activités
		 */
		public function getActivitesHebergementProvince($id)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.hebergement_activite_id q WHERE p.province_id =:id AND q.id is not null GROUP BY p.region_id ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Récupère une liste de 4 hébergements pour la région qui ont des activités
		 */
		public function getActivitesHebergementRegionLimit4($id)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.hebergement_activite_id q WHERE p.region_id =:id AND q.id is not null GROUP BY p.id ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			$query->setMaxResults(4);
			return $query->getResult();
		}
		
		/**
		 * Récupère les hébergements pour la région qui ont des activités
		 */
		public function getActivitesHebergementRegion($id)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.hebergement_activite_id q WHERE p.region_id =:id AND q.id is not null GROUP BY p.id ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Récupère les hébergements pour la région qui ont des activités avec la pagination
		 */
		public function getActivitesHebergementRegionPaginate($id, $page, $limit)
		{
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.hebergement_activite_id q WHERE p.region_id =:id AND q.id is not null GROUP BY p.id ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			return $query->getResult();
		}
		
		/**
		 * Récupère les hébergements pour la région qui ont des activités grouper par ville
		 */
		public function getActivitesHebergementRegionGroupByVille($id)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.hebergement_activite_id q WHERE p.region_id =:id AND q.id is not null GROUP BY p.ville_id ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Récupère les hébergements pour la ville qui ont des activités
		 */
		public function getActivitesHebergementVille($id)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.hebergement_activite_id q WHERE p.ville_id =:id AND q.id is not null GROUP BY p.id ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			return $query->getResult();
		}
		
		/**
		 * Récupère les hébergements pour la ville qui ont des activités avec la pagination
		 */
		public function getActivitesHebergementVillePaginate($id, $page, $limit)
		{
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.hebergement_activite_id q WHERE p.ville_id =:id AND q.id is not null GROUP BY p.id ';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			return $query->getResult();
		}
		
		/*####################################################################################*/
		/* 				 Fonctions pour le moteur de recherche section CLIENT				  */
		/*####################################################################################*/
		
		/**
		 * Pagination pour les hébergements tableau de bord section client trier par région
		 *
		 * @ORM\PostLoad()
		 */
		public function getAdminHebergementTriRegion($page, $limit, $region )
		{
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.region_id = :region ORDER BY p.nom_fr ASC';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			$query->setParameter('region', $region);
			return $query->getResult();
		}
		
		/**
		 * Pagination pour les hébergements tableau de bord section client trier par zone
		 *
		 * @ORM\PostLoad()
		 */
		public function getAdminHebergementTriZone($page, $limit, $zone )
		{
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.zone_id = :zone ORDER BY p.nom_fr ASC';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			$query->setParameter('zone', $zone);
			return $query->getResult();
		}
		
		/**
		 * Pagination pour les hébergements tableau de bord section client trier par ville
		 *
		 * @ORM\PostLoad()
		 */
		public function getAdminHebergementTriVille($page, $limit, $ville )
		{
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.ville_id = :ville ORDER BY p.nom_fr ASC';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			$query->setParameter('ville', $ville);
			return $query->getResult();
		}
		
		/**
		 * Recherche les hébergements qui ont le status actif
		 */
		public function getAdminHebergementActif($page, $limit, $actif)
		{	
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.actif = :actif ORDER BY p.nom_fr ASC';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			$query->setParameter('actif', $actif);
			return $query->getResult();
		}
		
		/**
		 * Recherche les hébergements qui ont le status inactif
		 */
		public function getAdminHebergementInActif($page, $limit, $inactif)
		{
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.actif = :inactif ORDER BY p.nom_fr ASC';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			$query->setParameter('inactif', $inactif);
			return $query->getResult();
		}
		
		/**
		 * Recherche les hébergements qui commencent par cette lettre alphabétique
		 */
		public function getClientByFirstLetter($page, $limit, $lettre)
		{
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.nom_fr LIKE :lettre ORDER BY p.nom_fr ASC';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			$query->setParameter('lettre', $lettre.'%');
			return $query->getResult();
		}
		
		/**
		 * Compte le nombre d'hébergement qui sont publiés
		 */
		public function getCompteHebergementPublier()
		{
			$sql = 'SELECT COUNT(p.id) AS nbHebergement FROM MyAppMobileBundle:Hebergements p WHERE p.aprouver = 0';
			$query = $this->getEntityManager()->createQuery($sql);
			return $query->getResult();
		}
		
		/**
		 * Compte le nombre d'hébergement qui sont actifs
		 */
		public function getCompteHebergementActif()
		{
			$sql = 'SELECT COUNT(p.id) AS nbHebergement FROM MyAppMobileBundle:Hebergements p WHERE p.actif = 1';
			$query = $this->getEntityManager()->createQuery($sql);
			return $query->getResult();
		}
		
		/**
		 * Compte le nombre d'hébergement qui sont inactifs
		 */
		public function getCompteHebergementInActif()
		{
			$sql = 'SELECT COUNT(p.id) AS nbHebergement FROM MyAppMobileBundle:Hebergements p WHERE p.actif = 0';
			$query = $this->getEntityManager()->createQuery($sql);
			return $query->getResult();
		}
		
		/**
		 * Compte le nombre d'hébergement qui sont de cette région
		 */
		public function getCompteHebergementRegionSectionClient($region)
		{
			$sql = 'SELECT COUNT(p.id) AS nbHebergement FROM MyAppMobileBundle:Hebergements p WHERE p.region_id = :region';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('region', $region);
			return $query->getResult();
		}
		
		/**
	     * Compte le nombre d'hébergement qui sont de cette zone
	     */
	    public function getCompteHebergementZoneSectionClient($zone)
	    {
	    	$sql = 'SELECT COUNT(p.id) AS nbHebergement FROM MyAppMobileBundle:Hebergements p WHERE p.zone_id = :zone';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('zone', $zone);
	    	return $query->getResult();
	    }
	    
	    /**
	     * Compte le nombre d'hébergement qui sont de cette ville
	     */
	    public function getCompteHebergementVilleSectionClient($ville)
	    {
	    	$sql = 'SELECT COUNT(p.id) AS nbHebergement FROM MyAppMobileBundle:Hebergements p WHERE p.ville_id = :ville';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('ville', $ville);
	    	return $query->getResult();
	    }
		
	    /**
	     * Compte le nombre d'hébergement qui ont le nom qui commence par cette lettre
	     */
	    public function getCompteHebergementLettreSectionClient($word)
	    {
	    	$sql = 'SELECT COUNT(p.id) AS nbHebergement FROM MyAppMobileBundle:Hebergements p WHERE p.nom_fr LIKE :word';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('word', $word.'%');
	    	return $query->getResult();
	    }
		
	    /**
	     * Recherche les clients approuvés qui sont de cette ville grouper par ville
	     */
	    public function getAfficheClientDeLaVille($id)
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.region_id = :id AND p.aprouver = 1 AND p.actif = 1 GROUP BY p.ville_id';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('id', $id);
	    	return $query->getResult();
	    }
		
	    /**
	     * Affiche les activités de l'hébergement du client 
	     */
	    public function getAfficheToutesActivitesHebergementDuClient($id)
	    {
	    	$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.hebergement_activite_id q WHERE p.id = :id ORDER BY q.nom_fr ASC';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('id', $id);
	    	return $query->getResult();
	    }
	    
	    /**
	     * Fonction pour afficher les provinces sur la page d'accueil du portail
	     */
	    public function getAfficheProvinceAccueil($id, $limit = 1)
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.aprouver = 1 and p.province_id = :id';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('id', $id);
	    	$query->setMaxResults($limit);
	    	return $query->getResult();
	    }
            
            /**
	     * Fonction pour afficher les provinces sur la page d'accueil du portail
	     */
	    public function getAfficheProvince($id, $lang, $page, $limit)
	    {
                $paginator = ($page - 1) * $limit;
                if($lang == "fr"){                  
                    $sql = 'SELECT p.id, p.nom_fr, p.texte_description_fr, p.reservit_id, p.repertoire_fr, p.prix_a_partir, q.nom_fr AS region, r.nom_fr AS ville, s.id AS classification, s.valeur, s.image  FROM MyAppMobileBundle:Hebergements p JOIN p.region_id q JOIN p.ville_id r JOIN p.classification_id s WHERE p.province_id = :id AND p.actif = 1 AND p.aprouver = 1';
                    $query = $this->getEntityManager()->createQuery($sql);
                    $query->setParameter('id', $id);
                    $query->setFirstResult($paginator);
                    $query->setMaxResults($limit);
                    return $query->getResult();
                }else{
                    $sql = 'SELECT p.id, p.nom_en, p.texte_description_en, p.reservit_id, p.repertoire_en, p.prix_a_partir, q.nom_en AS region, r.nom_en AS ville, s.id AS classification, s.valeur, s.image  FROM MyAppMobileBundle:Hebergements p JOIN p.region_id q JOIN p.ville_id r JOIN p.classification_id s WHERE p.province_id = :id AND p.actif = 1 AND p.aprouver = 1';
                    $query = $this->getEntityManager()->createQuery($sql);
                    $query->setParameter('id', $id);
                    $query->setFirstResult($paginator);
                    $query->setMaxResults($limit);
                    return $query->getResult();
                }
	    }
            
            /**
	     * Fonction pour afficher les régions sur la page d'accueil du portail
	     */
	    public function getAfficheRegion($id, $lang, $page, $limit)
	    {
                $paginator = ($page - 1) * $limit;
                if($lang == "fr"){                  
                    $sql = 'SELECT p.id, p.nom_fr, p.texte_description_fr, p.reservit_id, p.repertoire_fr, p.prix_a_partir, r.nom_fr AS ville, s.id AS classification, s.valeur, s.image  FROM MyAppMobileBundle:Hebergements p JOIN p.region_id q JOIN p.ville_id r JOIN p.classification_id s WHERE p.region_id = :id AND p.actif = 1 AND p.aprouver = 1';
                    $query = $this->getEntityManager()->createQuery($sql);
                    $query->setParameter('id', $id);
                    $query->setFirstResult($paginator);
                    $query->setMaxResults($limit);
                    return $query->getResult();
                }else{
                    $sql = 'SELECT p.id, p.nom_en, p.texte_description_en, p.reservit_id, p.repertoire_en, p.prix_a_partir, r.nom_en AS ville, s.id AS classification, s.valeur, s.image  FROM MyAppMobileBundle:Hebergements p JOIN p.region_id q JOIN p.ville_id r JOIN p.classification_id s WHERE p.region_id = :id AND p.actif = 1 AND p.aprouver = 1';
                    $query = $this->getEntityManager()->createQuery($sql);
                    $query->setParameter('id', $id);
                    $query->setFirstResult($paginator);
                    $query->setMaxResults($limit);
                    return $query->getResult();
                }
	    }
            
             /**
	     * Fonction pour afficher les villes sur la page d'accueil du portail
	     */
	    public function getAfficheVille($id, $lang, $page, $limit)
	    {
                $paginator = ($page - 1) * $limit;
                if($lang == "fr"){                  
                    $sql = 'SELECT p.id, p.nom_fr, p.texte_description_fr, p.reservit_id, p.repertoire_fr, p.prix_a_partir, r.nom_fr AS ville, s.id AS classification, s.valeur, s.image  FROM MyAppMobileBundle:Hebergements p JOIN p.ville_id r JOIN p.classification_id s WHERE p.ville_id = :id AND p.actif = 1 AND p.aprouver = 1';
                    $query = $this->getEntityManager()->createQuery($sql);
                    $query->setParameter('id', $id);
                    $query->setFirstResult($paginator);
                    $query->setMaxResults($limit);
                    return $query->getResult();
                }else{
                    $sql = 'SELECT p.id, p.nom_en, p.texte_description_en, p.reservit_id, p.repertoire_en, p.prix_a_partir, r.nom_en AS ville, s.id AS classification, s.valeur, s.image  FROM MyAppMobileBundle:Hebergements p JOIN p.ville_id r JOIN p.classification_id s WHERE p.ville_id = :id AND p.actif = 1 AND p.aprouver = 1';
                    $query = $this->getEntityManager()->createQuery($sql);
                    $query->setParameter('id', $id);
                    $query->setFirstResult($paginator);
                    $query->setMaxResults($limit);
                    return $query->getResult();
                }
	    }
                       
	    /**
	     * Fonction pour afficher les régions sur la section d'accueil du portail
	     */
	    public function getAfficheRegionAccueil($id)
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.aprouver = 1 AND p.province_id = :id GROUP BY p.region_id';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('id', $id);
	    	return $query->getResult();
	    }
	    
	    /**
	     * Affiche les régions qui ont des établissements hôteliers grouper par région
	     */
	    public function getAfficheRegionsCoteClientGroupByRegion($id)
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.region_id = :id AND p.aprouver = 1 AND p.actif = 1 GROUP BY p.region_id';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('id', $id);
	    	return $query->getResult();
	    }
	    
	    /**
	     * Affiche les villes qui ont des établissements hôteliers grouper par ville
	     */
	    public function getAfficheVillesCoteClientGroupByVille($id)
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.ville_id = :id AND p.aprouver = 1 AND p.actif = 1 GROUP BY p.ville_id';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('id', $id);
	    	return $query->getResult();
	    }
	    
	    /**
	     * Fonction pour afficher toutes les provinces
	     */
	    public function getAfficheToutesLesProvinces($pays)
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p JOIN p.province_id q WHERE q.pays_id = :pays AND p.aprouver = 1 AND p.actif = 1 GROUP BY p.province_id';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('pays', $pays);
	    	return $query->getResult();
	    }
	    
	    /**
	     * Méthode pour retourner le dernier id 
	     */
 		public function getRetourneDernierId()
	    {
	    	$sql = 'SELECT MAX(p.id) AS lastid FROM MyAppMobileBundle:Hebergements p ';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	return $query->getResult();
	    }
	    
	    /**
	     * Recherche l'id de l'hébergement par son nom de repertoire avec l'id de l'utilisateur
	     */
	    public function getRechercheHebergementParRepertoireEtIdValideUtilisateur($id ,$repertoire, $clientid)
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.id = :id AND p.repertoire_fr = :nom AND p.utilisateur = :client OR p.id = :id AND p.repertoire_en = :nom AND p.utilisateur = :client';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('nom', $repertoire);
	    	$query->setParameter('id', $id);
	    	$query->setParameter('client', $clientid);
	    	return $query->getResult();
	    }
	    
	    /**
	     * Recherche l'hébergement par son repertoire et son id
	     */
	    public function getRechercheHebergementParRepertoireEtId($id, $name)
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.id = :id AND p.repertoire_fr = :word OR p.id =:id AND p.repertoire_en = :word';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('word', $name);
	    	$query->setParameter('id', $id);
	    	return $query->getResult();
	    }
	    
	    /**
	     * Récupère l'hébergement actif et approuver du client par son idclient
	     */
	    public function getExistHebergement($id)
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.utilisateur = :id AND p.actif = 1 AND p.aprouver = 1 OR p.utilisateur = :id AND p.aprouver = 1';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('id', $id);
	    	return $query->getResult();
	    }
            
            /**
	     * Récupère l'hébergement du client par son idclient
	     */
	    public function getExistHebergementNonValideActif($id)
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.utilisateur = :id ';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('id', $id);
	    	return $query->getResult();
	    }
	    
	    /**
	     * Affiche les détail du client
	     */
	    public function getAfficheDetail($id)
	    {               
                $sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.id = :id AND p.aprouver = 1 AND p.actif = 1';
                $query = $this->getEntityManager()->createQuery($sql);
                $query->setParameter('id', $id);
                return $query->getResult();               
	    }
	    
	    /**
	     * Retourne les périodes de hautes saison
	     */
	    public function getRetournePeriodeHauteSaison($id)
	    {
	    	$sql = 'SELECT p, q FROM MyAppMobileBundle:Hebergements p JOIN p.calendrier q WHERE p.id = :id ';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('id', $id);
	    	return $query->getResult();
	    }
            
            /**
             * Retourne la liste des clients dont les résultats sont resortis dans le moteur de recherche
             */
	    public function getListeClientPropositionMoteurRecherche($id)
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p WHERE p.id IN (:id) AND p.actif = 1 AND p.aprouver = 1';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	$query->setParameter('id', $id);
	    	return $query->getResult();
	    }
            
            /**
             * Retourne la liste des province groupées
             */
	    public function getListeProvincesGroupees()
	    {
	    	$sql = 'SELECT p FROM MyAppMobileBundle:Hebergements p GROUP BY p.province_id ';
	    	$query = $this->getEntityManager()->createQuery($sql);
	    	return $query->getResult();
	    }
	    
}