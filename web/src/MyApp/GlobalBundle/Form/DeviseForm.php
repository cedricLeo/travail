<?php
namespace MyApp\GlobalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
 
 class DeviseForm extends AbstractType
 {
 	public function buildForm(FormBuilder $builder, array $options)
 	{
 		$builder
 			->add('symbole', 'entity', array('class' => 'MyAppGlobalBundle:Devises'))
 			->add('abreviationfr', 'entity', array('class' => 'MyAppGlobalBundle:Devises'))
 			->add('taux_current', 'entity', array('class' => 'MyAppGlobalBundle:Devises'));
 	}
 	
 	public function getName()
 	{
 		return 'devise';
 	}
 }