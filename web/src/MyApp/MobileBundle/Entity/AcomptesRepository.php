<?php
namespace MyApp\MobileBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Berriart\Bundle\SitemapBundle\Entity\Url;


class AcomptesRepository extends EntityRepository{

	/**
	 * Liste tous les acomptes
	 */
	public function getListAcomptes()
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Acomptes p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Recherche la liste des urls pour le sitemap
	 */
	public function getRechercherLesUrl()
	{
		$sql = 'SELECT p FROM BerriartSitemapBundle:Url p';
		$query = $this->getEntityManager()->createQuery($sql);
		return $query->getResult();
	}
	
	/**
	 * Retourne la liste des urls pour la section accueil en fonction de la langue
	 */
	public function triUrlPourLaLangue($lang, $tab)
	{
		$tabResultat = array();
		if($lang == "fr"){
			$tabFR = $tab[0];
			foreach($tabFR as $item)
			{
				$sql = 'SELECT p.id, p.loc FROM BerriartSitemapBundle:Url p WHERE p.loc LIKE :critere';
				$query = $this->getEntityManager()->createQuery($sql);
				$query->setParameter('critere', '%'.$item.'%');	
				array_push($tabResultat, $query->getResult());	
			}	
		}else{
			$tabEN = $tab[1];
			foreach($tabEN as $item)
			{
				$sql = 'SELECT p.id, p.loc FROM BerriartSitemapBundle:Url p WHERE p.loc LIKE :critere';
				$query = $this->getEntityManager()->createQuery($sql);
				$query->setParameter('critere', '%'.$item.'%');
				array_push($tabResultat, $query->getResult());
			}
		}
		$tabResultat = array_values(array_filter($tabResultat));
		return $tabResultat;
	}

}