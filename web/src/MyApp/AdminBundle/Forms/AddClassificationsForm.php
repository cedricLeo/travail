<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddClassificationsForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('valeur', 'text')
		->add('file', 'file', array("required" => false))
		;
	}

	public function getName()
	{
		return 'add_classification';
	}
}