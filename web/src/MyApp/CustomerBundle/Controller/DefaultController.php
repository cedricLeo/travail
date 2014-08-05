<?php
namespace MyApp\CustomerBundle\Controller;
use MyApp\GlobalBundle\Entity\Soins_sante;
use MyApp\GlobalBundle\Entity\Soins_client;
use MyApp\GlobalBundle\Entity\Types_soins_sante;
use MyApp\AdminBundle\Forms\AddSoinsSanteAttraitType;
use MyApp\AdminBundle\Forms\FormDistanceType;
use MyApp\AdminBundle\Forms\CustomerServiceAttraitType;
use MyApp\AdminBundle\Forms\CustomerServiceHebergementType;
use MyApp\GlobalBundle\Entity\Hebergements_activites;
use MyApp\AdminBundle\Forms\AddTextePolitiqueType;
use MyApp\AdminBundle\Forms\TexteHebergementFicheEnForm;
use MyApp\GlobalBundle\Entity\Galerie_forfaits;
use MyApp\GlobalBundle\Entity\Galerie_hebergement;
use MyApp\AdminBundle\Forms\AddHoraireClientHebergementType;
use MyApp\AdminBundle\Forms\AddPhotoCustomerAttraitType;
use MyApp\AdminBundle\Forms\AddSalleCorporatifType;
use MyApp\GlobalBundle\Entity\Hebergements_salles_corporatives;
use MyApp\AdminBundle\Forms\AddClientChambreENType;
use MyApp\AdminBundle\Forms\AddClientChambreType;
use MyApp\GlobalBundle\Entity\Chambres;
use MyApp\GlobalBundle\Entity\Galerie_photo_chambres;
use MyApp\AdminBundle\Forms\AddTexteForfaitType;
use MyApp\GlobalBundle\Entity\Textes_accueil;
use MyApp\AdminBundle\Forms\AddHebergementForm;
use MyApp\AdminBundle\Forms\AddPhotoCustomerType;
use MyApp\GlobalBundle\Entity\Distances;
use MyApp\AdminBundle\Forms\AddCouponType;
use MyApp\GlobalBundle\Entity\Coupons;
use MyApp\GlobalBundle\Entity\Forfaits_clients;
use MyApp\AdminBundle\Forms\AddForfaitsClientType;
use MyApp\AdminBundle\Forms\AddForfaitForm;
use MyApp\AdminBundle\Forms\CustomerActiviteHebergementType;
use MyApp\AdminBundle\Forms\CustomerActiviteHebergementEnType;
use MyApp\AdminBundle\Forms\DeviseFicheClientEnHebergementType;
use MyApp\AdminBundle\Forms\DeviseFicheClientENForm;
use MyApp\AdminBundle\Forms\DeviseFicheClientHebergementType;
use MyApp\GlobalBundle\Entity\Temporaire_attraits;
use MyApp\AdminBundle\Forms\AddVideoHebergementsForm;
use MyApp\AdminBundle\Forms\TexteHebergementFicheForm;
use Symfony\Component\HttpFoundation\Session;
use MyApp\AdminBundle\Forms\CustomerActiviteAttraitEnForm;
use MyApp\AdminBundle\Forms\HoraireFicheClientForm;
use MyApp\AdminBundle\Forms\AttraitForm;
use MyApp\AdminBundle\Forms\DeviseFicheClientForm;
use MyApp\AdminBundle\MyAppAdminBundle;
use MyApp\AdminBundle\Forms\Textes_page_activiteType;
use MyApp\AdminBundle\Forms\CustomerActiviteAttraitForm;
use Symfony\Bundle\FrameworkBundle\EventListener\RouterListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use MyApp\GlobalBundle\Entity\Modes_paiements;
use MyApp\GlobalBundle\MyAppGlobalBundle;
use MyApp\AdminBundle\Forms\LoginForm;
use MyApp\AdminBundle\Forms\RecoverPasswordForm;
use MyApp\AdminBundle\Forms\AddClientForm;
use MyApp\GlobalBundle\Entity\Attraits_activites;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use MyApp\GlobalBundle\Entity\Attraits;
use MyApp\GlobalBundle\Entity\Distances_attraits;
use MyApp\GlobalBundle\Entity\Hebergements;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use MyApp\GlobalBundle\Controller\ControleDataSecureController;
use JMS\SecurityExtraBundle\Annotation\Secure;
use MyApp\GlobalBundle\Entity\Politique_fr;
use MyApp\GlobalBundle\Entity\Politique_en;
use MyApp\GlobalBundle\Entity\Utilisateur;
use MyApp\GlobalBundle\Entity\Logs;
use MyApp\AdminBundle\Forms\HoraireHebergementForm;
use MyApp\AdminBundle\Forms\HoraireHebergementType;
use MyApp\GlobalBundle\Entity\Types_prix;
use MyApp\AdminBundle\Forms\CustomerServiceHebergementEnType;

/**
 * 
 * @author leonardc
 *
 * Controller pour le mini site du client
 * 
 * @Secure(roles="ROLE_ADMIN")
 */
class DefaultController extends Controller
{
	
	/**
	 * 
	 * Détermine vers qu'elle page on redirige en fonction des droits
	 */
	public function redirigeEnFonctionRoleAction()
	{
		//Gestionnaire des entités.
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//pour la sécurité on envoie le jeton comme un cookie de session.
		$session = new \Symfony\Component\HttpFoundation\SessionStorage\NativeSessionStorage($options = array($cookie_lifetime = 3600) );
		//On vérifie son rôle
		$validRole = new ControleDataSecureController();
		$role = $validRole->getValidRoles($user);
		if($role === "ROLE_SUPER_ADMIN")
		{
			if($user->getUsername() !== "adminVisiteur75"){
				//On écrit la date et l'heure du log  
				$infoLogs = new Logs();
				$infoLogs->setUtilisateurId($user->getId());
				$infoLogs->setDateConnexion(new \DateTime("now"));
				$em->persist($infoLogs);
				$em->flush();
			}
			return $this->redirect($this->generateUrl('_Dashboard'));
		}
		elseif($role === "ROLE_ADMIN")
		{
			//On récupère les informations du client.
			$infoClient = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getAccesInfoSessionClient($user);                 
			if($infoClient != null and $infoClient[0]->getIsActive() === true){
				$infoLogs = new Logs();
				$infoLogs->setUtilisateurId($user->getId());
				$infoLogs->setDateConnexion(new \DateTime("now"));
				$em->persist($infoLogs);
				$em->flush();
				//On regarde si ce client a un hébergement actif pour lui donner accés à la gestion de son hébergement
				$hebergementactif = $em->getRepository("MyAppGlobalBundle:Hebergements")->getExistHebergement($infoClient[0]->getId());
                                if($hebergementactif != null){
					for($i = 0; $i < count($hebergementactif[0]); $i++){
						if($hebergementactif[$i]->getActif() === true or $hebergementactif[$i]->getAprouver() === true)
							return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $infoClient[0]->getId())));                                                
					}
					return $this->redirect($this->generateUrl("login"));
				}
				//On regarde si ce client a un attrait actif pour lui donner accès à la gestion de son attrait
				$attraitactif = $em->getRepository("MyAppGlobalBundle:Attraits")->getRechercheAttraitParUtilisateur($infoClient[0]->getId());
				if($attraitactif != null){
					for($i = 0; $i < count($attraitactif[0]); $i++){
						if($attraitactif[$i]->getAtif === true)
							return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $infoClient[0]->getId())));
					}
					return $this->redirect($this->generateUrl("login"));
				}
                                if($hebergementactif == null or $attraitactif == null){
                                    return $this->redirect($this->generateUrl("login"));
                                }
			}else{
				return $this->redirect($this->generateUrl("login"));
			}
		}
		else
		{
			return $this->redirect($this->generateUrl('_accueil'));
		}
	}
	
	/**
	 * Retourne les informations de l'attraits du client
	 */
	public function informationsAttraitAction($id)
	{
		$id = (new ControleDataSecureController)->getValidInteger($id);
		//Gestionnaire des entités.
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère les informations du client et la latitude et longitude de l'attrait ou de l'hébergement si ça existe
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomer($id);
		//On récupère l'id de l'attrait on va en avoir besoin pour créer le formulaire des textes pour l'attrait
		foreach($listOption as $txtAtt){
			foreach($txtAtt->getAttraitId() as $test){
				$recupIdAtt = $test->getId();
			}
		}
		//On récupère les informations de l'attrait.
		 $textes_attrait = $em->find('MyAppGlobalBundle:Attraits', $recupIdAtt);
		 return $textes_attrait;
	}
	
	/**
	 * Accéde au compte du client depuis l'authentification client
	 */
	public function showCompteCustomerAction($id, $name)
	{
		//On valide les arguments dans l'url
		$validateur = new ControleDataSecureController();
		$id = $validateur->getValidInteger($id);
		$name = $validateur->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validRole->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerHebergement($id, $name);
		if($listOption == null)
		{
			$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerAttrait($id, $name);
		}
		//On prépare la view index.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:index.html.twig',
                    array(
                        'annee'					=> date('Y'),
                        'name_admin'				=> $user->getUsername(),
                        'role'					=> $role,
                        'id'					=> $id,
                        'listOption'				=> $listOption,
                        'confirm'				=> $confirm = "",
                        'adminClient'				=> true,
                        'nocache'				=> $this->getNoCache(),
                    ));
	}
	
	public function getNoCache()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	}
	
	
	/**
	 * Accéde au compte du client depuis la gestion de Global et affiche les informations administratives.
	 */
	public function accessCompteCustomerAction($id, $name, $redirect, $rechargement)
	{     
            //On regarde s'il s'agit d'une redirection dans une autre action
            if($rechargement == "hebergement"){
                return $this->redirect($this->generateUrl('MyAppTextHebergement', array('id' => $id, 'name' => $name, 'redirect' => $redirect) ));
            }
            $attraitExist = $hebergementExist = $idSectionRedirect = "";
            //Contrôle le nom de la région passé
            $validateur = new ControleDataSecureController();
            $id = $validateur->getValidInteger($id);
            $name = $validateur->getCleanNameGeography($name, "name");
            //Gestionnaire des entités
            $em = $this->getDoctrine()->getEntityManager();
            //Récupère le nom de la personne qui accède à l'administration
            $user = $this->container->get('security.context')->getToken()->getUser();
            //On vérifie son rôle
            $role = $validateur->getValidRoles($user);
            if($role === "ROLE_ADMIN"){
                    //Fonction pour la sécurité
                    self::getValideIdAvecNomRepertoire($user);
            }
            if($role === "ROLE_SUPER_ADMIN"){
                    //Récupère les informations du client.
                    $listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($id);
                    if($listOption != null)
                    {                
                            //Liste hébergement
                            $hebergementExist = $em->getRepository('MyAppGlobalBundle:Hebergements')->getExistHebergement($listOption[0]->getId());                               
                            if($redirect == "menu_hebergement"){
                                $idSectionRedirect = $hebergementExist[0]->getId();
                            }                                
                            //Liste attrait
                            $attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getUtilisateurByAttraitRelationSoins($listOption[0]->getId());                              
                            if($redirect == "menu_attrait"){
                                $idSectionRedirect = $attraitExist[0]->getId();
                            }
                    }
            }else{
                    $listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($user->getId());
                    //Liste hébergement
                    $hebergementExist = $em->getRepository('MyAppGlobalBundle:Hebergements')->getExistHebergement($user->getId());
                    //Liste attrait
                    $attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getRechercheAttraitParUtilisateur($user->getId());
            }
            //On prépare la view index.html.twig
            return $this->render('MyAppCustomerBundle:MiniSite:index.html.twig',
                array(
                                'annee'				=> date('Y'),
                                'name_admin'			=> $user->getUsername(),
                                'role'				=> $role,
                                'listOption'			=> $listOption,				
                                'adminClient'			=> true,
                                'attraitExist'			=> $attraitExist,	
                                'hebergementExiste'		=> $hebergementExist,	
                                'nocache'			=> $this->getNoCache(),	
                                'redirect'                      => $redirect,
                                'id'                            => $idSectionRedirect
                ));
	}
	
	
	/**
	 * Méthode pour ignitialiser la variable pour la langue
	 */
	public function traductionLangueAdminAction($langue, $id)
	{
		//On valide les arguments dans l'url
		$validateur = new ControleDataSecureController();
		$langue = $validateur->getCleanNameGeography($langue, 'name');
		$id = $validateur->getValidInteger($id);
		if($langue != null)
		{
			// On enregistre la langue en session
			$this->container->get('session')->setLocale($langue);
		}
		//On redirige vers la même page mais traduite dans la langue choisie.
		$url = $this->container->get('request')->headers->get('referer');
		
		if(empty($url))
		{
			//$url = $this->container->get('router')->generate("_Dashboard_compteCustomer");
			$url = $this->container->get('router')->generate("_Dashboard_compteCustomer", array("id" => $id) );
		}
		return new RedirectResponse($url);
	}
	
	/**
	 * Ajout du texte pour les promotions(section forfaits - promotions)
	 */
	public function textpromotionAction($idclient, $name, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		//On valide les arguments passés
		$validateur = new ControleDataSecureController();
		$idclient = $validateur->getValidInteger($idclient);
		$name = $validateur->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validateur->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerHebergement($idclient, $name);
		if($listOption == null)
		{
			$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerAttrait($idclient, $name);
		}
		$textes = $em->getRepository('MyAppGlobalBundle:Textes_accueil')->getSearchTexteForfait($idclient);
		if($textes == null)
		{
			$textes = new Textes_accueil();
		}
		$form = $this->createForm(new AddTexteForfaitType(), $textes);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
			// On l'enregistre notre objet $textes dans la base de données.
			$em->persist($textes);
			$em->flush();
			echo 'Textes ajoutés avec succés !';
			//On redirige vers la liste des forfaits.
			return $this->redirect($this->generateUrl('MyAppForfait', array('id' => $idclient, 'name' => $name)));
			}
		}
		//On prépare la view forfaits.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:textePromotion.html.twig',
                    array(
                            'annee'			=> date('Y'),
                            'name_admin'		=> $user->getUsername(),
                            'role'                      => $role,
                            'idclient'			=> $listOption[0]->getId(),
                            'name'			=> $listOption[0]->getRepertoireFr(),
                            'listOption'		=> $listOption,
                            'adminClient'		=> true,
                            'form'			=> $form->createView(),
                            'nocache'			=> $this->getNoCache(),
                            'redirect'                  => $redirect,
                    ));
	}
	
	/**
	 * Section forfait administration du client.
	 * 
	 * params id et nom du client
	 */
	public function forfaitAction($id, $name, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$listeForfait = $hebergementExiste = $attraitExist = "";
		$validateur = new ControleDataSecureController();
		$id = $validateur->getValidInteger($id);
		$name = $validateur->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validateur->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Récupère les informations de l'hébergement.
		$hebergement = $em->getRepository('MyAppGlobalBundle:Hebergements')->getRechercheHebergementParRepertoireEtId($id, $name);
		if($hebergement != null)
		{ 
			//Liste des forfaits
			$listeForfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getListeForfaitsHebergementDuClient($hebergement[0]->getId());
			//Information du client
			$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($hebergement[0]->getUtilisateur()->getId());
			//Liste hébergement
			$hebergementExiste = $em->getRepository("MyAppGlobalBundle:Hebergements")->getExistHebergement($listOption[0]->getId());
			//Liste attrait
			$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getUtilisateurByAttraitRelationSoins($listOption[0]->getId());
		}
		//On prépare la view listeforfaits.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:listeforfaits.html.twig',
				array(
						'annee'					=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'role'					=> $role,
						'id'					=> $id,
						'adminClient'				=> true,
						'listOption'				=> $listOption,
						'today'					=> new \DateTime("now"),
						'attraitExist'				=> $attraitExist,
						'hebergementExiste'			=> $hebergementExiste,
						'hebergementForfait'                    => $hebergement,	
						'listeForfait'				=> $listeForfait,
						'nocache'				=> $this->getNoCache(),
                                                'redirect'                              => $redirect,
                                                'pointerforfait'                        => true,
				));
	}
	
	/**
	 * Ajouter ou modifier un forfait compte client
	 */
	public function addForfaitAction($idforfait, $name, $idclient, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$infoid = $infoname = $infoimg = $infoimgprincipale = $type_soin = $attraitExist = $hebergementExiste = "";
		$exist = false;
		//On valide les arguments.
		$validateur = new ControleDataSecureController();
		$idclient = $validateur->getValidInteger($idclient);
		($idforfait != "idforfait")? $idforfait = $validateur->getValidInteger($idforfait): "";
		$name = $validateur->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validateur->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Information hébergement
		$hebergement = $em->getRepository("MyAppGlobalBundle:Hebergements")->getRechercheHebergementParRepertoireEtId($idclient, $name);
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($hebergement[0]->getUtilisateur()->getId());
		//Liste hébergment
		$hebergementExiste = $em->getRepository("MyAppGlobalBundle:Hebergements")->getExistHebergement($listOption[0]->getId());
		//Liste attrait
		$attraitExist = $em->getRepository("MyAppGlobalBundle:Attraits")->getUtilisateurByAttraitRelationSoins($listOption[0]->getId());
		if($idforfait === "idforfait")
		{
			//Construction du formulaire pour l'ajout d'un forfait
			$forfait = new Forfaits_clients();
			$exist = false;
		}
		else{
			//Construction du formulaire pour la modification d'un forfait
			$forfait = $em->find('MyAppGlobalBundle:Forfaits_clients', $idforfait);
			$infoid = $forfait->getId();	// On récupère l'id
			$infoname = $forfait->getNomfr(); 	// le nom fr
			$infoimg = $forfait->getImageCategorie();	// l'image catégorie du forfait
			$infoimgprincipale = $forfait->getImagePrincipale(); //l'image principale
			$exist = true;
		}
		//Création du formulaire
		$form = $this->createForm(new AddForfaitsClientType(), $forfait);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			//if( $form->isValid() )
			//{
				//On valide que c'est bien un super utilisateur qui valide pour être un tarif de dernière minute
				if($role === "ROLE_SUPER_ADMIN" and $form->getData()->getDerniereMinute() == true)
				{
                                    $forfait->setDerniereMinute(true);
                                    $forfait->setPublication(new \DateTime("now"));
				}else{
                                    $forfait->setDerniereMinute(false);
				}
                                if($exist == true){
                                    $dateToday = new \DateTime("now");
                                    //On désassemble l'objet date 
                                    $tab = [];
                                    foreach($forfait->getDateDeFin() as $test)
                                    {
                                        array_push($tab, $test);
                                    }
                                    $dateForfait = $tab[0];
                                    $dateForfaits =	substr($dateForfait,0 ,10 ); //on supprime l'heure on ne veut juste la date
                                    //On valide que les dates de forfaits périmées si le client essait de créer un forfait on supprime la validation pour les tarifs de dernières minutes
                                    if($dateForfaits < $dateToday and $forfait->getDateDeFin() == null and $forfait->getDerniereMinute() == 1)
                                    {
                                        $forfait->setDerniereMinute(0);
                                    }	
                                }
				//On valide si le champs image continet une valeur pour ne passe écraser sa valeur dans la BD
				$imgprincipale = $form->getData()->getImagePrincipaleDoctrine();
				if($imgprincipale != null)
				{                                    
                                    $forfait->setImagePrincipale($imgprincipale);
				}
				//Si c'est un attrait qui créer un forfait on enregistre son id
				if(isset($value) and $value == "attrait")
				{
					$attrait = $em->getRepository("MyAppGlobalBundle:Attraits")->getSearchAttraitById($listOption[0]->getId());
					//On récupère une instance pour l'injection de dépendance
					$dependance = $em->find("MyAppGlobalBundle:Attraits", $attrait[0]->getId());
					$forfait->setAttraitId($dependance, $attrait[0]->getId());
					if($listOption[0]->getHebergementId() != null)
					{
						//On écrit l'id de l'hébergement dans la relation
						$hebergement = $em->find('MyAppGlobalBundle:Hebergements', $listOption[0]->getHebergementId()->getId());
						$forfait->setHebergementId($hebergement);
					}
				}
				else{
					//On écrit l'id de l'hébergement dans la relation
					$hebergement = $em->find('MyAppGlobalBundle:Hebergements', $idclient);
					$forfait->setHebergementId($hebergement);
				}
				//On vérifie si la catégorie forfait est (déjeuner ou déjeuner/souper pour écrire l'id de l'attrait)
				if($form->getData()->getForfaitClientId()->getId() == 8 or $form->getData()->getForfaitClientId()->getId() == 7)
				{
					if(!isset($attrait) and !isset($dependance))//On regarde si la variable est déjà créer si oui la requête existe on ne la rappel pas
					{
						$attrait = $em->getRepository("MyAppGlobalBundle:Attraits")->getHebergementByAttrait($listOption[0]->getId());
                                                if($attrait != null){
                                                    //On récupère une instance pour l'injection de dépendance
                                                    $dependance = $em->find("MyAppGlobalBundle:Attraits", $attrait[0]->getId());
                                                    $forfait->setAttraitId($dependance, $attrait[0]->getId());
                                                }
					}
				}
                                /*if($exist == false){
                                    $forfait->setPublication(new \DateTime("now"));
                                } */
                                $forfait->setDateCreation(new \DateTime("now"));
				// On l'enregistre notre objet $forfait dans la base de données.
				$em->persist($forfait);
				$em->flush();
                                //Envoie du courriel si le client désire être dans les tarifs dernières minutes
                                if($request->get('publicationtarif') == "on")
                                {
                                    if($exist == false)
                                    {
                                        $forfait = "";
                                        $forfait = $em->getRepository("MyAppGlobalBundle:Forfaits_clients")->getRechercheDernierForfaitsHebergementDuClient($hebergement[0]->getId());
                                    }                                       
                                    $this->getEnvoyerEmailAGlobalInfo($hebergement, $forfait);                                    
                                }
				echo 'Forfait ajouté avec succés !';
				if(is_array($hebergement) == true){
					//On redirige vers la liste des forfaits.
					return $this->redirect($this->generateUrl('MyAppForfait', array('id' => $hebergement[0]->getId(), 'name' => $hebergement[0]->getRepertoireFr(), 'redirect' => $redirect )));
				}else{
					//On redirige vers la liste des forfaits.
					return $this->redirect($this->generateUrl('MyAppForfait', array('id' => $hebergement->getId(), 'name' => $hebergement->getRepertoireFr(), 'redirect'    => $redirect )));
				}
			//}
		}                
		//On prépare la view forfaits.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:forfaits.html.twig',
                    array(
                            'annee'				=> date('Y'),
                            'name_admin'			=> $user->getUsername(),
                            'role'				=> $role,
                            'idforfait'				=> $idforfait,
                            'idclient'				=> $hebergement[0]->getId(),
                            'name'				=> $infoname,
                            'repertoire'			=> $hebergement[0]->getRepertoirefr(),
                            'infoimg'				=> $infoimg,
                            'infoimgprincipale'			=> $infoimgprincipale,
                            'listOption'			=> $listOption,
                            'adminClient'			=> true,
                            'form'				=> $form->createView(),
                            'exist'				=> $exist,
                            'today'                             => new \DateTime("now"),
                            'dateFin'				=> $forfait->getDateDeFin(),
                            'dateCourante'			=> date("dmY"),		
                            'attraitExist'			=> $attraitExist,
                            'hebergementExiste'			=> $hebergementExiste,	
                            'nocache'				=> $this->getNoCache(),
                            'redirect'                          => $redirect,
                            'id'                                => $hebergement[0]->getId(),
                            'pointerforfait'                    => true,
                    ));
	}
		
	/**
	 * Supprime un forfait administration compte client.
	 */
	public function deleteforfaitAction($idclient, $name, $idforfait, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		//On valide les arguments
		$validateur = new ControleDataSecureController();
		$idforfait = $validateur->getValidInteger($idforfait);
		$idclient = $validateur->getValidInteger($idclient);
		$name = $validateur->getCleanNameGeography($name, 'name');
		//Gestionnaire d'entité
		$em = $this->getDoctrine()->getEntityManager();
		//On regarde si le client à d'autre forfait sera utile pour la redirection
		$forfaitExist = $em->getRepository('MyAppGlobalBundle:Forfaits_clients')->getListeForfaitsHebergementDuClient($idclient);
		//Information hébergement
		$hebergement = $em->getRepository("MyAppGlobalBundle:Hebergements")->getRechercheHebergementParRepertoireEtId($idclient, $name);
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($hebergement[0]->getUtilisateur()->getId());
		//On récupère le forfait à supprimer
		$forfait = $em->find('MyAppGlobalBundle:Forfaits_clients', $idforfait);
		$em->remove($forfait);
		$em->flush();
		//On redirige vers la page d'accueil des forfaits ou sinon vers l'accueil du compte
		if(sizeof($forfaitExist) > 1){
			return $this->redirect($this->generateUrl('MyAppForfait', array('id' => $hebergement[0]->getId(), 'name' => $hebergement[0]->getRepertoireFr(), 'redirect' => $redirect )));
		}else{ 
			return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $listOption[0]->getId(), 'name' => $listOption[0]->getNom(), 'redirect' => $redirect)));
		}
	}
	
	/**
	 * Accéde aux textes de l'attrait du client
	 */
	public function texteAttraitAction($id, $name, $redirect)
	{	
                gc_enable();
                $imgLogoExist = $imgMainExist = $imgCatExist = false;
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$attrait = $type_soin = $attraitExist = $hebergementExiste = "";
		//On valide les arguments dans l'url
		$validRole = new ControleDataSecureController();
		$id = $validRole->getValidInteger($id);
		$name = $validRole->getCleanNameGeography($name, 'name');
		//Gestionnaire d'entité
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validRole->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire( $user);
		}
		//Récupère les informations du client.
		$attrait = $em->getRepository('MyAppGlobalBundle:Attraits')->getRechercheAttraitParRepertoireEtId($id, $name);
		//Information client
		$listOption = $em->getRepository("MyAppGlobalBundle:Utilisateur")->getRetourneIdOptionUtilisateur($attrait[0]->getUtilisateur()->getId());
		//Liste attrait
		$attraitExist = $em->getRepository("MyAppGlobalBundle:Attraits")->getRechercheAttraitParUtilisateur($listOption[0]->getId());
		//Liste hébergement
		$hebergementExiste = $em->getRepository("MyAppGlobalBundle:Hebergements")->getExistHebergement($listOption[0]->getId());
		//Entité pour la création du formulaire
		$textes_attrait = $em->find('MyAppGlobalBundle:Attraits', $attrait[0]->getId());
                if($textes_attrait->getImage() != null){
                    define("PHOTO_PRINCIPALE", $textes_attrait->getImage());
                    $imgMainExist = true;
                }
                if($textes_attrait->getPhotoPayante() != null){
                    define("PHOTO_CATEGORIE", $textes_attrait->getPhotoPayante());
                    $imgCatExist = true;
                }
                if($textes_attrait->getLogo() != null){
                    define("PHOTO_LOGO", $textes_attrait->getLogo());
                    $imgLogoExist = true;
                }
		//Ici on regarde la langue pour afficher la liste des services dans la bonne langue
		$lang = $this->container->get('session')->getLocale();
                //Liste des activités
               //On récupère la liste des activités 
                $formActivite = $em->getRepository("MyAppGlobalBundle:Distances_attraits")->getListeLesDistancesAttrait($textes_attrait->getId());
                $distanceExiste = true;
                if($formActivite == null){  //Si cet attrait n'a pas encore de renseigné de distance pour les activités proches
                    $formActivite = $em->getRepository('MyAppGlobalBundle:Attraits_activites')->getListActivites();
                    $distanceExiste = false;
                }
		//On récupère les id des activités
		$tab = []; 
		foreach($formActivite as $index)
		{
			array_push($tab, $index);
		}
		//Formulaire pour les textes pour la page attrait
		$form_texte_activite = $this->createForm(new Textes_page_activiteType($lang), $textes_attrait);
		//On accède à la requête.
		$request = $this->get('request');
		//On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form_texte_activite->bindRequest($request);
			//On valide que tout est ok dans les données transmisent
			if( $form_texte_activite->isValid() )
			{
				//Valide les textes descriptions FR et EN.
				$txtfr = $validRole->getSecureData($_POST['editor1']);
				$txten = $validRole->getSecureData($_POST['editor2']);
				$textes_attrait->setTexteDescriptionFr($txtfr);
				$textes_attrait->setTexteDescriptionEn($txten);
				//Persistance des photos (photo pricipale, photo catégorie, photo logo ) pour l'attrait
				$imgPricipale = $form_texte_activite->getData()->getImage();
				if($imgPricipale != null){
					$textes_attrait->setImage($imgPricipale);
                                        $textes_attrait->setImageDoctrine(null);
				}
				$imgCategorie = $form_texte_activite->getData()->getPhotoPayante();
				if($imgCategorie != null){
					$textes_attrait->setPhotoPayante($imgCategorie);
                                        $textes_attrait->setPhotoPayanteDoctrine(null);
				}
				$imgLogo = $form_texte_activite->getData()->getLogo();
				if($imgLogo != null){
					$textes_attrait->setLogo($imgLogo);
                                        $textes_attrait->setLogoDoctrine(null);
				} 
                                //persist les distances
                                for($x = 0; $x < count($tab); $x++){  
                                    if($distanceExiste == false){
                                        $distance = new Distances_attraits();
                                    }else{
                                        $retourneIdDistance = $em->getRepository("MyAppGlobalBundle:Distances_attraits")->getRechercheLesDistancesAvecAttrait($tab[$x]->getActiviteId(), $textes_attrait->getId());
                                        if($retourneIdDistance != null)
                                            $distance = $em->find("MyAppGlobalBundle:Distances_attraits", $retourneIdDistance[0]->getId());                      
                                    }  
                   
                                       /* $activite = $em->find("MyAppGlobalBundle:Attraits_activites", $x);
                                        $distance->setDistance($request->request->get("attrait_distance_activite_".$x));
                                        $distance->setAttraitId($textes_attrait);
                                        $distance->setActiviteId($x);
                                        if($activite != null){
                                            $distance->setNomFr($activite->getNomFr());
                                            $distance->setNomEn($activite->getNomEn());
                                        }
                                        $textes_attrait->addDistances($distance);*/
                                    //if($request->request->get("attrait_distance_activite_".$x) != null){
                                   if($distanceExiste == false){
                                            $activite = $em->find("MyAppGlobalBundle:Attraits_activites", $tab[$x]->getId());   
                                            var_dump($request->request->get("attrait_distance_activite_".$tab[$x]->getId()));
                                            $distance->setDistance($request->request->get("attrait_distance_activite_".$tab[$x]->getId()));
                                            $distance->setAttraitId($textes_attrait);
                                            $distance->setActiviteId($tab[$x]->getId());
                                         if($activite != null){
                                            $distance->setNomFr($activite->getNomFr());
                                            $distance->setNomEn($activite->getNomEn());
                                         }
                                            $textes_attrait->addDistances($distance);                            
                                   }else{
                                            $activite = $em->find("MyAppGlobalBundle:Attraits_activites", $tab[$x]->getId());   
                                            $distancePerso = $request->request->get("attrait_distance_activite_".$tab[$x]->getId());
                                            if($distancePerso == null){
                                                $distance->setDistance("");
                                            }else{
                                                $distance->setDistance($distancePerso);
                                            }
                                            $distance->setAttraitId($textes_attrait);
                                            $distance->setActiviteId($tab[$x]->getId());
                                         if($activite != null){
                                            $distance->setNomFr($activite->getNomFr());
                                            $distance->setNomEn($activite->getNomEn());
                                         }
                                            $textes_attrait->addDistances($distance);
                                   }
                                    unset($distance);
                                    unset($activite);
                                }
                                 //Persistance du reste des informations
                                if($imgPricipale == null and $imgMainExist == true){
					$textes_attrait->setImage(PHOTO_PRINCIPALE);
                                        $textes_attrait->setImageDoctrine(null);
				}
				if($imgCategorie == null and $imgCatExist == true){
					$textes_attrait->setPhotoPayante(PHOTO_CATEGORIE);
                                        $textes_attrait->setPhotoPayanteDoctrine(null);
				}
				if($imgLogo == null and $imgLogoExist == true){
					$textes_attrait->setLogo(PHOTO_LOGO);
                                        $textes_attrait->setLogoDoctrine(null);
				} 
				$em->persist($textes_attrait);
				$em->flush();
                                gc_collect_cycles();
                                gc_disable();
				return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $listOption[0]->getId(), 'name' => $name, 'redirect' => $redirect)));
			}
		}                    
                gc_collect_cycles();
		//On prépare la view attraitFiche.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:attraitFiche.html.twig',
				array(
						'annee'					=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'role'					=> $role,
						'id'					=> $id,
						'adminClient'				=> true,
						'formTexteActivite'			=> $form_texte_activite->createView(),
						'listOption'				=> $listOption,
						'txtAttFr'				=> str_replace(array("\r\n"), " ", html_entity_decode($textes_attrait->getTexteDescriptionFr())),
						'txtAttEn'				=> str_replace(array("\r\n"), " ", html_entity_decode($textes_attrait->getTexteDescriptionEn())),
						'pointerAtt'				=> true,
						'attrait'				=> $attrait,
						'attraitExist'				=> $attraitExist,
						'hebergementExiste'			=> $hebergementExiste,
						'nocache'				=> $this->getNoCache(),
						'photoPrincipale'			=> $textes_attrait->getImage(),
						'photoCategorie'			=> $textes_attrait->getPhotoPayante(),
						'photoLogo'				=> $textes_attrait->getLogo(),
						'repertoire'				=> $attrait[0]->getRepertoireFr(),
                                                'redirect'                              => $redirect,
                                                'tabId'                                 => $tab,
                                                'distanceExiste'                        => $distanceExiste,
				));
	}
	
	/**
	 * Accéde aux activités de l'hébergement
	 */
	/*public function activiteHebergementAction($id, $name, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$reference = $tablo = $attraitExist = $type_soin = $hebergementExiste = "";
		gc_enable();
		//On valide les arguments de l'url
		$validRole = new ControleDataSecureController();
		$id = $validRole->getValidInteger($id);
		$name = $validRole->getCleanNameGeography($name, 'name');
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie son rôle
		$role = $validRole->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Ici on regarde la langue pour afficher les listes deroulantes dans la bonne langue
		$lang = $this->container->get('session')->getLocale();
		//Information hébergement
		$hebergement = $em->getRepository("MyAppGlobalBundle:Hebergements")->getRechercheHebergementParRepertoireEtId($id, $name);
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($hebergement[0]->getUtilisateur()->getId());
		//Liste hébergement
		$hebergementExiste = $em->getRepository("MyAppGlobalBundle:Hebergements")->getExistHebergement($listOption[0]->getId());
		//Liste Attrait
		$attraitExist = $em->getRepository("MyAppGlobalBundle:Attraits")->getUtilisateurByAttraitRelationSoins($listOption[0]->getId());
		//On récupère la liste des activités
		$formActivite = $em->getRepository('MyAppGlobalBundle:Hebergements_Activites')->getListActivites();
		//On récupère les id des activités
		$tab = []; 
		foreach($formActivite as $index)
		{
			array_push($tab, $index->getId());
		}
		//On récupère les distances des activités du clients si elles existent
		$distance = $em->getRepository('MyAppGlobalBundle:Distances')->getAfficheDistanceActiviteHebergement($id);
		if($distance != null)
		{
			$reference = $distance;
			//On fusionne les deux tableaux en gardant les valeurs de distances
			$tablo = array_replace($formActivite, $distance);
		}
		//Récupère la liste des activités non triés va nous servir pour l'enregistrement des distances
		$listeActivite = $em->getRepository('MyAppGlobalBundle:Hebergements_activites')->getAfficheListeActiviteHebergement();

		//Récupère les id des activites trier par ASC
		$activiteIdOrder = $em->getRepository('MyAppGlobalBundle:Distances')->getListeLesDistances($id);
		$tableau = [];
		foreach($activiteIdOrder as $ts)
		{
			array_push($tableau, $ts->getId());
		}
		//On récupère les informations de l'hébergement.
		$serviceActivite = $em->find('MyAppGlobalBundle:Hebergements', $id);
		//Formulaire pour les activités
		if($lang == "en")
			$form = $this->createForm(new CustomerActiviteHebergementEnType(), $serviceActivite);
		else
			$form = $this->createForm(new CustomerActiviteHebergementType(), $serviceActivite);

		//On accède à la requête
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			//if( $form->isValid() )
			//{
					$nb = count($tab) + 1;
					if($reference == null)	//Si le client n'a pas encore ajouter de distance aux activités proches
					{			
						for($i = 1; $i < $nb;)
						{
							//if($_POST[$i])
							//{
								$distance = new Distances();
								$distance->setHebergement($id); 				//enregistre id du client
								if($_POST[$i])
								{
									$distance->setDistance($_POST[$i]);			//enregistre la distance
								}
								else 
								{
									$distance->setDistance(0);					
								}
								$distance->setActiviteId($i);					//enregistre l'id de l'activité
								$distance->setNomFr($listeActivite[--$i]->getNomFr());		//enregistre le nom fr on décrémente pour la tableau
								$distance->setNomEn($listeActivite[$i]->getNomEn());		//enregistre le nom en
								++$i;
								$serviceActivite->addDistances($distance)[$i];	//On transmet à la relation hébergements-distances
							//}
							$i++;
						}
					}	
					else //Cas ou le client a ajouté des distances.
					{
						for($i = 1; $i < $nb;)
						{
							if($_POST[$i] != 0)
							{
								if($i <= count($tableau))
								{
									$delete = $em->find("MyAppGlobalBundle:Distances", $tableau[--$i]);
									$em->remove($delete);
									$em->flush();
									++$i;
								}
								$distance = new Distances();
								$distance->setHebergement($id);
								$distance->setDistance($_POST[$i]);
								$distance->setActiviteId($i);
								$distance->setNomFr($listeActivite[--$i]);		//enregistre le nom fr on décrémente pour la tableau
								$distance->setNomEn($listeActivite[$i]);		//enregistre le nom en
								$serviceActivite->addDistances($distance)[++$i];
							}
							$i++;
						}
					}			
				$em->persist($serviceActivite);
				$em->flush();
				gc_collect_cycles();
				gc_disable();
				return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $listOption[0]->getId(), 'redirect' => redirect)));
			//}
		}
		//On prépare la view des activités et services
		return $this->render('MyAppCustomerBundle:MiniSite:activiteHebergement.html.twig',
				array(
						'annee'						=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'role'						=> $role,
						'id'						=> $id,
						'name'						=> $name,
						'listOption'				=> $listOption,
						'form'						=> $form->createView(),
						'pointerActiviteHebergement'    => true,
						'adminClient'				=> true,
						'formActivite'				=> $formActivite,
						'reference' 				=> $reference,
						'tablo'						=> $tablo,
						'attraitExist'				=> $attraitExist,
						'hebergementExiste'			=> $hebergementExiste,
						'hebergementActivite'		=> $hebergement,
						'nocache'					=> $this->getNoCache(),
                                                'redirect'                      => $redirect,
				));
	}*/
	
	/**
	 * Accéde aux services de l'hébergement
	 */
	/*public function serviceHebergementAction($id, $name, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$testing = $attraitExist = $type_soin = $hebergementExiste = "";
		gc_enable();
		//On valide les arguments dans l'url
		$validRole = new ControleDataSecureController();
		$id = $validRole->getValidInteger($id);
		$name = $validRole->getCleanNameGeography($name, 'name');
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie son rôle
		$role = $validRole->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire( $user);
		}
		//Ici on regarde la langue pour afficher les listes deroulantes dans la bonne langue
		$lang = $this->container->get('session')->getLocale();
		//Informations hébergement
		$hebergement = $em->getRepository("MyAppGlobalBundle:Hebergements")->getRechercheHebergementParRepertoireEtId($id, $name);
		//Récupère les informations du client
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($hebergement[0]->getUtilisateur()->getId());
		//Liste hébergement
		$hebergementExiste = $em->getRepository('MyAppGlobalBundle:Hebergements')->getExistHebergement($listOption[0]->getId());
		//Si un attrait existe
		$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getUtilisateurByAttraitRelationSoins($listOption[0]->getId());
		//On récupère les informations de l'hébergement.
		$serviceActivite = $em->find('MyAppGlobalBundle:Hebergements', $hebergement[0]->getId());
		//Formulaire pour les activités et services
		if($lang == "en")
			$form = $this->createForm(new CustomerServiceHebergementEnType(), $serviceActivite);
		else
			$form = $this->createForm(new CustomerServiceHebergementType(), $serviceActivite);
		//On accède à la requête
		$request = $this->get('request');
		
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			//if( $form->isValid() )
			//{
				$em->persist($serviceActivite);
				$em->flush();
				gc_collect_cycles();
				gc_disable();
				return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $listOption[0]->getId())));
			//}
		}
		//On prépare la view serviceHebergement.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:serviceHebergement.html.twig',
				array(
						'annee'						=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'role'						=> $role,
						'id'						=> $id,
						'listOption'				=> $listOption,
						'form'						=> $form->createView(),
						'pointerServiceHebergement'	=> true,
						'adminClient'				=> true,
						'testing' 					=> $testing,
						'name' 						=> $name,
						'attraitExist'				=> $attraitExist,
						'hebergementExiste'			=> $hebergementExiste,
						'hebergementService'		=> $hebergement,
						'nocache'					=> $this->getNoCache(),
                                                'redirect'                      => $redirect,
				));
	}*/
	
	/**
	 * Accéde aux services de l'attrait
	 */
	/*public function serviceAttraitAction($id, $name, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$type_soin = $attraitExist = "";
		$validRole = new ControleDataSecureController();
		$id = $validRole->getValidInteger($id);
		$name = $validRole->getCleanNameGeography($name, 'name');
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie son rôle
		$role = $validRole->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Recherche les informations de l'attrait
		$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getRetourneInformationAttrait($id, $name);
		//Ici on regarde la langue pour afficher la liste des services dans la bonne langue
		$lang = $this->container->get('session')->getLocale();
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($attraitExist[0]->getUtilisateur()->getId());
		//Soins santé
		$type_soin = $em->getRepository('MyAppGlobalBundle:Attraits')->getHebergementByAttraitRelationSoins($attraitExist[0]->getHebergementId()->getId());
		//On récupère l'entity des services.
		$serviceActivite = $em->find('MyAppGlobalBundle:Attraits', $attraitExist[0]->getId());
		//Formulaire pour les activités et services
		if($lang == "en")
			$form = $this->createForm(new CustomerServiceAttraitEnType(), $serviceActivite);
		else
			$form = $this->createForm(new CustomerServiceAttraitType(), $serviceActivite);
		//On accède à la requête
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			//if( $form->isValid() )
			//{
			$em->persist($serviceActivite);
			$em->flush();
			return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $attraitExist[0]->getUtilisateur()->getId() )));
			//}
		}
		//On prépare la view serviceAttrait.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:serviceAttrait.html.twig',
				array(
						'annee'						=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'role'						=> $role,
						'id'						=> $id,
						'listOption'				=> $listOption,
						'form'						=> $form->createView(),
						'pointerServiceAttrait'                 => true,
						'adminClient'				=> true,
						'soinExist'					=> $type_soin,
						'attraitExist'				=> $attraitExist,
						'nocache'					=> $this->getNoCache(),
                                                'redirect'                              => $redirect,
				));
	}*/
	
	/**
	 * Suppression des périodes de haute saison avec ajax
	 */
	public function getPeriodeDeleteAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$periode = '';
			$periode = $request->request->get('periode');
			$em = $this->getDoctrine()->getEntityManager();
			if($periode != ''){
				//Recherche et suppression de la période
				$retourdel = $em->find('MyAppGlobalBundle:Calendrier_saison', $periode);
				$em->remove($retourdel);
				$em->flush();
				return $this->render('MyAppCustomerBundle:MiniSite:delete_periode.xml.twig');
			}
		}
	}
	
	/**
	 * Retourne la liste des images pour l'affichage des vignettes de l'hébergement
	 */
	public function getDisplayThumbnailAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$listeimg = '';
			$listeimg = $request->request->get('listeimg');
			$tabarray = [];
			$tabarray = preg_split("/[\s,]+/", $listeimg);//Supprime les virgules
			$tab = [];
			foreach($tabarray as $tw){
				array_push($tab, (integer)$tw); //cast les id en integer
			}
			$em = $this->getDoctrine()->getEntityManager();
			if($tab != ''){
				//Retourne la liste
				$retourliste = $em->getRepository('MyAppGlobalBundle:Galerie_hebergement')->getDisplayThumbnail($tab);
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_hebergement.xml.twig',
						array(
								'listeimg'	=> $retourliste,
				));
			}
		}
	}
	
	/**
	 * Retourne la liste des images pour l'affichage des vignettes du corporatif
	 */
	public function getDisplayThumbnailCorporateAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$listeimg = '';
			$listeimg = $request->request->get('listeimgcorpo');
			$tabarray = [];
			$tabarray = preg_split("/[\s,]+/", $listeimg);//Supprime les virgules
			$tab = [];
			foreach($tabarray as $tw){
				array_push($tab, (integer)$tw); //cast les id en integer
			}
			$em = $this->getDoctrine()->getEntityManager();
			if($tab != ''){
				//Retourne la liste
				$retourliste = $em->getRepository('MyAppGlobalBundle:Galerie_hebergement')->getDisplayThumbnailCorporate($tab);
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_corporatif.xml.twig',
						array(
								'listeimgcorpo'	=> $retourliste,
						));
			}
		}
	}
	
	/**
	 * Retourne la liste des images pour l'affichage des vignettes galerie chambre
	 */
	public function getDisplayThumbnailRoomAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$listeimg = '';
			$listeimg = $request->request->get('listeimgroom');
			$tabarray = [];
			$tabarray = preg_split("/[\s,]+/", $listeimg);//Supprime les virgules
			$tab = [];
			foreach($tabarray as $tw){
				array_push($tab, (integer)$tw); //cast les id en integer
			}
			$em = $this->getDoctrine()->getEntityManager();
			if($tab != ''){
				//Retourne la liste
				$retourliste = $em->getRepository('MyAppGlobalBundle:Galerie_hebergement')->getDisplayThumbnailRoom($tab);
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_chambre.xml.twig',
						array(
								'listeimgroom'	=> $retourliste,
						));
			}
		}
	}
	
	/**
	 * Retourne la liste des images pour l'affichage des vignettes galerie chambre
	 */
	public function getDisplayThumbnailAttraitAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$listeimg = '';
			$listeimg = $request->request->get('listeimgattrait');
			$tabarray = [];
			$tabarray = preg_split("/[\s,]+/", $listeimg);//Supprime les virgules
			$tab = [];
			foreach($tabarray as $tw){
				array_push($tab, (integer)$tw); //cast les id en integer
			}
			$em = $this->getDoctrine()->getEntityManager();
			if($tab != ''){
				//Retourne la liste
				$retourliste = $em->getRepository('MyAppGlobalBundle:Galerie_attraits')->getDisplayThumbnailAttrait($tab);
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_attrait_client.xml.twig',
						array(
								'listeimgattrait'	=> $retourliste,
						));
			}
		}
	}
	
	/**
	 * Retourne la liste des images pour l'affichage des vignettes galerie forfait
	 */
	public function getDisplayThumbnailPackageAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$listeimg = '';
			$listeimg = $request->request->get('listeimgpackage');
			$tabarray = [];
			$tabarray = preg_split("/[\s,]+/", $listeimg);//Supprime les virgules
			$tab = [];
			foreach($tabarray as $tw){
				array_push($tab, (integer)$tw); //cast les id en integer
			}
			$em = $this->getDoctrine()->getEntityManager();
			if($tab != ''){
				//Retourne la liste
				$retourliste = $em->getRepository('MyAppGlobalBundle:Galerie_hebergement')->getDisplayThumbnailPackage($tab);
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_forfait.xml.twig',
						array(
								'listeimgpackage'	=> $retourliste,
						));
			}
		}
	}
	
	/**
	 * Suppression des images pour la galerie de l'hébergement avec ajax
	 */
	public function getGalerieHebergementDeleteAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$galimgdelete = '';
			$galimgdelete = $request->request->get('galimgdelete');
			$em = $this->getDoctrine()->getEntityManager();
			if($galimgdelete != ''){
				//Recherche et suppréssion de l'image
				$retourdel = $em->find('MyAppGlobalBundle:Galerie_hebergement', $galimgdelete);
                                var_dump($retourdel);
				$em->remove($retourdel);
				$em->flush();
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_hebergement.xml.twig');
			}
		}
	}
	
	/**
	 * Suppression des images pour la galerie de la chambre avec ajax
	 */
	public function getGalerieChambreDeleteAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$galimgdelete = '';
			$galimgdelete = $request->request->get('galimgdelete');
			$em = $this->getDoctrine()->getEntityManager();
			if($galimgdelete != ''){
				//Recherche et suppréssion de l'image
				$retourdel = $em->find('MyAppGlobalBundle:Galerie_photo_chambres', $galimgdelete);
				$em->remove($retourdel);
				$em->flush();
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_chambre.xml.twig');
			}
		}
	}
	
	/**
	 * Suppression des images pour la galerie de la chambre avec ajax
	 */
	public function getGaleriePackageDeleteAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$galimgdelete = '';
			$galimgdelete = $request->request->get('galimgdelete');
			$em = $this->getDoctrine()->getEntityManager();
			if($galimgdelete != ''){
				//Recherche et suppréssion de l'image
				$retourdel = $em->find('MyAppGlobalBundle:Galerie_forfaits', $galimgdelete);
				$em->remove($retourdel);
				$em->flush();
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_forfait.xml.twig');
			}
		}
	}
	
	/**
	 * Suppression des images pour la galerie du corporatif avec ajax
	 */
	public function getGalerieCorporateDeleteAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$galimgdelete = '';
			$galimgdelete = $request->request->get('galimgdelete');
			$em = $this->getDoctrine()->getEntityManager();
			if($galimgdelete != ''){
				//Recherche et suppréssion de l'image
				$retourdel = $em->find('MyAppGlobalBundle:Corporatif_galerie_photo', $galimgdelete);
				$em->remove($retourdel);
				$em->flush();
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_corporatif.xml.twig');
			}
		}
	}
	
	/**
	 * Suppression des images pour la galerie de l'attrait avec ajax
	 */
	public function getGalerieAttraitDeleteAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$galimgdelete = '';
			$galimgdelete = $request->request->get('galimgdelete');
			$em = $this->getDoctrine()->getEntityManager();
			if($galimgdelete != ''){
				//Recherche et suppréssion de l'image
				$retourdel = $em->find('MyAppGlobalBundle:Galerie_attraits', $galimgdelete);
				$em->remove($retourdel);
				$em->flush();
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_attrait_client.xml.twig');
			}
		}
	}
	
	/**
	 * Upload des images de la galerie hébergement
	 */
	public function getGalerieHebergementUploadAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$galimgupload = $id = '';
			$id = $request->request->get('id');
			$galimgupload = $request->request->get('galimgupload');
			$em = $this->getDoctrine()->getEntityManager();
			if($galimgupload != ''){
				$retourupload = $em->find('MyAppGlobalBundle:Hebergements', $id);
				$instancegalery = new Galerie_hebergement();
				$retourupload->addGalerie_hebergement($instancegalery);
				return $this->render('MyAppCustomerBundle:MiniSite:display_gallery_hebergement.xml.twig',
						array(
								'id' => $id,
								'galimgupload' => $retourupload,				
				));
			}
		}
	}
	
	/**
	 * Upload de l'image principale pour l'hébergement
	 */
	public function uploadImgMainHebergementAction(){
            $msg = "";
		if(isset($_FILES['photoPrincipale']) and !isset($_FILES['photoCategorie']) and !isset($_POST["submit"]) ){
                        $em = $this->getDoctrine()->getEntityManager();
                        $id = (new ControleDataSecureController)->getValidInteger($_POST['id']);
                        $hebergement = $em->find("MyAppGlobalBundle:Hebergements", $id);
                        //Dimensions minimum pour l'image
                        $width = 594; $height = 328; $mime = ['image/jpeg', 'image/png'];
                        //regarde la taille
                        try {
                            $retour = getimagesize($_FILES['photoPrincipale']["tmp_name"]);
                          //  var_dump($retour['mime']);
                          //  var_dump(in_array($retour['mime'], $mime));
                            if($retour != null){
                                if($retour[0] < $width or $retour[1] < $height){
                                    $msg = "Les dimensions de la photo principale sont inférieures à ".$width."px de large et ".$height."px de haut.";
                                }
                            }elseif(in_array($retour['mime'], $mime) == false){
                                $msg = "Seulement les images JPG ou PNG sont acceptées.";
                            }  
                        } catch (Exception $ex) {
                            $msg = $ex;
                        }       
                        //Si on a pas de message d'erreur on persist l'image
                        if($msg === "" and $retour[0] >= $width and $retour[1] >= $height and in_array($retour['mime'], $mime)){
                            $fileprincipale = new \Symfony\Component\HttpFoundation\File\UploadedFile($_FILES['photoPrincipale']['tmp_name'], $_FILES['photoPrincipale']['name'], $_FILES['photoPrincipale']["type"], $_FILES['photoPrincipale']["size"], $_FILES['photoPrincipale']['error'], false);       
                            if($fileprincipale != null){
                                $hebergement->setPhotoPayante($fileprincipale);
                                $em->persist($hebergement);
                                $em->flush();
                                $retour = null;                                   
                            }
                        }
		}
                if(isset($_FILES['photoPrincipale']) and !isset($_FILES['photoCategorie'])){
                    return $this->render("MyAppCustomerBundle:MiniSite:FormData.html.twig", array(
                        'photoPrincipale'       => $hebergement->getPhotoPayante(),
                        'id'                    => $hebergement->getId(),
                        'msgerror'              => $msg,
                    ));
                }
	}
        
        /**
         * Upload de l'image de la catégorie pour l'hébergement
         */
        public function uploadImgCategoryHebergementAction(){
            $msg = "";
		if(isset($_FILES['photoCategorie']) and !isset($_FILES['photoPrincipale']) and !isset($_POST["submit"]) ){ 
                    $em = $this->getDoctrine()->getEntityManager();
                    $id = (new ControleDataSecureController)->getValidInteger($_POST['id']);
                    $hebergementCategorie = $em->find("MyAppGlobalBundle:Hebergements", $id);
                    $width = 154; $height = 105; $mime = ['image/jpeg', 'image/png'];
                    //regarde la taille
                    try {
                        $retour = getimagesize($_FILES['photoCategorie']["tmp_name"]);
                      //  var_dump($retour['mime']);
                      //  var_dump(in_array($retour['mime'], $mime));
                        if($retour != null){
                            if($retour[0] < $width or $retour[1] < $height){
                                $msg = "Les dimensions de la photo pour la catégorie sont inférieures à ".$width."px de large et ".$height."px de haut.";
                            }
                        }elseif(in_array($retour['mime'], $mime) == false){
                            $msg = "Seulement les images JPG ou PNG sont acceptées.";
                        }  
                    } catch (Exception $ex) {
                        $msg = $ex;
                    } 
                    //Si on a pas de message d'erreur on persist l'image
                    if($msg === "" and $retour[0] >= $width and $retour[1] >= $height and in_array($retour['mime'], $mime)){
                    $photoCategorie = new \Symfony\Component\HttpFoundation\File\UploadedFile($_FILES['photoCategorie']['tmp_name'], $_FILES['photoCategorie']['name'], $_FILES['photoCategorie']["type"], $_FILES['photoCategorie']["size"], $_FILES['photoCategorie']['error'], false);       
                        if($photoCategorie != null){
                           // $hebergementCategorie->setPhotoCategoriePayanteDoctrine($photoCategorie);
                            $hebergementCategorie->setPhotoCategoriePayante($photoCategorie);
                            $em->persist($hebergementCategorie);
                            $em->flush();
                            $retour = null;
                        }
                    }
                }	
                if(isset($_FILES['photoCategorie']) and !isset($_FILES['photoPrincipale'])){ 
                    return $this->render("MyAppCustomerBundle:MiniSite:FormData_hebergement_img_categorie.html.twig", array(
                        'photoCategorie'        => $hebergementCategorie->getPhotoCategoriePayante(),
                        'id'                    => $hebergementCategorie->getId(),
                        'msgerrorcategorie'     => $msg,
                   ));
                }
        }
        
        /**
         * Upload du logo pour l'hébergement
         */
        public function uploadImgLogoHebergementAction(){
            $msg = $widthlogo = $heightlogo = "";
		if(isset($_FILES['photoLogo']) and !isset($_FILES['photoPrincipale']) and !isset($_POST["submit"]) ){ 
                    $em = $this->getDoctrine()->getEntityManager();
                    $id = (new ControleDataSecureController)->getValidInteger($_POST['id']);
                    $hebergementLogo = $em->find("MyAppGlobalBundle:Hebergements", $id);
                    $width = 200; $height = 280; $mime = ['image/jpeg', 'image/png', 'image/gif'];
                    //regarde la taille
                    try {
                        $retour = getimagesize($_FILES['photoLogo']["tmp_name"]);
                      //  var_dump($retour['mime']);
                      //  var_dump(in_array($retour['mime'], $mime));
                        if($retour != null){
                            if($retour[0] > $width or $retour[1] > $height){
                                $msg = "Les dimensions du logo ne doivent pas être supérieures à ".$width."px de large et ".$height."px de haut.";
                            }
                        }elseif(in_array($retour['mime'], $mime) == false){
                            $msg = "Seulement les images JPG, PNG ou GIF sont acceptées.";
                        }  
                    } catch (Exception $ex) {
                        $msg = $ex;
                    } 
                    //Si on a pas de message d'erreur on persist l'image
                    if($msg === "" and $retour[0] <= $width and $retour[1] <= $height and in_array($retour['mime'], $mime)){
                    $photoLogo = new \Symfony\Component\HttpFoundation\File\UploadedFile($_FILES['photoLogo']['tmp_name'], $_FILES['photoLogo']['name'], $_FILES['photoLogo']["type"], $_FILES['photoLogo']["size"], $_FILES['photoLogo']['error'], false);       
                        if($photoLogo != null){
                           // $hebergementCategorie->setPhotoCategoriePayanteDoctrine($photoCategorie);
                            $hebergementLogo->setLogo($photoLogo);
                            $em->persist($hebergementLogo);
                            $em->flush();
                            $retour = null;
                            $widthlogo = $retour[0];
                            $heightlogo = $retour[1];
                        }
                    }
                }	
                if(isset($_FILES['photoLogo']) and !isset($_FILES['photoPrincipale']) and !isset($_FILES['photoCategorie'])){ 
                    return $this->render("MyAppCustomerBundle:MiniSite:FormData_hebergement_logo.html.twig", array(
                        'photoLogo'        => $hebergementLogo->getLogo(),
                        'id'               => $hebergementLogo->getId(),
                        'msgerrorlogo'     => $msg,
                        'widthlogo'        => $widthlogo,
                        'heightlogo'       => $heightlogo,
                   ));
                }
        }
	
	/**
	 * Upload de l'image principale pour l'attrait
	 */
	public function uploadImgMainAttraitAction()
	{
            $msg = "";
		if(isset($_FILES['photoPrincipale']) and !isset($_FILES['photoCategorie']) and !isset($_POST["submit"]) ){
                        $em = $this->getDoctrine()->getEntityManager();
                        $id = (new ControleDataSecureController)->getValidInteger($_POST['id']);
                        $attrait = $em->find("MyAppGlobalBundle:Attraits", $id);
                        //Dimensions minimum pour l'image
                        $width = 594; $height = 328; $mime = ['image/jpeg', 'image/png'];
                        //regarde la taille
                        try {
                            $retour = getimagesize($_FILES['photoPrincipale']["tmp_name"]);
                          //  var_dump($retour['mime']);
                          //  var_dump(in_array($retour['mime'], $mime));
                            if($retour != null){
                                if($retour[0] < $width or $retour[1] < $height){
                                    $msg = "Les dimensions de la photo principale sont inférieures à ".$width."px de large et ".$height."px de haut.";
                                }
                            }elseif(in_array($retour['mime'], $mime) == false){
                                $msg = "Seulement les images JPG ou PNG sont acceptées.";
                            }  
                        } catch (Exception $ex) {
                            $msg = $ex;
                        }       
                        //Si on a pas de message d'erreur on persist l'image
                        if($msg === "" and $retour[0] >= $width and $retour[1] >= $height and in_array($retour['mime'], $mime)){
                            $fileprincipale = new \Symfony\Component\HttpFoundation\File\UploadedFile($_FILES['photoPrincipale']['tmp_name'], $_FILES['photoPrincipale']['name'], $_FILES['photoPrincipale']["type"], $_FILES['photoPrincipale']["size"], $_FILES['photoPrincipale']['error'], false);       
                            if($fileprincipale != null){
                                $attrait->setImage($fileprincipale);
                                $em->persist($attrait);
                                $em->flush();
                                $retour = null;         
                            }
                        }
		}
                if(isset($_FILES['photoPrincipale']) and !isset($_FILES['photoCategorie'])){
                    return $this->render("MyAppCustomerBundle:MiniSite:FormData_attrait_principale.html.twig", array(
                                    'photoPrincipale'       => $attrait->getImage(),
                                    'id'                    => $attrait->getId(),
                                    'msgerror'              => $msg,
                    ));
                }
	}
        
        /**
         * Upload de l'image de la catégorie pour l'attrait
         */
        public function uploadImgCategoryAttraitAction(){
            $msg = "";
		if(isset($_FILES['photoCategorie']) and !isset($_FILES['photoPrincipale']) and !isset($_POST["submit"]) ){ 
                    $em = $this->getDoctrine()->getEntityManager();
                    $id = (new ControleDataSecureController)->getValidInteger($_POST['id']);
                    $attraitCategorie = $em->find("MyAppGlobalBundle:Attraits", $id);
                    $width = 154; $height = 105; $mime = ['image/jpeg', 'image/png'];
                    //regarde la taille
                    try {
                        $retour = getimagesize($_FILES['photoCategorie']["tmp_name"]);
                      //  var_dump($retour['mime']);
                      //  var_dump(in_array($retour['mime'], $mime));
                        if($retour != null){
                            if($retour[0] < $width or $retour[1] < $height){
                                $msg = "Les dimensions de la photo pour la catégorie sont inférieures à ".$width."px de large et ".$height."px de haut.";
                            }
                        }elseif(in_array($retour['mime'], $mime) == false){
                            $msg = "Seulement les images JPG ou PNG sont acceptées.";
                        }  
                    } catch (Exception $ex) {
                        $msg = $ex;
                    } 
                    //Si on a pas de message d'erreur on persist l'image
                    if($msg === "" and $retour[0] >= $width and $retour[1] >= $height and in_array($retour['mime'], $mime)){
                    $photoCategorie = new \Symfony\Component\HttpFoundation\File\UploadedFile($_FILES['photoCategorie']['tmp_name'], $_FILES['photoCategorie']['name'], $_FILES['photoCategorie']["type"], $_FILES['photoCategorie']["size"], $_FILES['photoCategorie']['error'], false);       
                        if($photoCategorie != null){
                           // $hebergementCategorie->setPhotoCategoriePayanteDoctrine($photoCategorie);
                            $attraitCategorie->setPhotoPayante($photoCategorie);
                            $em->persist($attraitCategorie);
                            $em->flush();
                            $retour = null;
                        }
                    }
                }	
                if(isset($_FILES['photoCategorie']) and !isset($_FILES['photoPrincipale'])){ 
                    return $this->render("MyAppCustomerBundle:MiniSite:FormData_attrait_categorie.html.twig", array(
                                   'photoCategorie'        => $attraitCategorie->getPhotoPayante(),
                                   'id'                    => $attraitCategorie->getId(),
                                   'msgerrorcategorie'     => $msg,
                   ));
                }
        }
        
         /**
         * Upload du logo pour l'attrait
         */
        public function uploadImgLogoAttraitAction(){
            $msg = "";
		if(isset($_FILES['photoLogo']) and !isset($_FILES['photoPrincipale']) and !isset($_FILES['photoCategorie']) and !isset($_POST["submit"]) ){ 
                    $em = $this->getDoctrine()->getEntityManager();
                    $id = (new ControleDataSecureController)->getValidInteger($_POST['id']);
                    $attraitLogo = $em->find("MyAppGlobalBundle:Attraits", $id);
                    $width = 200; $height = 280; $mime = ['image/jpeg', 'image/png', 'image/gif'];
                    //regarde la taille
                    try {
                        $retour = getimagesize($_FILES['photoLogo']["tmp_name"]);
                      //  var_dump($retour['mime']);
                      //  var_dump(in_array($retour['mime'], $mime));
                        if($retour != null){
                            if($retour[0] > $width or $retour[1] > $height){
                                $msg = "Les dimensions du logo ne doivent pas être supérieures à ".$width."px de large et ".$height."px de haut.";
                            }
                        }elseif(in_array($retour['mime'], $mime) == false){
                            $msg = "Seulement les images JPG, PNG ou GIF sont acceptées.";
                        }  
                    } catch (Exception $ex) {
                        $msg = $ex;
                    } 
                    //Si on a pas de message d'erreur on persist l'image
                    if($msg === "" and $retour[0] <= $width and $retour[1] <= $height and in_array($retour['mime'], $mime)){
                    $photoLogo = new \Symfony\Component\HttpFoundation\File\UploadedFile($_FILES['photoLogo']['tmp_name'], $_FILES['photoLogo']['name'], $_FILES['photoLogo']["type"], $_FILES['photoLogo']["size"], $_FILES['photoLogo']['error'], false);       
                        if($photoLogo != null){
                           // $hebergementCategorie->setPhotoCategoriePayanteDoctrine($photoCategorie);
                            $attraitLogo->setLogo($photoLogo);
                            $em->persist($attraitLogo);
                            $em->flush();
                            $retour = null;
                        }
                    }
                }	
                if(isset($_FILES['photoLogo']) and !isset($_FILES['photoPrincipale']) and !isset($_FILES['photoCategorie'])){ 
                    return $this->render("MyAppCustomerBundle:MiniSite:FormData_attrait_logo.html.twig", array(
                                   'photoLogo'        => $attraitLogo->getLogo(),
                                   'id'               => $attraitLogo->getId(),
                                   'msgerrorlogo'     => $msg,
                   ));
                }
        }
	
	/**
	 * Accède à l'hébergement par la fiche client
	 */
	public function texteHebergementAction($id, $name, $redirect)
	{
                $imgLogoExist = $imgMainExist = $imgCatExist = false;
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$texteRoutierFr = $texteRoutierEn = $valide = $attraitExist = $hebergementExist = $type_soin = $photoCategorie = $photoPrincipale = $photoLogo = "";
		gc_enable();
		$msg_confirm_activite = "";//variable pour le message de confirmation que les mises à jour ont réussies
		//On valide les arguments dans l'url
		$validDonnee = new ControleDataSecureController();
		$id = $validDonnee->getValidInteger($id);
		$name = $validDonnee->getCleanNameGeography($name, 'name');
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//on vérifie son rôle
		$role = $validDonnee->getValidRoles($user);
		//Fonction pour la sécurité
		if($role === "ROLE_ADMIN"){
			self::getValideIdAvecNomRepertoire($user);
		}
		//Ici on regarde la langue pour afficher les listes deroulantes dans la bonne langue
		$lang = $this->container->get('session')->getLocale();
		//On recupère les informations de l'hébergement
		$hebergement = $em->getRepository('MyAppGlobalBundle:Hebergements')->getRechercheHebergementParRepertoireEtId($id, $name);
                //informations de l'utilisateur
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($hebergement[0]->getUtilisateur()->getId());
		//Liste d'hébergement
		$hebergementExist = $em->getRepository("MyAppGlobalBundle:Hebergements")->getExistHebergement($listOption[0]->getId());
                //On regarde s'il existe un attrait
		$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getUtilisateurByAttraitRelationSoins($listOption[0]->getId());
		//On récupère les textes de l'hébergement.
		$textes_hebergement = $em->find('MyAppGlobalBundle:Hebergements', $hebergement[0]->getId());  
                //On récupère la liste des activités 
                $formActivite = $em->getRepository("MyAppGlobalBundle:Distances")->getListeLesDistances($textes_hebergement->getId());
                $distanceExiste = true;
                if($formActivite == null){  //Si cet hébergement n'a pas encore de renseigné de distance pour les activités proches
                    $formActivite = $em->getRepository('MyAppGlobalBundle:Hebergements_activites')->getListActivites();
                    $distanceExiste = false;
                }  
		//On récupère les id des activités
		$tab = []; 
		foreach($formActivite as $index)
		{
			array_push($tab, $index);
		}
		//On récupère les images
		if($textes_hebergement->getPhotoPayante() != null)
		{
			$photoPrincipale = $textes_hebergement->getPhotoPayante();
                        $imgMainExist = true;
                        define("PHOTO_PRINCIPALE", $textes_hebergement->getPhotoPayante());
		}
		if($textes_hebergement->getPhotoCategoriePayante() != null)
		{
			$photoCategorie= $textes_hebergement->getPhotoCategoriePayante();
                        $imgCatExist = true;
                        define("PHOTO_CATEGORIE", $textes_hebergement->getPhotoCategoriePayante());
		}
		if($textes_hebergement->getLogo() != null)
		{
			$photoLogo = $textes_hebergement->getLogo();
                        $imgLogoExist = true;
                        define("PHOTO_LOGO", $textes_hebergement->getLogo());
		}
		//Instance des politiques
		$instancePolitiqueFr = new Politique_fr();
		$instancePolitiqueEn = new Politique_en();
		//Formulaire pour les textes de la page hébergement
		if($lang == "fr") //formulaire en français
			$form_hebergement = $this->createForm(new TexteHebergementFicheForm(), $textes_hebergement);
		else 
			$form_hebergement = $this->createForm(new TexteHebergementFicheEnForm(), $textes_hebergement);
		//On accède à la requête
		$request = $this->get('request');	
		//On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form_hebergement->bindRequest($request);
			//On valide que tout est ok dans les données transmisent	
			if ($form_hebergement->isValid()) {
				//Valide les textes descriptions FR et EN.
				$txtdescriptionfr = $validDonnee->getSecureData($form_hebergement->getData()->getTexteDescriptionFr());
				$textes_hebergement->setTexteDescriptionFr($txtdescriptionfr );
				$txtdescriptionen = $validDonnee->getSecureData($form_hebergement->getData()->getTexteDescriptionEn());
				$textes_hebergement->setTexteDescriptionEn( $txtdescriptionen );
				//Traitements des champs images
				$photoPrincipale = $form_hebergement->getData()->getPhotoPayante();       
				if($photoPrincipale != null )
				{
                                    $textes_hebergement->setPhotoPayanteDoctrine(null);
                                    $textes_hebergement->setPhotoPayante($photoPrincipale);
                                }/*else{
                                    $textes_hebergement->setPhotoPayante(null);
                                }*/
                                $photoCategorie = $form_hebergement->getData()->getPhotoCategoriePayante();
				if($photoCategorie != null)
				{   
                                    $textes_hebergement->setPhotoCategoriePayante($photoCategorie);
                                    $textes_hebergement->setPhotoCategoriePayanteDoctrine(null);
                                }/*else{
                                    $textes_hebergement->setPhotoCategoriePayante(null);
                                }*/
				$photoLogo  = $form_hebergement->getData()->getLogo();
				if($photoLogo != null )
				{
                                    $textes_hebergement->setLogo($photoLogo);
                                    $textes_hebergement->setLogoDoctrine(null);
                                }/*else{
                                    $textes_hebergement->setLogo(null);
                                }*/
                                //persist les distances
                                for($x = 1; $x <= count($tab); $x++){     
                                    if($distanceExiste == false){
                                        $distance = new Distances();
                                    }else{
                                        $retourneIdDistance = $em->getRepository("MyAppGlobalBundle:Distances")->getRechercheLesDistancesAvecHebergement($x, $textes_hebergement->getId());
                                        if($retourneIdDistance != null)
                                            $distance = $em->find("MyAppGlobalBundle:Distances", $retourneIdDistance[0]->getId());                      
                                    }
                                    //if($request->request->get("hebergement_distance_activite_".$x) != null){
                                        $activite = $em->find("MyAppGlobalBundle:Hebergements_activites", $x);
                                        $distance->setDistance($request->request->get("hebergement_distance_activite_".$x));
                                        $distance->setHebergementId($textes_hebergement);
                                        $distance->setActiviteId($x);
                                        $distance->setNomFr($activite->getNomFr());
                                        $distance->setNomEn($activite->getNomEn());
                                        $textes_hebergement->addDistances($distance);
                                   // }
                                    unset($distance);
                                    unset($activite);
                                }         
                                //Persistance du reste des informations
                                if($photoPrincipale == null and $imgMainExist == true)
				{
                                    $textes_hebergement->setPhotoPayanteDoctrine(null);
                                    $textes_hebergement->setPhotoPayante(PHOTO_PRINCIPALE);
                                }                      
				if($photoCategorie == null and $imgCatExist == true)
				{   
                                    $textes_hebergement->setPhotoCategoriePayante(PHOTO_CATEGORIE);
                                    $textes_hebergement->setPhotoCategoriePayanteDoctrine(null);
                                }
				if($photoLogo == null and $imgLogoExist == true)
				{
                                    $textes_hebergement->setLogo(PHOTO_LOGO);
                                    $textes_hebergement->setLogoDoctrine(null);
                                }                                                                                              
				$em->persist($textes_hebergement);
				$em->flush();
                               // unset($textes_hebergement);
				gc_collect_cycles();
                                //return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $listOption[0]->getId(), 'redirect' => $redirect, 'rechargement' => "hebergement") ));
                                if($role === "ROLE_ADMIN"){
                                    return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $id, 'name' => $name, 'rechargement' => "hebergement") ));
                                }
                                else{
                                    return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $id, 'name' => $name, 'redirect' => $redirect, 'rechargement' => "hebergement") ));
                                }                                
                      }
		}	
                if($textes_hebergement->getDescriptionHebergementFr() != null){
                    $texteRoutierFr = str_replace(array("\r\n"), " ", html_entity_decode($textes_hebergement->getDescriptionHebergementFr()->getTexteDirectionRoutierePersoFr()));          
                }
                if($textes_hebergement->getDescriptionHebergementEn() != null){
                    $texteRoutierEn = str_replace(array("\r\n"), " ", html_entity_decode($textes_hebergement->getDescriptionHebergementEn()->getTexteDirectionRoutierePersoEn()));
                }
		//Retourne la dernière date de fin 
		$tabLastDateFin = [];
		foreach($textes_hebergement->getCalendrier() as $tw){
			array_push($tabLastDateFin, $tw->getDateFinSaison());
		}
                gc_collect_cycles();                                                                                                    
		//On prépare la view des textes pour l'hébergement
		return $this->render('MyAppCustomerBundle:MiniSite:hebergementFiche.html.twig',
                        array(
                                'annee'					=> date('Y'),
                                'name_admin'				=> $user->getUsername(),
                                'role'					=> $role,
                                'id'					=> $id,
                                'adminClient'				=> true,
                                'formTexteHebergement'                  => $form_hebergement->createView(),
                                'listOption'				=> $listOption,
                                'txtAttFr'				=> str_replace(array("\r\n"), " ", html_entity_decode($textes_hebergement->getTexteDescriptionFr())),
                                'txtAttEn'				=> str_replace(array("\r\n"), " ", html_entity_decode($textes_hebergement->getTexteDescriptionEn())),
                                'txtRoutierFr'				=> $texteRoutierFr,
                                'txtRoutierEn'				=> $texteRoutierEn,
                                'msgConfirmActivite'                    => $msg_confirm_activite,
                                'pointerHeb'				=> true,
                                'photoPrincipale'			=> $photoPrincipale,
                                'photoLogo'				=> $photoLogo,
                                'photoCategorie'			=> $photoCategorie,
                                'saisonnier'				=> $textes_hebergement->getSaisonnier(),
                                'attraitExist'				=> $attraitExist,
                                'hebergementExiste'			=> $hebergementExist,
                                'lat'					=> $textes_hebergement->getLatitude(),
                                'long'					=> $textes_hebergement->getLongitude(),
                                'nocache'				=> $this->getNoCache(),
                                'lastdatefin'				=> array_pop($tabLastDateFin),
                                'redirect'                              => $redirect,
                                'tabId'                                 => $tab,
                                'distanceExiste'                        => $distanceExiste,
                                'imgMainExist'                          => $imgMainExist,    
                                'acompte'                               => $textes_hebergement->getAcompteId()->getId(),
                        ));
	}
        
	
	/**
	 * Lister les coupons rabais
	 */
	public function rabaisCouponAction($id, $name, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$type_soin = $attraitExist = "";
		//On valide les arguments dans l'url
		$validateur = new ControleDataSecureController();
		$name = $validateur->getCleanNameGeography($name, "name");
		$id = $validateur->getValidInteger($id);
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validateur->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerHebergement($id, $name);
		if($listOption == null)//attraits
		{
			$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerAttrait($id, $name);
			//Soins santé
			$type_soin = $em->getRepository('MyAppGlobalBundle:Attraits')->getAttraitRelationSoins($listOption[0]->getId());
		}else{
			//Soins santé
			$type_soin = $em->getRepository('MyAppGlobalBundle:Attraits')->getHebergementByAttraitRelationSoins($listOption[0]->getId());
			//Si un attrait existe
			$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getHebergementByAttrait($listOption[0]->getId());
		}	
		
		$coupon = $em->getRepository('MyAppGlobalBundle:Utilisateur')->searchCouponduClient($listOption[0]->getId());		
		//On prépare la view listecoupon.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:listecoupon.html.twig',
				array(
						'annee'						=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'role'						=> $role,
						'id'						=> $id,
						'coupons'					=> $coupon,
						'adminClient'				=> true,
						'pointerCoupon'				=> true,
						'listOption'				=> $listOption,
						'attraitExist'				=> $attraitExist,
						'soinExist'					=> $type_soin,
						'nocache'					=> $this->getNoCache(),
                                                'redirect'                              => $redirect
				));
	}
	
	/**
	 * Ajouter un coupon
	 */
	public function addrabaisCouponAction($id, $name, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$attraitExist = $type_soin = "";
		//On valide les arguments dans l'url
		$validateur = new ControleDataSecureController();
		$name = $validateur->getCleanNameGeography($name, "name");
		$id = $validateur->getValidInteger($id);
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validateur->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerHebergement($id, $name);
		if($listOption == null)//attraits
		{
			$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerAttrait($id, $name);
			//Soins santé
			$type_soin = $em->getRepository('MyAppGlobalBundle:Attraits')->getAttraitRelationSoins($listOption[0]->getId());
		}else{
			//Soins santé
			$type_soin = $em->getRepository('MyAppGlobalBundle:Attraits')->getHebergementByAttraitRelationSoins($listOption[0]->getId());
			//Si un attrait existe
			$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getHebergementByAttrait($listOption[0]->getId());
		}
		//Construction du formulaire pour l'ajout d'un coupon
		$coupon = new Coupons();
		//$form = $this->createForm(new AddForfaitsClientType($id), array($forfait, $id));
		$form = $this->createForm(new AddCouponType(), $coupon);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				//On valide si les champs images contiennent une valeur pour ne pas écraser leurs valeurs dans la BD
				$imgfr = $form->getData()->getImageDoctrineFr();
				if($imgfr != null)
					$coupon->setImageFr($imgfr);
				$imgen = $form->getData()->getImageDoctrineEn();
				if($imgen != null)
					$coupon->setImageEn($imgen);
				// On n'enregistre notre objet $coupon dans la base de données.
				$coupon->setCouponId($listOption[0]->getId());
				$coupon->setRepertoireFr($listOption[0]->getRepertoireFr());
				$coupon->setRepertoireEn($listOption[0]->getRepertoireEn());
				$em->persist($coupon);
				$em->flush();
				echo 'Coupon ajouté avec succés !';
				//On redirige vers la liste des forfaits.
				return $this->redirect($this->generateUrl('MyAppCouponRabais', array('id' => $id, 'name' => $name, 'redirect' => redirect)));
			}
		}
		//On prépare la view forfaits.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:coupons.html.twig',
				array(
						'annee'						=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'role'						=> $role,
						'id'						=> $id,
						'name'						=> $name,
						'listOption'				=> $listOption,
						'adminClient'				=> true,
						'pointerCoupon'				=> true,
						'form'						=> $form->createView(),
						'exist'						=> "test",
						'attraitExist'				=> $attraitExist,
						'soinExist'					=> $type_soin,
						'nocache'					=> $this->getNoCache(),
                                                'redirect'                              => $redirect,
				));
	}
	
	/**
	 * Modifier un coupon
	 */
	public function updaterabaisCouponAction($id, $name, $couponid, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$attraitExist = $type_soin = "";
		//On valide les arguments dans l'url
		$validateur = new ControleDataSecureController();
		$name = $validateur->getCleanNameGeography($name, "name");
		$id = $validateur->getValidInteger($id);
		$couponid = $validateur->getValidInteger($couponid);
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validateur->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerHebergement($id, $name);
		if($listOption == null)
		{
			$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerAttrait($id, $name);
			//Soins santé
			$type_soin = $em->getRepository('MyAppGlobalBundle:Attraits')->getAttraitRelationSoins($listOption[0]->getId());
		}else{
			//Soins santé
			$type_soin = $em->getRepository('MyAppGlobalBundle:Attraits')->getHebergementByAttraitRelationSoins($listOption[0]->getId());
			//Si un attrait existe
			$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getHebergementByAttrait($listOption[0]->getId());
		}
		//Construction du formulaire pour l'ajout d'un coupon
		$coupon = $em->find('MyAppGlobalBundle:Coupons', $couponid);
		//$form = $this->createForm(new AddForfaitsClientType($id), array($forfait, $id));
		$form = $this->createForm(new AddCouponType(), $coupon);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				//On valide si les champs images contiennent une valeur pour ne pas écraser leurs valeurs dans la BD
				$imgfr = $form->getData()->getImageDoctrineFr();
				if($imgfr != null)
					$coupon->setImageFr($imgfr);
				$imgen = $form->getData()->getImageDoctrineEn();
				if($imgen != null)
					$coupon->setImageEn($imgen);
				// On enregistre notre objet $coupon dans la base de données.
				$coupon->setCouponId($listOption[0]->getId());
				$em->persist($coupon);
				$em->flush();
				echo 'Coupon modifié avec succés !';
				//On redirige vers la liste des forfaits.
				return $this->redirect($this->generateUrl('MyAppCouponRabais', array('id' => $id, 'name' => $name)));
			}
		}
		//On prépare la view coupons.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:coupons.html.twig',
				array(
						'annee'						=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'role'						=> $role,
						'id'						=> $id,
						'name'						=> $name,
						'listOption'				=> $listOption,
						'pointerCoupon'				=> true,
						'adminClient'				=> true,
						'form'						=> $form->createView(),
						'exist'						=> true,
						'infonamefr'				=> $coupon->getTitreFr(),
						'infonameen'				=> $coupon->getTitreEn(),
						'infoimgfr'					=> $coupon->getImageFr(),
						'infoimgen'					=> $coupon->getImageEn(),
						'infocouponid'				=> $coupon->getId(),
						'repertoire'				=> $coupon->getrepertoireFr(),
						'attraitExist'				=> $attraitExist,
						'soinExist'					=> $type_soin,
						'nocache'					=> $this->getNoCache(),
                                                'redirect'                              => $redirect,
				));
	}
	
	/**
	 * Action pour supprimer les coupons rabais
	 */
	public function deleterabaisCouponAction($idcoupon, $idclient, $name, $redirect)
	{   
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$validateur = new ControleDataSecureController();
		//On valide les id en arguments
		$idcoupon = $validateur->getValidInteger($idcoupon);
		$idclient = $validateur->getValidInteger($idclient);
		$name = $validateur->getCleanNameGeography($name, "name");
		//Gestionnaire d'entité
		$em = $this->getDoctrine()->getEntityManager();
		//On regarde si le client à d'autre coupon sera utile pour la redirection
		$couponExist = $em->getRepository('MyAppGlobalBundle:Utilisateur')->searchCouponduClient($idclient);
		//Nombre de coupon
		$nbCoupon = sizeof($couponExist);
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerHebergement($idclient, $name);
		if($listOption == null)
		{
			$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getExistOptionCustomerAttrait($idclient, $name);
		}
		//On récupère le coupon à supprimer
		$coupons = $em->find('MyAppGlobalBundle:Coupons', $idcoupon);
		$em->remove($coupons);
		$em->flush();
		//On redirige vers la page d'accueil des coupons ou sinon vers l'accueil du compte
		if($nbCoupon != null)
			return $this->redirect($this->generateUrl('MyAppCouponRabais', array('id' => $listOption[0]->getId(), 'name' => $listOption[0]->getRepertoireFr(), 'redirect' => $redirect)));
		else 
			return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $listOption[0]->getId(), 'name' => $listOption[0]->getRepertoireFr(), 'redirect' => $redirect)));
	}
	
	public  function getOrdreAffichageChambreAction()
	{
		$request = $this->container->get('request');
		if($request->isXmlHttpRequest())
		{
			$listroom = '';
			$listroom = $request->request->get('ordre');
			$tabarray = [];
			$tabarray = preg_split("/[\s,]+/", $listroom);//Supprime les virgules
			$tab = [];
			foreach($tabarray as $tw){
				array_push($tab, (integer)$tw); //cast les id en integer
			}
			$em = $this->getDoctrine()->getEntityManager();
			if($tab != ''){
				//Enregistre la position de classement d'affichage des chambres
				for($i = 0; $i < count($tab); $i++){
					$chambre = $em->find('MyAppGlobalBundle:Chambres', $tab[$i]);
					$chambre->setOrdreAffichage($i);
					$em->persist($chambre);
					$chambre = null;
				}				
				$em->flush();
				return $this->render('MyAppCustomerBundle:MiniSite:sortablechambre.xml.twig');
			}
		}
	}
	
	/**
	 * Section chambre administration du client.
	 */
	public function listeChambreAction($id, $name, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$chambre = $attraitExist = $hebergementExiste = $type_soin =  "";
		//On valide les arguments dans l'url
		$validateur = new ControleDataSecureController();
		$id = $validateur->getValidInteger($id);
		$name = $validateur->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validateur->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Récupère les informations de l'hébergement.
		$hebergement = $em->getRepository('MyAppGlobalBundle:Hebergements')->getRechercheHebergementParRepertoireEtId($id, $name);		
                //Information utilisateur
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($hebergement[0]->getUtilisateur()->getId());
		//Liste hébergement
		$hebergementExiste = $em->getRepository("MyAppGlobalBundle:Hebergements")->getExistHebergement($listOption[0]->getId());
		if($hebergement != null){
			//Recherche les chambres du client
			$chambreAvecType = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreTypeEtablissement($hebergement[0]->getId());
			//Recherche les chambres du clients mais qui sont sans type
			$chambreSansType = $em->getRepository("MyAppGlobalBundle:Chambres")->getListeChambreEtablissement($hebergement[0]->getId()); 
			if(count($chambreAvecType) >= count($chambreSansType)){
				$chambre = $chambreAvecType;
			}else{
				$chambre = $chambreSansType;
			}
			//Liste attraits
			$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getUtilisateurByAttraitRelationSoins($listOption[0]->getId());
		} 
		//On prépare la view listechambre.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:listechambre.html.twig',
				array(
						'annee'				=> date('Y'),
						'name_admin'			=> $user->getUsername(),
						'role'				=> $role,
						'id'				=> $id,
						'chambre'			=> $chambre,
						'adminClient'			=> true,
						'listOption'			=> $listOption,
						'attraitExist'			=> $attraitExist,
						'hebergementExiste'		=> $hebergementExiste,
						'hebergementChambre'		=> $hebergement,
						'nocache'			=> $this->getNoCache(),
                                                'redirect'                      => $redirect,
				));
	}
	
	/**
	 * Ajouter ou modifier une chambre compte client
	 */
	public function addChambreAction($idclient, $name, $idchambre, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$nomChambre = $vide = $periodeHauteSaison = $typeChambre = $infoid = $infoname = $infoimg = $type_soin = $attraitExist = $hebergementExiste = "";
		gc_enable();
		//On valide les arguments dans l'url
		$validateur = new ControleDataSecureController();
		$idclient = $validateur->getValidInteger($idclient);
		($idchambre != "idchambre")? $idchambre = $validateur->getValidInteger($idchambre): "";
		$name = $validateur->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validateur->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire( $user);
		}
		//Information hébergement
		$hebergement = $em->getRepository("MyAppGlobalBundle:Hebergements")->getRechercheHebergementParRepertoireEtId($idclient, $name);
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($hebergement[0]->getUtilisateur()->getId());
		//Liste hébergement
		$hebergementExiste = $em->getRepository("MyAppGlobalBundle:Hebergements")->getExistHebergement($listOption[0]->getId());
		//Liste attrait
		$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getUtilisateurByAttraitRelationSoins($listOption[0]->getId());		
		if($idchambre == "idchambre")
		{
			//Construction du formulaire pour l'ajout d'une chambre
			$chambre = new Chambres();
			//Période haute saison
			$periodeHauteSaison = $hebergement[0]->getCalendrier();
			$exist = false;
		}
		else{
			//Construction du formulaire pour la modification d'une chambre
			$chambre = $em->find('MyAppGlobalBundle:Chambres', $idchambre);
			$infoid = $chambre->getId();	// On récupère l'id
			$infoname = $chambre->getNomfr(); 	// le nom fr
			$infoimg = $chambre->getPhoto1();	// et l'image du forfait
			//Période haute saison
			$periodeHauteSaison = $em->getRepository("MyAppGlobalBundle:Calendrier_saison")->getRetourneListePrixChambre($chambre->getId());
			if($periodeHauteSaison == null){
				$periodeHauteSaison = $em->getRepository("MyAppGlobalBundle:Hebergements")->getRetournePeriodeHauteSaison($hebergement[0]->getId());
				$vide = true;
			}                        
			$exist = true;	
		}
		//On regarde la langue pour charger le bon formulaire
		if($this->get('session')->getLocale() == "fr"){
			$form = $this->createForm(new AddClientChambreType(), $chambre);
		}
		else{
			$form = $this->createForm(new AddClientChambreENType(), $chambre);
		}
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			    if($form->isValid())
			    {
					//On valide si le champ image contient une valeur pour ne pas écraser sa valeur dans la BD
					$img = $form->getData()->getPhoto1Doctrine();
					if($img != null){
						$chambre->setPhoto1($img);
					}
					//On écrit l'id de l'hébergement dans la relation
					$hebergement2 = $em->find('MyAppGlobalBundle:Hebergements', $idclient);
					$chambre->setHebergement($hebergement2);
					//On regarde s'il existe un prix dans la table hébergement et si oui si le prix est plus grand que le prix
					//de cette chambre alors on fait la mise à jour dans la table hébergement
					if($hebergement2->getPrixAPartir() == null){
						$hebergement2->setPrixAPartir($form->getData()->getTarifMinBasseSaison());
					}else{
						if($hebergement2->getPrixAPartir() > $form->getData()->getTarifMinBasseSaison())
							$hebergement2->setPrixAPartir($form->getData()->getTarifMinBasseSaison());
					}
					//On regarde si on a un ordre d'affichage
					if($form->getData()->getOrdreAffichage() == null){
						$ordre = $em->getRepository("MyAppGlobalBundle:Chambres")->getCompteListeChambreTypeEtablissement($hebergement2->getId());
						$chambre->setOrdreAffichage((integer)$ordre[0]['nbchambre'] + 1);
					}
					if($exist == false){
						$prix = new Types_prix();
						$chambre->addTypes_prix($prix, $em);
					}else{
						$resultPrix = $em->getRepository("MyAppGlobalBundle:Calendrier_saison")->getRetourneListePrixChambre($chambre->getId());					
						for($i = 0; $i < count($resultPrix); $i++ ){
							$prix = $em->find("MyAppGlobalBundle:Types_prix", $resultPrix[$i]->getId());
							$chambre->addTypes_prix($prix, $em);
						}
					}
					//On l'enregistre notre objet $chambre dans la base de données.
					$em->persist($chambre);
					$em->flush();
					//Enregistre les prix des autres hautes saisons personnalisées
					if($exist === false){ //ajout
						//Retourne la dernière chambre enregistrée pour cet hébergement
						$derniereChambreRec = $em->getRepository("MyAppGlobalBundle:Chambres")->getReturnLastRecoder($hebergement[0]->getId());
						foreach($chambre->getHebergement()->getCalendrier() as $tw){
							//Si les champs des périodes sont remplis	
							if(!empty($_POST['prixperiodemin'.$tw->getId()]) and !empty($_POST['prixperiodemax'.$tw->getId()]) ){
								$prixmin = $validateur->getCleanPrice( $_POST['prixperiodemin'.$tw->getId()]);
								$prixmax = $validateur->getCleanPrice( $_POST['prixperiodemax'.$tw->getId()]);
								$instancePrix = new Types_prix();
								//hydratation de l'instance Types_prix
								$instancePrix = $this->hydrateEntityTypePrix($instancePrix, $prixmax, $prixmin, $tw, $derniereChambreRec[0]['id']);
								$chambre->addTypes_prix($instancePrix, $em);
								$em->persist($instancePrix);
								$em->flush();
								$instancePrix = $prixmin = $prixmax = null;
							}
						}
					}else{ //Mise à jour
						if($vide == ""){	//Si le client a des périodes renseignées
							foreach($periodeHauteSaison as $tw){
								//si les champs des périodes sont remplis
								$prixmin = $validateur->getCleanPrice( $_POST['prixperiodemin'.$tw->getId()]);
								$prixmax = $validateur->getCleanPrice( $_POST['prixperiodemax'.$tw->getId()]);
								$instancePrix = $em->find('MyAppGlobalBundle:Types_prix', $tw->getId());
								//modification de l'instance Types_prix
								$instancePrix = $this->hydrateEntityTypePrix($instancePrix, $prixmax, $prixmin, $tw, $infoid);
								$chambre->addTypes_prix($instancePrix, $em);
								$em->persist($instancePrix);
								$em->flush();
								$instancePrix = $prixmin = $prixmax = null;
							}
						}else{ //Si les périodes sont vides
							foreach($periodeHauteSaison as $value){
								foreach($value->getCalendrier() as $tw){
									//si les champs des périodes sont remplis
									if(!empty($_POST['prixperiodemin'.$tw->getId()]) and !empty($_POST['prixperiodemax'.$tw->getId()]) ){
										$prixmin = $validateur->getCleanPrice( $_POST['prixperiodemin'.$tw->getId()]);
										$prixmax = $validateur->getCleanPrice( $_POST['prixperiodemax'.$tw->getId()]);
										$instancePrix = $em->find('MyAppGlobalBundle:Types_prix', $tw->getId());
										//modification de l'instance Types_prix
										$instancePrix = $this->hydrateEntityTypePrix($instancePrix, $prixmax, $prixmin, $tw, $infoid);
										$chambre->addTypes_prix($instancePrix, $em);
										$em->persist($instancePrix);
										$em->flush();
										$instancePrix = $prixmin = $prixmax = null;
									}
								}
							}
						}
					}
					gc_collect_cycles();
					gc_disable();
					echo 'Chambre ajoutée avec succés !';
					//On redirige vers la liste des chambre.
					return $this->redirect($this->generateUrl('MyAppChambre', array('id' => $idclient, 'name' => $name, 'redirect' => $redirect)));
			 }
		}
		//On contrôle si des chambres sont déjà existantes
		if($chambre->getId() != null){
			if(count($chambre->getTypeChambreId()) >= 1 ){
				$typeChambre = $chambre->getTypeChambreId()[0]->getNomFr();	
			}
		}
                if($chambre->getNomFr() != null and $exist == true){
                    $nomChambre = $infoname;
                }
                elseif($chambre->getNomFr() == null and $exist == true){
                    $nomChambre = $typeChambre;
                }             
		//On prépare la view chambre.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:chambre.html.twig',
                    array(
                        'annee'					=> date('Y'),
                        'name_admin'				=> $user->getUsername(),
                        'role'					=> $role,
                        'idchambre'				=> $infoid,
                        'idclient'				=> $hebergement[0]->getId(),
                        'name'					=> $nomChambre,
                        'repertoire'				=> $hebergement[0]->getRepertoirefr(),
                        'infoimg'				=> $infoimg,
                        'listOption'				=> $listOption,
                        'adminClient'				=> true,
                        'form'					=> $form->createView(),
                        'exist'					=> $exist,
                        'soinExist'				=> $type_soin,
                        'attraitExist'				=> $attraitExist,
                        'hebergementExiste'			=> $hebergementExiste,
                        'nocache'				=> $this->getNoCache(),
                        'periodeHauteSaison'                    => $periodeHauteSaison,	
                        'vide'                                  => $vide,
                        'redirect'                              => $redirect,
                        'id'                                    => $idclient,
                    ));
	}
	
	/**
	 * Méthode pour hydrater l'entity type de prix en relation avec la chambre
	 */
	private function hydrateEntityTypePrix( $instancePrix, $prixmax, $prixmin, $object, $chambreid)
	{
		$instancePrix->setPrixMin($prixmin);
		$instancePrix->setPrixMax($prixmax);
		$instancePrix->setCalendrierId($object->getId());
		$instancePrix->setTitreHauteSaisonFr($object->getTitreHauteSaisonFr());
		$instancePrix->setTitreHauteSaisonEn($object->getTitreHauteSaisonEn());
		$instancePrix->setDateDebutSaison($object->getDateDebutSaison());
		$instancePrix->setDateFinSaison($object->getDateFinSaison());
		$instancePrix->setIndexChambre($chambreid);
		return $instancePrix;
	}
	
	
	/**
	 * Supprimer chambre administration compte client.
	 */
	public function deletechambreAction($idclient, $name, $idchambre)
	{
		//On valide les arguments
		$validateur = new ControleDataSecureController();
		$idchambre = $validateur->getValidInteger($idchambre);
		$idclient = $validateur->getValidInteger($idclient);
		$name = $validateur->getCleanNameGeography($name, 'name');
		//Gestionnaire d'entité
		$em = $this->getDoctrine()->getEntityManager();
                //Recherche l'hébergement avec son id et son repertoire pour valider avant la supprésion
                $client = $em->getRepository("MyAppGlobalBundle:Hebergements")->getRechercheHebergementParRepertoireEtId($idclient, $name);
		//On regarde si le client à d'autre chambre sera utile pour la redirection
		$chambreExist = $em->getRepository('MyAppGlobalBundle:Chambres')->getListeChambreTypeEtablissement($client[0]->getId());
                if($chambreExist == null){
                    $chambreExist = $em->getRepository("MyAppGlobalBundle:Chambres")->getListeChambreEtablissement($client[0]->getId());
                }
		//Nombre de chambre
		$nbChambre = sizeof($chambreExist);
                //Récupère les informations du client.
                $listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($client[0]->getId());
		//On récupère la chambre à supprimer
		$chambre = $em->find('MyAppGlobalBundle:Chambres', $idchambre);
		$em->remove($chambre);
		$em->flush();
		//On redirige vers la page d'accueil des chambres ou sinon vers l'accueil du compte
		if($nbChambre != null)
			return $this->redirect($this->generateUrl('MyAppChambre', array('id' => $chambreExist[0]->getHebergement()->getId(), 'name' => $chambreExist[0]->getHebergement()->getRepertoireFr())));
		else
			return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $listOption[0]->getId())));
	}
	
	
	/**
	 * Section corporatif (administration compte client).
	 */
	public function corporatifAction($id, $name, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$type_soin = $attraitExist = "";
		$validateur = new ControleDataSecureController();
		$id = $validateur->getValidInteger($id);
		$name = $validateur->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validateur->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Récupère l'hébergement
		$hebergement = $em->getRepository("MyAppGlobalBundle:Hebergements")->getRechercheHebergementParRepertoireEtId($id, $name);
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($hebergement[0]->getUtilisateur()->getId());
		//Recherche les corporatifs du client
		$corporatif = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getListSalleCorporative($hebergement[0]->getId());
		//Soins santé
		$type_soin = $em->getRepository('MyAppGlobalBundle:Attraits')->getHebergementByAttraitRelationSoins($listOption[0]->getId());
		//Si un attrait existe
		$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getRechercheAttraitParUtilisateur($listOption[0]->getId());
		//On prépare la view listechambre.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:listecorporative.html.twig',
				array(
						'annee'					=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'role'					=> $role,
						'id'					=> $id,
						'corporatif'				=> $corporatif,
						'adminClient'				=> true,
						'listOption'				=> $listOption,
						'soinExist'				=> $type_soin,
						'attraitExist'				=> $attraitExist,
						'nocache'				=> $this->getNoCache(),
						'hebergementExiste'			=> $hebergement,
                                                'redirect'                              => $redirect,
                                                'pointercorpo'                          => true,
				));
	}
	
	/**
	 * Ajouter ou modifier un corporatif (administration compte client)
	 */
	public function addCorporatifAction($idclient, $name, $idcorpo, $redirect)
	{
                ($redirect == "menu_hebergement" or $redirect == "menu_attrait")? $redirect : $redirect = "";
		$infoid = $infoname = $infoimg = $attraitExist = $type_soin = "";
		//On valide les arguments dans l'url
		$validateur = new ControleDataSecureController();
		$idclient = $validateur->getValidInteger($idclient);
		($idcorpo != "idcorpo")?$idcorpo = $validateur->getValidInteger($idcorpo): "" ;
		$name = $validateur->getCleanNameGeography($name, "name");
		//Gestionnaire des entités
		$em = $this->getDoctrine()->getEntityManager();
		//Récupère le nom de la personne qui accède à l'administration
		$user = $this->container->get('security.context')->getToken()->getUser();
		//On vérifie son rôle
		$role = $validateur->getValidRoles($user);
		if($role === "ROLE_ADMIN"){
			//Fonction pour la sécurité
			self::getValideIdAvecNomRepertoire($user);
		}
		//Récupère l'hébergement
		$hebergement = $em->getRepository("MyAppGlobalBundle:Hebergements")->getRechercheHebergementParRepertoireEtId($idclient, $name);
                //Constante pour l'adresse courriel corpo
                define("EMAILCORPO", $hebergement[0]->getEmailCorporatif());
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($hebergement[0]->getUtilisateur()->getId());
		//Soins santé
		$type_soin = $em->getRepository('MyAppGlobalBundle:Attraits')->getHebergementByAttraitRelationSoins($listOption[0]->getId());
		//Si un attrait existe
		$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getRechercheAttraitParUtilisateur($listOption[0]->getId());
		if($idcorpo == "idcorpo")
		{
			//Construction du formulaire pour l'ajout d'un corporatif
			$corpo = new Hebergements_salles_corporatives();
			$exist = false;
		}
		else{
			//Construction du formulaire pour la modification d'un corporatif
			$corpo = $em->find('MyAppGlobalBundle:Hebergements_salles_corporatives', $idcorpo);
			$infoid = $corpo->getId();	// On récupère l'id
			$infoname = $corpo->getNomfr(); 	// le nom fr
			$exist = true;
		}
		$form = $this->createForm(new AddSalleCorporatifType(), $corpo);
		// On récupère la requête.
		$request = $this->get('request');
		// On vérifie qu'elle est de type « POST ».
		if( $request->getMethod() == 'POST' )
		{
			// On fait le lien Requête <-> Formulaire.
			$form->bindRequest($request);
			// On vérifie que les valeurs rentrées sont correctes.
			if( $form->isValid() )
			{
				//On valide si les champs files ne sont pas vides pour ne pas écraser leur valeur dans la BD.
				$fileFr = $form->getData()->getFichierListeSallesFrDoctrine();
				if($fileFr != null)
				{
					$corpo->setFichierListeSallesFr($fileFr);
				}
				$fileEn = $form->getData()->getFichierListeSallesEnDoctrine();
				if($fileEn != null)
				{
					$corpo->setFichierListeSallesEn($fileEn);
				}
				$planFr = $form->getData()->getFichierPlanSallesFrDoctrine();
				if($planFr != null)
				{
					$corpo->setFichierPlanSallesFr($planFr);
				}
				$planEn = $form->getData()->getFichierPlanSallesEnDoctrine();
				if($planEn != null)
				{
					$corpo->setFichierPlanSallesEn($planEn);
				}
				//On récupère les dimensions pour ne pas avoir de valeurs décimales on vérifie si le client a rentré une valeur un point ou une virgule
					//Profondeur en mètre
				$profondeurM = number_format($form->getData()->getProfondeurMetre(), 0, ',', '' );
				$profondeurM = number_format($profondeurM, 0, ',', '' );
				$corpo->setProfondeurMetre($profondeurM);
					//Profondeur en pouce
				$profondeurP = number_format($form->getData()->getProfondeur(), 0, ',', '' );
				$profondeurP = number_format($profondeurP, 0, ',', '' );
				$corpo->setProfondeur($profondeurP);
					//Largeur en mètre
				$largeurM = number_format($form->getData()->getLargeurMetre(), 0, ',', '' );
				$largeurM = number_format($largeurM, 0, ',', '' );
				$corpo->setLargeurMetre($largeurM);
					//Largeur en pouce
				$largeurP = number_format($form->getData()->getLargeur(), 0, ',', '' );
				$largeurP = number_format($largeurP, 0, ',', '' );
				$corpo->setLargeur($largeurP);
				//On écrit l'id de l'hébergement dans la relation
				$hebergement = $em->find('MyAppGlobalBundle:Hebergements', $idclient);
				$corpo->setSalleCorporativeHebergement($hebergement);
				// On l'enregistre notre objet $corpo dans la base de données.
				$em->persist($corpo);
				$em->flush();
				echo 'Corporatif ajouté avec succés !';
				//On redirige vers la liste des chambre.
				return $this->redirect($this->generateUrl('MyAppCorporatif', array('id' => $idclient, 'name' => $name, 'redirect' => $redirect)));
			}
		}
		//On prépare la view corporatif.html.twig
		return $this->render('MyAppCustomerBundle:MiniSite:corporatif.html.twig',
				array(
						'annee'					=> date('Y'),
						'name_admin'				=> $user->getUsername(),
						'role'					=> $role,
						'idcorpo'				=> $infoid,
						'id'					=> $hebergement[0]->getId(),
						'name'					=> $infoname,
						'repertoire'				=> $hebergement[0]->getRepertoirefr(),
						'listOption'				=> $listOption,
						'adminClient'				=> true,
						'form'					=> $form->createView(),
						'exist'					=> $exist,
						'corporatif'				=> $corpo,
						'listePdfFr'				=> $corpo->getFichierListeSallesFr(),
						'listePdfEn'				=> $corpo->getFichierListeSallesEn(),
						'planPdfFr'				=> $corpo->getFichierPlanSallesFr(),
						'planPdfEn'				=> $corpo->getFichierPlanSallesEn(),
						'soinExist'				=> $type_soin,
						'attraitExist'				=> $attraitExist,
						'nocache'				=> $this->getNoCache(),
						'hebergementExiste'			=> $hebergement,
                                                'redirect'                              => $redirect,
                                                'pointeurcorpo'                         => true,
                                                'emailCorpo'                            => EMAILCORPO,
				));
	}
	
	/**
	 * Supprimer un corporatif (administration compte client).
	 */
	public function deleteCorporatifAction($idclient, $name, $idcorpo, $redirect)
	{
		//On valide les arguments
		$validateur = new ControleDataSecureController();
		$idcorpo = $validateur->getValidInteger($idcorpo);
		$idclient = $validateur->getValidInteger($idclient);
		$name = $validateur->getCleanNameGeography($name, 'name');
		//Gestionnaire d'entité
		$em = $this->getDoctrine()->getEntityManager();
		//On regarde si le client à d'autre corporatif sera utile pour la redirection
		$corpoExist = $em->getRepository('MyAppGlobalBundle:Hebergements_salles_corporatives')->getAfficheSalleCorporativeAdmin($idcorpo);
		//Récupère les informations du client.
		$listOption = $em->getRepository('MyAppGlobalBundle:Utilisateur')->getRetourneIdOptionUtilisateur($corpoExist[0]->getSalleCorporativeHebergement()->getUtilisateur()->getId());
		//On récupère le corpo à supprimer
		$corpo = $em->find('MyAppGlobalBundle:Hebergements_salles_corporatives', $idcorpo);
		$em->remove($corpo);
		$em->flush();
		//On redirige vers la page d'accueil des corporatifs ou sinon vers l'accueil du compte
		if(sizeof($corpoExist) > 1){
			return $this->redirect($this->generateUrl('MyAppCorporatif', array('id' => $corpoExist[0]->getSalleCorporativeHebergement()->getId(), 'name' => $corpoExist[0]->getSalleCorporativeHebergement()->getRepertoireFr(), 'redirect' => $redirect)));
		}else{
			return $this->redirect($this->generateUrl('_Dashboard_compteCustomer', array('id' => $listOption[0]->getId(), 'redirect' => $redirect)));
		}
	}
	
	/**
	 * Fonction sécurité des comptes clients elle valide que l'id et le nom du repertoire concorde bien sinon on déconnecte
	 */
	private function getValideIdAvecNomRepertoire($user)
	{
		//Gestionnaire d'entité
		$em = $this->getDoctrine()->getEntityManager();
		//Liste hébergement
		$hebergementExist = $em->getRepository('MyAppGlobalBundle:Hebergements')->getExistHebergement($user->getId());
		//Liste attrait
		$attraitExist = $em->getRepository('MyAppGlobalBundle:Attraits')->getUtilisateurByAttraitRelationSoins($user->getId());
		$informationClient = [$hebergementExist, $attraitExist];
		//On vérifie les droits
		$role = (new ControleDataSecureController)->getValidRoles($user);
		if($informationClient === null && $role === "ROLE_ADMIN" or $role === "ROLE_ADMIN" and $user->getIsActive() === false )
		{
			echo '<script>window.alert("Ce client n\'existe pas \r / This customer did not exist ");</script>';
			//$this->get('session')->getFlashBag()->add("Ce client n\'existe pas \r This customer did not exist ");
			session_destroy();
			unset($session);
			unset($user);
			return $this->redirect($this->generateUrl('logout'));
		}
	}
	
	/**
	 * Méthode pour le traitement d'envoie des courriels pour la demande de publication des tarifs
	 */
	private function getEnvoyerEmailAGlobalInfo($hebergement, $forfait)
	{
                $messageInfo = "";
		//Variable du formulaire de soumission pour la demande d'information.
		//$email = $hebergement->getUtilisateur()->getEmail();
                //if($email == null){
                    $email = "test@global-reservation.com";
                   // $messageInfo = "Ce client n'a pas d'adresse courriel dans son compte.";
               // }
                $nomForfait = $forfait->getNomFr();
                $numeroClient = $hebergement->getUtilisateur()->getUsername();
                $nomHebergement = $hebergement->getNomFr();
                //Création du message               
                $message = \Swift_Message::newInstance()
                                                    ->setSubject("Demande de validation d'un tarif de dernière minute du client ".$numeroClient )
                                                    ->setContentType('text/html')
                                                    ->setFrom($email)
                                                    ->setTo("info@global-reservation.com") 
                                                    ->setBody(
                                                        $this->renderView(
                                                            'MyAppGlobalBundle:Hebergement:body_emailInfo.html.twig',
                                                            array(
                                                                    'nomForfait'     => $nomForfait,
                                                                    'numeroClient'   => $numeroClient,
                                                                    'nomHebergement' => $nomHebergement,
                                                                    'date'           => date('Y'),
                                                                    'messageinfo'    => $messageInfo,
                                                            )
                                                        )
                                                    );
                //$message->embed(\Swift_Image::fromPath("Bg-GR.png"));
		//$message->attach(\Swift_Attachment::fromPath("Bg-GR.png"));
                //Envoie du message
                $this->get('mailer')->send($message);
                return "confirmation";
                
	}
}
