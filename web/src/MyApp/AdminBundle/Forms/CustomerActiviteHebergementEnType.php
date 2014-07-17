<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityRepository;

class CustomerActiviteHebergementEnType extends AbstractType
{
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		
		$builder
			/*->add('hebergement_service_id', 'entity', array('class' => 'MyAppGlobalBundle:Hebergements_services', 
															'required' => true, 
															'multiple' => true,
															'expanded'	 => true,
															'query_builder' => function(EntityRepository $er){
															return $er->createQueryBuilder('hs')->orderBy('hs.nom_en','ASC');
													 		 }))*/
		   ->add('hebergement_activite_id', 'entity', array('class' => 'MyAppGlobalBundle:Hebergements_activites',
													  		'required' => false,
													  		'multiple' => true,
		   													'expanded'	 => true,
													  		'query_builder' => function(EntityRepository $er){
													  		return $er->createQueryBuilder('ha')->orderBy('ha.nom_en', 'ASC');
													  		}));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class'      => 'MyApp\AdminBundle\Entity\Form',
				'csrf_protection' => true,
				'csrf_field_name' => '_token',
				// une clé unique pour aider à la génération du jeton secret
				'intention'       => 'activite_item',
		));
	}

	public function getName()
	{
		return 'add_activity_customer';
	}
}