<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class AddPolitiqueFrType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		//->add('politique_generale_fr', 'textarea', array("required" => false))
		//->add('politique_animaux_fr', 'textarea', array("required" => false))
		//->add('politique_annulation_fr', 'textarea', array("required" => false))
		->add('politique_tarif_fr', 'textarea', array("required" => false))
		//->add('politique_annulation_forfait_fr', 'textarea', array("required" => false))
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Politique_fr',
		);
	}

	public function getName()
	{
		return 'add_politique_fr';
	}
}