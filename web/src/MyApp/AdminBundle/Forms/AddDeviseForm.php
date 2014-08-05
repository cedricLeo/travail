<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use MyApp\GlobalBundle\Entity\Devises;

class AddDeviseForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('abreviation', 'text')
		->add('symbole', 'text')
		->add('tauxchange', 'text', array('required' => false))
		;
	}

	public function getName()
	{
		return 'add_devise';
	}
}