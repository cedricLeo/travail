<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GooglemapsAPIType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('adresse', 'text')
		->add('latitude', 'text', array("required" => false))
		->add('longitude', 'text', array("required" => false))
		;
	}

	public function getName()
	{
		return 'add_google';
	}
}