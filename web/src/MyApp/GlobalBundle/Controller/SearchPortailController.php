<?php
namespace MyApp\GlobalBundle\Controller;
use Doctrine\ORM\EntityManager;
use MyApp\AdminBundle\Forms\SearchMoteurEnginePortailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use MyApp\GlobalBundle\Entity\Utilisateur;

/**
 * 
 * @author leonardc
 *
 */
class SearchPortailController extends Controller{

	/**
	 * Traitement du moteur de recherche
	 */
	public function getRechercheMoteurDeRecherche()
	{
		//Gestionnaire des entités
		$em  = $this->getDoctrine()->getEntityManager();
		//Moteur de recherche
		$client = new Utilisateur();
		$formEngine = $this->container->get('form.factory')->create(new SearchMoteurEnginePortailType(), $client);
		$request = $this->get('request');
		if($request->getMethod() != "POST")
		{
			return array("form", $formEngine);
		}
		else
		{
			//$request = $this->get('request');
			if( $request->getMethod() == 'POST' ){
				// On fait le lien Requête <-> Formulaire.
				$formEngine->bindRequest($request);
				$word = $formEngine->getData()->getNom();
				if($word != null)
				{
					$rep = (new DefaultController)->getMoteurRechercheAction($word, $em);
					if($rep != null)
					{
						if($rep[1] == "hebergement")
							return array("request", $this->redirect($this->generateUrl('_hebergementinfoclient', array( 'name' => strtolower($rep[0][0]->getRepertoireFr()) ))));
					}
					else
					{
						return array("request", $this->redirect($this->generateUrl('_hebergementrestaurant', array( 'name' => strtolower($rep[0][0]->getRepertoireFr()) ))));
					}
					if(!$rep) {
						// throw $this->createNotFoundException('The product does not exist');
						throw new \Exception("Aucun résultat trouvé");
					}
				}
				//return $this->redirect($this->generateUrl('homepage'), 404);
			}
		}
	}
	
}