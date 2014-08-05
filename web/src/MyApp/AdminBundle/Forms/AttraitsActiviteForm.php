<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\GlobalBundle\Entity\Attraits;

class AttraitsActiviteForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom_fr', 'text')
		->add('nom_en', 'text')
		->add('image', 'file', array("required" => false))
		;
	}

	public function getName()
	{
		return 'add_activite_attrait';
	}
}
