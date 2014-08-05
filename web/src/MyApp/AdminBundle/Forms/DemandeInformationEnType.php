<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * 
 * @author leonardc
 * 
 * Formulaire de demande d'information pour le corporatif
 *
 */
class DemandeInformationEnType extends AbstractType
{	
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
			->add('salle', 'radio', array("required" => false))
			->add('hebergement', 'radio', array("required" => false))
			->add('salle_hebergement', 'radio', array("required" => false))
			->add('prenom', 'text', array("required" => true))
			->add('nom', 'text', array("required" => true))
			->add('courriel', 'text', array("required" => true))
			->add('nom_entreprise', 'text', array("required" => false))
			->add('adresse', 'text', array("required" => false))
			->add('ville', 'text', array("required" => false))
			->add('province', 'text', array("required" => false))
			->add('code_postal', 'text', array("required" => false))
			->add('pays', 'text', array("required" => false))
			->add('telephone', 'text', array("required" => true))
			->add('telecopieur', 'text', array("required" => false))
			->add('nombre_chambre', 'choice', array('choices' => array('nd' => 'N/D', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '+20' => '+20' )))
			->add('simple', 'checkbox', array("required" => false))
			->add('simple_double', 'checkbox', array("required" => false))
			->add('double', 'checkbox', array("required" => false))
			->add('suite', 'checkbox', array("required" => false))
			->add('demandes_specifiques', 'textarea', array("required" => false))
			->add('nom_reunion', 'text', array("required" => false))
			->add('nombre_personne', 'text', array("required" => false))
			->add('type_evenement', 'choice', array('choices' => array('bal_finissant' => 'Bal de finissants', 'banquet' => 'Banquet', 'comite' => 'Comité', 'conference_presse' => 'Conférence de presse', 'congres' => 'Congrés', 'formation' => 'Formation', 'groupe_sportif' => 'Groupe sportif', 'groupe_touristique' => 'Groupe touristique', 'mariage' => 'Mariage', 'recrutement' => 'Recrutement', 'reunion_conseil' => 'Réunion de conseil', 'reunion_motivation' => 'Réunion de motivation', 'salon' => 'Salon', 'salon_professionel' => 'Salon professionel', 'seance_reflexion' => 'Séance de réflexion', 'vente' => 'Vente', 'autres' => 'Autres')) )
			->add('date_arrivee', 'text', array("required" => true))
			->add('date_depart', 'text', array("required" => true))
			->add('vos_dates_flexibles', 'choice', array('choices' => array('nb' => 'N/D', 'oui' => 'Yes', 'non' => 'No')))		
			->add('disposition_salle', 'choice', array('choices' => array('banquet' => 'Banquet', 'carre_ouvert' => 'Open square', 'chevrons' => 'Rafters', 'conference' => 'Conference', 'demi_lune' => 'Half moon', 'ecole' => 'School', 'ent' => 'in T', 'enu' => 'in U', 'salon_commercial' => 'Tradshow', 'theatre' => 'Theatre', 'autres' => 'Other')))
			->add('decrire_equipement', 'textarea', array("required" => false))
			//->add('captcha', 'captcha')
		;
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$collectionConstraint = new Collection(array(
				'nom' => new MinLength(5),
				'prenom' => new MinLength(3),
				'courriel' => new Email(array('message' => 'Invalid email address')),
				'telephone' => new MinLength(12),
				'date_arrivee' => new NotBlank(),
				'date_depart' => new NotBlank(),
		));
	
		$resolver->setDefaults(array(
				'constraints' => $collectionConstraint
		));
	}

	public function getName()
	{
		return 'add_demande_information';
	}
}