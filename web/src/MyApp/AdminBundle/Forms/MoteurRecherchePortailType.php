<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use MyApp\GlobalBundle\Entity\Attraits;
use MyApp\GlobalBundle\Entity\Hebergements;


class MoteurRecherchePortailType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		 ->add('nom_fr', 'text', array("required" => false))
		;
	}

	public function getName()
	{
		return 'moteur_recherche_portail';
	}
}