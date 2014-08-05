<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddClientEmbeddedForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
			->add('nom', 'text')
			//->add('nom', 'entity', array('class' => 'MyAppGlobalBundle:Clients', 'property' => 'nom','required' => false, "multiple" => true))
		;
	}

	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Utilisateur',
		);
	}

	public function getName()
	{
		return 'add_customer2';
	}
}