<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Moteur_recherche_clientForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom', 'text', array('required' => false));
	}

	public function getName()
	{
		return 'add_enginesearch';
	}
}