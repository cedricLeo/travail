<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

class Attraits_categoriesRepository extends EntityRepository{
	
	/**
	 * Affiche la liste des catégories pour les attraits et activités rangée par ordre alphabétique
	 */
	public function getListAttraitCategorie()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Attraits_categories p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'id de la catégorie par son nom pour le moteur de recherche dans l'admin
	 */
	public function getSearchIdCatByName($word)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppGlobalBundle:Attraits_categories p WHERE p.nom_fr =:word OR p.nom_en =:word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $word);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'id de la catégorie par son nom coté portail
	 */
	public function getRechercheIdCategorieParSonNom($word)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Attraits_categories p WHERE p.nom_fr =:word OR p.nom_en =:word';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('word', $word);
		return $query->getResult();
	}
	
	/**
	 * Recherche les catégories attraits par leurs id
	 */
	public function getRechercheIdCategorie($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Attraits p WHERE p.categorie_attrait = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
}