<?php
namespace MyApp\AdminBundle\Forms;
use MyApp\GlobalBundle\Entity\Hebergements_activitesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormError;
//use Myapp\GlobalBundle\Forms\DataTransformer\DistanceTransformer;

/**
 * 
 * @author leonardc
 * 
 * Formulaire pour les services et activités de l'hébergement
 */
class CustomerActiviteHebergementType extends AbstractType
{
	
	public function buildForm(FormBuilder $builder, array $options)
	{		
		$builder
				->add('hebergement_activite_id', 'entity', array('class' => 'MyAppGlobalBundle:Hebergements_activites',
														  		'required' => false,
														  		'multiple' => true,
			   													'expanded' => true,
														  		'query_builder' => function(EntityRepository $er){
														 		 return $er->createQueryBuilder('ha')->orderBy('ha.nom_fr','ASC');
														 		 }));
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Hebergements',
		);
	}
	

	public function getName()
	{
		return 'add_activity_customer';
	}
}