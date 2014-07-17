<?php
namespace MyApp\AdminBundle\Controller;
use MyApp\GlobalBundle\Controller\ControleDataSecureController;
use MyApp\GlobalBundle\MyAppGlobalBundle;
use MyApp\AdminBundle\MyAppAdminBundle;
use Symfony\Component\BrowserKit\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * 
 * @author leonardc
 * Classe pour le menu admin de premier niveau avec ses sections
 * 
 * @Secure(roles="ROLE_SUPER_ADMIN")
 */
class DashboardController extends Controller
{	
	
	/**
	 * Page d'accueil du tableau de bord.
	 */
	public function dashboardAction()
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupére le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Préparation de la view dashboard.html.twig
		return $this->render('MyAppAdminBundle:Dashboard:dashboard.html.twig',
				array(
						'annee' 			=> date('Y'), //date pour copyright
						'name_admin' 		=> $user->getUsername(),
						'role'				=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour afficher les informations générales.
	 */
	public function generalAction()
	{	
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Préparation de la view dashboard_general_html.twig
		return $this->render('MyAppAdminBundle:Dashboard:dashboard_general.html.twig',
		array(
				'annee' 		=> date('Y'), 
				'name_admin' 		=> $user->getUsername(),
				'role'			=> $role,
		));
	}
	
	/**
	 * Page du tableau de bord pour afficher les hébergements.
	 */
	public function hebergementsAction()
	{		
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Préparation de la view dashboard_hebergements_html.twig
		return $this->render('MyAppAdminBundle:Dashboard:dashboard_hebergements.html.twig',
		array(
				'annee' 		=> date('Y'), 
				'name_admin' 		=> $user->getUsername(),
				'role'			=> $role,
		));
	}
	
	/**
	 * Page du tableau de bord pour afficher les attraits.
	 */
	public function attraitsAction()
	{	
		$em = $this->getDoctrine()->getEntityManager();		
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);		
		//Préparation de la view dashboard_attraits_html.twig
		return $this->render('MyAppAdminBundle:Dashboard:dashboard_attraits.html.twig',
		array(
				'annee' 		=> date('Y'), 
				'name_admin' 		=> $user->getUsername(),
				'role'			=> $role,
		));
	}
	
	/**
	 * Page du tableau de bord pour afficher les textes du site web.
	 */
	public function sectionSiteWebAction()
	{
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Préparation de la view dashboard_text_html.twig
		return $this->render('MyAppAdminBundle:Dashboard:dashboard_text.html.twig',
		array(
				'annee' 		=> date('Y'), 
				'name_admin' 		=> $user->getUsername(),
				'role'			=> $role,
		));
	}
	
	/**
	 * Page du tableau de bord pour la gestion du Québec en saisons.
	 */
	public function quebec_saisonAction()
	{
		$em = $this->getDoctrine()->getEntityManager();		
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);	
		//Préparation de la view dashboard_quebec_en_saison_html.twig
		return $this->render('MyAppAdminBundle:Dashboard:dashboard_quebec_saison.html.twig',
		array(
				'annee' 		=> date('Y'), 
				'name_admin' 		=> $user->getUsername(),
				'role'			=> $role,
		));
	}
	
	/**
	 * Page du tableau de bord pour afficher les statistiques.
	 */
	public function statistiquesAction()
	{
		$em = $this->getDoctrine()->getEntityManager();	
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Préparation de la view dashboard_statistiques_html.twig
		return $this->render('MyAppAdminBundle:Dashboard:dashboard_statistiques.html.twig',
		array(
				'annee' 		=> date('Y'),
				'name_admin' 		=> $user->getUsername(),
				'role'			=> $role,
		));
	}
	
	/**
	 * Page du tableau de bord pour afficher toutes les informations divers logs, etc.
	 */
	public function informationsAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Préparation de la view dashboard_informations_html.twig
		return $this->render('MyAppAdminBundle:Dashboard:dashboard_informations.html.twig',
			array(
					'annee' 		=> date('Y'),
					'name_admin' 		=> $user->getUsername(),
					'role'			=> $role,
			));
	}
	
}
