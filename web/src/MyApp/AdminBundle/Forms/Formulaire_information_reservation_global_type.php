<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use MyApp\GlobalBundle\Entity\Zones;

class Formulaire_information_reservation_global_type extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
			->add('prenom', 'text', array("required" => true))
			->add('nom', 'text', array("required" => true))
			->add('adresse', 'text', array("required" => false))
			->add('ville', 'text', array("required" => false))
			->add('province', 'text', array("required" => false))
			->add('pays', 'text', array("required" => false))
			->add('code_postal', 'text', array("required" => false))
			->add('telephone', 'text', array("required" => true))
			->add('telecopieur', 'text', array('required' => false))
			->add('courriel', 'email', array('required' => true))
			->add('date_arrive', 'text', array('required' => true))
			->add('date_depart', 'text', array('required' => true))
			->add('nombre_adulte', 'number', array('required' => true))
			->add('nombre_enfant', 'number', array('required' => false))
			->add('age_enfant', 'text', array('required' => false))
			->add('nombre_chambre', 'number', array('required' => true))
			->add('chambre_fumeur', 'checkbox', array("required" => false))
			->add('demande_specifique', 'textarea', array("required" => false))
			//->add('captcha', 'captcha')
			;
	}

	public function getName()
	{
		return 'add_demande_global_reservation';
	}
}