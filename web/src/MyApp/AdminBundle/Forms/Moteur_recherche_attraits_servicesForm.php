<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use MyApp\GlobalBundle\Entity\Attraits_services;

class Moteur_recherche_attraits_servicesForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom_fr', 'text', array('required' => false));
	}

	public function getName()
	{
		return 'add_enginesearch';
	}
}