<?php 
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddCouponType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('titre_fr', 'text', array("required" => true))
		->add('titre_en', 'text', array("required" => true))
		->add('description_fr', 'textarea', array("required" => true))
		->add('description_en', 'textarea', array("required" => true))
		->add('specification_fr', 'text', array("required" => false))
		->add('specification_en', 'text', array("required" => false))
		->add('image_doctrine_fr', 'file', array("required" => false))
		->add('image_doctrine_en', 'file', array("required" => false))
		->add('expiration_fr', 'text', array("required" => false))
		->add('expiration_en', 'text', array("required" => false))
		->add('date_expiration', 'date', array("required" => false, 'years' => range(date('Y'), date('Y') + 10)))
		->add('credit_photo', 'text', array("required" => false))
		;
	}

	public function getName()
	{
		return 'add_coupon';
	}
}