<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class AddSoinsSanteAttraitType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
			->add('soins_sante_id', 'entity', array('class'    => 'MyAppGlobalBundle:Soins_sante', 
												 	 'required' => true, 
													 'multiple' => true,
													 'expanded' => true,
													 'property' => 'nom_fr',
											     	 'query_builder' => function(EntityRepository $er){
												 	 return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
												    }))
			//->add('duree_id', 'entity', array('class' => 'MyAppGlobalBundle:Duree', 'multiple' => true, 'property' => 'nom_fr', 'required' => true))
		;
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'MyApp\GlobalBundle\Entity\Attraits',
		);
	}

	public function getName()
	{
		return 'add_soins_sante_attrait';
	}
}