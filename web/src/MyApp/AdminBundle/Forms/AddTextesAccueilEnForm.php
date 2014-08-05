<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddTextesAccueilEnForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('texte_accueil_en', 'textarea', array("required" => false))
		->add('texte_accueil_hebergement_en', 'textarea', array("required" => false))
		->add('texte_accueil_forfait_en', 'textarea', array("required" => false))
		->add('texte_accueil_corporatif_en', 'textarea', array("required" => false))
		->add('texte_accueil_sante_en', 'textarea', array("required" => false))
		->add('texte_accueil_attrait_en', 'textarea', array("required" => false))
		->add('texte_accueil_promotion_en', 'textarea', array("required" => false))
		->add('texte_accueil_restaurant_en', 'textarea', array("required" => false))
                ->add('texte_complementaire_en', new TexteMetaPrincipaleEnForm(), array("required" => false))
		;
	}
        
        public function getDefaultOptions(array $options)
	{
		return array(
                    'data_class' => 'MyApp\GlobalBundle\Entity\Textes_accueil_en',
		);
	}

	public function getName()
	{
		return 'add_texte_accueil_en';
	}
}