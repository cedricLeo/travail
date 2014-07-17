<?php
namespace MyApp\AdminBundle\Controller;
use MyApp\GlobalBundle\MyAppGlobalBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\GlobalBundle\Controller\ControleDataSecureController;
use MyApp\AdminBundle\Forms\Moteur_recherche_clientForm;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * 
 * @author leonardc
 * 
 * @Secure(roles="ROLE_SUPER_ADMIN")
 *
 */
class StatistiqueController extends Controller
{

/*####################################################################################*/
/*############### SECTION STATISTIQUES ###############################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les statistiques du clients
	 */
	public function statistiqueClientAction($id, $page)
	{
		$number = 0;
		$numberPaginate = 30;
		
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère la liste des statistiques des clients.
		$autocompletion = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAutoCompletionClient();
		$number = 1;
		//Formulaire de recherche du client par son nom
		$form = $this->container->get('form.factory')->create(new Moteur_recherche_clientForm());
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			foreach($form->getData() as $word)
			{
			 	$word = $validRole->getSearchEngineAdmin($word);
			}
			//On recherche le service par le nom entrer avec l'auto-completion
			$result = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getWordSearchClient($word);
			$number = 2;
		}
		else
			$result = "";
		//Compte le nombre de client 
		$numberCustomer = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getCompteClients();
		$total = $numberCustomer[0]['nbclient'];
		//On divise le nombre total de client par le nombre que l'on souhaite afficher .
		$displaypage = ceil($total / $numberPaginate);
		//Contrôle s'il existe une variable $page et on s'assure qu'elle ne devienne pas superieure au nombre max de page
		$page = $validRole->getValideEntierPagination($page, $displaypage);
		//Récupère la liste des services avec la pagination.
		$statistiqueClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getListClient($page, $numberPaginate);
		$number = 1;
		(isset($word))? $number = 2 : $number;
                
               
		//Préparation de la view dashboard_statistiqueclient.html.twig
		return $this->render('MyAppAdminBundle:Statistique:dashboard_statistiqueclient.html.twig',
				array(
						'annee' 					=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'menu' 						=> 'selection',
						'pointeur' 					=> 'pointeur',
						'statcust' 					=> "menu_statistique",
						'autocompletion'			=> $autocompletion,
						'form'						=> $form->createView(),
						'number'					=> $number,
						'nbclient'					=> $total,
						'displaypage'				=> $displaypage,
						'page'						=> $page,
						'firstpage'					=> 1,
						'statistique'				=> $statistiqueClient ,
						'result'					=> $result,
						'role'						=> $role,
				));
	}
	
	/**
	 * Page du tableau de bord pour afficher les statistiques du mois
	 */
	public function statistiqueMoisAction($id)
	{
		return $this->render('MyAppAdminBundle:Statistique:dashboard_statistiquemois.html.twig',
				array(
						/*'annee' => $annee_en_cours,
						 'name_admin' => $name,
		'pays' => $state,
		'menu' => $menu,
		'pointeur' => 'pointeur',
		'mp' => $mp,*/
				));
	}
	
	/**
	 * Page du tableau de bord pour modifier les statistiques de l'ann�e
	 */
	public function statistiqueAnneeAction($id)
	{
		return $this->render('MyAppAdminBundle:Statistique:dashboard_statistiqueannee.html.twig',
				array(
						/*'annee' => $annee_en_cours,
						 'name_admin' => $name,
		'pays' => $state,
		'menu' => $menu,
		'pointeur' => 'pointeur',
		'mp' => $mp,*/
				));
	}
	
	/**
	 * Page pour archiver les statistiques
	 */
	public function statistiqueArchiveAction($id)
	{
		return $this->render('MyAppAdminBundle:Statistique:dashboard_statistiquearchive.html.twig',
				array(
						/*'annee' => $annee_en_cours,
						 'name_admin' => $name,
		'pays' => $state,
		'menu' => $menu,
		'pointeur' => 'pointeur',
		'mp' => $mp,*/
				));
	}
	
}

