<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 *
 */
class Categories_hebergementsRepository extends EntityRepository
{
	
	/**
	 * Affiche la liste des catégories d'hébergements
	 */
	public function getListCategoryHebergement()
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.image FROM MyAppGlobalBundle:Categories_hebergements p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Affiche la liste des catégories d'hébergement coté client mais sans l'id 1 qui a pour valeur non défini
	 */
	public function getChoiceCategoryHebergement()
	{
		$sql = 'SELECT q FROM MyAppGlobalBundle:Categories_hebergements q WHERE q.id <> 1';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Récupère l'id pour le type d'hébergement.
	 */
	public function getIdHebergement($name)
	{
		$sql = 'SELECT q FROM MyAppGlobalBundle:Categories_hebergements q WHERE q.nom_fr = :name';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('name', $name);
		return $query->getResult();
	}
	
	/**
	 * Récupère l'id du type d'hébergement par son nom.
	 */
	public function getRechercheIdCategorieHebergement($name)
	{
		$sql = 'SELECT q.id, q.nom_fr, q.nom_en, q.repertoire_fr, q.repertoire_en, q.texte_fr, q.texte_en, q.page_titre_fr, q.page_titre_en, q.page_metadescription_fr, q.page_metadescription_en '.
                       'FROM MyAppGlobalBundle:Categories_hebergements q WHERE q.nom_fr = :name OR q.nom_en = :name OR q.repertoire_fr =:name OR q.repertoire_en =:name';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('name', $name);
		return $query->getResult();
	}
	
	/**
	 * Récupère les clients de cette province que l'on groupe par catégorie d'hébergement.
	 */
	public function getGrouperIdCategorieHebergement($province, $tab)
	{
		$sql = 'SELECT p, q FROM MyAppGlobalBundle:Hebergements p JOIN p.categorie_hebergement_id q WHERE p.province_id = :province AND p.aprouver = 1 AND q.id = :tab';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('province', $province);
		$query->setParameter('tab', $tab);
		return $query->getResult();
	}
	
        /**
         * Recherche une catégorie d'hébergement par son id
         */
        public function getRechercheCategorieHebergementParId($id)
        {
                $sql = 'SELECT q.repertoire_fr, q.repertoire_en FROM MyAppGlobalBundle:Categories_hebergements q WHERE q.id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
        }        
       
}