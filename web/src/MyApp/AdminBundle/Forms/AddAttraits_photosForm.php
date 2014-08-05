<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddAttraits_photosForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('image_doctrine', 'file', array('required' => false))		
		->add('legende1_fr', 'text', array('required' => false))	
		->add('legende1_en', 'text', array('required' => false))
		//->add('hebergement_id', 'entity', array('class' => 'MyAppGlobalBundle:Hebergements', 'property' => 'nom_fr','required' => true))
		->add('attraitsId', 'entity', array('class' => 'MyAppGlobalBundle:Attraits', 'property' => 'nom_fr','required' => true))
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
					'virtual' => true
				);
	}

	public function getName()
	{
		return 'add_photo_attrait';
	}
}