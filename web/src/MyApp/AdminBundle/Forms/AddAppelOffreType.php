<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * 
 * @author leonardc
 * 
 * Formulaire pour l'appel d'offre
 */
class AddAppelOffreType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('prenom', 'text', array('required' => true))
		->add('nom', 'text', array('required' => true))
		->add('email', 'text', array('required' => true))
		->add('nom_entreprise', 'text', array('required' => false))
		->add('adresse', 'text', array('required' => true))
		->add('ville', 'text', array('required' => true))
		->add('province_etat', 'text', array('required' => true))
		->add('code_postal', 'text', array('required' => true))
		->add('pays_offre', 'text', array('required' => false))
		->add('telephone', 'text', array('required' => true))
		->add('telecopieur', 'text', array('required' => false))
		->add('nb_chambre', 'choice', array('choices' => array('0' => '10', '1' => '11', '2' => '12', '3' => '13', '4' => '14', '5' => '15', '6' => '16', '7' => '17', '8' => '18', '9' => '19', '10' => '20+')))
		->add('type_chambre', 'choice', array('choices' => array('0' => 'Simple', '1' => 'Double', '2' => 'Suite et double', '3' => 'Suite'), 'expanded' => true))
		->add('demande_specifique_hebergement', 'textarea', array('required' => false))
		->add('description_equipement', 'textarea', array('required' => false))
		->add('nom_reunion', 'text', array('required' => false))
		->add('nb_personne', 'text', array('required' => false))
		->add('date_arrivee', 'date', array('required' => true, 'years' => range(date('Y'), date('Y') + 10)))
		->add('date_depart', 'date', array('required' => true, 'years' => range(date('Y'), date('Y') + 10)))
		->add('date_flexible', 'choice', array('choices' => array('0' => 'Non', '1' => 'Oui')))
		->add('pays_offre', 'text', array('required' => false))
		->add('type_event_id', 'entity', array( 'class' => 'MyAppGlobalBundle:Types_evenements', 
												'required' => true,
												'query_builder' => function(EntityRepository $er){
												return $er->createQueryBuilder('l')->orderBy('l.nom_fr','ASC');
 												}));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
					  'data_class' => 'MyApp\GlobalBundle\Entity\Appel_Offre',
					);
	}

	public function getName()
	{
		return 'add_appel_offre';
	}
}