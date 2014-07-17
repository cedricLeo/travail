<?php
namespace MyApp\MobileBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AttraitsRepository extends EntityRepository{

	/**
     * Liste tous les attraits pour l'auto-completion coté admin
	 *
	 * @ORM\PreLoad()
	 */
	public function getListAttrait() 
	{
		$sql = 'SELECT p.id, p.nom_fr FROM MyAppMobileBundle:Attraits p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Liste tous les attraits pour l'auto-completion coté portail
	 *
	 * @ORM\PreLoad()
	 */
	public function getAutocompletionAttraitPortail()
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Attraits p WHERE p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Pagination pour les attraits dans le tableau de bord pour lister les clients
	 *
	 * @ORM\PostLoad()
	 */
	public function getAdminAttraitTBClient($page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 *  Compte le nombre d'attrait dans la table
	 */
	public function getCompteIdAttrait()
	{
		$sql = 'SELECT COUNT(p.id) AS nbAttrait FROM MyAppMobileBundle:Attraits p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'attrait qui est entré dans le moteur de recherche coté admin avec sa relation utilisateur
	 */
	public function getSearchAttrait($searchword)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.actif, q.id, q.username FROM MyAppMobileBundle:Attraits p JOIN p.utilisateur q WHERE p.nom_fr = :word OR p.utilisateur =:word OR q.username =:word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $searchword);
		return $query->getResult();
	}
        
        /**
	 * Recherche l'attrait qui est entré dans le moteur de recherche coté admin sans sa relation utilisateur
	 */
	public function getSearchAttraitSansRelationUtilisateur($searchword)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.actif FROM MyAppMobileBundle:Attraits p WHERE p.nom_fr = :word OR p.utilisateur =:word ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $searchword);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'attrait entrée dans le moteur de recherche coté client
	 */
	public function getRechercheAttrait($searchword)
	{
                $searchword = html_entity_decode($searchword);
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.nom_fr LIKE :word AND p.approuve = 1 AND p.actif = 1 OR p.nom_en LIKE :word AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', '%'.$searchword.'%');
		return $query->getResult();
	}
	
	/**
	 *	Affiche les attraits avec la pagination.
	 */
	public function getAdminAttrait($page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.actif FROM MyAppMobileBundle:Attraits p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 *  Recherche tous les attraits qui commencent par cette lettre.
	 */
	public function getAttraitByFirstLetter($letter)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.actif FROM MyAppMobileBundle:Attraits p WHERE p.nom_fr LIKE :letter';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('letter', $letter.'%' );
		return $query->getResult();
	}
        
        /**
	 * Retourne les attraits proche de ce client 
	 */
	public function getListeGpsFluxRss($tab, $today, $limit = 10)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.id IN (:tab) AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		//$query->setParameter('now', $today);
		$query->getMaxResults($limit);
		return $query->getResult();
	}
        
        /**
	 * Retourne les attraits qui sont approuvés et actifs
	 */
	public function getListeGps($page, $limit, $tab)
	{
		$paginator = ($page - 1)* $limit;
		//$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.image, p.texte_resume_fr, p.texte_resume_en, p.repertoire_fr, p.repertoire_en FROM MyAppMobileBundle:Attraits p WHERE p.id IN (:tab) AND p.approuve = 1';
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.id IN (:tab) AND p.approuve = 1 and p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
        
        public function getCountListeGps()
	{
		$sql = 'SELECT COUNT(p.id) AS nbActif FROM MyAppMobileBundle:Attraits p WHERE p.approuve = 1 and p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
        
        /**
	 * Retourne les hébergements et attraits qui sont approuvés qui n'ont pas de client_id vide dans les tables attraits et hébergements et que les latitudes et longitudes ne sont pas vide ou différentes de 0
	 */
	public function getPreTraitementPourGpsPOurAttraits($client)
	{
		$sql = 'SELECT p.id, p.latitude, p.longitude, p.date_creation FROM MyAppMobileBundle:Attraits p WHERE p.id <> :id AND p.approuve = 1 AND p.actif = 1 AND p.latitude is not null AND p.longitude is not null AND p.latitude != 0 AND p.longitude != 0 ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $client);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'id de l'hébergement par son nom de repertoire avec l'id de l'utilisateur
	 */
	public function getRechercheAttraitParRepertoireEtIdValideUtilisateur($id ,$repertoire, $clientid)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.id = :id AND p.repertoire_fr = :nom AND p.utilisateur = :client OR p.id = :id AND p.repertoire_en = :nom AND p.utilisateur = :client';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('nom', $repertoire);
		$query->setParameter('id', $id);
		$query->setParameter('client', $clientid);
		return $query->getResult();
	}
	
	/**
	 * Récupère l'attrait par son id et son repertoire
	 */
	public function getRechercheAttraitParRepertoireEtId($id, $repertoire)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.id = :id AND p.repertoire_fr = :repertoire OR p.id = :id AND p.repertoire_en = :repertoire';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('repertoire', $repertoire);
		return $query->getResult();
	}
	
	/**
	 * Récupère les attraits de l'utilisateur
	 */
	public function getRechercheAttraitParUtilisateur($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:attraits p WHERE p.utilisateur = :client';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('client', $id);
		return $query->getResult();
	}
	
	
	/**
	 * Tri les attraits par la catégorie recherchée dans le moteur de recherche
	 */
	public function getSortAttraitByCategory($id)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:attraits p WHERE p.categorie_attrait = :cat';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $id);
		return $query->getResult();
	}
	
	/**
	 * Récupère les photos de l'attrait
	 */
	public function getSearchPhoto($word)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:attraits p WHERE p.nom_fr = :client';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('client', $word);
		return $query->getResult();
	}
	
	/**
	 * Tri les attraits et activités pour la province choisit et grouper par catégorie des attraits
	 */
	public function getSortProvinceAttrait($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :id AND p.categorie_attrait is not null GROUP BY p.categorie_attrait ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Tri les attraits et activités pour la région choisit et grouper par catégorie des attraits
	 */
	public function getSortRegionAttrait($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :id AND p.categorie_attrait is not null GROUP BY p.categorie_attrait  ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Tri les attraits et activités pour la province choisit
	 */
	public function getAfficheLaListeDesCategorieDAttraitsProvince($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :id AND p.categorie_attrait is not null';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Tri les attraits et activités pour la région choisit
	 */
	public function getAfficheLaListeDesCategorieDAttraits($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :id AND p.categorie_attrait is not null ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Tri les villes de la région choisie
	 */
	public function getSortVilleAttrait($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :id AND p.categorie_attrait is not null GROUP BY p.ville_id  ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Tri les villes de la région choisie grouper par ville_id
	 */
	public function getSortVilleAttraitGroupBy($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.ville_id = :id AND p.categorie_attrait is not null GROUP BY p.ville_id  ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Affiche la liste des attraits pour la ville sélectionnée.
	 */
	public function getAfficheListeAttraitPourVille($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.ville_id = :id AND p.categorie_attrait is not null GROUP BY p.categorie_attrait';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Affiche les provinces qui ont des catégories d'attraits et activités
	 */
	public function getAfficheProvincesPOurAttrait($id)
	{	
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :id AND p.categorie_attrait is not null GROUP BY p.province_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Affiche les régions qui ont des catégories d'attraits et activités
	 */
	public function getAfficheRegionsPourAttrait($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :id AND p.categorie_attrait is not null AND p.approuve = 1 AND p.actif = 1 GROUP BY p.region_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Affiche les régions qui ont la catégorie d'attrait et activité recherchée
	 */
	public function getAfficheRegionsPourAttraitActiviteRechercher($id, $cat)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :id AND p.categorie_attrait = :cat AND p.approuve = 1 AND p.actif = 1 GROUP BY p.region_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('cat', $cat);
		return $query->getResult();
	}
	
	/**
	 * Affiche les régions de cette province qui ont l'activité recherchée
	 */
	public function getAfficheActiviteRechercherPourLaProvince($id, $cat)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :id AND p.categorie_attrait = :cat AND p.approuve = 1 AND p.actif = 1 GROUP BY p.region_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('cat', $cat);
		return $query->getResult();
	}
	
	/**
	 * Affiche les régions de cette province qui ont des restaurants
	 */
	public function getAfficheTousRestaurantPourLaProvince($id, $catResto)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :id AND p.categorie_attrait = :catResto AND p.approuve = 1 AND p.actif = 1 GROUP BY p.region_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('catResto', $catResto);
		return $query->getResult();
	}
	
	/**
	 * Affiche les régions de cette province qui ont des restaurants grouper par nom_fr
	 */
	public function getAfficheTousLesRestaurantPourLaProvince($id, $catResto)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.cuisine_id q WHERE p.province_id = :id AND p.categorie_attrait = :catResto AND p.approuve = 1 AND p.actif = 1 ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('catResto', $catResto);
		return $query->getResult();
	}
	
	/**
	 * Affiche les restaurants des régions de cette province et qui sont approuvés
	 */
	public function getListeTousRestaurantPourLaProvince($id, $catResto)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :id AND p.categorie_attrait = :catResto AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('catResto', $catResto);
		return $query->getResult();
	}
	
	/**
	 * Affiche tous les attraits et activités des provinces affichées
	 */
	public function getAllAttraitProvinces($tab)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id IN ( :qc, :on, :nb) AND p.categorie_attrait is not null AND p.approuve = 1 AND p.actif = 1 GROUP BY p.categorie_attrait ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('qc', $tab[0]);
		$query->setParameter('on', $tab[1]);
		$query->setParameter('nb', $tab[2]);
		return $query->getResult();
	}
	
	/**
	 * Affiche l'attrait et activité des provinces affichées
	 */
	public function getAfficheActiviteRechercherPourLesProvinces($tab, $cat)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id IN ( :qc, :on, :nb) AND p.categorie_attrait = :cat AND p.approuve = 1 AND p.actif = 1 GROUP BY p.categorie_attrait ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('qc', $tab[0]);
		$query->setParameter('on', $tab[1]);
		$query->setParameter('nb', $tab[2]);
		$query->setParameter('cat', $cat);
		return $query->getResult();
	}
	
	/**
	 * Tri pour récupérer juste les id categories attraits valides
	 */
	public function getAllIdCat()
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.categorie_attrait is not null GROUP BY p.categorie_attrait';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne tous les clients de cette région et de la même catégorie d'attraits
	 */
	public function getMemeRegionMemeCategory($reg, $cat, $page, $limit)
	{
		$paginator = ($page - 1)* $limit;
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :reg AND p.categorie_attrait = :cat AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('reg', $reg);
		$query->setParameter('cat', $cat);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne tous les clients de cette région et de la même catégorie d'attraits grouper par ville
	 */
	public function getMemeRegionMemeCategoryGroupByVille($reg, $cat)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :reg AND p.categorie_attrait = :cat AND p.approuve = 1 AND p.actif = 1 GROUP BY p.ville_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('reg', $reg);
		$query->setParameter('cat', $cat);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne tous les clients de cette région et de la même catégorie d'attraits et qui ont une relation avec un hébergement
	 */
	/*public function getMemeRegionMemeCategoryRelationAvecHebergement($reg, $cat)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :reg AND p.categorie_attrait = :cat AND p.hebergement_id is not null AND p.approuve = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('reg', $reg);
		$query->setParameter('cat', $cat);
		return $query->getResult();
	}*/
	
	/**
	 * Sélectionne tous les clients de cette région et de la même catégorie d'attraits et qui ont une relation avec un hébergement 
	 */
	public function getMemeRegionMemeCategoryRelationAvecHebergementAvecPagination($reg, $cat)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :reg AND p.categorie_attrait = :cat AND p.hebergement_id is not null AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('reg', $reg);
		$query->setParameter('cat', $cat);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne une catégorie d'attraits
	 */
	public function getSuggestionCategoriesAttraits($region, $tab)
	{
		
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :region  AND p.categorie_attrait =:cat GROUP BY p.categorie_attrait ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('region', $region);
		$query->setParameter('cat', $tab);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne toutes les activités de la province qui sont de même catégorie 
	 */
	public function getActiviteProvince($prov, $cat)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :prov  AND p.categorie_attrait =:cat GROUP BY p.region_id ORDER BY p.nom_fr ASC OR p.nom_en ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('prov', $prov);
		$query->setParameter('cat', $cat);
		return $query->getResult();
	}
	
	/**
	 * Tri par ville tous les clients de la même catégorie et de la même région
	 */
	public function getTriListeClientParVille($reg, $cat, $ville)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :reg AND p.categorie_attrait = :cat AND p.ville_id = :ville';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $cat);
		$query->setParameter('reg', $reg);
		$query->setParameter('ville', $ville);
		return $query->getResult();
	}
	
	/**
	 * Tri par cotation tous les clients de la même catégorie et de la même région 
	 */
	public function getTriListeClientParCotation($reg, $cat, $cotation)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :reg AND p.categorie_attrait = :cat AND p.cotation_id = :cotation';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $cat);
		$query->setParameter('reg', $reg);
		$query->setParameter('cotation', $cotation);
		return $query->getResult();
	}
	
	/**
	 * Compte le nombre de client de cette catégorie dans cette région 
	 */
	public function getCompteClientCategorie($reg, $cat)
	{
		$sql = 'SELECT COUNT(p.id) AS resultList FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :reg AND p.categorie_attrait = :cat AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $cat);
		$query->setParameter('reg', $reg);
		return $query->getResult();
	}

	/**
	 * Compte le nombre de client de cette catégorie dans cette ville
	 */
	public function getCompteClientCategorieVille($ville, $cat)
	{
		$sql = 'SELECT COUNT(p.id) AS resultList FROM MyAppMobileBundle:Attraits p WHERE p.ville_id = :ville AND p.categorie_attrait = :cat AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('cat', $cat);
		$query->setParameter('ville', $ville);
		return $query->getResult();
	}
	
	/**
	 * MÉTHODE POUR LA SECTION RESTAURANT
	 */
	
	/**
	 * Affiche les provinces qui ont des restaurants
	 */
	public function getAfficheProvincesPOurAttraitRestaurant($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :id AND p.categorie_attrait = 11 GROUP BY p.province_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne toutes les régions de la province qui ont des restaurants (11 = restaurant) et qui sont approuvées
	 */
	public function getAfficheRegionsPourAttraitRestaurant($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :id AND p.categorie_attrait = 11 AND p.approuve = 1 AND p.actif = 1 GROUP BY p.region_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne toutes les catégories de cuisines pour cette région
	 */
	public function getAfficheCategorieCuisineParRegion($region)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p INNER JOIN p.cuisine_id q WHERE p.region_id = :region ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('region', $region);
		return $query->getResult();
	}
	
	/**
	 * sélectionne toutes les catégories de cuisines disponibles pour cette province en français
	 */
	public function getAffichecategorieCuisineFRParProvince($tab)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p INNER JOIN p.cuisine_id q WHERE p.id IN (:tab) AND p.approuve = 1 AND p.actif = 1 GROUP BY q.nom_fr ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
	
	/**
	 * sélectionne toutes les catégories de cuisines disponibles pour cette province en anglais
	 */
	public function getAffichecategorieCuisineENParProvince($tab)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p INNER JOIN p.cuisine_id q WHERE p.id IN (:tab) AND p.approuve = 1 AND p.actif = 1 GROUP BY q.nom_en ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
	
	/**
	 * Affiche la province choisie pour les restaurants
	 */
	public function getSortProvinceCuisine($id)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p INNER JOIN p.cuisine_id q WHERE p.province_id = :id GROUP BY p.region_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Affiche 4 clients pour nos suggestions de restaurants
	 */
	public function getDisplay4restaurant($tab, $limit = 4)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.id IN (:id1, :id2, :id3, :id4) AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id1', $tab[0]);
		$query->setParameter('id2', $tab[1]);
		$query->setParameter('id3', $tab[2]);
		$query->setParameter('id4', $tab[3]);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	public function getDisplay3restaurant($tab, $limit = 4)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p INNER JOIN p.cuisine_id q WHERE p.id IN (:id1, :id2, :id3) AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id1', $tab[0]);
		$query->setParameter('id2', $tab[1]);
		$query->setParameter('id3', $tab[2]);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Compte les clients dans la région et qui sont de la catégorie recherchée
	 */
	public function getAfficheNombreDeClientPourLaregionAvecMemeCategorie($reg, $cat)
	{
		$sql = 'SELECT COUNT(p.id) AS nbresult FROM MyAppMobileBundle:Attraits p WHERE p.categorie_attrait = :cat AND p.region_id = :reg AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('reg', $reg);
		$query->setParameter('cat', $cat);
		return $query->getResult();
	}
	
	
	/**
	 * Récupère les restaurants de cette région
	 */
	public function getAfficheRestoPourLaRegion($reg, $cat)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.categorie_attrait = :cat AND p.region_id = :reg AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('reg', $reg);
		$query->setParameter('cat', $cat);
		return $query->getResult();
	}
	
	/**
	 * Récupère les restaurants de cette région et qui sont de ce type de cuisine
	 */
	public function getAfficheRestoPourLaRegionAvecCategorie($reg, $cuisine, $cat)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.cuisine_id q WHERE p.categorie_attrait = :cat AND p.region_id = :reg AND q.id = :cuisine AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('reg', $reg);
		$query->setParameter('cat', $cat);
		$query->setParameter('cuisine', $cuisine);
		return $query->getResult();
	}
	
	/**
	 * Recherche le client par son nom soit en français où en anglais
	 */
	public function getRechercheRestaurantMiniSite($name)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.nom_fr = :name OR p.nom_en = :name ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('name', $name);
		return $query->getResult();
	}
	
	/**
	 * Recherche les modes de paiements de l'attrait et ses spécialités culinaires
	 */
	public function getInfoComplementaire($id)
	{
		$sql = 'SELECT p, q, r, s, t, u FROM MyAppMobileBundle:Attraits p INNER JOIN p.paiement_id q INNER JOIN p.cuisine_id r INNER JOIN p.attrait_service_id s INNER JOIN p.lundi_matin_ete t INNER JOIN p.devise_id u WHERE p.id = :id AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Affiche la catégorie recherchée dans la ville
	 */
	public function getListeCategoriePourLaVilleRechercher($ville, $cat, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.ville_id = :ville AND p.categorie_attrait = :cat AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('ville', $ville);
		$query->setParameter('cat', $cat);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Affiche les restaurants qui ont cette spécialité pour la province
	 */
	public function getListeRestoPourLaProvince($id, $cat)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :id AND p.categorie_attrait = :cat AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('cat', $cat);
		return $query->getResult();
	}
	
	/**
	 * Recherche tous les restaurants qui ont cette spécialité dans la province
	 */
	public function getListeSpecialiteParProvince($specialite, $province)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.cuisine_id q WHERE p.categorie_attrait = 11 AND p.province_id = :province AND p.approuve = 1 AND p.actif = 1 AND q.id = :specialite GROUP BY p.province_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('specialite', $specialite);
		$query->setParameter('province', $province);
		return $query->getResult();
	}
	
	/**
	 * Recherche tous les restaurants qui ont cette spécialité dans les régions
	 */
	public function getListeSpecialiteParRegion($specialite, $province)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.cuisine_id q WHERE p.categorie_attrait = 11 AND p.province_id = :province AND p.approuve = 1 AND p.actif = 1 AND q.id = :specialite GROUP BY p.region_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('specialite', $specialite);
		$query->setParameter('province', $province);
		return $query->getResult();
	}
	
	/**
	 * MÉTHODE POUR LA SECTION CENTRE DE SANTÉ 
	 */
	
	/**
	 * Affiche la province qui a des types de soins
	 */
	public function getAfficheCategorieTypeSoinParProvince($province)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.province_id = :province AND p.categorie_attrait = 5 AND p.approuve = 1 AND p.actif = 1 GROUP BY p.province_id ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('province', $province);
		$query->setMaxResults(1);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne toutes les régions qui ont des types de soins
	 */
	public function getAfficheCategorieTypeSoinParRegion($id)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.soins_sante_id q WHERE p.province_id = :id AND q.id <> 126 AND p.categorie_attrait = 5 AND p.approuve = 1 AND p.actif = 1 GROUP BY p.region_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne tous les id des régions qui ont des centres de santé
	 */
	public function getCompteIdRegionPourCentreSante()
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.soins_sante_id q WHERE p.categorie_attrait = 5 AND q.id <> 126 AND p.approuve = 1 AND p.actif = 1 GROUP BY p.region_id';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne 5 clients pour nos suggestions de centres de santé
	 */
	public function getAffiche5ClientSuggestionSante($id, $limit = 5)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.soins_sante_id q WHERE p.region_id = :id AND q.id <> 126 AND p.categorie_attrait = 5 AND p.approuve = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne 5 clients pour nos suggestions de centres de santé
	 */
	public function getAffiche5ClientSuggestionTypeSoin($id, $soin)
	{
		$limit = 5;
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE p.region_id = :id AND p.categorie_attrait = 5 AND p.approuve = 1 AND p.actif = 1 AND q.id = :soin ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('soin', $soin);
		$query->setMaxResults($limit);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne toutes les régions qui ont le type de soin recherché
	 */
	public function getTypeSoinRechercheParProvince($id, $soin)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE p.province_id = :id AND q.id = :soin AND p.approuve = 1 AND p.actif = 1 GROUP BY p.region_id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('soin', $soin);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne toutes les villes de la région qui ont le type de soin recherché
	 */
	public function getTypeSoinRechercheParRegion($id, $soin, $page, $limit)
	{
		$tab = array();
		if($page == null and $limit == null)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE p.region_id = :id AND q.id = :soin AND p.approuve = 1 AND p.actif = 1 GROUP BY p.ville_id';
		}
		if($page != null and $limit != null)
		{
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE p.region_id = :id AND q.id = :soin AND p.approuve = 1 AND p.actif = 1 GROUP BY p.ville_id';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			$query->setParameter('soin', $soin);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			array_push($tab, $query->getResult());
			return $tab[0];
		}
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('soin', $soin);
		array_push($tab, $query->getResult());
		return $tab[0];
	}
	
	
	/**
	 * Sélectionne tous les clients de la ville qui ont le type de soin recherché
	 */
	public function getTypeSoinRechercheParVille($id, $soin, $page, $limit)
	{
		$tab = array();
		if($page == null and $limit == null)
		{
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE p.ville_id = :id AND q.id = :soin AND p.approuve = 1 AND p.actif = 1';
		}
		if($page != null and $limit != null)
		{
			$paginator = ($page - 1) * $limit;
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE p.ville_id = :id AND q.id = :soin AND p.approuve = 1 AND p.actif = 1';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter('id', $id);
			$query->setParameter('soin', $soin);
			$query->setFirstResult($paginator);
			$query->setMaxResults($limit);
			array_push($tab, $query->getResult());
			return $tab[0];
		}
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		$query->setParameter('soin', $soin);
		array_push($tab, $query->getResult());
		return $tab[0];
	}
	
	/**
	 * Recherche l'id de l'attrait par son repertoire fr ou en
	 */
	public function getNameAttrait($searchword)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.repertoire_fr = :nom OR p.repertoire_en = :nom';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('nom', $searchword);
		return $query->getResult();
	}
	
	/**
	 * Retourne les informations de l'attraits par son repertoire et son id
	 */
	public function getRetourneInformationAttrait($id, $searchword)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.id =:id AND p.repertoire_fr = :nom OR p.repertoire_en = :nom';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('nom', $searchword);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/***********************************************************************************
	 * 				MINI SITE DES CLIENTS
	 **********************************************************************************/

	/**
	 * Récupère l'attrait par son id
	 */
	public function getSearchAttraitById($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
    /**
     * Récupère l'attrait ou les attraits de l'hébergement
     */
    public function getHebergementByAttrait($id)
    {
        $sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.hebergement_id = :id';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter('id', $id);
        return $query->getResult();
    }
    
    /**
     * Récupère l'attrait ou les attraits de l'hébergement et qui sont en relation avec des soins de santé
     */
    public function getHebergementByAttraitRelationSoins($id)
    {
    	$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.soins_sante_id q WHERE p.hebergement_id = :id';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setParameter('id', $id);
    	return $query->getResult();
    }
    
    /**
     * Récupère les attraits de l'utilisateur qui sont en relation avec des soins de santé
     */
    public function getUtilisateurByAttraitRelationSoins($id)
    {
    	$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.soins_sante_id q WHERE p.utilisateur = :id';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setParameter('id', $id);
    	if($query->getResult() == null){
    		$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.utilisateur = :id';
    		$query = $this->getEntityManager()->createQuery($sql);
    		$query->setParameter('id', $id);
    	}
    	return $query->getResult();
    }
    
    /**
     * Récupère l'attrait en relation avec des soins de santé
     */
    public function getAttraitRelationSoins($id)
    {
    	$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.soins_sante_id q WHERE p.id = :id';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setParameter('id', $id);
    	return $query->getResult();
    }
	
	/***********************************************************************************
	 * 				Fonctions pour le moteur de recherche section CLIENT
	 ***********************************************************************************/
	
    /**
     * Pagination pour les hébergements tableau de bord section client trier par région
     *
     * @ORM\PostLoad()
     */
    public function getAdminAttraitTriRegion($page, $limit, $region )
    {
    	$paginator = ($page - 1) * $limit;
    	$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :region ORDER BY p.nom_fr ASC';
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
    public function getAdminAttraitTriZone($page, $limit, $zone )
    {
    	$paginator = ($page - 1) * $limit;
    	$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.zone_id = :zone ORDER BY p.nom_fr ASC';
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
    public function getAdminAttraitTriVille($page, $limit, $ville )
    {
    	$paginator = ($page - 1) * $limit;
    	$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.ville_id = :ville ORDER BY p.nom_fr ASC';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setFirstResult($paginator);
    	$query->setMaxResults($limit);
    	$query->setParameter('ville', $ville);
    	return $query->getResult();
    }
    
    /**
     * Recherche les attraits qui ont le status actif
     */
    public function getAdminAttraitActif($page, $limit, $actif)
    {
    	$paginator = ($page - 1) * $limit;
    	$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.actif = :actif ORDER BY p.nom_fr ASC';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setFirstResult($paginator);
    	$query->setMaxResults($limit);
    	$query->setParameter('actif', $actif);
    	return $query->getResult();
    }
    
    /**
     * Recherche les attraits qui ont le status inactif
     */
    public function getAdminAttraitInActif($page, $limit, $inactif)
    {
    	$paginator = ($page - 1) * $limit;
    	$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.actif = :inactif ORDER BY p.nom_fr ASC';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setFirstResult($paginator);
    	$query->setMaxResults($limit);
    	$query->setParameter('inactif', $inactif);
    	return $query->getResult();
    }
    
    /**
     * Recherche les attraits qui commencent par cette lettre alphabétique
     */
    public function getClientByFirstLetter($page, $limit, $lettre)
    {
    	$paginator = ($page - 1) * $limit;
    	$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.nom_fr LIKE :lettre  ORDER BY p.nom_fr ASC';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setFirstResult($paginator);
    	$query->setMaxResults($limit);
    	$query->setParameter('lettre', $lettre.'%');
    	return $query->getResult();
    }
    
    /**
     * Compte le nombre d'attrait qui sont actifs
     */
    public function getCompteAttraitActif()
    {
    	$sql = 'SELECT COUNT(p.id) AS nbAttrait FROM MyAppMobileBundle:Attraits p WHERE p.actif = 1';
    	$query = $this->getEntityManager()->createQuery($sql);
    	return $query->getResult();
    }
    
    /**
     * Compte le nombre d'attrait qui sont inactifs
     */
    public function getCompteAttraitInActif()
    {
    	$sql = 'SELECT COUNT(p.id) AS nbAttrait FROM MyAppMobileBundle:Attraits p WHERE p.actif = 0';
    	$query = $this->getEntityManager()->createQuery($sql);
    	return $query->getResult();
    }
    
    /**
     * Compte le nombre d'attrait qui sont de cette région
     */
    public function getCompteAttraitRegionSectionClient($region)
    {
    	$sql = 'SELECT COUNT(p.id) AS nbAttrait FROM MyAppMobileBundle:Attraits p WHERE p.region_id = :region';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setParameter('region', $region);
    	return $query->getResult();
    }
    
    /**
     * Compte le nombre d'attrait qui sont de cette zone
     */
    public function getCompteAttraitZoneSectionClient($zone)
    {
    	$sql = 'SELECT COUNT(p.id) AS nbAttrait FROM MyAppMobileBundle:Attraits p WHERE p.zone_id = :zone';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setParameter('zone', $zone);
    	return $query->getResult();
    }
    
    /**
     * Compte le nombre d'attrait qui sont de cette ville
     */
    public function getCompteAttraitVilleSectionClient($ville)
    {
    	$sql = 'SELECT COUNT(p.id) AS nbAttrait FROM MyAppMobileBundle:Attraits p WHERE p.ville_id = :ville';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setParameter('ville', $ville);
    	return $query->getResult();
    }
    
    /**
     * Compte le nombre d'attrait qui ont le nom qui commence par cette lettre
     */
    public function getCompteAttraitLettreSectionClient($word)
    {
    	$sql = 'SELECT COUNT(p.id) AS nbAttrait FROM MyAppMobileBundle:Attraits p WHERE p.nom_fr LIKE :word';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setParameter('word', $word.'%');
    	return $query->getResult();
    }
    
    /**
     * Retourne tous les champs de la table Attraits_services
     */
    public function getAfficheChampsAttraitService()
    {
    	$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.attrait_service_id q ORDER BY q.nom_fr ASC';
    	$query = $this->getEntityManager()->createQuery($sql);
    	return $query->getResult();
    }
    
    /**
     * Affiche la catégorie de l'attrait
     */
    public function getRechercheCategorieAttraitMiniSite($client)
    {
    	$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.id = :client AND p.approuve = 1 AND p.actif = 1';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setParameter('client', $client);
    	return $query->getResult();
    }
    
    /**
     * Affiche la catégorie de l'attrait
     */
    public function getRechercheLesSoinsMiniSite($client)
    {
    	$sql = 'SELECT p, q, r FROM MyAppMobileBundle:Attraits p JOIN p.soins_sante_id q JOIN p.type_soins_id r  WHERE p.id = :client AND p.approuve = 1 AND p.actif = 1';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setParameter('client', $client);
    	return $query->getResult();
    }
    
    /**
     * Fonction pour afficher les provinces sur la section d'accueil du portail
     */
    public function getAfficheProvinceAccueil($id, $limit = 1)
    {
    	$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.approuve = 1 AND p.actif = 1 AND p.province_id = :id';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setParameter('id', $id);
    	$query->setMaxResults($limit);
    	return $query->getResult();
    }
    
    /**
     * Fonction pour afficher les régions sur la section d'accueil du portail
     */
    public function getAfficheRegionAccueil($id)
    {
    	$sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.approuve = 1 AND p.actif = 1 AND p.province_id = :id GROUP BY p.region_id';
    	$query = $this->getEntityManager()->createQuery($sql);
    	$query->setParameter('id', $id);
    	return $query->getResult();
    }
    
    /**
     * Retourner le dernier id
     */
    public function getRetourneDernierId()
    {
    	$sql = 'SELECT MAX(p.id) AS lastid FROM MyAppMobileBundle:Attraits p ';
    	$query = $this->getEntityManager()->createQuery($sql);
    	return $query->getResult();
    }
    
    public function getRetourneAttraitAvecIdUtilisateur($id)
    {
        $sql = 'SELECT p FROM MyAppMobileBundle:Attraits p WHERE p.utilisateur = :id';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter('id', $id);
        return $query->getResult();
    }
    
   
}