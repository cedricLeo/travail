<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use MyApp\GlobalBundle\Entity\Zones;
use Doctrine\ORM\EntityRepository;

class AddZoneForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('region_id', 'entity', array('class' => 'MyAppGlobalBundle:Regions', 
                                                   'property' => 'nom_fr', 
                                                   'required' => true,
                                                   'query_builder' => function(EntityRepository $er){
                                                    return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
                                                    }))
		->add('nom_fr', 'text')
		->add('nom_en', 'text')
		->add('titre_fr', 'text')
		->add('titre_en', 'text')
                ->add('repertoire_fr', 'text')
		->add('repertoire_en', 'text')
		->add('texte_fr', 'textarea', array("required" => false))
		->add('texte_en', 'textarea', array("required" => false))
		->add('latitude', 'text')
		->add('longitude', 'text')
		->add('image_haut_fr', 'file', array('required' => false))
		->add('image_haut_en', 'file', array('required' => false))
		->add('image_gauche', 'file', array('required' => false))
		->add('image_centre', 'file', array('required' => false))
		->add('image_suggestion_doctrine', 'file', array('required' => false))
		->add('page_metakeyword_fr', 'text', array('required' => false))
		->add('page_metakeyword_en', 'text', array('required' => false))
		->add('page_metadescription_fr', 'textarea', array('required' => false))
		->add('page_metadescription_en', 'textarea', array('required' => false))
		->add('texte_resume_fr', 'textarea')
		->add('texte_resume_en', 'textarea');
	}

	public function getName()
	{
		return 'add_zone';
	}
}