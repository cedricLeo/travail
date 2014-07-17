<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\GlobalBundle\Entity\Regions;

class AddRegionForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('province_etat_id', 'entity', array('class' => 'MyAppGlobalBundle:Provinces_etats', 'property' => 'nom_fr', 'required' => true))
		->add('nomfr', 'text', array('required' => true))
		->add('nomen', 'text', array('required' => true))
                ->add('repertoire_fr', 'text', array('required' => true))
		->add('repertoire_en', 'text', array('required' => true))
		->add('url_fr', 'textarea', array('required' => false))
		->add('url_en', 'textarea', array('required' => false))
		->add('titre_fr', 'text', array('required' => false))
		->add('titre_en', 'text', array('required' => false))
		->add('texte_fr', 'textarea', array('required' => false))
		->add('texte_en', 'textarea', array('required' => false))
		->add('latitude', 'text', array('required' => true))
		->add('longitude', 'text', array('required' => true))
		->add('image_haut_fr', 'file', array('required' => false))
		->add('image_haut_en', 'file', array('required' => false))
		->add('image_gauche', 'file', array('required' => false))
		->add('image_centre', 'file', array('required' => false))
               // ->add('nom_reservit', 'text', array('required' => false))
		->add('texte_fr_bas_page', 'textarea', array('required' => false))
		->add('texte_en_bas_page', 'textarea', array('required' => false))
		->add('image_travel_doctrine', 'file', array('required' => false))
		->add('resume_fr_travel', 'textarea', array('required' => false))
		->add('resume_en_travel', 'textarea', array('required' => false))
		->add('page_metadescription_fr', 'textarea', array('required' => false))
		->add('page_metadescription_en', 'textarea', array('required' => false))
		->add('page_metakeyword_fr', 'text', array('required' => false))
		->add('page_metakeyword_en', 'text', array('required' => false))
		//->add('texte_accueil_fr', 'textarea', array('required' => false))
		//->add('texte_accueil_en', 'textarea', array('required' => false))
		->add('image_doctrine', 'file', array('required' => false))
		->add('reservit_id', 'text', array('required' => true))
		->add('affiche', 'checkbox', array('required' => false))
		;
	}

	public function getName()
	{
		return 'add_region';
	}
}