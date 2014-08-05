<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use MyApp\GlobalBundle\Entity\Pays;

class CategorieAttraitForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('nom_fr', 'text')
		->add('nom_en', 'text')
                ->add('repertoire_fr', 'text')
		->add('repertoire_en', 'text')
		->add('page_titre_fr', 'text')
		->add('page_titre_en', 'text')
		->add('page_metakeyword_fr', 'text', array("required" => false))
		->add('page_metakeyword_en', 'text', array("required" => false))
		->add('page_metadescription_fr', 'textarea', array("required" => false))
		->add('page_metadescription_en', 'textarea', array("required" => false))
		->add('texte_fr', 'textarea', array("required" => false))
		->add('texte_en', 'textarea', array("required" => false))
		->add('image_doctrine', 'file', array("required" => false))
		//->add('type_festival_evenement', 'checkbox', array("required" => false))
		//->add('type_restaurant', 'checkbox', array("required" => false))
		//->add('type_camping', 'checkbox', array("required" => false))
		//->add('type_centre_sante_spa', 'checkbox', array("required" => false))
		;
	}

	public function getName()
	{
		return 'add_category_attrait';
	}
}