<?php
namespace MyApp\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{

	public function loginAction()
	{
		$request = $this->getRequest();
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('MyAppAdminBundle:Security:login.html.twig', array(
                    // last username entered by the user
                        'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                        'error'         => $error,
        		'date_now' 		=> new \DateTime("now"),
        		'annee'    		=> date("Y"),
        ));
	}

	public function recoverPasswordAction()
	{
		$annee_en_cours = date('Y');
		 
		//Formulaire demande adresse courriel pour envoit du mot de passe
		$em = $this->getDoctrine()->getEntityManager();
		$user = new Utilisateurs();
		$form = $this->container->get('form.factory')->create(new recoverPasswordForm(), $user);
		 
		//Contr�le si l'adresse courriel se trouve dans la bd
		if(isset($email))
		{
			$user = $em->find('MyAppAdminBundle:Utilisateurs', $email);
			if(!email)
			{
				$message = "Cette adresse courriel n'existe pas.";
			}
			else
			{
				$message = "Vous avez reçu un message.";
			}
		}

		return $this->render('MyAppAdminBundle:Default:recoverPassword.html.twig',
				array(
						'form'  => $form->createView(),
						'annee' => $annee_en_cours,
				)
		);
	}
	
	/**
	 * Action entreprise lors de la déconnexion.
	 * Redirection vers la page de login
	 */
	public function logoutAction()
	{
		session_destroy();
		//Redirection vers la page de login pour éviter le taux de rebond
		return $this->redirect($this->generateUrl('login'));
	}
}
