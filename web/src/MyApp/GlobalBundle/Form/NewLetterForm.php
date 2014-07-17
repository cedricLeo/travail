<?php
namespace MyApp\GlobalBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NewLetterForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
				->add('courriel', 'text', array('required' => false));
	}
	
	public function getName()
	{
		return 'newletter';
	}
}