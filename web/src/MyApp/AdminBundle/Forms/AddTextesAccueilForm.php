<?php
namespace MyApp\AdminBundle\Forms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddTextesAccueilForm extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('texte_accueil_fr', 'textarea', array("required" => false))
		->add('texte_accueil_hebergement_fr', 'textarea', array("required" => false))
		->add('texte_accueil_forfait_fr', 'textarea', array("required" => false))
		->add('texte_accueil_corporatif_fr', 'textarea', array("required" => false))
		->add('texte_accueil_sante_fr', 'textarea', array("required" => false))
		->add('texte_accueil_attrait_fr', 'textarea', array("required" => false))
		->add('texte_accueil_promotion_fr', 'textarea', array("required" => false))
		->add('texte_accueil_restaurant_fr', 'textarea', array("required" => false))
                ->add('texte_complementaire', new TexteMetaPrincipaleForm(), array("required" => false))
		;
	}
       
        	
        public function getDefaultOptions(array $options)
	{
		return array(
                    'data_class' => 'MyApp\GlobalBundle\Entity\Textes_accueil',
		);
	}

	public function getName()
	{
		return 'add_texte_accueil';
	}
}