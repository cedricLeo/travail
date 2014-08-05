<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\GlobalBundle\Entity\Provinces_etats;

class AddProvinceForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('pays_id', 'entity', array('class' => 'MyAppGlobalBundle:Pays', 'property' => 'nom_fr','required' => true))
		->add('nomfr', 'text', array('required' => true))
		->add('nomen', 'text', array('required' => true))
                ->add('repertoire_fr', 'text')
                ->add('repertoire_en', 'text')
                ->add('page_titre_fr', 'text', array('required' => false))
		->add('page_titre_en', 'text', array('required' => false))
		->add('page_metakeyword_fr', 'text', array('required' => false))
		->add('page_metakeyword_en', 'text', array('required' => false))
		->add('page_metadescription_fr', 'textarea', array('required' => false))
		->add('page_metadescription_en', 'textarea', array('required' => false))
		->add('texte_accueil_fr', 'textarea', array('required' => false))
		->add('texte_accueil_en', 'textarea', array('required' => false))
		->add('image_doctrine', 'file', array('required' => false))
		->add('reservitId', 'text')
		->add('affiche', 'checkbox', array('required' => false))
		;
	}

	public function getName()
	{
		return 'add_province';
	}
}