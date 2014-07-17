<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class AddDescriptionEnType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('texte_generale_chambre_en', 'textarea', array("required" => false))
		->add('texte_direction_routiere_perso_en', 'textarea', array("required" => false))
		->add('description_promotion_en', 'textarea', array("required" => false))
		;
	}

	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Description_en',
		);
	}

	public function getName()
	{
		return 'add_description_en';
	}
}