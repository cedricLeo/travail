<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;


class SousCategorieAttraitForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('categorie_id', 'entity', array('class' => 'MyAppGlobalBundle:Attraits_categories', 'property' => 'nom_fr','required' => true))
		->add('nom_fr', 'text')
		->add('nom_en', 'text')
                ->add('page_titre_fr', 'text', array("required" => false))
		->add('page_titre_en', 'text', array("required" => false))
                ->add('page_metadescription_fr', 'textarea', array("required" => false))
		->add('page_metadescription_en', 'textarea', array("required" => false))
                ->add('texte_fr', 'textarea', array("required" => false))
		->add('texte_en', 'textarea', array("required" => false))
		->add('image_doctrine', 'file', array("required" => false));
	}

	public function getName()
	{
		return 'add_sous_categorie';
	}
}