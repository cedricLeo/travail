<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityManager;
//use MyApp\GlobalBundle\Entity\HebergementsRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TexteMetaPrincipaleEnForm extends AbstractType{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        ->add('texte_accueil_meta_en', 'textarea', array("required" => false))
        ->add('texte_accueil_hebergement_meta_en', 'textarea', array("required" => false))
        ->add('texte_accueil_forfait_meta_en', 'textarea', array("required" => false))
        ->add('texte_accueil_corporatif_meta_en', 'textarea', array("required" => false))
        ->add('texte_accueil_sante_meta_en', 'textarea', array("required" => false))
        ->add('texte_accueil_attrait_meta_en', 'textarea', array("required" => false))
        ->add('texte_accueil_promotion_meta_en', 'textarea', array("required" => false))
        ->add('texte_accueil_restaurant_meta_en', 'textarea', array("required" => false))
        ->add('titre_accueil_en', 'text', array("required" => false))
        ->add('titre_hebergement_en', 'text', array("required" => false))
        ->add('titre_forfait_en', 'text', array("required" => false))
        ->add('titre_corporatif_en', 'text', array("required" => false))
        ->add('titre_attrait_en', 'text', array("required" => false))
        ->add('titre_sante_en', 'text', array("required" => false))
        ->add('titre_promotion_en', 'text', array("required" => false))
        ->add('titre_restaurant_en', 'text', array("required" => false))
        ;
    }
    
    public function getDefaultOptions(array $options)
    {
            return array(
                 'data_class' => 'MyApp\GlobalBundle\Entity\Texte_complementaire_section_principale_en', 
            );
    }

    public function getName()
    {
            return 'add_metaPrincipaleen';
    }
}
