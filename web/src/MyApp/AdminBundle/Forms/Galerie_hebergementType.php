<?php 
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * 
 * @author leonardc
 *
 */
class Galerie_hebergementType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('legende_fr', 'text', array("required" =>false))
		->add('legende_en', 'text', array("required" => false))
		->add('image', 'file', array("required" => false))
		->add('id', 'hidden', array("required" => false))
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Galerie_hebergement',
		);
	}

	public function getName()
	{
		return 'galerie_hebergement';
	}
}