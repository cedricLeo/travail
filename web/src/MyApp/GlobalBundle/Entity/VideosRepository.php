<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class VideosRepository extends EntityRepository{
	
	/**
	 * Récupère la ou les vidéo(s) pour l'attrait
	 */
	public function getSearchMovieAttrait($id)
	{
		$sql = 'SELECT p, q, r FROM MyAppGlobalBundle:Clients p INNER JOIN p.attrait_id q INNER JOIN q.attrait_video_id r WHERE p.id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Récupère la ou les vidéos pour l'hébergement
	 */
	public function getSearchMovieHebergement($id)
	{
		$sql = 'SELECT p FROM MyAppGlobalBundle:Videos p WHERE p.hebergement = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}

}