<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddTypesSoinsForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom_fr', 'text')
		->add('nom_en', 'text')
                ->add('repertoire_fr', 'text')
		->add('repertoire_en', 'text')
		->add('metakeyword_fr', 'text', array("required" => false))
		->add('metakeyword_en', 'text', array("required" => false))
		->add('metadescription_fr')
		->add('metadescription_en')
		->add('texte_fr', 'textarea', array("required" => false))
		->add('texte_en', 'textarea', array("required" => false))
		->add('resume_fr', 'textarea', array("required" => false))
		->add('resume_en', 'textarea', array("required" => false))
		->add('image_doctrine', 'file', array("required" => false))
		;
	}

	public function getName()
	{
		return 'add_typesoin';
	}
}