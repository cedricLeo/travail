<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 *
 * @author leonardc
 *
 */
class AddPhotoCustomerAttraitType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('image_doctrine', 'file', array("required" => false))
		->add('photo_payante_doctrine', 'file', array("required" => false))
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
				'data_class' => 'MyApp\GlobalBundle\Entity\Attraits',
		);
	}

	public function getName()
	{
		return 'add_photo_customer_attrait';
	}
}