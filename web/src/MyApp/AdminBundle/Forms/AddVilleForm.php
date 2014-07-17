<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\GlobalBundle\Entity\Villes;
use Doctrine\ORM\EntityRepository;

class AddVilleForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
                    ->add('zone_id', 'entity', array('class' => 'MyAppGlobalBundle:Zones', 
                                                                'property' => 'nom_fr',
                                                                'required' => true,
                                                                'query_builder' => function(EntityRepository $er){
                                                                return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
                                                                }))
                    ->add('region_id', 'entity', array('class' => 'MyAppGlobalBundle:Regions', 
                                                       'property' => 'nom_fr',
                                                       'required' => true,
                                                       'query_builder' => function(EntityRepository $er){
                                                        return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
                                                        }))
                    ->add('nom_fr', 'text')
                    ->add('nom_en', 'text')
                    ->add('repertoire_fr', 'text')
                    ->add('repertoire_en', 'text')
                    ->add('page_titre_fr', 'text', array('required' => false))
                    ->add('page_titre_en', 'text', array('required' => false))
                    ->add('texte_fr', 'textarea', array('required' => false))
                    ->add('texte_en', 'textarea', array('required' => false))
                    ->add('latitude', 'text')
                    ->add('longitude', 'text')
                    //->add('nom_reservit', 'text', array('required' => false))
                    ->add('page_metakeyword_fr', 'text', array("required" => false))
                    ->add('page_metakeyword_en', 'text', array("required" => false))
                    ->add('page_metadescription_fr', 'textarea', array("required" => false))
                    ->add('page_metadescription_en', 'textarea', array("required" => false))
                    //->add('texte_accueil_fr', 'textarea', array("required" => false))
                   // ->add('texte_accueil_en', 'textarea', array("required" => false))
                    ->add('reservit_id', 'text', array("required" => true))
                    ->add('code_meteo_media', 'text', array('required' => false))
                    ->add('affiche', 'checkbox', array('required' => false));
	}

	public function getName()
	{
		return 'add_ville';
	}
}
