<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class AddPolitiqueAttraitClientEnType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('politique_generale_en', 'textarea', array("required" => false))
		->add('politique_animaux_en', 'textarea', array("required" => false))
		->add('politique_annulation_en', 'textarea', array("required" => false))
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Politique_en',
		);
	}

	public function getName()
	{
		return 'add_politique_en';
	}
}