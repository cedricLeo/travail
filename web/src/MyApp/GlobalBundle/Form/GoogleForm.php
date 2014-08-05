<?php
namespace MyApp\GlobalBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GoogleForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
			->add('province', 'entity', array('class' => 'MyAppGlobalBundle:Provinces_etats', 'property' => 'nom_fr'))
			//->add('province', 'entity', array('class' => 'MyAppGlobalBundle:Provinces_etats', 'property' => 'nom_en'))
			->add('region', 'entity', array('class' => 'MyAppGlobalBundle:Regions', 'property' => 'nom_fr'))
			//->add('region', 'entity', array('class' => 'MyAppGlobalBundle:Regions', 'property' => 'nom_en'))
			->add('hebergement', 'radio', array('required' => false))
			->add('forfait', 'radio', array('required' => false))
			->add('corporatif', 'radio', array('required' => false))
			->add('centresante', 'radio', array('required' => false))
			->add('attrait', 'radio', array('required' => false))
			->add('destination', 'radio', array('required' => false))
			->add('restaurant', 'radio', array('required' => false));
	}

	public function getName()
	{
		return 'google';
	}
}