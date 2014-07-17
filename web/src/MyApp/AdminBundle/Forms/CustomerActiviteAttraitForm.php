<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\GlobalBundle\Entity\Attraits_activites;

/**
 * 
 * @author leonardc
 * 
 * Formulaire pour les activités etservices dans l'admin client.
 */
class CustomerActiviteAttraitForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
			->add('attrait_activite_id', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_activites', 'property' => 'nomfr' , 'required' => false, "multiple" => true))
			->add('attrait_service_id', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_services', 'property' => 'nomfr' , 'required' => false, "multiple" => true))
			//->add('type_soins_id', 'entity', array('class' => 'MyAppGlobalBundle:Types_soins_sante', 'property' => 'nomfr' , 'required' => false, "multiple" => true))
			//->add('soins_sante_id', 'entity', array('class' => 'MyAppGlobalBundle:Soins_sante', 'property' => 'nomfr' , 'required' => false, "multiple" => true))
			//->add('cuisine_id', 'entity', array('class' => 'MyAppGlobalBundle:Cuisines', 'property' => 'nomfr' , 'required' => false, "multiple" => true))
		;
	}

	public function getName()
	{
		return 'add_activity_customer';
	}
}