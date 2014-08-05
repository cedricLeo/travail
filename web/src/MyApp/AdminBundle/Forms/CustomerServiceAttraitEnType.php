<?php
namespace MyApp\AdminBundle\Forms;
use MyApp\GlobalBundle\Entity\Hebergements_activitesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormError;

/**
 * 
 * @author leonardc
 * 
 * Formulaire pour les services des attraits (version EN)
 */
class CustomerServiceAttraitEnType extends AbstractType
{
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		
		$builder
			->add('attrait_service_id', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_services', 
															'required' => true, 
															'multiple' => true,
															'expanded' => true,
															'query_builder' => function(EntityRepository $er){
															return $er->createQueryBuilder('hs')->orderBy('hs.nom_en','ASC');
													 		 }));
	}
		
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Attraits',
				'virtual'	 => true,
		);
	}
	

	public function getName()
	{
		return 'add_activity_customer';
	}
}