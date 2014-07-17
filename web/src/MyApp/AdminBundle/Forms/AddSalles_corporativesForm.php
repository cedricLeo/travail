<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddSalles_corporativesForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('salle_corporative_hebergement', 'entity', array('class' => 'MyAppGlobalBundle:Hebergements', 
															   'required' => true, 
				 											   'multiple' => true, 
															   'query_builder' => function(EntityRepository $er){ return $er->createQueryBuilder('h')->orderBy('h.nom_fr', 'ASC');}))
		->add('texte_salle_corporative_fr', 'textarea' ,array("required" => false))
		->add('texte_salle_corporative_en', 'textarea', array("required" => false))
		->add('texte_capacite_salle_corporative_fr', 'text')
		->add('texte_capacite_salle_corporative_en', 'text')
		;
	}

	public function getName()
	{
		return 'add_salle';
	}
}