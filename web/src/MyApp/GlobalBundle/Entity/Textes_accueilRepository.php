<?php
namespace MyApp\GlobalBundle\Entity;

use Doctrine\ORM\EntityRepository;

class Textes_accueilRepository extends EntityRepository{

        /**
	 * Recherche le texte d'accueil fr pour la section accueil du portail
	 */
	public function getListTexteAccueilPortail()
	{
		$sql = 'SELECT p.texte_accueil_fr, q.texte_accueil_meta_fr, q.titre_accueil_fr FROM MyAppGlobalBundle:Textes_accueil p JOIN p.texte_complementaire q';
		$query = $this->getEntityManager()->createQuery($sql);		
                return $query->getResult();
        }
        
         /**
	 * Recherche le texte d'accueil en pour la section accueil du portail
	 */
	public function getListTexteAccueilPortailEn()
	{	
		$sql = 'SELECT p.texte_accueil_en, q.texte_accueil_meta_en, q.titre_accueil_en FROM MyAppGlobalBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
		$query = $this->getEntityManager()->createQuery($sql);		
                return $query->getResult();
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section hébergement du portail
	 */
	public function getListTexteAccueilHebergement()
	{
		$sql = 'SELECT p.texte_accueil_hebergement_fr, q.titre_hebergement_fr, q.texte_accueil_hebergement_meta_fr FROM MyAppGlobalBundle:Textes_accueil p JOIN p.texte_complementaire q';
		$query = $this->getEntityManager()->createQuery($sql);	
                return $query->getResult();
        }
                      
        /**
	 * Recherche le texte d'accueil en pour la section hébergement du portail
	 */
	public function getListTexteAccueilHebergementen()
	{		
		$sql = 'SELECT p.texte_accueil_hebergement_en, q.titre_hebergement_en, q.texte_accueil_hebergement_meta_en FROM MyAppGlobalBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
		$query = $this->getEntityManager()->createQuery($sql);		
                return $query->getResult();
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section forfait du portail
	 */
	public function getListTexteAccueilForfait()
	{

                $sql = 'SELECT p.texte_accueil_forfait_fr, q.titre_forfait_fr, q.texte_accueil_forfait_meta_fr FROM MyAppGlobalBundle:Textes_accueil p JOIN p.texte_complementaire q';
                $query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section forfait du portail
	 */
	public function getListTexteAccueilForfaiten()
	{
                $sql = 'SELECT p.texte_accueil_forfait_en, q.titre_forfait_en, q.texte_accueil_forfait_meta_en FROM MyAppGlobalBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
                $query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section corporatif du portail
	 */
	public function getListTexteAccueilCorporatif()
	{
		
		$sql = 'SELECT p.texte_accueil_corporatif_fr, q.titre_corporatif_fr, q.texte_accueil_corporatif_meta_fr FROM MyAppGlobalBundle:Textes_accueil p JOIN p.texte_complementaire q';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section corporatif du portail
	 */
	public function getListTexteAccueilCorporatifen()
	{		
		$sql = 'SELECT p.id, p.texte_accueil_corporatif_en, q.titre_corporatif_en, q.texte_accueil_corporatif_meta_en FROM MyAppGlobalBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
		$query = $this->getEntityManager()->createQuery($sql);
                return $query->getResult();		
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section corporatif du portail
	 */
	public function getListTexteAccueilPromotion()
	{
		
		$sql = 'SELECT p.texte_accueil_promotion_fr, q.titre_promotion_fr, q.texte_accueil_promotion_meta_fr FROM MyAppGlobalBundle:Textes_accueil p JOIN p.texte_complementaire q';
                $query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section corporatif du portail
	 */
	public function getListTexteAccueilPromotionen()
	{		
		$sql = 'SELECT p.texte_accueil_promotion_en, q.titre_promotion_en, q.texte_accueil_promotion_meta_en FROM MyAppGlobalBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
		$query = $this->getEntityManager()->createQuery($sql);
                return $query->getResult();		
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section corporatif du portail
	 */
	public function getListTexteAccueilSante()
	{
		
		$sql = 'SELECT p.texte_accueil_sante_fr, q.titre_sante_fr, q.texte_accueil_sante_meta_fr FROM MyAppGlobalBundle:Textes_accueil p JOIN p.texte_complementaire q';
                $query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section corporatif du portail
	 */
	public function getListTexteAccueilSanteen()
	{		
		$sql = 'SELECT p.texte_accueil_sante_en, q.titre_sante_en, q.texte_accueil_sante_meta_en FROM MyAppGlobalBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
		$query = $this->getEntityManager()->createQuery($sql);
                return $query->getResult();		
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section corporatif du portail
	 */
	public function getListTexteAccueilAttrait()
	{
		
		$sql = 'SELECT p.texte_accueil_attrait_fr, q.titre_attrait_fr, q.texte_accueil_attrait_meta_fr FROM MyAppGlobalBundle:Textes_accueil p JOIN p.texte_complementaire q';
                $query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section corporatif du portail
	 */
	public function getListTexteAccueilAttraiten()
	{		
		$sql = 'SELECT p.texte_accueil_attrait_en, q.titre_attrait_en, q.texte_accueil_attrait_meta_en FROM MyAppGlobalBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
		$query = $this->getEntityManager()->createQuery($sql);
                return $query->getResult();		
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section corporatif du portail
	 */
	public function getListTexteAccueilRestaurant()
	{
		
		$sql = 'SELECT p.id, p.texte_accueil_restaurant_fr, q.titre_restaurant_fr, q.texte_accueil_restaurant_meta_fr FROM MyAppGlobalBundle:Textes_accueil p JOIN p.texte_complementaire q';
                $query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
        }
        
        /**
	 * Recherche le texte d'accueil fr pour la section corporatif du portail
	 */
	public function getListTexteAccueilRestauranten()
	{		
		$sql = 'SELECT p.id, p.texte_accueil_restaurant_en, q.titre_restaurant_en, q.texte_accueil_restaurant_meta_en FROM MyAppGlobalBundle:Textes_accueil_en p JOIN p.texte_complementaire_en q';
		$query = $this->getEntityManager()->createQuery($sql);
                return $query->getResult();		
        }
       
}