<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use MyApp\GlobalBundle\Entity\Pays;
use MyApp\GlobalBundle\Entity\Provinces_etats;

class UpdateProvinceForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('pays_id', 'entity', array('class' => 'MyAppGlobalBundle:Pays', 'property' => 'nom_fr'))
		->add('nomfr', 'text')
		->add('nomen', 'text')
		->add('titre_fr_travel_attraits', 'text')
		->add('titre_en_travel_attraits', 'text')
		->add('texte_fr_travel_attraits', 'textarea', array('required' => false))
		->add('texte_en_travel_attraits', 'textarea', array('required' => false))
		->add('page_fr', 'text', array('required' => false))
		->add('page_en', 'text', array('required' => false))
		->add('page_metakeyword_fr', 'text')
		->add('page_metakeyword_en', 'text')
		->add('page_metadescription_fr', 'text')
		->add('page_metadescription_en', 'text')
		->add('texte_accueil_fr', 'textarea', array('required' => false))
		->add('texte_accueil_en', 'textarea', array('required' => false))
		->add('image', 'collection', array(
											'type'       => 'file',
											'allow_add'  => TRUE,
											'prototype'  => TRUE,
											'attr'       => array('accept' => 'images/Provinces/*')))
		->add('image_suggestion', 'text', array('required' => false))
		->add('reservitId', 'integer');
	}

	public function getName()
	{
		return 'add_province';
	}
}