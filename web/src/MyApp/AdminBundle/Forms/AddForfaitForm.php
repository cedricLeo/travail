<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use MyApp\GlobalBundle\Entity\Forfaits;

class AddForfaitForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom_fr', 'text')
		->add('nom_en', 'text')
                ->add('repertoire_fr', 'text')
		->add('repertoire_en', 'text')
		->add('meta_titre_fr', 'text')
		->add('meta_titre_en', 'text')
		->add('page_metakeyword_fr', 'text')
		->add('page_metakeyword_en', 'text')
		->add('page_metadescription_fr', 'textarea')
		->add('page_metadescription_en', 'textarea')
		->add('texte_fr', 'textarea', array('required' => false))
		->add('texte_en', 'textarea', array('required' => false))
		//->add('default_forfait', 'integer')
		->add('image_doctrine', 'file', array('required' => false))
		//->add('date_debut', 'date', array('required' => false))
		//->add('date_de_fin', 'date', array('required' => false))
		;
	}

	public function getName()
	{
		return 'add_forfait';
	}
}