<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class AddTextesAttraitFrType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('texte_resume_fr', 'textarea', array("required" => true))
		->add('texte_periode_ouverture_fr', 'textarea', array("required" => false))
		;
	}

	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Textes_attrait_fr',
		);
	}

	public function getName()
	{
		return 'add_texte_attrait_fr';
	}
}