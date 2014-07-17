<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use MyApp\GlobalBundle\Entity\Attraits;
use MyApp\GlobalBundle\Controller\ControleDataSecureController;
/**
 * 
 * @author leonardc
 * Classe qui valide les données du formulaire pour les attraits si tout est ok renvoie dans le controlleur des attraits
 *
 */
class AttraitsHandler{
	
	protected $form;
    protected $request;
    protected $em;
    protected $user;

    public function __construct(Form $form, Request $request, EntityManager $em, $user)
    {
        $this->form    		= $form;
        $this->request 		= $request;
        $this->em      		= $em;
        $this->user      	= $user->getUsername();
    }
    
    public static function getForm()
    {
    	return $this->form;
    }
	
	public function process()
	{	
		// On vérifie qu'elle est de type « POST ».
		if($this->request->getMethod() == "POST")
		{
			// On fait le lien Requête <-> Formulaire.
			$this->form->bindRequest($this->request);
			
			//if($this->form->isValid())
			//{
				$this->onSuccess($this->form->getData());
				return true;
			//}
		}
		return false;
	}
	
	//fonction qui remplit le rôle de validation 
	public function onSuccess(Attraits $attrait)
	{	

		$validDonnee = new ControleDataSecureController();
		//Valide les textes descriptions FR et EN.
		//$txtfr = $validDonnee->getSecureData($_POST['editor1'], 'editor1');
		//$txten = $validDonnee->getSecureData($_POST['editor2'], 'editor2');
		//$attrait->setTexteDescriptionFr(strip_tags($txtfr));
		//$attrait->setTexteDescriptionEn(strip_tags($txten));
		//Ici on valide les valeurs des coordonnées gps et on remplace la virgule par un point.
		//$attrait->setLatitude($validDonnee->getFormatValueGps($form->getData()->getLatitude()));
		//$attrait->setLongitude($validDonnee->getFormatValueGps($form->getData()->getLongitude()));
		//Ici on ajoute un espace au milieu du code postal
		//$codePostal = $validDonnee->getCodePostalAddSpace($form->getData()->getCodePostal());
		//$attrait->setCodePostal($codePostal);
		//On vérifie que la valeur du champ photo est pas vide
		//$img = $form->getData()->getImageDoctrine();
		//if($img != null)
		//{
		//	$attrait->setImage($img);
		//}
		//On valide l'image du logo si le champ est pas vide
		//$logo = $form->getData()->getLogoDoctrine();
		//if($logo != null)
		//{
		//	$attrait->setLogo($logo);
		//}
		//Grande Image
	//	$grandeImage = $form->getData()->getPhotoPayanteDoctrine();
	//	if($grandeImage != null)
		//{
		//	$attrait->setPhotoPayante($grandeImage);
		//}
		//Et là les horaires de l'attrait dans la table «HORAIRES»
		$this->em->persist($attrait->getLundiMatinEte());
		//On enregistre qui a valider l'attrait
		//$attrait->setValiderPar($user->getUsername());
		//On finit de traiter le reste des informations qui ne demandent pas une validation particulière
		
		$this->em->persist($attrait);
		foreach($attrait->getGalery() as $img)
		{
			$this->em->persist($img);
		}
		$this->em->flush();
	}
	
}