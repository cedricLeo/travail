<?php
namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

class Attraits_sous_categorieRepository extends EntityRepository{
	
	/**
	 * Affiche la liste des sous catégories attraits rangée par ordre alphabétique
	 */
	public function getListAttraitSousCategorie()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Attraits_sous_categories p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}

	/**
	 * Recherche les sous catégories qui appartiennent à la catégorie
	 */
	public function getRechercheEnfantCategorieAttrait($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Attraits_sous_categories p WHERE p.categorie_id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
}