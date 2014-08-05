<?php

namespace MyApp\MobileBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CedricL
 *
 * Fonctions pour la sécurité 
 */
class UtilisateurRepository extends EntityRepository
{
	
	/**
	 * Affiche la liste des utilisateurs du système
	 */
	public function getListUserGlobal()
	{
		$role_super_admin = "ROLE_SUPER_ADMIN";
		$sql = 'SELECT p FROM MyAppMobileBundle:Utilisateur p WHERE p.role = :role';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('role', $role_super_admin);
		return $query->getResult();
	}
	
	/**
	 * Affiche la liste des clients du système
	 */
	public function getListClientGlobal()
	{
		$role_admin = "ROLE_ADMIN";
		$sql = 'SELECT p FROM MyAppMobileBundle:Utilisateur p WHERE p.role = :role';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('role', $role_admin);
		return $query->getResult();
	}
	
	/**
	 * Récupère les informations du client depuis sa session
	 */
	public function getAccesInfoSessionClient($session)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Utilisateur p WHERE p.nom =:session';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('session', $session->getNom());
		return $query->getResult();
	}
	
	/**
	 * Méthode pour rechercher si une adresse courriel existe dans la table
	 */
	public function getRechercheAdresseCourriel($id)
	{
		$sql = 'SELECT p.courriel FROM MyAppMobileBundle:Inscription_newletter p WHERE p.courriel = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Méthode pour récupérer le dernier log de connexion
	 */
	public function getRecupereDernierLog($tab)
	{
		$sql = 'SELECT p.date_connexion FROM MyAppMobileBundle:Logs p WHERE p.utilisateur_id = :id ORDER BY p.date_connexion DESC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $tab);
		return $query->getResult();
	}
	
	/**
	 * Méthode pour retourner l'id de l'utilisateur par son username
	 */
	public function getRetourneIdUtilisateur($tab)
	{
		$sql = 'SELECT p.id FROM MyAppMobileBundle:Utilisateur p WHERE p.username = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $tab);
		return $query->getResult();
	}
	
	/**
	 * Retourne l'id en question dans la table Utilisateur
	 */
	public function getRetourneIdOptionUtilisateur($id)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Utilisateur p WHERE p.id = :id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Retourne le nombre d'utilisateur
	 */
	public function getCompteNombreClient()
	{
		$role = "ROLE_ADMIN";
		$sql = 'SELECT count(p.id) AS nbuser FROM MyAppMobileBundle:Utilisateur p WHERE p.role = :role';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('role', $role);
		return $query->getResult();
	}
	
	/**
	 * Retourne la liste des utilisateurs avec la pagination 
	 */
	public function getRetourneListeClient($page, $limit)
	{
		$role = "ROLE_ADMIN";
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p FROM MyAppMobileBundle:Utilisateur p WHERE p.role =:role ORDER BY p.nom ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		$query->setParameter('role', $role);
		return $query->getResult();
	}
	
	/**
	 * Retourne la liste des attraits et hébergement du client
	 */
	public function getRetourneListeAttraitHebergementClient($id)
	{
		$sql = 'SELECT p, q FROM MyAppMobileBundle:Utilisateur p JOIN p.hebergements q WHERE p.id =:id';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('id', $id);
		return $query->getResult();
	}
	
	/**
	 * Reherche le client soit par sont nom ou son n°interne(username) 
	 */
	public function getInfoUserEngine($search)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Utilisateur p WHERE p.username =:search OR p.nom =:search';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('search', $search);
		return $query->getResult();
	}
	
	/**
	 * Compte les clients qui ont leur nom qui commence par cette lettre
	 */
	public function getRetourneClientParLettre($lettre)
	{
		$sql = 'SELECT COUNT(p.id) AS nblettre FROM MyAppMobileBundle:Utilisateur p WHERE p.nom LIKE :lettre';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('lettre', $lettre.'%');
		return $query->getResult();
	}
	
	/**
	 * Retourne la liste des utilisateurs avec la pagination trier par lettre
	 */
	public function getRetourneClientParLettrePagination($lettre, $page, $limit)
	{
		$paginator = ($page - 1) * $limit;
		$sql = 'SELECT p FROM MyAppMobileBundle:Utilisateur p WHERE p.nom LIKE :lettre ORDER BY p.nom ASC';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setFirstResult($paginator);
		$query->setMaxResults($limit);
		$query->setParameter('lettre', $lettre.'%');
		return $query->getResult();
	}
	
	/**
	 * Retourne la liste de client avec leur nom qui commence par cette lettre
	 */
	public function getRetourneListeClientParLettre($lettre)
	{
		$sql = 'SELECT p FROM MyAppMobileBundle:Utilisateur p WHERE p.nom LIKE :lettre';
		$query = $this->getEntityManager()->createQuery($sql);
		$query->setParameter('lettre', $lettre.'%');
		return $query->getResult();
	}
	
	/**
	 * Autocompletion pour le moteur de recherche coté portail
	 */
	public function getAutocompletionPortail()
	{
		$sql = 'SELECT p.nom_fr FROM MyAppMobileBundle:Hebergements p WHERE p.aprouver = 1 AND p.actif = 1';
		$query = $this->getEntityManager()->createQuery($sql);
		$tab = array($query->getResult());
		$sql2 = 'SELECT p.nom_fr FROM MyAppMobileBundle:Attraits p WHERE p.approuve = 1 AND p.actif = 1';
		$query2 = $this->getEntityManager()->createQuery($sql2);
		array_push($tab, $query2->getResult());
		return $tab;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}