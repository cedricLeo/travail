<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddCuisinesForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom_fr', 'text')
		->add('nom_en', 'text')
                ->add('repertoire_fr', 'text')
		->add('repertoire_en', 'text')
		->add('page_metakeyword_fr', 'text')
		->add('page_metakeyword_en', 'text')
		->add('page_metadescription_fr', 'textarea')
		->add('page_metadescription_en', 'textarea')
		->add('texte_fr', 'textarea')
		->add('texte_en', 'textarea')
		;
	}

	public function getName()
	{
		return 'add_cuisine';
	}
}