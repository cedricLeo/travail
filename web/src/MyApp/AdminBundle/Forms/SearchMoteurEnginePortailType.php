<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SearchMoteurEnginePortailType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom', 'text', array("required" => false))
		;
	}

	public function getName()
	{
		return 'moteur_recherche_portail';
	}
}