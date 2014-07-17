<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class AddDescriptionFrType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('texte_generale_chambre_fr', 'textarea', array("required" => false))
		->add('texte_direction_routiere_perso_fr', 'textarea', array("required" => false))
		->add('description_promotion_fr', 'textarea', array("required" => false))
		;
	}

	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Description_fr',
		);
	}

	public function getName()
	{
		return 'add_description_fr';
	}
}