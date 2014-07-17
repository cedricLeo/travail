<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TriClientValidationForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('statut', 'choice', array('choices' => array('1' => 'clients actifs', '0' => 'clients non actifs', '2' => 'par ville'), 'required' => false))
		;
	}

	public function getName()
	{
		return 'add_tri_validation';
	}
}