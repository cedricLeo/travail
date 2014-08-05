<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddCategorieHebergementForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom_fr', 'text')
		->add('nom_en', 'text')
                ->add('repertoire_fr', 'text')
		->add('repertoire_en', 'text')
		->add('page_titre_fr', 'text')
		->add('page_titre_en', 'text')
		->add('page_metakeyword_fr', 'text')
		->add('page_metakeyword_en', 'text')
		->add('page_metadescription_fr', 'textarea', array('required' => false))
		->add('page_metadescription_en', 'textarea', array('required' => false))
		->add('texte_fr', 'textarea', array('required' => false))
		->add('texte_en', 'textarea', array('required' => false))
		->add('resume_fr', 'textarea', array('required' => false))
		->add('resume_en', 'textarea', array('required' => false))
		->add('image_doctrine', 'file', array('required' => false))
		;
	}

	public function getName()
	{
		return 'add_categorie';
	}
}