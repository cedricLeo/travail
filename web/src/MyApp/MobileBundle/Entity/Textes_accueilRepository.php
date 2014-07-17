<?php
namespace MyApp\MobileBundle\Entity;

use Doctrine\ORM\EntityRepository;

class Textes_accueilRepository extends EntityRepository{

	/**
	 * Liste tous les textes d'accueil de chaques sections du site
	 */
	public function getListTexteAccueil($identifiant)
	{
		if($identifiant == "accueil")
		{
			$sql = 'SELECT p.id, p.texte_accueil_fr, q.texte_accueil_meta_fr, q.titre_accueil_fr FROM MyAppMobileBundle:Textes_accueil p JOIN p.texte_complementaire q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		if($identifiant == "accueil_en")
		{
			$sql = 'SELECT p.id, p.texte_accueil_en, q.texte_accueil_meta_en, q.titre_accueil_en FROM MyAppMobileBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "hebergement")
		{
			$sql = 'SELECT p.id, p.texte_accueil_hebergement_fr, q.titre_hebergement_fr, q.texte_accueil_hebergement_meta_fr FROM MyAppMobileBundle:Textes_accueil p JOIN p.texte_complementaire q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "hebergement_en")
		{
			$sql = 'SELECT p.id, p.texte_accueil_hebergement_en, q.titre_hebergement_en, q.texte_accueil_hebergement_meta_en FROM MyAppMobileBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "forfait")
		{
			$sql = 'SELECT p.id, p.texte_accueil_forfait_fr, q.titre_forfait_fr, q.texte_accueil_forfait_meta_fr FROM MyAppMobileBundle:Textes_accueil p JOIN p.texte_complementaire q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "forfait_en")
		{
			$sql = 'SELECT p.id,  p.texte_accueil_forfait_en, q.titre_forfait_en, q.texte_accueil_forfait_meta_en FROM MyAppMobileBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "corporatif")
		{
			$sql = 'SELECT p.id, p.texte_accueil_corporatif_fr, q.titre_corporatif_fr, q.texte_accueil_corporatif_meta_fr FROM MyAppMobileBundle:Textes_accueil p JOIN p.texte_complementaire q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "corporatif_en")
		{
			$sql = 'SELECT p.id, p.texte_accueil_corporatif_en, q.titre_corporatif_en, q.texte_accueil_corporatif_meta_en FROM MyAppMobileBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "sante")
		{
			$sql = 'SELECT p.id, p.texte_accueil_sante_fr, q.titre_sante_fr, q.texte_accueil_sante_meta_fr FROM MyAppMobileBundle:Textes_accueil p JOIN p.texte_complementaire q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "sante_en")
		{
			$sql = 'SELECT p.id, p.texte_accueil_sante_en, q.titre_sante_en, q.texte_accueil_sante_meta_en FROM MyAppMobileBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "attrait")
		{
			$sql = 'SELECT p.id, p.texte_accueil_attrait_fr, q.titre_attrait_fr, q.texte_accueil_attrait_meta_fr FROM MyAppMobileBundle:Textes_accueil p JOIN p.texte_complementaire q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "attrait_en")
		{
			$sql = 'SELECT p.id, p.texte_accueil_attrait_en, q.titre_attrait_en, q.texte_accueil_attrait_meta_en FROM MyAppMobileBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "promotion")
		{
			$sql = 'SELECT p.id, p.texte_accueil_promotion_fr, q.titre_promotion_fr, q.texte_accueil_promotion_meta_fr FROM MyAppMobileBundle:Textes_accueil p JOIN p.texte_complementaire q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "promotion_en")
		{
			$sql = 'SELECT p.id, p.texte_accueil_promotion_en, q.titre_promotion_en, q.texte_accueil_promotion_meta_en FROM MyAppMobileBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "restaurant")
		{
			$sql = 'SELECT p.id, p.texte_accueil_restaurant_fr, q.titre_restaurant_fr, q.texte_accueil_restaurant_meta_fr FROM MyAppMobileBundle:Textes_accueil p JOIN p.texte_complementaire q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		elseif($identifiant == "restaurant_en")
		{
			$sql = 'SELECT p.id, p.texte_accueil_restaurant_en, q.titre_restaurant_en, q.texte_accueil_restaurant_meta_en FROM MyAppMobileBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
			$query = $this->getEntityManager()->createQuery($sql);
		}
		return $query->getResult();
	}

	public function getSearchTexteForfait($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Textes_accueil p WHERE p.forfait2 =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}

}