<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author leonardc
 * 
 *Méthodes pour les forfaits.
 */
class ForfaitRepository extends EntityRepository{
	
	/**
	* Affiche la liste des forfaits trier par ordre alphabétique FR
	*/
	public function getForfaitAlphabetiqueFR()
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Forfaits p WHERE p.id <> 1 ORDER BY p.nom_fr ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Affiche la liste des forfaits trier par ordre alphabétique EN
	 */
	public function getForfaitAlphabetiqueEN()
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Forfaits p WHERE p.id <> 1 ORDER BY p.nom_en ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Recherche l'id du forfait avec son nom
	 */
	public function getRechercheIdForfait($name)
	{
		$sql = 'SELECT p.id, p.nom_fr, p.nom_en, p.repertoire_fr, p.repertoire_en, p.meta_titre_fr, p.meta_titre_en, p.page_metadescription_fr, p.page_metadescription_en, p.texte_fr, p.texte_en '.
                        'FROM MyAppMobileBundle:Forfaits p WHERE p.nom_fr = :nom OR p.nom_en = :nom  OR p.repertoire_fr =:nom OR p.repertoire_en =:nom';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setparameter('nom', $name);
		return $query->getResult();
	}
        
  
	
}