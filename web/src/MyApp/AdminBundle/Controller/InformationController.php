<?php
namespace MyApp\AdminBundle\Controller;
use MyApp\AdminBundle\Forms\AddClientForm;
use MyApp\GlobalBundle\Entity\Utilisateur;
use MyApp\GlobalBundle\MyAppGlobalBundle;
use MyApp\AdminBundle\Forms\Moteur_recherche_clientForm;
use MyApp\AdminBundle\Forms\AddUserSystemForm;
use MyApp\AdminBundle\MyAppAdminBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\GlobalBundle\Controller\ControleDataSecureController;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * 
 * @author cedric 
 * 
 * @Secure(roles="ROLE_SUPER_ADMIN")
 *
 */
class InformationController extends Controller
{

/*####################################################################################*/
/*############### SECTION LISTE UTILISATEUR DU SYSTÈME ###############################*/
/*####################################################################################*/
	
	/**
	 * Page du tableau de bord pour afficher les utilisateurs du système
	 */
	public function utilisateurAction()
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Affiche la liste des utilisateurs du système global
		$listeUserSystem = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getListUserGlobal();
		//Vide dans la table des logs tous les logs qui sont passé depuis deux mois
		if(date("m") == 01 or date("m") == 02){
			if(date("m") == 01){
				$mois = 11;
			}
			if(date("m") == 02){
				$mois = 12;
			}
			$annee = date("Y")-1;
			$datedelay = $annee."-".$mois."-01";
		}else{
			if(count(date("m")-2) == 1){
				$datedelay = date("Y")."-0".(date("m")-2)."-".date("d");
			}else{
				$datedelay = date("Y")."-".(date("m")-2)."-".date("d");
			}
		}
		//Suppréssion 
		$datedelete = $em->getRepository("MyAppGlobalBundle:Logs")->getDeleteLogs($datedelay);
		//Préparation de la view 
		return $this->render('MyAppAdminBundle:Information:dashboard_listeutilisateursysteme.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'infouser' 				=> "menu_informations",
						'listuser'				=> $listeUserSystem,
						'role'					=> $role,
				));
		
	}
	
/*####################################################################################*/
/*############### SECTION LISTE CLIENT DU SYSTÈME ####################################*/
/*####################################################################################*/
	
	/**
	 * Page du tableau de bord pour afficher les clients du système
	 */
	public function clientAction($id)
	{
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Affiche la liste des utilisateurs du système global
		$listeUserSystem = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getListClientGlobal();
		//Préparation de la view
		return $this->render('MyAppAdminBundle:Information:dashboard_listeclientsysteme.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'infoclient' 				=> "menu_informations",
						'listuser'				=> $listeUserSystem,
						'role'					=> $role,
				));
	
	}
	
/*####################################################################################*/
/*############### SECTION LOGS ET ANOMALIES ##########################################*/
/*####################################################################################*/
	/**
	 * Page du tableau de bord pour afficher les logs et anomalies
	 */
	public function logAndAnomalyAction($page, $letter)
	{
		$nbParPage = 30; //Affiche 30 clients par défault.
		$number = "";
		
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie le role
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//Récupère le nombre de client dans la table
		$nub_customer = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getCompteClients();
		foreach($nub_customer as $nb){
			$total = $nb['nbclient'];
		}
		//Détermine le nombre de page
		$displaypage = ceil( $total/$nbParPage);
		//S'il n'existe pas de numéro de page dans l'url alors on prend la valeur 1 par defaut.
		if(isset($page) and is_numeric($page) == 1)
			if($page > $displaypage)
				$page = $displaypage;
			elseif($page <= 0)
				$page = 1;
			else
				$page;
		else
			$page = 1;
		//Affiche la liste des clients
		$listeCustomer = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getListLogClient($page, $nbParPage);
		//S'il existe une lettre alphabétique dans l'url.(recherche par lettre alphabétique)
		($letter === 'letter')? $lettre = "" : $lettre = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getClientByFirstLetter($letter);
		//Création du formulaire pour le moteur de recherche.
		$form = $this->createForm(new Moteur_recherche_clientForm());
		//On accède à la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			foreach($form->getData() as $word)
			{
				$word;
			}
			$result = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getWordSearchClient($word);
		}
		else
			$result = "";
		
		//Préparation de la view
		return $this->render('MyAppAdminBundle:Information:dashboard_loganomalie.html.twig',
				array(
						'annee' 					=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'pointeur' 					=> 'pointeur',
						'infolog' 					=> "menu_informations",
						'listuser'					=> $listeUserSystem,
						'role'						=> $role,
						'form' 						=> $form->createView(),
						'listClient'				=> $listeCustomer,
				));
	}
	
	/**
	 * Ajout d'un utilisateur pour la gestion de l'admin du portail de Global réservation
	 */
	public function addUtilisateurAction($id)
	{
		$val = $log = $displayPw = "";
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie le rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		//On regarde si c'est un ajout ou une modification
		if($id == "id")
		{	
			$val = 0;
			//Récupération de l'entité Utilisateur.
			$utilisateur = new Utilisateur();
			//Création du formulaire.
			$form = $this->container->get('form.factory')->create(new AddUserSystemForm(), $utilisateur);	
			//Accés à la requête sousmise
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{ 
					$pw = $form->getData()->getPassword(); //on récupère le mot de passe dans le champ du formulaire
					$factory = $this->get('security.encoder_factory');
	
					$encoder = $factory->getEncoder($utilisateur);
					$password = $encoder->encodePassword($pw, $utilisateur->getSalt()); //on le hash
					$utilisateur->setPassword($password);
					$utilisateur->setRoles('ROLE_SUPER_ADMIN');
					$utilisateur->setDateCreation(new \DateTime("now"));
					$em->persist($utilisateur);
					$em->flush();
					echo 'Utilisateur ajouté avec succés !';
					//On redirige vers la liste des utilisateurs du système.
					return $this->redirect($this->generateUrl('_Dashboard_utilisateursSysteme'));
				}
			}
		}
		else
		{
			//On valide que la variable id est bien un entier
			$id = (new ControleDataSecureController)->getValidInteger($id);
			//Récupération de l'entité Utilisateur.
			$utilisateur = $em->find('MyAppGlobalBundle:Utilisateur', $id);
			//On récupère le mot de passe crypter
			define('PASSWD', $utilisateur->getPassword());
                        $displayPw = PASSWD;
			//Création du formulaire.
			$form = $this->container->get('form.factory')->create(new AddUserSystemForm(), $utilisateur);
			//Accés à la requête sousmise
			$request = $this->get('request');
			// On vérifie qu'elle est de type « POST ».
			if( $request->getMethod() == 'POST' )
			{
				// On fait le lien Requête <-> Formulaire.
				$form->bindRequest($request);
				// On vérifie que les valeurs rentrées sont correctes.
				if( $form->isValid() )
				{ 
					//On regarde si la checkbox de modification du mot de passe est cochée.
					$checkbox = $form->getData()->getResetPassword();
					if($checkbox == true)
					{
						$pw = $form->getData()->getPassword(); //on récupère le mot de passe dans le champ du formulaire
						$factory = $this->get('security.encoder_factory');
				
						$encoder = $factory->getEncoder($utilisateur);
						$password = $encoder->encodePassword($pw, $utilisateur->getSalt()); //on le hash
						$utilisateur->setPassword($password);
					}
					else 
						$utilisateur->setPassword(PASSWD);
					$utilisateur->setRoles('ROLE_SUPER_ADMIN');
					$utilisateur->setDateCreation(new \DateTime("now"));
					$em->persist($utilisateur);
					$em->flush();
					echo 'Utilisateur modifié avec succés !';
					//On redirige vers la liste des utilisateurs du système.
					return $this->redirect($this->generateUrl('_Dashboard_utilisateursSysteme'));
				}
			}
			//Va nous servir à determiner qu'on est dans la mise à jour pour le formulaire
			$val = 1;
			$log = $em->getRepository("MyAppGlobalBundle:Utilisateur")->getRecupereDernierLog($id);
		}
		//Préparation de la view dashboard_clients.html.twig
		return $this->render('MyAppAdminBundle:Information:dashboard_addUserSystem.html.twig',
				array(
						'annee' 				=> date('Y'),
						'name_admin'                            => $user->getUsername(),
						'pointeur' 				=> 'pointeur',
						'infouser' 				=> "menu_informations",
						'form' 					=> $form->createView(),
						'infonom' 				=> $utilisateur->getUsername(),
						'infoid' 				=> $utilisateur->getId(),
						'exist' 				=> $val,
						'mois' 					=> date('n'),
						'jour' 					=> date('d'),
						'annee' 				=> date('Y'),
						'role'					=> $role,
						'log'					=> $log,
                                                'displayPw'                             => $displayPw,
					));
	}
	
	/**
	 * Suppréssion d'un administrateur du système
	 */
	/**
	 * Page du tableau de bord pour supprimer les clients.
	 */
	public function deleteUtilisateurAction($id)
	{
		//Vérification des arguments dans l'url
		$id = (new ControleDataSecureController)->getValidInteger($id);
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Recherche du client à supprimer
		$utilisateur = $em->find('MyAppGlobalBundle:Utilisateur', $id);
		$em->remove($utilisateur);
		$em->flush();
		//Redirection à la page d'accueil des utilisateurs
		return $this->redirect($this->generateUrl('_Dashboard_utilisateursSysteme'));
	}
}
