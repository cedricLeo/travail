<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use MyApp\GlobalBundle\Entity\Villes;

class SearchVilleForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom_fr', 'text')
		;
	}

	public function getName()
	{
		return 'search_customer_by_town';
	}
}