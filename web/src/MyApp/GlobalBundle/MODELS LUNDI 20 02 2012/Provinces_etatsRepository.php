<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

class Provinces_etatsRepository extends EntityRepository{
	
	//Affiche les provinces
	public function getProvinces($id)
	{	
		$id0 = strip_tags($id);
		(is_numeric($id0) == 1)? $id1 = $id0 : $id0 = null;
		$sql = 'SELECT p FROM MyAppGlobalBundle:Provinces_etats p WHERE p.id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id1);
		return $query->getResult();
	}
	
	//Affiche les régions
	public function getRegions($id)
	{	
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.idprovinceetat = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	//Affiche les suggestions de destinations touristiques pour les pages destination 
	public function getSuggestionsDestinationTouristique()
	{	
		//Compte le nombre de region dans la table et retourne le nombre de id.
		$em = $this->getDoctrine()->getEntityManager();
		$region = $em->getRepository('MyAppGlobalBundle:Hebergements')->getCompteRegion();
		 foreach($region as $nb){
		$nb['nbth'];
		}
		$qc = $nb['nbth'];
		$a = 1; 
		//Sélectionne aléatoirement 4 régions
		$region1 = rand($a, $qc);
		$region2 = rand($a, $qc);
		$region3 = rand($a, $qc);
		$region4 = rand($a, $qc);
		
		//stockage statique dans un tableau des id region pour travailler pour le moment juste sur les régions des provinces Québec , Ontario et nouveau Brunswick.
		$tabregion = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,41,42,43,44,45,46); 
		if(!in_array($region1, $tabregion)){
			$region1 = rand($a, $qc);
			echo 'test1';
		}
		if(!in_array($region2, $tabregion)){
			$region2 = rand($a, $qc);
			echo 'test2';
		}
		if(!in_array($region3, $tabregion)){
			$region3 = rand($a, $qc);
			echo 'test3';
		}
		if(!in_array($region4, $tabregion)){
			$region4 = rand($a, $qc);
			echo 'test4';
		}
		
		//Contrôle si chaque nombre aléatoire ne se trouve pas en double.
		if($region2 == $region1){
			$region2 = rand($a, $qc);
			//echo 'test1';
		}
		if($region3 == $region1){
			$region3 = rand($a, $qc);
			//echo 'test2';
		}
		if($region4 == $region1){
			$region4 = rand($a, $qc);
			//echo 'test3';
		}
		if($region3 == $region2){
			$region3 = rand($a, $qc);
			//echo 'test4';
		}
		if($region4 == $region2){
			$region4 = rand($a, $qc);
			//echo 'test5';
		}
		if($region4 == $region3){
			$region4 = rand($a, $qc);
			//echo 'test6';
		}
		
		$displayRegion1 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getRegionAleatoire($region1);
		$displayRegion2 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getRegionAleatoire($region2);
		$displayRegion3 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getRegionAleatoire($region3);
		$displayRegion4 = $em->getRepository('MyAppGlobalBundle:Hebergements')->getRegionAleatoire($region4);
		return;
		
	}
	
	//Récupère les infos des provinces.
	public function getAdminProvinces()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Provinces_etats p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	//Récupère les infos des régions.
	public function getAdminRegions()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	//Récupère les infos des provinces pour le pays sélectionné.
	public function getAdminProvincesByIdPays($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Provinces_etats p WHERE p.pays_id =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	//Récupère les infos des régions pour la province sélectionnée.
	public function getAdminRegionByIdProvince($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.province_etat_id =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	//Récupère les info sur la région.
	public function getAdminRegionById($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regions p WHERE p.id =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
}