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
 * Formulaire pour les services et activités de l'hébergement
 */
class CustomerServiceHebergementType extends AbstractType
{
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		
		$builder
			->add('hebergement_service_id', 'entity', array('class' => 'MyAppGlobalBundle:Hebergements_services', 
															'required' => true, 
															'multiple' => true,
															'expanded' => true,
															'query_builder' => function(EntityRepository $er){
															return $er->createQueryBuilder('hs')->orderBy('hs.nom_fr','ASC');
													 		 }));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Hebergements',
				'virtual'	 => true,
		);
	}
	

	public function getName()
	{
		return 'add_activity_customer';
	}
}