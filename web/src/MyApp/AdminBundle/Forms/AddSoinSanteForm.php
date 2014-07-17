<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;


class AddSoinSanteForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		//->add('sous_categorie_attrait_id', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_sous_categories', 'property' => 'nom_fr', 'required' => true))
		//->add('types_soins_sante_id', 'entity', array('class' => 'MyAppGlobalBundle:Types_soins_sante', 'property' => 'nom_fr', 'required' => true))
		->add('types_soins_sante_id', 'entity', array('class' => 'MyAppGlobalBundle:Types_soins_sante',
													   'required' => true,
													   'query_builder' => function(EntityRepository $er){
													   return $er->createQueryBuilder('c')->orderBy('c.nom_fr', 'ASC');
									                   }))
		->add('nom_fr', 'text', array('required' => true))
		->add('nom_en', 'text', array('required' => true))
		->add('texte_fr', 'textarea', array('required' => false))
		->add('texte_en', 'textarea', array('required' => false))
		->add('resume_fr', 'textarea', array('required' => false))
		->add('resume_en', 'textarea', array('required' => false))
		->add('image_doctrine', 'file', array('required' => false))
		->add('page_metadescription_fr', 'textarea', array('required' => true))
		->add('page_metadescription_en', 'textarea', array('required' => true))
		->add('page_metakeyword_fr', 'text', array('required' => false))
		->add('page_metakeyword_en', 'text', array('required' => false))
		;
	}

	public function getName()
	{
		return 'add_soin';
	}
}