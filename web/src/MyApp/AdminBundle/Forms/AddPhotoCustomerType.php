<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * 
 * @author leonardc
 *
 */
class AddPhotoCustomerType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('photo_payante_doctrine', 'file', array("required" => false))
		->add('photo_categorie_payante_doctrine', 'file', array("required" => false))
		->add('logo_doctrine', 'file', array("required" => false))
		->add('galery_id', 'collection', array(
												'type' => new GaleryType(),
												'allow_add' => true,
											  ))
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Hebergements',
		);
	}

	public function getName()
	{
		return 'add_photo_customer';
	}
}