<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SelectAttraitType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('recherche', 'choice', array('choices' => array('nom' => 'Nom d\'hétablissement', 'ville' => 'Ville', 'tarif' => 'Tarif', 'reservation' => 'Réservation en ligne', 'classification' => 'classification')));
	}

	public function getName()
	{
		return 'add_selectAttrait';
	}
}