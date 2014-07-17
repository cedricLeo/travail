<?php
namespace MyApp\AdminBundle\Forms;
use MyApp\GlobalBundle\Entity\Soins_client;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class Textes_page_activiteType extends AbstractType
{
	private $lang = "";
	
	public function __construct($lang)
	{
		$this->lang = $lang;
	}
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		if($lang = "fr"){
			$builder
					->add('cuisine_id', 'entity', array('class' => 'MyAppGlobalBundle:Cuisines', 
                                                                                                                    'required' => false,
                                                                                                                    'multiple' => true,
                                                                                                                    'expanded'	=> true,
                                                                                                                    'query_builder' => function(EntityRepository $er){
                                                                                                                    return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
                                                                                                                    }))
					->add('paiement_id', 'entity', array('class' => 'MyAppGlobalBundle:Modes_paiements', 'property' => 'nomfr', "multiple" => true,"required" => true,))
					->add('attrait_activite_id', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_activites', 'property' => 'nomfr', 'multiple' => true, "required" => false, "expanded" => true))
                                        ->add('capacite', 'text', array("required" => true))
					->add('tarif_attrait', 'text', array("required" => true))
					->add('texte_description_fr', 'textarea', array('required' => false))
					->add('texte_description_en', 'textarea', array('required' => false))
					->add('date_debut', 'text', array("required" => false ))
					->add('date_fin', 'text', array("required" => false ))
					//Galerie photo imbriquée
					->add('galerie_attraits', 'collection', array(  'type' 		   => new Galerie_attraitType(),
																	'allow_add'    => true,
																	'allow_delete' => true,
																	'required'	   => false,
															     ))
					//Textes descriptifs et politiques version fr et en
                                        ->add('politique_attrait_fr', new AddPolitiqueAttraitClientFrType(), array("required" => false))
                                        ->add('description_attrait_fr', new AddTextesAttraitFrType(), array("required" => false))
                                        ->add('politique_attrait_en', new AddPolitiqueAttraitClientEnType(), array("required" => false))
                                        ->add('description_attrait_en', new AddTextesAttraitEnType(), array("required" => false))
                                        ->add('image', 'file', array("required" => false))
                                        ->add('photo_payante', 'file', array("required" => false))
                                        ->add('logo', 'file', array("required" => false))
                                        ->add('soins_sante_id', 'entity', array('class' => 'MyAppGlobalBundle:Soins_sante',
												       				'required' => false,
												       				'multiple' => true,
																	'expanded' => true,
												       				'query_builder' => function(EntityRepository $er){
												       					return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
												       				}))
                                        //Formulaire imbriqué pour les horaires.
                                       // ->add('lundi_matin_ete', new HoraireFicheClientForm(), array("required" => false))
                                        ->add('attrait_service_id', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_services', 
															    'required' => true, 
															    'multiple' => true,
															    'expanded' => true,
															    'query_builder' => function(EntityRepository $er){
															         return $er->createQueryBuilder('hs')->orderBy('hs.nom_fr','ASC');
													 		 }));
		}else{
			$builder
					->add('cuisine_id', 'entity', array('class' => 'MyAppGlobalBundle:Cuisines', 
                                                                                                                    'required' => false,
                                                                                                                    'multiple' => true,
                                                                                                                    'expanded'	=> true,
                                                                                                                    'query_builder' => function(EntityRepository $er){
                                                                                                                    return $er->createQueryBuilder('c')->orderBy('c.nom_en', 'ASC');
                                                                                                                    }))
					->add('paiement_id', 'entity', array('class' => 'MyAppGlobalBundle:Modes_paiements', 'property' => 'nomfr','required' => true, "multiple" => true))
                                        ->add('attrait_activite_id', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_activites', 'property' => 'nomen', 'multiple' => true, "required" => false, "expanded" => true))
					->add('capacite', 'text', array("required" => true))
					->add('tarif_attrait', 'text', array("required" => true))
					->add('texte_description_fr', 'textarea', array('required' => false))
					->add('texte_description_en', 'textarea', array('required' => false))
					->add('date_debut', 'date', array("required" => false, 'years' => range(date('Y'), date('Y') + 10)))
					->add('date_fin', 'date', array("required" => false, 'years' => range(date('Y'), date('Y') + 10)))
					//Galerie photo imbriquée
					->add('galerie_attraits', 'collection', array(  'type' 		   => new Galerie_attraitType(),
																	'allow_add'    => true,
																	'allow_delete' => true,
																	'required'	   => false,
					))
					//Textes descriptifs et politiques version fr et en
					->add('politique_attrait_fr', new AddPolitiqueAttraitClientFrType(), array("required" => false))
					->add('description_attrait_fr', new AddTextesAttraitFrType(), array("required" => false))
					->add('politique_attrait_en', new AddPolitiqueAttraitClientEnType(), array("required" => false))
					->add('description_attrait_en', new AddTextesAttraitEnType(), array("required" => false))
					->add('image', 'file', array("required" => false))
					->add('photo_payante', 'file', array("required" => false))
					->add('logo', 'file', array("required" => false))
					->add('soins_sante_id', 'entity', array( 'class' => 'MyAppGlobalBundle:Soins_sante',
																 'required' => false,
																 'multiple' => true,
																 'expanded'	=> true,
																 'query_builder' => function(EntityRepository $er){
																 return $er->createQueryBuilder('c')->orderBy('c.nom_en', 'ASC');
																 }))
					//Formulaire imbriqué pour les horaires.
					->add('lundi_matin_ete', new HoraireFicheClientForm(), array("required" => false))
					->add('attrait_service_id', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_services',
																'required' => true,
																'multiple' => true,
																'expanded' => true,
																'query_builder' => function(EntityRepository $er){
																	 return $er->createQueryBuilder('hs')->orderBy('hs.nom_en','ASC');
																}));
		}
	}
	
	public function getDefaultOptions(array $options) 
	{	
		return array(
					 'data_class' => 'MyApp\GlobalBundle\Entity\Attraits',
					 'virtual' => true,
					);
	}
	
	public function getName()
	{
		return 'add_texte_activite';
	}
}