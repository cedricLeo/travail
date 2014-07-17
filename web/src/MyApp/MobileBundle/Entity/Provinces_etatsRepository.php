<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class Provinces_etatsRepository extends EntityRepository{
	
	/**
	 * Affiche la province recherchée
	 */
	public function getProvinces($id)
	{	
		
		$sql = 'SELECT p FROM MyAppMobileBundle:Provinces_etats p WHERE p.id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Récupère les infos des provinces.
	 */
	public function getAdminProvinces()
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.reservit_id, p.repertoire_fr, p.repertoire_en FROM MyAppMobileBundle:Provinces_etats p WHERE p.affiche = 1 AND p.reservit_id <> 0';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Récupère les infos des provinces pour le pays sélectionné.
	 */
	public function getAdminProvincesByIdPays($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Provinces_etats p WHERE p.pays_id =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'id de la province par son nom passé en URL
	 */
	public function getSearchIdByName($prov)
	{

		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Provinces_etats p WHERE p.repertoire_fr = :nom OR p.repertoire_en = :nom';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('nom', $prov);
		return $query->getSingleResult();           
	}
	
	/**
	 * Retourne la liste des provinces qui sont dans réservit
	 */
	public function getRetourneListeProvinceReservit($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Provinces_etats p WHERE p.pays_id =:id AND p.reservit_id is not null AND p.reservit_id <> 0 AND p.affiche = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'id de la province par son id de reservit
	 */
	public function getSearchIdByReservitId($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Provinces_etats p WHERE p.reservit_id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
        
        /**
	 * Retourne la liste des id des provinces
	 */
	public function getRetourneListeIdProvince()
	{
		$sql = 'SELECT p.id FROM MyAppMobileBundle:Provinces_etats p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
}