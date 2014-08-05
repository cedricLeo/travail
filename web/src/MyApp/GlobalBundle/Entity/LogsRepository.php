<?php
namespace MyApp\GlobalBundle\Entity;
use Doctrine\ORM\EntityRepository;

class LogsRepository extends EntityRepository{
	
	/**
	 * On supprime tous les logs qui sont passés depuis deux mois
	 */
	public function getDeleteLogs($datedelay){
		
		$sql = 'DELETE FROM MyAppGlobalBundle:Logs p WHERE p.date_connexion <= :datedelay';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter("datedelay", $datedelay);
		return $query->getResult();
	}
}