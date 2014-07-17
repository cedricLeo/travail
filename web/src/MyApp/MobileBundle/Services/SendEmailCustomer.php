<?php

namespace MyApp\MobileBundle\Email;

/**
 * Description of SendEmailCustomer
 *
 * @author leonardc
 */
class SendEmailCustomer {
   
    protected $name;
    protected $client;
    protected $lang;
    
    public function __construct(\Swift_Mailer $name, $client, $lang) {
        $this->name = $name;
        $this->client = $client;
        $this->lang = $lang;
    }
    
    /**
     * Méthode d'envoie de courriel pour les fiches clients
     */
    public function getEnvoyerEmailAGlobal($name, $client, $lang)
    {
		//Variable du formulaire de soumission pour la demande d'information.
		$prenom = $name['prenom'];
		$nom = $name['nom'];
		$email = $name['courriel'];
		$telephone = $name['telephone'];
		$datebegin = $name['date_arrive'];
		$dateend = $name['date_depart'];
		$adresse = $name['adresse'];
		$ville = $name['ville'];		
		$codePostal = $name['code_postal'];
		$nbChambre = $name['nombre_chambre'];
		$demandeSpecifique = $name['demande_specifique'];
		$nbPersonne = $name['nombre_adulte'];
		$nbEnfant = $name['nombre_enfant'];
		$ageEnfant = $name['age_enfant'];
		$chambreFumeur = $name['chambre_fumeur'];
		//Création du message
		$message = \Swift_Message::newInstance()
                        ->setSubject("Demande " .$client[0]->getNomFr())
                        ->setContentType('text/html')
                        ->setFrom($email)
                        ->setTo("reservation@global-reservation.com")
                        //->setReplyTo('"Global-reservation" <reservation@global-reservation.com>')
                        ->setBody(
                            $this->renderView(
                                'MyAppMobileBundle:Hebergement:body_emailReservation.html.twig',
                                    array('nom'    			=> ucfirst($nom),
                                          'prenom' 			=> ucfirst($prenom),
                                          'email'                       => $email,
                                          'telephone' 			=> $telephone,
                                          'datebegin' 			=> $datebegin,
                                          'dateend'   			=> $dateend,
                                          'adresse'                     => $adresse,
                                          'ville'			=> $ville,                                         
                                          'codepostal'			=> $codePostal,         
                                          'demandespecifique'           => $demandeSpecifique,
                                          'nbChambre'			=> $nbChambre,
                                          'nbEnfant'                    => $nbEnfant,
                                          'ageEnfant'                   => $ageEnfant,
                                          'nbPersonne'			=> $nbPersonne,
                                          'fumeur'                      => $chambreFumeur,
                                          'lang'                        => $lang,
                                          'etablissement'               => $client[0]->getNomFr(),
                                          'dateNow'                     => new \DateTime("now"),
                                    )
                            )
                        );
		//Envoie du message
		$this->get('mailer')->send($message);
		return "confirmation";                
	}
    
    /*public function getEnvoyerEmailAGlobal()
    {
        echo "toto";
    }*/
    
    
}
