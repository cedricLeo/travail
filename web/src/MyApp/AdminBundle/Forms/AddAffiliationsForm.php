<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddAffiliationsForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom_fr', 'text')
		->add('nom_en', 'text')
		->add('image_doctrine', 'file', array("required" => false))
		;
	}

	public function getName()
	{
		return 'add_affiliation';
	}
}