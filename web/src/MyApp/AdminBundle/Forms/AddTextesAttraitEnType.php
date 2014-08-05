<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class AddTextesAttraitEnType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('texte_resume_en', 'textarea', array("required" => true))
		->add('texte_periode_ouverture_en', 'textarea', array("required" => false))
		;
	}

	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Textes_attrait_en',
		);
	}

	public function getName()
	{
		return 'add_texte_attrait_en';
	}
}