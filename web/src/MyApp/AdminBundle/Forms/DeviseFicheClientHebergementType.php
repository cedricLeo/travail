<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityManager;
use MyApp\GlobalBundle\Entity\HebergementsRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


class DeviseFicheClientHebergementType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('devise_id', 'entity', array('class' => 'MyAppGlobalBundle:Devises', 'property' => 'abreviation','required' => true, "multiple" => true))
		->add('hebergement_paiements_id', 'entity', array('class' => 'MyAppGlobalBundle:Modes_paiements', 'property' => 'nomfr' , 'required' => true, "multiple" => true))
		;
	}

	public function getName()
	{
		return 'add_devise_and_paiement_customer';
	}
}