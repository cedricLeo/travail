<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class Types_soins_santeRepository extends EntityRepository{

	/**
	 * Méthode pour lister les types de soin
	 */
	public function getListTypeSoin()
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en FROM MyAppMobileBundle:Types_soins_sante p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Méthode qui recherche les clients qui sont de cette région est qui offrent des soins
	 */
	public function getListTypeSoinPourLaRegion($region)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE p.region_id = :region AND q.id <> 126 AND p.approuve = 1 AND p.actif = 1 GROUP BY q.id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter("region", $region);
		return $query->getResult();
	}
	
	/**
	 * Méthode qui recherche les clients qui sont de cette province est qui offrent des soins
	 */
	public function getListTypeSoinPourLaProvince($province)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE p.province_id = :province AND q.id <> 126 AND p.approuve = 1 AND p.actif = 1 GROUP BY q.id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter("province", $province);
		return $query->getResult();
	}

	/**
	 * Méthode qui recherche les clients qui sont de cette ville est qui offrent des soins
	 */
	public function getListTypeSoinPourLaVille($ville)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE p.ville_id = :ville AND q.id <> 126 AND p.approuve = 1 AND p.actif = 1 GROUP BY q.id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter("ville", $ville);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'id du type de soin par son nom 
	 */
	public function getSearchIdByName($nom)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Types_soins_sante p WHERE p.nom_fr = :nom or p.nom_en = :nom';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter("nom", $nom);
		return $query->getResult();
	}
	
	/**
	 * Sélectionne tous les attraits qui ont le type de soin recherché.
	 */
	public function getRechercheTypeSoinPourPartout($soin)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE q.id = :soin';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter("soin", $soin);
		return $query->getResult();
	}
	
	/**
	 * Retourne un tableau qui aura juste les nouveaux types de soins
	 */
	public function getReturnTableauTypeSoin($tab, $id)
	{
		$tablo = array();
		for($i = 0; $i < count($tab); $i++){
			$sql = 'SELECT p, q FROM MyAppMobileBundle:Attraits p JOIN p.type_soins_id q WHERE p.id = :id AND q.id = :soin';
			$query = $this->getEntityManager()->createQuery($sql);
			$query->setParameter("soin", $tab[$i]);
			$query->setParameter("id", $id);
			if($query->getResult() == null){
				array_push($tablo, $tab[$i]);
			}
		}
		return $tablo = array_unique($tablo);
	}
}
