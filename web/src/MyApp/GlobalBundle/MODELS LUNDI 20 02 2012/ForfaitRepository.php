<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

class ForfaitRepository extends EntityRepository{
	
	public function getForfaitForTown($id)
	{
		$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );
		$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
	}
	
	//Affiche la liste des forfaits
	public function getTypeForfait()
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Typesforfaits p WHERE p.defaultforfait <> 1 ORDER BY p.nomfr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	//Affiche la liste des forfaits de la région
	public function getTypeForfaitRegion($id)
	{
		$sql = 'SELECT p, q FROM MyAppGlobalBundle:Regionstouristiques p INNER JOIN p.typeforfaits_id q WHERE p.id = :id ORDER BY p.nomfr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setparameter('id', $id);
		return $query->getResult();
	}
	
	//Récupère le nombre de categorie
	public function getCountCategory()
	{
		$sql = 'SELECT p, COUNT(p.id) AS nbcat FROM MyAppGlobalBundle:Typesforfaits p WHERE p.defaultforfait <> 1';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	//Affiche la liste des villes de la région pour le forfait choisi.
	public function getListTown($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Villes p WHERE p.regions_touristiques_id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	//Affiche la liste des villes de la région pour la colonne de gauche.
	public function getListeVilleDelaRegion($region)
	{
		$sql = 'SELECT p, q FROM MyAppGlobalBundle:Villes p INNER JOIN p.soins_id  q WHERE p.regions_touristiques_id = :region ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('region', $region);
		return $query->getResult();
	}
	
	//Affiche les villes en bas de page pour les suggestions.
	public function getTowsSuggestion($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regionstouristiques p WHERE p.id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	//Affiche un forfait aléatoire.
	public function getForfaitRand($f1)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Typesforfaits p WHERE p.id =:f1 ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('f1', $f1);
		return $query->getResult();
	}
	
	//Affiche 5 forfaits de client aléatoire.
	public function getCount5forfaitsClient($f1, $f2, $f3, $f4, $f5)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Typesforfaits p WHERE p.id IN( :f1, :f2, :f3, :f4, :f5 )';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('f1', $f1);
		$query->setParameter('f2', $f2);
		$query->setParameter('f3', $f3);
		$query->setParameter('f4', $f4);
		$query->setParameter('f5', $f5);
		return $query->getResult();
	}
	
	//Affiche tous les forfaits pour la catégorie choisie.
	public function getTypesoinVille($region, $soin)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Regionstouristiques p WHERE p.id = :r ';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setparameter('r', $region);
		return $query->getResult();
	}
	
}