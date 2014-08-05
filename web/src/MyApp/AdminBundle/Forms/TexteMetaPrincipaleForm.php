<?php
namespace MyApp\AdminBundle\Forms;
use Doctrine\ORM\EntityManager;
//use MyApp\GlobalBundle\Entity\HebergementsRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TexteMetaPrincipaleForm extends AbstractType{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        ->add('texte_accueil_meta_fr', 'textarea', array("required" => false))
        ->add('texte_accueil_hebergement_meta_fr', 'textarea', array("required" => false))
        ->add('texte_accueil_forfait_meta_fr', 'textarea', array("required" => false))
        ->add('texte_accueil_corporatif_meta_fr', 'textarea', array("required" => false))
        ->add('texte_accueil_sante_meta_fr', 'textarea', array("required" => false))
        ->add('texte_accueil_attrait_meta_fr', 'textarea', array("required" => false))
        ->add('texte_accueil_promotion_meta_fr', 'textarea', array("required" => false))
        ->add('texte_accueil_restaurant_meta_fr', 'textarea', array("required" => false))
        ->add('titre_accueil_fr', 'text', array("required" => false))
        ->add('titre_hebergement_fr', 'text', array("required" => false))
        ->add('titre_forfait_fr', 'text', array("required" => false))
        ->add('titre_corporatif_fr', 'text', array("required" => false))
        ->add('titre_attrait_fr', 'text', array("required" => false))
        ->add('titre_sante_fr', 'text', array("required" => false))
        ->add('titre_promotion_fr', 'text', array("required" => false))
        ->add('titre_restaurant_fr', 'text', array("required" => false))
        ;
    }
    
    public function getDefaultOptions(array $options)
    {
            return array(
                 'data_class' => 'MyApp\GlobalBundle\Entity\Texte_complementaire_section_principale', 
            );
    }

    public function getName()
    {
            return 'add_metaPrincipale';
    }
}
