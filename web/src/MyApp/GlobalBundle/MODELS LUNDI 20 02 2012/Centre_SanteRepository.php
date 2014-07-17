<?php
namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CentreSanteRepository extends EntityRepository{
	
	public function __destruct(){}
	
	
	// Affiche les provinces pour les soins
	public function getProvinces($id)
	{
		$id0 = strip_tags($id);
		(is_numeric($id0) == 1)? $id1 = $id0 : $id0 = null;
		$sql = 'SELECT p FROM MyAppGlobalBundle:Provincesetats p WHERE p.id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id1);
		return $query->getResult();
		//$gb = CentreSanteRepository::__destruct($query);
	}
	
	 //Affiche les régions des provinces pour les soins
	public function getRegions($id)
	{
		$id0 = strip_tags($id);
		(is_numeric($id0) == 1)? $id1 = $id0 : $id0 = null;
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regionstouristiques p WHERE p.idprovinceetat = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id1);
		return $query->getResult();
		
	}
	
	//Affiche les types de soin pour le secteur
	public function getTypesoinparville($id)
	{	
		$sql = 'SELECT p, q FROM MyAppGlobalBundle:Villes p 
				INNER JOIN p.soins_id q 
				WHERE p.regions_touristiques_id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id' , $id);
		return $query->getResult();
	}
	
	//Affiche les villes qui ont des centres de santé
	public function getDisplaycenterByTown($id)
	{
		$sql = 'SELECT q, r FROM MyAppGlobalBundle:Regionstouristiques q
				INNER JOIN q.typessoins_id r
				WHERE q.idprovinceetat = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	//Affiche les régions qui ont le type de soin sélectionner.
	public function getSelectTypeSoin($id)
	{	
		//$region = filter_input(INPUT_GET, 'id1', FILTER_SANITIZE_NUMBER_INT);
		//$soin = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

		$sql = 'SELECT q, r FROM MyAppGlobalBundle:Regionstouristiques q
				INNER JOIN q.typessoins_id r
				WHERE r.idtypesoinsante = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	//Affiche une région avec le type de soin recherché.
	public function getSelectRegionSoin($region, $soin)
	{
		$sql = 'SELECT q, r FROM MyAppGlobalBundle:Regionstouristiques q
		INNER JOIN q.typessoins_id r
		WHERE r.idtypesoinsante = :soin AND q.id =:regon';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('soin', $soin);
		$query->setparameter('region', $region);
		return $query->getResult();
	}
	
	//Compte le nombre de Type de soin.
	public function getSuggestionColonneGauche()
	{
		$dql = 'SELECT q, COUNT(q.id) AS nbtypess FROM MyAppGlobalBundle:Typessoinssante q';
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
		$gb = new CentreSanteRepository();
		$gb->__destruct($query);
	}
	
	//Affiche les suggestions de type de soin pour la colonne de gauche.
	public function getTypeSoinAleatoire($id)
	{
		$dql = 'SELECT q FROM MyAppGlobalBundle:Typessoinssante q WHERE q.id =:id';
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('id', $id);
		return $query->getResult();
		$gb = new CentreSanteRepository();
		$gb->__destruct($query);
	}
	
	//Récupère l'id du type de soin.
	public function getIdTypeSoin($name)
	{
		$dql = 'SELECT q FROM MyAppGlobalBundle:Typessoinssante q WHERE q.nomfr =:name';
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('name', $name);
		return $query->getResult();
		$gb = new CentreSanteRepository();
		$gb->__destruct($query);
	}
	
	//Affiche les provinces pour le type de soin choisit.
	public function getDisplayProvinceForSoin($soin, $province)
	{
		$dql = 'SELECT q, s FROM MyAppGlobalBundle:Provincesetats q INNER JOIN q.typesoinsante_id s  WHERE q.id =:province AND s.id =:soin';
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('soin', $soin);
		$query->setParameter('province', $province);
		return $query->getResult();
		$gb = new CentreSanteRepository();
		$gb->__destruct($query);
	}
	
	//Affiche les régions pour le type de soin choisit.
	public function getDisplayRegionForSoin($soin, $region)
	{
		$dql = 'SELECT q, s FROM MyAppGlobalBundle:Regionstouristiques q INNER JOIN q.typesoinsante_id s  WHERE q.idprovinceetat =:region AND s.id =:soin';
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('soin', $soin);
		$query->setParameter('region', $region);
		return $query->getResult();
		$gb = new CentreSanteRepository();
		$gb->__destruct($query);
	}
	

}